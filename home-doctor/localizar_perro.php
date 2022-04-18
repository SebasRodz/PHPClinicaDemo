<?php
    ini_set( 'session.cookie_httponly', 1 );
    // Iniciando la sesión
    session_start();

    // Conenctando a la base de datos
    include __DIR__."/../connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Definiendo el perro a tratar
        $_SESSION["perro_id"] = $_POST["perro_id"];
        $_SESSION["perro_nombre"] = $_POST["perro_nombre"];

        // Close conexión
        mysqli_close($db);
    }
?>