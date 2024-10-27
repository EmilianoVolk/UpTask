<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>


    <form class="formulario" method="post" action="/profile">
        <div class="campo">
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                value="<?php echo $user->name ?>"
                name="name"
                placeholder="Your name">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                value="<?php echo $user->email ?>"
                name="email"
                placeholder="Your email">
        </div>

        <input type="submit" value="Update Profile">
    </form>
    
    <a href="/change-password" class="link">Do you want to Change your Password?</a>

</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>