<?php include 'verificar-login.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/edicoes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/main.js"></script>
</head>
<body class="body-pagina-inicial">

  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt=""></a>
    <!-- Botão hamburguer para mobile -->
    <button id="hamburguer" aria-label="Abrir menu" aria-expanded="false">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>

    <nav id="nav-menu">
      <a href="pagina-inicial-adm.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a href="#" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="edicao2023-adm.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="edicao2024-adm.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="edicao2025-adm.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
      <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
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
        <script>
          document.getElementById("botao-logout").addEventListener("click", function (e) {
              e.preventDefault();

              Swal.fire({
                  title: "Deseja sair da conta?",
                  text: "Você precisará fazer login novamente para continuar.",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Sim, sair"
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "logout.php";
                  }
              });
          });
        </script>
    </nav>
  </header>

    <main class="main-acervos">
        <section class="acervo">
            <div class="titulo-acervo">
                <div class="titulo-e-botao">
                    <h1 class="titulo-acervo-h1">Acervo Cinelentes - 2024</h1>
                </div>
                <div class="linha-preta-acervo-titulo"></div>
            </div>

            <div class="cards">
                <?php
                include 'conexao.php';

                $edicao = 2024;
                $sql = "SELECT * FROM acervos WHERE edicao = ? ORDER BY id_acervo DESC";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("i", $edicao);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $titulo = $row['titulo'];
                        $id = $row['id_acervo'];
                        $fotosArray = json_decode($row['fotos'], true);
                        $foto = isset($fotosArray[0]) ? $fotosArray[0] : '../img/img-icon-avatar.png';

                        echo '
    <div class="card">
      <img id="img-card" src="' . htmlspecialchars($foto) . '" alt="' . htmlspecialchars($titulo) . '">
      <div class="card-text">' . htmlspecialchars($titulo) . '</div>
      <div class="card-buttons">
        <a href="editar-projeto.php?id=' . $id . '" class="botao-editar">EDITAR</a>
        <button class="botao-excluir" onclick="confirmarExclusao(' . $id . ')">EXCLUIR</button>
      </div>
    </div>';
                    }
                } else {
                    echo '<p>Nenhum projeto encontrado para esta edição.</p>';
                }

                $stmt->close();
                $conexao->close();
                ?>
            </div>

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusao(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você não poderá reverter isso!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'excluir-projeto.php?id=' + id;
                }
            });
        }
    </script>

  <footer class="footer-container">
    <div class="footer-topo">
      <div class="footer-logo-container">
        <img id="logo-cinelentes-footer" src="../img/logo-cinelentes-novo.png" alt="Cinelentes">
      </div>
    </div>
    <div class="linha-branca-footer"></div>
    <div class="linha-preta-footer">
      <p class="footer-direitos">Todos os direitos reservados.</p>
    </div>
  </footer>

</body>
</html>
