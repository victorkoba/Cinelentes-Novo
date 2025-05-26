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
// Divide os dados em arrays
$fotosArray = explode(',', $projeto['fotos']);
$videosArray = explode(',', $projeto['videos']);
$musicasArray = explode(',', $projeto['musicas']);
$habilidadesArray = explode(',', $projeto['habilidades']);
$feedbacksArray = explode('||', $projeto['feedback']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($projeto['titulo']); ?> - Projeto</title>
  <link rel="stylesheet" href="../style/ver-projeto.css">
  <link rel="stylesheet" href="../style/style.css">
  <script src="../js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
  <a href="../index.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" /></a>
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
        <h1><?php echo htmlspecialchars($projeto['titulo']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($projeto['descricao'])); ?></p>
        <p><strong>Data de Realização:</strong> <?php echo date("d/m/Y", strtotime($projeto['data_criacao'])); ?></p>
      </div>

      <div class="projeto-video">
        <?php
        if (!empty($projeto['curtas']) && $projeto['curtas'] !== 'Sem curta') {
          echo '<video controls>
                  <source src="' . htmlspecialchars($projeto['curtas']) . '" type="video/mp4">
                  Seu navegador não suporta o elemento de vídeo.
                </video>';
        } elseif (!empty($fotosArray[0])) {
          echo '<img src="' . htmlspecialchars($fotosArray[0]) . '" alt="Imagem do projeto">';
        }
        ?>
      </div>
    </div>

    <!-- CURTA-METRAGEM -->
    <?php if (!empty($projeto['curtas']) && $projeto['curtas'] !== 'Sem curta'): ?>
      <section>
        <h2>Curta-metragem</h2>
        <video controls>
          <source src="<?php echo htmlspecialchars($projeto['curtas']); ?>" type="video/mp4">
        </video>
      </section>
    <?php endif; ?>

    <!-- FOTOS -->
    <?php if (!empty($fotosArray[0])): ?>
      <section>
        <h2>Fotos</h2>
        <?php foreach ($fotosArray as $foto): ?>
          <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto do projeto">
        <?php endforeach; ?>
      </section>
    <?php endif; ?>

    <!-- VÍDEOS -->
    <?php if (!empty($videosArray[0])): ?>
      <section>
        <h2>Vídeos</h2>
        <?php foreach ($videosArray as $video): ?>
          <video controls>
            <source src="<?php echo htmlspecialchars($video); ?>" type="video/mp4">
          </video>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>

    <!-- MÚSICAS -->
    <?php if (!empty($musicasArray[0])): ?>
      <section>
        <h2>Músicas</h2>
        <?php foreach ($musicasArray as $musica): ?>
          <audio controls>
            <source src="<?php echo htmlspecialchars($musica); ?>" type="audio/mpeg">
          </audio>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>

    <!-- HABILIDADES DESENVOLVIDAS -->
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

    <!-- BOTÃO VOLTAR -->
    <div style="text-align: center;">
      <a class="btn-voltar-card" href="index.php">Voltar</a>
    </div>
  </main>
</body>
</html>
