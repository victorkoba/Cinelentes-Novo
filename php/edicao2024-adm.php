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
    <a href="pagina-inicial-adm.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="edicao2023-adm.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="edicao2024-adm.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="edicao2025-adm.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="quem-somos-adm.php" class="link-animado">QUEM SOMOS</a>
      <a href="pagina-inicial-adm.php#grid-agenda" class="link-animado">AGENDA</a>
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
          <img src="../img/img-mes-mulher-2024.jpg" alt="Festival Mês da Mulher">
          <div class="card-text">7° Festival Cinelentes<br>Mês da Mulher</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-mes-povos-originarios-2024.jpg" alt="Festival Povos Originários">
          <div class="card-text">8° Festival Cinelentes<br>Povos Originários</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-mes-cultura-coreana.jpg" alt="Festival Cultura Coreana">
          <div class="card-text">9° Festival Cinelentes<br>Cultura Coreana</div>
        </a>

        <a href="mes-mulher.php" class="card">
          <img src="../img/img-mes-comunicacao-nao-violenta-2024.jpg" alt="Festival Comunicação não Violenta">
          <div class="card-text">10° Festival Cinelentes<br>Comunicação não Violenta</div>
        </a>
      </div>
    </section>
  </main>

  <footer class="footer-container">
    <div class="footer-topo">
        <div class="div-vazia"></div>
        <div class="footer-logo-container">
            <img id="logo-cinelentes-footer" src="../img/logo-cinelentes-novo.png" alt="CineLentes">
        </div>

        <div class="botao-login-container">
          <a href="../index.php" class="botao-login">Logout</a>
        </div>
    </div>

    <div class="linha-branca-footer"></div>

    <div class="linha-preta-footer">
        <p class="footer-direitos">Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>