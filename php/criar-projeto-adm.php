<?php include 'verificar-login.php'; ?>
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
  <style>
    /* Estilo básico para mostrar o nome do arquivo */
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
  <img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" />
  <nav>
    <a href="pagina-inicial-adm.php" class="link-animado">INÍCIO</a>
    <div class="dropdown">
      <a onclick="myFunction()" class="dropbtn link-animado" tabindex="0" aria-haspopup="true" aria-expanded="false">EDIÇÕES</a>
      <div id="myDropdown" class="dropdown-content" aria-label="submenu de edições">
        <a href="edicao2023-adm.php" class="link-animado">EDIÇÃO 2023</a>
        <a href="edicao2024-adm.php" class="link-animado">EDIÇÃO 2024</a>
        <a href="edicao2025-adm.php" class="link-animado">EDIÇÃO 2025</a>
      </div>
    </div>
    <a href="pagina-inicial-adm.php#grid-agenda" class="link-animado">AGENDA</a>
    <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
    <a id="botao-logout" href="#" class="button-logout">Logout</a>
  </nav>
</header>

<main class="main-container">
  <h1 class="titulo-pagina">CRIAR PROJETO</h1>

  <!-- Formulário começa aqui -->
  <form method="POST" action="salvar-projeto.php" enctype="multipart/form-data">
    <section class="secao-inicial">
      <div class="informacoes-iniciais">
        <input
          type="text"
          name="titulo"
          placeholder="Digite o título do projeto"
          class="input-titulo-projeto"
          required
        />
        <div class="linha-preta"></div>
        <textarea
          name="conteudo"
          style="resize: vertical"
          placeholder="Digite aqui o conteúdo de apresentação do projeto. (Sobre e a data de realização do projeto)"
          class="textarea-conteudo-projeto"
          required
        ></textarea>
      </div>
      <div class="upload-final-video">
        <p>Faça o upload do vídeo final do projeto</p>
        <button type="button" class="botao-upload" data-type="video" data-target="final-video">Upload de Vídeo</button>
        <input type="file" accept="video/*" name="final_video" id="final-video" style="display:none" />
        <div id="final-video-name" class="file-name"></div>
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
            <button type="button" class="close-card" aria-label="Minimizar fotos" onclick="minimizeCard('fotos-card')">×</button>
          </div>
          <div class="card-content">
            <p>Faça o upload das fotos</p>
            <button type="button" class="botao-upload" data-type="photo" data-target="upload-fotos">Upload de Fotos</button>
            <input type="file" accept="image/*" name="fotos[]" id="upload-fotos" multiple style="display:none" />
            <div id="upload-fotos-name" class="file-name"></div>
          </div>
        </div>
        <div class="content-card" id="videos-card">
          <div class="card-header">
            <h3>Vídeos</h3>
            <button type="button" class="close-card" aria-label="Minimizar vídeos" onclick="minimizeCard('videos-card')">×</button>
          </div>
          <div class="card-content">
            <p>Faça o upload de vídeo</p>
            <button type="button" class="botao-upload" data-type="video" data-target="upload-videos">Upload de Vídeo</button>
            <input type="file" accept="video/*" name="videos[]" id="upload-videos" multiple style="display:none" />
            <div id="upload-videos-name" class="file-name"></div>

            <button type="button" class="botao-upload" data-action="link" data-link-type="vídeo" data-container-id="videos-card">Upload por Link</button>
            <div class="link-preview" id="videos-card-preview"></div>
          </div>
        </div>
        <div class="content-card" id="curta-card">
          <div class="card-header">
            <h3>Curta-metragem</h3>
            <button type="button" class="close-card" aria-label="Minimizar curta-metragem" onclick="minimizeCard('curta-card')">×</button>
          </div>
          <div class="card-content">
            <p>Faça o upload do curta-metragem</p>
            <button type="button" class="botao-upload" data-type="video" data-target="upload-curta">Upload de Vídeo</button>
            <input type="file" accept="video/*" name="curta" id="upload-curta" style="display:none" />
            <div id="upload-curta-name" class="file-name"></div>

            <button type="button" class="botao-upload" data-action="link" data-link-type="curta" data-container-id="curta-card">Upload por Link</button>
            <div class="link-preview" id="curta-card-preview"></div>
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
        <button type="button" class="botao-upload" data-action="link" data-link-type="música" data-container-id="musica1-container">Upload de Link</button>
        <span class="icone-play" role="img" aria-label="Ícone de play">▶</span>
        <input
          type="text"
          name="musica1"
          placeholder="Digite o nome da Música"
          class="input-musica"
        />
        <div class="link-preview" id="musica1-container"></div>
      </div>
      <div class="musica-item">
        <button type="button" class="botao-upload" data-action="link" data-link-type="música" data-container-id="musica2-container">Upload de Link</button>
        <span class="icone-play" role="img" aria-label="Ícone de play">▶</span>
        <input
          type="text"
          name="musica2"
          placeholder="Digite o nome da Música"
          class="input-musica"
        />
        <div class="link-preview" id="musica2-container"></div>
      </div>
      <div class="musica-item">
        <button type="button" class="botao-upload" data-action="link" data-link-type="música" data-container-id="musica3-container">Upload de Link</button>
        <span class="icone-play" role="img" aria-label="Ícone de play">▶</span>
        <input
          type="text"
          name="musica3"
          placeholder="Digite o nome da Música"
          class="input-musica"
        />
        <div class="link-preview" id="musica3-container"></div>
      </div>
    </section>

    <section class="secao-habilidades">
      <div class="titulo-secao">
        <h2>Habilidades desenvolvidas</h2>
        <div class="linha-preta"></div>
      </div>
      <textarea
        name="habilidades"
        style="resize: vertical"
        placeholder="Digite aqui as expectativas trabalhadas e as hashtags (se tiver)."
        class="textarea-habilidades"
      ></textarea>
    </section>

    <section class="secao-feedback">
      <div class="titulo-secao">
        <h2>Deixe seu Feedback</h2>
        <div class="linha-preta"></div>
      </div>
      <textarea
        name="feedback"
        style="resize: vertical"
        placeholder="Suba o link do formulário do seu projeto para os alunos darem suas avaliações quanto ao projeto (Pode ser adicionado futuramente através da edição)."
        class="textarea-feedback"
      ></textarea>
    </section>

    <section class="secao-feedback">
      <div class="titulo-secao">
        <h2>Agenda</h2>
        <div class="linha-preta"></div>
      </div>
      <textarea
        name="agenda"
        style="resize: vertical"
        placeholder="Digite a data de algum projeto que irá acontecer..."
        class="textarea-feedback"
      ></textarea>
      <button type="submit" class="botao-confirmar">Confirmar</button>
    </section>
  </form>
  <!-- Fim do formulário -->

</main>

<footer class="footer-container">
  <div class="footer-topo">
    <div class="footer-logo-container">
      <img id="logo-cinelentes-footer" src="../img/logo-cinelentes-novo.png" alt="Cinelentes" />
    </div>
  </div>
  <div class="linha-branca-footer"></div>
  <div class="footer-links-container">
    <div class="footer-links-box">
      <h3>Site</h3>
      <a href="#">Página Inicial</a>
      <a href="#">Agenda</a>
      <a href="#">Edições</a>
    </div>
    <div class="footer-links-box">
      <h3>Redes Sociais</h3>
      <a href="#">Instagram</a>
      <a href="#">YouTube</a>
      <a href="#">Facebook</a>
    </div>
    <div class="footer-links-box">
      <h3>Contato</h3>
      <a href="#">E-mail</a>
      <a href="#">Telefone</a>
      <a href="#">Endereço</a>
    </div>
  </div>
  <div class="footer-baixo">
    <p>© 2025 Cinelentes. Todos os direitos reservados.</p>
  </div>
</footer>

<script>
  // Função para abrir e fechar dropdown
  function myFunction() {
    const dropdown = document.getElementById("myDropdown");
    dropdown.classList.toggle("show");
  }

  window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
      const dropdowns = document.getElementsByClassName("dropdown-content");
      for (const dropdown of dropdowns) {
        if (dropdown.classList.contains('show')) {
          dropdown.classList.remove('show');
        }
      }
    }
  };

  // Minimizar cards
  function minimizeCard(id) {
    const card = document.getElementById(id);
    if (!card) return;
    const content = card.querySelector(".card-content");
    if (content.style.display === "none") {
      content.style.display = "block";
    } else {
      content.style.display = "none";
    }
  }

  // Botões de upload que disparam o input escondido
  document.querySelectorAll('button.botao-upload[data-type]').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      const inputFile = document.getElementById(targetId);
      if (inputFile) {
        inputFile.click();
      }
    });
  });

  // Mostrar nome dos arquivos selecionados
  function updateFileName(input, displayId) {
    const display = document.getElementById(displayId);
    if (!display) return;
    if (!input.files || input.files.length === 0) {
      display.textContent = '';
      return;
    }
    if (input.files.length === 1) {
      display.textContent = input.files[0].name;
    } else {
      display.textContent = `${input.files.length} arquivos selecionados`;
    }
  }

  // Atualiza nomes para todos inputs file
  document.querySelectorAll('input[type=file]').forEach(input => {
    input.addEventListener('change', () => {
      updateFileName(input, input.id + '-name');
    });
  });

  // Upload por link (prompt modal com SweetAlert)
  document.querySelectorAll('button.botao-upload[data-action="link"]').forEach(button => {
    button.addEventListener('click', async () => {
      const linkType = button.getAttribute('data-link-type') || 'vídeo';
      const containerId = button.getAttribute('data-container-id');
      if (!containerId) return;

      const { value: url } = await Swal.fire({
        title: `Coloque o link do ${linkType}`,
        input: 'url',
        inputLabel: `Link do ${linkType}:`,
        inputPlaceholder: `Digite ou cole o link do ${linkType}`,
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Você precisa colocar um link!';
          }
          try {
            new URL(value);
          } catch {
            return 'Por favor, coloque uma URL válida!';
          }
        }
      });

      if (url) {
        const container = document.getElementById(containerId);
        if (!container) return;

        // Limpa preview anterior
        container.innerHTML = '';

        // Detecta tipo de mídia: vídeo ou música (áudio)
        if (linkType.toLowerCase().includes('música') || linkType.toLowerCase().includes('musica')) {
          // áudio
          const audio = document.createElement('audio');
          audio.controls = true;
          audio.src = url;
          audio.style.maxWidth = '100%';
          container.appendChild(audio);
        } else {
          // vídeo
          const video = document.createElement('video');
          video.controls = true;
          video.src = url;
          video.style.maxWidth = '100%';
          container.appendChild(video);
        }
      }
    });
  });
</script>

</body>
</html>
