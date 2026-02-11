<?php
declare(strict_types=1);

require_once __DIR__ . '/../database/dbc.php';

function normalize_string(mixed $value, int $maxLength = 250): string
{
    $text = is_string($value) ? trim($value) : '';
    if ($text === '') {
        return '';
    }

    return mb_substr($text, 0, $maxLength, 'UTF-8');
}

function gregorian_to_jalali(int $gy, int $gm, int $gd): array
{
    $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
    $days = 355666 + (365 * $gy) + intdiv(($gy2 + 3), 4) - intdiv(($gy2 + 99), 100) + intdiv(($gy2 + 399), 400) + $gd + $g_d_m[$gm - 1];
    $jy = -1595 + (33 * intdiv($days, 12053));
    $days %= 12053;
    $jy += 4 * intdiv($days, 1461);
    $days %= 1461;
    if ($days > 365) {
        $jy += intdiv(($days - 1), 365);
        $days = ($days - 1) % 365;
    }
    $jm = ($days < 186) ? (1 + intdiv($days, 31)) : (7 + intdiv(($days - 186), 30));
    $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));

    return [$jy, $jm, $jd];
}

function build_jalali_date(): string
{
    $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Tehran'));
    [$jy, $jm, $jd] = gregorian_to_jalali(
        (int) $now->format('Y'),
        (int) $now->format('n'),
        (int) $now->format('j')
    );

    return sprintf('%04d/%02d/%02d', $jy, $jm, $jd);
}

function validate_username(mixed $value): string
{
    $username = normalize_string($value, 120);
    if ($username === '' || !preg_match('/^[a-zA-Z0-9._-]{2,120}$/', $username)) {
        return '';
    }

    return $username;
}

function validate_password(mixed $value): string
{
    $password = normalize_string($value, 128);
    if ($password === '' || mb_strlen($password, 'UTF-8') < 4) {
        return '';
    }

    return $password;
}

function enforce_login_rate_limit(): ?array
{
    $now = time();
    $lastAttempt = $_SESSION['login_last_attempt'] ?? 0;
    if (is_int($lastAttempt) && $lastAttempt > 0 && ($now - $lastAttempt) < 3) {
        return [
            'ok' => false,
            'message' => 'لطفاً چند ثانیه بعد دوباره تلاش کنید.',
        ];
    }

    $_SESSION['login_last_attempt'] = $now;
    return null;
}

function handle_api_request(array $payload, array $context = []): array
{
    $action = normalize_string($payload['action'] ?? '', 80);

    if ($action === '') {
        return [
            'ok' => false,
            'message' => 'درخواست نامعتبر است.',
        ];
    }

    switch ($action) {
        case 'ping':
            return [
                'ok' => true,
                'message' => 'ارتباط برقرار است.',
                'data' => [
                    'jalali_date' => build_jalali_date(),
                    'server_time' => (new DateTimeImmutable('now', new DateTimeZone('Asia/Tehran')))->format('H:i:s'),
                    'client_ip' => $context['ip'] ?? '',
                ],
            ];
        case 'auth.status':
            $isAuth = isset($_SESSION['auth']) && $_SESSION['auth'] === true;
            return [
                'ok' => true,
                'message' => $isAuth ? 'کاربر وارد شده است.' : 'کاربر وارد نشده است.',
                'data' => [
                    'authenticated' => $isAuth,
                    'expires_at' => $_SESSION['expires_at'] ?? null,
                ],
            ];
        case 'auth.login':
            $limitResponse = enforce_login_rate_limit();
            if ($limitResponse !== null) {
                return $limitResponse;
            }

            $username = validate_username($payload['username'] ?? '');
            $password = validate_password($payload['password'] ?? '');

            if ($username === '' || $password === '') {
                return [
                    'ok' => false,
                    'message' => 'نام کاربری یا رمز عبور نامعتبر است.',
                ];
            }

            $user = Database::findUserByUsername($username);
            if ($user === null || (int) $user['active'] !== 1) {
                return [
                    'ok' => false,
                    'message' => 'کاربر یافت نشد یا غیرفعال است.',
                ];
            }

            if (!password_verify($password, $user['password_hash'])) {
                return [
                    'ok' => false,
                    'message' => 'نام کاربری یا رمز عبور اشتباه است.',
                ];
            }

            $expiresAt = time() + 3600;
            $sessionKey = Database::createSession(
                (int) $user['id'],
                $context['user_agent'] ?? '',
                $context['ip'] ?? '',
                $expiresAt
            );

            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['session_key'] = $sessionKey;
            $_SESSION['expires_at'] = $expiresAt;

            return [
                'ok' => true,
                'message' => 'ورود با موفقیت انجام شد.',
                'data' => [
                    'user_id' => (int) $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'expires_at' => $expiresAt,
                ],
            ];
        case 'auth.logout':
            $sessionKey = $_SESSION['session_key'] ?? '';
            if (is_string($sessionKey) && $sessionKey !== '') {
                Database::revokeSession($sessionKey);
            }

            $_SESSION = [];
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }

            return [
                'ok' => true,
                'message' => 'خروج با موفقیت انجام شد.',
            ];
        default:
            return [
                'ok' => false,
                'message' => 'عملیات درخواستی پشتیبانی نمی‌شود.',
            ];
    }
}
