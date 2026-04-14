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

$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE nome = ? OR email = ?");
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['senha'])) {
        $_SESSION['usuario_id']   = $row['id'];
        $_SESSION['usuario_nome'] = $row['nome'];
        echo json_encode(['status' => 'success', 'nome' => $row['nome']]);
    } else {
        echo json_encode(['status' => 'invalid']);
    }
} else {
    echo json_encode(['status' => 'invalid']);
}

$stmt->close();
$conn->close();
?>
