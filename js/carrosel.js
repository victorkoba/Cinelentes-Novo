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
                el.classList.remove('galeria-item-1');
                el.classList.remove('galeria-item-2');
                el.classList.remove('galeria-item-3');
                el.classList.remove('galeria-item-4');
                el.classList.remove('galeria-item-5');
            });

            this.carouselArray.slice(0, 5).forEach((el, i) => {
                el.classList.add(`galeria-item-${i + 1}`);
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