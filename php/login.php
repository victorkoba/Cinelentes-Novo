<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            // ATENÇÃO: Aqui a senha no banco está salva como texto puro ('30012008')
            // Mas password_verify só funciona se a senha estiver criptografada com password_hash()
            if ($password === $adm['senha_adm']) { // Usando comparação direta já que sua senha não está criptografada
                $_SESSION['administrador'] = $adm['email_adm']; // Ou outro nome fixo, pois não há nome no banco
                $_SESSION['id_usuario'] = $adm['id_adm'];

                header('Location: pagina-inicial-adm.php');
                exit;
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function(){
                            Swal.fire({
                                title: 'Senha incorreta!',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = 'index.php';
                            });
                        });
                    </script>";
            }
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function(){
                        Swal.fire({
                            title: 'Usuário não encontrado!',
                            icon: 'error',
                            confirmButtonText: 'Voltar'
                        }).then(function() {
                            window.location.href = 'index.php';
                        });
                    });
                </script>";
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }

    $conexao->close();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 
</head>
<body class="body-login">
    
  <div class="card-login">
    <div class="container-login">
      <div class="lado-esquerdo">
        <div class="logo">
          <img id="imagem-logo" src="../img/logo-cinelentes-novo.png" alt="logo-cinelentes" />
        </div>
      </div>
      <div class="lado-direito">
        <div class="voltar">
          <a href="../index.php">
            <i class="fas fa-arrow-left"></i> Voltar para página inicial
          </a>
        </div>
        <form action="" method="POST" class="login-form">
          <h2 class="texto-login">LOGIN</h2>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-email.png" alt="">
            <input class="input-email-senha" type="email" name="email" placeholder="Email" required />
          </div>

          <div class="input-inform">
            <img class="img-icon" src="../img/img-icon-senha.png" alt="">
            <input class="input-email-senha" name="senha" type="password" placeholder="Senha" required />
          </div>

          <a href="pagina-inicial-adm.php" class="botao-entrar">ENTRAR</a>
          <a href="redefinir-senha.php" class="bot-esqueceu-senha">Esqueceu a senha?</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
