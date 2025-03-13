<!--
    Vista para añadir nuevos productos. Contiene el código HTML con el formulario así como el código PHP para
    mostrar errores de validación, en caso de existir.
-->
<div class="container"> 
   <h5>Introduce los datos de los productos:</h2>

    <form class="form" action="Index.php?controller=Productocontroles&action=aniadirProducto" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-label" for="nombre">Id:</label>
            <input class="form-control" type="text" name="id" ><br>
            <?php
                if (isset($data) && isset($data['id']))
                echo "<div class='alert alert-danger'>"
                       .$data['id'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="Edad">Nombre:</label>
            <input class="form-control" type="text" name="nombre" maxlength="50" value="" ><br>
            <?php
                if (isset($data) && isset ($data['nombre']))
                echo "<div class='alert alert-danger'>"
                       .$data['nombre'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="Edad">Descripción:</label>
            <input class="form-control" type="text" name="descripcion" maxlength="150" value="" ><br>
            <?php
                if (isset($data) && isset ($data['descripcion']))
                echo "<div class='alert alert-danger'>"
                       .$data['descripcion'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="Edad">Precio:</label>
            <input class="form-control" type="text" name="precio" maxlength="50" value="" ><br>
            <?php
                if (isset($data) && isset ($data['precio']))
                echo "<div class='alert alert-danger'>"
                       .$data['precio'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="Edad">Imagen:</label>
            <input class="form-control"  type="file" name="imagen" accept="image/*"><br>
            <?php
                if (isset($data) && isset ($data['imagen']))
                echo "<div class='alert alert-danger'>"
                       .$data['imagen'].
                      "</div>";
            ?>
        </div>
        
        <?php
                if (isset($data) && isset($data['general']))
                echo "<div class='alert alert-danger'>"
                       .$data['general'].
                      "</div>";
            ?>
        <div class="form-group">
            <input class="form-control" type="submit" name="insertar" value="Enviar">
        </div>
        
    </form>
    </div>