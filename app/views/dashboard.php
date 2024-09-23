
<?php
// Al inicio de dashboard.php, asegúrate de que la variable $boards está definida
$boards = $boards ?? [];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            padding: 20px;
            flex-grow: 1;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        footer {
            margin-top: 20px;
            padding: 10px 0;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
        .welcome-message {
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .action-buttons a {
            margin-right: 10px;
        }
        .btn-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="content">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Tu Aplicación</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/paleta/public/logout">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-4">
                <div class="welcome-message">
                    <h1 class="mb-4 text-center">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                    <p class="text-center">Este es tu panel administrativo. Aquí puedes gestionar tus tableros y usuarios.</p>
                </div>

                <div class="mt-4 text-center">
                    <h3>Mis Tableros</h3>
                    <div class="btn-group">
                        <a href="/paleta/public/boards/create" class="btn btn-success">Crear Nuevo Tablero</a>
                        <a href="/paleta/public/boards/manage" class="btn btn-info">Gestionar Tableros</a>
                        <a href="/paleta/public/users/manage" class="btn btn-warning">Gestionar Usuarios</a>
                        <a href="/paleta/public/settings" class="btn btn-secondary">Configuraciones</a>
                    </div>

                    <?php if (isset($message)): ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

            <div class="mt-4">
         
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Suponiendo que $boards contiene todos los tableros del usuario
                    if (isset($boards) && !empty($boards)) {
                        foreach ($boards as $board): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($board['title']); ?></td>
                                <td><?php echo htmlspecialchars($board['description']); ?></td>
                                <td><?php echo $board['is_public'] ? 'Público' : 'Privado'; ?></td>
                                <td>
                                    <a href="/paleta/public/boards/edit/<?php echo $board['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="/paleta/public/boards/delete/<?php echo $board['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este tablero?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">No tienes tableros creados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <footer>
                <p>&copy; <?php echo date("Y"); ?> Tu Aplicación. Todos los derechos reservados.</p>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
