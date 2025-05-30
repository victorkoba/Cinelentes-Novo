<?php
include 'verificar-login.php';
include 'conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "ID do projeto não informado.";
  exit;
}

$stmt = $conexao->prepare("SELECT * FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$projeto = $stmt->get_result()->fetch_assoc();

$fotosArray = [];
if (!empty($projeto['fotos_acervo'])) {
  $fotosArray = json_decode($projeto['fotos_acervo'], true);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cinelentes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/editar-projeto.css">
</head>
<body>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById("form-evento");

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    Swal.fire({
      title: "Deseja salvar este evento?",
      text: "Você pode editar depois, mas isso vai salvá-lo no banco de dados.",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim, salvar!",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});
</script>

<header class="header-geral">
  <h1 class="sesi-senai">SESI | SENAI</h1>
  <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt=""></a>

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
    <a href="cadastro.php" class="link-animado">CADASTRO ADMINISTRADOR</a>
    <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
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

<main class="main-container">
  <h1 class="titulo-pagina">Editar Projeto</h1>

  <form id="form-evento" method="POST" action="atualizar-projeto.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($projeto['id_acervo']) ?>" />

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($projeto['titulo']) ?>" required />

    <label for="conteudo">Descrição:</label>
    <textarea id="conteudo" name="conteudo" required><?= htmlspecialchars($projeto['descricao']) ?></textarea>

    <label for="edicao">Edição:</label>
    <select id="edicao" name="edicao" required>
      <?php foreach ([2023, 2024, 2025] as $ano): ?>
        <option value="<?= $ano ?>" <?= $projeto['edicao'] == $ano ? 'selected' : '' ?>><?= $ano ?></option>
      <?php endforeach; ?>
    </select>

    <label for="habilidades">Habilidades:</label>
    <textarea id="habilidades" name="habilidades"><?= htmlspecialchars($projeto['habilidades']) ?></textarea>

    <label for="feedback">Feedback:</label>
    <textarea id="feedback" name="feedback"><?= htmlspecialchars($projeto['feedback']) ?></textarea>

    <h2>Foto de Capa:</h2>
    <?php if (!empty($projeto['foto_capa_acervo'])): ?>
      <div class="card-midia">
        <img src="<?= htmlspecialchars($projeto['foto_capa_acervo']) ?>" alt="Capa atual">
        <label><input type="checkbox" name="excluir_capa" value="1"> Excluir</label>
      </div>
    <?php endif; ?>

    <h2>Fotos:</h2>
    <div class="galeria-fotos">
      <?php if (!empty($fotosArray)): ?>
        <?php foreach ($fotosArray as $index => $fotoNome): ?>
          <div class="card-midia">
            <img src="<?= htmlspecialchars(trim($fotoNome)) ?>" alt="Foto <?= $index + 1 ?>" />
            <label><input type="checkbox" name="excluir_fotos[]" value="<?= htmlspecialchars(trim($fotoNome)) ?>"> Excluir</label>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <input type="file" name="fotos[]" multiple accept="image/*" />

    <h2>Vídeos:</h2>
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

    <h2>Curtas:</h2>
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
