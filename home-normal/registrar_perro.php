<?php
    // Iniciando la sesión
    session_start();

    // Conenctando a la base de datos
    include("../connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Definiendo las variables y la id de la sesión
        $v1 = $_POST['nombre'];
        $v2 = $_POST['raza'];
        $v3 = $_POST['genero'];
        $v4 = $_POST['fecha'];
        $v5 = $_POST['imagen'];

        $id = $_SESSION["id"];

        // Consulta SQL para agregar la mascota
        $sql = "INSERT INTO Perro (id_user, nombre, raza, genero, fechanac, foto) ";
        $sql .= "VALUES ('$id', '$v1', '$v2', '$v3', '$v4', '$v5')";
        
        // Resultado en caso de error
        if (!(mysqli_query($db, $sql))) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } 
        
        // Close conexión
        mysqli_close($db);
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
    <div class="card border-primary mb-3" style="width: 60%; height:auto; margin:0 auto; margin-top:1%">
        <div class="card-header">
            <h3 style="text-align: center;">Registro de Perro</h3>
        </div>
        <div class="card-body">
            <form id="form-ingreso" class="form-group" action="registrar_perro.php" method="POST">                        
                <label class="form-label">Ingresar Nombre:</label>
                <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Escribe el nombre">
                        
                <label class="form-label mt-3">Fecha de Nacimiento:</label>
                <input id="fecha" name= "fecha" type = "date" class="form-control">
                        
                <label class="form-label mt-3">Genero:</label> 
                <div class="form-check">
                    <label class="form-check-label">
                        <input name="genero" type="radio" class="checked-reg form-check-input" value="Macho" checked="">
                        Macho
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input name="genero" type="radio" class="checked-reg form-check-input" value="Hembra">
                        Hembra
                    </label>
                </div>
                        
                <label class="form-label mt-3">Seleccione raza:</label>
                <br>
                <select class="form-select" id="select-gen" name="raza">
                    <option value="Pitbull">Pitbull</option>
                    <option value="Bulldog">Bulldog</option>
                    <option value="Shichu">Shichu</option>
                    <option value="Pequines">Pequines</option>
                    <option value="San Bernando">San Bernando</option>
                    <option value="Chiguahua">Chiguahua</option>
                    <option value="Pastor Aleman">Pastor Aleman</option>
                </select>
                <br>
                
                <label class="form-label mt-3">Imagen:</label> 
                <input id="imagen" class="form-control" name="imagen" type="text">
            
                <div class = "botones mt-3">        
                    <!-- <div class="boton">
                        <input class="btn btn-lg btn-primary" name= "Registrar" type = Submit value = "Registrar">
                    </div> -->
                    <div>
                        <button id="boton-registrar" type="button" class="btn btn-primary">
                            Registrar
                        </button>
                    </div>
                    <div>
                        <button id="boton-cancelar" type="button" class="btn btn-secondary ml-3">
                            Cancelar
                        </button>
                    </div>
                </div>    

                <div class="response"></div>
            </form>
        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="script-registro.js"></script>
</body>
</html>