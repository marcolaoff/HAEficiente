
<?php
session_start();

// Corrigir o nome da variável de sessão
if (!isset($_SESSION["usuario_id"]) || $_SESSION["perfil"] !== "professor") {
    header("Location: ../../login.html"); // Use caminho absoluto relativo
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscrição - Sistema HAE</title>
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
      font-size: 26px;
    }

    .form-container {
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
      margin-top: 15px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 6px;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    button {
      width: 100%;
      margin-top: 30px;
      padding: 14px;
      background-color: var(--cor-primaria);
      color: white;
      font-weight: bold;
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
    <h1>Inscrição no Edital HAE</h1>
  </div>

  <div class="form-container">
    <h2>Formulário de Inscrição</h2>
    <form method="POST" action="salvar_inscricao.php" enctype="multipart/form-data">
      <label for="nome">Nome do Professor</label>
      <input type="text" id="nome" name="nome" value="<?php echo $_SESSION['usuario_nome']; ?>" readonly>

      <label for="telefone">Telefone</label>
      <input type="text" id="telefone" name="telefone" required>

      <label for="titulo">Título do Projeto</label>
      <input type="text" id="titulo" name="titulo" required>

      <label for="descricao">Descrição da Proposta</label>
      <textarea id="descricao" name="descricao" required></textarea>

      <label for="arquivo_pdf">Anexar PDF</label>
      <input type="file" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf">

      <button type="submit">Enviar Inscrição</button>
    </form>
    <form action="dashboard.php" method="get">
      <button type="submit" class="btn-voltar">Voltar para o Painel</button>
    </form>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>

  <script>
    document.getElementById('telefone').addEventListener('input', function (e) {
      let x = e.target.value.replace(/\D/g, '').slice(0, 11);
      if (x.length >= 2 && x.length <= 6)
        x = `(${x.slice(0, 2)}) ${x.slice(2)}`;
      else if (x.length > 6)
        x = `(${x.slice(0, 2)}) ${x.slice(2, 7)}-${x.slice(7)}`;
      e.target.value = x;
    });
  </script>
</body>
</html>
