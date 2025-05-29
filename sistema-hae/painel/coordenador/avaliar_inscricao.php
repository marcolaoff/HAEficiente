<?php
require_once "../../config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? 0;
    $status = $_POST["status"] ?? '';
    $comentario = $_POST["comentario"] ?? '';

    if ($id && in_array($status, ['pendente', 'aprovado', 'parcial', 'rejeitado'])) {
        $stmt = $conn->prepare("UPDATE inscricoes SET status = ?, comentario = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $comentario, $id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: inscricoes.php");
exit();
