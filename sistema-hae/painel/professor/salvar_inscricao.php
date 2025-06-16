<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'professor') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $edital_id = $_POST['edital_id'] ?? null;

    // Novos campos do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $rg = trim($_POST['rg']);
    $matricula = trim($_POST['matricula']);
    $tipo_hae = trim($_POST['tipo_hae']);
    $quantidade_hae = intval($_POST['quantidade_hae']);
    $projeto_interesse = trim($_POST['projeto_interesse']);
    $periodo_inicio = $_POST['periodo_inicio'];
    $periodo_fim = $_POST['periodo_fim'];
    $horarios_aula = trim($_POST['horarios_aula']);
    $horario_execucao = trim($_POST['horario_execucao']);
    $metas = trim($_POST['metas']);
    $objetivos = trim($_POST['objetivos']);
    $justificativa = trim($_POST['justificativa']);
    $recursos = trim($_POST['recursos']);
    $resultado_esperado = trim($_POST['resultado_esperado']);
    $metodologia = trim($_POST['metodologia']);
    $cronograma = trim($_POST['cronograma']);
    $arquivo_pdf = '';

    // Upload do arquivo PDF
    if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['arquivo_pdf']['name'], PATHINFO_EXTENSION));
        if ($extensao !== 'pdf') {
            echo "Somente arquivos PDF são permitidos.";
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
            echo "Erro ao enviar o arquivo.";
            exit;
        }
    }

    // Inserção no banco com os novos campos
    $stmt = $conn->prepare("INSERT INTO inscricoes 
    (usuario_id, edital_id, nome, email, rg, matricula, tipo_hae, quantidade_hae, projeto_interesse, 
    periodo_inicio, periodo_fim, horarios_aula, horario_execucao, metas, objetivos, justificativa, recursos, 
    resultado_esperado, metodologia, cronograma, arquivo_pdf, status, data_envio) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendente', NOW())");

    $stmt->bind_param("iisssssssssssssssssss",
        $usuario_id, $edital_id, $nome, $email, $rg, $matricula, $tipo_hae, $quantidade_hae, $projeto_interesse, 
        $periodo_inicio, $periodo_fim, $horarios_aula, $horario_execucao, $metas, $objetivos, $justificativa, $recursos, 
        $resultado_esperado, $metodologia, $cronograma, $arquivo_pdf
    );

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
