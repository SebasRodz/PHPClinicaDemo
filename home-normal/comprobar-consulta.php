<?php
    // Inicializando la sesión
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cosmo/bootstrap.min.css" integrity="sha384-5QFXyVb+lrCzdN228VS3HmzpiE7ZVwLQtkt+0d9W43LQMzz4HBnnqvVxKg6O+04d" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <h1>Sistema de Identificación Perruno</h1>
    </header>
    <div class="card border-primary mb-3" style="width: 60%; height:auto; margin:0 auto; margin-top:1%">
        <div class="card-header">
            <h3 style="text-align: center;">
                Comprobar consulta de perro: <?php echo htmlspecialchars($_SESSION["perro_nombre"]); ?>
            </h3>
        </div>
        <div id="table" class="card-body"></div>
        <div class = "botones mt-2 mb-3">
            <button value = "<?php echo htmlspecialchars($_SESSION["perro_id"]); ?>" id="boton-aceptar" type="button" class="btn btn-primary ml-3">
                Aceptar
            </button>
            <button id="boton-cancelar" type="button" class="btn btn-danger ml-3">
                Cancelar
            </button>
        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="script-comprobar.js"></script>
</body>
</html>