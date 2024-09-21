<?php
// Iniciar sesión
session_start();
//Traemos la clase db que contiene la conexion a la BD
require_once __DIR__ . '/src/db.php';

// Obtener los datos del formulario
$usuario = $_POST['username'];
$contrasena = $_POST['password'];


if($usuario!="" && $contrasena!=""){
    //Conectarse a la base de datos usando la conexión desde DB::getConexion (esta en otro archivo)
    $db = DB::getConexion();

    //Verificar si el email/usuario ya existe en la base de datos
    $consulta = $db->prepare("SELECT * FROM usuario WHERE email = ?");
    $consulta->execute([$usuario]);
    $usuarioExistente = $consulta->fetch();

    if ($usuarioExistente) {
        // El usuario/email existe, ahora validar la contraseña
        $passwordAlmacenada = $usuarioExistente['password']; // La columna es 'password'

        if ($contrasena === $passwordAlmacenada) {
            // Si la contraseña es correcta, iniciar sesión y redirigir
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit();
        } else {
            // Si la contraseña es incorrecta, redirigir con un error
            header("Location: index.php?error=2"); // Error: contraseña incorrecta
            exit();
        }
    } else {
        // Si el usuario no existe, redirigir con un error: usuario inexistente
        header("Location: index.php?error=1");
        exit();
    }
}
?>
