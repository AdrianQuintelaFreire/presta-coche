document.addEventListener('DOMContentLoaded', () => {

    // ---------------------------
    // POPUP VALIDACIÓN
    // ---------------------------
    const pendingButton = document.getElementById("pendingValidationButton");
    const popup = document.getElementById("validationPopup");
    const closePopup = document.getElementById("closeValidationPopup");

    if (pendingButton && popup) {
        pendingButton.addEventListener("click", () => {
            popup.classList.add("validation-popup--active");
        });
    }

    if (closePopup && popup) {
        closePopup.addEventListener("click", () => {
            popup.classList.remove("validation-popup--active");
        });
    }

    popup?.addEventListener("click", (e) => {
        if (e.target.classList.contains("validation-popup__overlay")) {
            popup.classList.remove("validation-popup--active");
        }
    });

    // ---------------------------
    // RESERVA AJAX
    // ---------------------------
    const form = document.getElementById("reserveForm");

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const res = await fetch("./reserve.php", {
                    method: "POST",
                    body: formData
                });

                const data = await res.json();

                showPopup(data.ok
                    ? "Reserva realizada correctamente ✔️"
                    : (data.message || "Error en la reserva")
                );

            } catch (err) {
                showPopup("Error de conexión con el servidor");
            }
        });
    }

    // ---------------------------
    // POPUP DINÁMICO
    // ---------------------------
    function showPopup(message) {
        const popup = document.createElement("div");
        popup.className = "reservation-popup";

        popup.innerHTML = `
        <div class="reservation-popup__box">
            <p>${message}</p>

            <div class="reservation-popup__actions">
                <button type="button" class="btn-ok">Aceptar</button>
                <a href="./reserves.php" class="btn-go">Ir a reservas</a>
            </div>
        </div>
    `;

        popup.querySelector(".btn-ok").addEventListener("click", () => {
            popup.remove();
        });

        document.body.appendChild(popup);
    }

});