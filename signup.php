<?php
require_once 'Database.php';
session_start();
if (isset($_SESSION['username'])) {
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script>

    </script>
</head>

<body>
    <form method="POST">
        <section class="vh-100" style="background-color: #508bfc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <!-- <h3 class="mb-5">Modas Marisol</h3> -->
                                <div class="form-outline mb-4">

                                <h5 class="mb-3">¡Registrate!</h5>
                                <img src="images/logo.jpeg" class="u-logo-image u-logo-image-1" style="width:200px; height:75x">
                                </div>
                                
                                <input type="hidden" name="registrarse">
                                <div class="form-outline mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" />
                                    <label class="form-label" for="typeEmailX-2">Usuario</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="text" name="email" class="form-control form-control-lg" />
                                    <label class="form-label">Email</label>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" />
                                    <label class="form-label">Contraseña</label>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" name="cpassword" class="form-control form-control-lg" />
                                    <label class="form-label">Repita la contraseña</label>
                                </div>
                                <div class="form-outline mb-4">

                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Registrarse</button>
                                </div>
                                <div class="form-outline mb-4">

                                    <a class="btn btn-primary btn-lg btn-block" href="index.php">¿Ya tienes cuenta?</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</body>

</html>