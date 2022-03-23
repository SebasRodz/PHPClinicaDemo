<?php
    // Inicializando la sesión
    session_start();

    // Conexión a la base de datos
    include("connection.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        // Validando credenciales
        if(!empty($id)){
            // Preparando la consulta DELETE
            $sql = "DELETE FROM perro WHERE id = ".$id;
            
            if($stmt = mysqli_prepare($db, $sql)){
                // Intento de ejecutar la declaración preparada
                if(mysqli_stmt_execute($stmt)){
                    // Resultados
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) >= 1){                    
                        
                        if(mysqli_stmt_fetch($stmt)){
                            $result = mysqli_query($db, $sql);
                            
                            if(!$result) {
                                echo "Error: " . $sql . "<br>" . mysqli_error($db);
                            } else {
                                echo 'Se elimino a la mascota';
                            }
                        } else{
                            echo false;
                        }
                    }
                } else {
                        echo false;
                }
            } else {
                    echo false;
            }
            // Cierra la declaracion
            mysqli_stmt_close($stmt);
        }
    }
?>