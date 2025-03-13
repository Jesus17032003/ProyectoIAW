<?php
class Usuario {
    public $id;
    public $username;
    public $password;
    public $role;
    
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
    
    // Método para añadir un nuevo usuario (faltante)
    public function register($username, $password, $role = 'usuario') {
        try {
            if ($this->db) {
                // Verificar si el usuario ya existe
                $check_query = "SELECT * FROM usuarios WHERE username = :username";
                $check_stmt = $this->db->prepare($check_query);
                $check_stmt->bindParam(':username', $username);
                $check_stmt->execute();
                
                if ($check_stmt->rowCount() > 0) {
                    return false; // Usuario ya existe
                }
                
                // Hash de la contraseña para almacenamiento seguro
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertar nuevo usuario
                $query = "INSERT INTO usuarios (username, password, role) VALUES (:username, :password, :role)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':role', $role);
                
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            // Manejar el error
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
        
        return false;
    }
    
    // Método para validar credenciales de usuario (modificado)
    public function login($username, $password) {
        try {
            if ($this->db) {
                $query = "SELECT * FROM usuarios WHERE username = :username";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Verificar la contraseña
                    // Primero intentamos con password_verify (si está hasheada)
                    if (password_verify($password, $row['password'])) {
                        // Credenciales válidas
                        $this->id = $row['id'];
                        $this->username = $row['username'];
                        $this->role = $row['role'];
                        return true;
                    } 
                    // Si no funciona, comprobamos si coincide exactamente (para contraseñas sin hash)
                    else if ($password === $row['password']) {
                        // Credenciales válidas
                        $this->id = $row['id'];
                        $this->username = $row['username'];
                        $this->role = $row['role'];
                        return true;
                    }
                }
            }
        } catch (PDOException $e) {
            // Registrar el error
            error_log("Error en login: " . $e->getMessage());
        }
        
        return false;
    }
    
    // Método para obtener un usuario por su ID
    public function getById($id) {
        try {
            if ($this->db) {
                $query = "SELECT * FROM usuarios WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->id = $row['id'];
                    $this->username = $row['username'];
                    $this->role = $row['role'];
                    return true;
                }
            }
        } catch (PDOException $e) {
            // Manejar el error de consulta
            echo "Error en la consulta: " . $e->getMessage();
        }
        
        return false;
    }
public function getAllUsers() {
    $usuarios = [];
    
    try {
        if ($this->db) {
            $query = "SELECT * FROM usuarios";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuarios[] = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'password' => '********', // Por seguridad no guardamos la contraseña real
                    'role' => $row['role']
                ];
            }
        }
    } catch (PDOException $e) {
        // Manejar el error
        error_log("Error al obtener usuarios: " . $e->getMessage());
    }
    
    return $usuarios;
}

}
?>