<?php
require_once __DIR__ . '/src/db.php';
$email = $_POST['email'];
$password = $_POST['password'];

if($email!="" && $password!=""){
    //Conectarse a la base de datos usando la conexión desde DB::getConexion (esta en otro archivo)
    $db = DB::getConexion();

    //Verificar si el email ya existe en la base de datos
    $consulta = $db->prepare("SELECT * FROM usuario WHERE email = ?");
    $consulta->execute([$email]);
    $usuarioExistente = $consulta->fetch();

    if ($usuarioExistente) {
        //Si el usuario ya existe, mostrar un mensaje
        header("Location: registro.php?status=error&message=El correo ya está registrado");
        exit();

    } else{

        //Insertar los datos en la base de datos
        $insertar = $db->prepare("INSERT INTO usuario (email, password) VALUES (?, ?)");
        if ($insertar->execute([$email, $password])) {
            //Si la inserción es exitosa, mostrar un mensaje de éxito
            header("Location: index.php");
            exit();
        } else{
            //Si algo falla en la inserción
            header("Location: registro.php?status=error&message=Error al crear la cuenta");
            exit();
        }
    }
}
?>
