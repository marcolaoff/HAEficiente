<?php
require_once "../../config.php";
session_start();
// TODO: Adicionar verificação de sessão e carregar dados do banco se necessário
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resumo do Projeto - Sistema HAE</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
      --cor-branca: #ffffff;
      --cor-sucesso: #2e7d32;
      --cor-aviso: #f9a825;
      --cor-erro: #c62828;
      --cor-pendente: #0277bd;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--cor-fundo);
      color: #333;
    }

    header {
      background-color: var(--cor-secundaria);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 40px;
    }

    header img {
      height: 60px;
    }

    .banner {
      text-align: center;
      padding: 30px 20px;
      background-color: var(--cor-primaria);
      color: white;
    }

    .banner h1 {
      margin: 0;
      font-size: 26px;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      background-color: var(--cor-branca);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .section {
      margin-bottom: 30px;
    }

    .section h2 {
      font-size: 1.2rem;
      color: var(--cor-primaria);
      border-bottom: 2px solid #eee;
      padding-bottom: 6px;
      margin-bottom: 10px;
    }

    .section p {
      margin: 6px 0;
    }

    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: bold;
      margin-top: 10px;
    }

    .aprovado {
      background-color: #e0f2f1;
      color: var(--cor-sucesso);
    }

    .pendente {
      background-color: #e1f5fe;
      color: var(--cor-pendente);
    }

    .rejeitado {
      background-color: #ffebee;
      color: var(--cor-erro);
    }

    .parcial {
      background-color: #fff8e1;
      color: var(--cor-aviso);
    }

    .documento-link {
      display: inline-block;
      margin-top: 10px;
      background-color: var(--cor-primaria);
      color: white;
      padding: 10px 16px;
      border-radius: 6px;
      text-decoration: none;
    }

    .documento-link:hover {
      background-color: #8f1011;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 13px;
      color: white;
      background-color: var(--cor-secundaria);
      padding: 15px;
    }
  </style>
</head>
<body>
  <header>
    <img src="imagens/logo_sp.jpeg" alt="Logo Governo SP" />
    <img src="imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner">
    <h1>Resumo da Proposta Submetida</h1>
  </div>

  <div class="container">
    <div class="section">
      <h2>Informações do Professor</h2>
      <p><strong>Nome:</strong> João da Silva</p>
      <p><strong>Curso:</strong> Gestão da Tecnologia da Informação</p>
      <p><strong>Email:</strong> joao.silva@fatec.sp.gov.br</p>
    </div>

    <div class="section">
      <h2>Dados do Projeto</h2>
      <p><strong>Título:</strong> Integração de Sistemas Acadêmicos com Power BI</p>
      <p><strong>Resumo:</strong> O projeto visa criar painéis interativos com indicadores de desempenho baseados nos dados internos da Fatec, permitindo uma melhor gestão e análise.</p>
      <a href="#" class="documento-link" target="_blank">Ver Documento Anexado (PDF)</a>
    </div>

    <div class="section">
      <h2>Status da Avaliação</h2>
      <p><span class="status-badge pendente">Em Análise</span></p>
      <p><strong>Comentário da Coordenação:</strong> Aguardando reunião do colegiado para deliberação final.</p>
    </div>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
