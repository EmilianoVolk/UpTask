<?php



namespace Controllers;


use Model\Project;
use Model\User;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $projects = Project::belongsTo('ownerId', $id);
        $router->render('dashboard/index', [
            'titulo' => 'Projects',
            'projects' => $projects
        ]);
    }

    public static function create_project(Router $router){
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project($_POST);

            $alertas = $project->validateNameProject();

            if (empty($alertas)) {
                //URL
                $project->url = md5(uniqid());

                //User Id
                $project->ownerId = $_SESSION['id'];

                //Save Project
                $project->guardar();

                header('Location: /project?id=' . $project->url);
            }

        }

        $router->render('dashboard/create-project', [
            'titulo' => 'Create Project',
            'alertas' => $alertas

        ]);
    }

    public static function profile(Router $router){
        session_start();
        isAuth();

        $user = User::find($_SESSION['id']);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (($_POST['name']) !== $user->name || ($_POST['email']) !== $user->email) {
                $user->sincronizar($_POST);
                $alertas = $user->validateProfile();

                if (empty($alertas)) {
                    $userExist = User::where('email', $user->email);
                    if ($userExist && $userExist->id !== $user->id) {
                        User::setAlerta('error', 'Email is already in use');
                    } else{
                        $user->guardar();
                        
                        User::setAlerta('exito', 'Saved Succesfully');
                        
                        $_SESSION['name'] = $user->name;
                    }
                    $alertas = User::getAlertas();
                }
            } 
        }

        $router->render('dashboard/profile', [
            'titulo' => 'Profile',
            'user' => $user,
            'alertas' => $alertas
        ]);
    }

    public static function project(Router $router){
        session_start();
        isAuth();

        $token = s($_GET['id']);

        if(!$token) header('Location: /dashboard');

        $project = Project::where('url', $token);
        // debuguear($project);

        if ($project->ownerId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/project', [
            'titulo' => $project->project,
        ]);
    }

    public static function changePassword(Router $router){
        session_start();
        $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::find($_SESSION['id']);
            $user->sincronizar($_POST);

            $alertas = $user->validateChangePasswords();

            if (empty($alertas)) {
                $result = $user->comprobateNewPassword();
                if ($result) {
                    $user->password = $user->new_password;
                    
                    unset($user->current_password);
                    unset($user->new_password);
                    unset($user->password2);

                    $user->hashPassword();

                    $result = $user->guardar();

                    if ($result) {
                        $alertas = User::setAlerta('exito', 'Password Saved Succesfully');
                    } else{
                        debuguear('asd');
                    }
                    
                } else{
                    $alertas = User::setAlerta('error', 'Incorrect Password');
                }
            }

            $alertas = User::getAlertas();

        }

        $router->render('dashboard/change-password',[
            'titulo' => 'Change Password',
            'alertas' => $alertas
        ]);
    }
}
