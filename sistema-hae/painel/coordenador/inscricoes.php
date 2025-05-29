<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION["perfil"]) || $_SESSION["perfil"] !== "coordenador") {
    header("Location: /HAEficiente/sistema-hae/login.html");
    exit();
}

$stmt = $conn->prepare("
    SELECT i.id, i.titulo, i.data_envio, i.status, i.comentario,
           u.nome as professor_nome
    FROM inscricoes i
    JOIN usuarios u ON i.usuario_id = u.id
    ORDER BY i.data_envio DESC
");
$stmt->execute();
$result = $stmt->get_result();
$inscricoes = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Inscrições - Sistema HAE</title>
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

    .container {
      max-width: 1000px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .card {
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 30px;
      padding: 20px;
    }

    .card h3 {
      margin: 0 0 10px;
      color: var(--cor-primaria);
    }

    label, select, textarea {
      display: block;
      width: 100%;
      margin-top: 10px;
    }

    textarea {
      min-height: 80px;
      resize: vertical;
    }

    .btn {
      background-color: var(--cor-primaria);
      color: white;
      border: none;
      padding: 10px 15px;
      margin-top: 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #8f1011;
    }

    .footer {
      text-align: center;
      background-color: var(--cor-secundaria);
      color: white;
      padding: 15px;
      margin-top: 40px;
    }
  </style>
</head>
<body>
<header>
  <img src="../../imagens/logo_sp.jpeg" alt="Logo Governo SP">
  <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira">
</header>

<div class="banner">
  <h1>Inscrições Realizadas</h1>
</div>

<div class="container">
  <?php foreach ($inscricoes as $ins): ?>
    <div class="card">
      <h3><?= htmlspecialchars($ins['titulo']) ?></h3>
      <p><strong>Professor:</strong> <?= htmlspecialchars($ins['professor_nome']) ?></p>
      <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($ins['data_envio'])) ?></p>

      <form action="avaliar_inscricao.php" method="POST">
        <input type="hidden" name="id" value="<?= $ins['id'] ?>">
        <label>Status:</label>
        <select name="status" required>
          <option value="pendente" <?= $ins['status'] == 'pendente' ? 'selected' : '' ?>>Em Análise</option>
          <option value="aprovado" <?= $ins['status'] == 'aprovado' ? 'selected' : '' ?>>Aprovado</option>
          <option value="parcial" <?= $ins['status'] == 'parcial' ? 'selected' : '' ?>>Aprovado com Ressalvas</option>
          <option value="rejeitado" <?= $ins['status'] == 'rejeitado' ? 'selected' : '' ?>>Rejeitado</option>
        </select>

        <label>Comentário:</label>
        <textarea name="comentario"><?= htmlspecialchars($ins['comentario'] ?? '') ?></textarea>

        <button type="submit" class="btn">Salvar Avaliação</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

<div class="footer">
  &copy; 2025 Fatec Itapira – Sistema HAE
</div>
</body>
</html>
