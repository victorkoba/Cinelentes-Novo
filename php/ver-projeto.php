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
$projeto = $stmt->get_result()->fetch_assoc();

if (!$projeto) {
  echo "Projeto não encontrado.";
  exit;
}

$habilidadesArray = explode(',', $projeto['habilidades'] ?? '');
$feedbacksArray = explode('||', $projeto['feedback'] ?? '');
$fotosArray = explode ('||', $projeto['foto_capa_acervo'] ?? '');

// Vídeos
$stmtVideos = $conexao->prepare("SELECT * FROM videos_acervo WHERE acervo_id = ?");
$stmtVideos->bind_param("i", $id);
$stmtVideos->execute();
$resultVideos = $stmtVideos->get_result();
$videos = [];
while ($row = $resultVideos->fetch_assoc()) {
  $videos[] = $row;
}

// Fotos
$stmtFotos = $conexao->prepare("SELECT * FROM fotos_acervo WHERE acervo_id = ?");
$stmtFotos->bind_param("i", $id);
$stmtFotos->execute();
$resultFotos = $stmtFotos->get_result();
$fotos = [];
while ($row = $resultFotos->fetch_assoc()) {
  $fotos[] = $row;
}

// Curtas
$stmtCurtas = $conexao->prepare("SELECT * FROM curtas_acervo WHERE acervo_id = ?");
$stmtCurtas->bind_param("i", $id);
$stmtCurtas->execute();
$resultCurtas = $stmtCurtas->get_result();
$curtas = [];
while ($row = $resultCurtas->fetch_assoc()) {
  $curtas[] = $row;
}

// Agora sim, fora do while, processamos músicas
$musicasArray = [];
if (!empty($projeto['musicas'])) {
  $decoded = json_decode($projeto['musicas'], true);
  if (is_array($decoded)) {
    $musicasArray = $decoded;
  } else {
    $musicasArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $projeto['musicas'])));
  }
}
?>
<?php
function embedLink($url) {
  // YouTube
  if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $matches) || preg_match('/youtube\.com\/watch\?v=([^\?&]+)/', $url, $matches)) {
    return 'https://www.youtube.com/embed/' . $matches[1];
  }

  // Vimeo
  if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
    return 'https://player.vimeo.com/video/' . $matches[1];
  }

  // Spotify (pode ajustar conforme necessário)
  if (strpos($url, 'spotify.com') !== false) {
    return str_replace('/track/', '/embed/track/', $url);
  }

  // Default (embed direto, sem garantias)
  return $url;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($projeto['titulo']) ?> - Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/ver-projeto.css">
  <script src="../main/main.js"></script>

</head>
<body class="body-pagina-inicial">
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
      <h1><?= htmlspecialchars($projeto['titulo']) ?></h1>
      <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
      <p><strong>Data de Realização:</strong> <?= date("d/m/Y", strtotime($projeto['data_criacao'])) ?></p>
    </div>
    <div class="projeto-video">
      <?php if (!empty($fotosArray[0])): ?>
        <img src="<?= htmlspecialchars(trim($fotosArray[0])) ?>" width="300" alt="Imagem de destaque">
      <?php endif; ?>
    </div>
  </div>

  <!-- FOTOS -->
    <section>
      <h2 class="titulo-linha">Fotos</h2>
      <div class="grid-fotos">
      <?php
      $sqlFotos = "SELECT id_fotos, nome_arquivo FROM fotos_acervo WHERE acervo_id = ?";
      $stmt = $conexao->prepare($sqlFotos);
      $stmt->bind_param("i", $projeto['id_acervo']);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($fotos = $result->fetch_assoc()):
      ?>
        <div class="card-midia">
          <img width="300" src="exibir-foto.php?id=<?= $fotos['id_fotos'] ?>" type="image/*"/>
        </div>
      <?php endwhile; $stmt->close(); ?>
    </div>
      </div>
    </section>

  <!-- VÍDEOS -->
    <section>
      <h2 class="titulo-linha">Vídeos</h2>
      <div class="galeria-videos">
      <?php
      $sqlVideos = "SELECT id_videos, nome_arquivo FROM videos_acervo WHERE acervo_id = ?";
      $stmt = $conexao->prepare($sqlVideos);
      $stmt->bind_param("i", $projeto['id_acervo']);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($video = $result->fetch_assoc()):
      ?>
        <div class="card-midia">
          <video controls width="320">
            <source src="exibir-video.php?id=<?= $video['id_videos'] ?>" type="video/mp4">
            Seu navegador não suporta vídeo.
          </video>
        </div>
      <?php endwhile; $stmt->close(); ?>
    </div>
      </div>
    </section>
    
  <!-- MÚSICAS -->
   <?php if (!empty($musicasArray)): ?>
  <section>
    <h2 class="titulo-linha">Músicas</h2>
    <div class="grid-musicas">
      <?php foreach ($musicasArray as $link): ?>
        <div class="musica-item">
          <iframe 
            width="100%" height="220" 
            src="<?= htmlspecialchars(embedLink($link)) ?>" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
          </iframe>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

 <!-- CURTA -->
  <div class="galeria-videos">
      <?php
      $sqlCurtas = "SELECT id_curtas, nome_arquivo FROM curtas_acervo WHERE acervo_id = ?";
      $stmt = $conexao->prepare($sqlCurtas);
      $stmt->bind_param("i", $projeto['id_acervo']);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($curta = $result->fetch_assoc()):
      ?>
        <div class="card-midia">
          <video controls width="320">
            <source src="exibir-curta.php?id=<?= $curta['id_curtas'] ?>" type="video/mp4">
            Seu navegador não suporta vídeo.
          </video>
        </div>
      <?php endwhile; $stmt->close(); ?>
    </div>

  <!-- HABILIDADES -->
  <?php if (!empty($habilidadesArray[0])): ?>
    <section>
      <h2 class="titulo-linha">Habilidades Desenvolvidas</h2>
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
      <h2 class="titulo-linha">Feedbacks</h2>
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
    <div class="footer-topo">
      <div class="div-vazia"></div>
      <div class="footer-logo-container">
        <img id="logo-cinelentes-footer" src="../img/logo-cinelentes-novo.png" alt="CineLentes">
      </div>
      <div class="botao-login-container">
        <a href="login.php" class="botao-login">Login Administrador</a>
      </div>
    </div>

    <div class="linha-branca-footer"></div>

    <div class="linha-preta-footer">
      <p class="footer-direitos">Todos os direitos reservados.</p>
    </div>
  </footer>


</body>
</html>