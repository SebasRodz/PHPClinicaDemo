<?php
//    define('DB_SERVER', "localhost");
//    define('DB_USERNAME', "root");
//    define('DB_PASSWORD', "");
//    define('DB_DATABASE', "RelocaDB");
//    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

//    if (!$db) {
//     die("Error de conexion: " . mysqli_connect_error());
//    }

    $user = getenv('CLOUDSQL_USER');
    $pass = getenv('CLOUDSQL_PASSWORD');
	$inst = getenv('CLOUDSQL_DSN');
	$db1 = getenv('CLOUDSQL_DB');
	$db = mysqli_connect(null, $user, $pass, $db1, null, $inst);

	if (!$db) {
		echo "Error!".mysqli_connect_error();
	}
				
	// return $connection;
?>