<?php
session_start();
require 'conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Validação básica
if (empty($email) || empty($senha)) {
    header("Location: ../index.html?erro=preencha");
    exit;
}

$stmt = $conn->prepare("SELECT id, senha, is_admin FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() === 1) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['is_admin'] = $usuario['is_admin'];

        if ($usuario['is_admin']) {
            header("Location: ../admin.html");
            exit;
        } else {
            header("Location: ../quiz.html");
            exit;
        }
    } else {
        header("Location: ../index.html?erro=senha");
        exit;
    }
} else {
    header("Location: ../index.html?erro=usuario");
    exit;
}
