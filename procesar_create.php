<?php
require_once __DIR__ . '/src/Pokemon.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $tipos = $_POST['tipos'];
    //$evoluciones = $_POST['evoluciones'];
    $descripcion = $_POST['descripcion'];
    $pokemon = new Pokemon();

    if(count($tipos)  > 2) {
        echo "Solo se permiten hasta 2 tipos";
        exit();
    }

    $imagen = $_FILES['imagen']['name'];
    $tempPath = $_FILES['imagen']['tmp_name'];
    $uploadDir = 'Imagenes/';
    $uploadFile = $uploadDir . basename($imagen);
    $respuesta = move_uploaded_file($tempPath, $uploadFile);
    $uploadFile = $respuesta ? $uploadFile : null;

    $validTypes = $pokemon->verificarSiExisteTipos($tipos);

    if ($validTypes) {
        $pokemonId = $pokemon->insertarPokemon($nombre, $numero, $uploadFile, $descripcion);
        $pokemon->insertarTipoPokemon($pokemonId, $validTypes);

        header("Location: index.php");
        exit();
    }else{
        echo "Uno de los tipos no existe";
    }
}