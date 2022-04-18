<?php
    ini_set( 'session.cookie_httponly', 1 );
    // Inicializando la sesión
    session_start();

    // Conexión a la base de datos
    include __DIR__."/../connection.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        // Validando credenciales
        if(!empty($id)){
            // Preparando la consulta DELETE
            $sql = "DELETE FROM perro WHERE id = ".$id;
            $sql2 = "DELETE FROM perro_consulta WHERE id_perro = ".$id;
            

            $result = mysqli_query($db, $sql2);

            if(!$result) {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            } else {
                mysqli_query($db, $sql);
                echo 'Se elimino a la mascota';
            }
        }
        // Close conexión
        mysqli_close($db);
    }
?>