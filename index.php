<?php
include './php/conexao.php';

$meses_abreviados = [
  '01' => 'JAN',
  '02' => 'FEV',
  '03' => 'MAR',
  '04' => 'ABR',
  '05' => 'MAI',
  '06' => 'JUN',
  '07' => 'JUL',
  '08' => 'AGO',
  '09' => 'SET',
  '10' => 'OUT',
  '11' => 'NOV',
  '12' => 'DEZ'
];

$eventos = [];

$stmt = $conexao->prepare("SELECT id_data, titulo_data, dia, descricao_data FROM data ORDER BY dia ASC");

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }
}

$stmt->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinelentes</title>
  <link rel="stylesheet" href="./style/pagina-inicial.css">
  <link rel="stylesheet" href="./style/style.css">
  <script src="./js/carrosel.js"></script>
  <script src="./js/main.js"></script>
</head>
<div id="modal-agenda" class="modal-agenda">
  <div class="modal-conteudo">
    <span class="fechar-modal" onclick="fecharModal()">&times;</span>
    <div class="modal-header">
      <div class="data-modal">
        <span class="dia" id="modal-dia"></span>
        <span class="mes" id="modal-mes"></span>
      </div>
      <h2 id="modal-titulo"></h2>
    </div>
    <p id="modal-descricao"></p>
  </div>
</div>
<body>
  <header class="header-geral">
    <h1 class="sesi-senai">SESI | SENAI</h1>
    <img id="logo-header" src="./img/logo-cinelentes-novo.png" alt="">
    <nav>
      <a href="#" class="link-animado">INÍCIO</a>
      <div class="dropdown">
        <a onclick="myFunction()" class="dropbtn link-animado">EDIÇÕES</a>
        <div id="myDropdown" class="dropdown-content">
          <a href="./php/edicao2023.php" class="link-animado">EDIÇÃO 2023</a>
          <a href="./php/edicao2024.php" class="link-animado">EDIÇÃO 2024</a>
          <a href="./php/edicao2025.php" class="link-animado">EDIÇÃO 2025</a>
        </div>
      </div>
      <a href="./php/quem-somos.php" class="link-animado">QUEM SOMOS</a>
      <a href="#grid-agenda" class="link-animado">AGENDA</a>
    </nav>
  </header>
  <main>
        <!-- Introdução -->
        <div id="grid-introducao">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">O que é o Cinelentes?</h1>
            </div>
            <div class="introducao-texto">
                <div class="texto">
                <p class="conteudo-introducao">
                    O Projeto “Cinelentes” tem o objetivo de fomentar a cultura no ambiente escolar,
                    democratizando o acesso ao cinema e outras linguagens artísticas/culturais.
                    Proporcionar um ambiente de interação, debate e criatividade que envolve não só o corpo docente
                    e discente, mas toda a comunidade escolar, proporcionando a criticidade necessária para buscar
                    novas lentes através de curtas metragens. Durante cada mês serão abordados temas relacionados
                    a datas comemorativas relevantes daquele mês.
                </p>
                </div>
                <div class="imagem">
                    <figure>
                        <img id="img-idealizadores" src="./img/img-mes-mulher-foto1.jpg" alt="Imagem idealizadores"/>
                        <figcaption>Foto dos idealizadores do projeto no evento "Mês das Mulheres".</figcaption>
                    </figure>
                </div>

            </div>
        </div>    
        <div id="grid-destaques">
            <div id="titulo">
                <h1 class="titulo-pagina-inicial">Destaques</h1>
            </div>
            <div class="galeria">
              <div class="galeria-container">
                <img  class="galeria-itens galeria-item-1" src="./img/img-mes-mulher-foto1.jpg"  data-index="1" alt="" >
                <img class="galeria-itens galeria-item-2" src="./img/img-mes-cultura-coreana.jpg"  data-index="2" alt="">
                <img class="galeria-itens galeria-item-3" src="./img/img-inclusao.jpg"  data-index="3" alt="">
                <img class="galeria-itens galeria-item-4" src="./img/img-mes-trabalho.jpg"  data-index="4" alt="">
                <img class="galeria-itens galeria-item-5" src="./img/img-mes-mulher-foto3.jpg"  data-index="5" alt="">
                <div class="galeria-controls"></div>
              </div>
            </div>
 
            
        <div id="grid-agenda">
          <div id="titulo-agenda">
            <h1 class="titulo-pagina-inicial">Agenda</h1>
              <div class="agenda-eventos">
                <?php foreach ($eventos as $evento): 
                  $dataObj = new DateTime($evento['dia']);
                  $dia = $dataObj->format('d');
                  $numero_mes = $dataObj->format('m');
                  $mes = $meses_abreviados[$numero_mes];
                ?>
                <div class="agenda-card" onclick="abrirModal(
                  '<?= htmlspecialchars($evento['titulo_data']) ?>',
                  '<?= htmlspecialchars($evento['descricao_data']) ?>',
                  '<?= htmlspecialchars($dia) ?>',
                  '<?= htmlspecialchars($mes) ?>'
                )">

                  <div class="data-agenda">
                    <span class="dia"><?= htmlspecialchars($dia) ?></span>
                    <span class="mes"><?= htmlspecialchars($mes) ?></span>
                  </div>
                  
                    <div class="overflow titulo-agenda" ><?= htmlspecialchars($evento['titulo_data']) ?></div>
                    <div class="overflow descricao-agenda"><?= htmlspecialchars($evento['descricao_data']) ?></div>
                  
                </div>
            <?php endforeach; ?>
        </div>
    </main>
  <footer class="footer-container">
    <div class="footer-topo">
      <div class="div-vazia"></div>
      <div class="footer-logo-container">
        <img id="logo-cinelentes-footer" src="./img/logo-cinelentes-novo.png" alt="Cinelentes">
      </div>
      <div class="botao-login-container">
        <a href="./php/login.php" class="botao-login">Login Administrador</a>
      </div>
    </div>
    <div class="linha-branca-footer"></div>
    <div class="linha-preta-footer">
      <p class="footer-direitos">Todos os direitos reservados.</p>
    </div>
  </footer>
   <script>
    function abrirModal(titulo, descricao, dia, mes) {
      document.getElementById('modal-titulo').innerText = titulo;
      document.getElementById('modal-descricao').innerText = descricao;
      document.getElementById('modal-dia').innerText = dia;
      document.getElementById('modal-mes').innerText = mes;
      document.getElementById('modal-agenda').style.display = 'block';
    }

    function fecharModal() {
      document.getElementById('modal-agenda').style.display = 'none';
      document.body.style.overflow = 'auto';
    }
  </script>
</body>
</html>
