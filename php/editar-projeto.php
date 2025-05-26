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
$musicas = json_decode($projeto['musicas'], true);
$fotos = json_decode($projeto['fotos'], true);
$videos = json_decode($projeto['videos'], true);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Projeto</title>
  <link rel="stylesheet" href="../style/style.css" />
  <link rel="stylesheet" href="../style/criar-projeto.css" />
</head>
<body class="body-pagina-inicial">

<header class="header-geral">
  <h1 class="sesi-senai">SESI | SENAI</h1>
  <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" /></a>
</header>

<main class="main-container">
  <h1 class="titulo-pagina">Editar Projeto</h1>

  <form method="POST" action="atualizar-projeto.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $projeto['id_acervo']; ?>" />

    <!-- Título e descrição -->
    <div class="informacoes-iniciais">
      <input type="text" name="titulo" value="<?php echo htmlspecialchars($projeto['titulo']); ?>" class="input-titulo-projeto" required />
      <div class="linha-preta"></div>
      <textarea name="conteudo" class="textarea-conteudo-projeto" required><?php echo htmlspecialchars($projeto['descricao']); ?></textarea>
    </div>

    <!-- Seleção de edição -->
    <div class="select-edicao-container">
      <label for="edicao">Edição:</label>
      <select name="edicao" id="edicao" required>
        <option value="2023" <?php if ($projeto['edicao'] == 2023) echo 'selected'; ?>>2023</option>
        <option value="2024" <?php if ($projeto['edicao'] == 2024) echo 'selected'; ?>>2024</option>
        <option value="2025" <?php if ($projeto['edicao'] == 2025) echo 'selected'; ?>>2025</option>
      </select>
    </div>

    <!-- Habilidades e feedback -->
    <section class="secao-habilidades">
      <div class="titulo-secao">
        <h2>Habilidades desenvolvidas</h2>
        <div class="linha-preta"></div>
      </div>
      <textarea name="habilidades" class="textarea-habilidades"><?php echo htmlspecialchars($projeto['habilidades']); ?></textarea>
    </section>

    <section class="secao-feedback">
      <div class="titulo-secao">
        <h2>Feedback</h2>
        <div class="linha-preta"></div>
      </div>
      <textarea name="feedback" class="textarea-feedback"><?php echo htmlspecialchars($projeto['feedback']); ?></textarea>
    </section>

    <!-- Mostrar preview das mídias -->
    <section class="secao-conteudo">
  <div class="titulo-secao">
    <h2>Atualizar Conteúdo</h2>
    <div class="linha-preta"></div>
  </div>

  <!-- Upload de novas fotos -->
  <div class="upload-buttons">
    <p><strong>Nova(s) Foto(s):</strong></p>
    <input type="file" name="fotos[]" multiple accept="image/*" />
  </div>

  <!-- Upload de novos vídeos -->
  <div class="upload-buttons">
    <p><strong>Nova(s) Vídeo(s):</strong></p>
    <input type="file" name="videos[]" multiple accept="video/*" />
  </div>

  <!-- Upload de novo curta -->
  <div class="upload-buttons">
    <p><strong>Novo Curta:</strong></p>
    <input type="file" name="curta" accept="video/*" />
  </div>

  <!-- Exibição das mídias existentes -->
  <div style="margin-top: 2rem;">
    <p><strong>Fotos Atuais:</strong></p>
    <?php if (!empty($fotos)): foreach ($fotos as $foto): ?>
      <img src="<?php echo htmlspecialchars($foto); ?>" style="max-width:150px; margin:5px;">
    <?php endforeach; endif; ?>

    <p><strong>Vídeos Atuais:</strong></p>
    <?php if (!empty($videos)): foreach ($videos as $video): ?>
      <video controls width="400" style="margin:10px;">
        <source src="<?php echo htmlspecialchars($video); ?>" type="video/mp4">
        Seu navegador não suporta o vídeo.
      </video>
    <?php endforeach; endif; ?>

    <p><strong>Curta Atual:</strong></p>
    <?php if (!empty($projeto['curtas'])): ?>
      <video controls width="400">
        <source src="<?php echo htmlspecialchars($projeto['curtas']); ?>" type="video/mp4">
        Seu navegador não suporta o vídeo.
      </video>
    <?php endif; ?>
  </div>
</section>


    <button type="submit" class="botao-confirmar">Salvar Alterações</button>
  </form>
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
