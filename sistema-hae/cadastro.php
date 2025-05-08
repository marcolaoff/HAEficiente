
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
    $perfil = $_POST["perfil"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];

    // Verificar se já existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
    $check->bind_param("ss", $usuario, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Usuário ou email já cadastrado.";
    } else {
        $aprovado = $perfil === "coordenador" ? 0 : 1;

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha, perfil, aprovado, telefone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $nome, $email, $usuario, $senha, $perfil, $aprovado, $telefone);
        
        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso.";
        } else {
            echo "Erro ao cadastrar.";
        }

        $stmt->close();
    }

    $check->close();
}
$conn->close();
?>
