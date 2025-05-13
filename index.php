<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinelentes</title>
  <link rel="stylesheet" href="./style/pagina-inicial.css">
  <link rel="stylesheet" href="./style/style.css">
  <script src="./js/carrosel.js"></script>
  <script src="./js/main.js"></script>
</head>
<body>
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <img id="logo-header" src="./img/logo-cinelentes-novo.png" alt="">
    <nav>
      <a href="#" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="./php/edicao2023.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="./php/edicao2024.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="./php/edicao2025.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="./php/quem-somos.php" class="link-animado">QUEM SOMOS</a>
      <a href="#grid-agenda" class="link-animado">AGENDA</a>
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
                    <figure>
                        <img id="img-idealizadores" src="./img/img-mes-mulher-foto1.jpg" alt="Imagem idealizadores"/>
                        <figcaption>Foto dos idealizadores do projeto no evento "Mês das Mulheres".</figcaption>
                    </figure>
                </div>

            </div>
        </div>    
        <div id="grid-destaques">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">Destaques</h1>
            </div>
            <div class="galeria">
              <div class="galeria-container">
                <img class="galeria-itens galeria-item-1" src="./img/img-mes-mulher-foto1.jpg"  data-index="1" alt="">
                <img class="galeria-itens galeria-item-2" src="./img/img-mes-cultura-coreana.jpg"  data-index="2" alt="">
                <img class="galeria-itens galeria-item-3" src="./img/img-inclusao.jpg"  data-index="3" alt="">
                <img class="galeria-itens galeria-item-4" src="./img/img-mes-mulher-foto1.jpg"  data-index="4" alt="">
                <img class="galeria-itens galeria-item-5" src="./img/img-mes-cultura-coreana.jpg"  data-index="5" alt="">
              </div>
              <div class="galeria-controls">
                
              </div>
            </div>
 
            
        <div id="grid-agenda">
            <div id="titulo-agenda">
                <h1 class="titulo-pagina-inicial">Agenda</h1>
                <div class="agenda-eventos">
        <div class="agenda-card">
          <div class="data-agenda">
            <span class="dia">28</span>
            <span class="mes">FEV</span>
          </div>
          <div class="descricao-agenda">Mês das Mulheres</div>
        </div>

        <div class="agenda-card">
          <div class="data-agenda">
            <span class="dia">30</span>
            <span class="mes">MAR</span>
          </div>
          <div class="descricao-agenda">Mês dos Bonitos</div>
        </div>
      </div>

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
