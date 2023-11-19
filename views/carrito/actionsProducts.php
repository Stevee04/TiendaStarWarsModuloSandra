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

echo "Hola e entrado aqui";
echo "<br>";
echo $_POST['action'];

if (isset($_POST['action']) && $_POST['action'] == 'eliminarproducto') {
    // Obtener el ID del usuario
    $idProducto = $_POST['id'];

    // Llamar a la función actualizarUsuario con el ID del usuario
    eliminarProducto($idProducto, $con);

}else if (isset($_POST['action']) && $_POST['action'] == 'añadirproducto') {
    // Obtener el ID del usuario
    $idProducto = $_POST['id'];
    $Product_Name = $_POST['Producto'];
    $Quantity = $_POST['Cantidad'];
    $TotalPrice = $_POST['Total'];
    $Nick_Cart= $_POST['nick_cart'];
    // Llamar a la función actualizarUsuario con el ID del usuario
    $consultaProducto = "SELECT Producto FROM carrito WHERE nick_cart = '$Nick_Cart'";
    $Productos = $con->query($consultaProducto);    

    if ($NombresProducto = $Productos->fetch_assoc()) {
        $ProdcutName = $NombresProducto['Producto'];
    }
    if ($ProdcutName != $Product_Name){
    añadirProducto($idProducto, $Product_Name, $Quantity, $TotalPrice, $Nick_Cart, $con);
    }else{
        echo '"Ya tienes este producto en la cest, si quieres comprar mas de uno puedes añadirlo en la cesta"';
        header("Location: ../Home.php");
        exit();
    }

}else if (isset($_POST['action']) && $_POST['action'] == 'sumarCant') {
    // Obtener el ID del usuario
    $idProducto = $_POST['id'];
    $cantidad = $_POST['Cantidad'];
    $Product_Name = $_POST['Producto'];
    // Llamar a la función actualizarUsuario con el ID del usuario
    SumarCant($idProducto, $cantidad, $Product_Name, $con);
}

function eliminarProducto($id, $con) {

    $sql = "DELETE FROM carrito WHERE id=$id";
    $consulta = mysqli_query($con, $sql);

    if (!$consulta) {
        echo '<script>alert("No se ha podido eliminar el producto.");</script>';
    } else {
        header("Location: /Tienda/views/carrito/carrito.php");
        exit();
    }
}

function añadirProducto($id, $nick, $quantity, $totalPrice, $nick_Cart, $con) {

    $consultaProducto = "SELECT `Precio unitario`,`Stock` FROM productos WHERE Nombre = '$nick'";
        $resultadoProducto = $con->query($consultaProducto);   

        if ($rowPrecio = $resultadoProducto->fetch_assoc()) {
        $precioUnitario = $rowPrecio['Precio unitario'];
        $StockDisponible = $rowPrecio['Stock'];
        $totalPrice = $quantity * $precioUnitario;
    }

    if( $StockDisponible > 0){
    $sql = "INSERT INTO `carrito` (id, Producto, Cantidad, `Precio total`, nick_cart) VALUES (null, '$nick', '$quantity', '$totalPrice', '$nick_Cart')";
    $consulta = mysqli_query($con, $sql);

    if (!$consulta) {
        echo '<script>alert("No se ha podido añadir el producto.");</script>';
    } else {
        $sql = "UPDATE `productos` SET `Stock`=`Stock`-1 WHERE `Nombre`='$nick'";
        $consulta = mysqli_query($con, $sql);
        header("Location: ../Home.php");
        exit();
    }
    }else{
        echo '<script>alert("No hay stock disponible.");</script>';
        header("Location: ../Home.php");
        exit();
    }
}

function SumarCant($id, $cantidad, $nick, $con) {

    $sql = "UPDATE `carrito` SET `Cantidad`=$cantidad+1 WHERE `id`='$id'";
    $consulta = mysqli_query($con, $sql);

    if (!$consulta) {
        echo '<script>alert("No se ha podido actualizar el producto. Revisa los campos.");</script>';
    } else {
        $sql = "UPDATE `productos` SET `Stock`=`Stock`-1 WHERE `Nombre`='$nick'";
        $consulta = mysqli_query($con, $sql);
        header("Location: /Tienda/views/carrito/carrito.php");
        exit();
    }
}

?>
