<?php
require_once "../../config.php";
session_start();
// TODO: Adicionar verificação de sessão e carregar dados do banco se necessário
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Confirmação de Inscrição - Sistema HAE</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
      --cor-sucesso: #2e7d32;
      --cor-branca: #ffffff;
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
      max-width: 600px;
      margin: 40px auto;
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .icone {
      font-size: 60px;
      color: var(--cor-sucesso);
      margin-bottom: 20px;
    }

    h2 {
      color: var(--cor-primaria);
      margin-bottom: 10px;
    }

    p {
      font-size: 16px;
      margin-bottom: 30px;
    }

    .btn-voltar {
      display: inline-block;
      background-color: var(--cor-primaria);
      color: white;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .btn-voltar:hover {
      background-color: #8f1011;
    }

    .footer {
      background-color: var(--cor-secundaria);
      text-align: center;
      color: white;
      padding: 15px;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <header>
    <img src="imagens/logo_sp.jpeg" alt="Logo Governo SP" />
    <img src="imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner">
    <h1>Inscrição Enviada</h1>
  </div>

  <div class="container">
    <div class="icone">✅</div>
    <h2>Inscrição Realizada com Sucesso!</h2>
    <p>Sua proposta foi registrada e será avaliada pela coordenação da Fatec Itapira. Acompanhe o status pelo seu painel.</p>
    <a href="dashboard.php?tipo=professor" class="btn-voltar">Voltar para o Painel</a>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
