<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../js/main.js"></script>
    <link rel="stylesheet" href="../style/mes-mulher.css">
    <link rel="stylesheet" href="../audios">
</head>
<body>
    <header class="header-geral">
        <h1 class="sesi-senai">SESI | SENAI</h1>
        <img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes">
        <nav>
            <a href="../index.php" class="link-animado">INÍCIO</a>
            <div class="dropdown">
                <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
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
                        <source src="../img/videos/Bina Oliver - Padrão de Beleza.mp4" type="video/mp4">
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
            <!-- VÍDEOS -->
<div class="videos-section">
    <div class="section-title">Vídeos</div>

    <div class="videos-container">
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
</div>


            <!-- MÚSICAS -->
            <div class="music-section">
                <div class="section-title">Playlist</div>

                <div class="music-item">
                    <img src="../img/amelia.avif" alt="Música 1">
                    <span>Não precisa ser Amelia - Bia Ferreira</span>
                    <audio controls>
                    <source src="../audios/Bia Ferreira.mp3" type="audio/mp3">
                  Seu navegador não suporta a tag de áudio.
                  </audio>


                </div>

                <div class="music-item">
                    <img src="../img/louca e ma.jpg" alt="Música 2">
                    <span>Triste, Louca ou Má - Francisco, el Hombre</span>
                    <audio controls>
                    <source src="../audios/Francisco, el Hombre - Triste, Louca ou Má (OFICIAL).mp3" type="audio/mp3">
                 Seu navegador não suporta a tag de áudio.
m                 </audio>
                </div>

                <div class="music-item">
                    <img src="../img/escravos.jpg" alt="Música 3">
                    <span>Escrava - Guto e a Cidade</span>
                    <audio controls>
                    <source src="../audios/GUTO E A CIDADE - Escrava.mp3" type="audio/mp3">
                 Seu navegador não suporta a tag de áudio.
m                 </audio>
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
