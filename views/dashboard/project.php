<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <div class="container-new-task">
        <button
            type="button"
            class="add-task"
            id="add-task">&#43; Add Task</button>
    </div>

    <div id="filters" class="filters">
        <div class="filters-inputs">
            <h2>Filters: </h2>
            <div class="campo">
                <label for="all">All</label>
                <input 
                    type="radio"
                    id="all"
                    name="filter"
                    value=""
                    checked    
                >
            </div>
            <div class="campo">
                <label for="completed">Completed</label>
                <input 
                    type="radio"
                    id="completed"
                    name="filter"
                    value="1"
                >
            </div>
            <div class="campo">
                <label for="pending">Pending</label>
                <input 
                    type="radio"
                    id="pending"
                    name="filter"
                    value="0"
                >
            </div>
        </div>
    </div>

    <ul id="tasks-list" class="tasks-list">

    </ul>
</div>


<?php include_once __DIR__ . '/footer-dashboard.php' ?>

<?php
$script = '
    <script src="build/js/task.js"></script>
    <script src="build/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

';
?>
