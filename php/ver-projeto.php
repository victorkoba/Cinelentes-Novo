<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "Projeto não encontrado.";
  exit;
}

$stmt = $conexao->prepare("SELECT * FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$projeto = $result->fetch_assoc();

if (!$projeto) {
  echo "Projeto não encontrado.";
  exit;
}

$habilidadesArray = explode(',', $projeto['habilidades'] ?? '');
$feedbacksArray = explode('||', $projeto['feedback'] ?? '');
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
    <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt=""></a>
    <!-- Botão hamburguer para mobile -->
    <button id="hamburguer" aria-label="Abrir menu" aria-expanded="false">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>

    <nav id="nav-menu">
      <a href="pagina-inicial-adm.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a href="#" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="edicao2023-adm.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="edicao2024-adm.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="edicao2025-adm.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
      <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
    </nav>
  </header>
  <script>
    const hamburguer = document.getElementById('hamburguer');
    const navMenu = document.getElementById('nav-menu');
    const dropdownBtn = document.querySelector('.dropbtn');
    const dropdownContent = document.getElementById('myDropdown');

    hamburguer.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('show');
      hamburguer.setAttribute('aria-expanded', isOpen);

      // Alterna classe 'open' para animação do botão
      hamburguer.classList.toggle('open');

      // Fecha dropdown quando abrir/fechar menu
      dropdownContent.classList.remove('show');
    });

    // Dropdown toggle mobile
    dropdownBtn.addEventListener('click', (e) => {
      e.preventDefault();
      dropdownContent.classList.toggle('show');
    });

    // Fecha dropdown se clicar fora
    window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropbtn')) {
        dropdownContent.classList.remove('show');
      }
    });
  </script>
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

<main class="main-projeto">
  <div class="projeto-topo">
    <div class="projeto-texto">
      <h1><?= htmlspecialchars($projeto['titulo']) ?></h1>
      <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
      <p><strong>Data de Realização:</strong> <?= date("d/m/Y", strtotime($projeto['data_criacao'])) ?></p>
    </div>
    <div class="projeto-video">
      <?php
      // Foto de capa (primeira entrada da tabela foto_capa_acervo)
      $foto = $conexao->prepare("SELECT * FROM foto_capa_acervo WHERE acervo_id = ? LIMIT 1");
      $foto->bind_param("i", $id);
      $foto->execute();
      $fotoRes = $foto->get_result();
      if ($fotoRow = $fotoRes->fetch_assoc()) {
        echo "<img src='ver-midia.php?tabela=foto_capa_acervo&id={$id}&midia=0' width='300'>";
      }
      ?>
    </div>
  </div>

  <!-- FOTOS -->
  <section>
  <h2>Fotos</h2>
  <div class="grid-fotos">
    <?php
    $fotos = $conexao->prepare("SELECT * FROM fotos_acervo WHERE acervo_id = ?");
    $fotos->bind_param("i", $id);
    $fotos->execute();
    $fotoRes = $fotos->get_result();
    $i = 0;
    while ($row = $fotoRes->fetch_assoc()) {
      echo "<div class='foto-grid-item'>
              <img src='ver-midia.php?tabela=fotos_acervo&id={$id}&midia={$i}' alt='Foto do projeto'>
            </div>";
      $i++;
    }
    ?>
  </div>
</section>


  <!-- CURTA -->
  <?php
  $curta = $conexao->prepare("SELECT * FROM curtas_acervo WHERE acervo_id = ? LIMIT 1");
  $curta->bind_param("i", $id);
  $curta->execute();
  $curtaRes = $curta->get_result();
  if ($curtaRow = $curtaRes->fetch_assoc()) {
    echo "<section><h2>Curta-metragem</h2>
          <video controls width='600'>
            <source src='ver-midia.php?tabela=curtas_acervo&id={$id}&midia=0' type='video/mp4'>
          </video></section>";
  }
  ?>

  <!-- VÍDEOS -->
  <section>
    <h2>Vídeos</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
      <?php
      $videos = $conexao->prepare("SELECT * FROM videos_acervo WHERE acervo_id = ?");
      $videos->bind_param("i", $id);
      $videos->execute();
      $videoRes = $videos->get_result();
      $i = 0;
      while ($videoRow = $videoRes->fetch_assoc()) {
        echo "<video controls width='400' style='margin:10px;'>
                <source src='ver-midia.php?tabela=videos_acervo&id={$id}&midia={$i}' type='{$videoRow['tipo_arquivo']}'>
              </video>";
        $i++;
      }
      ?>
    </div>
  </section>

  <!-- HABILIDADES -->
  <?php if (!empty($habilidadesArray[0])): ?>
    <section>
      <h2>Habilidades Desenvolvidas</h2>
      <ul>
        <?php foreach ($habilidadesArray as $habilidade): ?>
          <li><?= htmlspecialchars(trim($habilidade)) ?></li>
        <?php endforeach; ?>
      </ul>
    </section>
  <?php endif; ?>

  <!-- FEEDBACKS -->
  <?php if (!empty($feedbacksArray[0])): ?>
    <section>
      <h2>Feedbacks</h2>
      <ul>
        <?php foreach ($feedbacksArray as $feedback): ?>
          <li><?= htmlspecialchars(trim($feedback)) ?></li>
        <?php endforeach; ?>
      </ul>
    </section>
  <?php endif; ?>

  <div style="text-align: center; margin-top: 2rem;">
    <a class="btn-voltar-card" href="../index.php">Voltar</a>
  </div>
</main>

<footer class="footer-container">
  <!-- Footer omitido por brevidade... -->
</footer>

<script>
  // Script do carrossel igual anterior...
</script>
</body>
</html>