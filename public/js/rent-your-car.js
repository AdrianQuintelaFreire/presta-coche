document.addEventListener('DOMContentLoaded', () => {
    const successPopup = document.querySelector('.success-popup');

    if (successPopup) {

        setTimeout(() => {

            successPopup.style.opacity = '0';
            successPopup.style.transition = 'opacity .3s ease';

            setTimeout(() => {

                const destino = '/prestacoche/pages/my-cars.php';

                window.location.href = destino;

            }, 2000);

        }, 2000);

    }
});