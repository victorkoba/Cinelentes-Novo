const galleryContainer = document.querySelector('.galleria-container');
const galleryControlsContainer = document.querySelector('.galleria-controls');
const galleryControls = ['previous', 'next'];
const galleryItems = document.querySelectorAll('.galleria-itens');

class Carousel {

  constructor(container, items, controls) {
    this.carouselContainer = container;
    this.carouselControls = controls;
    this.carouselArray = [...items];
  }

  updateGallery() {
    this.carouselArray.forEach(el => {
      el.classList.remove('galleria-item-1');
      el.classList.remove('galleria-item-2');
      el.classList.remove('galleria-item-3');
      el.classList.remove('galleria-item-4');
      el.classList.remove('galleria-item-5');
    });

    this.carouselArray.slice(0, 5).forEach((el, i) => {
      el.classList.add(`galleria-item-${i + 1}`);
    });
  }
}
