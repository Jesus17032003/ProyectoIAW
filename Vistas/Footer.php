<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Footer - Jesus's Shop</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Jesus'Shop</h3>
                <p>Tu tienda de confianza para todo lo relacionado con tecnología y ordenadores.</p>
            </div>
            
            
            <div class="footer-section">
                <h3>Contacto</h3>
                <ul>
                    <li>Polígono Industrial, 12</li>
                    <li>06800 Mérida, España</li>
                    <li>jesusshopinfo@gmail.com</li>
                    <li>+34 924 562 566</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 Jesus'Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
    
    <style>
        /* Estilos del footer */
        .footer {
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 40px 0 20px;
            margin-top: 40px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 0 20px;
        }
        
        .footer-section {
            flex: 1;
            min-width: 250px;
            margin-bottom: 20px;
        }
        
        .footer-section h3 {
            color: white;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-section li {
            margin-bottom: 8px;
        }
        
        .footer-section a {
            color: #e2e8f0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section a:hover {
            color: #2563eb;
        }
        
        .footer-bottom {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #334155;
        }
        
        .footer-bottom p {
            margin: 0;
            font-size: 0.9rem;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr; /* Divide en tres columnas */
            gap: 20px;
            padding: 0 20px;
        }

        .footer-section:first-child {
            grid-column: 1; /* Primera sección en la primera columna */
        }

        .footer-section:last-child {
            grid-column: 3; /* Sección de contacto en la tercera columna */
            text-align: right;
        }
        
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
            }
            
            .footer-section {
                margin-bottom: 30px;
            }
        }
    </style>
</body>
</html>