document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.js-make-admin');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {

            const userId = btn.dataset.id;

            showConfirmPopup(userId);
        });
    });

    function showConfirmPopup(userId) {

        const popup = document.createElement('div');
        popup.className = 'popup popup--confirm';

        popup.innerHTML = `
            <div class="popup__content">

                <h2 class="popup__title">
                    ¿Dar permisos de administrador?
                </h2>

                <p class="popup__text">
                    Esta acción dará acceso total al sistema a este usuario.
                </p>

                <div class="popup__actions">
                    <button class="popup__button popup__button--cancel">
                        Cancelar
                    </button>

                    <button class="popup__button popup__button--confirm">
                        Confirmar
                    </button>
                </div>

            </div>
        `;

        document.body.appendChild(popup);

        popup.querySelector('.popup__button--cancel').addEventListener('click', () => {
            popup.remove();
        });

        popup.querySelector('.popup__button--confirm').addEventListener('click', () => {

            fetch('/prestacoche/actions/make-admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${userId}`
            })
                .then(res => res.text())
                .then(() => {
                    window.location.reload();
                });

        });
    }

});