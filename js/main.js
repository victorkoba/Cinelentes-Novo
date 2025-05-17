// Function dropdown página inicial
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function (event) {
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

function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}
// Fechar o dropdown clicando fora
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        for (const openDropdown of dropdowns) {
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
};

// Abrir modal lateral na página inicial de agenda
function abrirModal(titulo, descricao, dia, mes) {
  document.getElementById('modal-titulo').innerText = titulo;
  document.getElementById('modal-descricao').innerText = descricao;
  document.getElementById('modal-dia').innerText = dia;
  document.getElementById('modal-mes').innerText = mes;
  document.getElementById('modal-agenda').classList.add('ativo');
}

function fecharModal() {
  document.getElementById('modal-agenda').classList.remove('ativo');
}