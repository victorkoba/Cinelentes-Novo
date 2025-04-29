<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../js/main.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .container {
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s forwards;
        }

        .section-subtitle {
            font-size: 16px;
            margin-bottom: 20px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            text-align: justify;
        }

        .video-section, 
        .photos-section, 
        .videos-section, 
        .music-section, 
        .skills-section, 
        .feedback-section {
            margin-top: 40px;
        }

        .video-frame, .photo-frame, .small-video-frame {
            width: 100%;
            max-width: 600px;
            height: 300px;
            background-color: #ccc;
            margin: 20px auto;
        }

        .small-video-frame video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .carousel {
            display: flex;
            overflow: hidden;
            justify-content: center;
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel img {
            width: 100%;
            height: auto;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 24px;
            padding: 10px;
            cursor: pointer;
            border: none;
            z-index: 2;
        }

        .carousel-button-left {
            left: 10px;
        }

        .carousel-button-right {
            right: 10px;
        }

        .music-item {
            background-color: black;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            gap: 10px;
        }

        .music-item img {
            width: 40px;
            height: 40px;
        }

        .feedback-section a {
            color: #333;
            font-weight: bold;
            text-decoration: underline;
            display: block;
            margin-top: 10px;
        }

        .skills-section, .feedback-section {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .skills-section ul {
            list-style-type: none;
            padding-left: 0; /* Remove a indentação da lista */
            margin: 0;
        }

        .skills-section li {
            font-size: 16px;
            margin-bottom: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .skills-section li:before {
            content: "✔";
            margin-right: 10px;
            color: #007BFF;
        }

        .feedback-section {
            text-align: left;
        }

        .feedback-section a:hover {
            color: #007BFF;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title-video-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            margin-top: 40px;
        }

        .title-side {
            flex: 1 1 300px;
            max-width: 500px;
        }

        .video-side {
            flex: 1 1 300px;
            max-width: 600px;
        }

        @media (max-width: 768px) {
            .title-video-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .title-side, .video-side {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

<header class="header-container">
    <nav class="parte-cima-header-container">
        <img id="logo-sesi-senai" src="../img/logo-sesi-senai.png" alt="SESI - SENAI">
        <img id="logo-cinelentes" src="../img/logo-cinelentes.png" alt="CineLentes">
    </nav>
    <div class="linha-branca"></div>
    <div class="navbar-menu-container">
        <ul class="navbar-menu">
            <li><a class="informacoes-navbar-menu" href="../index.php">INÍCIO</a></li>
            <div class="dropdown">
                <a onclick="myFunction()" class="dropbtn">EDIÇÕES</a>
                <div id="myDropdown" class="dropdown-content">
                    <a href="edicao2023.php">EDIÇÃO 2023</a>
                    <a href="edicao2024.php">EDIÇÃO 2024</a>
                    <a href="edicao2025.php">EDIÇÃO 2025</a>
                </div>
            </div>
            <li><a class="informacoes-navbar-menu" href="quem-somos.php">QUEM SOMOS</a></li>
            <li><a class="informacoes-navbar-menu" href="../index.php#grid-agenda">AGENDA</a></li>
        </ul>     
    </div>
</header>

<main>
<div class="container">

    <!-- TÍTULO + CURTA JUNTOS -->
    <div class="title-video-wrapper">
        <div class="title-side">
            <div class="section-title">Dia Internacional da Mulher</div>
            <div class="section-subtitle">
                O 1º Festival de Curta-Metragem "Cinelentes" foi realizado na biblioteca escolar, com uma roda de conversa e um sarau entre os alunos, abordando o tema e os curtas-metragens apresentados.
            </div>
        </div>
        <div class="video-side">
            <div class="video-frame">
                <video controls width="100%" height="100%">
                    <source src="../img/videos/Frida Kahlo.mp4" type="video/mp4">
                    Seu navegador não suporta a tag de vídeo.
                </video>
            </div>
        </div>
    </div>

    <!-- Espaço adicional para Curta-Metragem com Vídeo -->
    <div class="video-section">
        <div class="section-title">Curta-Metragem: Frida Kahlo</div>
        <div class="video-frame">
            <video controls width="100%" height="100%">
            <source src="../img/videos/Frida Kahlo.mp4" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
        </div>
    </div>

    <!-- FOTOS -->
    <div class="photos-section">
        <div class="section-title">Fotos</div>
        <div class="carousel">
            <div class="carousel-images">
                <img src="../img/img-mes-mulher-foto1.jpg" alt="Foto 1">
                <img src="../img/img-mes-mulher-foto2.jpg" alt="Foto 2">
                <img src="../img/img-mes-mulher-foto3.jpg" alt="Foto 3">
            </div>
            <button class="carousel-button carousel-button-left" onclick="moveCarousel(-1)">&#10094;</button>
            <button class="carousel-button carousel-button-right" onclick="moveCarousel(1)">&#10095;</button>
        </div>
    </div>

    <!-- VÍDEOS -->
    <div class="videos-section">
        <div class="section-title">Vídeos</div>

        <div class="small-video-frame">
            <video controls>
                <source src="../img/videos/Mulheres-Fantasticas.mp4.mp4" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
        </div>

        <div class="small-video-frame">
            <video controls>
                <source src="../img/videos/Bina Oliver - Padrão de Beleza.mp4" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
        </div>
    </div>

    <!-- MÚSICAS -->
    <div class="music-section">
    <div class="section-title">Playlist</div>

    <div class="music-item">
        <img src="../img/music1.jpg" alt="Música 1">
        <span>Não precisa ser Amelia - Bia Ferreira/span>
        <audio controls>
            <source src="../audio/let-it-be.mp3" type="audio/mp3">
            Seu navegador não suporta o elemento de áudio.
        </audio>
    </div>

    <div class="music-item">
        <img src="../img/music2.jpg" alt="Música 2">
        <span>Triste, Louca ou Má - Francisco,  el Hombre</span>
        <audio controls>
            <source src="../audio/imagine.mp3" type="audio/mp3">
            Seu navegador não suporta o elemento de áudio.
        </audio>
    </div>

    <div class="music-item">
        <img src="../img/music3.jpg" alt="Música 3">
        <span>Hey Jude - The Beatles</span>
        <audio controls>
            <source src="../audio/hey-jude.mp3" type="audio/mp3">
            Seu navegador não suporta o elemento de áudio.
        </audio>
    </div>
</div>

    </div>

    <!-- HABILIDADES -->
    <div class="skills-section">
        <div class="section-title">Habilidades desenvolvidas</div>
        <ul>
            <li>Leitura e discussão sobre a temática proposta</li>
            <li>Roteirização de curta-metragem</li>
            <li>Edição de vídeo</li>
            <li>Produção de material fotográfico</li>
            <li>Gravação de músicas</li>
            <li>Trabalho em equipe</li>
            <li>Desenvolvimento da criatividade</li>
            <li>Pensamento crítico</li>
        </ul>
    </div>

    <!-- FEEDBACK -->
    <div class="feedback-section">
        <div class="section-title">Deixe seu Feedback</div>
        <a href="#">Clique aqui para enviar seu feedback</a>
    </div>
</div>
</main>

<!-- RODAPÉ -->
<footer class="footer-container">
    <div class="footer-topo">
        <div class="div-vazia"></div>
        <div class="footer-logo-container">
            <img id="logo-cinelentes-footer" src="../img/logo-cinelentes.png" alt="CineLentes">
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

<script>
    let currentIndex = 0;

    function moveCarousel(direction) {
        const images = document.querySelectorAll('.carousel img');
        const totalImages = images.length;
        const carouselImages = document.querySelector('.carousel-images');
        
        currentIndex = (currentIndex + direction + totalImages) % totalImages;
        carouselImages.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
</script>
</body>
</html>
