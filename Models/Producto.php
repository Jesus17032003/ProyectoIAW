<?php
class Producto {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;
    
    private $db;
    
    public function __construct() {
        // Inicializar la conexión a la base de datos
        require_once __DIR__ . '/../Base de datos/Basededatos.php';
        $database = new Database();
        if ($database->isConnected()) {
            $this->db = $database->getConnection();
        } else {
            // Manejar el error de conexión
            echo "Error: No se pudo conectar a la base de datos";
        }
    }
    
    // Método para añadir un nuevo producto
    public function add() {
        try {
            if ($this->db) {
                // Verificar si el producto ya existe
                $check_query = "SELECT * FROM productos WHERE id = :id";
                $check_stmt = $this->db->prepare($check_query);
                $check_stmt->bindParam(':id', $this->id);
                $check_stmt->execute();
                
                if ($check_stmt->rowCount() > 0) {
                    return false; // Producto ya existe
                }
                
                // Insertar nuevo producto
                $query = "INSERT INTO productos (id, nombre, descripcion, precio, imagen) 
                          VALUES (:id, :nombre, :descripcion, :precio, :imagen)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':nombre', $this->nombre);
                $stmt->bindParam(':descripcion', $this->descripcion);
                $stmt->bindParam(':precio', $this->precio);
                $stmt->bindParam(':imagen', $this->imagen);
                
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            // Manejar el error
            error_log("Error al añadir producto: " . $e->getMessage());
            return false;
        }
        
        return false;
    }
    
    // Método para obtener todos los productos
    public function getAll() {
        $productos = [];
        
        try {
            if ($this->db) {
                $query = "SELECT * FROM productos";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $producto = new Producto();
                    $producto->id = $row['id'];
                    $producto->nombre = $row['nombre'];
                    $producto->descripcion = $row['descripcion'];
                    $producto->precio = $row['precio'];
                    $producto->imagen = $row['imagen'];
                    
                    $productos[] = $producto;
                }
            }
        } catch (PDOException $e) {
            // Manejar el error
            error_log("Error al obtener productos: " . $e->getMessage());
        }
        
        return $productos;
    }
    
    // Método para obtener un producto por su ID
    public function getById($id) {
        try {
            if ($this->db) {
                $query = "SELECT * FROM productos WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->id = $row['id'];
                    $this->nombre = $row['nombre'];
                    $this->descripcion = $row['descripcion'];
                    $this->precio = $row['precio'];
                    $this->imagen = $row['imagen'];
                    return true;
                }
            }
        } catch (PDOException $e) {
            // Manejar el error
            error_log("Error al obtener producto por ID: " . $e->getMessage());
        }
        
        return false;
    }
    
    // Método para eliminar un producto
    public function delete($id) {
        try {
            if ($this->db) {
                $query = "DELETE FROM productos WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $id);
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            // Manejar el error
            error_log("Error al eliminar producto: " . $e->getMessage());
        }
        
        return false;
    }
    
    // Método para actualizar un producto existente (manteniendo el método update)
    public function update() {
        try {
            if ($this->db) {
                $query = "UPDATE productos 
                          SET nombre = :nombre, descripcion = :descripcion, 
                              precio = :precio, imagen = :imagen 
                          WHERE id = :id";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':nombre', $this->nombre);
                $stmt->bindParam(':descripcion', $this->descripcion);
                $stmt->bindParam(':precio', $this->precio);
                $stmt->bindParam(':imagen', $this->imagen);
                
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            // Manejar el error de actualización
            error_log("Error al actualizar: " . $e->getMessage());
        }
        
        return false;
    }
}
?>