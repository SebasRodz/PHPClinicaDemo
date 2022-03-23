<?php
// Iniciando la sesión
session_start();
 
// Revisa si un usuario esta logueado, siendo el caso, lo redirige al home
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}

include("connection.php");
 
// Definiendo variables
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Procesando la data en caso de ser enviada
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verificando si el usuario esta vacio
    if(empty(trim($_POST["username"]))){
        $username_err = "Porfavor, ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Verificando si la contraseña esta vacia
    if(empty(trim($_POST["password"]))){
        $password_err = "Porfavor, ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validando credenciales
    if(empty($username_err) && empty($password_err)){
        // Preparando la consulta SELECT
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Deinir parametros
            $param_username = $username;
            
            // Intento de ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Resultados
                mysqli_stmt_store_result($stmt);
                
                // Verifica si existe el usuario, siendo asi, la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Vincula las variables resultantes
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Si la contraseña es correcta, empieza una nueva sesión
                            session_start();
                            
                            // Guarda la sesión en variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirecciona al home
                            header("location: home.php");
                        } else{
                            // Si la contraseña no es valida, manda el siguiente mensaje
                            $login_err = "Usuario o contraseña invalidos.";
                        }
                    }
                } else{
                    // Si no existe el usuario, manda el siguiente mensaje
                    $login_err = "Usuario o contraseña invalidos.";
                }
            } else{
                echo "Algo salio mal, Intentalo luego.";
            }

            // Cierra la declaracion
            mysqli_stmt_close($stmt);
        }
    }
    
    // Cierra la conexión
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
        <div class = "login-container">
            <div class="login-sub-container card border-primary mb-3" style="width: 30rem;">
                <div class="card-header">
                    <h3>Inicio de Sesión</h3>
                </div>
                <div class = "card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group" method = "post">
                        <label class="form-label">Usuario:</label>
                        <input 
                            name="username" 
                            type="text" 
                            class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
                            value="<?php echo $username; ?>"
                            placeholder="Escriba su correo electronico">
                        <span class="invalid-feedback">
                            <?php echo $username_err; ?>
                        </span>

                        <label class="form-label mt-3">Contraseña:</label>
                        <input 
                            name="password" 
                            type="password" 
                            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                            placeholder="Escriba su contraseña">
                            <span class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </span>
                        
                        <div class="boton mt-4">
                            <input class="btn btn-lg btn-primary" type = "submit" value = "Iniciar Sesión">
                        </div>

                        <div class="response">
                            <small class="smalling form-text text-muted mt-2">¿No tienes cuenta? <a href="registro.php">Registrate</a></small>
                        </div>
                    </form>
                </div>
            </div>	
        </div>
        <script src="script.js"></script>
   </body>
</html>