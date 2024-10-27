<?php include_once __DIR__ . '/header-dashboard.php' ?>

    <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form action="/create-project" class="formulario" method="post">

            <?php include_once __DIR__ . '/form-project.php' ?>

            <input type="submit" value="Create Project">
        </form>
    </div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>