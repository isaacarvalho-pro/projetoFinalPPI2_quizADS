<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$stmt = $conn->query("SELECT * FROM perguntas");
$perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($perguntas);
?>
