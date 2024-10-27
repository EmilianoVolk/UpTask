(function(){
    /* =======SHOW TASKS======= */
    getTasks();
    let tasks = [];
    let filtered = [];

    //Search Filters
    const filters = document.querySelectorAll('#filters input[type="radio"]');
    filters.forEach(filter=>{
        filter.addEventListener('input', filterTask)
    })

    function filterTask(e){
        const filter = e.target.value;

        if(filter !== ''){
            filtered = tasks.filter(task => task.state === filter);

        } else{
            filtered = [];
        }

        showTasks();
    }


    async function getTasks() {
        try {
            const id = getProject();
            const url = `http://localhost:3000/api/tasks?id=${id}`;

            const answer = await fetch(url);
            const result = await answer.json();

            tasks = result.tasks

            showTasks();
        } catch (error) {
            console.log(error)
        }
    }

    function showTasks() {

        cleanTasks();
        activeFilter();

        totalPending();
        totalCompleted();
        
        const tasksArray = filtered.length ? filtered : tasks;
        const tasksList = document.querySelector('#tasks-list');

        if (tasksArray.length == 0) {
            const li = document.createElement('LI');
            li.textContent = 'There are not Tasks to Show';
            li.classList.add('no-tasks');

            tasksList.appendChild(li);
            return
        }

        const states = {
            0: 'Pending',
            1: 'Completed'
        }

        tasksArray.forEach(task => {
            const li = document.createElement('LI');
            li.dataset.taskId = task.id;
            li.classList.add('task');

            const taskName = document.createElement('P');
            taskName.textContent = task.name;
            taskName.ondblclick = function(){
                showForm(true, {...task});
            }

            const optionsDiv = document.createElement('DIV');
            optionsDiv.classList.add('options');

            //buttons
            const btnStateTask = document.createElement('BUTTON');
            btnStateTask.classList.add('task-state');
            btnStateTask.textContent = states[task.state];
            btnStateTask.classList.add(`${states[task.state].toLowerCase()}`);
            btnStateTask.dataset.taskState = task.state;
            btnStateTask.ondblclick = function() {
                changeStateTask({...task});
            }

            const btnDeleteTask = document.createElement('BUTTON');
            btnDeleteTask.classList.add('delete-task');
            btnDeleteTask.textContent = 'Delete';
            btnDeleteTask.dataset.idTask = task.id;
            btnDeleteTask.ondblclick = function () {
                confirmDeleteTask({ ...task });                
            }

            optionsDiv.appendChild(btnStateTask);
            optionsDiv.appendChild(btnDeleteTask);

            li.appendChild(taskName);
            li.appendChild(optionsDiv);

            tasksList.appendChild(li)
        });
    }

    function totalPending(){
        const totalPending = tasks.filter(task => task.state === '0');
        const pendingRadio = document.querySelector('#pending')

        if (totalPending.length === 0) {
            pendingRadio.disabled = true;
        } else{
            pendingRadio.disabled = false;

        }
    }

    function totalCompleted(){
        const totalCompleted = tasks.filter(task => task.state === '1');
        const completedRadio = document.querySelector('#completed')

        if (totalCompleted.length === 0) {
            completedRadio.disabled = true;
        } else{
            completedRadio.disabled = false;

        }
    }

    function cleanTasks() {
        const tasksList = document.querySelector('.tasks-list');

        while (tasksList.firstChild) {
            tasksList.firstChild.remove();
        }
    }

    /* =======ADD TASKS / FORM======= */
    const newTaskBtn = document.querySelector('#add-task');
    newTaskBtn.addEventListener('click', ()=>{
        showForm();
    });


    function showForm(edit = false, task = null) {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        document.body.classList.add('no-overflow');

        modal.innerHTML = `
            <form class="formulario new-task">
                <legend>${edit === true ? 'Edit Task' : 'Add a new Task'}</legend>

                <div class="campo campo-modal">
                    <label>Task</label>
                    <input
                        type="text"
                        name="task"
                        placeholder="${task !== null ? 'Edit the task' : 'Add Task to the current Project'}"
                        id="task"
                        value="${task !== null ? task.name : ''}"
                    >
                </div>
                <div class="options">
                    <input 
                        type="submit" 
                        class="submit-new-task" 
                        value="${task !== null ? 'Update Task' : 'Add new Task'}"
                    >
                    <button type="button" class="close-modal">Cancel</button>
                </div> 
        `;

        setTimeout(()=>{
            const form = document.querySelector('.formulario');
            form.classList.add('animate');
        }, 0)

        modal.addEventListener('click', (e)=>{
            e.preventDefault();

            if (e.target.classList.contains('close-modal') || (e.target.classList.contains('modal'))) {
                const form = document.querySelector('.formulario');
                form.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                    document.body.classList.remove('no-overflow')
                }, 500);
            } 

            if (e.target.classList.contains('submit-new-task')){
                const taskValue = document.querySelector('#task').value.trim();

                if (taskValue === '') {
                    const reference = document.querySelector('.formulario legend');
                    campo = document.querySelector('#task')
                    showAlert('error', 'Add a name for the Task', reference, campo);
                    reference.nextElementSibling
                } else{
                    if (edit) {
                        task.name = taskValue;
                        updateTask(task)
                    } else{
                        addTask(taskValue)
                    }
                }
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
    }

    async function addTask(task){
    
        //Build petition
        const data = new FormData();
        data.append('name', task);
        data.append('projectId', getProject());

        try{
            const url = 'http://localhost:3000/api/task';
            const answer = await fetch(url, {
                method: 'POST',
                body: data
            });
          
            const result = await answer.json();
            
            showAlert(result.tipo, result.mensaje, document.querySelector('.formulario legend'));

            if(result.tipo == 'exito'){
                closeModal();

                const taskObj = {
                    id: String(result.id),
                    name: task,
                    state: '0',
                    projectId: result.projectId
                }

                tasks = [...tasks, taskObj];
                showTasks();

            }
        } catch(error){
            console.log(error)
        }
    }

    //Update
    async function updateTask(task){
        const {id, name, projectId, state} = task;

        const data = new FormData();
        data.append('id', id);
        data.append('name', name);
        data.append('projectId', getProject());
        data.append('state', state);

        try {
            const url = `http://localhost:3000/api/update`;

            const answer = await fetch(url, {
                method: 'POST',
                body: data
            })

            const result = await answer.json();
            console.log(result)

            ////
            showAlert(result.answer.tipo, result.answer.mensaje, document.querySelector('.formulario legend'));



            if (result.answer.tipo == 'exito') {

                closeModal();

                tasks = tasks.map(memoryTask =>{
                    if (memoryTask.id === id) {
                        memoryTask.state = state;
                        memoryTask.name = name;
                    }
                    return memoryTask
                })

                showTasks();
            }
        } 
        catch (error) 
        {
            console.log(error)
        }
    }

    /* =======BUTTONS FUNCTIONALITY======= */
    //Change the state of the taks
    function changeStateTask(task){
        task.state == '0' ? task.state = '1' : task.state = '0';

        updateStateTask(task);
    }

    async function updateStateTask(task){
        const {id, name, state} = task;
        const projectId = getProject();

        const data = new FormData();
        data.append('id', id);
        data.append('name', name);
        data.append('state', state);
        data.append('projectId', projectId);

        try {
            const url = `http://localhost:3000/api/update`;
            const answer = await fetch(url, {
                method: 'POST',
                body: data
            })

            const result = await answer.json();
            if (result.answer.tipo === 'exito') {
                tasks = tasks.map(memoryTask =>{
                    if (memoryTask.id == id) {
                        memoryTask.state = state;
                    }
                    return memoryTask;
                })
                
                showTasks();
            }
        } 
        catch (error) 
        {
            console.log(error)
        }
    }

    //Delete tasks
    function confirmDeleteTask(task){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire({
                //     title: "Deleted!",
                //     text: "Your file has been deleted.",
                //     icon: "success"
                // });

                deleteTask(task);
            }
        });
    }

    async function deleteTask(task){
        const { id, name } = task;
        task.projectId = getProject();


        const data = new FormData();
        data.append('id', id);
        data.append('name', name);
        data.append('projectId', task.projectId);

        try {
            const url = `http://localhost:3000/api/delete`;
            const answer = await fetch(url, {
                method: 'POST',
                body: data
            })

            const result = await answer.json();

            if (result.result) {
                Swal.fire('Removed', result.result.mensaje, 'success')
                
                tasks = tasks.filter(memoryTask => 
                    memoryTask.id !== id
                )
                showTasks();
            } 
        }
        catch (error) {
            console.log(error)
        }
    }


    /* =======EXTRA FUNCTIONS======= */

    function getProject(){
        const projectParams = new URLSearchParams(window.location.search)
        const project = Object.fromEntries(projectParams.entries())
        return project.id;
    }

    function showAlert(type, message, reference, campo = null, setTimeoutC = false) {
        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia) alertaPrevia.remove();

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', type);
        alerta.textContent = message;

        reference.parentElement.insertBefore(alerta, reference.nextElementSibling);

        if (campo != null) {
            campo.addEventListener('input', (e) => {
                const alertaActiva = document.querySelector('.alerta');
                if (e.target.value !== '' && alertaActiva) {
                    alertaActiva.remove();  
                }
            });
        }

        if (setTimeoutC === true) {
            setTimeout(() => {
                alerta.remove();
            }, 3000);
        }
    }

    function closeModal(){
        const form = document.querySelector('form');
        const modal = document.querySelector('.modal');
        const campo = document.querySelector('.campo-modal');

        campo.remove();

        setTimeout(() => {
            form.classList.add('cerrar');
        }, 750);

        setTimeout(() => {
            modal.remove();
            document.body.classList.remove('no-overflow')
        }, 1000);
    }

    function activeFilter() {
        const activeFilter = document.querySelector('input[name="filter"]:checked').value;

        if (activeFilter) {
            filtered = tasks.filter(tarea => tarea.state === activeFilter);

            if (filtered.length == 0) {
                radiobtn = document.querySelector('#all');
                radiobtn.checked = true;
            }
        }
    }
})();