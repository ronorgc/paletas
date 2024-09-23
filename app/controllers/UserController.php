<?php
class UserController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Verificar si el usuario o correo ya existen
            $query = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo "Nombre de usuario o correo electrónico ya existe";
                return;
            }

            // Insertar el nuevo usuario en la base de datos
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);

            if ($stmt->execute()) {
                header('Location: /paleta/public/login');
                exit();
            } else {
                echo "Error al registrar usuario.";
            }
        } else {
            require '../app/views/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];

            // Buscar usuario por nombre de usuario
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Guardar el usuario en la sesión
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirigir al dashboard
                header('Location: /paleta/public/dashboard');
                exit();
            } else {
                echo "Credenciales incorrectas.";
            }
        } else {
            require '../app/views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /paleta/public/login');
        exit();
    }
}
