<?php
    // Iniciando la sesión
    session_start();

    // Conenctando a la base de datos
    include("../connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Definiendo las variables y la id de la sesión
        $v1 = $_POST['sintomas'];
        $v2 = $_POST['rayos'];
        $v3 = $_POST['diagnostico'];
        $v4 = $_POST['medicina'];
        $v5 = $_POST['costo'];

        $id_perro = $_SESSION["perro_id"];
        $id = $_SESSION["id"];

        // Consulta SQL para agregar la mascota
        $sql = "INSERT INTO perroconsultado (id_perro, id_user, sintomas, rayosx, prueba_sangre, medicina, costo) ";
        $sql .= "VALUES ('$id_perro', '$id', '$v1', '$v2', '$v3', '$v4', '$v5')";
        
        // Resultado en caso de error
        if (!(mysqli_query($db, $sql))) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } else {
            $sql2 = "UPDATE perro SET consulta = 1 WHERE id = ".$id_perro;
            mysqli_query($db, $sql2);
            echo $sql2;
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
            <h3 style="text-align: center;">
                Atencion de perro de nombre: <?php echo htmlspecialchars($_SESSION["perro_nombre"]); ?>
            </h3>
        </div>
        <div class="card-body">
            <form id="form-consulta" class="form-group" action="atender-perro.php" method="POST">                        
                <label class="form-label">Sintomas:</label>
                <textarea class="form-control" id="sintomas" name="sintomas" rows="3" placeholder="Escriba los sintomas..."></textarea>  
                
                <label class="form-label mt-3">Rayos X:</label>
                <input id="rayos" name= "rayos" type = "file" class="form-control">
                        
                <label class="form-label mt-3">Diagnostico de Sangre:</label> 
                <textarea class="form-control" id="diagnostico" name="diagnostico" rows="2" placeholder="Escriba el diagnostico..."></textarea> 
                        
                <label class="form-label mt-3">Medicinas:</label>
                <input id="medicina" name="medicina" type="text" class="form-control" placeholder="Escribe las medicinas">
                
                <label class="form-label mt-3">Costo de la consulta:</label> 
                <input id="costo" class="form-control" name="costo" type="number" placeholder="Escriba el costo en soles">
            
                <div class = "botones mt-3">        
                    <!-- <div class="boton">
                        <input class="btn btn-lg btn-primary" name= "Registrar" type = Submit value = "Registrar">
                    </div> -->
                    <div>
                        <button id="boton-atender" type="button" class="btn btn-primary">
                            Atender
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
    <script src="script-atender.js"></script>
</body>
</html>