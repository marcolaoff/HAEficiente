<?php
session_start();

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_hae";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_login = $_POST["usuario"];
    $senha_login = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, nome, perfil, senha, aprovado, status FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario_login);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $dados = $resultado->fetch_assoc();

        if (password_verify($senha_login, $dados["senha"])) {
            if ($dados["status"] === "inativo") {
                echo "Usuário inativo. Contate o administrador.";
            } elseif ($dados["perfil"] === "coordenador" && $dados["aprovado"] == 0) {
                echo "Aguardando aprovação do administrador.";
            } else {
                $_SESSION["usuario_id"] = $dados["id"];
                $_SESSION["usuario_nome"] = $dados["nome"];
                $_SESSION["perfil"] = $dados["perfil"];

                if ($dados["perfil"] === "professor") {
                    header("Location: painel/professor/dashboard.php");
                } elseif ($dados["perfil"] === "coordenador") {
                    header("Location: painel/coordenador/dashboard.php");
                } elseif ($dados["perfil"] === "admin") {
                    header("Location: painel/admin/admin_painel.php");
                }
                exit();
            }
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
}
$conn->close();
?>
