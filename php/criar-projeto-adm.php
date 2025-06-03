<?php
include 'verificar-login.php';
include 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cinelentes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
  <link rel="stylesheet" href="../style/criar-projeto.css" />
  <link rel="stylesheet" href="../style/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/criar-projeto.js"></script>
  <style>
    .file-name {
      margin-top: 5px;
      font-style: italic;
      color: #333;
      font-size: 0.9rem;
    }
  </style>
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

<main class="main-container">
  <div class="titulo-secao">
  <div class="linha-titulo"></div>
    <h1 class="titulo-pagina">Criar Projeto</h1>
  </div>
  

  <form method="POST" action="salvar-projeto.php" enctype="multipart/form-data">
    <div class="select-edicao-container">
      <select class="select-edicao" name="edicao" id="edicao" required>
        <option class="option-edicao" value="" disabled selected>Selecionar ano de edição</option>
        <option value="2023">Edição 2023</option>
        <option value="2024">Edição 2024</option>
        <option value="2025">Edição 2025</option>
      </select>
    </div>

    <section class="secao-inicial">
      <div class="informacoes-iniciais">
        <input
          type="text"
          name="titulo"
          placeholder="Digite o título do projeto"
          class="input-titulo-projeto option-edicao"
          required
        />
        <div class="linha-preta"></div>
        <textarea
          name="conteudo"
          style="resize: vertical"
          placeholder="Digite aqui o conteúdo de apresentação do projeto. (Sobre e a data de realização do projeto)"
          class="textarea-conteudo-projeto option-edicao"
          required
        ></textarea>
      </div>
      <div class="upload-final-video">
        <p class="option-edicao">Faça o upload de uma imagem que ficará do lado do título e da descrição, além disso essa imagem que ficará na capa do card na página de edições.</p>
        <button type="button" class="botao-upload" data-type="video" data-target="final-video">Upload do Arquivo</button>
        <input accept="image/*" type="file" name="foto_capa_acervo" id="final-video" style="display:none" />
        <div id="final-video-name" class="file-name"></div>
      </div>
    </section>

    <section class="secao-conteudo">
      <div class="titulo-secao">
          <div class="linha-titulo"></div>
        <h2>Adicionar Fotos</h2>
      </div>
      <div class="cards-container">
        <div class="content-card" id="fotos-card">
          <div class="card-header">
            <h3>Fotos</h3>
          </div>
          <div class="card-content">
            <div class="div-p-upload">
              <p class="p-upload">Envie vários arquivos de uma vez.</p>
            </div>            
            <button type="button" class="botao-upload" data-type="photo" data-target="upload-fotos">Upload dos Arquivos</button>
            <input accept="image/*" type="file" name="fotos[]" id="upload-fotos" multiple style="display:none" />
            <div id="upload-fotos-name" class="file-name"></div>
          </div>
        </div>
      </div>
      <div class="titulo-secao">
          <div class="linha-titulo"></div>

        <h2>Adicionar Vídeos</h2>
      </div>
      <div class="cards-container">
      <div class="content-card" id="videos-card">
          <div class="card-header">
            <h3>Vídeos</h3>
          </div>
          <div class="card-content">
            <div class="div-p-upload">
              <p class="p-upload">Envie vários arquivos de uma vez.</p>
            </div>            
            <button type="button" class="botao-upload" data-type="video" data-target="upload-videos">Upload dos Arquivos</button>
            <input accept="video/*" type="file" name="videos[]" id="upload-videos" multiple style="display:none" />
            <div id="upload-videos-name" class="file-name"></div>
          </div>
        </div>
      </div>
      <div class="titulo-secao">
          <div class="linha-titulo"></div>

        <h2>Adicionar Curta-Metragem</h2>
      </div>
      <div class="cards-container">
      <div class="content-card" id="curta-card">
          <div class="card-header">
            <h3>Curta-metragem</h3>
          </div>
          <div class="card-content">
            <div class="div-p-upload">
              <p class="p-upload">Envie vários arquivos de uma vez.</p>
            </div>
            <button type="button" class="botao-upload" data-type="video" data-target="upload-curta">Upload dos Arquivos</button>
            <input accept="video/*" type="file" name="curta[]" id="upload-curta" multiple style="display:none" />
            <div id="upload-curta-name" class="file-name"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="secao-musicas">
      <div class="titulo-secao">
          <div class="linha-titulo"></div>

        <h2>Músicas</h2>
      </div>
        <!-- MÚSICA 1 -->
        <div class="musica-item">
          <input
            type="url"
            name="musica1"
            placeholder="Link do YouTube ou MP3"
            class="input-musica option-edicao"
            oninput="ativarBotaoMultimidia(this, 'play-musica1', 'musica1-container')"
          />
          <button
            type="button"
            id="play-musica1"
            class="botao-play"
            onclick="alternarMultimidia(this, 'musica1-container')"
            disabled
          >
            <span class="icone-play" role="img" aria-label="Ícone de play">▶</span> 

          </button>
          <div class="link-preview" id="musica1-container"></div>
        </div>
        <div class="musica-item">
          <input
            type="url"
            name="musica2"
            placeholder="Link do YouTube ou MP3"
            class="input-musica option-edicao"
            oninput="ativarBotaoMultimidia(this, 'play-musica2', 'musica2-container')"
          />
          <button
            type="button"
            id="play-musica2"
            class="botao-play"
            onclick="alternarMultimidia(this, 'musica2-container')"
            disabled
          >
            <span class="icone-play" role="img" aria-label="Ícone de play">▶</span> 
          </button>
          <div class="link-preview" id="musica2-container"></div>
        </div>
        <div class="musica-item">
          <input
            type="url"
            name="musica3"
            placeholder="Link do YouTube ou MP3"
            class="input-musica option-edicao"
            oninput="ativarBotaoMultimidia(this, 'play-musica3', 'musica3-container')"
          />
          <button
            type="button"
            id="play-musica3"
            class="botao-play"
            onclick="alternarMultimidia(this, 'musica3-container')"
            disabled
          >
            <span class="icone-play" role="img" aria-label="Ícone de play">▶</span> 
          </button>
          <div class="link-preview" id="musica3-container"></div>
        </div>
<script>
  function getYoutubeEmbedUrl(url) {
    const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w\-]+)/);
    if (match && match[1]) {
      return `https://www.youtube.com/embed/${match[1]}?autoplay=1`;
    }
    return null;
  }

  function isMp3Url(url) {
    return url.endsWith('.mp3');
  }

 function ativarBotaoMultimidia(input, botaoId, containerId) {
  const url = input.value.trim();
  const botao = document.getElementById(botaoId);
  const container = document.getElementById(containerId);

  const isYoutube = getYoutubeEmbedUrl(url) !== null;
  const isMp3 = isMp3Url(url);

  if (isYoutube || isMp3) {
    botao.disabled = false;
    botao.dataset.status = "parado";
    botao.dataset.url = url;
    botao.dataset.tipo = isYoutube ? "youtube" : "mp3";

    container.innerHTML = '';
  } else {
    botao.disabled = true;
    botao.dataset.url = "";
    botao.dataset.tipo = "";
    container.innerHTML = "";
  }
}
  function alternarMultimidia(botao, containerId) {
    const container = document.getElementById(containerId);
    const tipo = botao.dataset.tipo;
    const status = botao.dataset.status;
    const url = botao.dataset.url;

    if (status === "parado") {
      if (tipo === "youtube") {
        const embed = getYoutubeEmbedUrl(url);
        container.innerHTML = `
          <iframe width="300" height="80" 
            src="${embed}" frameborder="0" allow="autoplay" allowfullscreen>
          </iframe>`;
      } else if (tipo === "mp3") {
        container.innerHTML = `
          <audio controls autoplay>
            <source src="${url}" type="audio/mpeg">
            Seu navegador não suporta áudio.
          </audio>`;
      }
      botao.textContent = "⏸";
      botao.dataset.status = "tocando";
    } else {
      container.innerHTML = "";
      botao.textContent = "▶";
      botao.dataset.status = "parado";
    }
  }
</script>
</section>

    <section class="secao-habilidades">
      <div class="titulo-secao">
          <div class="linha-titulo"></div>

        <h2>Habilidades desenvolvidas</h2>
      </div>
      <textarea
        name="habilidades"
        style="resize: vertical"
        placeholder="Insira as habilidades desejadas, separando cada uma com vírgula. Ex.: habilidade 1, habilidade 2, habilidade 3, ..."
        class="textarea-habilidades option-edicao"
      ></textarea>
    </section>

    <section class="secao-feedback">
      <div class="titulo-secao">
          <div class="linha-titulo"></div>

        <h2>Deixe seu Feedback</h2>
      </div>
      <textarea
        name="feedback"
        style="resize: vertical"
        placeholder="Suba o link do formulário do seu projeto para os alunos darem suas avaliações quanto ao projeto (Pode ser adicionado futuramente através da edição)."
        class="textarea-feedback option-edicao"
      ></textarea>
      <div class="alinhamento-confirmar">
      <div class="alinhamento-confirmar">
  <button type="button" onclick="confirmarEnvio()"  class="botao-confirmar">Criar Projeto</button>
</div>

<!-- SCRIPT DO SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmarEnvio() {
    Swal.fire({
      title: "Tem certeza?",
      text: "Você deseja criar este projeto?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sim, criar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        // Envia o formulário
        document.querySelector("form").submit();
      }
    });
  }
</script> 
    </section>
  </form>
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