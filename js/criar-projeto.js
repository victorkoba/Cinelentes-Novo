
  // Minimizar cards
  function minimizeCard(id) {
    const card = document.getElementById(id);
    if (!card) return;
    const content = card.querySelector(".card-content");
    if (content.style.display === "none") {
      content.style.display = "block";
    } else {
      content.style.display = "none";
    }
  }

  // Botões de upload que disparam o input escondido
  document.querySelectorAll('button.botao-upload[data-type]').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      const inputFile = document.getElementById(targetId);
      if (inputFile) {
        inputFile.click();
      }
    });
  });

  // Mostrar nome dos arquivos selecionados
  function updateFileName(input, displayId) {
    const display = document.getElementById(displayId);
    if (!display) return;
    if (!input.files || input.files.length === 0) {
      display.textContent = '';
      return;
    }
    if (input.files.length === 1) {
      display.textContent = input.files[0].name;
    } else {
      display.textContent = `${input.files.length} arquivos selecionados`;
    }
  }

  // Atualiza nomes para todos inputs file
  document.querySelectorAll('input[type=file]').forEach(input => {
    input.addEventListener('change', () => {
      updateFileName(input, input.id + '-name');
    });
  });

// Upload por link (prompt modal com SweetAlert)
document.querySelectorAll('button.botao-upload[data-action="link"]').forEach(button => {
  button.addEventListener('click', async () => {
    const linkType = button.getAttribute('data-link-type') || 'vídeo';
    const containerId = button.getAttribute('data-container-id');
    if (!containerId) return;

    const { value: url } = await Swal.fire({
      title: `Coloque o link do ${linkType}`,
      input: 'url',
      inputLabel: `Link do ${linkType}:`,
      inputPlaceholder: `Digite ou cole o link do ${linkType}`,
      showCancelButton: true,
      inputValidator: (value) => {
        if (!value) {
          return 'Você precisa colocar um link!';
        }
        try {
          new URL(value);
        } catch {
          return 'Por favor, coloque uma URL válida!';
        }
      }
    });

    if (url) {
      const container = document.getElementById(containerId);
      if (!container) return;

      // Limpa preview anterior
      container.innerHTML = '';

      // Detecta tipo de mídia: vídeo ou música (áudio)
      if (linkType.toLowerCase().includes('música') || linkType.toLowerCase().includes('musica')) {
        // Cria um player de áudio
        const audio = document.createElement('audio');
        audio.controls = true;
        audio.src = url;
        container.appendChild(audio);

        // Preenche o input de texto da música, se existir
        const inputText = container.previousElementSibling.querySelector('input[type="text"]');
        if (inputText) {
          inputText.value = url;
        }

      } else {
        // Cria um player de vídeo
        const video = document.createElement('video');
        video.controls = true;
        video.width = 320;
        video.height = 240;
        video.src = url;
        container.appendChild(video);
      }
    }
  });
});