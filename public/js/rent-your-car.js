document.addEventListener('DOMContentLoaded', () => {
    const successPopup = document.querySelector('.success-popup');

    if (successPopup) {

        setTimeout(() => {

            successPopup.style.opacity = '0';

            successPopup.style.transition = 'opacity .3s ease';

            setTimeout(() => {

                window.location.href = './my-cars.php';

            }, 300);

        }, 2000);

    }
})