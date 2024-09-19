<?php
require_once __DIR__ . '/src/Pokemon.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $tipos = $_POST['tipos'];
    $descripcion = $_POST['descripcion'];

    if(count($tipos)  > 2) {
        echo "Solo se permiten hasta 2 tipos";
        exit();
    }

    $imagen = $_FILES['imagen']['name'];
    $tempPath = $_FILES['imagen']['tmp_name'];
    $uploadDir = 'Imagenes/';
    $uploadFile = $uploadDir . basename($imagen);

    if (move_uploaded_file($tempPath, $uploadFile)) {
        $pokemon = new Pokemon();
        $pokemon->createPokemon($nombre, $numero, $tipos, $uploadFile, $descripcion);

        header("Location: index.php");
        exit();
    } else {
        echo "No se pudo subir la imagen";
    }
}