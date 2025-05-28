<?php
$host = "localhost";
$dbname = "sistema_hae";
$username = "root";
$password = "";

// Conexão com o banco
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Caminho absoluto do projeto local
$base_url = "http://localhost/HAEficiente/sistema-hae";
?>
