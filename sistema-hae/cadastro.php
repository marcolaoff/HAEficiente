<?php
require_once "config.php";
session_start();

$conn = new mysqli("localhost", "root", "", "sistema_hae");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $perfil = $_POST["perfil"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $telefone = $_POST["telefone"];

    $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
    $check->bind_param("ss", $usuario, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Usuário ou email já cadastrado.'); window.location.href='cadastro.html';</script>";
    } else {
        $aprovado = ($perfil === "coordenador") ? 0 : 1;

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha, perfil, aprovado, telefone) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $nome, $email, $usuario, $senha, $perfil, $aprovado, $telefone);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar.'); window.location.href='cadastro.html';</script>";
        }

        $stmt->close();
    }

    $check->close();
}
$conn->close();
?>
