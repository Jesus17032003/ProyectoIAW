<?php
require_once __DIR__ . '/../Models/Producto.php';
require_once __DIR__ . '/../Vistas/Vista.php';
require_once __DIR__ . '/UsuarioController.php';

class Productocontroles {
    private $model;
    private $UsuarioController;
    
    public function __construct() {
        $this->model = new Producto();
        $this->UsuarioController = new UsuarioController();
        
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Método para listar todos los productos
    public function listar() {
        // Obtener todos los productos del modelo
        $array_productos = $this->model->getAll();
        
        // Preparar los datos para la vista
        $data = [
            'array_productos' => $array_productos
        ];
        
        // Mostrar la vista con los datos
        View::show('listausu.php', $data);
    }
    
    // Método para mostrar el formulario de añadir producto
    public function mostrarFormularioAnadir() {
        // Verificar si el usuario es administrador
        if (!$this->UsuarioController->esAdmin()) {
            // Redirigir a la lista de productos con un mensaje de error
            header('Location: Index.php?controller=Productocontroles&action=listar&error=forbidden');
            exit;
        }
        
        View::show('Añadirproducto.php');
    }
    
    // Método para procesar la adición de un nuevo producto
    public function aniadirProducto() {
        // Verificar si el usuario es administrador
        if (!$this->UsuarioController->esAdmin()) {
            // Redirigir a la lista de productos con un mensaje de error
            header('Location: Index.php?controller=Productocontroles&action=listar&error=forbidden');
            exit;
        }
        
        $errores = [];
        $valido = true;
        
        // Validación del ID
        if (empty($_POST['id'])) {
            $errores['id'] = "El ID es obligatorio";
            $valido = false;
        }
        
        // Validación del nombre
        if (empty($_POST['nombre'])) {
            $errores['nombre'] = "El nombre es obligatorio";
            $valido = false;
        }
        
        // Validación de la descripción
        if (empty($_POST['descripcion'])) {
            $errores['descripcion'] = "La descripción es obligatoria";
            $valido = false;
        }
        
        // Validación del precio
        if (empty($_POST['precio'])) {
            $errores['precio'] = "El precio es obligatorio";
            $valido = false;
        } elseif (!is_numeric($_POST['precio'])) {
            $errores['precio'] = "El precio debe ser un número";
            $valido = false;
        }
        
        // Validación de la imagen
        $nombre_imagen = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (in_array($_FILES['imagen']['type'], $tipos_permitidos)) {
                $nombre_imagen = $_FILES['imagen']['name'];
                $ruta_destino = "assets/" . $nombre_imagen;
                
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
                    $errores['imagen'] = "Error al subir la imagen";
                    $valido = false;
                }
            } else {
                $errores['imagen'] = "Tipo de archivo no permitido. Solo se permiten imágenes JPEG, PNG y GIF";
                $valido = false;
            }
        } elseif ($_FILES['imagen']['error'] != 4) { // 4 significa que no se subió ningún archivo
            $errores['imagen'] = "Error al subir la imagen";
            $valido = false;
        }
        
        // Si todo es válido, guardar el producto
        if ($valido) {
            $this->model->id = $_POST['id'];
            $this->model->nombre = $_POST['nombre'];
            $this->model->descripcion = $_POST['descripcion'];
            $this->model->precio = $_POST['precio'];
            $this->model->imagen = $nombre_imagen;
            
            if ($this->model->add()) {
                // Redirigir a la lista de productos
                header('Location: Index.php?controller=Productocontroles&action=listar');
                exit;
            } else {
                $errores['general'] = "Error al guardar el producto";
                View::show('Añadirproducto.php', ['data' => $errores]);
            }
        } else {
            // Mostrar el formulario con los errores
            View::show('Añadirproducto.php', ['data' => $errores]);
        }
    }
    
    // Método para mostrar los detalles de un producto
    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if ($this->model->getById($id)) {
                $data = [
                    'producto' => $this->model
                ];
                
                View::show('verproducto.php', $data);
            } else {
                echo "Producto no encontrado";
            }
        } else {
            echo "ID de producto no especificado";
        }
    }
    
    // Método para eliminar un producto
    public function eliminar() {
        // Verificar si el usuario es administrador
        if (!$this->UsuarioController->esAdmin()) {
            // Redirigir a la lista de productos con un mensaje de error
            header('Location: Index.php?controller=Productocontroles&action=listar&error=forbidden');
            exit;
        }
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if ($this->model->delete($id)) {
                header('Location: Index.php?controller=Productocontroles&action=listar');
                exit;
            } else {
                echo "Error al eliminar el producto";
            }
        } else {
            echo "ID de producto no especificado";
        }
    }
}
?>