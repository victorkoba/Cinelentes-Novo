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
                <li><a class="informacoes-navbar-menu" href="#">INÍCIO</a></li>
                <div class="dropdown">
                    <a onclick="myFunction()" class="dropbtn">EDIÇÕES</a>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="edicao2023-adm.php">EDIÇÃO 2023</a>
                        <a href="edicao2024-adm.php">EDIÇÃO 2024</a>
                        <a href="edicao2025-adm.php">EDIÇÃO 2025</a>
                    </div>
                </div>
                <li><a class="informacoes-navbar-menu" href="quem-somos-adm.php">QUEM SOMOS</a></li>
                <li><a class="informacoes-navbar-menu" href="#grid-agenda">AGENDA</a></li>
                <li><a class="informacoes-navbar-menu" href="pagina-edicao-exclusao-criar-eventos-adm.php">GERENCIAR PROJETOS</a></li>
            </ul>     
        </div>
    </header>
    <main>
        <div id="grid-introducao">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">O que é o Cinelentes?</h1>
            </div>
            <div class="linha-oque-cinelentes"></div>
            <div class="introducao-texto">
                <p class="conteudo-introducao">O Projeto “Cinelentes” tem o objetivo de fomentar a cultura no ambiente escolar, democratizando o acesso ao cinema e outras linguagens artísticas/culturais. Proporcionar um ambiente de interação, debate e criatividade que envolve não só o corpo docente e discente, mas toda a comunidade escolar, proporcionando a criticidade necessária para buscar novas lentes através de curtas metragens. Durante cada mês serão abordados temas relacionados a datas comemorativas relevantes daquele mês.</p>
            </div>
            <div class="logo-introducao">
                <img src="../img/logo-cinelentes.png" alt="">
            </div>
        </div>
        <div id="grid-destaques">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">Destaques</h1>
            </div>
            <div class="linha-destaques"></div>

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
                <img id="logo-cinelentes-footer" src="../img/logo-cinelentes.png" alt="Cinelentes">
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

