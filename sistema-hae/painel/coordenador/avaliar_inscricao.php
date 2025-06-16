<?php
require_once "../../config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["inscricao_id"]);
    $status = $_POST["status"];
    $comentario = trim($_POST["comentario"]);

    if ($id > 0 && in_array($status, ['pendente', 'aprovado', 'parcial', 'rejeitado'])) {
        $stmt = $conn->prepare("UPDATE inscricoes SET status = ?, comentario = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $comentario, $id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: avaliar.php");
exit();
