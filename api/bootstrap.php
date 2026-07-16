<?php
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('X-Frame-Options: DENY');

$config = require __DIR__ . '/config.php';
$allowedOrigins = $config['allowed_origins'] ?? [];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
if ($origin !== '' && in_array($origin, $allowedOrigins, true)) {
    header('Access-Control-Allow-Origin: ' . $origin);
    header('Vary: Origin');
}

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-API-Key');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

/**
 * Sanitize and escape a scalar value for use in a MySQL query.
 */
function escapeField($dbc, $value): string
{
    return mysqli_real_escape_string($dbc, trim((string) $value));
}

/**
 * Insert an associative array into the given table.
 * Values are escaped but NOT lowercased (unlike the legacy insert_data helper).
 *
 * @param mysqli $dbc
 * @param string $table
 * @param array  $data  column => value pairs
 * @return bool
 */
function apiInsert($dbc, string $table, array $data): bool
{
    $columns = [];
    $values  = [];
    foreach ($data as $col => $val) {
        $columns[] = '`' . mysqli_real_escape_string($dbc, $col) . '`';
        $values[]  = "'" . mysqli_real_escape_string($dbc, (string) $val) . "'";
    }
    $sql = sprintf(
        'INSERT INTO `%s` (%s) VALUES (%s)',
        mysqli_real_escape_string($dbc, $table),
        implode(', ', $columns),
        implode(', ', $values)
    );
    return (bool) mysqli_query($dbc, $sql);
}

require_once __DIR__ . '/../admin/php_action/db_connect.php';

function respondJson(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function requireApiToken(): void
{
    $config = require __DIR__ . '/config.php';
    $expectedToken = (string) ($config['api_token'] ?? '');

    $providedToken = '';
    $headers = [];
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
    }

    $authorizationHeader = '';
    if (isset($headers['Authorization'])) {
        $authorizationHeader = (string) $headers['Authorization'];
    } elseif (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
        $authorizationHeader = (string) $_SERVER['HTTP_AUTHORIZATION'];
    } elseif (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        $authorizationHeader = (string) $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
    } elseif (!empty($_SERVER['Authorization'])) {
        $authorizationHeader = (string) $_SERVER['Authorization'];
    }

    if ($authorizationHeader !== '' && preg_match('/^Bearer\s+(.+)$/i', trim($authorizationHeader), $matches)) {
        $providedToken = trim($matches[1]);
    }

    if ($providedToken === '' && !empty($headers['X-API-Key'])) {
        $providedToken = trim((string) $headers['X-API-Key']);
    } elseif ($providedToken === '' && !empty($_SERVER['HTTP_X_API_KEY'])) {
        $providedToken = trim((string) $_SERVER['HTTP_X_API_KEY']);
    }

    if ($providedToken === '' && isset($_GET['token'])) {
        $providedToken = trim((string) $_GET['token']);
    }

    if (!is_string($providedToken) || !hash_equals(trim((string) $expectedToken), $providedToken)) {
        respondJson(401, [
            'status' => 'error',
            'message' => 'Unauthorized.'
        ]);
    }
}

function requireApiKey(): void
{
    requireApiToken();
}

function normalizeImageUrl($imageName): ?string
{
    if (empty($imageName)) {
        return null;
    }

    $imageName = trim((string) $imageName);
    if ($imageName === '') {
        return null;
    }

    if (preg_match('/^https?:\/\//i', $imageName)) {
        return $imageName;
    }

    $relativePath = ltrim($imageName, '/');
    $candidates = [
        '/admin/img/vehicles_images/' . $relativePath,
        '/img/vehicles_images/' . $relativePath,
    ];

    foreach ($candidates as $publicPath) {
        $absolutePath = dirname(__DIR__) . $publicPath;
        if (file_exists($absolutePath)) {
            return $publicPath;
        }
    }

    return null;
}

function isActiveOnlyRequested(): bool
{
    return isset($_GET['active']) && $_GET['active'] === '1';
}
