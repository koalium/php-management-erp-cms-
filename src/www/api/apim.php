<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../database/dbc.php';
require_once __DIR__ . '/api.php';

function send_not_found(): void
{
    http_response_code(404);
    header('Location: /404.html');
    exit;
}

function send_json(array $payload): void
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function read_request_payload(): array
{
    $payload = [];
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $decoded = json_decode($raw ?? '', true);
        if (is_array($decoded)) {
            $payload = $decoded;
        }
    } elseif (!empty($_POST)) {
        $payload = $_POST;
    } elseif (!empty($_GET)) {
        $payload = $_GET;
    }

    $action = $payload['action'] ?? '';
    if (!is_string($action) || $action === '') {
        return ['action' => ''];
    }

    return $payload;
}

function is_authenticated(): bool
{
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        return false;
    }

    $expiresAt = $_SESSION['expires_at'] ?? 0;
    if (!is_int($expiresAt) || $expiresAt < time()) {
        return false;
    }

    $sessionKey = $_SESSION['session_key'] ?? '';
    $userId = $_SESSION['user_id'] ?? 0;
    if (!is_string($sessionKey) || $sessionKey === '' || !is_int($userId) || $userId <= 0) {
        return false;
    }

    return Database::isSessionValid($sessionKey, $userId);
}

$payload = read_request_payload();
$action = $payload['action'] ?? '';

$publicActions = [
    'ping',
    'auth.login',
    'auth.status',
];

if (!in_array($action, $publicActions, true) && !is_authenticated()) {
    send_not_found();
}

$response = handle_api_request($payload, [
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
]);

send_json($response);
