<?php
require_once(__DIR__ . "/../Base de datos/Basededatos.php");

class Carrito {
    private $db;

    public function __construct() {
        // Inicializar la conexión a la base de datos
        $this->db = new Database();
        
        // Asegurar que la sesión esté iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Inicializar el carrito si no existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Método para agregar productos al carrito
    public function agregar() {
        // Verificar si se recibió el ID del producto
        if (isset($_POST['productId'])) {
            $productId = (int)$_POST['productId'];
            
            // Verificar si el producto existe en la base de datos
            if ($this->db->isConnected()) {
                try {
                    // Usamos el método fetchOne de la clase Database
                    $producto = $this->db->fetchOne("SELECT id, nombre, precio, imagen FROM productos WHERE id = ?", [$productId]);
                    
                    if (!$producto) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
                        exit;
                    }
                    
                    // Verificar si el producto ya está en el carrito
                    $found = false;
                    foreach ($_SESSION['cart'] as $key => $item) {
                        if ($item['id'] == $productId) {
                            $_SESSION['cart'][$key]['quantity'] += 1;
                            $found = true;
                            break;
                        }
                    }
                    
                    // Si no se encontró, añadir el producto al carrito con todos sus datos
                    if (!$found) {
                        $_SESSION['cart'][] = [
                            'id' => $productId,
                            'nombre' => $producto['nombre'],
                            'precio' => $producto['precio'],
                            'imagen' => !empty($producto['imagen']) ? 'assets/' . $producto['imagen'] : 'assets/images/default.jpg',
                            'quantity' => 1,
                            'timestamp' => time()
                        ];
                    }
                    
                    // Responder con éxito
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true, 
                        'cartCount' => $this->getCartItemCount(),
                        'message' => 'Producto añadido al carrito'
                    ]);
                    exit;
                } catch (Exception $e) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Error al acceder a la base de datos: ' . $e->getMessage()]);
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No hay conexión a la base de datos']);
                exit;
            }
        } else {
            // Responder con error
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID de producto no especificado']);
            exit;
        }
    }
    
    // Método para obtener el número total de items en el carrito
    private function getCartItemCount() {
        $count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    // Método para ver el carrito
    public function ver() {
        $productos = [];
        $total = 0;
        
        // Comprobar si hay elementos en el carrito
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if (isset($item['nombre']) && isset($item['precio']) && isset($item['quantity'])) {
                    $subtotal = $item['precio'] * $item['quantity'];
                    $total += $subtotal;
                    
                    $productos[] = [
                        'id' => $item['id'],
                        'nombre' => $item['nombre'],
                        'precio' => $item['precio'],
                        'imagen' => isset($item['imagen']) ? $item['imagen'] : 'assets/images/default.jpg',
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal
                    ];
                }
            }
        }
        
        // Incluir la vista del carrito pasando los productos y el total
        include_once("Vistas/Carrito.php");
    }
    
    // Método para eliminar productos del carrito
    public function eliminar() {
        // Verificar si se recibió el índice del producto
        if (isset($_GET['index'])) {
            $index = (int)$_GET['index'];
            
            // Verificar que el índice existe en el carrito
            if (isset($_SESSION['cart'][$index])) {
                // Eliminar el producto del carrito
                unset($_SESSION['cart'][$index]);
                
                // Reindexar el array para evitar problemas con índices no continuos
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                
                // Redirigir de vuelta al carrito después de eliminar
                header("Location: Index.php?controller=Carrito&action=ver");
                exit;
            } else {
                // Redirigir con mensaje de error
                header("Location: Index.php?controller=Carrito&action=ver&error=product_not_found");
                exit;
            }
        } else {
            // Redirigir con mensaje de error
            header("Location: Index.php?controller=Carrito&action=ver&error=no_index");
            exit;
        }
    }
    
    // Método para procesar la compra
    public function comprar() {
        // Verificar si el usuario ha iniciado sesión para la compra
        if (!isset($_SESSION['username'])) {
            // Redirigir al usuario a la página del carrito con un mensaje de error
            header("Location: Index.php?controller=Carrito&action=ver&error=login_required");
            exit;
        }
        
        // Verificar que el carrito no esté vacío
        if (empty($_SESSION['cart'])) {
            header("Location: Index.php?controller=Carrito&action=ver&error=cart_empty");
            exit;
        }
        
        // Limpiar el carrito
        $_SESSION['cart'] = [];

        header("Location: Index.php?controller=Producto&action=index&success=compra_completada");
        
        
        exit;
    }
}
?>