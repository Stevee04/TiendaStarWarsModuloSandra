<?php
        session_start();
        function conectarBD() {
            $servidor = "localhost";
            $usuario = "root";
            $password = "";
            $bd = "tienda";
        
            $conn=mysqli_connect($servidor,$usuario,$password,$bd);
        
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
        
            return $conn;
        }

        if (isset($_SESSION['actualizacion_exitosa']) && $_SESSION['actualizacion_exitosa'] == true) {
            echo '<script>alert("Usuario actualizado correctamente.");</script>';
            unset($_SESSION['actualizacion_exitosa']); // Limpiar la variable de sesión
        }

        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleUser.css">
    <title>Informacion Usuarios</title>
</head>
<body>
<div>
        <?php 
            $con = conectarBD();
            // Verificar la conexión
            if ($con->connect_error)
            {
            die("Error en la conexión: " . $con->connect_error);
            }
            $nombre = isset($_SESSION['nick']) ? $_SESSION['nick'] : '';
            echo "<h1>User " . $nombre . "</h1>";
        ?>
    <a href="../Home.php">
      <button style="color: red; border: 2px solid red;">Home</button>
    </a>
</div>
<br>
<br>
    <table>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Precio Total</th>
            <th>Accion</th>
        </tr>

        <?php
        $con = conectarBD();
        // Verificar la conexión
        if ($con->connect_error) {
            die("Error en la conexión: " . $con->connect_error);
        }
        $producto = "";

        // Obtener el nick del usuario
        $nombre = isset($_SESSION['nick']) ? $_SESSION['nick'] : '';

        $consultaCarro = "SELECT * FROM carrito WHERE nick_cart = '$nombre'";       
        $resultadoCarro = $con->query($consultaCarro);

        while ($row = $resultadoCarro->fetch_assoc()) {
            $producto = $row['Producto'];
            $cantidad = $row['Cantidad'];

        $consultaProducto = "SELECT `Precio unitario` FROM productos WHERE Nombre = '$producto'";
        $resultadoProducto = $con->query($consultaProducto);    

        if ($rowPrecio = $resultadoProducto->fetch_assoc()) {
        $precioUnitario = $rowPrecio['Precio unitario'];
        
        $PrecioTotal = $cantidad * $precioUnitario;}

        $resultado = $con->query($consultaCarro);

        if ($resultado->num_rows > 0) {
            // echo $resultado;
            while ($fila = $resultado->fetch_assoc()) {
                echo "<form action='actions/actions.php' method='post'>";
                echo "<input type='hidden' name='id' value='" . $fila['id'] . "'>";

                echo "<tr>";
                echo "<td><input readonly name='Producto' value='" . $fila['Producto'] . "'></td>";
                echo "<td><input readonly name='precioUnitario' value='" . $precioUnitario . "'></td>";
                echo "<td><input readonly name='Cantidad' value='" . $fila['Cantidad'] . "'></td>";
                echo "<td><input readonly name='PrecioTotal' value='" . $PrecioTotal . " €'></td>";
                echo "<td><button formaction='actionsProducts.php' name='action' value='eliminarproducto'>Eliminar</button>
                <button formaction='actionsProducts.php' name='action' value='sumarCant'>Sumar Cantidad</button></td>";
                echo "</tr>";
                echo "</form>";
            }
            
    } else {
        echo "<tr><td colspan='4'>No hay productos</td></tr>";
    }
} if($consultaCarro == null) {
    echo "<tr><td colspan='4'>No hay productos</td></tr>";
}
?>
    </table>
    <script>src="/logout.js"</script>
</body>
</html>