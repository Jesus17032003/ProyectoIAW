<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay una sesión activa
$sesionActiva = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

// Asegurarnos de que $data existe
if (!isset($data) || !isset($data['array_productos'])) {
    // Si se accede directamente a este archivo sin datos
    echo "<div class='container'><h2>Error: No hay datos de productos disponibles</h2></div>";
} else {
    $array_productos = $data['array_productos'];
?>
    <div class="container">
        <h2 class="section-title">Listado de Productos</h2>
        
        <?php if ($sesionActiva && $esAdmin): ?>
        <!-- Solo mostrar la opción de añadir si es administrador -->
        <div class="actions-container">
            <a href='Index.php?controller=Productocontroles&action=mostrarFormularioAnadir' class='btn-add'>Añadir Nuevo Producto</a>
        </div>
        <?php endif; ?>
        
        <div class="product-list">
            <table class="productos-tabla">
                <thead>
                    <tr>
                        
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Mas Infomación</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($array_productos as $producto): ?>
                    <tr>
                        
                        <td><?php echo $producto->nombre; ?></td>
                        <td><?php echo $producto->precio; ?> €</td>
                        <td><img src="assets/<?php echo $producto->imagen; ?>" alt="<?php echo $producto->nombre; ?>" width="100" height="75"/></td>
                        <td class="actions-cell">
                            <a href="Index.php?controller=Productocontroles&action=ver&id=<?php echo $producto->id; ?>" class="btn-view">Ver</a>
                            <?php if ($sesionActiva && $esAdmin): ?>
                            <!-- Solo mostrar la opción de eliminar si es administrador -->
                            <a href="Index.php?controller=Productocontroles&action=eliminar&id=<?php echo $producto->id; ?>" class="btn-delete" onclick="return confirm('¿Está seguro de que desea eliminar este producto?')">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
?>

<style>
/* Estos estilos se aplican solo a la tabla de productos y no interfieren con el header/footer */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-title {
    text-align: center;
    margin-bottom: 30px;
    color: #2563eb;
    font-size: 1.8rem;
}

.actions-container {
    margin-bottom: 20px;
    text-align: right;
}

.btn-add {
    display: inline-block;
    background-color: #2563eb;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn-add:hover {
    background-color: #1d4ed8;
}

.product-list {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.productos-tabla {
    width: 100%;
    border-collapse: collapse;
}

.productos-tabla th, .productos-tabla td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.productos-tabla th {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #2563eb;
}

.productos-tabla tr:hover {
    background-color: #f0f9ff;
}

.productos-tabla img {
    display: block;
    margin: 0 auto;
    object-fit: cover;
    border-radius: 4px;
}

/* Para pantallas más grandes, permitir desplazamiento para descripciones muy largas */
@media (min-width: 992px) {
    .descripcion-cell {
        max-height: 100px;
        overflow: auto;
    }
}

.actions-cell {
    white-space: nowrap;
    text-align: center;
}

.btn-view, .btn-delete {
    display: inline-block;
    padding: 6px 12px;
    margin: 0 3px;
    text-decoration: none;
    border-radius: 4px;
    font-size: 0.9rem;
    transition: background-color 0.3s;
}

.btn-view {
    background-color: #2563eb;
    color: white;
}

.btn-view:hover {
    background-color: #1d4ed8;
}

.btn-delete {
    background-color: #f87171;
    color: white;
}

.btn-delete:hover {
    background-color: #ef4444;
}

@media (max-width: 768px) {
    .productos-tabla {
        display: block;
        overflow-x: auto;
    }
    
    .actions-cell {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-view, .btn-delete {
        margin: 2px 0;
    }
}
</style>