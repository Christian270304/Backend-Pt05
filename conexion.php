<?php
    // Christian Torres Barrantes

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pt02_christian_torres";

    try {
        // Cremos una conexion PDO.
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
?>