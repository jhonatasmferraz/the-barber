<?php
$host = 'localhost'; 
$db = 'barbearia';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error){
    die('erro de conexão:' . $conn-> connect_error);
}
?>