<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tablero</title>
</head>
<body>
    <h1>Editar Tablero</h1>
    <form action="/boards/edit/<?php echo $board['id']; ?>" method="POST">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <label for="title">Título</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($board['title']); ?>" required>
        <br>
        <label for="description">Descripción</label>
        <textarea name="description"><?php echo htmlspecialchars($board['description']); ?></textarea>
        <br>
        <label for="is_public">¿Es público?</label>
        <input type="checkbox" name="is_public" <?php echo $board['is_public'] ? 'checked' : ''; ?>>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="/dashboard">Regresar al Panel</a>
</body>
</html>
