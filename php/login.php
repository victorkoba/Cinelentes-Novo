<?php
session_start();
include 'conexao.php';
include 'login_helper.php';

$erroLogin = false;

// Proteção contra força bruta
if (!isset($_SESSION['tentativas'])) {
    $_SESSION['tentativas'] = 0;
}

if ($_SESSION['tentativas'] >= 5) {
    die('Muitas tentativas de login. Tente novamente mais tarde.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM administradores WHERE email_adm = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $adm = $resultado->fetch_assoc();

            if (password_verify($senha, $adm['senha_adm'])) {
                $_SESSION['administrador'] = $adm['email_adm'];
                $_SESSION['id_usuario'] = $adm['id_adm'];
                $_SESSION['tentativas'] = 0;

                // Adiciona sucesso de login à sessão
                $_SESSION['login_sucesso'] = true;

                header('Location: pagina-inicial-adm.php');
                exit;
            } else {
                $_SESSION['tentativas']++;
                registrarTentativaLogin($email);
                redirectComErro(1);
            }
        } else {
            $_SESSION['tentativas']++;
            registrarTentativaLogin($email);
            redirectComErro(1);
        }
    }

    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 

</head>
<body class="body-login">
  <div class="card-login">
    <a href="../index.php" class="btn-voltar-card">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>

    <div class="container-login">
      <div class="lado-esquerdo">
        <div class="logo">
          <img id="imagem-logo" src="../img/logo-cinelentes-novo.png" alt="logo-cinelentes" />
        </div>
      </div>
      <div class="lado-direito">
        <form method="POST" class="login-form">
          <h2 class="texto-login">LOGIN</h2>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-email.png" alt="ícone email">
            <input class="input-email-senha" type="email" name="email" placeholder="Email" required
              value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
          </div>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-icon-senha.png" alt="ícone senha">
            <input class="input-email-senha" name="senha" type="password" placeholder="Senha" required />
          </div>

          <div class="alinhamento-botao">
            <button type="submit" class="botao-entrar" id="botao-entrar">ENTRAR</button>
          </div>

          <a href="redefinir-senha.php" class="bot-esqueceu-senha">Esqueceu a senha?</a>

          <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
            <p class="erro-login">Email ou senha incorretos.</p>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('.login-form').addEventListener('submit', function () {
      const botao = document.getElementById('botao-entrar');
      botao.disabled = true;
      botao.innerText = 'Entrando...';
    });
  </script>
</body>
</html>
