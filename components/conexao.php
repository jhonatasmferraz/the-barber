<?php
$dbUrl = getenv('DATABASE_URL') ?: 'postgres://root:@localhost:5432/barbearia';
$url   = parse_url($dbUrl);
$dsn   = sprintf(
    'pgsql:host=%s;port=%d;dbname=%s;sslmode=%s',
    $url['host'],
    $url['port'] ?? 5432,
    ltrim($url['path'], '/'),
    getenv('DATABASE_URL') ? 'require' : 'prefer'
);
try {
    $pdo = new PDO($dsn, $url['user'] ?? '', $url['pass'] ?? '', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'msg' => 'Erro de conexão com o banco']);
    exit;
}
