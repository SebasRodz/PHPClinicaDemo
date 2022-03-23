<?php
    include("connection.php");

    //Definiendo variables
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    //Procesando la data de los forms
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validando usuario
        if (empty (trim ($_POST["username"]))) {
            $username_err = "Porfavor, ingrese un usuario.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
            $username_err = "Ingrese un usuario solo con letras, numeros y guiones bajos.";
        } else {
            //Preparando el query SELECT
            $sql = "SELECT id FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                // Vincular variables a la declaración preparada como parámetros
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Deinir parametros
                $param_username = trim($_POST["username"]);

                // Intento de ejecutar la declaración preparada
                if (mysqli_stmt_execute($stmt)) {
                    /* Guarda el resultado */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "Este usuario ya esta tomado.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Algo salio mal, Intentalo luego.";
                }
                // Cerrar la declaración
                mysqli_stmt_close($stmt);
            }
        }

        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=(.*?\d){2})((?=.*[@#$%&?]){2,})[A-Za-z\d@#$%?]{8,}$/"; 
        //Validar la contraseña
        if (empty(trim($_POST["password"]))) {
            $password_err = "Porfavor, ingresa una contraseña correcta.";
        } 
        // elseif (strlen(trim($_POST["password"])) < 8)
        elseif (!preg_match($pattern, trim($_POST['password'])))
        { 
            $password_err = "La contraseña no cumple los requisitos.";
        } else {
            $password = trim($_POST["password"]);
        }

        //Validar la confirmación de contraseña
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Porfavor, confirme la contraseña.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "La contraseña no coincide.";
            }
        }
        
        // Determinar errores en los inputs antes de entrar en la base de datos
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            
            // Preparando la declaración INSERT
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
             
            if($stmt = mysqli_prepare($db, $sql)){
                // Vincular variables a la declaración preparada como parámetros
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                
                // Declarar parametros
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Crea un hash en la contraseña
                
                // Definiciones al ejecutar la declaración preparadas
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    header("location: login.php");
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
<html>
   <head>
      <title>Login Page</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cosmo/bootstrap.min.css" integrity="sha384-5QFXyVb+lrCzdN228VS3HmzpiE7ZVwLQtkt+0d9W43LQMzz4HBnnqvVxKg6O+04d" crossorigin="anonymous">
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
        <header class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h1>Sistema de Identificación Perruno</h1>
        </header>
        <div class = "registro-container">
            <div class="registro-sub-container card border-primary mb-3" style="width: 30rem;">
                <div class="card-header">
                    <h3>Registro</h3>
                </div>
                <div class = "card-body">
                    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id = "form-login" class="form-group" method = "post">
                        
                        <label class="form-label mt-3">Usuario:</label>
                        <input 
                            name = "username" 
                            type = "text" 
                            class = "form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
                            value = "<?php echo $username; ?>" 
                            placeholder = "Escriba su usuario">
                        <span class="invalid-feedback">
                            <?php echo $username_err; ?>
                        </span>
                        
                        <label class="form-label mt-3">Contraseña:</label>
                        <input 
                            name = "password" 
                            type = "password" 
                            class = "form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                            value = "<?php echo $password; ?>"
                            placeholder="Escriba su contraseña">
                        <span class="invalid-feedback">
                            <?php echo $password_err; ?>
                        </span>

                        <label class="form-label mt-3">Confirmar Contraseña:</label>
                        <input 
                            name="confirm_password" 
                            type="password" 
                            class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" 
                            value = "<?php echo $confirm_password; ?>"
                            placeholder="Confirme su contraseña">
                            <span class="invalid-feedback">
                                <?php echo $confirm_password_err; ?>
                            </span>

                        <div class="boton mt-4">
                            <input class="btn btn-lg btn-primary" type = "Submit" value = "Crear Usuario">
                        </div>
                        
                        <div class="response">
                            <small class="smalling form-text text-muted mt-2">¿Ya tiene cuenta? <a href="login.php">Logueate</a></small>
                        </div>
                    </form>
                </div>
            </div>	
        </div>
    </body>
</html>
