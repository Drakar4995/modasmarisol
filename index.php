 <?php
    session_start();
    require_once 'Database.php';
    /**
     * Si el usuario no esta logeado
     */
    if (!isset($_SESSION['username'])) {

        if (isset($_POST['username']) && isset($_POST['password'])) { {
                /**
                 * Comprobamos que existan los datos para el login
                 */
                if ((!empty($_POST['username']) || !empty($_POST['password']))) {

                    /**
                     * Comprobamos que los datos no esten vacios
                     */
                    $username = $_POST['username'];
                    $pass = $_POST['password'];
                    $pass = md5($pass);
                
                    /**
                     * Lo buscamos en la bbdd y si coincide procedemos a logearlo
                     */
                    $sql = "SELECT * from usuarios WHERE username = '$username' AND password = '$pass'";

                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        /**
                         * Creamos las sessiones necesarias para el usuario
                         */
                        $user = mysqli_fetch_assoc($resultado);
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['carrito'] = array();
                        /**
                         * Se redirige a las prendas
                         */
            
                        header("location: ./prendas.php");
                        exit();
                    } else {
                        /**
                         * Error en caso de que no exista el usuario 
                         * o la contraseña no coincida
                         */
                        $errorLogin = 'Este usuario no existe';
                    }
                } else {
                    /**
                     * En caso de que no se rellenen todos los campos
                     */
                    $errorLogin = "Rellena todos los campos";
                }
            }
        } 
    }else {
        /**
         * En caso de que el usuario ya este logeado 
         * lo regirimos a la pagina de prendas
         */
        if (isset($_GET['logout'])) {
            /**
             * Para cuando exista la peticion de hacer un logout
             * borramos las sessiones y lo redirigimos al index.
             */
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