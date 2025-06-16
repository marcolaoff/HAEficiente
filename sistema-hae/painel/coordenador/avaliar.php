<?php
require_once "../../config.php";
session_start();

// Validação de sessão
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'coordenador') {
    header("Location: ../../login.html");
    exit();
}

// Buscar inscrições completas
$sql = "SELECT i.id, i.titulo, i.objetivos, i.justificativa, i.resumo, i.status, i.comentario, u.nome AS professor 
        FROM inscricoes i
        JOIN usuarios u ON i.usuario_id = u.id
        ORDER BY i.data_envio DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Avaliação de Propostas - Sistema HAE</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
      --cor-branca: #ffffff;
    }
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: var(--cor-fundo); color: #333; }
    header { background-color: var(--cor-secundaria); display: flex; justify-content: space-between; padding: 10px 40px; }
    header img { height: 60px; }
    .banner { background-color: var(--cor-primaria); color: white; text-align: center; padding: 30px 20px; }
    .container { max-width: 1000px; margin: 30px auto; background-color: var(--cor-branca); padding: 40px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
    .projeto-card { border: 1px solid #ccc; border-radius: 10px; padding: 20px; margin-bottom: 30px; background-color: #fff; }
    .projeto-card h2 { color: var(--cor-primaria); margin-top: 0; }
    .info { font-size: 14px; margin: 6px 0; }
    .status-select, textarea { width: 100%; padding: 10px; margin-top: 8px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
    textarea { resize: vertical; min-height: 100px; }
    .btn-salvar { background-color: var(--cor-primaria); color: white; padding: 12px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
    .btn-salvar:hover { background-color: #8f1011; }
    .footer { text-align: center; margin-top: 40px; font-size: 13px; color: white; background-color: var(--cor-secundaria); padding: 15px; }
  </style>
</head>

<body>
  <header>
    <img src="../../imagens/logo_sp.jpeg" alt="Logo Governo SP" />
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner">
    <h1>Avaliação de Propostas HAE</h1>
  </div>

  <div class="container">
    <?php while ($p = $result->fetch_assoc()): ?>
      <form method="POST" action="avaliar_inscricao.php" class="projeto-card">
        <h2><?= htmlspecialchars($p['titulo']) ?></h2>
        <p class="info"><strong>Professor:</strong> <?= htmlspecialchars($p['professor']) ?></p>
        <p class="info"><strong>Justificativa:</strong> <?= htmlspecialchars($p['justificativa']) ?></p>
        <p class="info"><strong>Objetivos:</strong> <?= htmlspecialchars($p['objetivos']) ?></p>

        <input type="hidden" name="inscricao_id" value="<?= $p['id'] ?>">

        <label for="status_<?= $p['id'] ?>">Status da Avaliação:</label>
        <select name="status" class="status-select" id="status_<?= $p['id'] ?>">
          <option value="pendente" <?= $p['status'] == 'pendente' ? 'selected' : '' ?>>Em Análise</option>
          <option value="aprovado" <?= $p['status'] == 'aprovado' ? 'selected' : '' ?>>Aprovado</option>
          <option value="parcial" <?= $p['status'] == 'parcial' ? 'selected' : '' ?>>Aprovado com Ressalvas</option>
          <option value="rejeitado" <?= $p['status'] == 'rejeitado' ? 'selected' : '' ?>>Rejeitado</option>
        </select>

        <label>Comentário da Coordenação:</label>
        <textarea name="comentario"><?= htmlspecialchars($p['comentario']) ?></textarea>

        <button class="btn-salvar" type="submit">Salvar Avaliação</button>
      </form>
    <?php endwhile; ?>
  </div>

  <div class="footer">&copy; 2025 Fatec Itapira – Sistema HAE</div>
</body>
</html>
