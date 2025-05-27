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
  <title>Cinelentes</title>
  <link rel="stylesheet" href="../style/style.css" />
  <link rel="stylesheet" href="../style/editar-projeto.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <a href="cadastro.php" class="link-animado">CADASTRO ADMINISTRADOR</a>
      <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
    </nav>
  </header>

  <!-- Scripts de navegação -->
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

    document.getElementById("botao-logout").addEventListener("click", function(e) {
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

    <form method="POST" action="atualizar-projeto.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= htmlspecialchars($projeto['id_acervo']) ?>" />

      <!-- Título e descrição -->
      <div class="informacoes-iniciais">
        <input type="text" name="titulo" value="<?= htmlspecialchars($projeto['titulo']) ?>" class="input-titulo-projeto" required />
        <div class="linha-preta"></div>
        <textarea name="conteudo" class="textarea-conteudo-projeto" required><?= htmlspecialchars($projeto['descricao']) ?></textarea>
      </div>

      <!-- Edição -->
      <div class="select-edicao-container">
        <label for="edicao">Edição:</label>
        <select name="edicao" id="edicao" required>
          <?php foreach ([2023, 2024, 2025] as $ano): ?>
            <option value="<?= $ano ?>" <?= $projeto['edicao'] == $ano ? 'selected' : '' ?>><?= $ano ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Habilidades e feedback -->
      <section class="secao-habilidades">
        <div class="titulo-secao">
          <h2>Habilidades desenvolvidas</h2>
          <div class="linha-preta"></div>
        </div>
        <textarea name="habilidades" class="textarea-habilidades"><?= htmlspecialchars($projeto['habilidades']) ?></textarea>
      </section>

      <section class="secao-feedback">
        <div class="titulo-secao">
          <h2>Feedback</h2>
          <div class="linha-preta"></div>
        </div>
        <textarea name="feedback" class="textarea-feedback"><?= htmlspecialchars($projeto['feedback']) ?></textarea>
      </section>

      <!-- Atualização de conteúdo -->
      <section class="secao-conteudo">
        <div class="titulo-secao">
          <h2>Atualizar Conteúdo</h2>
          <div class="linha-preta"></div>
        </div>

        <div class="upload-buttons">
          <p><strong>Nova(s) Foto(s):</strong></p>
          <input type="file" name="fotos[]" multiple accept="image/*" />
        </div>

        <div class="upload-buttons">
          <p><strong>Nova(s) Vídeo(s):</strong></p>
          <input type="file" name="videos[]" multiple accept="video/*" />
        </div>

        <div class="upload-buttons">
          <p><strong>Novo Curta:</strong></p>
          <input type="file" name="curta" accept="video/*" />
        </div>

        <!-- Fotos atuais -->
        <?php if (!empty($fotos)): ?>
          <p><strong>Fotos Atuais:</strong></p>
          <div class="galeria-fotos">
            <?php foreach ($fotos as $foto): ?>
              <div class="card-midia">
                <img src="<?= htmlspecialchars($foto) ?>" alt="Foto Atual">
                <label>
                  <input type="checkbox" name="excluir_fotos[]" value="<?= htmlspecialchars($foto) ?>">
                  Remover
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Vídeos atuais -->
        <?php if (!empty($videos)): ?>
          <p><strong>Vídeos Atuais:</strong></p>
          <div class="galeria-videos">
            <?php foreach ($videos as $video): ?>
              <div class="card-midia">
                <video controls>
                  <source src="<?= htmlspecialchars($video) ?>" type="video/mp4">
                </video>
                <label>
                  <input type="checkbox" name="excluir_videos[]" value="<?= htmlspecialchars($video) ?>">
                  Remover
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Curta atual -->
        <?php if (!empty($projeto['curtas'])): ?>
          <p><strong>Curta Atual:</strong></p>
          <div style="margin-bottom:1rem;">
            <video controls width="300">
              <source src="<?= htmlspecialchars($projeto['curtas']) ?>" type="video/mp4">
            </video><br>
            <label>
              <input type="checkbox" name="excluir_curta" value="1">
              Remover curta
            </label>
          </div>
        <?php endif; ?>
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
