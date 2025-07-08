<?php
require 'conexao.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Validação simples
if (empty($nome) || empty($email) || empty($senha)) {
    echo "Preencha todos os campos.";
    exit;
}

// Verifica se o e-mail já está cadastrado
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo "E-mail já cadastrado.";
    exit;
}

// Insere novo usuário
$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");

if ($stmt->execute([$nome, $email, $hash])) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar usuário.";
}
?>
