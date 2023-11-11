// Event listeners para los botones
document.getElementById('cartBtn').addEventListener('click', () => {
  // Redirige al carrito de compras (debes implementar esta página)
  window.location.href = 'carrito.html';
});

// Asegúrate de incluir el siguiente código para mostrar el nombre del usuario al lado del botón después de iniciar sesión
function mostrarNombreUsuario(nombre) {
  var userContainer = document.getElementsByClassName('userContainer');
  userContainer.innerHTML = '<span id="userName">' + nombre + '</span>';
  userContainer.addEventListener('click', function() {
    window.location.href = 'userInfo.php';
  });
}

