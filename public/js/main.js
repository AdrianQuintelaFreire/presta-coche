document.addEventListener('DOMContentLoaded', () => {

    const accountButton = document.getElementById("accountButton");
    const accountDropdown = document.getElementById("accountDropdown");

    if(accountButton) {

        accountButton.addEventListener("click", function (e) {

            e.stopPropagation();

            accountDropdown.classList.toggle("active");

        });

        window.addEventListener("click", function (e) {

            if (
                !accountDropdown.contains(e.target) &&
                !accountButton.contains(e.target)
            ) {

                accountDropdown.classList.remove("active");

            }

        });

    }
const accountButtonMobile = document.getElementById("accountButtonMobile");
    const accountDropdownMobile = document.getElementById("accountDropdownMobile");

    if(accountButtonMobile) {

        accountButtonMobile.addEventListener("click", function (e) {

            e.stopPropagation();

            accountDropdownMobile.classList.toggle("active");

        });

        window.addEventListener("click", function (e) {

            if (
                !accountDropdownMobile.contains(e.target) &&
                !accountButtonMobile.contains(e.target)
            ) {

                accountDropdownMobile.classList.remove("active");

            }

        });

    }



});