<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'professor') {
    header("Location: ../../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $edital_id = $_POST['edital_id'] ?? null;
    $titulo = trim($_POST['titulo'] ?? '');
    $justificativa = trim($_POST['justificativa'] ?? '');
    $objetivos = trim($_POST['objetivos'] ?? '');
    $metodologia = trim($_POST['metodologia'] ?? '');
    $resultados = trim($_POST['resultados'] ?? '');
    $cronograma = trim($_POST['cronograma'] ?? '');
    $arquivo_pdf = '';

    // Validar campos obrigatórios
    if (!$edital_id || !$titulo || !$justificativa || !$objetivos || !$metodologia || !$resultados || !$cronograma) {
        echo "Preencha todos os campos obrigatórios.";
        exit;
    }

    // Upload do PDF
    if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['arquivo_pdf']['name'], PATHINFO_EXTENSION));
        if ($extensao !== 'pdf') {
            echo "Apenas arquivos PDF são permitidos.";
            exit;
        }

        $nome_arquivo = uniqid("proposta_", true) . ".pdf";
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
    }

    // Inserção no banco
    $stmt = $conn->prepare("INSERT INTO inscricoes 
        (usuario_id, edital_id, titulo, justificativa, objetivos, metodologia, resultados, cronograma, arquivo_pdf, status, data_envio) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendente', NOW())");

    $stmt->bind_param("iisssssss", 
        $usuario_id, $edital_id, $titulo, 
        $justificativa, $objetivos, $metodologia, 
        $resultados, $cronograma, $arquivo_pdf);

    if ($stmt->execute()) {
        header("Location: ../professor/confirma-inscricao.php");
        exit;
    } else {
        echo "Erro ao salvar inscrição: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
