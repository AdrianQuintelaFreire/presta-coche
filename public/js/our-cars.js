document.addEventListener('DOMContentLoaded', () => {

    // Pequeña validación para las fechas
    document.getElementById('date-start').addEventListener('change', function () {
        document.getElementById('date-end').min = this.value;
    });

})