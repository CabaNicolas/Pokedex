<?php
require_once __DIR__ . '/src/Pokemon.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $tiposNombres = isset($_POST['tipos']) ? $_POST['tipos'] : [];
    $evoluciones = isset($_POST['evoluciones']) ? $_POST['evoluciones'] : [];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];
    $pokemon = new Pokemon();

    $uploadFile = null;
    if (!empty($imagen)){
        $tempPath = $_FILES['imagen']['tmp_name'];
        $uploadDir = 'Imagenes/';
        $uploadFile = $uploadDir . basename($imagen);
        move_uploaded_file($tempPath, $uploadFile);
    }

    $tiposIds = $pokemon->verificarSiExisteTipos($tiposNombres);

    $evolucionesIds = $pokemon->verificarSiExistePokemons($evoluciones);

    if (empty($tiposIds)) {
        echo "Error: No se seleccionaron tipos válidos.";
        exit();
    }

    $pokemon->modificatePokemon($id, $nombre, $numero, $tiposIds, $evolucionesIds, $descripcion, $uploadFile);

    header('Location: index.php');
    exit();

}
