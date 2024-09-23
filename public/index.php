<?php
// Cargar controladores y configuraciones
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/BoardController.php'; // Cargar el controlador de tableros
require_once '../app/config/db.php';

// Iniciar sesión
session_start();

// Verificar las rutas desde la URL
if (isset($_GET['url'])) {
    // Limpiar y procesar la URL
    $url = rtrim($_GET['url'], '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    // Crear instancias de los controladores
    $userController = new UserController();
    $boardController = new BoardController(); // Instancia del controlador de tableros

    // Verificar la primera parte de la URL para determinar la acción
    switch ($url[0]) {
        case 'register':
            // Llamar al método de registro
            $userController->register();
            break;
        case 'login':
            // Llamar al método de inicio de sesión
            $userController->login();
            break;
        case 'logout':
            // Llamar al método de cierre de sesión
            $userController->logout();
            break;
        case 'dashboard':
            // Verificar si el usuario está logueado
            if (!isset($_SESSION['user_id'])) {
                // Si no está logueado, redirigir a la página de login
                header('Location: /paleta/public/login');
                exit();
            }
            // Mostrar el dashboard si está logueado
            require '../app/views/dashboard.php';
            break;
        case 'boards':
            // Manejar las rutas relacionadas con los tableros
            if (isset($url[1])) {
                switch ($url[1]) {
                    case 'create':
                        $boardController->create();
                        break;
                    case 'edit':
                        $id = $url[2]; // Asumimos que el ID del tablero es el tercer elemento de la URL
                        $boardController->edit($id);
                        break;
                    case 'delete':
                        $id = $url[2]; // Asumimos que el ID del tablero es el tercer elemento de la URL
                        $boardController->delete($id);
                        break;
                    default:
                        // Si no se encuentra una acción válida para tableros
                        echo "Acción de tablero no encontrada";
                        break;
                }
            } else {
                // Si no se especifica una acción, mostrar todos los tableros del usuario
                $boardController->index();
            }
            break;
        default:
            // Si no encuentra una ruta válida, muestra un mensaje de error
            echo "Página no encontrada";
    }
} else {
    // Si no hay URL especificada, redirigir a la página de login
    header('Location: /paleta/public/login');
    exit();
}
