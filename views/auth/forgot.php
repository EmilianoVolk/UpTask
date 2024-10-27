<div class="contenedor forgot">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Create your Account in UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <?php if ($mostrar){ ?>

        <form action="/forgot" class="formulario" method="post">
            <div class="campo">
                <label for="email">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Your Email"
                    value="">
            </div>

            <input type="submit" value="Send Instructions" class="boton">
        </form>
        <?php }?>


        <div class="acciones">
            <a href="/">You already have an account? login</a>
            <a href="/forgot">You don't have an account? Get one</a>
        </div>
    </div>
</div>