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
      <a href="pagina-inicial-adm.php#grid-agenda" class="link-animado">AGENDA</a>
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
      <a id="botao-logout" class="button-logout">Logout</a>
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
                <h1 class="titulo-acervo-h1">Acervo Cinelentes - 2025</h1>
                <a href="criar-projeto-adm.php" class="botao-criar-projeto">+ Criar Projeto</a>
            </div>
            <div class="linha-preta-acervo-titulo"></div>
        </div>

        <div class="cards">
            <!-- CARD 1 -->
            <div class="card">
                <img id="img-card" src="../img/img-mes-mulher.jpg" alt="1° Festival 2023">
                <div class="card-text">
                    1° Festival Cinelentes<br>Mês da Mulher
                </div>
                <div class="card-buttons">
                    <button class="botao-editar">EDITAR</button>
                    <button class="botao-excluir">EXCLUIR</button>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="card">
                <img id="img-card" src="../img/img-lgbt.jpg" alt="4° Festival 2023">
                <div class="card-text">
                    4° Festival Cinelentes<br>LGBTQIA+
                </div>
                <div class="card-buttons">
                    <button class="botao-editar">EDITAR</button>
                    <button class="botao-excluir">EXCLUIR</button>
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="card">
                <img id="img-card" src="../img/img-povos-originarios.jpg" alt="2° Festival 2023">
                <div class="card-text">
                    2° Festival Cinelentes<br>Povos Originários
                </div>
                <div class="card-buttons">
                    <button class="botao-editar">EDITAR</button>
                    <button class="botao-excluir">EXCLUIR</button>
                </div>
            </div>

            <!-- CARD 4 -->
            <div class="card">
                <img id="img-card" src="../img/img-inclusao.jpg" alt="5° Festival 2023">
                <div class="card-text">
                    5° Festival Cinelentes<br>Inclusão
                </div>
                <div class="card-buttons">
                    <button class="botao-editar">EDITAR</button>
                    <button class="botao-excluir">EXCLUIR</button>
                </div>
            </div>

            <!-- CARD 5 -->
            <div class="card">
                <img id="img-card" src="../img/img-mes-trabalho.jpg" alt="3° Festival 2023">
                <div class="card-text">
                    3° Festival Cinelentes<br>Mês do Trabalho
                </div>
                <div class="card-buttons">
                    <button class="botao-editar">EDITAR</button>
                    <button class="botao-excluir">EXCLUIR</button>
                </div>
            </div>

            <!-- CARD 6 -->
            <div class="card">
                <img id="img-card" src="../img/img-consciencia-negra.jpg" alt="6° Festival 2023">
                <div class="card-text">
                    6° Festival Cinelentes<br>Povos Conhecimento Negro
                </div>
                <div class="card-buttons">
                    <button class="botao-editar">EDITAR</button>
                    <button class="botao-excluir">EXCLUIR</button>
                </div>
            </div>
        </div>
    </section>
</main>

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
