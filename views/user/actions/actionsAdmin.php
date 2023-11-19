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
    $nickUsuario = $_POST['nick'];
    $emailUsuario = $_POST['email'];
    $contraUsuario = $_POST['contraseña'];

    // Llamar a la función actualizarUsuario con el ID del usuario
    actualizarUsuario($idUsuario, $nickUsuario, $emailUsuario, $contraUsuario, $con);
}else if (isset($_POST['action']) && $_POST['action'] == 'eliminarusuario') {
    // Obtener el ID del usuario
    $idUsuario = $_POST['id'];

    // Llamar a la función actualizarUsuario con el ID del usuario
    eliminarUsuario($idUsuario, $con);
}else if (isset($_POST['action']) && $_POST['action'] == 'añadirusuario') {
    // Obtener el ID del usuario
    $idUsuario = $_POST['id'];
    $nickUsuario = $_POST['nick'];
    $emailUsuario = $_POST['email'];
    $contraUsuario = $_POST['contraseña'];

    // Llamar a la función actualizarUsuario con el ID del usuario
    añadirUsuario($idUsuario, $nickUsuario, $email, $password, $con);
}

function actualizarUsuario($idUsuario, $nickUsuario, $emailUsuario, $contraUsuario, $con)
{
    $emailOriginal = $_POST['email_original'];
    $contraOriginal = $_POST['contraseña_original'];

    // Verificar si hay cambios en el email o contraseña
    if ($emailUsuario !== $emailOriginal || $contraUsuario !== $contraOriginal) {
        $sql = "UPDATE `usuarios` SET `nick`='$nickUsuario',`email`='$emailUsuario', `contraseña`='$contraUsuario' WHERE `id`='$idUsuario'";
        $consulta = mysqli_query($con, $sql);

        if (!$consulta) {
            echo '<script>alert("No se ha podido actualizar el usuario. Revisa los campos.");</script>';
        } else {
            $_SESSION['actualizacion_exitosa'] = true; // Nueva línea
            header("Location: /Tienda/views/user/userInfoAdmin.php");
            exit();
        }
    } else {
        echo '<script>alert("No se realizaron cambios en el usuario.");</script>';
    }
}

function eliminarUsuario($id, $con) {

    $sql = "DELETE FROM usuarios WHERE id=$id";

    $consulta = mysqli_query($con, $sql);

    if (!$consulta) {
        echo '<script>alert("No se ha podido eliminar el usuario.");</script>';
    } else {
        $_SESSION['actualizacion_exitosa'] = true; // Nueva línea
        header("Location: /Tienda/views/user/userInfoAdmin.php");
        exit();
    }
}

function añadirUsuario($id, $nick, $email, $password, $con) {

    $sql = "INSERT INTO usuarios (id, nick, email, contraseña) VALUES (null, '$nick', '$email', '$password') where $id";
    $consulta = mysqli_query($con, $sql);

    if (!$consulta) {
        echo '<script>alert("No se ha podido actualizar el usuario. Revisa los campos.");</script>';
    } else {
        $_SESSION['actualizacion_exitosa'] = true; // Nueva línea
        header("Location: /Tienda/views/user/userInfoAdmin.php");
        exit();
    }
}
?>
