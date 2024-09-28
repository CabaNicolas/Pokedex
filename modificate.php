<?php

require_once __DIR__ . '/src/Pokemon.php';
session_start();
$idEvoluciones = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $poke = new Pokemon();
    $pokemon = $poke->buscarPokemonPorId($id);
    $pokemons = $poke->getPokemons();

    if (!$pokemon) {
        echo "No se encontró el Pokémon.";
        exit();
    }
    $tipos = $pokemon->tipos();
    $tiposDelPokemon = $pokemon->getTipo();
    $evoluciones = $pokemon->buscarEvoluciones($pokemon->getId());

    if(!$evoluciones && count($evoluciones) > 0){
        foreach ($evoluciones as $evolucion){
            $evoluciones[] = $evolucion->getId();
        }
    }

    if (!$evoluciones) {
        $evoluciones = [];
    }

    if (!is_array($tiposDelPokemon)) {
        $tiposDelPokemon = explode(',', $tiposDelPokemon);
    }


    if (!$tiposDelPokemon) {
        $tiposDelPokemon = [];
    }

    $idEvoluciones = array_map(function($evolucion) {
        return $evolucion->getId();
    }, $evoluciones);

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
    <link rel="icon" href="Imagenes/iconoPestania.webp">
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
                <?php foreach ($tipos as $tipo):
                    $nombreTipo = pathinfo($tipo['nombre'], PATHINFO_FILENAME);?>
                <option value="<?= $tipo['nombre'] ?>" <?= in_array($tipo['nombre'], $tiposDelPokemon) ? 'selected' : '' ?>><?= $nombreTipo ?></option>
                <?php endforeach; ?>
            </select>
            <?php
                if(isset($_SESSION['error-tipo-modify'])):
                    echo '<p style="color:red;margin-top:0">' . $_SESSION['error-tipo-modify'] . '</p>';
                    unset($_SESSION['error-tipo-modify']);
                endif;
            ?>
            <label for="evoluciones">Evoluciones:</label>
            <select name="evoluciones[]" id="evoluciones" multiple>
                <?php foreach ($pokemons as $poke):?>
                    <option value="<?= $poke->getId() ?>" <?= in_array($poke->getId(), $idEvoluciones) ? 'selected' : '' ?>><?= $poke->getNombre() ?></option>
                <?php endforeach; ?>
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
