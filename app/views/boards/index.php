<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tableros</title>
</head>
<body>
    <h1>Mis Tableros</h1>
    <a href="/boards/create" class="btn btn-primary">Crear Nuevo Tablero</a>
    <ul>
        <?php foreach ($boards as $board): ?>
            <li>
                <strong><?php echo htmlspecialchars($board['title']); ?></strong>
                (<?php echo $board['is_public'] ? 'Público' : 'Privado'; ?>)
                <a href="/boards/edit/<?php echo $board['id']; ?>">Editar</a>
                <a href="/boards/delete/<?php echo $board['id']; ?>" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="/dashboard">Regresar al Panel</a>
</body>
</html>
