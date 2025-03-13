<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito - Jesus's Shop</title>
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .cart-title {
            color: #2563eb;
            margin-bottom: 20px;
        }
        
        .cart-empty {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .cart-table th, .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .cart-table th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        
        .product-info {
            display: flex;
            align-items: center;
        }
        
        .product-image {
            width: 80px;
            height: 60px;
            margin-right: 15px;
            object-fit: contain;
        }
        
        .product-details h4 {
            margin: 0 0 5px 0;
            color: #1f2937;
        }
        
        .product-details p {
            margin: 0;
            color: #6b7280;
        }
        
        .remove-btn {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .remove-btn:hover {
            background-color: #dc2626;
        }
        
        .cart-summary {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .cart-total {
            margin-right: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        
        .checkout-btn {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .checkout-btn:hover {
            background-color: #059669;
        }
        
        .continue-shopping {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }
        
        .continue-shopping:hover {
            text-decoration: underline;
        }
        
        .login-message {
            background-color: #fed7d7;
            color: #9b2c2c;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        
        .login-link {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .login-link:hover {
            background-color: #1d4ed8;
        }
        
        .error-message {
            background-color: #fed7d7;
            color: #9b2c2c;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h1 class="cart-title">Tu Carrito de Compra</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php 
                $error = $_GET['error'];
                switch($error) {
                    case 'login_required':
                        echo "Debes iniciar sesión para finalizar la compra.";
                        break;
                    case 'cart_empty':
                        echo "Tu carrito está vacío.";
                        break;
                    case 'product_not_found':
                        echo "El producto que intentas eliminar no existe en tu carrito.";
                        break;
                    case 'no_index':
                        echo "No se especificó el producto a eliminar.";
                        break;
                    default:
                        echo "Ha ocurrido un error.";
                }
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($productos)): ?>
            <div class="cart-empty">
                <p>Tu carrito está vacío</p>
                <a href="Index.php" class="continue-shopping">Continuar comprando</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $index => $producto): ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-image" onerror="this.src='assets/images/default.jpg';">
                                <div class="product-details">
                                    <h4><?php echo htmlspecialchars($producto['nombre']); ?></h4>
                                    <p>ID: <?php echo $producto['id']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>€<?php echo number_format($producto['precio'], 2); ?></td>
                        <td><?php echo $producto['quantity']; ?></td>
                        <td>€<?php echo number_format($producto['subtotal'], 2); ?></td>
                        <td>
                            <form action="Index.php" method="GET">
                                <input type="hidden" name="controller" value="Carrito">
                                <input type="hidden" name="action" value="eliminar">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="remove-btn">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="cart-summary">
                <div class="cart-total">
                    Total: €<?php echo number_format($total, 2); ?>
                </div>
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Usuario ha iniciado sesión - mostrar botón normal de finalizar compra -->
                    <form action="Index.php" method="POST">
                        <input type="hidden" name="controller" value="Carrito">
                        <input type="hidden" name="action" value="comprar">
                        <button type="submit" class="checkout-btn">Finalizar Compra</button>
                    </form>
                <?php else: ?>
                    <!-- Usuario no ha iniciado sesión - mostrar mensaje y enlace para iniciar sesión -->
                    <div class="login-message">
                        Debes iniciar sesión para finalizar la compra
                        <a href="Index.php?controller=UsuarioController&action=mostrarFormularioLogin" class="login-link">Iniciar Sesión</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <a href="Index.php" class="continue-shopping">Continuar comprando</a>
        <?php endif; ?>
    </div>
    
    <script>
        // Verificar si hay errores en la carga de imágenes y reemplazarlos con la imagen predeterminada
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.product-image');
            images.forEach(img => {
                img.onerror = function() {
                    this.src = 'assets/images/default.jpg';
                }
            });
        });
    </script>
</body>
</html>