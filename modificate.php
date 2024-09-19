<?php

require_once __DIR__ . '/src/Pokemon.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $poke = new Pokemon();
    $pokemon = $poke->getPokemonById($id);

    if (!$pokemon) {
        echo "No se encontró el Pokémon.";
        exit();
    }

    $tipos = $pokemon->getTipo();


    if (!is_array($tipos)) {
        $tipos = explode(',', $tipos);
    }


    if (!$tipos) {
        $tipos = [];
    }
} else {
    echo "ID del Pokémon no proporcionado.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar un Pokémon</title>
    <link rel="stylesheet" href="Styles/accionStyle.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php"><img src="Imagenes/logo.webp" alt="Imagen Pokeball"></a>
    </div>
    <h1>Pokedex</h1>
</header>

<main>
    <div class="contenedor">
        <h2>Modificar el pokémon: <?= $pokemon->getNombre(); ?> </h2>
        <form action="procesar_modificate.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $pokemon->getId() ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre del Pokémon" value="<?= $pokemon->getNombre() ?>">
            <label for="numero">Número:</label>
            <input type="number" name="numero" placeholder="Número del Pokémon" value="<?= $pokemon->getNumero() ?>">

            <label for="tipo">Selecciona el/los tipo/s:</label>
            <select name="tipos[]" id="tipo" multiple>
                <option value="Fuego" <?= in_array('Fuego', $tipos) ? 'selected' : '' ?>>Fuego</option>
                <option value="Agua" <?= in_array('Agua', $tipos) ? 'selected' : '' ?>>Agua</option>
                <option value="Hierba" <?= in_array('Hierba', $tipos) ? 'selected' : '' ?>>Hierba</option>
            </select>


            <label for="descripcion">Descripcion:</label>
            <textarea name="descripcion" placeholder="Descripcion" rows="4"><?= $pokemon->getDescripcion() ?></textarea>

            <label for="imagen">Suba la imagen del pokémon:</label>
            <input type="file" name="imagen" accept="image/*">

            <button type="submit">Modificar</button>
        </form>

        <a class="volver" href="index.php">Volver a la lista de Pokemones</a>
    </div>
</main>
</body>
</html>
