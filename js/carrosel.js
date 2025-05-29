document.addEventListener('DOMContentLoaded', () => {
    const galleryContainer = document.querySelector('.galeria-container');
    const galleryControlsContainer = document.querySelector('.galeria-controls');
    const galleryControls = ['previous', 'next'];
    const galleryItems = Array.from(document.querySelectorAll('.acervo-item'));

    class Carousel {
        constructor(container, items, controls) {
            this.carouselContainer = container;
            this.carouselArray = items;
            this.carouselControls = controls;
            this.currentIndex = 0; // ✅ Agora dentro da classe

            this.setControls();
            this.updateGallery();
            this.useControls(); // ✅ Já pode chamar aqui
        }

        updateGallery() {
            // Oculta todos os itens
            this.carouselArray.forEach(el => {
                el.style.display = 'none';
            });

            // Mostra os 5 itens a partir do índice atual
            for (let i = 0; i < 5; i++) {
                const index = (this.currentIndex + i) % this.carouselArray.length;
                this.carouselArray[index].style.display = 'block';
            }
        }

        setCurrentState(control) {
            if (control.classList.contains('galeria-controls-previous')) {
                this.currentIndex = (this.currentIndex - 1 + this.carouselArray.length) % this.carouselArray.length;
            } else if (control.classList.contains('galeria-controls-next')) {
                this.currentIndex = (this.currentIndex + 1) % this.carouselArray.length;
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
                control.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.setCurrentState(control);
                });
            });
        }
    }

    const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);
});
