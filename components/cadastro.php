<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'msg' => 'Método não permitido']);
    exit();
}

include 'conexao.php';

$nome  = trim($_POST['nome']  ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($nome) || empty($email) || empty($senha)) {
    echo json_encode(['status' => 'error', 'msg' => 'Preencha todos os campos!']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'msg' => 'E-mail inválido.']);
    exit();
}

if (strlen($senha) < 6) {
    echo json_encode(['status' => 'error', 'msg' => 'A senha deve ter pelo menos 6 caracteres.']);
    exit();
}

// Verificando se o e-mail já está cadastrado
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'msg' => 'E-mail já cadastrado. Tente outro.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Criptografando a senha e inserindo
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senhaHash);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'msg' => 'Cadastro realizado com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Erro ao cadastrar. Tente novamente.']);
}

$stmt->close();
$conn->close();
?>
