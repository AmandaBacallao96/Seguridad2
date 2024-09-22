<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión / Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">
    <div class="container">
        <h1 class="text-center mb-4">Actividad 2 Seguridad Web</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Formulario de Inicio de Sesión -->
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Iniciar Sesión</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email_login">Correo Electrónico</label>
                                <input type="email" id="email_login" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password_login">Contraseña</label>
                                <input type="password" id="password_login" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>¿No tienes una cuenta? <a href="#registro" data-toggle="collapse">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Registro -->
                <div class="card mt-4 collapse" id="registro">
                    <div class="card-header text-center">
                        <h4>Registro</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" id="apellidos" class="form-control" name="apellidos" value="{{ old('apellidos') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" id="dni" class="form-control" name="dni" value="{{ old('dni') }}" required>
                                <small class="form-text text-muted">
                                    Formato: 8 dígitos seguidos de una letra (EJ: 12345678L)
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="register_email">Correo Electrónico</label>
                                <input type="email" id="register_email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="register_password">Contraseña</label>
                                <input type="password" id="register_password" class="form-control" name="password" required>
                                <small class="form-text text-muted">
                                    La contraseña debe tener al menos 10 caracteres, incluir una letra, un número y un carácter especial (!@#$%^&*).
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                            </div>

                            <!-- Campo Teléfono (Opcional) -->
                            <div class="form-group">
                                <label for="telefono">Teléfono (Opcional)</label>
                                <input type="text" id="telefono" class="form-control" name="telefono" value="{{ old('telefono') }}" placeholder="+34912345678">
                                <small class="form-text text-muted">Formato: Solo números y el símbolo "+" para prefijos.</small>
                            </div>

                            <!-- Campo País (Opcional) -->
                            <div class="form-group">
                                <label for="pais">País (Opcional)</label>
                                <select id="pais" class="form-control" name="pais">
                                    <option value="" selected>Selecciona tu país</option>
                                    <option value="España" {{ old('pais') == 'España' ? 'selected' : '' }}>España</option>
                                    <option value="México" {{ old('pais') == 'México' ? 'selected' : '' }}>México</option>
                                    <option value="Argentina" {{ old('pais') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                    <!-- Agrega más países según lo necesario -->
                                </select>
                            </div>

                            <!-- Campo Sobre Ti (Opcional) -->
                            <div class="form-group">
                                <label for="sobre_ti">Sobre ti (Opcional)</label>
                                <textarea id="sobre_ti" class="form-control" name="sobre_ti" rows="4" placeholder="Escribe algo sobre ti...">{{ old('sobre_ti') }}</textarea>
                                <small class="form-text text-muted">Mínimo 20 caracteres, máximo 250 caracteres.</small>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>