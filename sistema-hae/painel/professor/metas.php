<?php
require_once "../../config.php";
session_start();

// Redireciona se não estiver logado como professor
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'professor') {
    header("Location: ../../login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$inscricoes = [];

$stmt = $conn->prepare("SELECT id, titulo, data_envio, status, comentario, resposta_professor FROM inscricoes WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $inscricoes[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status das Propostas - Sistema HAE</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
      --cor-branca: #ffffff;
      --cor-texto: #333;
      --cor-sucesso: #2e7d32;
      --cor-aviso: #f9a825;
      --cor-erro: #c62828;
      --cor-pendente: #0277bd;
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
      margin: 30px auto;
      background-color: var(--cor-branca);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: var(--cor-primaria);
      text-align: center;
      margin-bottom: 30px;
    }

    .info {
      text-align: center;
      color: #555;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: var(--cor-primaria);
      color: white;
    }

    .status {
      font-weight: bold;
      padding: 6px 12px;
      border-radius: 20px;
      display: inline-block;
      font-size: 0.9rem;
    }

    .aprovado { background-color: #e0f2f1; color: var(--cor-sucesso); }
    .pendente { background-color: #e1f5fe; color: var(--cor-pendente); }
    .rejeitado { background-color: #ffebee; color: var(--cor-erro); }
    .parcial { background-color: #fff8e1; color: var(--cor-aviso); }

    .btn-voltar {
      margin-top: 30px;
      width: 100%;
      background-color: var(--cor-secundaria);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn-voltar:hover { background-color: #333; }

    .btn-acao {
      padding: 10px 18px;
      border-radius: 5px;
      font-weight: bold;
      border: none;
      margin-right: 8px;
      cursor: pointer;
    }

    .aceitar { background-color: #2e7d32; color: white; }
    .recusar { background-color: #c62828; color: white; }
  </style>
</head>
<body>
  <header>
    <img src="../../imagens/logo_sp.jpeg" alt="Logo Governo SP" />
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner">
    <h1>Status das Propostas Submetidas</h1>
  </div>

  <div class="container">
    <h2>Acompanhe o andamento da sua proposta</h2>
    <p class="info">Veja abaixo o status e, caso tenha ressalvas, confirme ou recuse a proposta.</p>

    <table>
      <thead>
        <tr>
          <th>Projeto</th>
          <th>Data de Envio</th>
          <th>Status</th>
          <th>Comentário</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($inscricoes as $inscricao): ?>
          <tr>
            <td><?= htmlspecialchars($inscricao['titulo']) ?></td>
            <td><?= date('d/m/Y', strtotime($inscricao['data_envio'])) ?></td>
            <td>
              <span class="status <?= $inscricao['status'] ?>">
                <?= ucfirst($inscricao['status']) ?>
              </span>
            </td>
            <td><?= htmlspecialchars($inscricao['comentario'] ?? '-') ?></td>
            <td>
              <?php if ($inscricao['status'] === 'parcial' && empty($inscricao['resposta_professor'])): ?>
                <form method="POST" action="responder_proposta.php" style="display:inline;">
                  <input type="hidden" name="inscricao_id" value="<?= $inscricao['id'] ?>">
                  <input type="hidden" name="resposta" value="aceito">
                  <button type="submit" class="btn-acao aceitar">Aceitar</button>
                </form>

                <form method="POST" action="responder_proposta.php" style="display:inline;">
                  <input type="hidden" name="inscricao_id" value="<?= $inscricao['id'] ?>">
                  <input type="hidden" name="resposta" value="recusado">
                  <button type="submit" class="btn-acao recusar">Recusar</button>
                </form>
              <?php elseif ($inscricao['resposta_professor'] === 'aceito'): ?>
                ✅ Proposta aceita
              <?php elseif ($inscricao['resposta_professor'] === 'recusado'): ?>
                ❌ Proposta recusada
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <form action="dashboard.php" method="get">
      <button type="submit" class="btn-voltar">Voltar para o Painel</button>
    </form>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>
</body>
</html>
