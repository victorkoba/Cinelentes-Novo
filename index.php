<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinelentes - SESI SENAI</title>
  <link rel="stylesheet" href="./style/index-home.css">
  <script src="./js/main.js"></script>
</head>
<body>
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <img id="logo-header" src="./img/logo-cinelentes-novo.png" alt="">
    <nav>
      <a href="#">INÍCIO</a>
      <a href="#">EDIÇÕES</a>
      <a href="#">QUEM SOMOS</a>
      <a href="#">AGENDA</a>
     
    </nav>
  </header>
  <main>
        <!-- Introdução -->
        <div id="grid-introducao">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">O que é o Cinelentes?</h1>
            </div>
            <div class="introducao-texto">
                <div class="texto">
                <p class="conteudo-introducao">
                    O Projeto “Cinelentes” tem o objetivo de fomentar a cultura no ambiente escolar,
                    democratizando o acesso ao cinema e outras linguagens artísticas/culturais.
                    Proporcionar um ambiente de interação, debate e criatividade que envolve não só o corpo docente
                    e discente, mas toda a comunidade escolar, proporcionando a criticidade necessária para buscar
                    novas lentes através de curtas metragens. Durante cada mês serão abordados temas relacionados
                    a datas comemorativas relevantes daquele mês.
                </p>
                </div>
                <div class="imagem">
                <img id="img-idealizadores" src="./img/img-mes-mulher-foto1.jpg" alt="Imagem idealizadores"/>
                </div>
            </div>
        </div>

        
        <div id="grid-destaques">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">Destaques</h1>
            </div>

            
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
        <img id="logo-cinelentes-footer" src="./img/logo-cinelentes-novo.png" alt="Cinelentes">
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
