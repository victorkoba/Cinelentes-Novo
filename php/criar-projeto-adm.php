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
  <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" /></a>
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
    <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
  </nav>
</header>

<main class="main-container">
  <h1 class="titulo-pagina">Criar Projeto</h1>

  <form method="POST" action="salvar-projeto.php" enctype="multipart/form-data">
    <div class="select-edicao-container">
      <label for="edicao">Selecione a Edição:</label>
      <select name="edicao" id="edicao" required>
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
        <input type="file" name="final_video" id="final-video" style="display:none" />
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
            <input type="file" name="fotos" id="upload-fotos" multiple style="display:none" />
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
            <input type="file" name="videos" id="upload-videos" multiple style="display:none" />
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
            <input type="file" name="curta" id="upload-curta" style="display:none" />
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
          type="url"
          name="musica1"
          placeholder="Digite a URL da Música"
          class="input-musica"
        />
        <div class="link-preview" id="musica1-container"></div>
      </div>
      <div class="musica-item">
        <button type="button" class="botao-upload" data-action="link" data-link-type="música" data-container-id="musica2-container">Upload de Link</button>
        <span class="icone-play" role="img" aria-label="Ícone de play">▶</span>
        <input
          type="url"
          name="musica2"
          placeholder="Digite a URL da Música"
          class="input-musica"
        />
        <div class="link-preview" id="musica2-container"></div>
      </div>
      <div class="musica-item">
        <button type="button" class="botao-upload" data-action="link" data-link-type="música" data-container-id="musica3-container">Upload de Link</button>
        <span class="icone-play" role="img" aria-label="Ícone de play">▶</span>
        <input
          type="url"
          name="musica3"
          placeholder="Digite a URL da Música"
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
      <button type="submit" class="botao-confirmar">Confirmar</button>
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