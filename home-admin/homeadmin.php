<?php
    // Inicializando la sesión
    session_start();

    // Conexión a la base de datos
    include("../connection.php");
    
    // Revisa si un usuario esta logueado, siendo el caso, lo redirige al login
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        if($_SESSION["id_type"] != 1){
            header("location: ../index.php");
            exit;
        }
    }
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
    <div class="card mb-3">
        <h3 class="card-header">
            Bienvenido otra vez, administrador <?php echo htmlspecialchars($_SESSION["username"]); ?>. 
        </h3>
    </div>
    <div class="card mb-3 mt-3" style="width: 90%; margin:0 auto;">
        <h4 class="card-header" style="text-align: center;">
            Lista total de perros
        </h4>
        <div class = "card-body">
            <div id = "grid-triple" class = "grid-triple"></div>
            <div class = "botones mt-3">
                <button id="cerrar-sesion" type="button" class="btn btn-danger ml-3">
                    Cerrar Sesión
                </button>
            </div> 
        </div>
    </div>
    <script
		src="https://code.jquery.com/jquery-3.6.0.js"
		integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
		crossorigin="anonymous">
    </script>
    <script src="script-admin.js"></script>
</body>
</html>