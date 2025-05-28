
<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_hae";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["proposta_id"];
    $acao = $_POST["acao"];
    $comentario = $_POST["comentario"] ?? null;
    $proposta_alternativa = $_POST["proposta_alternativa"] ?? null;

    $novo_status = "";

    if ($acao === "aprovar") {
        $novo_status = "aprovado";
    } elseif ($acao === "rejeitar") {
        $novo_status = "rejeitado";
    } elseif ($acao === "propor") {
        $novo_status = "parcial";
    } else {
        die("Ação inválida.");
    }

    $stmt = $conn->prepare("
        UPDATE propostas 
        SET status = ?, comentario = ?, proposta_alternativa = ?
        WHERE id = ?
    ");
    $stmt->bind_param("sssi", $novo_status, $comentario, $proposta_alternativa, $id);

    if ($stmt->execute()) {
        echo "Proposta atualizada com sucesso.";
    } else {
        echo "Erro ao atualizar proposta.";
    }

    $stmt->close();
}
$conn->close();
?>
