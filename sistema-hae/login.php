
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
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, nome, perfil, senha, aprovado, status FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $dados = $resultado->fetch_assoc();

        if ($senha === $dados["senha"]) {
            if ($dados["status"] === "inativo") {
                echo "Usuário inativo. Contate o administrador.";
            } elseif ($dados["perfil"] === "coordenador" && $dados["aprovado"] == 0) {
                echo "Aguardando aprovação do administrador.";
            } else {
                $_SESSION["id"] = $dados["id"];
                $_SESSION["nome"] = $dados["nome"];
                $_SESSION["perfil"] = $dados["perfil"];

                if ($dados["perfil"] === "professor") {
                    header("Location: dashboard.html?tipo=professor");
                } elseif ($dados["perfil"] === "coordenador") {
                    header("Location: dashboard.html?tipo=coordenador");
                } elseif ($dados["perfil"] === "admin") {
                    header("Location: admin_painel.html");
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
