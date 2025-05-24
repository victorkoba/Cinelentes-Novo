document.addEventListener("DOMContentLoaded", () => {
  // Minimizar cards
  window.minimizeCard = function (id) {
    const card = document.getElementById(id);
    if (!card) return;

    const content = card.querySelector(".card-content");
    const restoreBtn = card.querySelector(".restore-button");

    if (content.style.display === "none") {
      content.style.display = "flex";
      restoreBtn.style.display = "none";
      card.classList.remove("card-minimized");
    } else {
      content.style.display = "none";
      restoreBtn.style.display = "inline-block";
      card.classList.add("card-minimized");
    }
  };

  // Restaurar cards via botão
  document.querySelectorAll(".restore-button").forEach(btn => {
    btn.addEventListener("click", () => {
      const card = btn.closest(".content-card");
      const content = card.querySelector(".card-content");
      content.style.display = "flex";
      btn.style.display = "none";
      card.classList.remove("card-minimized");
    });
  });

  // Botões de upload para arquivos
  document.querySelectorAll('button.botao-upload[data-type]').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      const inputFile = document.getElementById(targetId);
      if (inputFile) inputFile.click();
    });
  });

  // Mostrar nome de arquivos selecionados
  document.querySelectorAll('input[type=file]').forEach(input => {
    input.addEventListener('change', () => {
      const displayId = input.id + "-name";
      const display = document.getElementById(displayId);
      if (!display) return;

      if (input.files.length === 0) {
        display.textContent = '';
      } else if (input.files.length === 1) {
        display.textContent = input.files[0].name;
      } else {
        display.textContent = `${input.files.length} arquivos selecionados`;
      }
    });
  });

  // Upload por link via SweetAlert
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
          if (!value) return 'Você precisa colocar um link!';
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

        container.innerHTML = ''; // Limpa prévias anteriores

        if (linkType.toLowerCase().includes('música') || linkType.toLowerCase().includes('musica')) {
          const audio = document.createElement('audio');
          audio.controls = true;
          audio.src = url;
          container.appendChild(audio);
        } else {
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
});
