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

$stmtFotos = $conexao->prepare("SELECT * FROM fotos_acervo WHERE acervo_id = ?");
$stmtFotos->bind_param("i", $id);
$stmtFotos->execute();
$resultFotos = $stmtFotos->get_result();
$fotos = [];
while ($row = $resultFotos->fetch_assoc()) {
  $fotos[] = $row;
}

$fotosArray = explode ('||', $projeto['foto_capa_acervo'] ?? '');

// Agora sim, fora do while, processamos músicas
$musicasArray = [];
if (!empty($projeto['musicas'])) {
  $decoded = json_decode($projeto['musicas'], true);
  if (is_array($decoded)) {
    $musicasArray = $decoded;
  } else {
    $musicasArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $projeto['musicas'])));
  }
}
?>
<?php
function embedLink($url) {
  // YouTube
  if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $matches) || preg_match('/youtube\.com\/watch\?v=([^\?&]+)/', $url, $matches)) {
    return 'https://www.youtube.com/embed/' . $matches[1];
  }

  // Vimeo
  if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
    return 'https://player.vimeo.com/video/' . $matches[1];
  }

  // Spotify (pode ajustar conforme necessário)
  if (strpos($url, 'spotify.com') !== false) {
    return str_replace('/track/', '/embed/track/', $url);
  }

  // Default (embed direto, sem garantias)
  return $url;
}

function linkify($text) {
    $pattern = '/(https?:\/\/[^\s]+)/i';
    return preg_replace($pattern, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $text);
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
  <link rel="stylesheet" href="../style/ver-projeto.css">
</head>
<body class="body-pagina-inicial">

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

<main class="main-projeto">
  <form id="form-evento" method="POST" action="atualizar-projeto.php" enctype="multipart/form-data">
  
  <section>
    <div class="projeto-topo">
      <div class="projeto-texto">
        <h1 class="titulo-pagina">Editar Projeto</h1>
        <label for="edicao">Edição</label>
        <select id="edicao" name="edicao" required>
          <?php foreach ([2023, 2024, 2025] as $ano): ?>
            <option value="<?= $ano ?>" <?= $projeto['edicao'] == $ano ? 'selected' : '' ?>><?= $ano ?></option>
          <?php endforeach; ?>
        </select>
      
          <input type="hidden" name="id" value="<?= htmlspecialchars($projeto['id_acervo']) ?>" />
      
          <label for="titulo">Título:</label>
          <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($projeto['titulo']) ?>" required />
      
          <label for="conteudo">Descrição:</label>
          <textarea id="conteudo" name="conteudo" required><?= htmlspecialchars($projeto['descricao']) ?></textarea>
      </div>
      <div class="projeto-video">
        <?php if (!empty($fotosArray[0])): ?>
          <img src="<?= htmlspecialchars(trim($fotosArray[0])) ?>" alt="Imagem de destaque" id="imgCapaPreview">
          <!-- <div class="overlay" onclick="document.getElementById('inputCapa').click();">
            Substituir Imagem
          </div> -->
        <?php endif; ?>
        <!-- <input type="file" name="nova_capa" id="inputCapa" accept="image/*" onchange="previewCapa(this)"> -->
      </div>

      <!-- <script>
        function previewCapa(input) {
          const file = input.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              document.getElementById('imgCapaPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        }
      </script> -->
    </div>
  </section>

<section>
  <h2 class="titulo-linha">Fotos</h2>

  <!-- Botão para adicionar novas imagens -->
  <div class="adicionar-fotos-container">
    <label class="btn-adicionar-imagens">
      + Adicionar novas imagens
      <input class="input-adicionar-imagens" type="file" name="fotos[]" accept="image/*" multiple onchange="mostrarNomesArquivos(this)">
    </label>
    <div id="nomesSelecionados" class="nomes-imagens-selecionadas"></div>
  </div>

<div class="container-fotos">
  <div class="grid-fotos">
    <?php
    $sqlFotos = "SELECT id_fotos, nome_arquivo FROM fotos_acervo WHERE acervo_id = ?";
    $stmt = $conexao->prepare($sqlFotos);
    $stmt->bind_param("i", $projeto['id_acervo']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($fotos = $result->fetch_assoc()):
      $fotoId = $fotos['id_fotos'];
    ?>
      <div class="foto-grid-item">
        <img class="img-fotos" src="exibir-foto.php?id=<?= $fotoId ?>" alt="Foto do projeto">

        <!-- Botão abaixo da imagem -->
        <label class="btn-abaixo-foto">
          <input type="checkbox" name="excluir_fotos[]" value="<?= $fotoId ?>" hidden>
          <button type="button" class="btn-excluir" onclick="alternarExclusao(this)">Excluir</button>
        </label>
      </div>
    <?php endwhile; $stmt->close(); ?>
  </div>
</div>
</section>

<script>
function alternarExclusao(button) {
  const checkbox = button.closest('label').querySelector('input[type="checkbox"]');
  const card = button.closest('.foto-grid-item') || button.closest('.card-midia');

  checkbox.checked = !checkbox.checked;

  if (checkbox.checked) {
    button.textContent = "Marcada";
    button.style.backgroundColor = "#999";
    button.style.cursor = "default";
    card?.classList.add("marcada");
  } else {
    button.textContent = "Excluir";
    button.style.backgroundColor = "#e63946";
    button.style.cursor = "pointer";
    card?.classList.remove("marcada");
  }
}

  function mostrarNomesArquivos(input) {
    const container = document.getElementById("nomesSelecionados");
    const arquivos = input.files;

    if (arquivos.length === 0) {
      container.innerHTML = "";
      return;
    }

    let nomes = "<strong>Selecionadas:</strong><ul>";
    for (let i = 0; i < arquivos.length; i++) {
      nomes += "<li>" + arquivos[i].name + "</li>";
    }
    nomes += "</ul>";
    container.innerHTML = nomes;
  }
</script>

<section>
  <h2 class="titulo-linha">Vídeos</h2>
  
  <div class="adicionar-fotos-container">
    <label class="btn-adicionar-imagens">
      + Adicionar novos vídeos
      <input class="input-adicionar-imagens" type="file" name="videos[]" accept="video/mp4" multiple>
    </label>
  </div>
  
  <div class="container-fotos">
    <div class="grid-fotos">
      <?php
      $sqlVideos = "SELECT id_videos, nome_arquivo FROM videos_acervo WHERE acervo_id = ?";
      $stmt = $conexao->prepare($sqlVideos);
      $stmt->bind_param("i", $projeto['id_acervo']);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($video = $result->fetch_assoc()):
        $videoId = $video['id_videos'];
      ?>
        <div class="foto-grid-item card-midia"> <!-- mantive foto-grid-item para a estilização -->
          <video controls width="500" >
            <source src="exibir-video.php?id=<?= $videoId ?>" type="video/mp4">
            Seu navegador não suporta vídeo.
          </video>
          <div class="foto-over">
            <label>
              <input type="checkbox" name="excluir_videos[]" value="<?= $videoId ?>" hidden>
              <button type="button" class="btn-excluir" onclick="alternarExclusao(this)">Excluir</button>
            </label>
          </div>
        </div>
      <?php endwhile; $stmt->close(); ?>
    </div>
  </div>
</section>

<!-- MÚSICAS -->
   <?php if (!empty($musicasArray)): ?>
  <section>
    <h2 class="titulo-linha">Músicas</h2>
    <div class="adicionar-fotos-container">
    <label class="btn-adicionar-imagens">
      + Adicionar novas músicas
<input class="input-adicionar-imagens" type="text" name="novas_musicas[]" multiple placeholder="Cole os links aqui, separados por vírgula">    </label>
  </div>
    <div class="grid-musicas">
<?php foreach ($musicasArray as $indice => $link): ?>
  <div class="musica-item card-midia">
    <iframe 
      width="100%" height="220" 
      src="<?= htmlspecialchars(embedLink($link)) ?>" 
      frameborder="0" 
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
      allowfullscreen>
    </iframe>
<div class="musica-botao">
  <label>
    <input type="checkbox" name="excluir_musicas[]" value="<?= $indice ?>" hidden>
    <button type="button" class="btn-excluir" onclick="alternarExclusao(this)">Excluir</button>
  </label>
</div>
  </div>
<?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<script>
function alternarExclusao(botao) {
  const label = botao.closest('label');
  const checkbox = label.querySelector('input[type="checkbox"]');
  if (checkbox.checked) {
    checkbox.checked = false;
    botao.textContent = 'Excluir';
    botao.classList.remove('btn-excluir-ativo');
  } else {
    checkbox.checked = true;
    botao.textContent = 'Cancelar';
    botao.classList.add('btn-excluir-ativo');
  }
}

// Função para adicionar mais inputs de links de música
function adicionarCampoMusica() {
  const container = document.querySelector('.adicionar-fotos-container');
  const novoInput = document.createElement('input');
  novoInput.type = 'url';
  novoInput.name = 'novas_musicas[]';
  novoInput.placeholder = 'Cole o link do YouTube';
  novoInput.className = 'input-adicionar-imagens';
  novoInput.style.width = '80%';
  novoInput.style.marginTop = '0.5rem';
  novoInput.onkeypress = function(e) {
    if (e.key === 'Enter') {
      adicionarCampoMusica();
      e.preventDefault();
    }
  };
  container.appendChild(novoInput);
}
</script>

<section>
  <h2 class="titulo-linha">Curtas</h2>

  <!-- Botão para adicionar novos curtas -->
  <div class="adicionar-fotos-container">
    <label class="btn-adicionar-imagens">
      + Adicionar novos curtas
      <input class="input-adicionar-imagens" type="file" name="curtas[]" accept="video/mp4" multiple>
    </label>
  </div>

  <div class="grid-fotos">
    <?php
    $sqlCurtas = "SELECT id_curtas, nome_arquivo FROM curtas_acervo WHERE acervo_id = ?";
    $stmt = $conexao->prepare($sqlCurtas);
    $stmt->bind_param("i", $projeto['id_acervo']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($curta = $result->fetch_assoc()):
      $curtaId = $curta['id_curtas'];
    ?>
      <div class="foto-grid-item card-midia">
        <video controls width="500">
          <source src="exibir-curta.php?id=<?= $curtaId ?>" type="video/mp4">
          Seu navegador não suporta vídeo.
        </video>
        <div class="foto-over">
          <label>
            <input type="checkbox" name="excluir_curtas[]" value="<?= $curtaId ?>" hidden>
            <button type="button" class="btn-excluir" onclick="alternarExclusao(this)">Excluir</button>
          </label>
        </div>
      </div>
    <?php endwhile; $stmt->close(); ?>
  </div>
</section>

      <section>
        <h2 class="titulo-linha">Habilidades</h2>
        <textarea id="habilidades" name="habilidades"><?= htmlspecialchars($projeto['habilidades']) ?></textarea>
      </section>
      

      <section>
        <h2 class="titulo-linha">Feedback</h2>
        <textarea id="feedback" name="feedback"><?= htmlspecialchars($projeto['feedback']) ?></textarea>
      </section>
      <div class="botao-editar">
        <button type="submit" class="botao-confirmar">Salvar Alterações</button>
      </div>
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
