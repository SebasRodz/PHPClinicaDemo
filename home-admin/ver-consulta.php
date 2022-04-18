<?php
    ini_set( 'session.cookie_httponly', 1 );
    // Inicializando la sesión
    session_start();

    // Conexión a la base de datos
    include __DIR__."/../connection.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_SESSION["perro_id"];

        // Validando credenciales
        if(!empty($id)){
            // Preparando la consulta SELECT
            $sql = "SELECT * FROM perro_consulta WHERE id_perro = ".$id;
            
            if($stmt = mysqli_prepare($db, $sql)){
                // Intento de ejecutar la declaración preparada
                if(mysqli_stmt_execute($stmt)){
                    // Resultados
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) >= 1){                    
                        
                        if(mysqli_stmt_fetch($stmt)){
                            $result = mysqli_query($db, $sql);
                            $ouput = array();

                            while ($row = mysqli_fetch_assoc($result)) {
                                $output[] = $row;
                            }
                            echo json_encode($output);
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
        // Close conexión
        mysqli_close($db);
    }
?>