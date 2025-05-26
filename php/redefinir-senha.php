<?php
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("localhost", "root", "", "cinelentes");

  if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
  }

  $email = $_POST["email"];
  $nova_senha = $_POST["nova_senha"];
  $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("SELECT id_adm FROM administradores WHERE email_adm = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->close();
    $update = $conn->prepare("UPDATE administradores SET senha_adm = ? WHERE email_adm = ?");
    $update->bind_param("ss", $senha_hash, $email);

    if ($update->execute()) {
      $mensagem = "sucesso";
    } else {
      $mensagem = "erro";
    }

    $update->close();
  } else {
    $mensagem = "nao_encontrado";
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="body-redefinir-senha">
  <div class="card-redefinir-senha">
    <a href="login.php" class="btn-voltar-card">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>
    <div class="container-redefinir-senha">
      <div class="lado-esquerdo">
        <div class="logo">
          <img id="imagem-logo" src="../img/logo-cinelentes-novo.png" alt="logo-cinelentes" />
        </div>
      </div>

      <div class="lado-direito">
        <form class="redefinir-senha-form" method="POST" action="">
          <h2 class="texto-redefinir-senha">REDEFINIR SENHA</h2>

          <div class="input-inform-redefinir-senha">
            <img class="img-icon" src="../img/img-email.png" alt="">
            <input class="input-email-redefinir-senha" type="email" name="email" placeholder="Insira seu e-mail" required />
          </div>

          <div class="input-inform-redefinir-senha">
            <img class="img-icon" src="../img/img-cadeado.png" alt="">
            <input class="input-email-redefinir-senha" type="password" name="nova_senha" placeholder="Nova senha" required />
          </div>

          <button type="submit" class="botao-enviar">REDEFINIR</button>
        </form>
      </div>
    </div>
  </div>

  <!-- SweetAlert Feedback -->
  <?php if (!empty($mensagem)) : ?>
    <script>
      <?php if ($mensagem === "sucesso"): ?>
        Swal.fire({
          icon: 'success',
          title: 'Senha redefinida com sucesso!',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = 'login.php';
        });
      <?php elseif ($mensagem === "erro"): ?>
        Swal.fire({
          icon: 'error',
          title: 'Erro ao atualizar a senha.',
          confirmButtonText: 'OK'
        });
      <?php elseif ($mensagem === "nao_encontrado"): ?>
        Swal.fire({
          icon: 'warning',
          title: 'E-mail não encontrado.',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>
    </script>
  <?php endif; ?>
</body>
</html>