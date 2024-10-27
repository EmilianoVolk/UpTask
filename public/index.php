<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TaskController;
$router = new Router();

/*LOGIN CONTROLLER*/
//Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Create Account
$router->get('/create', [LoginController::class, 'create']);
$router->post('/create', [LoginController::class, 'create']);

//Forgot my Password Form
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);

//New Password
$router->get('/restore', [LoginController::class, 'restore']);
$router->post('/restore', [LoginController::class, 'restore']);

//Account Confirmation
$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm', [LoginController::class, 'confirm']);

/*DASHBOARD CONTROLLER*/
//Projects zone
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/create-project', [DashboardController::class, 'create_project']);
$router->post('/create-project', [DashboardController::class, 'create_project']);
$router->get('/project', [DashboardController::class, 'project']);
$router->post('/project', [DashboardController::class, 'project']);
$router->get('/profile', [DashboardController::class, 'profile']);
$router->post('/profile', [DashboardController::class, 'profile']);
$router->get('/change-password', [DashboardController::class, 'changePassword']);
$router->post('/change-password', [DashboardController::class, 'changePassword']);

/* */
//Tasks API's
$router->get('/api/tasks', [TaskController::class, 'index']);
$router->post('/api/task', [TaskController::class, 'create']);
$router->post('/api/update', [TaskController::class, 'update']);
$router->post('/api/delete', [TaskController::class, 'delete']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();