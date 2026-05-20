document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".register-form__form");

    form.addEventListener("submit", function (e) {

        // =========================
        // INPUTS
        // =========================
        const dni = document.getElementById("dni").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const nacimiento = document.getElementById("data_nacemento").value;
        const caducidad = document.getElementById("fecha_caducidad_dni").value;

        const fileDni = document.getElementById("photo_DNI").files[0];
        const fileLicense = document.getElementById("permiso_conducir").files[0];

        const hoy = new Date();

        // =========================
        // CONFIRMAR CONTRASEÑA
        // =========================
        const password = document.getElementById("contrasinal").value;
        const confirmPassword = document.getElementById("contrasinal_confirm").value;

        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden.");
            e.preventDefault();
            return;
        }

        // =========================
        // DNI VALIDATION
        // =========================
        const dniRegex = /^[0-9]{8}[A-Z]$/;
        if (!dniRegex.test(dni)) {
            alert("DNI inválido. Formato correcto: 12345678X");
            e.preventDefault();
            return;
        }

        // =========================
        // TELÉFONO (España básico)
        // =========================
        const telRegex = /^[0-9]{9}$/;
        if (!telRegex.test(telefono)) {
            alert("Teléfono inválido. Debe tener 9 dígitos.");
            e.preventDefault();
            return;
        }

        // =========================
        // EDAD (mínimo 18 años)
        // =========================
        const fechaNac = new Date(nacimiento);
        let edad = hoy.getFullYear() - fechaNac.getFullYear();
        const m = hoy.getMonth() - fechaNac.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }

        if (edad < 18) {
            alert("Debes ser mayor de 18 años.");
            e.preventDefault();
            return;
        }

        // =========================
        // CADUCIDAD DNI
        // =========================
        const fechaCad = new Date(caducidad);

        if (fechaCad < hoy) {
            alert("El DNI está caducado.");
            e.preventDefault();
            return;
        }

        // =========================
        // ARCHIVOS
        // =========================
        if (!fileDni || !fileLicense) {
            alert("Debes subir todas las imágenes.");
            e.preventDefault();
            return;
        }

        const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

        if (!allowedTypes.includes(fileDni.type)) {
            alert("La foto del DNI debe ser JPG o PNG.");
            e.preventDefault();
            return;
        }

        if (!allowedTypes.includes(fileLicense.type)) {
            alert("La foto del permiso debe ser JPG o PNG.");
            e.preventDefault();
            return;
        }

    });
});