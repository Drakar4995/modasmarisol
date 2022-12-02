<?php
session_start();
require_once 'Database.php';
if (!isset($_SESSION['username'])) {
    header('location: ./index.php');
    exit();
}
if (isset($_POST['addItem'])) {

    $idPrenda = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $sql = "SELECT * from prendas WHERE id='$idPrenda'";

    $result = $conexion->query($sql);

    $row = mysqli_fetch_assoc($result);
    $item = [
        "id" => $row['id'],
        "nombre" => $row['nombre'],
        "precio" => $row['precio'],
        "cantidad" => (int)$cantidad,
        "subtotal" => 0,
        "url" => $row['url']
    ];
    $esta = false;
    $subtotal = 0;
    $total = 0;
    for ($i = 0; $i < sizeof($_SESSION['carrito']); $i++) {
        $tempCarrito = $_SESSION['carrito'][$i];
        if ($tempCarrito['id'] === $item["id"]) {
            $_SESSION['carrito'][$i]['cantidad'] += $item['cantidad'];
            $_SESSION['carrito'][$i]['subtotal'] = $_SESSION['carrito'][$i]['cantidad'] * $item['precio'];
            $esta = true;
        }
    }

    if (!$esta) {
        $item['subtotal'] = (float) $item['precio'] * $cantidad;
        array_push($_SESSION['carrito'], $item);
    }
}

if (isset($_GET['eliminar'])) {

    $id = $_GET['eliminar'];

    for ($i = 0; $i < sizeof($_SESSION['carrito']); $i++) {
        $producto = $_SESSION['carrito'][$i];
        if ($producto['id'] == $id) {

            if ($producto['cantidad'] > 1) {
                $_SESSION['carrito'][$i]['cantidad']--;
                $_SESSION['carrito'][$i]['subtotal'] = $_SESSION['carrito'][$i]['cantidad'] * $producto['precio'];
            } else {
                array_splice($_SESSION['carrito'], $i, 1);
            }
        }
    }
}

function getTotal()
{
    $total = 0;
    for ($i = 0; $i < sizeof($_SESSION['carrito']); $i++) {
        $total += $_SESSION['carrito'][$i]['subtotal'];
    }
    return $total;
}
$items = [];

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script>
        function myFunction() {
            document.getElementById("GFG").submit();
        };
    </script>
</head>

<body class="u-body u-xl-mode" data-lang="en">
    <?php include_once 'header.php' ?>
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">
                            <form id="GFG" action="redireccion.php" method="POST">
                                <div class="row">

                                    <!-- Valores para paypal -->
                                    
                                    <div class="col-lg-8">
                                        <h5 class="mb-3"><a href="prendas.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Continua Comprando</a></h5>
                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="mb-1">Carrito de Compra</p>
                                                <p class="mb-0">Tienes <?php echo sizeof($_SESSION['carrito']) ?> prendas en el carrito</p>
                                            </div>
                                            <!-- <div>
                                            <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!" class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                                        </div> -->
                                        </div>

                                        <?php $row = (array) $_SESSION['carrito'];
                                        if (sizeof($row) > 0) { ?>
                                            <?php for ($i = 0; $i < sizeof($row); $i++) : ?>
                                                
                                                <div class="card mb-3">

                                                    <div class="position-absolute top-0 end-0">
                                                        <a href="carrito.php?eliminar=<?php echo $row[$i]['id'] ?>" class="btn btn-outline-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">


                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex flex-row align-items-center">


                                                                <div>
                                                                    <img src="images/<?php echo $row[$i]['url'];  ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                                </div>
                                                                <div class="ms-3">
                                                                    <h5><?php echo $row[$i]['nombre'] ?></h5>
                                                                    <input type="hidden" name="nombre" value="<?php echo $row[$i]['nombre'] ?>">
                                                                    <p class="small mb-0">Precio unidad: <?php echo $row[$i]['precio'] ?>€</p>

                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-row align-items-center">
                                                                <div style="width: 150px;">
                                                                    <h5 class="fw-normal mb-0">Cantidad: <?php echo $row[$i]['cantidad'];  ?></h5>
                                                                </div>
                                                                <div style="width: 80px;">
                                                                    <h5 class="mb-0"><?php echo $row[$i]['subtotal'];  ?>€</h5>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                array_push($items, $item) ?>
                                            <?php endfor; ?>



                                    </div>
                                    <div class="col-lg-4">

                                        <div class="card bg-warning text-white rounded-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-4">

                                                    <img src="./images/logo-Paypal.png" alt="" width="200" height="100">
                                                </div>
                                                <div class="mt-4">
                                                    <div class="form-outline form-white mb-4">
                                                        <input value="<?php $_SESSION['email'] ?>" type="email"name="email" id="email" class="form-control form-control-lg" siez="17" placeholder="Email PayPal" />
                                                        <label class="form-label">Email</label>
                                                    </div>

                                                    <div class="form-outline form-white mb-4">
                                                        <input type="text" name="nombreComprador" id="nombre" class="form-control form-control-lg" siez="17" placeholder="Nombre"  maxlength="80" />
                                                        <label class="form-label">Nombre</label>
                                                    </div>
                                                    <div class="form-outline form-white mb-4">
                                                        <input type="text" name="address1" id="direccion" class="form-control form-control-lg" siez="17" placeholder="Direcion"  maxlength="90" />
                                                        <label class="form-label">Direccion</label>
                                                    </div>
                                                    <div class="form-outline form-white mb-4">
                                                        <input maxlength="9" minlength="9" type="text" name="dni" id="dni" class="form-control form-control-lg" siez="17" placeholder="DNI" />
                                                        <label class="form-label">DNI</label>
                                                    </div>
                                                    <!-- <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="form-outline form-white">
                                                            <input type="text" id="typeExp" class="form-control form-control-lg" placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />
                                                            <label class="form-label" for="typeExp">Expiration</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-outline form-white">
                                                            <input type="password" id="typeText" class="form-control form-control-lg" placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                                                            <label class="form-label" for="typeText">Cvv</label>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                </div>

                                                <hr class="my-4">

                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2">Subtotal</p>
                                                    <p class="mb-2"><?php echo getTotal() ?>€</p>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2">Envio</p>
                                                    <p class="mb-2">20.00€</p>
                                                </div>

                                                <div class="d-flex justify-content-between mb-4">
                                                    <p class="mb-2">Total</p>

                                                    <p class="mb-2"><?php echo getTotal() + 20 ?>€</p>
                                                </div>

                                                <button onclick="myFunction()" class="btn btn-info bg-primary btn-block btn-lg">
                                                    <div class="d-flex text-white justify-content-between">
                                                        <input type="hidden" name="total" value="<?php echo getTotal()+20 ?>">
                                                        <span>Tramitar Pedido:<i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                        <span><?php echo getTotal() + 20 ?>€ </span>
                                                    </div>
                                                </button>

                                            </div>
                                        </div>

                                    </div>
                                    
                            </form>
                        <?php } else {
                                            echo '<h1?>Aun no hay articulos en el carrito</h1>';
                                        } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</body>

</html>