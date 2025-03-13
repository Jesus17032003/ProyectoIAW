<div class="container">
    <h2 class="section-title">Detalles del Producto</h2>
    
    <div class="product-detail">
        <div class="product-image">
            <img src="assets/<?php echo $producto->imagen; ?>" alt="<?php echo $producto->nombre; ?>" width="300" />
        </div>
        
        <div class="product-info">
            <h1><?php echo $producto->nombre; ?></h1>
            <p class="product-price"><?php echo $producto->precio; ?> €</p>
            <div class="product-description">
                <h3>Descripción:</h3>
                <p><?php echo $producto->descripcion; ?></p>
            </div>
            
            <div class="product-actions">
                <button class="add-to-cart" onclick="addToCart(<?php echo $producto->id; ?>)">Añadir al Carrito</button>
                <a href="Index.php?controller=Productocontroles&action=listar" class="btn-back">Volver a la lista</a>
            </div>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-title {
    text-align: center;
    margin-bottom: 30px;
    color: #2563eb;
}

.product-detail {
    display: flex;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.product-image {
    flex: 0 0 40%;
    background-color: #f0f9ff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.product-image img {
    max-width: 100%;
    height: auto;
}

.product-info {
    flex: 0 0 60%;
    padding: 30px;
}

.product-info h1 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #1e3a8a;
}

.product-price {
    font-size: 2rem;
    font-weight: bold;
    color: #f87171;
    margin-bottom: 20px;
}

.product-description {
    margin-bottom: 30px;
}

.product-description h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #2563eb;
}

.product-description p {
    color: #4b5563;
    line-height: 1.6;
}

/* Modificación para centrar mejor los botones en la vista de producto */
.product-actions {
    display: flex;
    gap: 15px;
    justify-content: center; /* Centrar horizontalmente los botones */
    margin-top: 30px; /* Añadir más espacio superior */
    width: 100%; /* Asegurar que ocupa todo el ancho disponible */
}

.add-to-cart {
    background-color: #2563eb;
    color: white;
    padding: 12px 25px; /* Botones ligeramente más grandes */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    flex: 1; /* Ambos botones con el mismo ancho */
    max-width: 200px; /* Limitar el ancho máximo */
    text-align: center; /* Centrar el texto */
}

.add-to-cart:hover {
    background-color: #1d4ed8;
}

.btn-back {
    background-color: #9ca3af;
    color: white;
    padding: 12px 25px; /* Mantener el mismo padding que el otro botón */
    text-decoration: none;
    border-radius: 4px;
    font-size: 1rem;
    text-align: center;
    flex: 1; /* Mismo ancho que el otro botón */
    max-width: 200px; /* Limitar el ancho máximo */
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-back:hover {
    background-color: #6b7280;
}

/* Asegurar que en móviles también queden bien alineados */
@media (max-width: 768px) {
    .product-actions {
        flex-direction: column; /* En móviles, apilar los botones */
        align-items: center;
    }
    
    .add-to-cart, .btn-back {
        width: 100%; /* En móviles, ocupar todo el ancho disponible */
        max-width: 300px; /* Pero con un límite razonable */
    }
}
</style>

<script>
function addToCart(productId) {
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