<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['is_admin'] != 1) {
    exit("Acesso negado.");
}

$pergunta = $_POST['pergunta'];
$op1 = $_POST['op1'];
$op2 = $_POST['op2'];
$op3 = $_POST['op3'];
$op4 = $_POST['op4'];
$correta = $_POST['correta'];

$stmt = $conn->prepare("INSERT INTO perguntas (pergunta, op1, op2, op3, op4, correta) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$pergunta, $op1, $op2, $op3, $op4, $correta]);

echo "Pergunta adicionada com sucesso.";
