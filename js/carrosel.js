let currentIndex = 0;

function updateCarousel() {
  const cards = document.querySelectorAll('.card3d');

  cards.forEach((card, index) => {
    card.classList.remove('active', 'left', 'right');

    if (index === currentIndex) {
      card.classList.add('active');
    } else if (index === (currentIndex - 1 + cards.length) % cards.length) {
      card.classList.add('left');
    } else if (index === (currentIndex + 1) % cards.length) {
      card.classList.add('right');
    }
  });
}

function nextCard() {
  const cards = document.querySelectorAll('.card3d');
  currentIndex = (currentIndex + 1) % cards.length;
  updateCarousel();
}

function prevCard() {
  const cards = document.querySelectorAll('.card3d');
  currentIndex = (currentIndex - 1 + cards.length) % cards.length;
  updateCarousel();
}

// Inicializa o carrossel ao carregar a página
window.addEventListener('DOMContentLoaded', updateCarousel);
