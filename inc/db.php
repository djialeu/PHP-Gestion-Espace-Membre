<?php
    $dbname = "tutophp";
    $host = "localhost";
    $user = "root";
    $pwd = "";

    try {
        $con =  new PDO("mysql:host=$host;dbname=$dbname" , "$user" , "$pwd" );
        $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
    } catch (PDOException $e) {
         print $e->getmessage();
    }
    
?>