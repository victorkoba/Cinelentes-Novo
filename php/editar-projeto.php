<?php
include 'verificar-login.php';
include 'conexao.php';

if (!isset($_GET['id'])) {
  die('Projeto não especificado.');
}

$id = intval($_GET['id']);
$stmt = $conexao->prepare("SELECT * FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die('Projeto não encontrado.');
}

$projeto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Projeto - Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css" />
  <link rel="stylesheet" href="../style/editar-projeto.css" />
</head>
<body class="body-pagina-inicial">
  <main class="main-container">
    <h1 class="titulo-pagina">Editar Projeto</h1>

    <form method="POST" action="atualizar-projeto.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $projeto['id_acervo'] ?>"/>

      <label for="titulo">Título:</label>
      <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($projeto['titulo']) ?>" required class="input-titulo-projeto"/>

      <label for="conteudo">Descrição:</label>
      <textarea id="conteudo" name="conteudo" required class="textarea-conteudo-projeto"><?= htmlspecialchars($projeto['descricao']) ?></textarea>

      <label for="edicao">Edição:</label>
      <select id="edicao" name="edicao" class="select-edicao" required>
        <?php foreach ([2023, 2024, 2025] as $ano): ?>
          <option value="<?= $ano ?>" <?= $projeto['edicao'] == $ano ? 'selected' : '' ?>><?= $ano ?></option>
        <?php endforeach; ?>
      </select>

      <label for="habilidades">Habilidades:</label>
      <textarea id="habilidades" name="habilidades" class="textarea-habilidades"><?= htmlspecialchars($projeto['habilidades']) ?></textarea>

      <label for="feedback">Feedback:</label>
      <textarea id="feedback" name="feedback" class="textarea-feedback"><?= htmlspecialchars($projeto['feedback']) ?></textarea>

      <h2>Fotos:</h2>
      <div class="galeria-fotos">
        <?php
        $fotoStmt = $conexao->prepare("SELECT COUNT(*) as total FROM fotos_acervo WHERE acervo_id = ?");
        $fotoStmt->bind_param("i", $id);
        $fotoStmt->execute();
        $fotoTotal = $fotoStmt->get_result()->fetch_assoc()['total'];

        for ($i = 0; $i < $fotoTotal; $i++): ?>
          <div class="card-midia">
            <img src="ver-midia.php?tabela=fotos_acervo&id=<?= $id ?>&midia=<?= $i ?>" alt="Foto <?= $i ?>" />
            <label><input type="checkbox" name="excluir_fotos[]" value="<?= $i ?>"> Excluir</label>
          </div>
        <?php endfor; ?>
      </div>
      <input type="file" name="fotos[]" multiple accept="image/*">

      <h2>Vídeos:</h2>
      <div class="galeria-videos">
        <?php
        $videoStmt = $conexao->prepare("SELECT COUNT(*) as total FROM videos_acervo WHERE acervo_id = ?");
        $videoStmt->bind_param("i", $id);
        $videoStmt->execute();
        $videoTotal = $videoStmt->get_result()->fetch_assoc()['total'];

        for ($i = 0; $i < $videoTotal; $i++): ?>
          <div class="card-midia">
            <video controls>
              <source src="ver-midia.php?tabela=videos_acervo&id=<?= $id ?>&midia=<?= $i ?>" type="video/mp4">
              Seu navegador não suporta vídeo.
            </video>
            <label><input type="checkbox" name="excluir_videos[]" value="<?= $i ?>"> Excluir</label>
          </div>
        <?php endfor; ?>
      </div>
      <input type="file" name="videos[]" multiple accept="video/*">

      <h2>Curta:</h2>
      <div class="card-midia">
        <?php
        $curtaStmt = $conexao->prepare("SELECT COUNT(*) as total FROM curtas_acervo WHERE acervo_id = ?");
        $curtaStmt->bind_param("i", $id);
        $curtaStmt->execute();
        $curtaTotal = $curtaStmt->get_result()->fetch_assoc()['total'];

        if ($curtaTotal > 0): ?>
          <video controls width="300">
            <source src="ver-midia.php?tabela=curtas_acervo&id=<?= $id ?>&midia=0" type="video/mp4">
            Seu navegador não suporta vídeo.
          </video>
          <label><input type="checkbox" name="excluir_curta" value="1"> Excluir</label>
        <?php endif; ?>
      </div>
      <input type="file" name="curta" accept="video/*">

      <button type="submit" class="botao-confirmar">Salvar Alterações</button>
    </form>
  </main>
</body>
</html>
