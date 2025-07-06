CREATE DATABASE quiz_ads;
USE quiz_ads;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    pontuacao INT DEFAULT 0
);

CREATE TABLE perguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pergunta TEXT NOT NULL,
    op1 VARCHAR(255),
    op2 VARCHAR(255),
    op3 VARCHAR(255),
    op4 VARCHAR(255),
    correta TINYINT CHECK (correta BETWEEN 1 AND 4)
);

CREATE TABLE respostas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    pergunta_id INT,
    resposta_usuario TINYINT,
    correta BOOLEAN,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (pergunta_id) REFERENCES perguntas(id)
);
