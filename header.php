<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="contenedor">
        <header class="encabezado">
            <div class="logo">♻️</div>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="navegacion">
                <a href="index.php">Inicio</a>
                <a href="index.php#materiales">Materiales</a>
                <a href="index.php#como-funciona">Cómo Funciona</a>
                <a href="index.php#testimonios">Testimonios</a>
                <a href="login.php" class="btn-nav">Iniciar Sesión</a>
                <a href="registro.php" class="btn-nav btn-registro">Registrarse</a>
            </nav>
        </header>