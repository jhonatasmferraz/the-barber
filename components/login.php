<?php
session_start();
header('Content-Type: application/json');

include 'conexao.php';

if (!isset($_POST['user'], $_POST['pass'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Dados inválidos']);
    exit();
}

$user     = trim($_POST['user']);
$password = trim($_POST['pass']);

$stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE nome = ? OR email = ?");
$stmt->execute([$user, $user]);
$row = $stmt->fetch();

if ($row && password_verify($password, $row['senha'])) {
    $_SESSION['usuario_id']   = $row['id'];
    $_SESSION['usuario_nome'] = $row['nome'];
    echo json_encode(['status' => 'success', 'nome' => $row['nome']]);
} else {
    echo json_encode(['status' => 'invalid']);
}
