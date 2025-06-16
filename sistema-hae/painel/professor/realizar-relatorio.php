<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION["usuario_id"]) || $_SESSION["perfil"] !== "professor") {
    header("Location: ../../login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$inscricoes = [];

// Buscar somente as propostas aprovadas
$stmt = $conn->prepare("SELECT id, titulo FROM inscricoes WHERE usuario_id = ? AND status = 'aprovado'");
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório Final - Sistema HAE</title>
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
    }
    header { background-color: var(--cor-secundaria); padding: 10px 40px; display: flex; justify-content: space-between; align-items: center; }
    header img { height: 60px; }
    .banner { background-color: var(--cor-primaria); color: white; text-align: center; padding: 30px 20px; }
    .container { max-width: 800px; margin: 40px auto; background-color: var(--cor-branca); padding: 40px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
    h2 { color: var(--cor-primaria); margin-bottom: 30px; text-align: center; }
    label { display: block; margin-top: 20px; font-weight: bold; }
    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    textarea { resize: vertical; min-height: 120px; }
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
    button:hover { background-color: #8f1011; }
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
    <img src="../../imagens/logo_sp.jpeg" alt="Logo SP" />
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec" />
  </header>
  
  <div class="banner">
    <h1>Envio de Relatório Final</h1>
  </div>

  <div class="container">
    <h2>Selecione o projeto e envie o relatório</h2>

    <form action="salvar_relatorio.php" method="POST" enctype="multipart/form-data">
      <label for="inscricao_id">Selecione o projeto aprovado:</label>
      <select name="inscricao_id" id="inscricao_id" required>
        <option value="">Selecione...</option>
        <?php foreach ($inscricoes as $inscricao): ?>
          <option value="<?= $inscricao['id'] ?>"><?= htmlspecialchars($inscricao['titulo']) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="resumo">Resumo das Atividades Realizadas:</label>
      <textarea name="resumo" id="resumo" required></textarea>

      <label for="arquivo_pdf">Anexar Relatório Final (PDF)</label>
      <input type="file" name="arquivo_pdf" id="arquivo_pdf" accept=".pdf" required>

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
