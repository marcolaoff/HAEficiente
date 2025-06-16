<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'professor') {
    header("Location: ../../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $inscricao_id = $_POST['inscricao_id'] ?? null;
    $resumo = trim($_POST['resumo'] ?? '');
    $arquivo_pdf = '';

    if (!$inscricao_id || !$resumo) {
        echo "Preencha todos os campos obrigatórios.";
        exit;
    }

    // Upload do arquivo PDF
    if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['arquivo_pdf']['name'], PATHINFO_EXTENSION));
        if ($extensao !== 'pdf') {
            echo "Apenas arquivos PDF são permitidos.";
            exit;
        }

        $nome_arquivo = uniqid("relatorio_", true) . ".pdf";
        $pasta_destino = "../../uploads/";

        if (!file_exists($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }

        $caminho_arquivo = $pasta_destino . $nome_arquivo;
        if (move_uploaded_file($_FILES['arquivo_pdf']['tmp_name'], $caminho_arquivo)) {
            $arquivo_pdf = $nome_arquivo;
        } else {
            echo "Erro ao fazer upload do arquivo.";
            exit;
        }
    } else {
        echo "É necessário anexar o arquivo PDF.";
        exit;
    }

    // Inserir o relatório
    $stmt = $conn->prepare("INSERT INTO relatorios (id_inscricao, resumo, arquivo_pdf, data_envio) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $inscricao_id, $resumo, $arquivo_pdf);

    if ($stmt->execute()) {
        header("Location: confirma-relatorio.php");
        exit;
    } else {
        echo "Erro ao salvar o relatório: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
