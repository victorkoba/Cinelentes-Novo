<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="icon" href="../img/favicon.ico" type="image/png">
  <link rel="stylesheet" href="../style/edicoes.css">
  <script src="../js/main.js"></script>
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
  <main class="main-acervos">
    <section class="acervo">
      <div class="titulo-acervo">
        <h1 class="titulo-acervo-h1">Acervo Cinelentes - 2024</h1>
      </div>
      <div class="cards">
      <?php
      include 'conexao.php';

      $sql = "
            SELECT id_acervo, titulo, descricao, foto_capa_acervo
            FROM acervos
            WHERE edicao = 2024
            ORDER BY id_acervo ASC
          ";

          $result = $conexao->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $titulo = $row['titulo'];
              $id = $row['id_acervo'];
              $caminhoImagem = $row['foto_capa_acervo']; // já é uma string
              $caminhoFisico = __DIR__ . '/' . $caminhoImagem;

              if (!empty($caminhoImagem) && file_exists($caminhoFisico)) {
                  $foto = $caminhoImagem;
              } else {
                  htmlspecialchars("Foto não encontrada."); // fallback
              }

          echo '
            <a href="ver-projeto.php?id=' . $id . '" class="card">
              <img src="' . htmlspecialchars($foto) . '" alt="' . htmlspecialchars($titulo) . '">
              <div class="card-text">' . htmlspecialchars($titulo) . '</div>
            </a>
          ';
        }
      } else {
        echo "<p>Sem projetos cadastrados ainda.</p>";
      }

      $conexao->close();
      ?>
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