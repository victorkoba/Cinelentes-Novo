<?php
include 'conexao.php';
$result = $conexao->query("SELECT * FROM acervos ORDER BY id_acervo DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Projetos Cadastrados</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }
    .projeto {
      background: white;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .titulo {
      font-size: 24px;
      margin-bottom: 10px;
      color: #333;
    }
    .descricao {
      font-size: 16px;
      margin-bottom: 15px;
      color: #555;
    }
    .midia img, .midia video {
      max-width: 200px;
      margin: 8px;
      border-radius: 8px;
    }
    .midia {
      display: flex;
      flex-wrap: wrap;
    }
    .secao {
      margin-top: 10px;
    }
    h3 {
      margin: 12px 0 6px;
      color: #444;
    }
  </style>
</head>
<body>
  <h1>Projetos cadastrados</h1>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="projeto">
      <div class="titulo"><?= htmlspecialchars($row['titulo']) ?></div>
      <div class="descricao"><?= nl2br(htmlspecialchars($row['descricao'])) ?></div>

      <div class="secao">
        <h3>Fotos</h3>
        <div class="midia">
          <?php foreach (json_decode($row['fotos'], true) ?? [] as $foto): ?>
            <img src="<?= $foto ?>" alt="Foto do projeto">
          <?php endforeach; ?>
        </div>
      </div>

      <div class="secao">
        <h3>Vídeos</h3>
        <div class="midia">
          <?php foreach (json_decode($row['videos'], true) ?? [] as $video): ?>
            <video controls>
              <source src="<?= $video ?>" type="video/mp4">
            </video>
          <?php endforeach; ?>
        </div>
      </div>

      <?php if (!empty($row['video_final'])): ?>
        <div class="secao">
          <h3>Vídeo Final</h3>
          <div class="midia">
            <video controls>
              <source src="<?= $row['video_final'] ?>" type="video/mp4">
            </video>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($row['curtas'])): ?>
        <div class="secao">
          <h3>Curta</h3>
          <div class="midia">
            <video controls>
              <source src="<?= $row['curtas'] ?>" type="video/mp4">
            </video>
          </div>
        </div>
      <?php endif; ?>

      <div class="secao">
        <h3>Músicas</h3>
        <ul>
          <?php foreach (json_decode($row['musicas'], true) ?? [] as $musica): ?>
            <?php if (trim($musica) !== ''): ?>
              <li><a href="<?= htmlspecialchars($musica) ?>" target="_blank"><?= htmlspecialchars($musica) ?></a></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="secao">
        <strong>Habilidades:</strong> <?= htmlspecialchars($row['habilidades']) ?><br>
        <strong>Feedback:</strong> <?= nl2br(htmlspecialchars($row['feedback'])) ?><br>
        <strong>Edição:</strong> <?= htmlspecialchars($row['edicao']) ?>
      </div>
    </div>
  <?php endwhile; ?>
</body>
</html>
