<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <form class="formulario" method="post" action="/change-password">
        <div class="campo">
            <label for="current_password">Current Password</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                placeholder="Your Current Password">
        </div>
        <div class="campo">
            <label for="new_password">New Password</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                placeholder="Your New Password">
        </div>

        <input type="submit" value="Change Password">
    </form>

    <a href="/change-password" class="link">Go Back to Profile</a>

</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>