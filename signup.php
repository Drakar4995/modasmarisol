<?php
require_once 'Database.php';
session_start();
if(isset($_SESSION['username']))
{
    header("location: ./index.php");
    exit();
}

if (isset($_POST['registrarse'])) {

    $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

    $data = [
        'username' => trim($_POST["username"]),
        'email' => trim($_POST["email"]),
        'password' => trim($_POST["password"]),
        'cpassword' => trim($_POST["cpassword"]),
    ];
    //Validar los datos

    //Comprobamos que no esten vacios los datos
    if (
        empty($data['username']) || empty($data['email'])
        || empty($data['password']) || empty($data['cpassword'])
    ) {
        $errorRegistrarse = "Debes de introducir todos los campos";
    } else
        //Comprobamos que el email introducido tenga el formato correcto
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errorRegistrarse = "Debes de introducir un email valido";
        } else
        if (strlen($data['password']) < 4) {
            $errorRegistrarse = "La contraseña tiene que tener como minimo 4 caracteres";
        } else
        if ($data['password'] !== $data['cpassword']) {
            //La contraseña tiene que coincidir con la de la copia
            $errorRegistrarse = "Las contraseñas no coinciden";
        } elseif //Comprobamos que el usuario no exista
        (FindUserEmail($data["email"], $conexion)) {
            $errorRegistrarse = "El email ya esta registrado";
        } elseif (FindUserUsername($data["username"], $conexion)) {
            $errorRegistrarse = "El usuario ya esta registrado";
        } else {

            $data["password"] = md5($data["password"]);
            //Registramos al ususario
            registrar($data["username"], $data["email"], $data["password"], $conexion);
            header("location: ./index.php");
        }
    //Encriptamos la contraseña

    /*if () {
    
        header("location: ./login.php");
    } else {
        die("Ha ocurrido algun error");
    }*/
}

function registrar($username, $email, $password, $conexion)
{
    $sql = "INSERT INTO usuarios (username,email,password)VALUES('$username','$email','$password')";

    if ($conexion->query($sql)) {
        return true;
    } else {
        return true;
    }
}

function FindUserEmail($email, $conexion)
{

    $sql = "SELECT * from usuarios WHERE email='$email'";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function FindUserUsername($username, $conexion)
{   
    $sql = "SELECT * from usuarios WHERE username='$username'";

    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Modas Marisol</h1>
    <h2>Registro</h2>

    <?php if (isset($errorRegistrarse)) echo '<h2 style="color:red">' . $errorRegistrarse . '</h2>'; ?>
    <form method="POST">
        <label>Usuario</label> <br>
        <input type="hidden" name="registrarse">

        <input type="text" name="username"><br>
        <label for="">Email</label><br>
        <input type="text" name="email"><br>
        <label for="">Contraseña</label><br>
        <input type="password" name="password"><br>
        <label for="">Repita la Contraseña</label><br>
        <input type="password" name="cpassword"><br><br>

        <button type="submit">Registrate</button>
    </form>
</body>

</html>