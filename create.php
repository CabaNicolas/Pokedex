<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pokémon</title>
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
<h2>Agregar un pokémon a la lista</h2>
<form action="procesar_create.php" method="post" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre del Pokémon" required>
    <input type="number" name="numero" placeholder="Número del Pokémon" required>

    <label for="tipo">Selecciona el/los tipo/s:</label>
    <select name="tipos[]" id="tipo" multiple required>
        <option value="Imagenes/fuego.webp">Fuego</option>
        <option value="Imagenes/agua.webp">Agua</option>
        <option value="Imagenes/hierba.webp">hierba</option>
    </select>

    <textarea name="descripcion" placeholder="Descripcion" rows="4" required></textarea>

    <label for="imagen">Suba la imagen del pokémon:</label>
    <input type="file" name="imagen" accept="image/*" required>

    <button type="submit">Agregar Pokémon</button>
</form>

<a class="volver" href="index.php">Volver a la lista de Pokemones</a>
    </div>
</main>
</body>
</html>
