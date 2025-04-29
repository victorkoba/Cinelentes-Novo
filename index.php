<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="./style/style.css">
    <script src="./js/main.js"></script>
</head>
<body class="body-pagina-inicial">
    <header class="header-container">
        <nav class="parte-cima-header-container">
            <img id="logo-sesi-senai" src="./img/logo-sesi-senai.png" alt="SESI - SENAI">
            <img id="logo-cinelentes" src="img/logo-cinelentes.png" alt="CineLentes">
        </nav>
        <div class="linha-branca"></div>
        <div class="navbar-menu-container">
            <ul class="navbar-menu">
                <li><a class="informacoes-navbar-menu" href="index.php">INÍCIO</a></li>
                <div class="dropdown">
                    <a onclick="myFunction()" class="dropbtn">EDIÇÕES</a>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="./php/edicao2023.php">EDIÇÃO 2023</a>
                        <a href="./php/edicao2024.php">EDIÇÃO 2024</a>
                        <a href="./php/edicao2025.php">EDIÇÃO 2025</a>
                    </div>
                </div>
                <li><a class="informacoes-navbar-menu" href="./php/quem-somos.php">QUEM SOMOS</a></li>
                <li><a class="informacoes-navbar-menu" href="#grid-agenda">AGENDA</a></li>
            </ul>     
        </div>
    </header>
    <main>
        <!-- Introdução -->
        <div id="grid-introducao">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">O que é o Cinelentes?</h1>
            </div>
            <div class="linha-oque-cinelentes"></div>
            <div class="introducao-texto">
                <p class="conteudo-introducao">
                O Projeto “Cinelentes” tem o objetivo de fomentar a cultura no ambiente escolar, democratizando o acesso ao cinema e outras linguagens artísticas/culturais. Proporcionar um ambiente de interação, debate e criatividade que envolve não só o corpo docente e discente, mas toda a comunidade escolar, proporcionando a criticidade necessária para buscar novas lentes através de curtas metragens. Durante cada mês serão abordados temas relacionados a datas comemorativas relevantes daquele mês.                </p>
            </div>
            <div class="logo-introducao">
                <img src="./img/logo-cinelentes.png" alt="Logo Cinelentes">
            </div>
        </div>

        <!-- Destaques -->
        <div id="grid-destaques">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">Destaques</h1>
            </div>
            <div class="linha-destaques"></div>

            <!-- Carrossel -->
            <section class="carousel-section">
                <div class="carousel-container">
                    <div class="carousel-wrapper" id="carouselWrapper">
                    <div class="carousel-slide">
                        <a href="./php/mes-mulher.php">
                            <img src="./img/img-mes-mulher.jpg" alt="Slide 1">
                            <div class="overlay">
                                <h2>Mês da Mulher</h2>
                                <p>Homenagem especial às mulheres que fazem a diferença.</p>
                            </div>
                        </a>
                    </div>
                    <div class="carousel-slide">
                        <a href="./php/mes-mulher.php">
                            <img src="./img/img-mes-trabalho.jpg" alt="Slide 1">
                            <div class="overlay">
                            <h2>Mês do Trabalho</h2>
                            <p>Homenagem especial aos trabalhadores brasileiros.</p>
                        </div>
                        </a>
                    </div>
                    <div class="carousel-slide">
                    <a href="./php/mes-mulher.php">
                        <img src="./img/img-inclusao.jpg" alt="Slide 1">
                        <div class="overlay">
                            <h2>Homenagem à Inclusão</h2>
                            <p>Homenagem especial às crianças e pessoas com deficiência.</p>
                        </div>
                    </div>
                    </a>
                    </div>

                    <div class="carousel-controls">
                        <button onclick="prevSlide()">&#10094;</button>
                        <button onclick="nextSlide()">&#10095;</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- Agenda -->
        <div id="grid-agenda">
            <div id="titulo-agenda">
                <h1 class="titulo-pagina-inicial">Agenda</h1>
                <p class="agenda-texto">Nenhum evento programado...</p>
            </div>
            <div class="linha-agenda"></div>
        </div>
    </main>
    <footer class="footer-container">
        <div class="footer-topo">
            <div class="div-vazia"></div>
            <div class="footer-logo-container">
                <img id="logo-cinelentes-footer" src="./img/logo-cinelentes.png" alt="Cinelentes">
            </div>
            <div class="botao-login-container">
                <a href="./php/login.php" class="botao-login">Login Administrador</a>
            </div>
        </div>

    <div class="linha-branca-footer"></div>

    <div class="linha-preta-footer">
        <p class="footer-direitos">Todos os direitos reservados.</p>
    </div>
</footer>
</body>
</html>

