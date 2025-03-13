<?php

class Database
{
    private $dbh;
    private $connected = false;

    public function __construct()
    {    
        try {
            // Configuración de conexión a la base de datos
            $host = "mariadb";
            $dbname = "ProyectoIAW";
            $user = "root";
            $pass = "changepassword";
            


            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $this->dbh = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            $this->connected = true;
        } catch (PDOException $e) {
            error_log("Error de conexión a base de datos: " . $e->getMessage());
            // No terminamos la ejecución, permitimos que la aplicación siga funcionando
        }
    }

    public function getConnection()
    {
        if (!$this->connected) {
            throw new Exception("No hay conexión a la base de datos disponible");
        }
        return $this->dbh;
    }
    
    public function isConnected()
    {
        return $this->connected;
    }
    
    // Método para hacer consultas a la base de datos
    public function query($sql, $params = [])
    {
        if (!$this->connected) {
            throw new Exception("No hay conexión a la base de datos disponible");
        }
        
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en consulta SQL: " . $e->getMessage());
            throw new Exception("Error en la consulta a la base de datos");
        }
    }
    
    // Método para obtener un solo registro
    public function fetchOne($sql, $params = [])
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Método para obtener todos los registros
    public function fetchAll($sql, $params = [])
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}

?>