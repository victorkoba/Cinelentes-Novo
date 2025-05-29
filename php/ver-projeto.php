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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinelentes</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/quem-somos.css">
    <script src="../js/main.js"></script>
</head>
<body class="body-pagina-inicial">

  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <a href="../index.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt=""></a>
    <button id="hamburguer" aria-label="Abrir menu" aria-expanded="false">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>

    <nav id="nav-menu">
      <a href="../index.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a href="#" class="dropbtn link-animado">EDIÇÕES</a>
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

  <script>
    const hamburguer = document.getElementById('hamburguer');
    const navMenu = document.getElementById('nav-menu');
    const dropdownBtn = document.querySelector('.dropbtn');
    const dropdownContent = document.getElementById('myDropdown');

    hamburguer.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('show');
      hamburguer.setAttribute('aria-expanded', isOpen);
      hamburguer.classList.toggle('open');
      dropdownContent.classList.remove('show');
    });

    dropdownBtn.addEventListener('click', (e) => {
      e.preventDefault();
      dropdownContent.classList.toggle('show');
    });

    window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropbtn')) {
        dropdownContent.classList.remove('show');
      }
    });
  </script>

<main class="main-projeto">
  <div class="projeto-topo">
    <div class="projeto-texto">
      <h1><?= htmlspecialchars($projeto['titulo']) ?></h1>
      <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
      <p><strong>Data de Realização:</strong> <?= date("d/m/Y", strtotime($projeto['data_criacao'])) ?></p>
    </div>
    <div class="projeto-video">
      <?php
      $foto = $conexao->prepare("SELECT * FROM videos_acervo WHERE acervo_id = ? LIMIT 1");
      $foto->bind_param("i", $id);
      $foto->execute();
      $fotoRes = $foto->get_result();
      if ($fotoRow = $fotoRes->fetch_assoc()) {
        echo "<img src='ver-midia.php?tabela=videos_acervo&id={$id}&midia=0' width='300'>";
      }
      ?>
    </div>
  </div>

  <!-- FOTOS -->
  <section>
    <h2>Fotos</h2>
    <div class="grid-fotos">
      <?php
      $fotos = $conexao->prepare("SELECT * FROM curtas_acervo WHERE acervo_id = ?");
      $fotos->bind_param("i", $id);
      $fotos->execute();
      $fotoRes = $fotos->get_result();
      $i = 0;
      while ($row = $fotoRes->fetch_assoc()) {
        echo "<div class='foto-grid-item'>
                <img src='ver-midia.php?tabela=curtas_acervo&id={$id}&midia={$i}' alt='Foto do projeto'>
              </div>";
        $i++;
      }
      ?>
    </div>
  </section>

  <!-- CURTA -->
  <?php
  $curta = $conexao->prepare("SELECT * FROM videos_acervo WHERE acervo_id = ? LIMIT 1");
  $curta->bind_param("i", $id);
  $curta->execute();
  $curtaRes = $curta->get_result();
  if ($curtaRow = $curtaRes->fetch_assoc()) {
    echo "<section><h2>Curta-metragem</h2>
          <video controls width='600'>
            <source src='ver-midia.php?tabela=videos_acervo&id={$id}&midia=0' type='{$curtaRow['tipo_arquivo']}'>
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
  // Script do carrossel, se necessário...
</script>
</body>
</html>
