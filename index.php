<?php
require_once __DIR__ . '/src/Pokemon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link rel="stylesheet" href="src/estilos/styles.css">
</head>
<body>

            <h1>Pokedex</h1>

<?php
    $pokemons = (new Pokemon())->getPokemons();
    foreach ($pokemons as $pokemon):?>

    <div class="pokemon">
        <h2><?= $pokemon->getNombre() ?> # <?= $pokemon->getNumero() ?></h2>
        <img src="<?= $pokemon->getImagen() ?>" alt="<?= $pokemon->getNombre() ?>">
    </div>
    <?php
    endforeach;
?>

</body>
</html>