<?php
// Inicia la sesión para mostrar contenido personalizado
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="icon" href="Imagenes/iconoPestania.webp">
    <style>
        .msj-404{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #2E3A59;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="Imagenes/logo.webp" alt="Imagen Pokeball">
    </div>
    <h1 class="titulo">Error 404 - Página no encontrada</h1>
</header>
<main>
    <div class="msj-404">
    <p>Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>

    <a href="index.php">Volver a la página principal</a>

    <?php if (isset($_SESSION['usuario'])): ?>
        <h4 class="usuario">Bienvenido, <?= $_SESSION['usuario']; ?>!</h4>
    
    <?php endif; ?>
    </div>
    <div class="buscador">
        <p style="color: #2E3A59;">Mientras tanto, ¿por qué no buscas un Pokémon?</p>
        <form action="index.php" method="get">
            <input type="text" name="buscado" placeholder="Ingrese el nombre o número del Pokémon">
            <button type="submit">Buscar Pokémon</button>
        </form>
    </div>
</main>
<?php
include_once __DIR__ . '/footer.php';
?>
</body>
</html>
