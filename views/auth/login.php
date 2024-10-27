<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Login</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>


        <form action="/" class="formulario" method="post">
            <div class="campo">
                <label for="email">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Your Email"
                    value="<?php echo $user->email ?>"    
                >
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Your Password">
            </div>
            <input type="submit" class="boton" value="Login">
        </form>

        <div class="acciones">
            <a href="/create">You don't have an account? Get one</a>
            <a href="/forgot">Did you forget your password?</a>
        </div>
    </div>
</div>