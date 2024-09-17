<?php
// Iniciar sesión
session_start();

// Usuario y contrasenia correctos para loguearse
$usuario_correcto = 'admin';
$contrasena_correcta = '123456';

// Obtener los datos del formulario
$usuario = $_POST['username'];
$contrasena = $_POST['password'];

// Validar usuario y contraseña
if ($usuario === $usuario_correcto && $contrasena === $contrasena_correcta) {
    // Si es correcto, guardar el usuario en la sesión
    $_SESSION['usuario'] = $usuario;
    header("Location: index.php"); // Redirigir a la página de administración
    exit();
} else {
    // Si no es correcto, redirigir a index.php con un mensaje de error
    header("Location: index.php?error=1");
    exit();
}
?>
