<aside class="admin-sidebar">

    <h2 class="admin-sidebar__title">
        Panel Admin
    </h2>

    <nav class="admin-sidebar__nav">

        <ul class="admin-sidebar__menu">

            <li class="admin-sidebar__item">
                <a href="/prestacoche/public/admin.php"
                    class="admin-sidebar__link <?= $currentPage === 'manual' ? 'admin-sidebar__link--active' : '' ?>">
                    Manual
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="/prestacoche/pages/admin_validate-users.php"
                    class="admin-sidebar__link <?= $currentPage === 'validate-users' ? 'admin-sidebar__link--active' : '' ?>">
                    Validar usuarios
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="/prestacoche/pages/admin_validate-cars.php"
                    class="admin-sidebar__link <?= $currentPage === 'validate-cars' ? 'admin-sidebar__link--active' : '' ?>">
                    Validar vehículos
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="/prestacoche/pages/admin_manage-users.php"
                    class="admin-sidebar__link <?= $currentPage === 'manage-users' ? 'admin-sidebar__link--active' : '' ?>">
                    Gestionar usuarios
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="/prestacoche/pages/admin_manage-cars.php"
                    class="admin-sidebar__link <?= $currentPage === 'manage-cars' ? 'admin-sidebar__link--active' : '' ?>">
                    Gestionar vehículos
                </a>
            </li>

        </ul>

    </nav>

    <div class="admin-sidebar__footer">

        <a href="/prestacoche/actions/logout.php"
            class="admin-sidebar__logout">
            Cerrar sesión
        </a>

    </div>

</aside>