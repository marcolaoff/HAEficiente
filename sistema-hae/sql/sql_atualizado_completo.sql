
-- Desativar verificação de chave estrangeira para evitar erros de dependência
SET FOREIGN_KEY_CHECKS = 0;

-- Criar e usar o banco
CREATE DATABASE IF NOT EXISTS sistema_hae;
USE sistema_hae;

-- Apagar tabelas na ordem certa (filhas primeiro)
DROP TABLE IF EXISTS `relatorios`;
DROP TABLE IF EXISTS `propostas`;
DROP TABLE IF EXISTS `inscricoes`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `editais`;

-- Reativar verificação de chave estrangeira
SET FOREIGN_KEY_CHECKS = 1;

-- Tabela editais
CREATE TABLE `editais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `editais` (`id`, `titulo`, `descricao`, `arquivo_pdf`, `data_publicacao`) VALUES
(1, 'Edital HAE 2025', 'Inscrição de projetos para 2025', NULL, '2025-05-28 12:55:36');

-- Tabela usuarios
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','coordenador','professor') NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `aprovado` tinyint(1) DEFAULT 0,
  `telefone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `perfil`, `status`, `aprovado`, `telefone`) VALUES
(3, 'Administrador do Sistema', 'admin@fatec.com', 'admin', '$2y$10$YEpO7amcPw4w3/egPZW9I.90jlOPL/ZUoqZnweLbVi1E7dL8dZ1Zm', 'admin', 'ativo', 1, '(19) 99999-9999'),
(4, 'marcola', 'marcola@gmail.com', 'marcola', '$2y$10$wLO05W1lIJXpBqIBoKCQmObpbWK1tppgtTrU279rltXmC/5ktzjmy', 'professor', 'ativo', 1, ''),
(5, 'cleitin', 'cleiton@gmail.com', 'cleitin', '$2y$10$jcvO84nwaFOXpOdVqBLEuuvxuDhOx2e6uV8Mc9uSj6pfP.bwFH.iW', 'coordenador', 'ativo', 1, '(12) 31244-21');

-- Tabela inscricoes atualizada
CREATE TABLE `inscricoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `edital_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rg` varchar(50),
  `matricula` varchar(50),
  `titulo` varchar(255) NOT NULL,
  `tipo_hae` varchar(100),
  `quantidade_hae` int,
  `projeto_interesse` text,
  `periodo_inicio` date,
  `periodo_fim` date,
  `horarios_aula` text,
  `horario_execucao` text,
  `metas` text,
  `objetivos` text,
  `justificativa` text,
  `recursos` text,
  `resultado_esperado` text,
  `metodologia` text,
  `cronograma` text,
  `declaracao_ciencia` boolean DEFAULT 0,
  `arquivo_pdf` varchar(255),
  `status` varchar(20) DEFAULT 'pendente',
  `comentario` text,
  `comentario_coordenador` text,
  `data_envio` datetime DEFAULT current_timestamp(),
  `observacoes` text,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  FOREIGN KEY (`edital_id`) REFERENCES `editais` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela propostas
CREATE TABLE `propostas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `edital_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('pendente','aprovado','rejeitado','parcial') DEFAULT 'pendente',
  `comentario` text DEFAULT NULL,
  `proposta_alternativa` text DEFAULT NULL,
  `resposta_professor` text DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `edital_id` (`edital_id`),
  CONSTRAINT `propostas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `propostas_ibfk_2` FOREIGN KEY (`edital_id`) REFERENCES `editais` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela relatorios
CREATE TABLE `relatorios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proposta` int(11) NOT NULL,
  `resumo` text NOT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_proposta` (`id_proposta`),
  CONSTRAINT `relatorios_ibfk_1` FOREIGN KEY (`id_proposta`) REFERENCES `propostas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Corrigir charset explicitamente no final
SET character_set_client = 'utf8mb4';
SET character_set_results = 'utf8mb4';
SET collation_connection = 'utf8mb4_general_ci';
