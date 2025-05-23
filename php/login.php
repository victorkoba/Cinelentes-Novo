<?php
session_start();

// Processamento do formulário de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexao.php';

    $email = $_POST['email'];
    $password = $_POST['senha'];

    $sql = "SELECT * FROM administradores WHERE email_adm = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $adm = $result->fetch_assoc();

            if (password_verify($password, $adm['senha_adm'])) {
                $_SESSION['administrador'] = $adm['email_adm'];
                $_SESSION['id_usuario'] = $adm['id_adm'];
                header('Location: pagina-inicial-adm.php');
                exit;
            } else {
                // Senha incorreta
                header('Location: login.php?erro=1');
                exit;
            }
        } else {
            // Email não encontrado
            header('Location: login.php?erro=1');
            exit;
        }
        $stmt->close();
    }

    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Administrador</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css">
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
            <input class="input-email-senha" type="email" name="email" placeholder="Email" required />
          </div>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-icon-senha.png" alt="ícone senha">
            <input class="input-email-senha" name="senha" type="password" placeholder="Senha" required />
          </div>

          <button type="submit" class="botao-entrar">ENTRAR</button>
          <a href="redefinir-senha.php" class="bot-esqueceu-senha">Esqueceu a senha?</a>
        </form>
      </div>
    </div>
  </div>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        title: 'Email ou senha incorretos!',
        icon: 'error',
        confirmButtonText: 'Tentar novamente'
      }).then(() => {
        // Remove o parâmetro da URL sem recarregar
        window.history.replaceState(null, null, 'login.php');
      });
    });
  </script>
<?php endif; ?>
</body>
</html>