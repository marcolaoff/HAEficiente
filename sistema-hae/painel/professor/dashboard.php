<?php
require_once "../../config.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar propostas do professor logado
$sql = "SELECT p.*, e.titulo AS edital_titulo FROM propostas p 
        JOIN editais e ON p.id_usuario = ? AND e.id = p.edital_id
        ORDER BY p.data_envio DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Professor</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Suas Propostas Submetidas</h2>
    <table>
        <thead>
            <tr>
                <th>Edital</th>
                <th>Título</th>
                <th>Status</th>
                <th>Enviada em</th>
                <th>Ver Mais</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['edital_titulo']); ?></td>
                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['data_envio'])); ?></td>
                <td><a href="resumo-projeto.php?id=<?php echo $row['id']; ?>">Detalhes</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
