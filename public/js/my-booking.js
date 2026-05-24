document.addEventListener('DOMContentLoaded', () => {

    const bookingModal = document.getElementById("bookingModal");
    const bookingDatesList = document.getElementById("bookingDatesList");
    const bookingMatricula = document.getElementById("bookingMatricula");
    const closeBookingModal = document.getElementById("closeBookingModal");

    document.querySelectorAll(".open-booking-modal")
        .forEach(button => {

            button.addEventListener("click", () => {

                const matricula = button.dataset.matricula;
                const fechas = JSON.parse(button.dataset.fechas);

                bookingMatricula.textContent = matricula;

                bookingDatesList.innerHTML = "";

                fechas.forEach(fecha => {

                    const formattedDate =
                        new Date(fecha).toLocaleDateString("es-ES");

                    bookingDatesList.innerHTML += `
                    <div class="booking-modal-item">

                        <span class="booking-modal-item__date">
                            ${formattedDate}
                        </span>

                        <a
                            href="/prestacoche/actions/delete-booking-date.php?matricula=${matricula}&fecha=${fecha}"
                            class="booking-modal-item__delete">

                            ✕
                        </a>

                    </div>
                `;
                });

                bookingModal.classList.add("modal--active");
            });
        });

    closeBookingModal.addEventListener("click", () => {
        bookingModal.classList.remove("modal--active");
    });

    document.querySelector("#bookingModal .modal__overlay")
        .addEventListener("click", () => {
            bookingModal.classList.remove("modal--active");
        });

})