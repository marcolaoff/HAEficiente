
<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_hae";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_POST["usuario_id"];
    $acao = $_POST["acao"];

    if (!in_array($acao, ["aprovar", "ativar", "inativar"])) {
        die("Ação inválida.");
    }

    if ($acao === "aprovar") {
        $stmt = $conn->prepare("UPDATE usuarios SET aprovado = 1 WHERE id = ?");
    } elseif ($acao === "ativar") {
        $stmt = $conn->prepare("UPDATE usuarios SET status = 'ativo' WHERE id = ?");
    } elseif ($acao === "inativar") {
        $stmt = $conn->prepare("UPDATE usuarios SET status = 'inativo' WHERE id = ?");
    }

    $stmt->bind_param("i", $usuario_id);

    if ($stmt->execute()) {
        echo "Ação realizada com sucesso.";
    } else {
        echo "Erro ao executar ação.";
    }

    $stmt->close();
}
$conn->close();
?>
