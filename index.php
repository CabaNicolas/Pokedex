<?php
require_once __DIR__ . '/src/Pokemon.php';
require_once __DIR__ . '/Config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="icon" href="Imagenes/iconoPestania.webp">
</head>
<body>
<header>
    <div class="logo">
        <img src="Imagenes/logo.webp" alt="Imagen Pokeball">
    </div>
    <h1>Pokedex</h1>
    <?php if(!isset($_SESSION['usuario'])):?>
    <form class="login-form" action="login.php" method="post">
        <input type="text" name="username" placeholder="Email" class="input-login" required>
        <input type="password" name="password" placeholder="Contraseña" class="input-pass" required>
        <button type="submit" style="margin-right: 10px;">Ingresar</button>
    </form>
        <a href="registro.php" class="crear-cuenta">Crear cuenta</a>
    <?php else:?>
    <h3>Usuario ADMIN</h3>


        <form class="nuevo-pokemon" action="create.php" method="get">
            <button type="submit">Agregar Pokémon</button>
        </form>


    <form class="logout" action="logout.php" method="post">
        <button type="submit">Cerrar Sesion</button>
    </form>
    <?php endif;

    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<p style='color:red;' class='mensaje'> Usuario inexistente</p>";

    }else if (isset($_GET['error']) && $_GET['error'] == 2) {
        echo "<p style='color:red;' class='mensaje'> Contraseña incorrecta</p>";

    }
    ?>
</header>
<main>
    <div class="buscador">
        <form action="index.php" method="get">
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
                <?php if(isset($_SESSION['usuario'])):?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pokemons as $pokemon):
                ?>
                <tr>
                    <td><img src="<?= Config::$imagenPath . $pokemon->getImagen() ?>" alt="<?= $pokemon->getNombre() ?>"></td>
                    <td>
                    <?php
                    $tipos = explode(',', $pokemon->getTipo());
                    foreach($tipos as $tipo):
                    ?>
                    <img src="<?= Config::$imagenPath .  $tipo ?>" alt="<?= $tipo ?>">
                    <?php endforeach; ?>
                    </td>
                    <td><?= $pokemon->getNumero() ?></td>
                    <td><a class="linkDetalle" href="detalle.php?id=<?= $pokemon->getId() ?>"> <?= $pokemon->getNombre() ?> <a/> </td>
                    <?php if(isset($_SESSION['usuario'])):?>
                    <td>
                        <form class="modificar-pokemon" action="modificate.php" method="get">
                            <input type="hidden" name="id" value="<?= $pokemon->getId() ?>">
                        <button type="submit" class="modif">Modificacion</button>
                        </form>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?= $pokemon->getId() ?>">
                            <button class="baja">Baja</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>
<?php
include_once __DIR__ . '/footer.php';
?>
</body>
</html>
