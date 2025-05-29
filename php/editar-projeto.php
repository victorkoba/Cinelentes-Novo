<?php
include 'verificar-login.php';

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
  <style>
  body {
  font-family: Arial, sans-serif;
  margin: 0;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-container {
  padding: 2rem;
  max-width: 900px;
  margin: 0 auto; /* centraliza horizontalmente */
  flex: 1 0 auto;
}

.titulo-pagina {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 2rem;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center; /* centraliza os inputs e labels */
  gap: 1.5rem;
}

label {
  width: 100%;
  max-width: 700px;
  font-weight: bold;
}

input[type="text"],
textarea,
select {
  width: 100%;
  max-width: 700px;
  padding: 1rem;
  border-radius: 12px;
  border: 1px solid #ccc;
  font-size: 1rem;
  background-color: #fff;
  box-sizing: border-box;
}

.galeria-fotos,
.galeria-videos {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 1rem;
  justify-content: center; /* centraliza os cards na linha */
}

.card-midia {
  border: 1px solid #ccc;
  border-radius: 12px;
  padding: 1rem;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card-midia img,
.card-midia video {
  max-width: 200px;
  border-radius: 8px;
  margin-bottom: 0.5rem;
  display: block;
}

.botao-confirmar {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50px;
  width: 170px;
  text-decoration: none;
  background-color: #000;
  color: #f5e9d4;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 18px;
  transition: background-color 0.3s, transform 0.2s;
  font-weight: 600;
}

.botao-confirmar:hover {
  background-color: #333;
  transform: scale(1.05);
}
  </style>
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
          form.submit(); // envia o formulário para o PHP
        }
      });
    });
  });
</script>

<body>
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

<?php
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
$fotosArray = array_filter(array_map('trim', explode(',', $projeto['fotos_acervo'] ?? '')));

// Buscar vídeos
$stmtVideos = $conexao->prepare("SELECT * FROM videos_acervo WHERE acervo_id = ?");
$stmtVideos->bind_param("i", $id);
$stmtVideos->execute();
$resultVideos = $stmtVideos->get_result();
$videos = [];
while ($row = $resultVideos->fetch_assoc()) {
    $videos[] = $row;
}

// Buscar curtas
$stmtCurtas = $conexao->prepare("SELECT * FROM curtas_acervo WHERE acervo_id = ?");
$stmtCurtas->bind_param("i", $id);
$stmtCurtas->execute();
$resultCurtas = $stmtCurtas->get_result();
$curtas = [];
while ($row = $resultCurtas->fetch_assoc()) {
    $curtas[] = $row;
}
?>

<main class="main-container">
  <h1 class="titulo-pagina">Editar Projeto</h1>

  <form method="POST" action="atualizar-projeto.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $projeto['id_acervo'] ?>"/>

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

    <!-- Foto de capa -->
    <h2>Foto de Capa:</h2>
    <?php if (!empty($projeto['foto_capa_acervo'])): ?>
      <div class="card-midia">
        <img src="uploads/<?= htmlspecialchars($projeto['foto_capa_acervo']) ?>" alt="Capa atual" />
        <label><input type="checkbox" name="excluir_capa" value="1"> Excluir</label>
      </div>
    <?php endif; ?>
    <input type="file" name="foto_capa" accept="image/*" />

    <!-- Galeria de Fotos -->
    <?php $fotosArray = array_filter(explode(',', $projeto['fotos_acervo'])); ?>
    <h2>Fotos:</h2>
    <div class="galeria-fotos">
      <?php foreach ($fotosArray as $index => $fotoNome): ?>
        <div class="card-midia">
          <img src="uploads/<?= htmlspecialchars(trim($fotoNome)) ?>" alt="Foto <?= $index + 1 ?>" />
          <label><input type="checkbox" name="excluir_fotos[]" value="<?= htmlspecialchars(trim($fotoNome)) ?>"> Excluir</label>
        </div>
      <?php endforeach; ?>
    </div>
    <input type="file" name="fotos[]" multiple accept="image/*" />

    <!-- Galeria de Vídeos -->
    <h2>Vídeos:</h2>
<div class="galeria-videos">
  <?php if (count($videos) > 0): ?>
    <?php foreach ($videos as $video): ?>
      <div class="card-midia">
        <video controls>
          <source src="exibir-arquivo.php?tabela=videos_acervo&id=<?= $video['id_videos'] ?>" type="video/mp4">
          Seu navegador não suporta vídeo.
        </video>
        <label>
          <input type="checkbox" name="excluir_videos[]" value="<?= $video['id_videos'] ?>"> Excluir
        </label>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Não há vídeos cadastrados para este projeto.</p>
  <?php endif; ?>
</div>
<input type="file" name="videos[]" multiple accept="video/*" />

    <!-- Curta -->
    <h2>Curta:</h2>
<?php if (count($curtas) > 0): ?>
  <?php foreach ($curtas as $curta): ?>
    <div class="card-midia">
      <video controls>
        <source src="exibir-arquivo.php?tabela=curtas_acervo&id=<?= $curta['id_curtas'] ?>" type="video/mp4">
        Seu navegador não suporta vídeo.
      </video>
      <label>
        <input type="checkbox" name="excluir_curta[]" value="<?= $curta['id_curtas'] ?>"> Excluir
      </label>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>Não há curta cadastrado para este projeto.</p>
<?php endif; ?>
<input type="file" name="curta" accept="video/*" />

    <button type="submit" class="botao-confirmar">Salvar Alterações</button>
  </form>
</main>

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
