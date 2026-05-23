document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('profile-form');

    if (!form) return; // 🔥 EVITA QUE ROMPA TODO

    const password = document.getElementById('contrasinal');
    const confirmPassword = document.getElementById('contrasinal_confirm');

    form.addEventListener('submit', (e) => {

    const pass = password.value.trim();
    const confirm = confirmPassword.value.trim();

    if (pass === '' && confirm === '') return;

    if (pass === '' || confirm === '') {
        e.preventDefault();
        showPasswordPopup("empty");
        return;
    }

    if (pass !== confirm) {
        e.preventDefault();
        showPasswordPopup("mismatch");
        return;
    }
});

    function showPasswordPopup() {
  

        const popup = document.createElement('div');
        popup.className = 'popup popup--error';

        popup.innerHTML = `
            <div class="popup__content">
                <span class="popup__icon">⚠</span>
                <h2 class="popup__title">Las contraseñas no coinciden</h2>
                <p class="popup__text">
                    Asegúrate de escribir la misma contraseña en ambos campos.
                </p>
                <button class="popup__button">Entendido</button>
            </div>
        `;

        document.body.appendChild(popup);

        popup.querySelector('.popup__button').addEventListener('click', () => {
            popup.remove();
        });
    }

});