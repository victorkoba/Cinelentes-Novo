<?php
// Inicia a sessão, se ainda não foi iniciado
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Administrador</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css"> 
</head>
<body class="body-login">

  <div class="card-login">
    <div class="container-login">
      <div class="lado-esquerdo">
        <div class="logo">
          <img id="imagem-logo" src="../img/logo-cinelentes.png" alt="logo-cinelentes" />
        </div>
      </div>
      <div class="lado-direito">
        <!-- Formulário de login -->
        <form action="login.php" method="POST" class="login-form">
          <h2 class="texto-login">LOGIN</h2>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-email.png" alt="">
            <input class="input-email-senha" type="email" name="email" placeholder="Email" required />
          </div>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-icon-senha.png" alt="">
            <input class="input-email-senha" name="senha" type="password" placeholder="Senha" required />
          </div>

          <button type="submit" class="botao-entrar">ENTRAR</button>
          <a href="cadastro.php" class="bot-esqueceu-senha">Não tem conta?</a>
        </form>
      </div>
    </div>
  </div>

</body>
</html>

<?php
// Processamento do formulário de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexao.php'; // Inclua a conexão com o banco de dados

    $email = $_POST['email'];
    $password = $_POST['senha'];

    // Verifica no banco de dados
    $sql = "SELECT * FROM administradores WHERE email_adm = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar o email no banco de dados
        if ($result && $result->num_rows > 0) {
            $adm = $result->fetch_assoc();

            // Verifica a senha criptografada
            if (password_verify($password, $adm['senha_adm'])) {
                $_SESSION['administrador'] = $adm['email_adm'];
                $_SESSION['id_usuario'] = $adm['id_adm'];

                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function(){
                            Swal.fire({
                                title: 'Login realizado com sucesso!',
                                icon: 'success',
                                confirmButtonText: 'Continuar'
                            }).then(function() {
                                window.location.href = 'pagina-inicial-adm.php'; // Redireciona para a página principal do admin
                            });
                        });
                      </script>";
                exit;
            }
        }

        // Se a senha ou email estiverem incorretos
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        title: 'Email ou senha incorretos!',
                        icon: 'error',
                        confirmButtonText: 'Tentar novamente'
                    }).then(function() {
                        window.location.href = 'login.php'; // Redireciona para o login novamente
                    });
                });
              </script>";

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }

    $conexao->close();
}
?>
