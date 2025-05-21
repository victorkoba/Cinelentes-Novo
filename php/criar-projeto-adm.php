

<!DOCTYPE html> 
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../style/criar-projeto.css">
    <link rel="stylesheet" href="../style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/card-handler.js"></script>
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

<main class="main-container">
    <h1 class="titulo-pagina">CRIAR PROJETO</h1>
    <section class="secao-inicial">
        <div class="informacoes-iniciais">
            <input type="text" placeholder="Digite o título do projeto" class="input-titulo-projeto">
            <div class="linha-preta"></div>
            <textarea style="resize: vertical" placeholder="Digite aqui o conteúdo de apresentação do projeto. (Sobre e a data de realização do projeto)" class="textarea-conteudo-projeto"></textarea>
        </div>
        <div class="upload-final-video">
            <p>Faça o upload do vídeo final do projeto</p>
            <button class="botao-upload"> Upload de Vídeo</button>
        </div>
    </section>

    <section class="secao-conteudo">
    <div class="titulo-secao">
        <h2>Adicionar Conteúdo</h2>
        <div class="linha-preta"></div>
    </div>
    <div class="cards-container">
        <div class="content-card" id="fotos-card">
            <div class="card-header">
                <h3>Fotos</h3>
                <span class="close-card" onclick="minimizeCard('fotos-card')">×</span>
            </div>
            <div class="card-content">
                <p>Faça o upload das fotos</p>
                <button class="botao-upload">Upload de Fotos</button>
            </div>
        </div>
        <div class="content-card" id="videos-card">
            <div class="card-header">
                <h3>Vídeos</h3>
                <span class="close-card" onclick="minimizeCard('videos-card')">×</span>
            </div>
            <div class="card-content">
                <p>Faça o upload de vídeo</p>
                <button class="botao-upload">Upload de Vídeo</button>
                <button class="botao-upload">Upload por Link</button>
            </div>
        </div>
        <div class="content-card" id="curta-card">
            <div class="card-header">
                <h3>Curta-metragem</h3>
                <span class="close-card" onclick="minimizeCard('curta-card')">×</span>
            </div>
            <div class="card-content">
                <p>Faça o upload do curta-metragem</p>
                <button class="botao-upload">Upload de Vídeo</button>
                <button class="botao-upload">Upload por Link</button>
            </div>
        </div>
    </div>
</section>

    <section class="secao-musicas">
        <div class="titulo-secao">
            <h2>Músicas</h2>
            <div class="linha-preta"></div>
        </div>
        <div class="musica-item">
            <button class="botao-upload"> Upload de Link</button>
            <span class="icone-play">▶</span>
            <input type="text" placeholder="Digite o nome da Música" class="input-musica">
        </div>
        <div class="musica-item">
            <button class="botao-upload">Upload de Link</button>
            <span class="icone-play">▶</span>
            <input type="text" placeholder="Digite o nome da Música" class="input-musica">
        </div>
        <div class="musica-item">
            <button class="botao-upload"> Upload de Link</button>
            <span class="icone-play">▶</span>
            <input type="text" placeholder="Digite o nome da Música" class="input-musica">
        </div>
    </section>
    <section class="secao-habilidades">
        <div class="titulo-secao">
            <h2>Habilidades desenvolvidas</h2>
            <div class="linha-preta"></div>
        </div>
        <textarea style="resize: vertical" placeholder="Digite aqui as expectativas trabalhadas e as hashtags (se tiver)." class="textarea-habilidades"></textarea>
    </section>
    <section class="secao-feedback">
        <div class="titulo-secao">
            <h2>Deixe seu Feedback</h2>
            <div class="linha-preta"></div>
        </div>
        <textarea style="resize: vertical" placeholder="Suba o link do formulário do seu projeto para os alunos darem suas avaliações quanto ao projeto (Pode ser adicionado futuramente através da edição)." class="textarea-feedback"></textarea>
    </section>
    <section class="secao-feedback">
        <div class="titulo-secao">
            <h2>Agenda</h2>
            <div class="linha-preta"></div>
        </div>
        <textarea style="resize: vertical" placeholder="Digite a data de algum projeto que irá acontecer..." class="textarea-feedback"></textarea>
        <button class="botao-confirmar">Confirmar</button>
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