<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .action-selector {
            margin-bottom: 20px;
            text-align: center;
        }
        .action-selector label {
            margin: 0 10px;
            font-weight: bold;
            cursor: pointer;
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-container {
            text-align: center;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <h1 class="form-title">Acceso al Sistema</h1>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        
        <div class="action-selector">
            <label>
                <input type="radio" name="form_action" value="login" checked onclick="toggleFormMode('login')"> Iniciar Sesión
            </label>
            <label>
                <input type="radio" name="form_action" value="register" onclick="toggleFormMode('register')"> Registrarme
            </label>
        </div>
        
        <form id="access-form" method="post" action="Index.php?controller=UsuarioController&action=iniciarSesion">
            <input type="hidden" id="accion" name="accion" value="login">
            
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div id="user-type-container" class="form-group">
                <label for="tipo_usuario">Tipo de usuario:</label>
                <select id="tipo_usuario" name="tipo_usuario">
                    <option value="usuario">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            
            <div class="form-group btn-container">
                <button type="submit" id="submit-button" class="btn btn-primary">Iniciar Sesión</button>
            </div>
        </form>
    </div>

    <script>
        function toggleFormMode(mode) {
            const form = document.getElementById('access-form');
            const submitButton = document.getElementById('submit-button');
            const userTypeContainer = document.getElementById('user-type-container');
            const accionInput = document.getElementById('accion');
            const formTitle = document.querySelector('.form-title');
            
            if (mode === 'register') {
                formTitle.textContent = 'Registro de Usuario';
                submitButton.textContent = 'Registrarme';
                accionInput.value = 'registrar';
                
                // Si es registro, mostrar solo la opción de usuario normal
                document.getElementById('tipo_usuario').value = 'usuario';
                // Ocultar el selector de tipo si es registro
                userTypeContainer.style.display = 'none';
                
                // Cambiar la acción del formulario al controlador correcto
                form.action = "Index.php?controller=UsuarioController&action=registrarUsuario";
            } else {
                formTitle.textContent = 'Iniciar Sesión';
                submitButton.textContent = 'Iniciar Sesión';
                accionInput.value = 'login';
                
                // Mostrar el selector de tipo si es login
                userTypeContainer.style.display = 'block';
                
                // Cambiar la acción del formulario
                form.action = "Index.php?controller=UsuarioController&action=iniciarSesion";
            }
        }
    </script>
</body>
</html>