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

$fotosArray = json_decode($projeto['fotos'], true) ?: [];
$videosArray = json_decode($projeto['videos'], true) ?: [];
$habilidadesArray = explode(',', $projeto['habilidades'] ?? '');
$feedbacksArray = explode('||', $projeto['feedback'] ?? '');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($projeto['titulo']); ?> Cinelentes</title>
  <link rel="stylesheet" href="../style/ver-projeto.css">
  <link rel="stylesheet" href="../style/style.css">
  <script src="../js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <a href="../index.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt=""></a>
    <!-- Botão hamburguer para mobile -->
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
  </header>
  <main class="main-projeto">

    <div class="projeto-topo">
      <div class="projeto-texto">
        <h1><?php echo htmlspecialchars($projeto['titulo']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($projeto['descricao'])); ?></p>
        <p><strong>Data de Realização:</strong> <?php echo date("d/m/Y", strtotime($projeto['data_criacao'])); ?></p>
      </div>

      <div class="projeto-video">
        <?php
        if (!empty($projeto['curtas']) && $projeto['curtas'] !== 'Sem curta') {
          echo '<video controls>
                  <source src="' . htmlspecialchars($projeto['curtas']) . '" type="video/mp4">
                </video>';
        } elseif (!empty($fotosArray[0])) {
          echo '<img src="' . htmlspecialchars(stripslashes($fotosArray[0])) . '" alt="Imagem do projeto">';
        }
        ?>
      </div>
    </div>

    <!-- CURTA -->
    <?php if (!empty($projeto['curtas']) && $projeto['curtas'] !== 'Sem curta'): ?>
      <section>
        <h2>Curta-metragem</h2>
        <video controls width="600">
          <source src="<?php echo htmlspecialchars($projeto['curtas']); ?>" type="video/mp4">
        </video>
      </section>
    <?php endif; ?>

    <!-- FOTOS -->
    <?php if (!empty($fotosArray)): ?>
  <section>
    <h2>Fotos</h2>
    <div class="carrossel-container">
      <button class="prev">&#10094;</button>
      <div class="carrossel-slide">
        <?php foreach ($fotosArray as $foto): ?>
          <img src="<?php echo htmlspecialchars(stripslashes($foto)); ?>" alt="Foto do projeto">
        <?php endforeach; ?>
      </div>
      <button class="next">&#10095;</button>
    </div>
  </section>
<?php endif; ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const slide = document.querySelector('.carrossel-slide');
    const images = document.querySelectorAll('.carrossel-slide img');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');

    let counter = 0;
    const size = images[0].clientWidth;

    function updateSlide() {
      slide.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }

    nextBtn.addEventListener('click', () => {
      if (counter >= images.length  1) {
        counter = 0;
      } else {
        counter++;
      }
      updateSlide();
    });

    prevBtn.addEventListener('click', () => {
      if (counter <= 0) {
        counter = images.length - 1;
      } else {
        counter--;
      }
      updateSlide();
    });

    window.addEventListener('resize', () => {
      updateSlide();
    });
  });
</script>


    <!-- VÍDEOS -->
    <?php if (!empty($videosArray)): ?>
      <section>
        <h2>Vídeos</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
          <?php foreach ($videosArray as $video): ?>
            <?php
            $video = stripslashes($video);
            if (preg_match('/youtube\.com|youtu\.be/', $video)) {
              if (preg_match('/(?:v=|\/)([a-zA-Z0-9_-]{11})/', $video, $yt)) {
                echo '<iframe width="400" height="225" src="https://www.youtube.com/embed/' . $yt[1] . '" frameborder="0" allowfullscreen></iframe>';
              }
            } elseif (preg_match('/\.(mp4|webm|ogg)$/i', $video)) {
              echo '<video controls width="400" style="margin:10px;"><source src="' . htmlspecialchars($video) . '" type="video/mp4"></video>';
            } else {
              echo '<a href="' . htmlspecialchars($video) . '" target="_blank">' . htmlspecialchars($video) . '</a>';
            }
            ?>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- HABILIDADES -->
    <?php if (!empty($habilidadesArray[0])): ?>
      <section>
        <h2>Habilidades Desenvolvidas</h2>
        <ul>
          <?php foreach ($habilidadesArray as $habilidade): ?>
            <li><?php echo htmlspecialchars(trim($habilidade)); ?></li>
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
            <li><?php echo htmlspecialchars(trim($feedback)); ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 2rem;">
      <a class="btn-voltar-card" href="../index.php">Voltar</a>
    </div>
  </main>
</body>
</html>