<?php

    $mysql = new mysqli(
        "localhost",
        "root",
        "",
        "app_db"
    );

    if ($mysql->connect_error){
        die("Failed to conncet" . $mysql->connect_error);
    
    }
?>