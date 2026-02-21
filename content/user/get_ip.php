<?php
    include_once("content/rosetta.php"); // Archivo de la base de datos

    // Conectar con la base de datos (si no estÃ¡ ya conectado desde rosetta.php)
    if (!isset($link)) {
        $link = mysqli_connect($db_host, $db_user, $db_pass, $bdd);
        if (!$link) {
            die("Error de conexiÃ³n: " . mysqli_connect_error());
        }
    }

    // FunciÃ³n para detectar paÃ­s
    function visitor_country() {
        $client  = $_SERVER['HTTP_CLIENT_IP'] ?? null;
        $forward = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
        $remote  = $_SERVER['REMOTE_ADDR'] ?? null;
        $result  = "Unknown";

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if ($ip_data && !empty($ip_data->geoplugin_countryName)) {
            $result = $ip_data->geoplugin_countryName;
        }

        return $result;
    }

    // Sacar nombre de usuario de la sesiÃ³n si existe
    $visitorUsername = $_SESSION['name'] ?? "";

    // Variables para insertar
    $userIP   = $_SERVER['REMOTE_ADDR'];
    $userDate = date('Y-m-d H:i:s');
    $country  = visitor_country();
    $browser  = $_SERVER['HTTP_USER_AGENT'];

    // Insertar en la base de datos con consulta preparada
    $sql = "INSERT INTO $tableVisitors (name, datetime, country, browser, user) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $userIP, $userDate, $country, $browser, $visitorUsername);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        error_log("Error preparando consulta: " . mysqli_error($link));
    }

    // Cerrar conexiÃ³n
    mysqli_close($link);
?>
