<?php
require_once "../../config.php";
session_start();

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if (!empty($titulo) && isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $arquivoTmp = $_FILES['arquivo']['tmp_name'];
        $nomeOriginal = $_FILES['arquivo']['name'];
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        if ($extensao === 'pdf') {
            $novoNome = uniqid('edital_', true) . '.pdf';
            $pastaArquivos = '../../arquivos/';
            $caminho = $pastaArquivos . $novoNome;

            if (!is_dir($pastaArquivos)) {
                mkdir($pastaArquivos, 0755, true);
            }

            if (move_uploaded_file($arquivoTmp, $caminho)) {
                $stmt = $conn->prepare("INSERT INTO editais (titulo, descricao, arquivo_pdf, data_publicacao) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $titulo, $descricao, $novoNome);

                if ($stmt->execute()) {
                    $edital_id = $stmt->insert_id;
                    $stmt->close();

                    if (isset($_POST['tipo_hae'])) {
                        for ($i = 0; $i < count($_POST['tipo_hae']); $i++) {
                            $tipo_hae = trim($_POST['tipo_hae'][$i]);
                            $curso = trim($_POST['curso'][$i]);
                            $quantidade = intval($_POST['quantidade'][$i]);

                            if (!empty($tipo_hae) && !empty($curso) && $quantidade > 0) {
                                $stmtCota = $conn->prepare("INSERT INTO cotas_hae (edital_id, tipo_hae, curso, quantidade) VALUES (?, ?, ?, ?)");
                                $stmtCota->bind_param("issi", $edital_id, $tipo_hae, $curso, $quantidade);
                                $stmtCota->execute();
                                $stmtCota->close();
                            }
                        }
                    }

                    header("Location: confirmacao-edital.php");
                    exit;
                } else {
                    $erro = "Erro ao salvar o edital no banco.";
                }
            } else {
                $erro = "Erro ao mover o arquivo para a pasta.";
            }
        } else {
            $erro = "O arquivo deve ser um PDF.";
        }
    } else {
        $erro = "Preencha todos os campos obrigatórios e selecione um arquivo válido.";
    }
}
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
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: var(--cor-fundo); color: var(--cor-texto); }
    header { background-color: var(--cor-secundaria); padding: 10px 40px; display: flex; justify-content: space-between; align-items: center; }
    header img { height: 60px; }
    .banner { text-align: center; padding: 30px 20px; background-color: var(--cor-primaria); color: white; }
    .container { max-width: 900px; margin: 40px auto; background-color: var(--cor-branca); padding: 40px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input[type="text"], input[type="file"], input[type="number"], textarea, select {
      width: 100%; padding: 12px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;
    }
    button { margin-top: 30px; width: 100%; background-color: var(--cor-primaria); color: white; padding: 14px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; }
    button:hover { background-color: #8f1011; }
    .footer { text-align: center; margin-top: 40px; font-size: 13px; color: white; background-color: var(--cor-secundaria); padding: 15px; }
    .erro { color: red; text-align: center; margin-top: 10px; }
    .cota-block { border: 1px solid #ccc; padding: 15px; border-radius: 8px; margin-top: 20px; }
  </style>
</head>
<body>
  <header>
    <img src="imagens/logo_sp.jpeg" alt="Logo SP" />
    <img src="imagens/logo_fatec.jpeg" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner"><h1>Publicar Novo Edital</h1></div>

  <div class="container">
    <h2>Cadastro de Edital de HAEs</h2>

    <?php if (!empty($erro)): ?>
      <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
      <label for="titulo">Título do Edital</label>
      <input type="text" id="titulo" name="titulo" required />

      <label for="descricao">Descrição / Observações</label>
      <textarea id="descricao" name="descricao"></textarea>

      <label for="arquivo">Anexar Arquivo (PDF)</label>
      <input type="file" id="arquivo" name="arquivo" accept=".pdf" required />

      <h3>Cotas de HAE</h3>
      <div id="cotas-container">
        <!-- Primeiro bloco já renderizado -->
        <div class="cota-block">
          <label>Tipo de HAE</label>
          <input type="text" name="tipo_hae[]" required>

          <label>Curso</label>
          <select name="curso[]" required>
            <option value="">Selecione o curso</option>
            <option value="Gestão da Produção Industrial">Gestão da Produção Industrial</option>
            <option value="Gestão Empresarial">Gestão Empresarial</option>
            <option value="GTI">GTI</option>
            <option value="DSM">DSM</option>
          </select>

          <label>Quantidade de HAEs</label>
          <input type="number" name="quantidade[]" min="1" required>
        </div>
      </div>

      <button type="button" onclick="adicionarCota()">+ Adicionar Nova Cota</button>

      <button type="submit">Publicar Edital</button>
    </form>
  </div>

  <div class="footer">&copy; 2025 Fatec Itapira – Sistema HAE</div>

  <script>
    function adicionarCota() {
      const container = document.getElementById('cotas-container');

      const bloco = document.createElement('div');
      bloco.classList.add('cota-block');
      bloco.innerHTML = `
        <label>Tipo de HAE</label>
        <input type="text" name="tipo_hae[]" required>

        <label>Curso</label>
        <select name="curso[]" required>
          <option value="">Selecione o curso</option>
          <option value="Gestão da Produção Industrial">Gestão da Produção Industrial</option>
          <option value="Gestão Empresarial">Gestão Empresarial</option>
          <option value="GTI">GTI</option>
          <option value="DSM">DSM</option>
        </select>

        <label>Quantidade de HAEs</label>
        <input type="number" name="quantidade[]" min="1" required>
      `;
      container.appendChild(bloco);
    }
  </script>

</body>
</html>
