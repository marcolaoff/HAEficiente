<?php
session_start();
if (!isset($_SESSION["usuario_nome"])) {
    header("Location: ../../login.html");
    exit();
}
$nome = $_SESSION["usuario_nome"];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Edital Publicado</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-branca: #ffffff;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: var(--cor-secundaria);
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header img {
      height: 60px;
    }

    .container {
      text-align: center;
      margin: auto;
      background: white;
      padding: 50px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      max-width: 600px;
    }

    h1 {
      color: var(--cor-primaria);
    }

    p {
      font-size: 18px;
      color: #333;
    }

    .botao {
      display: inline-block;
      margin-top: 30px;
      padding: 14px 30px;
      background-color: var(--cor-primaria);
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .botao:hover {
      background-color: #a40e10;
    }

    .footer {
      margin-top: auto;
      background-color: var(--cor-secundaria);
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 13px;
    }
  </style>
</head>
<body>
  <header>
    <img src="../../imagens/logo_sp.jpeg" alt="Logo Governo SP">
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira">
  </header>

  <div class="container">
    <h1>Sucesso!</h1>
    <p>O edital foi publicado com sucesso.</p>
    <a href="../coordenador/dashboard.php" class="botao">Voltar ao Painel</a>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
