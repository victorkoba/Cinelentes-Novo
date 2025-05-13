<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro de Administrador</title>
  <link rel="stylesheet" href="../style/style.css"/>
  <link rel="stylesheet" href="../style/login-redefinir-senha.css"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <form action="processa_cadastro.php" method="POST" class="login-form">
          <h2 class="texto-login">Cadastro de Administrador</h2>

          <div class="input-inform">
            <input class="input-email-senha" type="email" name="email" placeholder="Email" required />
          </div>

          <div class="input-inform">
            <input class="input-email-senha" name="senha" type="password" placeholder="Senha" required />
          </div>

          <button type="submit" class="botao-entrar">Cadastrar</button>
          <a href="login.php" class="bot-esqueceu-senha">Voltar ao login</a>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
