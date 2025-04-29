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
        }

        .video-section, 
        .photos-section, 
        .videos-section, 
        .music-section, 
        .skills-section, 
        .feedback-section {
            margin-top: 40px;
        }

        .small-video-frame video {
            width: 100%;
            height: 100%;
            object-fit: cover; /* adapta o vídeo ao tamanho da div */
            border-radius: 8px; /* opcional: bordas arredondadas */
        }

        .video-frame, .photo-frame, .small-video-frame {
            width: 100%;
            max-width: 600px;
            height: 300px;
            background-color: #ccc;
            margin: 20px auto;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            justify-content: center;
        }

        .carousel img {
            height: 200px;
            width: auto;
            border-radius: 8px;
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
            color: black;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Animação fade-in dos títulos */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
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
    <div class="section-title">Dia Internacional da Mulher</div>
    <div class="section-subtitle">
        Alunos do 7º ano A desenvolveram atividades para celebrar o Dia Internacional da Mulher.<br>
        Curta-metragem | Vídeos | Músicas | Fotos
    </div>

    <div class="video-section">
        <div class="section-title">Curta-metragem</div>
        <div class="video-frame">
            <video controls width="100%" height="100%">
                <source src="../img/Bina Oliver - Padrão de Beleza.mp4" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
        </div>
    </div>

    <div class="photos-section">
        <div class="section-title">Fotos</div>
        <div class="carousel">
            <img src="../img/img-mes-mulher-foto1.jpg" alt="Foto 1">
            <img src="../img/img-mes-mulher-foto2.jpg" alt="Foto 2">
            <img src="../img/img-mes-mulher-foto3.jpg" alt="Foto 3">
        </div>
    </div>

    <div class="videos-section">
    <div class="section-title">Vídeos</div>

    <div class="small-video-frame">
        <video src="Mulheres Fantásticas #1_Malala Yousafzai-(1080p).mp4" controls></video>
    </div>

    <div class="small-video-frame">
        <video src="Versão Final - Cinelentes.mp4" controls></video>
    </div>
</div>
    <div class="skills-section">
        <div class="section-title">Habilidades desenvolvidas</div>
        <p>1. Leitura e discussão sobre a temática proposta; 2. Roteirização de curta-metragem; 3. Edição de vídeo; 4. Produção de material fotográfico; 5. Gravação de músicas; 6. Trabalho em equipe; 7. Desenvolvimento da criatividade; 8. Pensamento crítico.</p>
    </div>

    <div class="feedback-section">
        <div class="section-title">Deixe seu Feedback</div>
        <a href="#">Clique aqui para enviar seu feedback</a>
    </div>
</div>
</main>

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

</body>
</html>
