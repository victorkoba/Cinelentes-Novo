<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="body-redefinir-senha">
    
  <div class="card-redefinir-senha">
    <div class="container-redefinir-senha">
      <div class="lado-esquerdo">
        <div class="logo">
          <img id="imagem-logo" src="../img/logo-cinelentes-novo.png" alt="logo-cinelentes" />
        </div>
      </div>

      <div class="lado-direito">
      <div class="voltar">
        <a href="login.php">
          <i class="fas fa-arrow-left"></i> Voltar para o login
        </a>
      </div>
        <form class="redefinir-senha-form">
          <h2 class="texto-redefinir-senha">REDEFINIR SENHA</h2>

          <div class="input-inform-redefinir-senha">
            <img class="img-icon" src="../img/img-email.png" alt="">
            <input class="input-email-redefinir-senha" type="email" placeholder="Insira seu e-mail para receber o código" required />
          </div>

          <button type="submit" class="botao-enviar">ENVIAR</button>

    
        </form>
      </div>
    </div>
  </div>
</body>
</html>
