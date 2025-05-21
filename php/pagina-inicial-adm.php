<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/pagina-inicial.css">
  <link rel="stylesheet" href="../style/style.css">
  <script src="../js/carrosel.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/main.js"></script>
</head>
<body>
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="">
    <nav>
      <a href="pagina-inicial-adm.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="edicao2023-adm.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="edicao2024-adm.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="edicao2025-adm.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="#grid-agenda" class="link-animado">AGENDA</a>
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
      <a id="botao-logout" class="button-logout">Logout</a>
        <script>
          document.getElementById("botao-logout").addEventListener("click", function (e) {
              e.preventDefault();

              Swal.fire({
                  title: "Deseja sair da conta?",
                  text: "Você precisará fazer login novamente para continuar.",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Sim, sair"
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "logout.php";
                  }
              });
          });
        </script>
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
                        <img id="img-idealizadores" src="../img/img-mes-mulher-foto1.jpg" alt="Imagem idealizadores"/>
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
                <img class="galeria-itens galeria-item-1" src="../img/img-mes-mulher-foto1.jpg"  data-index="1" alt="">
                <img class="galeria-itens galeria-item-2" src="../img/img-mes-cultura-coreana.jpg"  data-index="2" alt="">
                <img class="galeria-itens galeria-item-3" src="../img/img-inclusao.jpg"  data-index="3" alt="">
                <img class="galeria-itens galeria-item-4" src="../img/img-mes-mulher-foto1.jpg"  data-index="4" alt="">
                <img class="galeria-itens galeria-item-5" src="../img/img-mes-cultura-coreana.jpg"  data-index="5" alt="">
              </div>
              <div class="galeria-bot">

              </div>
            </div>
<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dia = $_POST['data']; // Corrigido: nome do campo no formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO data (dia, titulo_data, descricao_data) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss", $dia, $titulo, $descricao);
    $stmt->execute();

    exit();
}
?>
    <div id="grid-agenda">
    <div id="titulo">
      <h1 class="titulo-pagina-inicial">Agenda</h1>
    </div>
    <div class="container-form">
    <h1 class="titulo-form">Inserir uma nova data de evento</h1>
    <p class="p-agenda">Aqui você pode adicionar uma data que irá aparecer lá na página do usuário!</p>

    <form method="POST" class="form-tarefa" id="form-evento">
        <label class="label-form" for="data">Dia do evento:</label>
        <input class="input-form" placeholder="Insira o dia do evento" type="date" name="data" required>

        <label class="label-form" for="titulo">Título do evento:</label>
        <input class="input-form" placeholder="Insira o título do evento" type="text" name="titulo" required>

        <label class="label-form" for="descricao">Descrição do evento:</label>
        <textarea style="resize: vertical" class="input-form" name="descricao" type="text" placeholder="Insira a descrição do evento" required></textarea>

        <div class="alinhamento-button">
            <button class="button-entrar" type="submit">Inserir data de evento</button>
        </div>
    </form>
</div>

  <script>
    document.getElementById("form-evento").addEventListener("submit", function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Deseja salvar este evento?",
            text: "Você pode editar depois, mas isso vai salvá-lo no banco de dados.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, salvar!"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
                window.location.href = 'pagina-inicial-adm.php';            
            }
        });
    });
  </script>

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