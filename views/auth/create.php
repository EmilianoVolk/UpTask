<div class="contenedor create">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Create your Account in UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>


        <form action="/create" class="formulario" method="post">
            <div class="campo">
                <label for="name">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Your Name"
                    value="<?php echo $user->name ?>">
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Your Email"
                    value="<?php echo $auth->email ?>">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Your Password">
            </div>
            <div class="campo">
                <label for="password2">Repeat Password</label>
                <input
                    type="password"
                    name="password2"
                    id="password2"
                    placeholder="Repeat you Password">
            </div>
            <input type="submit" class="boton" value="Login">
        </form>

        <div class="acciones">
            <a href="/">You already have an account? login</a>
            <a href="/forgot">Did you forget your password?</a>
        </div>
    </div>
</div>