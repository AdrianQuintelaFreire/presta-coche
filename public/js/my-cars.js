document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // MODAL ELIMINAR
    // =========================

    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const modalMatricula = document.getElementById('modalMatricula');

    const deleteButtons = document.querySelectorAll('.open-delete-modal');

    if (deleteModal) {

        deleteButtons.forEach(button => {

            button.addEventListener('click', () => {

                const matricula = button.dataset.matricula;

                modalMatricula.textContent = matricula;

                confirmDelete.href =
                    `/prestacoche/actions/delete-vehicle.php?matricula=${encodeURIComponent(matricula)}`;

                deleteModal.classList.add('modal--active');

            });

        });

        cancelDelete.addEventListener('click', () => {

            deleteModal.classList.remove('modal--active');

        });

        deleteModal.addEventListener('click', (e) => {

            if (e.target.classList.contains('modal__overlay')) {

                deleteModal.classList.remove('modal--active');

            }

        });

    }

    // =========================
    // MODAL EDITAR
    // =========================

    const editModal = document.getElementById('editModal');

    const editButtons = document.querySelectorAll('.open-edit-modal');

    const cancelEdit = document.getElementById('cancelEdit');

    const editMatricula = document.getElementById('editMatricula');

    const editPrecioDia = document.getElementById('editPrecioDia');

    const editPrecioKm = document.getElementById('editPrecioKm');

    const editModalMatricula = document.getElementById('editModalMatricula');

    if (editModal) {

        editButtons.forEach(button => {

            button.addEventListener('click', () => {

                const matricula = button.dataset.matricula;

                editMatricula.value = matricula;

                editPrecioDia.value = button.dataset.precioDia;

                editPrecioKm.value = button.dataset.precioKm;

                editModalMatricula.textContent = matricula;

                editModal.classList.add('modal--active');

            });

        });

        cancelEdit.addEventListener('click', () => {

            editModal.classList.remove('modal--active');

        });

        editModal.addEventListener('click', (e) => {

            if (e.target.classList.contains('modal__overlay')) {

                editModal.classList.remove('modal--active');

            }

        });

    }

    // =========================
    // MODAL DISPONIBILIDAD
    // =========================

    const availabilityModal =
        document.getElementById("availabilityModal");

    const openAvailabilityButtons =
        document.querySelectorAll(".open-availability-modal");

    const cancelAvailability =
        document.getElementById("cancelAvailability");

    const availabilityMatricula =
        document.getElementById("availabilityMatricula");

    const availabilityInputMatricula =
        document.getElementById("availabilityInputMatricula");

    if (availabilityModal) {

        openAvailabilityButtons.forEach(button => {

            button.addEventListener("click", () => {

                console.log("CLICK DISPONIBILIDAD");

                const matricula = button.dataset.matricula;

                availabilityMatricula.textContent = matricula;

                availabilityInputMatricula.value = matricula;

                availabilityModal.classList.add("modal--active");

            });

        });

        cancelAvailability.addEventListener("click", () => {

            availabilityModal.classList.remove("modal--active");

        });

        availabilityModal.addEventListener("click", (e) => {

            if (e.target.classList.contains("modal__overlay")) {

                availabilityModal.classList.remove("modal--active");

            }

        });

        let availabilityPicker = null;

        openAvailabilityButtons.forEach(button => {

            button.addEventListener("click", () => {

                const matricula = button.dataset.matricula;

                const fechas = JSON.parse(button.dataset.fechas || "[]");

                availabilityMatricula.textContent = matricula;

                availabilityInputMatricula.value = matricula;

                availabilityModal.classList.add("modal--active");

                // Destruir calendario anterior
                if (availabilityPicker) {
                    availabilityPicker.destroy();
                }

                // Crear nuevo calendario
                availabilityPicker = flatpickr("#availabilityCalendar", {

                    mode: "multiple",

                    minDate: "today",

                    dateFormat: "Y-m-d",

                    locale: "es",

                    defaultDate: fechas

                });

            });

        });

    }

});