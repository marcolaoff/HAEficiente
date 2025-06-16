-- Desativar verificação de chave estrangeira
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS sistema_hae;
USE sistema_hae;

-- Apagar tabelas existentes
DROP TABLE IF EXISTS `relatorios`;
DROP TABLE IF EXISTS `propostas`;
DROP TABLE IF EXISTS `inscricoes`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `editais`;

SET FOREIGN_KEY_CHECKS = 1;

-- Tabela editais
CREATE TABLE `editais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela inscricoes atualizada COMPLETA
CREATE TABLE `inscricoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `edital_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rg` varchar(50),
  `matricula` varchar(50),
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

-- Tabela propostas (permanece igual)
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
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`edital_id`) REFERENCES `editais` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela relatorios (permanece igual)
CREATE TABLE `relatorios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proposta` int(11) NOT NULL,
  `resumo` text NOT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_proposta` (`id_proposta`),
  FOREIGN KEY (`id_proposta`) REFERENCES `propostas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
