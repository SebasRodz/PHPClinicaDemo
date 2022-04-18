<?php
    // Inicializa la sesión
    session_start();
    
    // Despoja todas las variables de la sesión
    $_SESSION = array();
    
    // Destruye la seseión
    session_destroy();
    
    // Redirije al login
    header("location: index.php");
    exit;
?>