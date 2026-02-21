<?php
    include_once("content/rosetta.php"); // Archivo de la base de datos
    
    // Conectar con la base de datos (mysqli)
    // $link debería definirse en rosetta.php, pero por si acaso:
    if (!isset($link)) {
        $link = mysqli_connect($db_host, $db_user, $db_pass, $bdd);
        if (!$link) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    }

    if (isset($mainUserName)) {
        // Capturar la IP del usuario y añadirla a la BDD
        $userIP   = $_SERVER['REMOTE_ADDR'];
        $userDate = date('Y-m-d H:i:s'); // formato estándar
        $userHits = $_SESSION['hits'] + 1;

        // Usamos consultas seguras
        $sql = "UPDATE $tableUsers 
                   SET ip = ?, lastuse = ?, hits = ? 
                 WHERE $mainUserNameRow = ?";
        $stmt = mysqli_prepare($link, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssis", $userIP, $userDate, $userHits, $mainUserName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            error_log("Error preparando consulta: " . mysqli_error($link));
        }

        // Añadimos un enlace más
        $_SESSION['hits'] = $userHits;
    }

    include_once("get_ip.php");
?>
