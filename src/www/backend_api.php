<?php

declare(strict_types=1);

require_once __DIR__ . '/dbc.php';

final class JsonResponse
{
    public static function send(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

final class Request
{
    public string $method;
    public string $path;
    public array $query;
    public array $body;
    public array $headers;

    public static function capture(): self
    {
        $self = new self();
        $self->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $self->path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
        $self->query = $_GET;
        $self->headers = function_exists('getallheaders') ? array_change_key_case(getallheaders(), CASE_LOWER) : [];

        $raw = file_get_contents('php://input');
        $json = is_string($raw) && $raw !== '' ? json_decode($raw, true) : null;
        $self->body = is_array($json) ? $json : $_POST;

        return $self;
    }
}

final class AuthService
{
    public function __construct(private PDO $db)
    {
    }

    public function register(array $input): array
    {
        foreach (['email', 'password', 'full_name'] as $field) {
            if (empty($input[$field])) {
                throw new RuntimeException("Missing field: {$field}");
            }
        }

        $sql = 'INSERT INTO users(email, password_hash, full_name) VALUES(:email, :hash, :full_name)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => strtolower(trim((string) $input['email'])),
            ':hash' => password_hash((string) $input['password'], PASSWORD_BCRYPT),
            ':full_name' => trim((string) $input['full_name']),
        ]);

        $userId = (int) $this->db->lastInsertId();
        $roleId = (int) $this->db->query("SELECT id FROM roles WHERE code='assistant_accountant' LIMIT 1")->fetchColumn();
        if ($roleId > 0) {
            $this->db->prepare('INSERT IGNORE INTO user_roles(user_id, role_id) VALUES(:u,:r)')->execute([':u' => $userId, ':r' => $roleId]);
        }

        return ['user_id' => $userId, 'email' => $input['email']];
    }

    public function issueToken(array $input): array
    {
        foreach (['client_id', 'client_secret', 'email', 'password'] as $field) {
            if (empty($input[$field])) {
                throw new RuntimeException("Missing field: {$field}");
            }
        }

        $clientStmt = $this->db->prepare('SELECT * FROM oauth_clients WHERE client_id=:cid AND is_active=1 LIMIT 1');
        $clientStmt->execute([':cid' => $input['client_id']]);
        $client = $clientStmt->fetch();
        if (!$client || !hash_equals($client['client_secret'], hash('sha256', (string) $input['client_secret']))) {
            throw new RuntimeException('Invalid OAuth client credentials');
        }

        $userStmt = $this->db->prepare('SELECT * FROM users WHERE email=:email AND is_active=1 LIMIT 1');
        $userStmt->execute([':email' => strtolower(trim((string) $input['email']))]);
        $user = $userStmt->fetch();

        if (!$user || !password_verify((string) $input['password'], $user['password_hash'])) {
            throw new RuntimeException('Invalid user credentials');
        }

        $token = bin2hex(random_bytes(32));
        $refresh = bin2hex(random_bytes(32));
        $expiresAt = (new DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s');
        $refreshExpiresAt = (new DateTimeImmutable('+30 days'))->format('Y-m-d H:i:s');

        $this->db->beginTransaction();
        try {
            $tokenStmt = $this->db->prepare('INSERT INTO oauth_tokens(token_hash, user_id, client_id, scope, expires_at) VALUES(:token, :uid, :cid, :scope, :exp)');
            $tokenStmt->execute([
                ':token' => hash('sha256', $token),
                ':uid' => $user['id'],
                ':cid' => $client['id'],
                ':scope' => $input['scope'] ?? 'basic',
                ':exp' => $expiresAt,
            ]);
            $tokenId = (int) $this->db->lastInsertId();

            $refreshStmt = $this->db->prepare('INSERT INTO refresh_tokens(refresh_hash, token_id, expires_at) VALUES(:hash, :tid, :exp)');
            $refreshStmt->execute([
                ':hash' => hash('sha256', $refresh),
                ':tid' => $tokenId,
                ':exp' => $refreshExpiresAt,
            ]);

            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'refresh_token' => $refresh,
            'user' => [
                'id' => (int) $user['id'],
                'email' => $user['email'],
                'name' => $user['full_name'],
            ],
        ];
    }

    public function requireUser(Request $request): array
    {
        $authorization = $request->headers['authorization'] ?? '';
        if (!str_starts_with($authorization, 'Bearer ')) {
            throw new RuntimeException('Missing bearer token');
        }

        $token = trim(substr($authorization, 7));
        $sql = 'SELECT u.* FROM oauth_tokens t JOIN users u ON u.id=t.user_id WHERE t.token_hash=:hash AND t.expires_at > NOW() LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':hash' => hash('sha256', $token)]);
        $user = $stmt->fetch();

        if (!$user) {
            throw new RuntimeException('Invalid or expired token');
        }

        return $user;
    }
}

final class ERPService
{
    public function __construct(private PDO $db)
    {
    }

    public function createCompany(array $user, array $input): array
    {
        foreach (['company_code', 'company_name', 'country_code', 'base_currency'] as $field) {
            if (empty($input[$field])) {
                throw new RuntimeException("Missing field: {$field}");
            }
        }

        $stmt = $this->db->prepare('INSERT INTO companies(company_code, company_name, country_code, base_currency, tax_rule, created_by) VALUES(:code,:name,:country,:currency,:tax,:uid)');
        $stmt->execute([
            ':code' => strtoupper(trim((string) $input['company_code'])),
            ':name' => trim((string) $input['company_name']),
            ':country' => strtoupper(trim((string) $input['country_code'])),
            ':currency' => strtoupper(trim((string) $input['base_currency'])),
            ':tax' => json_encode($input['tax_rule'] ?? ['vat' => 0]),
            ':uid' => $user['id'],
        ]);

        $companyId = (int) $this->db->lastInsertId();
        $this->db->prepare('INSERT IGNORE INTO company_users(company_id, user_id, role_code) VALUES(:cid,:uid,:role)')->execute([
            ':cid' => $companyId,
            ':uid' => $user['id'],
            ':role' => 'financial_manager',
        ]);

        return ['company_id' => $companyId];
    }

    public function addBudget(array $user, array $input): array
    {
        foreach (['company_id', 'fiscal_year', 'category', 'amount', 'currency'] as $field) {
            if (!isset($input[$field]) || $input[$field] === '') {
                throw new RuntimeException("Missing field: {$field}");
            }
        }

        $stmt = $this->db->prepare('INSERT INTO budgets(company_id, fiscal_year, category, amount, currency, created_by) VALUES(:company_id,:year,:category,:amount,:currency,:created_by)');
        $stmt->execute([
            ':company_id' => (int) $input['company_id'],
            ':year' => (int) $input['fiscal_year'],
            ':category' => trim((string) $input['category']),
            ':amount' => (float) $input['amount'],
            ':currency' => strtoupper(trim((string) $input['currency'])),
            ':created_by' => (int) $user['id'],
        ]);

        return ['budget_id' => (int) $this->db->lastInsertId()];
    }

    public function addTransaction(array $user, array $input): array
    {
        foreach (['company_id', 'account_id', 'txn_type', 'amount', 'currency', 'reference_no', 'txn_date'] as $field) {
            if (!isset($input[$field]) || $input[$field] === '') {
                throw new RuntimeException("Missing field: {$field}");
            }
        }

        $stmt = $this->db->prepare(
            'INSERT INTO transactions(company_id, account_id, txn_type, amount, currency, reference_no, description, txn_date, created_by)
             VALUES(:company_id,:account_id,:txn_type,:amount,:currency,:reference_no,:description,:txn_date,:created_by)'
        );
        $stmt->execute([
            ':company_id' => (int) $input['company_id'],
            ':account_id' => (int) $input['account_id'],
            ':txn_type' => $input['txn_type'] === 'credit' ? 'credit' : 'debit',
            ':amount' => (float) $input['amount'],
            ':currency' => strtoupper(trim((string) $input['currency'])),
            ':reference_no' => trim((string) $input['reference_no']),
            ':description' => isset($input['description']) ? trim((string) $input['description']) : null,
            ':txn_date' => trim((string) $input['txn_date']),
            ':created_by' => (int) $user['id'],
        ]);

        return ['transaction_id' => (int) $this->db->lastInsertId()];
    }

    public function companyDashboard(int $companyId): array
    {
        $summary = $this->db->prepare(
            'SELECT
                COALESCE(SUM(CASE WHEN txn_type="debit" THEN amount END),0) AS total_debit,
                COALESCE(SUM(CASE WHEN txn_type="credit" THEN amount END),0) AS total_credit,
                COUNT(*) AS transactions_count
             FROM transactions WHERE company_id=:cid'
        );
        $summary->execute([':cid' => $companyId]);

        $budgets = $this->db->prepare('SELECT fiscal_year, category, amount, currency FROM budgets WHERE company_id=:cid ORDER BY fiscal_year DESC, category ASC');
        $budgets->execute([':cid' => $companyId]);

        return [
            'summary' => $summary->fetch() ?: [],
            'budgets' => $budgets->fetchAll(),
        ];
    }
}

final class ApiKernel
{
    public static function handle(): void
    {
        $request = Request::capture();
        $db = dbc();

        $auth = new AuthService($db);
        $erp = new ERPService($db);

        try {
            $action = $request->query['action'] ?? $request->body['action'] ?? '';
            switch ($action) {
                case 'health':
                    JsonResponse::send(['status' => 'ok', 'service' => 'php-erp-api']);
                    return;

                case 'register':
                    JsonResponse::send(['success' => true, 'data' => $auth->register($request->body)]);
                    return;

                case 'oauth/token':
                    JsonResponse::send(['success' => true, 'data' => $auth->issueToken($request->body)]);
                    return;

                case 'company/create':
                    $user = $auth->requireUser($request);
                    JsonResponse::send(['success' => true, 'data' => $erp->createCompany($user, $request->body)]);
                    return;

                case 'budget/create':
                    $user = $auth->requireUser($request);
                    JsonResponse::send(['success' => true, 'data' => $erp->addBudget($user, $request->body)]);
                    return;

                case 'transaction/create':
                    $user = $auth->requireUser($request);
                    JsonResponse::send(['success' => true, 'data' => $erp->addTransaction($user, $request->body)]);
                    return;

                case 'company/dashboard':
                    $auth->requireUser($request);
                    $companyId = (int) ($request->query['company_id'] ?? $request->body['company_id'] ?? 0);
                    if ($companyId <= 0) {
                        throw new RuntimeException('company_id is required');
                    }
                    JsonResponse::send(['success' => true, 'data' => $erp->companyDashboard($companyId)]);
                    return;

                default:
                    JsonResponse::send([
                        'success' => false,
                        'error' => 'Unknown action',
                        'supported_actions' => [
                            'health',
                            'register',
                            'oauth/token',
                            'company/create',
                            'budget/create',
                            'transaction/create',
                            'company/dashboard',
                        ],
                    ], 404);
            }
        } catch (Throwable $e) {
            JsonResponse::send(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
