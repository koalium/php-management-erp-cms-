<?php
declare(strict_types=1);

final class Database
{
    private const DB_HOST = '127.0.0.1';
    private const DB_NAME = 'esmartis_erp';
    private const DB_USER = 'esmartis_user';
    private const DB_PASS = 'esmartis1364';
    private const DB_CHARSET = 'utf8mb4';

    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', self::DB_HOST, self::DB_NAME, self::DB_CHARSET);
        self::$connection = new PDO($dsn, self::DB_USER, self::DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$connection;
    }

    public static function migrate(): void
    {
        $pdo = self::connection();
        foreach (self::migrationQueries() as $sql) {
            $pdo->exec($sql);
        }
    }

    public static function seedDefaults(): void
    {
        $pdo = self::connection();
        foreach (self::seedQueries() as $sql) {
            $pdo->exec($sql);
        }
    }

    public static function findUserByUsername(string $username): ?array
    {
        $sql = 'SELECT id, username, password_hash, role, active FROM users WHERE username = :username LIMIT 1';
        $stmt = self::connection()->prepare($sql);
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    public static function createSession(int $userId, string $userAgent, string $ipAddress, int $expiresAt): string
    {
        $sessionKey = bin2hex(random_bytes(32));
        $sql = 'INSERT INTO sessions (user_id, session_key, user_agent, ip_address, expires_at) VALUES (:user_id, :session_key, :user_agent, :ip_address, :expires_at)';
        $stmt = self::connection()->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':session_key' => $sessionKey,
            ':user_agent' => mb_substr($userAgent, 0, 255, 'UTF-8'),
            ':ip_address' => mb_substr($ipAddress, 0, 45, 'UTF-8'),
            ':expires_at' => date('Y-m-d H:i:s', $expiresAt),
        ]);

        return $sessionKey;
    }

    public static function revokeSession(string $sessionKey): void
    {
        $sql = 'DELETE FROM sessions WHERE session_key = :session_key';
        $stmt = self::connection()->prepare($sql);
        $stmt->execute([':session_key' => $sessionKey]);
    }

    public static function isSessionValid(string $sessionKey, int $userId): bool
    {
        $sql = 'SELECT id FROM sessions WHERE session_key = :session_key AND user_id = :user_id AND expires_at > NOW() LIMIT 1';
        $stmt = self::connection()->prepare($sql);
        $stmt->execute([
            ':session_key' => $sessionKey,
            ':user_id' => $userId,
        ]);

        return $stmt->fetch() !== false;
    }

    private static function migrationQueries(): array
    {
        return [
            'CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(120) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL DEFAULT "user",
                active TINYINT(1) NOT NULL DEFAULT 1,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
            'CREATE TABLE IF NOT EXISTS sessions (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED NOT NULL,
                session_key VARCHAR(128) NOT NULL UNIQUE,
                user_agent VARCHAR(255) NOT NULL,
                ip_address VARCHAR(45) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                expires_at DATETIME NOT NULL,
                INDEX idx_sessions_user (user_id),
                CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
        ];
    }

    private static function seedQueries(): array
    {
        $defaultUsers = [
            ['admin', '654321', 'admin'],
            ['ceo', '654321', 'ceo'],
            ['cto', '654321', 'cto'],
            ['reza', '123456', 'user'],
        ];

        $queries = [];
        foreach ($defaultUsers as $user) {
            $hash = password_hash($user[1], PASSWORD_DEFAULT);
            $queries[] = sprintf(
                'INSERT IGNORE INTO users (username, password_hash, role, active) VALUES (%s, %s, %s, 1)',
                self::quote($user[0]),
                self::quote($hash),
                self::quote($user[2])
            );
        }

        return $queries;
    }

    private static function quote(string $value): string
    {
        return self::connection()->quote($value);
    }
}
