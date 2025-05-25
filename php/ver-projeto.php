<?php
include 'conexao.php';

if (!isset($_GET['id'])) {
  echo "Projeto não encontrado.";
  exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM acervos WHERE id_acervo = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "Projeto não encontrado.";
  exit;
}

$projeto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/ver-projeto.css">
  <script src="../js/main.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="body-pagina-inicial">

  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" /></a>
    <nav>
      <a href="../index.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
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

  <main class="main-projeto">
    <h1><?php echo htmlspecialchars($projeto['titulo']); ?></h1>
    <p><strong>Descrição:</strong><br><?php echo nl2br(htmlspecialchars($projeto['descricao'])); ?></p>

    <?php
    // Decodificando JSON das fotos e exibindo cada imagem
    $fotosArray = json_decode($projeto['fotos'], true);
    if ($fotosArray && is_array($fotosArray)) {
      echo "<p><strong>Fotos:</strong><br>";
      foreach ($fotosArray as $foto) {
        echo '<img src="' . htmlspecialchars($foto) . '" alt="Foto" style="max-width:300px; margin: 10px;">';
      }
      echo "</p>";
    }
    ?>

    <?php
    // Decodificando JSON dos vídeos e exibindo os links
    $videosArray = json_decode($projeto['videos'], true);
    if ($videosArray && is_array($videosArray)) {
      echo "<p><strong>Vídeos:</strong><br>";
      foreach ($videosArray as $video) {
        echo '<video controls width="400" style="margin: 10px;">
            <source src="' . htmlspecialchars($video) . '" type="video/mp4">
            Seu navegador não suporta o elemento de vídeo.
          </video><br>';
      }
      echo "</p>";
    }
    ?>


    <?php if ($projeto['curtas'] !== 'Sem curta'): ?>
      <p><strong>Curta:</strong><br><video controls width="400">
          <source src="<?php echo $projeto['curtas']; ?>" type="video/mp4">
          Seu navegador não suporta o elemento de vídeo.
        </video></p>
    <?php endif; ?>

    <p><strong>Músicas:</strong><br>
    <ul>
      <?php
      $musicas = json_decode($projeto['musicas']);
      foreach ($musicas as $musica) {
        if ($musica) echo "<li>" . htmlspecialchars($musica) . "</li>";
      }
      ?>
    </ul>
    </p>

    <p><strong>Habilidades:</strong><br><?php echo htmlspecialchars($projeto['habilidades']); ?></p>
    <p><strong>Feedback:</strong><br><?php echo htmlspecialchars($projeto['feedback']); ?></p>

    <a href="../index.php" class="btn-voltar-card">
      <i class="fas fa-arrow-left"></i> Voltar para página inicial
    </a>
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