<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco se não existir
    $pdo->exec("CREATE DATABASE IF NOT EXISTS quiz_ads CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // Usa o banco
    $pdo->exec("USE quiz_ads");

    // Cria a tabela de usuários
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100),
            email VARCHAR(100) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL,
            is_admin BOOLEAN DEFAULT FALSE,
            pontuacao INT DEFAULT 0
        );
    ");

    // Cria a tabela de perguntas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS perguntas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            pergunta TEXT NOT NULL,
            op1 VARCHAR(255),
            op2 VARCHAR(255),
            op3 VARCHAR(255),
            op4 VARCHAR(255),
            correta TINYINT CHECK (correta BETWEEN 1 AND 4)
        );
    ");

    // Cria a tabela de respostas (opcional)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS respostas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT,
            pergunta_id INT,
            resposta_usuario TINYINT,
            correta BOOLEAN,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
            FOREIGN KEY (pergunta_id) REFERENCES perguntas(id)
        );
    ");

    echo "Setup concluído com sucesso!";
} catch (PDOException $e) {
    echo "Erro na configuração: " . $e->getMessage();
}
?>
