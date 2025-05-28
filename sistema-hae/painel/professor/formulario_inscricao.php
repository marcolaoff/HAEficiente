<?php
session_start();
require_once "../../config.php"; // Caminho relativo à raiz do projeto
if (!isset($_SESSION["id"])) {
    header("Location: {$base_url}/login.html");
    exit();
}
?>


// Buscar editais ativos
$editais = [];
$sql = "SELECT id, titulo FROM editais WHERE ativo = 1 ORDER BY data_publicacao DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $editais[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição de Projeto</title>
</head>
<body>
    <h2>Inscrição de Projeto HAE</h2>
    <form action="salvar_inscricao.php" method="POST" enctype="multipart/form-data">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>" readonly><br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone" value="<?php echo htmlspecialchars($_SESSION['usuario_telefone']); ?>" readonly><br><br>

        <label>Selecionar Edital:</label><br>
        <select name="edital_id" required>
            <option value="">Selecione um edital</option>
            <?php foreach ($editais as $edital): ?>
                <option value="<?php echo $edital['id']; ?>"><?php echo htmlspecialchars($edital['titulo']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Título do Projeto:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Descrição do Projeto:</label><br>
        <textarea name="descricao" rows="5" cols="50" required></textarea><br><br>

        <label>Anexar Proposta (PDF):</label><br>
        <input type="file" name="arquivo_pdf" accept=".pdf"><br><br>

        <button type="submit">Enviar Inscrição</button>
    </form>
</body>
</html>
