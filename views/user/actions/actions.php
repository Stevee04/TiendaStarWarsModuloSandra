<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "tienda";

$con = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$con) {
    die("No se ha podido realizar la conexión_" . mysqli_connect_error() . "<br>");
} else {
    mysqli_set_charset($con, "utf8");
}

if (isset($_POST['action']) && $_POST['action'] == 'actualizarusuario') {
    // Obtener el ID del usuario
    $idUsuario = $_POST['id'];
    $emailUsuario = $_POST['email'];
    $contraUsuario = $_POST['contraseña'];

    // Llamar a la función actualizarUsuario con el ID del usuario
    actualizarUsuario($idUsuario, $emailUsuario, $contraUsuario, $con);
}

function actualizarUsuario($idUsuario, $emailUsuario, $contraUsuario, $con)
{
    $emailOriginal = $_POST['email_original'];
    $contraOriginal = $_POST['contraseña_original'];

    // Verificar si hay cambios en el email o contraseña
    if ($emailUsuario !== $emailOriginal || $contraUsuario !== $contraOriginal) {
        $sql = "UPDATE `usuarios` SET `email`='$emailUsuario', `contraseña`='$contraUsuario' WHERE `id`='$idUsuario'";
        $consulta = mysqli_query($con, $sql);

        if (!$consulta) {
            echo '<script>alert("No se ha podido actualizar el usuario. Revisa los campos.");</script>';
        } else {
            $_SESSION['actualizacion_exitosa'] = true; // Nueva línea
            header("Location: /Tienda/views/user/userInfo.php");
            exit();
        }
    } else {
        echo '<script>alert("No se realizaron cambios en el usuario.");</script>';
    }
}

?>
