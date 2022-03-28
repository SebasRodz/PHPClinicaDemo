<?php
    // Iniciando la sesión
    session_start();

    // Conenctando a la base de datos
    include("../connection.php");

    //Definiendo variables
    $sintomas = $diagnostico = $medicina = $rayos = "";
    $sintomas_err = $diagnostico_err = $medicina_err = $rayos_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validando sintomas
        if (empty (trim ($_POST["sintomas"]))) {
            $sintomas_err = "Porfavor, ingrese los sintomas.";
        } elseif (!preg_match('/^[A-Za-z,. ]{30,254}$/', trim($_POST['sintomas']))) {
            $sintomas_err = "Se debe detallar con minimo 30 caracteres, maximo 254, sin numeros.";
        } else {
            $sintomas = trim($_POST["sintomas"]);
        }

        // Validando diagnostico de sangre
        if (empty (trim ($_POST["diagnostico"]))) {
            $diagnostico_err = "Porfavor, ingrese el diagnostico.";
        } elseif (!preg_match('/^[A-Za-z0-9,.\- ]{30,254}$/', trim($_POST['diagnostico']))) {
            $diagnostico_err = "Se debe detallar con minimo 30 caracteres, maximo 254";
        } else {
            $diagnostico = trim($_POST["diagnostico"]);
        }

        // Validando medicina
        if (empty (trim ($_POST["medicina"]))) {
            $medicina_err = "Porfavor, ingrese las medicinas.";
        } elseif (!preg_match('/^[A-Za-z0-9,. ]{30,100}$/', trim($_POST['medicina']))) {
            $medicina_err = "Se debe detallar con minimo 30 caracteres, maximo 100";
        } else {
            $medicina = trim($_POST["medicina"]);
        }

        $costo = trim($_POST["costo"]);

        // Validando rayos
        if (empty (trim ($_POST["rayos"]))) {
            $rayos_err = "Porfavor, ingrese un archivo.";
        } else {
            $rayos = trimm($_POST["rayos"]);
        }

        // Definiendo las ids del perro
        $id_perro = $_SESSION["perro_id"];
        $id = $_SESSION["id"];

        // Determinar errores en los inputs antes de entrar en la base de datos
        if(empty($sintomas_err) && empty($diagnostico_err) && empty($medicina_err) && 
            empty($rayos_err) && empty($costo_err)){
            
            // Preparando la declaración INSERT
            $sql = "INSERT INTO perro_consulta (id_perro, id_user, sintomas, rayosx, prueba_sangre, medicina, costo) ";
            $sql .= "VALUES (?,?,?,?,?,?,?)";
             
            if($stmt = mysqli_prepare($db, $sql)){
                // Vincular variables a la declaración preparada como parámetros
                mysqli_stmt_bind_param($stmt, "sssssss", $param_id_perro, $param_id, $param_sintomas, $param_rayos, $param_diagnostico, $param_medicina, $param_costo);
                
                // Declarar parametros
                $param_id_perro = $id_perro;
                $param_id = $id;
                $param_sintomas = $sintomas;
                $param_rayos = $rayos;
                $param_diagnostico = $diagnostico;
                $param_medicina = $medicina;
                $param_costo = $costo;
                
                // Definiciones al ejecutar la declaración preparadas
                if(mysqli_stmt_execute($stmt)){
                    // Estableciendo el perro consultado
                    $sql2 = "UPDATE perro SET consulta = 1 WHERE id = ".$id_perro;
                    mysqli_query($db, $sql2);

                    // Redirigiendo
                    header("location: homedoctor.php");
                } else{
                    echo "Algo salio mal, Intentalo luego.";
                }
    
                // Cerra declaracion
                mysqli_stmt_close($stmt);
            }
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
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form-consulta" class="form-group" method="POST">                        
                <label class="form-label">Sintomas:</label>
                <textarea 
                    id="sintomas" 
                    name="sintomas" 
                    rows="3" 
                    class="form-control <?php echo (!empty($sintomas_err)) ? 'is-invalid' : ''; ?>" 
                    placeholder="Escriba los sintomas"><?php echo trim($sintomas); ?></textarea>
                <span class="invalid-feedback">
                    <?php echo $sintomas_err; ?>
                </span>
                
                <label class="form-label mt-3">Rayos X:</label>
                <input 
                    value="<?php echo $rayos; ?>" 
                    id="rayos" 
                    name= "rayos" 
                    type = "file" 
                    class="form-control <?php echo (!empty($rayos_err)) ? 'is-invalid' : ''; ?>"
                    accept="application/pdf">
                <span class="invalid-feedback">
                    <?php echo $rayos_err; ?>
                </span>
                        
                <label class="form-label mt-3">Diagnostico de Sangre:</label> 
                <textarea 
                    id="diagnostico" 
                    name="diagnostico" 
                    rows="2" 
                    type = "text"
                    class="form-control <?php echo (!empty($diagnostico_err)) ? 'is-invalid' : ''; ?>" 
                    placeholder="Escriba el diagnostico"><?php echo trim($diagnostico); ?></textarea> 
                <span class="invalid-feedback">
                    <?php echo $diagnostico_err; ?>
                </span>
                        
                <label class="form-label mt-3">Medicinas:</label>
                <input 
                    value="<?php echo $medicina; ?>" 
                    id="medicina" 
                    name="medicina" 
                    type="text" 
                    class="form-control <?php echo (!empty($medicina_err)) ? 'is-invalid' : ''; ?>" 
                    placeholder="Escribe las medicinas">
                <span class="invalid-feedback">
                    <?php echo $medicina_err; ?>
                </span>

                <label class="form-label mt-3">Costo de la consulta:</label> 
                <input 
                    value="<?php echo $costo; ?>"
                    id="costo" 
                    name="costo" 
                    type="number" 
                    class="form-control" 
                    placeholder="Escriba el costo en soles.">
            
                <div class = "botones mt-3">        
                    <input class="btn btn-primary ml-3" type = "submit" value = "Atender Perro">
                    <button id="boton-cancelar" type="button" class="btn btn-secondary ml-3">
                        Cancelar
                    </button>
                </div>    
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