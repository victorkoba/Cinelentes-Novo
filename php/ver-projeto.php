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
    <h2 class="titulo-linha">Fotos</h2>
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
    echo "<section><h2 class='titulo-linha'>Curta-metragem</h2>
          <video controls width='600'>
            <source src='ver-midia.php?tabela=videos_acervo&id={$id}&midia=0' type='{$curtaRow['tipo_arquivo']}'>
          </video></section>";
  }
  ?>

  <!-- VÍDEOS -->
  <section>
    <h2 class="titulo-linha">Vídeos</h2>
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
  <!-- Footer omitido por brevidade... -->
</footer>

<style>
.main-projeto {
  max-width: 1200px;
  margin: auto;
  padding: 2rem;
  font-family: 'Arial', sans-serif;
  color: #333;
  background-color: #f9f9f9;
}

.projeto-topo {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  align-items: flex-start;
  margin-bottom: 2rem;
}

.projeto-texto {
  flex: 1;
  min-width: 300px;
}

.projeto-texto h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: rgb(0, 0, 0);
}

.projeto-texto p {
  font-size: 1rem;
  line-height: 1.5;
  margin-bottom: 0.5rem;
}

.projeto-video {
  flex: 1;
  text-align: center;
  min-width: 300px;
}

.grid-fotos {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 1rem;
  margin: 2rem 0;
}

.foto-grid-item img {
  width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

section {
  margin-bottom: 2rem;
}

.titulo-linha {
  position: relative;
  font-weight: bold;
  font-size: 1.5rem;
  color: #000;
  margin-bottom: 14rem; /* espaçamento maior entre títulos */
  display: inline-block;
   margin-bottom: 240px; /* um pouco maior para espaçamento */
}

.titulo-linha::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 100%;
  height: 1.5px; /* mesma finura para todas */
  background-color: #000;
  border-radius: 1px;
  transform: translateY(-50%);
  
  /* largura da linha = largura do container - largura do texto - 20px de folga */
  width: calc(1100px - 100% - 20px);
}



section ul {
  list-style-type: disc;
  padding-left: 1.5rem;
}

section ul li {
  margin-bottom: 0.5rem;
  font-size: 1rem;
}

.btn-voltar-card {
  display: inline-block;
  background-color: rgb(0, 0, 0);
  color: #fff;
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.btn-voltar-card:hover {
  background-color: rgb(0, 0, 0);
}

@media screen and (max-width: 768px) {
  .projeto-topo {
    flex-direction: column;
    align-items: center;
  }

  .projeto-video img {
    width: 100%;
    max-width: 400px;
  }

  video {
    width: 100% !important;
    height: auto;
  }
}
</style>

</body>
</html>
