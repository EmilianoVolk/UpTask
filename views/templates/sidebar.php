<aside class="sidebar">

    <div class="container-sidebar">
        <h2>UpTask</h2>

        <div class="close-menu">
            <img src="build/img/cerrar.svg" alt="close image" id="close-menu">
        </div>
    </div>

    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Projects') ? 'activo' : '' ?>" href="/dashboard">Projects</a>
        <a class="<?php echo ($titulo === 'Create Project') ? 'activo' : '' ?>" href="/create-project">Create Project</a>
        <a class="<?php echo ($titulo === 'Profile') ? 'activo' : '' ?>" href="/profile">Profile</a>
    </nav>
</aside>