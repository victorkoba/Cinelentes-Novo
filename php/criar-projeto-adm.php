<!DOCTYPE html> 
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../js/main.js"></script>
</head>
<body class="body-pagina-inicial">

<header class="header-container">
    <nav class="parte-cima-header-container">
        <img id="logo-sesi-senai" src="../img/logo-sesi-senai.png" alt="SESI - SENAI">
        <img id="logo-cinelentes" src="../img/logo-cinelentes.png" alt="CineLentes">
    </nav>
    <div class="linha-branca"></div>
    <div class="navbar-menu-container">
        <ul class="navbar-menu">
            <li><a class="informacoes-navbar-menu" href="pagina-inicial-adm.php">INÍCIO</a></li>
            <div class="dropdown">
                <a onclick="myFunction()" class="dropbtn">EDIÇÕES</a>
                <div id="myDropdown" class="dropdown-content">
                    <a href="./php/edicao2023.php">EDIÇÃO 2023</a>
                    <a href="./php/edicao2024.php">EDIÇÃO 2024</a>
                    <a href="./php/edicao2025.php">EDIÇÃO 2025</a>
                </div>
            </div>
            <li><a class="informacoes-navbar-menu" href="./php/quem-somos.php">QUEM SOMOS</a></li>
            <li><a class="informacoes-navbar-menu" href="pagina-inicial-adm.php#grid-agenda">AGENDA</a></li>
            <li><a class="informacoes-navbar-menu" href="pagina-edicao-exclusao-criar-eventos-adm.php">GERENCIAR PROJETOS</a></li>
        </ul>     
    </div>
</header>

<main class="main-container">
    <section class="secao-inicial">
  <div class="informacoes-iniciais">
    <input type="text" placeholder="Digite o título do projeto" class="input-titulo-projeto">
    <textarea placeholder="Digite aqui o conteúdo de apresentação do projeto. (Sobre e a data de realização do projeto)" class="textarea-conteudo-projeto"></textarea>
  </div>

  <div class="upload-final-video">
    <p>Faça o upload do vídeo final do projeto</p>
    <button class="botao-upload">⬆️ Upload de Vídeo</button>
  </div>
</section>
    <section class="secao-curta-metragem">
        <h2>Curta-metragem</h2>
        <div class="upload-buttons">
            <div>
                <p>Faça o upload do curta-metragem</p>
                <button class="botao-upload">⬆️ Upload de Vídeo</button>
                <button class="botao-upload">🔗 Upload por Link</button>
            </div>
        </div>
    </section>
    <section class="secao-fotos">
        <h2>Fotos</h2>
        <div class="upload-buttons">
            <div>
                <p>Faça o upload das fotos</p>
                <button class="botao-upload">⬆️ Upload de Fotos</button>
            </div>
        </div>
    </section>
    <section class="secao-videos">
        <h2>Vídeos</h2>
        <div class="upload-buttons">
            <div>
                <p>Faça o upload de vídeo</p>
                <button class="botao-upload">⬆️ Upload de Vídeo</button>
                <button class="botao-upload">🔗 Upload por Link</button>
            </div>
            <div>
                <p>Faça o upload de vídeo</p>
                <button class="botao-upload">⬆️ Upload de Vídeo</button>
                <button class="botao-upload">🔗 Upload por Link</button>
            </div>
        </div>
    </section>
    <section class="secao-musicas">
        <h2>Músicas</h2>
        <div class="musica-item">
            <button class="botao-upload">🔗 Upload de Link</button>
            <span class="icone-play">▶️</span>
            <input type="text" placeholder="Digite o nome da Música" class="input-musica">
        </div>
        <div class="musica-item">
            <button class="botao-upload">🔗 Upload de Link</button>
            <span class="icone-play">▶️</span>
            <input type="text" placeholder="Digite o nome da Música" class="input-musica">
        </div>
        <div class="musica-item">
            <button class="botao-upload">🔗 Upload de Link</button>
            <span class="icone-play">▶️</span>
            <input type="text" placeholder="Digite o nome da Música" class="input-musica">
        </div>
    </section>
    <section class="secao-habilidades">
        <h2>Habilidades desenvolvidas</h2>
        <textarea placeholder="Digite aqui as expectativas trabalhadas e as hashtags (se tiver)." class="textarea-habilidades"></textarea>
    </section>
    <section class="secao-feedback">
        <h2>Deixe seu Feedback</h2>
        <textarea placeholder="Suba o link do formulário do seu projeto para os alunos darem suas avaliações quanto ao projeto (Pode ser adicionado futuramente através da edição)." class="textarea-feedback"></textarea>
        <button class="botao-confirmar">Confirmar</button>
    </section>

</main>



<footer class="footer-container">
    <div class="footer-topo">
        <div class="div-vazia"></div>
        <div class="footer-logo-container">
            <img id="logo-cinelentes-footer" src="../img/logo-cinelentes.png" alt="CineLentes">
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