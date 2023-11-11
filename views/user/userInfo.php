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

        if (isset($_SESSION['actualizacion_exitosa']) && $_SESSION['actualizacion_exitosa'] == true) {
            echo '<script>alert("Usuario actualizado correctamente.");</script>';
            unset($_SESSION['actualizacion_exitosa']); // Limpiar la variable de sesión
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
            echo "<h1>User " . $nombre . "</h1>";
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
            <th>Acciones</th>
        </tr>

        <?php
        $con = conectarBD();
        // Verificar la conexión
        if ($con->connect_error) {
            die("Error en la conexión: " . $con->connect_error);
        }

        // Obtener el nick del usuario
        $nombre = isset($_SESSION['nick']) ? $_SESSION['nick'] : '';

        $consulta = "SELECT * FROM usuarios WHERE nick = '$nombre'";

        $resultado = $con->query($consulta);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<form action='actions/actions.php' method='post'>";
                echo "<input type='hidden' name='action' value='actualizarusuario'>";
                echo "<input type='hidden' name='id' value='" . $fila['id'] . "'>";
                echo "<input type='hidden' name='email_original' value='" . $fila['email'] . "'>";
                echo "<input type='hidden' name='contraseña_original' value='" . $fila['contraseña'] . "'>";
            
                echo "<tr>";
                echo "<td><input type='text' name='nick' value='" . $fila['nick'] . "'></td>";
                echo "<td><input type='email' name='email' value='" . $fila['email'] . "'></td>";
                echo "<td><input type='password' name='contraseña' value='" . $fila['contraseña'] . "'></td>";
                echo "<td><input type='submit' value='Actualizar Información'></td>";
                echo "</tr>";
                echo "</form>";
            }
            
    } else {
        echo "<tr><td colspan='4'>Error al obtener el valor del campo 'admin'</td></tr>";
    }

?>
    </table>
    <script>src="/logout.js"</script>
</body>
</html>