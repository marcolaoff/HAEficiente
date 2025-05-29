<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION["usuario_id"]) || $_SESSION["perfil"] !== "professor") {
    header("Location: ../../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Relatório Final - Sistema HAE</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
      --cor-branca: #ffffff;
      --cor-texto: #333;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--cor-fundo);
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
      max-width: 800px;
      margin: 40px auto;
      background-color: var(--cor-branca);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: var(--cor-primaria);
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-top: 20px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    button {
      margin-top: 30px;
      width: 100%;
      background-color: var(--cor-primaria);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #8f1011;
    }

    .btn-voltar {
      width: 100%;
      margin-top: 10px;
      background-color: var(--cor-secundaria);
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
    <img src="../../imagens/logo_sp.jpeg" alt="Logo Governo SP" />
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>
  
  <div class="banner">
    <h1>Relatório Final de Projeto</h1>
  </div>

  <div class="container">
    <h2>Informe os resultados das atividades desenvolvidas</h2>
    <form>
      <label for="nome">Nome do Professor</label>
      <input type="text" id="nome" name="nome" placeholder="Ex: João da Silva" required />

      <label for="projeto">Título do Projeto</label>
      <input type="text" id="projeto" name="projeto" placeholder="Título da proposta aprovada" required />

      <label for="resumo">Resumo das Atividades Realizadas</label>
      <textarea id="resumo" name="resumo" placeholder="Descreva brevemente as ações, entregas e resultados do projeto." required></textarea>

      <label for="anexo">Anexar Relatório Final (PDF)</label>
      <input type="file" id="anexo" name="anexo" accept=".pdf" required />

      <button type="submit">Enviar Relatório</button>
    </form>

    <form action="dashboard.php" method="get">
      <button type="submit" class="btn-voltar">Voltar para o Painel</button>
    </form>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
