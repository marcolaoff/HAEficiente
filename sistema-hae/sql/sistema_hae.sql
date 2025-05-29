USE sistema_hae;

CREATE TABLE `editais` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `editais`
--

INSERT INTO `editais` (`id`, `titulo`, `descricao`, `arquivo_pdf`, `data_publicacao`) VALUES
(1, 'Edital HAE 2025', 'Inscrição de projetos para 2025', NULL, '2025-05-28 12:55:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `inscricoes`
--

CREATE TABLE `inscricoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `edital_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente',
  `comentario` text DEFAULT NULL,
  `comentario_coordenador` text DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `inscricoes`
--

INSERT INTO `inscricoes` (`id`, `usuario_id`, `edital_id`, `titulo`, `descricao`, `arquivo_pdf`, `status`, `comentario`, `comentario_coordenador`, `data_envio`, `observacoes`) VALUES
(3, 4, 1, '4124', 'dsadsad', '', 'pendente', NULL, NULL, '2025-05-28 13:12:42', NULL),
(4, 4, 1, '41234124124', '31312312', '', 'parcial', 'dasdasda', NULL, '2025-05-28 20:45:54', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `propostas`
--

CREATE TABLE `propostas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `edital_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('pendente','aprovado','rejeitado','parcial') DEFAULT 'pendente',
  `comentario` text DEFAULT NULL,
  `proposta_alternativa` text DEFAULT NULL,
  `resposta_professor` text DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `relatorios`
--

CREATE TABLE `relatorios` (
  `id` int(11) NOT NULL,
  `id_proposta` int(11) NOT NULL,
  `resumo` text NOT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','coordenador','professor') NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `aprovado` tinyint(1) DEFAULT 0,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `perfil`, `status`, `aprovado`, `telefone`) VALUES
(3, 'Administrador do Sistema', 'admin@fatec.com', 'admin', '$2y$10$YEpO7amcPw4w3/egPZW9I.90jlOPL/ZUoqZnweLbVi1E7dL8dZ1Zm', 'admin', 'ativo', 1, '(19) 99999-9999'),
(4, 'marcola', 'marcola@gmail.com', 'marcola', '$2y$10$wLO05W1lIJXpBqIBoKCQmObpbWK1tppgtTrU279rltXmC/5ktzjmy', 'professor', 'ativo', 1, ''),
(5, 'cleitin', 'cleiton@gmail.com', 'cleitin', '$2y$10$jcvO84nwaFOXpOdVqBLEuuvxuDhOx2e6uV8Mc9uSj6pfP.bwFH.iW', 'coordenador', 'ativo', 1, '(12) 31244-21');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `editais`
--
ALTER TABLE `editais`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `edital_id` (`edital_id`);

--
-- Índices de tabela `propostas`
--
ALTER TABLE `propostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `edital_id` (`edital_id`);

--
-- Índices de tabela `relatorios`
--
ALTER TABLE `relatorios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proposta` (`id_proposta`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `editais`
--
ALTER TABLE `editais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `propostas`
--
ALTER TABLE `propostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relatorios`
--
ALTER TABLE `relatorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD CONSTRAINT `inscricoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `inscricoes_ibfk_2` FOREIGN KEY (`edital_id`) REFERENCES `editais` (`id`);

--
-- Restrições para tabelas `propostas`
--
ALTER TABLE `propostas`
  ADD CONSTRAINT `propostas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `propostas_ibfk_2` FOREIGN KEY (`edital_id`) REFERENCES `editais` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `relatorios`
--
ALTER TABLE `relatorios`
  ADD CONSTRAINT `relatorios_ibfk_1` FOREIGN KEY (`id_proposta`) REFERENCES `propostas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
