<?php 

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

#[\AllowDynamicProperties]  


class LoginController{
    public static function login(Router $router){

        $user = new User;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);

            $alertas = $user->validateLogin();

            if (empty($alertas)) {
                $user = User::where('email', $user->email);

                if (!$user || !$user->confirm) {
                    $alertas = User::setAlerta('error', 'User not found or not confirmed');
                } else{
                    if (password_verify($_POST['password'], $user->password)) {
                        //Login
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        header('Location: /dashboard');
                    } else{
                        $alertas = User::setAlerta('error', 'Incorrect Password');
                    }
                }
            }
        }

        $alertas = User::getAlertas();

        $router->render('auth/login',[
            'titulo' => 'Login',
            'user' => $user,
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function create(Router $router){
        $user = new User;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);

            
            $alertas = $user->validateNewAccount();
            
            $userExist = User::where('email', $user->email);
            
            if (empty($alertas)) {
                if($userExist){
                    User::setAlerta('error', 'Already Register User');
                    $alertas = User::getAlertas();
                }
                else{
                    
                    $user->hashPassword();
                    
                    //Eliminate Password 2
                    
                    
                    //Token
                    $user->createToken();
                    
                    
                    //Create User
                    $user->guardar();
                    
                    header('Location: /message');
                    
                    //Send Email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();
                }
            }
        }

        $router->render('auth/create', [
            'titulo' => 'Create',
            'user' => $user,
            'alertas' => $alertas
        ]);
    }

    public static function forgot(Router $router){

        $user = new User;
        $alertas = [];
        $mostrar = true;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);
            $alertas = $user->validateEmail();

            if (empty($alertas)) {
                $user = User::where('email', $user->email);
                
                if ($user && $user->confirm == '1') {
                    
                    
                    //Generate new token
                    $user->createToken();
                    
                    //Upload user
                    $user->guardar();

                    //Send Email

                    $email = new Email($user->email, $user->name, $user->token );
                    $email->sendNewPass();
                    
                    //Print alert
                    User::setAlerta('exito', 'We send you the instructions to recover your account');
                    $mostrar = false;
                } else{
                    User::setAlerta('error', 'User not found or not confirmed');
                }
            }
        }
        $alertas = User::getAlertas();

        $router->render('auth/forgot',[
            'titulo' => 'Forgot',
            'user' => $user,
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);

    }

    public static function restore(Router $router){
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        $user = User::where('token', $token);
        $mostrar = true;


        if (empty($user)) {
            User::setAlerta('error', 'Token no Valido');
            $mostrar = false;
        } else{
            $user->token = null;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //New Password
            $user->sincronizar($_POST);

            //Validate passwords
            $alertas = $user->validatePasswords();
            
            if (empty($alertas)) {
                
                
                //Hash
                $user->hashPassword();
    
                //Null Token 
                $user->token = null;

                //Save
                $resultado = $user->guardar();
                
                if($resultado) header('Location: /'); 
            }

        }
         
        $alertas = User::getAlertas();
        $router->render('auth/restore',[
            'titulo' => 'Restore Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function message(Router $router){
        $router->render('auth/message', [
            'titulo' => 'Restore Password'
        ]);
    }

    public static function confirm(Router $router){
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        $user = User::where('token', $token);

        if (empty($user)) {
            User::setAlerta('error', 'Token no Valido');
        } else{
            $user->confirm = 1;
            $user->token = null;
            
            
            $user->guardar();
            User::setAlerta('exito', 'Account Confirmed Correctly');
        }

        $alertas = User::getAlertas();

        $router->render('auth/confirm', [
            'titulo' => 'Confirm Account',
            'alertas' => $alertas
        ]);
    }
}