<?php
session_start();
if (!isset($_SESSION["perfil"])) {
    header("Location: /HAEficiente/sistema-hae/login.html");
    exit();
}
$perfil = $_SESSION["perfil"];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Sistema HAE</title>
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

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
    }

    .perfil {
      text-align: center;
      font-weight: bold;
      margin-bottom: 30px;
      color: #555;
    }

    .menu {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
    }

    .botao {
      background-color: var(--cor-primaria);
      color: white;
      padding: 20px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .botao:hover {
      background-color: #8f1011;
      transform: translateY(-3px);
    }

    .botao.vermelho {
      background-color: #6b0001;
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
    <h1>Painel do Usuário</h1>
  </div>

  <div class="container">
    <p class="perfil">Você está logado como: <?php echo ucfirst($perfil); ?></p>

    <?php if ($perfil === "professor"): ?>
    <div class="menu">
      <a href="formulario.php" class="botao">Preencher Inscrição</a>
      <a href="realizar-relatorio.php" class="botao">Enviar Relatório Final</a>
      <a href="metas.php" class="botao">Ver Status da Proposta</a>
    </div>
    <?php elseif ($perfil === "coordenador"): ?>
    <div class="menu">
      <a href="../coordenador/publicar-documentos.php" class="botao">Publicar Edital</a>
      <a href="../coordenador/avaliar.php" class="botao">Avaliar Propostas</a>
    </div>
    <?php elseif ($perfil === "admin"): ?>
    <div class="menu">
      <a href="../../admin/aprovar_coordenadores.php" class="botao">Aprovar Coordenadores</a>
      <a href="../../admin/gerenciar_usuarios.php" class="botao">Gerenciar Usuários</a>
    </div>
    <?php endif; ?>

    <div class="menu">
      <a href="../../logout.php" class="botao vermelho">Sair do Sistema</a>
    </div>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
