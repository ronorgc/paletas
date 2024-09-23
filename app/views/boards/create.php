<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tablero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }
        footer {
            margin-top: 20px;
            padding: 10px 0;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
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
            <h1>Crear Nuevo Tablero</h1>
            <form action="/paleta/public/boards/create" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">


                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_public" class="form-check-input" id="is_public">
                    <label class="form-check-label" for="is_public">¿Es público?</label>
                </div>
                <div class="btn-group" role="group" aria-label="Botones de acción">
                    <button type="submit" class="btn btn-success">Crear Tablero</button>
                    <a href="/paleta/public/dashboard" class="btn btn-secondary">Regresar al Panel</a>
                </div>
            </form>
        </div>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Tu Aplicación. Todos los derechos reservados.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
