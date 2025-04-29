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
                        <a href="edicao2023-adm.php">EDIÇÃO 2023</a>
                        <a href="edicao2024-adm.php">EDIÇÃO 2024</a>
                        <a href="edicao2025-adm.php">EDIÇÃO 2025</a>
                    </div>
                </div>
                <li><a class="informacoes-navbar-menu" href="quem-somos-adm.php">QUEM SOMOS</a></li>
                <li><a class="informacoes-navbar-menu" href="pagina-inicial-adm.php#grid-agenda">AGENDA</a></li>
                <li><a class="informacoes-navbar-menu" href="pagina-edicao-exclusao-criar-eventos-adm.php">GERENCIAR PROJETOS</a></li>
            </ul>     
        </div>
    </header>
    <main class="equipe-container">
    <h1 class="titulo-equipe">Conheça nossa Equipe</h1>

    <section class="secao-idealizadores">
        <h2 class="titulo-idealizadores">Idealizadores</h2>
        <div class="idealizadores">
            <div class="idealizador">
                <img class="imagem-idealizador" src="../img/img-icon-avatar.png" alt="Prof">
                <p class="nome-idealizador"> Sabrina Lina Figueiredo Gonçalves</p>
            </div>
            <div class="idealizador">
                <img class="imagem-idealizador" src="../img/img-icon-avatar.png" alt="Prof">
                <p class="nome-idealizador"> José Roberto de Lima</p>
            </div>
            <div class="idealizador">
                <img class="imagem-idealizador" src="../img/img-icon-avatar.png" alt="Prof">
                <p class="nome-idealizador"> Rogério de Souza Junior</p>
            </div>
        </div>
    </section>

    <section class="secao-desenvolvedores">
        <h2 class="titulo-desenvolvedores">Desenvolvido por</h2>
        <div class="desenvolvedores">
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/img-icon-avatar.png" alt="Pedro ">
                <p class="nome-desenvolvedor">Pedro Henrique de Petta Zocatelli</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/img-icon-avatar.png" alt="Victor ">
                <p class="nome-desenvolvedor">Victor Luiz Koba Batista</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/img-icon-avatar.png" alt="Miguel ">
                <p class="nome-desenvolvedor">Miguel Francisco da Silva Sales</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/img-icon-avatar.png" alt="Matheus ">
                <p class="nome-desenvolvedor">Matheus Arantes Villar</p>
            </div>
            <div class="desenvolvedor">
                <img class="imagem-desenvolvedor" src="../img/img-icon-avatar.png" alt="Murilo ">
                <p class="nome-desenvolvedor">Murilo Ferreira Faria Santana</p>
            </div>
        </div>
    </section>
</main>
<footer class="footer-container">
    <div class="footer-topo">
        <div class="div-vazia"></div>
        <div class="footer-logo-container">
            <img id="logo-cinelentes-footer" src="./img/logo-cinelentes.png" alt="CineLentes">
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

