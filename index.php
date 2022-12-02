 <?php
    session_start();
    require_once 'Database.php';
    if (!isset($_SESSION['username'])) {

        if (isset($_POST['username']) && isset($_POST['password'])) { {
                if ((!empty($_POST['username']) || !empty($_POST['password']))) {
                    $username = $_POST['username'];
                    $pass = $_POST['password'];
                    $pass = md5($pass);
                    //"SELECT * FROM users WHERE user_name = '$uname' AND password='$pass' ";
                    //SELECT * FROM `usuarios` WHERE username = "user" AND password = "81dc9bdb52d04dc20036dbd8313ed055";
                    $sql = "SELECT * from usuarios WHERE username = '$username' AND password = '$pass'";

                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        $user = mysqli_fetch_assoc($resultado);
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['carrito'] = array();

                        header("location: ./prendas.php");
                        exit();
                    } else {
                        $errorLogin = 'Este usuario no existe';
                    }
                } else {
                    $errorLogin = "Rellena todos los campos";
                }
            }
        } 
    }else {
        if (isset($_GET['logout'])) {
            session_start();
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
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <script>

     </script>
 </head>

 <body>
     <form action="" method="POST">
         <section class="vh-100" style="background-color: #508bfc;">
             <div class="container py-5 h-100">
                 <div class="row d-flex justify-content-center align-items-center h-100">
                     <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                         <div class="card shadow-2-strong" style="border-radius: 1rem;">
                             <div class="card-body p-5 text-center">
                                 <?php if (isset($errorLogin)) echo '<div class="alert alert-danger" role="alert">' . $errorLogin . '</div>'; ?>
                                 <h3 class="mb-4">Inicia Sesion</h3>

                                 <div class="form-outline mb-4">
                                     <input type="text" name="username" class="form-control form-control-lg" />
                                     <label class="form-label" for="typeEmailX-2">Usuario</label>
                                 </div>

                                 <div class="form-outline mb-4">
                                     <input type="password" name="password" class="form-control form-control-lg" />
                                     <label class="form-label" for="typePasswordX-2">Contraseña</label>
                                 </div>

                                 <div class="form-outline mb-4">

                                     <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                                 </div>
                                 <div class="form-outline mb-4">

                                     <a class="btn btn-primary btn-lg btn-block" href="signup.php">Registrate</a>
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