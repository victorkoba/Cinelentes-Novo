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
  <title>Cinelentes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
  <link rel="stylesheet" href="../style/editar-projeto.css" />
  <link rel="stylesheet" href="../style/style.css" />
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
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
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

      // Alterna classe 'open' para animação do botão
      hamburguer.classList.toggle('open');

      // Fecha dropdown quando abrir/fechar menu
      dropdownContent.classList.remove('show');
    });

    // Dropdown toggle mobile
    dropdownBtn.addEventListener('click', (e) => {
      e.preventDefault();
      dropdownContent.classList.toggle('show');
    });

    // Fecha dropdown se clicar fora
    window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropbtn')) {
        dropdownContent.classList.remove('show');
      }
    });
  </script>
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
  </header>
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

      <?php
      $fotosArray = explode(',', $projeto['fotos_acervo']);
      ?>
      <h2>Fotos:</h2>
      <div class="galeria-fotos">
        <?php foreach ($fotosArray as $index => $fotoNome): ?>
          <?php $fotoNome = trim($fotoNome); ?>
          <div class="card-midia">
            <img src="uploads/<?= htmlspecialchars($fotoNome) ?>" alt="Foto <?= $index + 1 ?>" />
            <label><input type="checkbox" name="excluir_fotos[]" value="<?= htmlspecialchars($fotoNome) ?>"> Excluir</label>
          </div>
        <?php endforeach; ?>
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