function minimizeCard(cardId) {
    Swal.fire({
        title: 'Deseja minimizar este card?',
        text: "Você poderá restaurá-lo depois.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Sim, minimizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const card = document.getElementById(cardId);
            card.classList.add('card-minimized');
            if (!card.querySelector('.restore-button')) {
                const restoreBtn = document.createElement('button');
                restoreBtn.innerHTML = '↩ <span style="font-size: 0.8rem;">Restaurar</span>';
                restoreBtn.className = 'restore-button';
                restoreBtn.onclick = () => restoreCard(cardId);
                card.appendChild(restoreBtn);
            }

            reorganizeCards();
        }
    });
}
function restoreCard(cardId) {
    Swal.fire({
        title: 'Restaurar card?',
        text: "O conteúdo será exibido novamente.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2ecc71',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Sim, restaurar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const card = document.getElementById(cardId);
            card.classList.remove('card-minimized');
            const restoreBtn = card.querySelector('.restore-button');
            if (restoreBtn) restoreBtn.remove();
            reorganizeCards();
        }
    });
}
function reorganizeCards() {
    const container = document.querySelector('.cards-container');
    const allCards = Array.from(container.children);
    allCards.sort((a, b) => {
        const aMin = a.classList.contains('card-minimized') ? 1 : 0;
        const bMin = b.classList.contains('card-minimized') ? 1 : 0;
        return aMin - bMin;
    });

    allCards.forEach(card => container.appendChild(card));
}
