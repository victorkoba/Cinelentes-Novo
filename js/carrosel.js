document.addEventListener('DOMContentLoaded', () => {
  const galleryContainer = document.querySelector('.galeria-container');
  const galleryControlsContainer = document.querySelector('.galeria-controls');
  const galleryControls = ['previous', 'next'];
  const galleryItems = document.querySelectorAll('.galeria-itens');

  class Carousel {
    constructor(container, items, controls) {
      this.carouselContainer = container;
      this.carouselControls = controls;
      this.carouselArray = [...items];
    }

    updateGallery() {
      this.carouselArray.forEach(el => {
        for (let i = 1; i <= 5; i++) {
          el.classList.remove(`galeria-item-${i}`);
        }
      });
      this.carouselArray.slice(0, 5).forEach((el, i) => {
        el.classList.add(`galeria-item-${i + 1}`);
      });
    }

    setCurrentState(direction) {
      if (direction.className.includes('previous')) {
        this.carouselArray.unshift(this.carouselArray.pop());
      } else {
        this.carouselArray.push(this.carouselArray.shift());
      }
      this.updateGallery();
    }

    setControls() {
      this.carouselControls.forEach(control => {
        const btn = document.createElement('button');
        btn.className = `galeria-controls-${control}`;
        btn.innerText = control;
        galleryControlsContainer.appendChild(btn);
      });
    }

    useControls() {
      const triggers = [...galleryControlsContainer.childNodes];
      triggers.forEach(control => {
        control.addEventListener('click', e => {
          e.preventDefault();
          this.setCurrentState(control);
        });
      });
    }
  }

  const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);
  exampleCarousel.setControls();
  exampleCarousel.useControls();
});
