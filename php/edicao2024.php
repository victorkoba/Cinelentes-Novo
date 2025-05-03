<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/edicoes.css"> 
    <script src="../js/main.js"></script>
</head>
<body class="body-pagina-inicial">
    
<header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="">
    <nav>
      <a href="../index.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="edicao2023.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="edicao2024.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="edicao2025.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="quem-somos.php" class="link-animado">QUEM SOMOS</a>
      <a href="../index.php#grid-agenda" class="link-animado">AGENDA</a>
    </nav>
  </header>
    <main class="main-acervos">
    <section class="acervo">
      <div class="titulo-acervo">
        <h1 class="titulo-acervo-h1">Acervo Cinelentes - 2024</h1>
        <div class="linha-preta-acervo-titulo"></div>
      </div>

      <div class="cards">
        <a href="mes-mulher.php" class="card">
          <img src="../img/img-mes-mulher.jpg" alt="Festival Mês da Mulher">
          <div class="card-text">1° Festival Cinelentes<br>Mês da Mulher</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-lgbt.jpg" alt="Festival LGBTQIAPN+">
          <div class="card-text">4° Festival Cinelentes<br>LGBTQIAPN+</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-povos-originarios.jpg" alt="Festival Povos Originários">
          <div class="card-text">2° Festival Cinelentes<br>Povos Originários</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-inclusao.jpg" alt="Festival Inclusão">
          <div class="card-text">5° Festival Cinelentes<br>Inclusão</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-mes-trabalho.jpg" alt="Festival Mês do Trabalho">
          <div class="card-text">3° Festival Cinelentes<br>Mês do Trabalho</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-consciencia-negra.jpg" alt="Festival Consciência Negra">
          <div class="card-text">6° Festival Cinelentes<br>Consciência Negra</div>
        </a>
      </div>
    </section>
  </main>

  <footer class="footer-container">
    <div class="footer-topo">
        <div class="div-vazia"></div>
        <div class="footer-logo-container">
            <img id="logo-cinelentes-footer" src="../img/logo-cinelentes.png" alt="CineLentes">
        </div>

        <div class="botao-login-container">
            <a href="login.php" class="botao-login">Login Administrador</a>
        </div>
    </div>

    <div class="linha-branca-footer"></div>

    <div class="linha-preta-footer">
        <p class="footer-direitos">Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>