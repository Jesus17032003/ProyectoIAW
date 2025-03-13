<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jesus's Shop</title>
    <style>
        /* Estilos generales */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
        }
        
        /* Estilos del header */
        .header {
            background-color: #2563eb; /* Azul similar al de la imagen */
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        
        .header-title span {
            color: #ffd700; /* Color dorado para "Shop" */
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-menu li {
            margin-left: 20px;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: #f0f0f0;
        }
        
        .header-right {
            display: flex;
            align-items: center;
        }
        
        .cart-icon {
            position: relative;
            margin-left: 20px;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #f87171;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow: auto;
        }
        
        .modal-content {
            background-color: #f9fafb;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 500px;
            position: relative;
        }
        
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: black;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .btn {
            background-color: #2563eb;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }
        
        .btn:hover {
            background-color: #1d4ed8;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            margin-right: 15px;
            color: white;
        }
        
        .user-info span {
            margin-right: 10px;
        }
        
        .logout-btn {
            background-color: #dc2626;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .logout-btn:hover {
            background-color: #b91c1c;
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #f87171;
        }
        
        /* Estilos para la tabla de usuarios */
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #1e293b;
            color: white;
        }
        
        .users-table th, .users-table td {
            padding: 10px;
            border: 1px solid #334155;
            text-align: left;
        }
        
        .users-table th {
            background-color: #0f172a;
            font-weight: bold;
        }
        
        .users-table tr:hover {
            background-color: #334155;
        }
        
        .users-container {
            margin: 20px;
            padding: 15px;
            background-color: #1e293b;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    // Iniciar la sesión si no está iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    
    <header class="header">
        <h1 class="header-title">Jesus's <span>Shop</span></h1>
        
        <nav>
            <ul class="nav-menu">
                <li><a href="Index.php">Inicio</a></li>
                <li><a href="Index.php?controller=Productocontroles&action=listar">Listar Productos</a></li>
            </ul>
        </nav>
        
        <div class="header-right">
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Usuario ha iniciado sesión -->
                <div class="user-info">
                    <span>Hola, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <form action="Index.php?controller=UsuarioController&action=cerrarSesion" method="post" style="display: inline;">
                        <button type="submit" class="logout-btn">Cerrar Sesión</button>
                    </form>
                </div>
            <?php else: ?>
                <!-- Usuario no ha iniciado sesión -->
                <a href="javascript:void(0)" onclick="openLoginModal()" style="color: white; text-decoration: none;">Iniciar Sesión</a>
            <?php endif; ?>
            
            <div class="cart-icon">
                <a href="Index.php?controller=Carrito&action=ver" style="color: white;">🛒</a>
                <span class="cart-count">
                    <?php 
                    echo isset($_SESSION['cart']) && is_array($_SESSION['cart']) 
                        ? count($_SESSION['cart']) 
                        : '0'; 
                    ?>
                </span>
            </div>
        </div>
    </header>

    <!-- Mostrar mensaje de error si existe -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-message">
            <?php 
                echo htmlspecialchars($_SESSION['error_message']); 
                unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
            ?>
        </div>
    <?php endif; ?>

    <!-- Solo la parte de inicio de sesión y el script -->
<!-- Modal de Inicio de Sesión -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <h2 id="modal-title">Iniciar Sesión</h2>
        <form id="loginForm" action="Index.php?controller=UsuarioController&action=iniciarSesion" method="post">
            <input type="hidden" id="modal-accion" name="accion" value="login">
            
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="modal-username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="modal-password" name="password" required>
            </div>
            <div class="form-group" id="modal-user-type-container">
                <label for="userType">Tipo de Usuario</label>
                <select id="userType" name="tipo_usuario">
                    <option value="usuario">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="action-selector">
                <label>
                    <input type="radio" name="modal_form_action" value="login" checked onclick="toggleModalMode('login')"> Iniciar Sesión
                </label>
                <label>
                    <input type="radio" name="modal_form_action" value="register" onclick="toggleModalMode('register')"> Registrarme
                </label>
            </div>
            <button type="submit" class="btn" id="modal-submit-button">Iniciar Sesión</button>
        </form>
    </div>
</div>

<script>
    function openLoginModal() {
        document.getElementById('loginModal').style.display = 'block';
    }

    function closeLoginModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    function toggleModalMode(mode) {
        const form = document.getElementById('loginForm');
        const submitButton = document.getElementById('modal-submit-button');
        const userTypeContainer = document.getElementById('modal-user-type-container');
        const accionInput = document.getElementById('modal-accion');
        const modalTitle = document.getElementById('modal-title');
        
        if (mode === 'register') {
            modalTitle.textContent = 'Registro de Usuario';
            submitButton.textContent = 'Registrarme';
            accionInput.value = 'registrar';
            
            // Si es registro, mostrar solo la opción de usuario normal
            document.getElementById('userType').value = 'usuario';
            // Ocultar el selector de tipo si es registro
            userTypeContainer.style.display = 'none';
            
            // Cambiar la acción del formulario
            form.action = "Index.php?controller=UsuarioController&action=registrarUsuario";
        } else {
            modalTitle.textContent = 'Iniciar Sesión';
            submitButton.textContent = 'Iniciar Sesión';
            accionInput.value = 'login';
            
            // Mostrar el selector de tipo si es login
            userTypeContainer.style.display = 'block';
            
            // Cambiar la acción del formulario
            form.action = "Index.php?controller=UsuarioController&action=iniciarSesion";
        }
    }

    // Cerrar modal si se hace clic fuera de él
    window.onclick = function(event) {
        var modal = document.getElementById('loginModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
</body>
</html>