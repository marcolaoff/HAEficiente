<?php
session_start();
require_once "../../config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Relatório Enviado - Sistema HAE</title>
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
    }

    header {
      background-color: var(--cor-secundaria);
      padding: 10px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header img { height: 60px; }

    .banner {
      text-align: center;
      padding: 30px 20px;
      background-color: var(--cor-primaria);
      color: white;
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

    .btn-voltar {
      display: inline-block;
      margin-top: 20px;
      background-color: var(--cor-primaria);
      color: white;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 16px;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      color: white;
      background-color: var(--cor-secundaria);
      padding: 15px;
    }
  </style>
</head>

<body>
  <header>
    <img src="../../imagens/logo_sp.jpeg" alt="Logo SP" />
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner">
    <h1>Relatório Final Enviado!</h1>
  </div>

  <div class="container">
    <div class="icone">✅</div>
    <h2>Relatório Registrado com Sucesso</h2>
    <p>O seu relatório foi enviado para análise da coordenação.</p>
    <a href="../professor/dashboard.php" class="btn-voltar">Voltar ao Painel</a>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
