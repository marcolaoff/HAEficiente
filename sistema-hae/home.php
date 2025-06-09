<?php
require_once "config.php"; // ajuste o caminho se necessário

// Buscar o edital mais recente e ativo
$edital = null;
$sql = "SELECT titulo, nome_arquivo FROM editais WHERE ativo = 1 ORDER BY data_publicacao DESC LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
  $edital = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal HAE – Fatec Itapira</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
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
      font-size: 28px;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: var(--cor-branca);
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .edital {
      background-color: #fff4f4;
      border-left: 6px solid var(--cor-primaria);
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
    }

    .edital h2 {
      margin-top: 0;
      color: var(--cor-primaria);
    }

    .btn {
      display: inline-block;
      padding: 14px 28px;
      background-color: var(--cor-primaria);
      color: white;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #8f1011;
    }

    .footer {
      background-color: var(--cor-secundaria);
      color: white;
      text-align: center;
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
    <h1>HAEficiente – Fatec Itapira</h1>
  </div>

  <div class="container">
    <?php if ($edital): ?>
      <div class="edital">
        <h2><?= htmlspecialchars($edital['titulo']) ?></h2>
        <p>Consulte as áreas de interesse e critérios para envio de propostas de HAEs.</p>
        <a href="arquivos/<?= htmlspecialchars($edital['nome_arquivo']) ?>" class="btn" target="_blank">📄 Baixar Edital</a>
      </div>
    <?php else: ?>
      <div class="edital">
        <h2>Nenhum edital disponível</h2>
        <p>Atualmente não há edital ativo publicado.</p>
      </div>
    <?php endif; ?>

    <a href="login.html" class="btn">🔐 Acessar Sistema</a>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema de Gestão de HAEs
  </div>
</body>
</html>

