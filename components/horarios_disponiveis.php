<?php
header('Content-Type: application/json');
include 'conexao.php';

$data = $_GET['data'] ?? '';
if (!$data || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
    echo json_encode(['error' => 'Data inválida']);
    exit;
}

// Domingo = fechado
$dow = (int) date('w', strtotime($data));
if ($dow === 0) {
    echo json_encode(['horarios' => [], 'fechado' => true]);
    exit;
}

// Sábado até 17h, demais dias até 19h
$horaFim = ($dow === 6) ? 17 : 19;
$todos = [];
for ($h = 9; $h < $horaFim; $h++) {
    $todos[] = sprintf('%02d:00', $h);
    $todos[] = sprintf('%02d:30', $h);
}

// Horários já ocupados nessa data
$stmt = $conn->prepare("SELECT hora FROM agendamentos WHERE data = ?");
$stmt->bind_param("s", $data);
$stmt->execute();
$result = $stmt->get_result();
$ocupados = [];
while ($row = $result->fetch_assoc()) {
    $ocupados[] = substr($row['hora'], 0, 5);
}
$stmt->close();
$conn->close();

$horarios = array_map(fn($h) => [
    'hora'       => $h,
    'disponivel' => !in_array($h, $ocupados)
], $todos);

echo json_encode(['horarios' => $horarios, 'fechado' => false]);
?>
