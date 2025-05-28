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
  <title>Publicar Edital - Sistema HAE</title>
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
      color: var(--cor-texto);
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

    input[type="text"],
    input[type="file"],
    textarea {
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
    <h1>Publicar Novo Edital</h1>
  </div>

  <div class="container">
    <h2>Cadastro de Edital de HAEs</h2>
    <form>
      <label for="titulo">Título do Edital</label>
      <input type="text" id="titulo" name="titulo" placeholder="Ex: Edital HAE 2025 - 1º Semestre" required />

      <label for="descricao">Descrição / Observações</label>
      <textarea id="descricao" name="descricao" placeholder="Informe detalhes adicionais se necessário."></textarea>

      <label for="arquivo">Anexar Arquivo (PDF)</label>
      <input type="file" id="arquivo" name="arquivo" accept=".pdf" required />

      <button type="submit">Publicar Edital</button>
    </form>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
