<?php
 /**
 * Conexion al a bbdd
 */
    $conexion = mysqli_connect("localhost","root","","modasmarisol");

    if ($conexion->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
     // echo "Connected successfully";
