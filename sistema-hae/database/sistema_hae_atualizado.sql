
-- Banco de dados: sistema_hae

CREATE DATABASE IF NOT EXISTS sistema_hae DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sistema_hae;

-- Tabela de usuários (admin, coordenador e professor)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'coordenador', 'professor') NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    aprovado BOOLEAN DEFAULT 0,
    telefone VARCHAR(20)
);

-- Tabela de propostas (inscrição de projetos)
CREATE TABLE propostas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    status ENUM('pendente', 'aprovado', 'rejeitado', 'parcial') DEFAULT 'pendente',
    comentario TEXT,
    proposta_alternativa TEXT,
    resposta_professor TEXT,
    arquivo_pdf VARCHAR(255),
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de relatórios finais
CREATE TABLE relatorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proposta INT NOT NULL,
    resumo TEXT NOT NULL,
    arquivo_pdf VARCHAR(255),
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proposta) REFERENCES propostas(id) ON DELETE CASCADE
);

-- Tabela de editais publicados
CREATE TABLE editais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    arquivo_pdf VARCHAR(255),
    data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP
);
