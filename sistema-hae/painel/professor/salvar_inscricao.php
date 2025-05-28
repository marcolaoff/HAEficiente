<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Verifica se os campos foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $edital_id = $_POST['edital_id'] ?? 1; // padrão 1 por enquanto
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $arquivo_pdf = '';

    // Upload do arquivo (se houver)
    if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === 0) {
        $pasta_destino = "../../uploads/";
        if (!file_exists($pasta_destino)) {
            mkdir($pasta_destino, 0777, true);
        }
        $nome_arquivo = basename($_FILES['arquivo_pdf']['name']);
        $caminho_arquivo = $pasta_destino . time() . "_" . $nome_arquivo;
        if (move_uploaded_file($_FILES['arquivo_pdf']['tmp_name'], $caminho_arquivo)) {
            $arquivo_pdf = $caminho_arquivo;
        }
    }

    // Inserção no banco
    $stmt = $conn->prepare("INSERT INTO inscricoes (usuario_id, edital_id, titulo, descricao, arquivo_pdf) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $usuario_id, $edital_id, $titulo, $descricao, $arquivo_pdf);

    if ($stmt->execute()) {
        header("Location: ../professor/confirma-inscricao.php");
        exit();
    } else {
        echo "Erro ao enviar inscrição: " . $conn->error;
    }
}
?>
