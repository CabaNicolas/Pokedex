<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex-Admin</title>
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="icon" href="Imagenes/iconoPestania.webp">
</head>
<body>
<header>
    <div class="logo">
        <img src="Imagenes/logo.webp" alt="Imagen Pokeball">
    </div>
    <h1>Pokedex</h1>

    <h3>Usuario ADMIN</h3>
    <form class="logout" action="index.php" method="post">
        <button type="submit">Cerrar Sesion</button>
    </form>
</header>
<main>
    <div class="buscador">
        <form action="admin.php" method="get">
            <input type="text" name="buscado" placeholder="Ingrese el nombre, tipo o número del pokemon">
            <button type="submit">¿Quién es este pokemon?</button>
        </form>
    </div>

    <?php
    require_once __DIR__ . '/src/Pokemon.php';

    // Se obtiene el parámetro de búsqueda si existe
    $buscado = isset($_GET['buscado']) ? $_GET['buscado'] : null;
    $pokemons = [];
    $pokemonObj = new Pokemon();

    if ($buscado) {
        // Se busca el pokemon por nombre, tipo o número
        $pokemons = $pokemonObj->buscarPokemon($buscado);

        // Si no se encuentra ningún pokemon, se muestra la respuesta negativa y la lista completa
        if (empty($pokemons)) {
            echo "<p class='respuesta_negativa'>Pokemon no encontrado</p>";
            $pokemons = $pokemonObj->getPokemons();
        }
    } else {
        // Si no se busca nada, se muestran todos los pokemons
        $pokemons = $pokemonObj->getPokemons();
    }
    ?>

    <!-- Lista de pokemons en formato tabla -->
    <div class="pokemon-table-container">
        <table class="pokemon-table">
            <thead>
            <tr>
                <th>Imagen</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pokemons as $pokemon) { ?>
                <tr>
                    <td><img src="<?= $pokemon->getImagen() ?>" alt="<?= $pokemon->getNombre() ?>"></td>
                    <td><?= $pokemon->getTipo() ?></td>
                    <td><?= $pokemon->getNumero() ?></td>
                    <td><?= $pokemon->getNombre() ?></td>
                    <td><button class="modif">Modificacion</button> <button class="baja">Baja</button></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Agregar nuevo Pokemon -->
    <form class="nuevo-pokemon" action="" method="post">
        <button type="submit">Nuevo Pokemon</button>
    </form>
</main>
<?php
include_once __DIR__ . '/footer.php';
?>
</body>
</html>
