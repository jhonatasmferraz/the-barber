<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['plano' => null]);
    exit;
}

include 'conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT plano FROM assinaturas WHERE usuario_id = ? AND ativo = 1 ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['plano' => $row['plano']]);
} else {
    echo json_encode(['plano' => null]);
}

$stmt->close();
$conn->close();
?>
