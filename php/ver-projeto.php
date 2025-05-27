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
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($projeto['titulo']) ?> - Cinelentes</title>
  <link rel="stylesheet" href="../style/ver-projeto.css">
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<header class="header-geral">
  <!-- Cabeçalho omitido por brevidade... -->
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
