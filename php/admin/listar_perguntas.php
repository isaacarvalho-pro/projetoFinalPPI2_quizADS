<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    exit;
}

$stmt = $conn->query("SELECT * FROM perguntas ORDER BY id DESC");
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);
