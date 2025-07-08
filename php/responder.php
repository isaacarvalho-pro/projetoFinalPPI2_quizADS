<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    exit('Usuário não autenticado.');
}

$usuario_id = $_SESSION['usuario_id'];
$total = $_POST['total'] ?? 0;
$acertos = $_POST['acertos'] ?? 0;
$respostas = json_decode($_POST['respostas'] ?? '[]', true);

// Atualiza pontuação da última tentativa
$porcentagem = ($total > 0) ? round(($acertos / $total) * 100) : 0;

$stmt = $conn->prepare("UPDATE usuarios SET pontuacao = ? WHERE id = ?");
$stmt->execute([$porcentagem, $usuario_id]);

// Registra cada resposta
$stmt = $conn->prepare("INSERT INTO respostas (usuario_id, pergunta_id, resposta_usuario, correta) VALUES (?, ?, ?, ?)");

foreach ($respostas as $resp) {
    $stmt->execute([
        $usuario_id,
        $resp['pergunta_id'],
        $resp['resposta_usuario'],
        $resp['correta'] ? 1 : 0
    ]);
}