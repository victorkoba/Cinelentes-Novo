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
        <h1 class="titulo-acervo-h1">Acervo Cinelentes - 2025</h1>
      </div>
      <div class="cards">
      <?php
      include 'conexao.php';

      // Pegando o primeiro registro de imagem associada ao acervo (se existir)
      $sql = "
        SELECT a.id_acervo, a.titulo, a.descricao, f.dados, f.tipo_arquivo
        FROM acervos a
        LEFT JOIN (
          SELECT acervo_id, dados, tipo_arquivo
          FROM fotos_acervo
          GROUP BY acervo_id
        ) f ON a.id_acervo = f.acervo_id
        WHERE a.edicao = 2025
        ORDER BY a.id_acervo ASC
      ";

      $result = $conexao->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $titulo = $row['titulo'];
          $id = $row['id_acervo'];

          // Se houver foto no banco, converte para base64
          if (!empty($row['dados'])) {
            $tipo = $row['tipo_arquivo'];
            $foto_base64 = 'data:' . $tipo . ';base64,' . base64_encode($row['dados']);
          } else {
            // Caso não tenha imagem no banco, usa uma imagem padrão
            $foto_base64 = './img/img-icon-avatar.png';
          }

          echo '
            <a href="ver-projeto.php?id=' . $id . '" class="card">
              <img src="' . htmlspecialchars($foto_base64) . '" alt="' . htmlspecialchars($titulo) . '">
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