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
        ?>
        <?php 
            $con = conectarBD();
            // Verificar la conexión
            if ($con->connect_error)
            {
            die("Error en la conexión: " . $con->connect_error);
            }
            $nombre = isset($_SESSION['nick']) ? $_SESSION['nick'] : '';
            echo "<h1>Admin " . $nombre . "</h1>";
        ?>
    <a href="../Home.php">
      <button style="color: red; border: 2px solid red;">Home</button>
    </a>
    <a href="logout.html">
      <button style="color: red; border: 2px solid red;">Log out</button>
    </a>
</div>
<br>
<br>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Admin</th>
            <th>Acciones</th>
        </tr>

        <?php
        $con = conectarBD();
        // Verificar la conexión
        if ($con->connect_error) {
            die("Error en la conexión: " . $con->connect_error);
        }

        $consulta = "SELECT * FROM usuarios";

        $resultado = $con->query($consulta);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<form action='actions/actions.php' method='post'>";
                echo "<input type='hidden' name='id' value='" . $fila['id'] . "'>";
                echo "<input type='hidden' name='email_original' value='" . $fila['email'] . "'>";
                echo "<input type='hidden' name='contraseña_original' value='" . $fila['contraseña'] . "'>";
            
                echo "<tr>";
                echo "<td><input type='text' name='nick' value='" . $fila['nick'] . "'></td>";
                echo "<td contenteditable='true' id='editEmail'>" . $fila['email'] . "</td>";
                echo "<td contenteditable='true' id='editPassword'>" . $fila['contraseña'] . "</td>";
                echo "<td contenteditable='true' id='admin'>
                    <button formaction='actions/actionsAdmin.php'>SI</button> <button formaction='actions/actionsAdmin.php'>NO</button>
                    </td>";
                echo "<td>
                    <button formaction='actions/actionsAdmin.php' name='action' value='actualizarusuario'>Modificar</button>
                    <button formaction='actions/actionsAdmin.php' name='action' value='eliminarusuario'>Eliminar</button>
                    </td>";
                echo "</tr>";
                echo "</form>";
            }
            echo "<form action='actions/actions.php' method='post'>";
            echo "<tr>";
            echo "<td contenteditable='true' id='nick'></td>";
            echo "<td contenteditable='true' id='email'></td>";
            echo "<td contenteditable='true' id='contraseña'></td>";
            echo "<td contenteditable='true' id='admin'>
                <button formaction='actions/actionsAdmin.php'>SI</button><button onclick='añadirUsuario()'>NO</button>
                </td>";
            echo "<td><button formaction='actions/actionsAdmin.php' name='action' value='añadirusuario'>Añadir</button></td>";
            echo "</tr>";
            echo "</form>";
            

} else {
    echo "<tr><td colspan='4'>Error al obtener el valor del campo 'admin'</td></tr>";
}
?>

    </table>
    <br>
    <br>
    <table>
    <tr>
            <th>Nombre</th>
            <th>Descripcion</th>
        </tr>

        <?php

        $con = conectarBD();
        // Verificar la conexión
        if ($con->connect_error) {
            die("Error en la conexión: " . $con->connect_error);
        }

        // Mostrar todos los usuarios si el campo 'admin' es 1
        $consulta = "SELECT * FROM categorias";
 
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td contenteditable='true'>" . $fila['Nombre'] . "</td>";
            echo "<td contenteditable='true'>" . $fila['Descripcion'] . "</td>";
            echo "<td>
                <button formaction='actions/actionsAdmin.php'>Modificar</button>
                <button formaction='actions/actionsAdmin.php'>Eliminar</button>
                </td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<td contenteditable='true' id='Nombre'></td>";
        echo "<td contenteditable='true' id='Descripcion'></td>";
        echo "<td><button onclick='añadirUsuario()'>Añadir</button></td>";
        echo "</tr>";
        
} else {
    echo "<tr><td colspan='4'>Error al obtener el valor del campo 'admin'</td></tr>";
}
?>
    </table>
    <br>
    <br>
    <table>
    <tr>
            <th>Nombre</th>
            <th>Stock</th>
            <th>Precio Unitario</th>
            <th>Categoria</th>
        </tr>

        <?php

        $con = conectarBD();
        // Verificar la conexión
        if ($con->connect_error) {
            die("Error en la conexión: " . $con->connect_error);
        }

        // Mostrar todos los usuarios si el campo 'admin' es 1
        $consulta = "SELECT * FROM productos";
 
    $resultado = $con->query($consulta);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td contenteditable='true'>" . $fila['Nombre'] . "</td>";
            echo "<td contenteditable='true'>" . $fila['Stock'] . "</td>";
            echo "<td contenteditable='true'>" . $fila['Precio unitario'] . " €</td>";
            echo "<td contenteditable='true'>" . $fila['Categoria'] . "</td>";
            echo "<td>
                <button formaction='actions/actionsAdmin.php'>Modificar</button>
                <button formaction='actions/actionsAdmin.php'>Eliminar</button>
                </td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<td contenteditable='true' id='Nombre'></td>";
        echo "<td contenteditable='true' id='Stock'></td>";
        echo "<td contenteditable='true' id='Precio unitario'></td>";
        echo "<td contenteditable='true' id='Categoria'></td>";
        echo "<td><button formaction='actions/actionsAdmin.php'>Añadir</button></td>";
        echo "</tr>";
        
} else {
    echo "<tr><td colspan='4'>Error al obtener el valor del campo 'admin'</td></tr>";
}
?>
    </table>
    <br>
    <br>
    <script>src="/logout.js"</script>
</body>
</html>