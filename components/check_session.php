<?php
session_start();
header('Content-Type: application/json');
echo json_encode([
    'logged_in' => isset($_SESSION['usuario_id']),
    'nome'      => $_SESSION['usuario_nome'] ?? ''
]);
?>
