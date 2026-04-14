<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método não permitido";
    exit();
}

$usuario_id = $_SESSION['usuario_id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$data = trim($_POST['data'] ?? '');
$hora = trim($_POST['hora'] ?? '');

if (empty($nome) || empty($data) || empty($hora)) {
    echo "Preencha todos os campos!";
    exit();
}

// Verificar se o horário já está ocupado
$stmt = $conn->prepare("SELECT id FROM agendamentos WHERE data = ? AND hora = ?");
$stmt->bind_param("ss", $data, $hora);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Este horário já foi reservado. Escolha outro.";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Inserir agendamento
$stmt = $conn->prepare("INSERT INTO agendamentos (usuario_id, nome, data, hora) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $usuario_id, $nome, $data, $hora);

if ($stmt->execute()) {
    $dataFmt = date('d/m/Y', strtotime($data));
    echo "Agendamento confirmado! {$nome}, até {$dataFmt} às {$hora}.";
} else {
    echo "Erro ao agendar: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
