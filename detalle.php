<?php
require_once __DIR__ . "/src/Pokemon.php";
$id = $_GET['id'];
$pokemon = (new Pokemon())->buscarPokemonPorId($id);
$evoluciones = $pokemon->buscarEvoluciones($pokemon->getNumero());
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Pokémon</title>
    <link rel="stylesheet" href="Styles/index.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="Imagenes/logo.webp" alt="Imagen Pokeball">
        </div>
        <h1>Pokedex</h1>
</header>

<main>

    <h1>Detalle de Pokémon</h1>
    <a href="index.php">Volver a la Pokédex</a>

    <section class="pokemon-detail">
        <?php if ($pokemon): ?>
            <div class="pokemon-info">
                <h2><?php echo $pokemon->getNombre(); ?></h2>

                <p><?php echo $pokemon->getDescripcion();?></p>

                <img src="<?php echo $pokemon->getImagen(); ?>" alt="<?php echo $pokemon->getImagen(); ?>" />
                <img src="<?php echo $pokemon->getTipo(); ?>" alt= "<?php echo $pokemon->getTipo(); ?>" />

                <?php if (!empty($evoluciones)): ?>
                    <h3>Evoluciones:</h3>
                    <ul>
                        <?php foreach ($evoluciones as $evolucion): ?>
                            <li><?php echo $evolucion->getNombre(); ?></li>
                            <img src="<?php echo $evolucion->getImagen(); ?>" alt="Imagen de <?php echo $evolucion->getNombre(); ?>">
                        <?php endforeach; ?>

                    </ul>
                <?php else: ?>
                    <p>Este pokémon no tiene evoluciones.</p>
                <?php endif; ?>


                </div>
            </div>
        <?php else: ?>
            <p class="pokemon-not-found">Pokémon no encontrado.</p>
        <?php endif; ?>

    </section>
</main>

<footer>
   <?php include_once __DIR__ . '/footer.php'; ?>
</footer>

</body>
</html>

