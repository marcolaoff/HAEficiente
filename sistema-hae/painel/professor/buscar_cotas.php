<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'professor') {
    http_response_code(403);
    exit("Acesso não autorizado.");
}

if (!isset($_GET['edital_id'])) {
    http_response_code(400);
    exit("ID do edital não informado.");
}

$edital_id = intval($_GET['edital_id']);

$cotas = [];
$stmt = $conn->prepare("SELECT id, tipo_hae, curso, quantidade FROM cotas_hae WHERE edital_id = ?");
$stmt->bind_param("i", $edital_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cotas[] = $row;
}

$stmt->close();
$conn->close();

header("Content-Type: application/json");
echo json_encode($cotas);
