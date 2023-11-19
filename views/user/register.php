<?php
if (
    empty($_GET['nick']) ||
    empty($_GET['email']) ||
    empty($_GET['contraseña']) ||
    empty($_GET['contraseña2'])
) {
    // Si algún campo está vacío, redirige a la página anterior
    header("Location: /Tienda/views/user/userRegister.html");
    exit();
}
$Nombre = $_GET['nick'];
$Email = $_GET['email'];
$Contraseña = $_GET['contraseña'];
$Contraseña2 = $_GET['contraseña2'];
$Admin = 0;

//$_SESSION["nick_logueado"]=$color;
$servidor="localhost";
$usuario="root";
$password="";
$bd="tienda";

$con=mysqli_connect($servidor,$usuario,$password,$bd);

if(!$con){
    die("No se ha podido realizar la conexión_".mysqli_connect_error()."<br>");
}else{
    mysqli_set_charset($con,"utf8");

    if ($Contraseña != $Contraseña2)
    {
        header("Location: /Tienda/views/user/userRegister.html?registro_fallido=true");
    exit();
    }else
    {
        // Verificar si el usuario ya existe
        $verificarUsuario = "SELECT * FROM usuarios WHERE nick='$Nombre'";
        $resultado = mysqli_query($con, $verificarUsuario);

        if (mysqli_num_rows($resultado) > 0 && $vacio != true) {
            // El usuario ya existe
            echo '<script>alert("El usuario ya existe.");</script>';
        } else {
            // El usuario no existe, realizar la inserción
            $sql = "INSERT INTO `usuarios`(`id`, `nick`, `email`, `contraseña`, `admin`) 
                    VALUES (NULL,'$Nombre','$Email','$Contraseña','$Admin')";

            $consulta = mysqli_query($con, $sql);

            if (!$consulta) {
                echo '<script>alert("No se a podido crear el usuario revisa los campos");</script>';
            }else{
                header("Location: /Tienda/views/user/userRegister.html");
                exit();
            }
        }
    }
}
?>