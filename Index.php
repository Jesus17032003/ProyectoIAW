<?php
// Iniciar la sesión al comienzo de todo
session_start();

include_once("Controles/Productocontroles.php");
include_once("Controles/Controladorcarrito.php");
include_once("Controles/UsuarioController.php");

// Punto de entrada a la aplicación
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controllerName = $_GET['controller'];
    $action = $_GET['action'];
    
    // Incluir el archivo del controlador
    // Modificación para manejar el caso especial del controlador Carrito
    $controllerFile = 'Controles/' . ($controllerName == 'Carrito' ? 'Controladorcarrito' : $controllerName) . '.php';
    
    if (file_exists($controllerFile)) {
        include_once($controllerFile);
        
        // Instanciar el controlador
        $controllerClass = ucfirst($controllerName);
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            
            // Verificar si la acción requiere autenticación
            $requiresAuth = false;
            $adminOnly = false;
            
            // Definir acciones que requieren autenticación o permisos de administrador
            if ($controllerName == 'Productocontroles' && in_array($action, ['admin', 'crear', 'editar', 'eliminar'])) {
                $requiresAuth = true;
                $adminOnly = true;
            } else if ($controllerName == 'Carrito' && in_array($action, ['eliminar', 'comprar'])) {
                $requiresAuth = true;
            }
            
            // Verificar la autenticación si es necesario
            if ($requiresAuth && !isset($_SESSION['username'])) {
                // Usuario no autenticado, redirigir a la página de inicio
                header("Location: Index.php?error=auth_required");
                exit;
            }
            
            // Verificar permisos de administrador si es necesario
            if ($adminOnly && (!isset($_SESSION['userType']) || $_SESSION['userType'] != 'admin')) {
                // Usuario no es administrador, redirigir a la página de inicio
                header("Location: Index.php?error=admin_required");
                exit;
            }
            
            // Verificar si la acción existe
            if (method_exists($controller, $action)) {
                // Ejecutar la acción - puede enviar cabeceras o salida
                $controller->$action();
                exit; // Importante: Salir después de que la acción del controlador se haya ejecutado
            } else {
                // Incluir el header antes de mostrar el error
                include_once("Vistas/Header.php");
                echo "Acción no encontrada: " . $action;
            }
        } else {
            // Incluir el header antes de mostrar el error
            include_once("Vistas/Header.php");
            echo "Controlador no encontrado: " . $controllerClass;
        }
    } else {
        // Incluir el header antes de mostrar el error
        include_once("Vistas/Header.php");
        echo "Archivo de controlador no encontrado: " . $controllerFile;
    }
} else {
    // Si no hay parámetros, mostrar la página de inicio
    // Incluir el header para la página principal
    include_once("Vistas/Header.php");
    
    // Verificar si hay mensajes de error
    $errorMessage = '';
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 'auth_required':
                $errorMessage = '<div style="background-color: #fed7d7; color: #9b2c2c; padding: 10px; margin: 10px 0; border-radius: 4px;">Debes iniciar sesión para acceder a esta funcionalidad.</div>';
                break;
            case 'admin_required':
                $errorMessage = '<div style="background-color: #fed7d7; color: #9b2c2c; padding: 10px; margin: 10px 0; border-radius: 4px;">Se requieren permisos de administrador para acceder a esta funcionalidad.</div>';
                break;
            case 'login_failed':
                $errorMessage = '<div style="background-color: #fed7d7; color: #9b2c2c; padding: 10px; margin: 10px 0; border-radius: 4px;">Usuario o contraseña incorrectos. Inténtalo de nuevo.</div>';
                break;
            case 'login_required':
                $errorMessage = '<div style="background-color: #fed7d7; color: #9b2c2c; padding: 10px; margin: 10px 0; border-radius: 4px;">Debes iniciar sesión para finalizar la compra. Por favor, inicia sesión y vuelve a intentarlo.</div>';
                break;
            case 'cart_empty':
                $errorMessage = '<div style="background-color: #fed7d7; color: #9b2c2c; padding: 10px; margin: 10px 0; border-radius: 4px;">Tu carrito está vacío. Añade productos antes de finalizar la compra.</div>';
                break;
        }
    }

    echo '<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Jesus\'s Shop</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="Vistas/styles.css" rel="stylesheet">
        </head>
        <body>
        ' . $errorMessage . '
        <section class="hero">
            <div class="hero-content">
                <h1>Tecnología de Última Generación</h1>
                <p>Descubre nuestra amplia gama de ordenadores y componentes al mejor precio.</p>
                ' . (isset($_SESSION['username']) ? '<p>Bienvenido de nuevo, ' . htmlspecialchars($_SESSION['username']) . '!</p>' : '') . '
            </div>
        </section>

        <!-- Featured Products -->
        <section class="products">
            <h2 class="section-title">Productos Destacados</h2>
            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-image">
                    <img src="assets/1.jpg" alt="Ordenador portátil" width="220" height="160"/>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Portátil UltraBook Pro</h3>
                        <p class="product-price">899,99 €</p>
                        <p class="product-description">Intel Core i7, 16GB RAM, 512GB SSD, Pantalla 15.6" Full HD, Windows 11</p>
                        <button class="add-to-cart" onclick="addToCart(1)">Añadir al Carrito</button>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="assets/2.jpg" alt="PC Gaming" width="150" height="170" />
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">PC Gaming Extreme</h3>
                        <p class="product-price">1.299,99 €</p>
                        <p class="product-description">AMD Ryzen 9, 32GB RAM, RTX 4070, 1TB SSD, 2TB HDD, RGB, Windows 11</p>
                        <button class="add-to-cart" onclick="addToCart(2)">Añadir al Carrito</button>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="assets/3.jpg" alt="Monitor Curvo" width="200" height="170" />
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Monitor Curvo 32"</h3>
                        <p class="product-price">349,99 €</p>
                        <p class="product-description">Pantalla curva 32", 4K, 144Hz, 1ms, HDR, FreeSync, HDMI, DisplayPort</p>
                        <button class="add-to-cart" onclick="addToCart(3)">Añadir al Carrito</button>
                    </div>
                </div>
            </div>
        </section>
        
        <script>
            function addToCart(productId) {
                // Ya no verificamos si el usuario ha iniciado sesión
                fetch("Index.php?controller=Carrito&action=agregar", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "productId=" + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar el contador del carrito
                        const cartCountElement = document.querySelector(".cart-count");
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cartCount;
                        }
                        alert("Producto añadido al carrito");
                    } else {
                        alert("Error al añadir el producto: " + data.message);
                    }
                });
            }
        </script>
        </body>
    </html>';
}

// Solo incluir el footer si no hemos salido ya
if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    include_once("Vistas/Footer.php");
}
?>