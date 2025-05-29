
<?php
require_once "../../config.php";
session_start();
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_hae";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$usuarios = $conn->query("SELECT id, nome, email, perfil, status, aprovado FROM usuarios ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Painel Admin - Sistema HAE</title>
  <style>
    :root {
      --cor-primaria: #cc1719;
      --cor-secundaria: #000000;
      --cor-fundo: #f4f4f4;
      --cor-branca: #ffffff;
      --cor-texto: #333;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--cor-fundo);
      color: var(--cor-texto);
    }

    header {
      background-color: var(--cor-secundaria);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 40px;
    }

    header img {
      height: 60px;
    }

    .banner {
      text-align: center;
      padding: 30px 20px;
      background-color: var(--cor-primaria);
      color: white;
    }

    .banner h1 {
      margin: 0;
      font-size: 26px;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      background-color: var(--cor-branca);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: var(--cor-primaria);
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: var(--cor-primaria);
      color: white;
    }

    .btn {
      padding: 6px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      color: white;
      font-weight: bold;
    }

    .aprovar { background-color: #2e7d32; }
    .inativar { background-color: #c62828; }
    .ativar { background-color: #0277bd; }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 13px;
      color: white;
      background-color: var(--cor-secundaria);
      padding: 15px;
    }

    .msg {
      text-align: center;
      margin: 20px 0;
      font-weight: bold;
      color: green;
    }
  </style>
</head>
<body>
  <header>
    <img src="logo_sp.png" alt="Logo Governo SP" />
    <img src="logo_fatec.png" alt="Logo Fatec Itapira" />
  </header>

  <div class="banner">
    <h1>Painel do Administrador</h1>
  </div>

  <div class="container">
    <h2>Gerenciamento de Usuários</h2>
    <div class="msg" id="msg"></div>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Perfil</th>
          <th>Status</th>
          <th>Aprovado</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while($u = $usuarios->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($u['nome']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= $u['perfil'] ?></td>
          <td><?= $u['status'] ?></td>
          <td><?= ($u['perfil'] === 'coordenador' ? ($u['aprovado'] ? 'sim' : 'não') : '—') ?></td>
          <td>
            <?php if ($u['perfil'] === 'coordenador' && !$u['aprovado']): ?>
              <button class="btn aprovar" data-id="<?= $u['id'] ?>" data-acao="aprovar">Aprovar</button>
            <?php endif; ?>

            <?php if ($u['status'] === 'ativo'): ?>
              <button class="btn inativar" data-id="<?= $u['id'] ?>" data-acao="inativar">Inativar</button>
            <?php else: ?>
              <button class="btn ativar" data-id="<?= $u['id'] ?>" data-acao="ativar">Ativar</button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
<div style="text-align: center; margin: 30px 0;">
  <a href="../../logout.php" style="text-decoration: none;">
    <button class="btn inativar" style="padding: 12px 20px; font-size: 16px;">
      Sair do Sistema
    </button>
  </a>
</div>

  <div class="footer">
    &copy; 2025 Fatec Itapira – Sistema HAE
  </div>

  <script>
    document.querySelectorAll(".btn").forEach(botao => {
      botao.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        const acao = this.getAttribute("data-acao");

        fetch("gerenciar_usuarios.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `usuario_id=${id}&acao=${acao}`
        })
        .then(response => response.text())
        .then(msg => {
          document.getElementById("msg").innerText = msg;
          setTimeout(() => location.reload(), 1500);
        })
        .catch(err => {
          document.getElementById("msg").innerText = "Erro na requisição.";
        });
      });
    });
  </script>
</body>
</html>
