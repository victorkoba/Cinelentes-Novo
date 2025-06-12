<!DOCTYPE html> 
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/quem-somos.css">
    <script src="../js/main.js"></script>
    <link rel="icon" href="../img/favicon.ico" type="image/png">
</head>
<body class="body-pagina-inicial">

  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <a href="../index.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt=""></a>
    <!-- Botão hamburguer para mobile -->
    <button id="hamburguer" aria-label="Abrir menu" aria-expanded="false">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>

    <nav id="nav-menu">
      <a href="../index.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a href="#" class="dropbtn link-animado">EDIÇÕES</a>
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
  <script>
    const hamburguer = document.getElementById('hamburguer');
    const navMenu = document.getElementById('nav-menu');
    const dropdownBtn = document.querySelector('.dropbtn');
    const dropdownContent = document.getElementById('myDropdown');

    hamburguer.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('show');
      hamburguer.setAttribute('aria-expanded', isOpen);

      // Alterna classe 'open' para animação do botão
      hamburguer.classList.toggle('open');

      // Fecha dropdown quando abrir/fechar menu
      dropdownContent.classList.remove('show');
    });

    // Dropdown toggle mobile
    dropdownBtn.addEventListener('click', (e) => {
      e.preventDefault();
      dropdownContent.classList.toggle('show');
    });

    // Fecha dropdown se clicar fora
    window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropbtn')) {
        dropdownContent.classList.remove('show');
      }
    });
  </script>
  </header>

<main class="equipe-container">
    <h1 class="titulo-equipe">Conheça nossa Equipe</h1>

    <section class="secao-idealizadores">
        <h2 class="titulo-idealizadores">Idealizadores</h2>
        <div class="idealizadores">
            <div class="idealizador">
                <img class="imagem-idealizador" src="../img/sabrina.png" alt="Prof">
                <p class="nome-idealizador">Profª Sabrina Lina Figueiredo Gonçalves</p>
            </div>
            <div class="idealizador">
                <img class="imagem-idealizador" src="../img/jose.png" alt="Prof">
                <p class="nome-idealizador">Profº José Roberto de Lima</p>
            </div>
            <div class="idealizador">
                <img class="imagem-idealizador" src="../img/rogerio.png" alt="Prof">
                <p class="nome-idealizador">Profº Rogério de Souza Junior</p>
            </div>
        </div>
    </section>

    <section class="secao-desenvolvedores">
        <h2 class="titulo-desenvolvedores">Desenvolvido por</h2>
        <div class="desenvolvedores">
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/pedro.png" alt="Pedro">
                <p class="nome-desenvolvedor">Pedro Henrique de Petta Zocatelli</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/vitor.png" alt="Victor">
                <p class="nome-desenvolvedor">Victor Luiz Koba Batista</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/mi.png" alt="Miguel">
                <p class="nome-desenvolvedor">Miguel Francisco da Silva Sales</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/mat.png" alt="Matheus">
                <p class="nome-desenvolvedor">Matheus Arantes Villar</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/mur.png" alt="Murilo">
                <p class="nome-desenvolvedor">Murilo Ferreira Faria Santana</p>
            </div>
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