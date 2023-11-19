<?php
session_start();
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "tienda";

$conn = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Manejo de la ordenación
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$orderClause = "ORDER BY `Precio unitario` $order";

// Consulta SQL para obtener productos con orden especificado
$sql = "SELECT id, Nombre, `Precio unitario`, Stock, Imagen FROM productos $orderClause";
$result = $conn->query($sql);

// Filtrar productos en stock
$stockFilter = isset($_GET['stock']) ? $_GET['stock'] : '';
if ($stockFilter == 'en_stock') {
    $sql = "SELECT id, Nombre, `Precio unitario`, Stock, Imagen FROM productos WHERE Stock > 0 $orderClause";
    $result = $conn->query($sql);
}
    
// Mostrar productos
if ($result->num_rows > 0) {
    // Resto del código para mostrar productos
} else {
    echo 'No se encontraron productos.';
}

// Cierre de la conexión
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.style.css">
  <title>Tienda de Star Wars</title>
</head>
<body>
  <header>
    <nav>
      <div class="order-buttons" style="display: flex;">
        <form method="get" action="">
          <button class="button-effect" name="order" value="ASC">Ordenar de menor a mayor precio</button>
          <button class="button-effect" name="order" value="DESC">Ordenar de mayor a menor precio</button>
        </form>
        <form method="get" action="">
          <button class="button-effect" name="stock" value="en_stock">En Stock</button>
        </form>
        <form method="get" action="carrito/carrito.php">
          <button id="cartBtn" class="image-container-cart" type="submit"></button>
        </form>
        <form method="get" action="user/selectUserType.php">
          <button class="image-container-register" type="submit"></button>
        </form>
      </div>
    </nav>
  </header>

  <div class="products-container">
  <?php
  // Mostrar productos
  if ($result->num_rows > 0) {
    $nombre = isset($_SESSION['nick']) ? $_SESSION['nick'] : '';
    echo '<main>';
    echo '<h1>Bienvenido a la Tienda de Star Wars</h1>';
    echo '<section class="productos">';
    while ($row = $result->fetch_assoc()) {
      echo '<div class="producto">';
      echo '<div class="product-info">';
      echo '<img src="' . $row['Imagen'] . '", alt="' . $row['Nombre'] . '">';
      echo '<h2>' . $row['Nombre'] . '</h2>';
      echo '<h3>Precio: ' . $row['Precio unitario'] . '</h3>';
      echo '<h3>Stock: ' . $row['Stock'] . '</h3>';
      echo "$nombre";
      echo '</div>';
      echo '<div class="product-buttons">';
      // Agregar un formulario para enviar la información del producto al archivo actionscarrito.php
      echo '<form action="carrito/actionsProducts.php" method="post">';
      echo '<input type="hidden" name="action" value="añadirproducto">';
      echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
      echo '<input type="hidden" name="Producto" value="' . $row['Nombre'] . '">';
      echo '<input type="hidden" name="Cantidad" value="1">';
      echo '<input type="hidden" name="Total" value="' . $row['Precio unitario'] . '">';
      echo '<input type="hidden" name="nick_cart" value="' . $nombre . '">';
      echo '<button type="submit" class="button-effect">Agregar al Carrito</button>';
      echo '</form>';
      echo '<button class="viewProductBtn">Ver Producto</button>';
      echo '</div>';
      echo '</div>';
    }
    echo '</section>';
    echo '</main>';
  } else {
    echo 'No se encontraron productos.';
  }
  ?>
</div>


  <script src="home.script.js"></script>
</body>
</html>
