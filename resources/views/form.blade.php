<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Formulario</title>
</head>
<body>
<div class="container mt-5">
        <h1 class="text-center">Creación de productos</h1>
        <form action="{{ route('form.submit') }}" method="POST" class="mt-4">
            @csrf

            <div class="form-group">
                <label for="campo1">Nombre</label>
                <input type="text" class="form-control" id="campo1" name="campo1" required>
            </div>

            <div class="form-group">
                <label for="campo2">Referencia</label>
                <input type="text" class="form-control" id="campo2" name="campo2" required>
            </div>

            <div class="form-group">
                <label for="campo3">Descripción</label>
                <input type="text" class="form-control" id="campo3" name="campo3" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
