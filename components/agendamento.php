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

$stmt = $pdo->prepare("SELECT COUNT(*) FROM agendamentos WHERE data = ? AND hora = ?");
$stmt->execute([$data, $hora]);
if ($stmt->fetchColumn() > 0) {
    echo "Este horário já foi reservado. Escolha outro.";
    exit();
}

$stmt = $pdo->prepare("INSERT INTO agendamentos (usuario_id, nome, data, hora) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$usuario_id, $nome, $data, $hora])) {
    $dataFmt = date('d/m/Y', strtotime($data));
    echo "Agendamento confirmado! {$nome}, até {$dataFmt} às {$hora}.";
} else {
    echo "Erro ao agendar.";
}
