<?php 

namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController{
    public static function index(){
        session_start();


        $projectId = $_GET['id'];

        if(!$projectId) header('Location: /dashboard');

        $project = Project::where('url', $projectId);

        if (!$project || $project->ownerId !== $_SESSION['id']) header('Location: /404');


        $tasks = Task::belongsTo('projectId', $project->id);

        echo json_encode(['tasks' => $tasks]);

    }
    
    public static function create(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $project = Project::where('url',$_POST['projectId']);

            if (!$project || $project->ownerId !== $_SESSION['id']) {
                $answer = [
                    'tipo' => 'error',
                    'mensaje' => 'There was an error adding the task'
                ];

                echo json_encode($answer);
                return;
            }


            $task = new Task($_POST);
            $task->projectId = $project->id;
            $result = $task->guardar();
            $answer = [
                'tipo' => 'exito',
                'id' => $result['id'],
                'mensaje' => 'Task Created Correctly',
                'projectId' => $project->id
            ];
            echo json_encode($answer);
            


        }
    }

    public static function update(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            
            $project = Project::where('url', $_POST['projectId']);

            if (!$project || $project->ownerId !== $_SESSION['id']) {
                $answer = [
                    'tipo' => 'error',
                    'mensaje' => 'There was an error',
                ];

                echo json_encode($answer);
                return;
            }

            $task = new Task($_POST);
            $task->projectId = $project->id; 

            $result = $task->guardar();

            if ($result) {
                $answer = [
                    'tipo' => 'exito',
                    'id' => $task->id,
                    'projectId' => $project->id,
                    'mensaje' => 'Updated Correctly',
                    'name' => $task->name,
                ];
                echo json_encode(['answer' => $answer]);
            }
            
        }
    }

    public static function delete(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $project = Project::where('url', $_POST['projectId']);

            if (!$project || $project->ownerId !== $_SESSION['id']) {
                $answer = [
                    'tipo' => 'error',
                    'mensaje' => 'There was an error'
                ];

                echo json_encode(['answer' => $answer]);
                return;
            }

            $task = new Task($_POST);
            $task->projectId = $project->id;

            $result = $task->eliminar();

            if($result){
                $result = [
                    'tipo' => 'exito',
                    'id' => $task->id,
                    'projectId' => $project->id,
                    'mensaje' => $_POST['name'] . ' Was Successfully Removed'
                ];
                echo json_encode(['result' => $result]);
            }
        }
    }


}