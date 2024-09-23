<?php
class BoardController {
    private $db;

    public function __construct() {
        // Iniciar la sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Inicializar la conexión a la base de datos
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Generar un token CSRF
    private function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Verificar el token CSRF
    private function verifyCsrfToken($token) {
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    // Mostrar todos los tableros del usuario
    public function index() {
        // Redirigir si el usuario no está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /paleta/public/login');
            exit;
        }

        // Consultar los tableros del usuario
        $query = "SELECT * FROM boards WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $boards = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Comprobar si se encontraron tableros
        if (!$boards) {
            $boards = [];  // Inicializar como un array vacío si no hay tableros
        }

        // Incluir la vista del dashboard y pasar los tableros
        require __DIR__ . '/../views/dashboard.php';
    }

    // Crear un tablero
    public function create() {
        // Redirigir si el usuario no está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /paleta/public/login');
            exit;
        }

        // Generar un token CSRF para el formulario
        $csrf_token = $this->generateCsrfToken();

        // Procesar el formulario de creación
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar el token CSRF
            if (!$this->verifyCsrfToken($_POST['csrf_token'])) {
                die("Error de seguridad. Token CSRF no válido.");
            }

            // Validar datos del formulario
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $is_public = isset($_POST['is_public']) ? 1 : 0;

            if (empty($title)) {
                $message = "El título es obligatorio.";
            } else {
                // Insertar el nuevo tablero en la base de datos
                $query = "INSERT INTO boards (user_id, title, description, is_public) VALUES (:user_id, :title, :description, :is_public)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':is_public', $is_public);

                if ($stmt->execute()) {
                    header('Location: /paleta/public/dashboard');
                    exit;
                } else {
                    $message = "Error al crear el tablero. Inténtalo de nuevo.";
                }
            }
        }

        // Incluir la vista para crear un nuevo tablero
        require __DIR__ . '/../views/boards/create.php';
    }

    // Editar un tablero
    public function edit($id) {
        // Redirigir si el usuario no está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /paleta/public/login');
            exit;
        }

        // Consultar el tablero a editar
        $query = "SELECT * FROM boards WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $board = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el tablero existe
        if (!$board) {
            echo "Tablero no encontrado o no tienes permiso para editarlo.";
            exit;
        }

        // Generar un token CSRF para el formulario
        $csrf_token = $this->generateCsrfToken();

        // Procesar el formulario de edición
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar el token CSRF
            if (!$this->verifyCsrfToken($_POST['csrf_token'])) {
                die("Error de seguridad. Token CSRF no válido.");
            }

            // Validar datos del formulario
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $is_public = isset($_POST['is_public']) ? 1 : 0;

            if (empty($title)) {
                $message = "El título es obligatorio.";
            } else {
                // Actualizar el tablero en la base de datos
                $query = "UPDATE boards SET title = :title, description = :description, is_public = :is_public WHERE id = :id AND user_id = :user_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':is_public', $is_public);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);

                if ($stmt->execute()) {
                    header('Location: /paleta/public/dashboard');
                    exit;
                } else {
                    $message = "Error al actualizar el tablero. Inténtalo de nuevo.";
                }
            }
        }

        // Incluir la vista para editar el tablero
        require __DIR__ . '/../views/boards/edit.php';
    }

    // Eliminar un tablero
    public function delete($id) {
        // Redirigir si el usuario no está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /paleta/public/login');
            exit;
        }

        // Eliminar el tablero de la base de datos
        $query = "DELETE FROM boards WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        header('Location: /paleta/public/dashboard');
        exit;
    }
}
