<?php
session_start();
include 'conexao.php';
include 'login_helper.php';

$erroLogin = false;
$login_sucesso = false;

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

                // Aqui, sinaliza que o login foi sucesso e exibe o alerta na mesma página
                $login_sucesso = true;

                // NÃO faz header redirecionando para pagina-inicial-adm.php aqui
                // Redirecionaremos via JS após SweetAlert
            } else {
                $_SESSION['tentativas']++;
                registrarTentativaLogin($email);
                header("Location: login.php?erro=1");
                exit;
            }
        } else {
            $_SESSION['tentativas']++;
            registrarTentativaLogin($email);
            header("Location: login.php?erro=1");
            exit;
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        </form>
      </div>
    </div>
  </div>

  <?php if ($login_sucesso): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success',
          title: 'Login realizado com sucesso!',
          confirmButtonText: 'Entrar',
          allowOutsideClick: false,
          allowEscapeKey: false,
        }).then(() => {
          // Redireciona para a página inicial após o usuário fechar o alerta
          window.location.href = "pagina-inicial-adm.php";
        });
      });
    </script>
  <?php endif; ?>

  <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Erro no login',
        text: 'Email ou senha incorretos.',
        confirmButtonColor: '#d33'
      });
    </script>
  <?php endif; ?>
</body>
</html>
