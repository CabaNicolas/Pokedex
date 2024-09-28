<?php
require_once __DIR__ . "/src/Pokemon.php";
require_once __DIR__ . '/Config.php';
$id = $_GET['id'];
$pokemon = (new Pokemon())->buscarPokemonPorId($id);
if ($pokemon != null) {
    $evoluciones = $pokemon->buscarEvoluciones($pokemon->getNumero());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Pokémon</title>
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="icon" href="Imagenes/iconoPestania.webp">
</head>
<body>
<header class="header">
    <div class="logo">
        <img src="Imagenes/logo.webp" alt="Imagen Pokeball">
    </div>
    <h1 class="title">Pokedex</h1>
</header>

<main class="main-container">
    <h1 class="detalle-titulo">Detalle de Pokémon</h1>
    <div>
        <a href="index.php" class="btn-back">Volver a la Pokédex</a>
    </div>

    <section class="pokemon-detail">
        <?php if ($pokemon): ?>
            <div class="pokemon-info">

                <div class="detalle">
                <h2><?php echo htmlspecialchars($pokemon->getNombre(), ENT_QUOTES, 'UTF-8'); ?></h2>
                <p class="description"><?php echo htmlspecialchars($pokemon->getDescripcion(), ENT_QUOTES, 'UTF-8'); ?></p> </div>

                <img class="imagen_detalle" src="<?php echo  htmlspecialchars(Config::$imagenPath .$pokemon->getImagen(), ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen de <?php echo htmlspecialchars($pokemon->getNombre(), ENT_QUOTES, 'UTF-8'); ?>" class="main-image" />

                <div class="tipos">
                    <?php
                    $tipos = explode(',', $pokemon->getTipo());
                    foreach ($tipos as $tipo):
                        ?>
                        <div class="tipos-badge">
                            <img class="tipo-imagen" src="<?php echo htmlspecialchars(Config::$imagenPath .$tipo, ENT_QUOTES, 'UTF-8'); ?>" alt="Tipo de <?php echo htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'); ?>">

                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($evoluciones)): ?>
                    <div class="evoluciones">

                        <h3 class="evoluciones-titulo">Evoluciones</h3>

                        <div class="evolution-list">
                            <?php foreach ($evoluciones as $evolucion): ?>
                                <div class="evolution-item">
                                    <img src="<?php echo htmlspecialchars(Config::$imagenPath .$evolucion->getImagen(), ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen de <?php echo htmlspecialchars($evolucion->getNombre(), ENT_QUOTES, 'UTF-8'); ?>" class="evolution-image" />
                                    <p><?php echo htmlspecialchars($evolucion->getNombre(), ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                <div class="texto-peligro">
                    <p class="text-danger">Este pokémon no tiene evoluciones.</p></div>
                <?php endif; ?>
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
