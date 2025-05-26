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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="body-pagina-inicial">
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <a href="pagina-inicial-adm.php"><img id="logo-header" src="../img/logo-cinelentes-novo.png" alt="Logo Cinelentes" /></a>
    <nav>
      <a href="pagina-inicial-adm.php" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="edicao2023-adm.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="edicao2024-adm.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="edicao2025-adm.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="cadastro.php" class="link-animado">CADASTRO ADMININSTRADOR</a>
      <a id="botao-logout" href="logout.php" class="button-logout">Logout</a>
      <script>
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
    </nav>
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
        <!-- DENTRO DO FORM: substitua a seção de exibição de mídias por isto -->

        <div style="margin-top: 2rem;">
          <p><strong>Fotos Atuais:</strong></p>
          <?php if (!empty($fotos)): foreach ($fotos as $index => $foto): ?>
              <div style="display:inline-block; margin:5px; text-align:center;">
                <img src="<?php echo htmlspecialchars($foto); ?>" style="max-width:150px;"><br>
                <label>
                  <input type="checkbox" name="excluir_fotos[]" value="<?php echo htmlspecialchars($foto); ?>">
                  Remover
                </label>
              </div>
          <?php endforeach;
          endif; ?>

          <p><strong>Vídeos Atuais:</strong></p>
          <?php if (!empty($videos)): foreach ($videos as $index => $video): ?>
              <div style="margin-bottom: 1rem;">
                <video controls width="300">
                  <source src="<?php echo htmlspecialchars($video); ?>" type="video/mp4">
                </video><br>
                <label>
                  <input type="checkbox" name="excluir_videos[]" value="<?php echo htmlspecialchars($video); ?>">
                  Remover
                </label>
              </div>
          <?php endforeach;
          endif; ?>

          <p><strong>Curta Atual:</strong></p>
          <?php if (!empty($projeto['curtas'])): ?>
            <div style="margin-bottom:1rem;">
              <video controls width="300">
                <source src="<?php echo htmlspecialchars($projeto['curtas']); ?>" type="video/mp4">
              </video><br>
              <label>
                <input type="checkbox" name="excluir_curta" value="1">
                Remover curta
              </label>
            </div>
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