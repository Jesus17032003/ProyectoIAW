-- Creación de la tabla de productos
CREATE TABLE productos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255) NULL,
    PRIMARY KEY (id)
) COLLATE='latin1_swedish_ci';

-- Creación de la tabla de usuarios
CREATE TABLE usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    PRIMARY KEY (id)
) COLLATE='latin1_swedish_ci';

-- Inserción de datos de ejemplo en la tabla de productos
INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES
('Portátil UltraBook Pro', 'Intel Core i7, 16GB RAM, 512GB SSD, Pantalla 15.6" Full HD, Windows 11', 899.99, '1.jpg'),
('PC Gaming Extreme', 'AMD Ryzen 9, 32GB RAM, RTX 4070, 1TB SSD, 2TB HDD, RGB, Windows 11', 1299.99, '2.jpg'),
('Monitor Curvo 32"', 'Pantalla curva 32", 4K, 144Hz, 1ms, HDR, FreeSync, HDMI, DisplayPort', 349.99, '3.jpg'),
('Forgeon Vendetta Ratón Gaming RGB 16000DPI Negro', 'El mejor ratón actual del mercado', 34.99, '4.png'),
('Krom Kernel Teclado Mecánico Gaming RGB Negro', 'El mejor teclado mecánico de nuestra tienda', 31.99, '5.png'),
('Logitech G435 LIGHTSPEED Auriculares Gaming Inalámbricos', 'Los mejores cascos del mercado actual', 54.99, '6.png'),
('Logitech Pack G29 Volante Driving Force para PS5/PC', 'Uno de nuestro set de simulación más vendido actualmente', 270.0, '8.png'),
('Portátil MSI Thin 15 B12UC-1839XES Intel Core i7-1', 'Uno de nuestros portátiles Gaming más potentes del mercado', 749.0, '7.png'),
('Klack KPS4 Mando Inalámbrico para PC/PS4 Rojo', '¿Necesitas un mando para tu pc? Que mejor que nuestros mandos de pc/ps4 con nuestros botones y sticks mejorados para una mejor sensación', 22.95, '9.png');

-- Inserción de datos de ejemplo en la tabla de usuarios
INSERT INTO usuarios (username, password, role) VALUES
('admin', 'admin', 'admin'),
('usuario', '1234', 'user'),



--Tanto si queremos añadir nuevos usuarios o productos se añadiran aqui--