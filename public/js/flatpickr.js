document.addEventListener('DOMContentLoaded', () => {
    flatpickr("#date-range", {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "es"
    });
})