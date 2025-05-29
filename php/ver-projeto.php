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
$fotosArray = json_decode($projeto['fotos_acervo'] ?? '[]', true);

// Vídeos
$stmtVideos = $conexao->prepare("SELECT * FROM videos_acervo WHERE acervo_id = ?");
$stmtVideos->bind_param("i", $id);
$stmtVideos->execute();
$resultVideos = $stmtVideos->get_result();
$videos = [];
while ($row = $resultVideos->fetch_assoc()) {
  $videos[] = $row;
}

// Curtas
$stmtCurtas = $conexao->prepare("SELECT * FROM curtas_acervo WHERE acervo_id = ?");
$stmtCurtas->bind_param("i", $id);
$stmtCurtas->execute();
$resultCurtas = $stmtCurtas->get_result();
$curtas = [];
while ($row = $resultCurtas->fetch_assoc()) {
  $curtas[] = $row;
  $musicasArray = [];

// Se o campo vier em formato JSON
if (!empty($projeto['musicas'])) {
  $decoded = json_decode($projeto['musicas'], true);
  if (is_array($decoded)) {
    $musicasArray = $decoded;
  } else {
    // fallback caso esteja como texto separado por vírgula ou quebra de linha
    $musicasArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $projeto['musicas'])));
  }
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

</head>
<body class="body-pagina-inicial">
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
      <?php foreach ($fotosArray as $foto): ?>
        <div class="foto-grid-item">
          <img src="<?= htmlspecialchars(trim($foto)) ?>" alt="Foto do projeto">
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- VÍDEOS -->
  <?php if (count($videos) > 0): ?>
    <section>
      <h2 class="titulo-linha">Vídeos</h2>
      <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
        <?php foreach ($videos as $video): ?>
  <div class="card-midia">
    <video controls width="320">
      <source src="exibir-arquivo.php?tabela=videos_acervo&id=<?= $video['id_videos'] ?>" type="<?= $video['tipo_arquivo'] ?>">
      Seu navegador não suporta vídeo.
    </video>
    <p><?= htmlspecialchars($video['nome_arquivo']) ?></p>
  </div>
<?php endforeach; ?>


      </div>
    </section>
  <?php endif; ?>
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
  <?php if (count($curtas) > 0): ?>
    <section>
      <h2 class="titulo-linha">Curta-metragem</h2>
      <?php foreach ($curtas as $curta): ?>
        <video controls width="600">
          <source src="exibir-arquivo.php?tabela=curtas_acervo&id=<?= $curta['id_curtas'] ?>" type="<?= $curta['tipo_arquivo'] ?>">
        </video>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>

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
  <p style="text-align:center;">© Cinelentes</p>
</footer>

<style>
/* Copie seu CSS aqui se quiser manter o estilo */
</style>

</body>
</html>
