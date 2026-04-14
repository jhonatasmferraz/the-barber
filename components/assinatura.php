<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Você precisa estar logado para assinar um plano.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'msg' => 'Método não permitido']);
    exit();
}

include 'conexao.php';

$plano        = trim($_POST['plano'] ?? '');
$planosValidos = ['essencial', 'premium', 'deluxe'];

if (!in_array($plano, $planosValidos)) {
    echo json_encode(['status' => 'error', 'msg' => 'Plano inválido.']);
    exit();
}

$usuario_id  = $_SESSION['usuario_id'];
$data_inicio = date('Y-m-d H:i:s');
$data_fim    = date('Y-m-d H:i:s', strtotime('+1 month'));

// Desativa assinaturas anteriores do usuário
$stmt = $conn->prepare("UPDATE assinaturas SET ativo = 0 WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->close();

// Insere nova assinatura
$stmt = $conn->prepare("INSERT INTO assinaturas (usuario_id, plano, data_inicio, data_fim) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $usuario_id, $plano, $data_inicio, $data_fim);

if ($stmt->execute()) {
    $nomePlano = ucfirst($plano);
    echo json_encode(['status' => 'success', 'msg' => "Plano {$nomePlano} ativado com sucesso!", 'plano' => $plano]);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Erro ao realizar assinatura. Tente novamente.']);
}

$stmt->close();
$conn->close();
?>
