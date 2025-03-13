<?php
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Vistas/Vista.php';

class UsuarioController {
    private $model;
    
    public function __construct() {
        $this->model = new Usuario();
        
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Método para mostrar el formulario de inicio de sesión
    public function mostrarFormularioLogin() {
        View::show('login.php');
    }
    
    // Método para procesar el inicio de sesión
    public function iniciarSesion() {
        $errores = [];
        $valido = true;
        
        // Validación del username
        if (empty($_POST['username'])) {
            $errores['username'] = "El nombre de usuario es obligatorio";
            $valido = false;
        }
        
        // Validación de la contraseña
        if (empty($_POST['password'])) {
            $errores['password'] = "La contraseña es obligatoria";
            $valido = false;
        }
        
        // Si todo es válido, intentar autenticar o registrar
        if ($valido) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $tipo_usuario = $_POST['tipo_usuario'] ?? 'usuario'; // Valor predeterminado: usuario
            $accion = isset($_POST['accion']) ? $_POST['accion'] : 'login';
            
            // Verificar si es un nuevo registro
            if ($accion === 'registrar') {
                // Verificar que no se intente crear un usuario admin
                if ($tipo_usuario === 'admin') {
                    $_SESSION['error_message'] = "No está permitido crear cuentas de administrador";
                    header('Location: Index.php?error=registro_admin_prohibido');
                    exit;
                }
                
                // Intentar registrar el nuevo usuario
                if ($this->model->register($username, $password, 'user')) {
                    $_SESSION['success_message'] = "Usuario registrado correctamente. Ahora puede iniciar sesión.";
                    header('Location: Index.php?success=registro_exitoso');
                    exit;
                } else {
                    $_SESSION['error_message'] = "No se pudo registrar el usuario. Es posible que el nombre de usuario ya exista.";
                    header('Location: Index.php?error=registro_fallido');
                    exit;
                }
            } else {
                // Proceso de inicio de sesión normal
                if ($this->model->login($username, $password)) {
                    // Verificar si el tipo de usuario coincide con el rol en la base de datos
                    if (($tipo_usuario == 'admin' && $this->model->role == 'admin') || 
                        ($tipo_usuario == 'usuario' && $this->model->role == 'user') ||
                        empty($tipo_usuario)) {
                        
                        // Guardar datos en la sesión
                        $_SESSION['user_id'] = $this->model->id;
                        $_SESSION['username'] = $this->model->username;
                        $_SESSION['user_role'] = $this->model->role;
                        $_SESSION['userType'] = $this->model->role;
                        $_SESSION['logged_in'] = true;
                        
                        // Guardar usuarios en la sesión para mostrarlos en la tabla
                        if (!isset($_SESSION['usuarios'])) {
                            $_SESSION['usuarios'] = [];
                        }
                        
                        // Agregar el usuario actual a la lista si no existe ya
                        $usuarioExistente = false;
                        foreach ($_SESSION['usuarios'] as $usuario) {
                            if ($usuario['id'] == $this->model->id) {
                                $usuarioExistente = true;
                                break;
                            }
                        }
                        
                        if (!$usuarioExistente) {
                            $_SESSION['usuarios'][] = [
                                'id' => $this->model->id,
                                'username' => $this->model->username,
                                'password' => '********', // Por seguridad no guardamos la contraseña real
                                'role' => $this->model->role
                            ];
                        }
                        
                        // Redirigir a la página principal
                        header('Location: Index.php');
                        exit;
                    } else {
                        $_SESSION['error_message'] = "El tipo de usuario seleccionado no coincide con sus permisos.";
                        header('Location: Index.php?error=login_failed');
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = "Nombre de usuario o contraseña incorrectos";
                    header('Location: Index.php?error=login_failed');
                    exit;
                }
            }
        }
        
        // Si llegamos aquí, hubo un error
        if (!empty($errores)) {
            // Mostrar el error en una sesión para el siguiente request
            $_SESSION['error_message'] = $errores['general'] ?? "Error al iniciar sesión. Inténtalo de nuevo.";
            header('Location: Index.php?error=login_failed');
            exit;
        }
    }
    
    // Método para registrar un nuevo usuario
    // Método para registrar un nuevo usuario
public function registrarUsuario() {
    $errores = [];
    $valido = true;
    
    // Validación del username
    if (empty($_POST['username'])) {
        $errores['username'] = "El nombre de usuario es obligatorio";
        $valido = false;
    }
    
    // Validación de la contraseña
    if (empty($_POST['password'])) {
        $errores['password'] = "La contraseña es obligatoria";
        $valido = false;
    }
    
    // Validación del tipo de usuario
    $tipo_usuario = $_POST['tipo_usuario'] ?? 'usuario';
    if ($tipo_usuario === 'admin') {
        $errores['tipo_usuario'] = "No está permitido crear cuentas de administrador";
        $valido = false;
    }
    
    // Si todo es válido, intentar registrar
    if ($valido) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($this->model->register($username, $password, 'user')) {
            $_SESSION['success_message'] = "Usuario registrado correctamente. Ahora puede iniciar sesión.";
            header('Location: Index.php?success=registro_exitoso');
            exit;
        } else {
            $_SESSION['error_message'] = "No se pudo registrar el usuario. Es posible que el nombre de usuario ya exista.";
            header('Location: Index.php?error=registro_fallido');
            exit;
        }
    }
    
    // Si llegamos aquí, hubo un error
    if (!empty($errores)) {
        $_SESSION['error_message'] = implode(", ", $errores);
        header('Location: Index.php?error=registro_fallido');
        exit;
    }
}
    
    
    // Método para cerrar sesión
    public function cerrarSesion() {
        // Destruir todas las variables de sesión
        $_SESSION = array();
    
        // Si se desea destruir la sesión completamente, borrar también la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // Finalmente, destruir la sesión
        session_destroy();
    
        // Redirigir a la página de inicio
        header('Location: Index.php');
        exit;
    }
    
    // Método para listar todos los usuarios (solo para administradores)
    public function listarUsuarios() {
        if ($this->esAdmin()) {
            // Obtener todos los usuarios desde el modelo
            $usuarios = $this->model->getAllUsers();
            
            // Guardar en sesión para mostrar en la tabla
            $_SESSION['usuarios'] = $usuarios;
            
            // Mostrar vista con los usuarios
            View::show('admin/usuarios.php', ['usuarios' => $usuarios]);
        } else {
            header('Location: Index.php');
            exit;
        }
    }
    
    // Método para verificar si hay una sesión activa
    public function verificarSesion() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: Index.php?controller=Usuariocontroles&action=mostrarFormularioLogin');
            exit;
        }
    }
    
    // Método para verificar si el usuario es administrador
    public function esAdmin() {
        return (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
    }
}
?>