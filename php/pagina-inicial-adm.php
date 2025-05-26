<?php
include 'conexao.php';
include 'verificar-login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dia = $_POST['data'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO data (dia, titulo_data, descricao_data) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss", $dia, $titulo, $descricao);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF'] . "?sucesso=1");
    exit();
}
?>
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
  <script src="../js/main.js"></script>
</head>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      title: "Evento salvo!",
      text: "Seu evento foi adicionado com sucesso.",
      icon: "success",
      confirmButtonText: "OK"
    });
  });
</script>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById("form-evento");

    form.addEventListener("submit", function (event) {
      event.preventDefault();

      Swal.fire({
        title: "Deseja salvar este evento?",
        text: "Você pode editar depois, mas isso vai salvá-lo no banco de dados.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, salvar!",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit(); // envia o formulário para o PHP
        }
      });
    });
  });
</script>

<body>
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
  <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" /></a>
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
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
      <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
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
    <div class="container-botao-criar">
      <a href="criar-projeto-adm.php" class="botao-criar-projeto">+ Criar Projeto</a>
    </div>
    <div id="grid-agenda">
      <div id="titulo-adm">
        <h1 class="titulo-pagina-inicial-adm">Criar Agenda</h1>
      </div>
      <div class="container-form">
        <h1 class="titulo-form">Inserir uma nova data de evento</h1>
        <p class="p-agenda">Aqui você pode adicionar uma data que irá aparecer lá na página do usuário!</p>

        <form method="POST" id="form-evento">
          <label class="label-form" for="data">Dia do evento:</label>
          <input class="input-form" placeholder="Insira o dia do evento" type="date" name="data" required>

          <label class="label-form" for="titulo">Título do evento:</label>
          <input class="input-form" placeholder="Insira o título do evento" type="text" name="titulo" required>

          <label class="label-form" for="descricao">Descrição do evento:</label>
          <textarea style="resize: vertical" class="input-form" name="descricao" placeholder="Insira a descrição do evento" required></textarea>

          <div class="alinhamento-button">
            <button class="button-entrar" type="submit">Inserir data de evento</button>
          </div>
        </form>
      </div>
    </div>
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
