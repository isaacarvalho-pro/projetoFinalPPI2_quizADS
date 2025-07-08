<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['is_admin'] != 1) {
    exit("Acesso negado.");
}

$id = $_POST['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM perguntas WHERE id = ?");
$stmt->execute([$id]);

echo "Pergunta deletada com sucesso.";
