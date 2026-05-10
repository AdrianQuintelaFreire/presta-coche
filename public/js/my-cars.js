const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const modalMatricula = document.getElementById('modalMatricula');

    const deleteButtons = document.querySelectorAll('.open-delete-modal');

    deleteButtons.forEach(button => {

        button.addEventListener('click', () => {

            const matricula = button.dataset.matricula;

            // Mostrar matrícula en el modal
            modalMatricula.textContent = matricula;

            // URL eliminación
            confirmDelete.href = `../public/delete-vehicle.php?matricula=${encodeURIComponent(matricula)}`;

            // Abrir modal
            deleteModal.classList.add('modal--active');
        });

    });

    // Cancelar
    cancelDelete.addEventListener('click', () => {
        deleteModal.classList.remove('modal--active');
    });

    // Cerrar al pulsar overlay
    deleteModal.addEventListener('click', (e) => {

        if (e.target.classList.contains('modal__overlay')) {
            deleteModal.classList.remove('modal--active');
        }

    });
    const editModal = document.getElementById('editModal');

const editButtons = document.querySelectorAll('.open-edit-modal');

const cancelEdit = document.getElementById('cancelEdit');

const editMatricula = document.getElementById('editMatricula');

const editPrecioDia = document.getElementById('editPrecioDia');

const editPrecioKm = document.getElementById('editPrecioKm');

const editModalMatricula = document.getElementById('editModalMatricula');

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