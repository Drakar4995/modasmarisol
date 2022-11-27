<?php
session_start();
require_once 'Database.php';
if (!isset($_SESSION['username'])) {

    if (isset($_POST['username']) && isset($_POST['password']) && (!is_null($_POST['username']) || !is_null($_POST['password']))) {

        $username = $_POST['username'];
        $pass = $_POST['password'];
        $pass = md5($pass);
        //"SELECT * FROM users WHERE user_name = '$uname' AND password='$pass' ";
        //SELECT * FROM `usuarios` WHERE username = "user" AND password = "81dc9bdb52d04dc20036dbd8313ed055";
        $sql = "SELECT * from usuarios WHERE username = '$username' AND password = '$pass'";

        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            var_dump($resultado);
            $_SESSION['username'] = $username;
            $_SESSION['carrito'] = array();
            header("location: ./prendas.php");
            exit();
        } else {
            $errorLogin = 'USUARIO NO ENCONTRADO';
        }
    }
} else {
    if (isset($_POST['logout'])) {
        session_start();
        //unset($_SESSION['user']);unset($_SESSION['carrito']);
        //unset($_SESSION["id"]);
        unset($_SESSION["username"]);
        unset($_SESSION['carrito']);
        header("Location:index.php");
        exit();
    }
    header("location:prendas.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/style.css">
    <title>Document</title>
</head>

<body>
    <form method="POST">
        <?php

        if (isset($errorLogin)) {
            echo $errorLogin;
        }

        ?>
        <h2>Iniciar sesión</h2>
        <p>Nombre de usuario: <br>
            <input type="text" name="username">
        </p>
        <p>Password: <br>
            <input type="password" name="password">
        </p>
        <p class="center"><input type="submit" value="Iniciar Sesión"></p>
        <p class="center">
            <a class="registrarse" href="signup.php">Registrate</a>
        </p>
    </form>

</body>

</html>