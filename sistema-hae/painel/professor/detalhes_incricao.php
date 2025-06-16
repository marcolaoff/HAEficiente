<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'professor') {
    header("Location: ../../login.html");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID da inscrição não informado!";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$id_inscricao = intval($_GET['id']);

// Buscar dados da inscrição
$stmt = $conn->prepare("SELECT * FROM inscricoes WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id_inscricao, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$inscricao = $result->fetch_assoc();
$stmt->close();

if (!$inscricao) {
    echo "Inscrição não encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detalhes da Inscrição</title>
  <style>
    :root { --cor-primaria: #cc1719; --cor-secundaria: #000000; --cor-fundo: #f4f4f4; --cor-branca: #ffffff; }
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: var(--cor-fundo); }
    header { background-color: var(--cor-secundaria); display: flex; justify-content: space-between; align-items: center; padding: 10px 40px; }
    header img { height: 60px; }
    .banner { background-color: var(--cor-primaria); color: white; text-align: center; padding: 30px 20px; }
    .container { max-width: 900px; margin: 40px auto; background-color: var(--cor-branca); padding: 40px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
    h2 { color: var(--cor-primaria); margin-bottom: 20px; }
    label { font-weight: bold; display: block; margin-top: 20px; }
    .campo { background: #f9f9f9; padding: 12px; border-radius: 6px; margin-top: 6px; }
    .btn-voltar { display: block; width: 100%; margin-top: 40px; background-color: var(--cor-secundaria); color: white; padding: 14px; border: none; border-radius: 6px; font-size: 16px; text-decoration: none; text-align: center; }
    .btn-voltar:hover { background-color: #333; }
    .footer { text-align: center; margin-top: 40px; font-size: 13px; color: white; background-color: var(--cor-secundaria); padding: 15px; }
  </style>
</head>
<body>

  <header>
    <img src="../../imagens/logo_sp.jpeg" alt="Logo SP" />
    <img src="../../imagens/logo_fatec.jpeg" alt="Logo Fatec" />
  </header>

  <div class="banner">
    <h1>Detalhes da Inscrição</h1>
  </div>

  <div class="container">
    <h2><?= htmlspecialchars($inscricao['titulo']) ?></h2>

    <label>Status:</label>
    <div class="campo"><?= ucfirst($inscricao['status']) ?></div>

    <label>Justificativa:</label>
    <div class="campo"><?= nl2br(htmlspecialchars($inscricao['justificativa'])) ?></div>

    <label>Objetivos:</label>
    <div class="campo"><?= nl2br(htmlspecialchars($inscricao['objetivos'])) ?></div>

    <label>Metodologia:</label>
    <div class="campo"><?= nl2br(htmlspecialchars($inscricao['metodologia'])) ?></div>

    <label>Resultados Esperados:</label>
    <div class="campo"><?= nl2br(htmlspecialchars($inscricao['resultados'])) ?></div>

    <label>Cronograma de Execução:</label>
    <div class="campo"><?= nl2br(htmlspecialchars($inscricao['cronograma'])) ?></div>

    <label>Data de Envio:</label>
    <div class="campo"><?= date('d/m/Y H:i', strtotime($inscricao['data_envio'])) ?></div>

    <?php if (!empty($inscricao['arquivo_pdf'])): ?>
      <label>Arquivo Anexado:</label>
      <div class="campo">
        <a href="../../uploads/<?= htmlspecialchars($inscricao['arquivo_pdf']) ?>" target="_blank">Visualizar PDF</a>
      </div>
    <?php endif; ?>

    <a href="metas.php" class="btn-voltar">Voltar</a>
  </div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>

</body>
</html>
