<?php
require_once __DIR__ . '/src/Pokemon.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $tiposNombres = isset($_POST['tipos']) ? $_POST['tipos'] : [];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];

    // Manejar la subida de la imagen
    $uploadFile = null;
    if (!empty($imagen)){
        $tempPath = $_FILES['imagen']['tmp_name'];
        $uploadDir = 'Imagenes/';
        $uploadFile = $uploadDir . basename($imagen);
        move_uploaded_file($tempPath, $uploadFile);
    }

    // Convertir nombres de tipos en IDs
    $db = DB::getConexion();
    $tiposIds = [];
    foreach ($tiposNombres as $nombreTipo) {
        echo "Buscando ID para tipo: $nombreTipo<br>"; // Imprime el nombre del tipo para depuración
        $query = "SELECT id FROM tipo WHERE nombre = :nombre";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':nombre', $nombreTipo);
        $stmt->execute();
        $tipoId = $stmt->fetchColumn();

        echo "ID encontrado: $tipoId<br>"; // Imprime el ID encontrado para depuración

        if ($tipoId) {
            $tiposIds[] = $tipoId; // Agrega el ID del tipo si se encuentra
        }
    }

    // Si no se encontró ningún tipo válido, muestra un error
    if (empty($tiposIds)) {
        echo "Error: No se seleccionaron tipos válidos.";
        exit();
    }

    // Modificar el Pokémon
    $poke = new Pokemon();
    $pokemonModif = $poke->modificatePokemon($id, $nombre, $numero, $tiposIds, $descripcion, $uploadFile);

    if ($pokemonModif) {
        echo "Se modificó correctamente";
        header('Location: /pokedex/index.php');
        exit();
    } else {
        echo "No se pudo modificar";
    }
}
