<?php
    // Iniciando la sesión
    session_start();

    // Conenctando a la base de datos
    include("../connection.php");

    //Definiendo variables
    $nombre = $fecha = $imagen = "";
    $nombre_err = $fecha_err = $imagen_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validando nombre
        if (empty (trim ($_POST["nombre"]))) {
            $nombre_err = "Porfavor, ingrese un nombre.";
        } elseif (!preg_match('/^[A-Z][A-Za-z]{2,254}$/', trim($_POST['nombre']))) {
            $nombre_err = "El nombre empieza con mayuscula y no puede tener numeros.";
        } else {
            $nombre = trim($_POST["nombre"]);
        }

        // Validando fecha
        if (empty (trim ($_POST["fecha"]))) {
            $fecha_err = "Porfavor, ingrese una fecha.";
        } else {
            $fecha = $_POST["fecha"];
        }

        // Validando imagen
        if (empty (trim ($_POST["imagen"]))) {
            $imagen_err = "Porfavor, ingrese un enlace.";
        } else {
            $imagen = trim($_POST["imagen"]);
        }

        // Definiendo las demas variables
        $raza = $_POST['raza'];
        $genero = $_POST['genero'];

        // Definiendo el id de la sesion
        $id = $_SESSION["id"];

        // Determinar errores en los inputs antes de entrar en la base de datos
        if(empty($nombre_err) && empty($fecha_err) && empty($imagen_err)){
            
            // Preparando la declaración INSERT
            // $sql = "INSERT INTO users (username, password, id_type) VALUES (?, ?, ?)";
            $sql = "INSERT INTO perro (id_user, nombre, raza, genero, fechanac, foto, consulta) VALUES (?,?,?,?,?,?,?)";
             
            if($stmt = mysqli_prepare($db, $sql)){
                // Vincular variables a la declaración preparada como parámetros
                mysqli_stmt_bind_param($stmt, "sssssss", $param_id, $param_nombre, $param_raza, $param_genero, $param_fecha, $param_imagen, $consulta);
                
                // Declarar parametros
                $param_id = $id;
                $param_nombre = $nombre;
                $param_raza = $raza;
                $param_genero = $genero;
                $param_fecha = $fecha;
                $param_imagen = $imagen;
                $consulta = 0;
                
                // Definiciones al ejecutar la declaración preparadas
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to home page
                    header("location: home.php");
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
            <h3 style="text-align: center;">Registro de Perro</h3>
        </div>
        <div class="card-body">
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form-ingreso" class="form-group" method="POST">                        
                <label class="form-label">Ingresar Nombre:</label>
                <input 
                    value="<?php echo $nombre; ?>" 
                    id="nombre" 
                    name="nombre" 
                    type="text" 
                    class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" 
                    placeholder="Escribe el nombre">
                <span class="invalid-feedback">
                    <?php echo $nombre_err; ?>
                </span>
                        
                <label class="form-label mt-3">Fecha de Nacimiento:</label>
                <input 
                    value="<?php echo $fecha; ?>" 
                    id="fecha" 
                    name= "fecha" 
                    type = "date" 
                    class="form-control <?php echo (!empty($fecha_err)) ? 'is-invalid' : ''; ?>" 
                    placeholder="Ingresa URL">
                <span class="invalid-feedback">
                    <?php echo $fecha_err; ?>
                </span>
                        
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
                <input 
                    value="<?php echo $imagen;?>" 
                    id="imagen" 
                    class="form-control <?php echo (!empty($imagen_err)) ? 'is-invalid' : ''; ?>" 
                    name="imagen" 
                    type="text">
                <span class="invalid-feedback">
                    <?php echo $imagen_err; ?>
                </span>
            
                <div class = "botones mt-3">        
                    <input class="btn btn-primary ml-3" type = "submit" value = "Registrar Perro">
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
    <script src="script-registro.js"></script>
</body>
</html>