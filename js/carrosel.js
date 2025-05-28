document.addEventListener('DOMContentLoaded', () => {
    const galleryContainer = document.querySelector('.galeria-container');
    const galleryControlsContainer = document.querySelector('.galeria-controls');
    const galleryControls = ['previous', 'next'];
    const galleryItems = document.querySelectorAll('.acervo-item');

    class Carousel {
        constructor(container, items, controls) {
            this.carouselContainer = container;
            this.carouselControls = controls;
            this.carouselArray = [...items];
        }

        updateGallery() {
            this.carouselArray.forEach(el => {
    for (let i = 1; i <= 5; i++) {
        el.classList.remove(`acervo-item-${i}`);
    }
});

this.carouselArray.slice(0, 5).forEach((el, i) => {
    el.classList.add(`acervo-item-${i + 1}`);
});
        }

        setCurrentState(direction) {
            if (direction.classList.contains('galeria-controls-previous')) {
                this.carouselArray.unshift(this.carouselArray.pop());
            } else if (direction.classList.contains('galeria-controls-next')) {
                this.carouselArray.push(this.carouselArray.shift());
            }
            this.updateGallery();
        }

        setControls() {
            this.carouselControls.forEach(control => {
                const button = document.createElement('button');
                button.className = `galeria-controls-${control}`;
                button.innerText = control === 'previous' ? '❮' : '❯';
                galleryControlsContainer.appendChild(button);
            });
        }

        useControls() {
            const triggers = [...galleryControlsContainer.querySelectorAll('button')];
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