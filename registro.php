<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <h2>Crear Cuenta</h2>


        <form action="validar-registro.php" method="post" enctype="multipart/form-data">
            <input type="email" name="email" placeholder="Ingrese su correo electronico" required>
            <input type="password" name="password" placeholder="Cree una contraseña" required>


            <button type="submit">Crear Cuenta</button>
        </form>
        <!-- Mostrar mensajes de éxito o error -->
        <div class="mensajes-registro">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo "<p style='color:green;text-align: center'>" . htmlspecialchars($_GET['message']) . "</p>";
            } elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
                echo "<p style='color:red; text-align: center'>" . htmlspecialchars($_GET['message']) . "</p>";
            }
            ?>
        </div>
        <a class="volver" href="index.php">Volver al inicio</a>


    </div>
</main>
</body>
</html>


