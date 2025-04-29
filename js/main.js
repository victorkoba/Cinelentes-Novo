// Function dropdown página inicial
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
    window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }

  let currentIndex = 0;

  function showSlide(index) {
      const wrapper = document.getElementById('carouselWrapper');
      const slides = document.querySelectorAll('.carousel-slide');
      const totalSlides = slides.length;
  
      if (index >= totalSlides) {
          currentIndex = 0;
      } else if (index < 0) {
          currentIndex = totalSlides - 1;
      } else {
          currentIndex = index;
      }
  
      wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
  }
  
  function nextSlide() {
      showSlide(currentIndex + 1);
  }
  
  function prevSlide() {
      showSlide(currentIndex - 1);
  }
  
  // Dropdown
  function toggleDropdown() {
      document.getElementById("myDropdown").classList.toggle("show");
  }
  
  // Fechar o dropdown clicando fora
  window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
          const dropdowns = document.getElementsByClassName("dropdown-content");
          for (const openDropdown of dropdowns) {
              if (openDropdown.classList.contains('show')) {
                  openDropdown.classList.remove('show');
              }
          }
      }
  };
  