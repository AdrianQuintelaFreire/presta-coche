document.addEventListener('DOMContentLoaded', () => {

    const links = document.querySelectorAll('.js-delete-car');

    links.forEach(link => {

        link.addEventListener('click', (e) => {
            e.preventDefault();

            const url = link.getAttribute('href');

            showConfirmPopup(url);
        });
    });

    function showConfirmPopup(url) {

        const popup = document.createElement('div');
        popup.className = 'popup popup--error';

        popup.innerHTML = `
            <div class="popup__content">

                <span class="popup__icon">⚠</span>

                <h2 class="popup__title">Eliminar vehículo</h2>

                <p class="popup__text">
                    ¿Seguro que quieres eliminar este vehículo?
                    Esta acción no se puede deshacer.
                </p>

                <button class="popup__button popup__button--danger">
                    Sí, eliminar
                </button>

                <button class="popup__button popup__button--cancel">
                    Cancelar
                </button>

            </div>
        `;

        document.body.appendChild(popup);

        popup.querySelector('.popup__button--danger').addEventListener('click', () => {
            window.location.href = url;
        });

        popup.querySelector('.popup__button--cancel').addEventListener('click', () => {
            popup.remove();
        });
    }
});