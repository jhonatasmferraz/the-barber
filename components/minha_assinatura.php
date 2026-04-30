<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['plano' => null]);
    exit;
}

include 'conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT plano FROM assinaturas WHERE usuario_id = ? AND ativo = 1 ORDER BY id DESC LIMIT 1");
$stmt->execute([$usuario_id]);
$row = $stmt->fetch();

echo json_encode(['plano' => $row ? $row['plano'] : null]);
