<?php
session_start();
if (empty($_GET['nick']) || empty($_GET['contraseña'])
) {
    // Si algún campo está vacío, redirige a la página anterior
    header("Location: /Tienda/views/user/userRegister.html");
}

$Nombre = $_GET['nick'];
$Contraseña = $_GET['contraseña'];

//$_SESSION["nick_logueado"]=$color;
$servidor="localhost";
$usuario="root";
$password="";
$bd="tienda";

$con=mysqli_connect($servidor,$usuario,$password,$bd);

if (!$con) {
    die("No se ha podido realizar la conexión_" . mysqli_connect_error() . "<br>");
} else {
    mysqli_set_charset($con, "utf8");

    // Verificar si el usuario ya existe
    $verificarUsuario = "SELECT * FROM usuarios WHERE nick='$Nombre' AND contraseña='$Contraseña'";
    $resultado = mysqli_query($con, $verificarUsuario);

    if (mysqli_num_rows($resultado) > 0) {
        
        // Almacena el valor en la variable de sesión
        $_SESSION['nick'] = $Nombre;
        if ($Nombre != ""){
        header("Location: /Tienda/views/Home.php");
        exit();
        }else{

        }
    } else {
        echo "No existe ese usuario revisa el nombre y la contraseña o registrate";
        $_SESSION["login_status"] = false; // Guarda el estado de inicio de sesión en una variable de sesión
    }
}

$response = array('login_status' => isset($_SESSION["login_status"]) ? $_SESSION["login_status"] : false);

// Devuelve la respuesta en formato JSON
echo json_encode($response);

?>