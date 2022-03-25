<?php
    // Iniciando la sesión
    session_start();

    // Conenctando a la base de datos
    include("../connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Definiendo el perro a tratar
        $_SESSION["perro_id"] = $_POST["perro_id"];
        $_SESSION["perro_nombre"] = $_POST["perro_nombre"];

        // Close conexión
        mysqli_close($db);
    }
?>