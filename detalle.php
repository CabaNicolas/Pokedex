<?php
// Incluir el archivo de conexión (donde está definida la clase DB)
require_once __DIR__. '/src/db.php';

// Obtener la conexión a la base de datos utilizando la clase DB
$pdo = DB::getConexion();

$id = $_GET['id'];

// Preparar la consulta para obtener los detalles del Pokémon por su ID
$stmt = $pdo->prepare("SELECT * FROM pokemon WHERE numero = ?");
$stmt->execute([$id]);
$pokemon = $stmt->fetch();
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
                <h2><?php echo $pokemon['nombre']; ?></h2>

                <p><?php echo $pokemon['descripcion'];?></p>

                <img src="<?php echo $pokemon['imagen']; ?>" alt="<?php echo $pokemon['imagen']; ?>" />

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

