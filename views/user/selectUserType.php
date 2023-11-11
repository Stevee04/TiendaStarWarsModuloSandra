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

        $con = conectarBD();
        // Verificar la conexión
        if ($con->connect_error) {
            die("Error en la conexión: " . $con->connect_error);
        }

        // Obtener el nick del usuario
        $nombre = isset($_SESSION['nick']) ? $_SESSION['nick'] : '';

        // Obtener el valor del campo 'admin' para el usuario actual
$consulta_admin = "SELECT admin FROM usuarios WHERE nick = '$nombre'";
$resultado_admin = $con->query($consulta_admin);

if ($resultado_admin->num_rows > 0) {
    $fila_admin = $resultado_admin->fetch_assoc();
    $admin = $fila_admin['admin'];

    // Consulta SQL para obtener la información del usuario
    if ($admin == 1) {
      header("Location: /Tienda/views/user/userInfoAdmin.php");
    } else {
      header("Location: /Tienda/views/user/userInfo.php");
    }
    }
      ?>