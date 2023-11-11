<?php
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
// Verificar si se ha enviado el parámetro 'order' a través de la URL

// Consulta SQL para obtener productos con orden especificado
$sql = "SELECT id, Nombre, `Precio unitario` FROM productos $orderClause";
$result = $conn->query($sql);

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
  <link rel="stylesheet" href="./views/home.style.css">
  <title>Tienda de Star Wars</title>
</head>
<body>
  <header>
    <nav>
      <div class="order-buttons" style="display: flex;">
        <form method="get" action="" >
            <button class="button-effect" name="order" value="ASC">Ordenar de menor a mayor precio</button>
            <button class="button-effect" name="order" value="DESC">Ordenar de mayor a menor precio</button>
        </form>
        <form method="get" action="carrito/carrito.php">
            <button id="cartBtn" class="userContainer" type="submit">Carrito de Compras</button>
        </form>
            <button id="registerBtn" class="image-container userContainer"></button>
      </div> 
    </nav>
  </header>

  <div class="products-container">
        <?php
        // Mostrar productos
        if ($result->num_rows > 0) {
          echo '<main>';
          echo '<h1>Bienvenido a la Tienda de Star Wars</h1>';
          echo '<section class="productos">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="producto">';
                echo '<div class="product-info">';
                echo '<img src="./views/imgTienda/pancake.jpg" alt="' . $row['Nombre'] . '">';
                echo '<h2>' . $row['Nombre'] . '</h2>';
                echo '<h3>Precio: ' . $row['Precio unitario'] . '</h3>';
                echo '</div>';
                echo '<div class="product-buttons">';
                echo '<button class="addToCartBtn" style="justify-content: center;">Agregar al Carrito</button>';
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

  <script src="index.script.js"></script>
</body>
</html>
