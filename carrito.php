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
function getTotal()
{
    $total = 0;
    for ($i = 0; $i < sizeof($_SESSION['carrito']); $i++) {
        $total += $_SESSION['carrito'][$i]['subtotal'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-7">
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
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div>
                                                        <img src="images/<?php echo $row[$i]['url'];  ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                        </div>
                                                        <div class="ms-3">
                                                            <h5><?php echo $row[$i]['nombre']?></h5>
                                                            <p class="small mb-0">Precio unidad: <?php echo $row[$i]['precio']?>€</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center">
                                                        <div style="width: 150px;">
                                                            <h5 class="fw-normal mb-0">Cantidad: <?php echo $row[$i]['cantidad'];  ?></h5>
                                                        </div>
                                                        <div style="width: 80px;">
                                                            <h5 class="mb-0"><?php echo $row[$i]['subtotal'];  ?>€</h5>
                                                        </div>
                                                        <a href="#!" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endfor;?>

                                    

                                </div>
                                <div class="col-lg-5">

                                    <div class="card bg-warning text-white rounded-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-4">

                                                <img src="./images/logo-Paypal.png" alt="" width="200" height="100">
                                            </div>
                                            <form class="mt-4">
                                                <div class="form-outline form-white mb-4">
                                                    <input type="text" id="typeName" class="form-control form-control-lg" siez="17" placeholder="Cardholder's Name" />
                                                    <label class="form-label" for="typeName">Cardholder's Name</label>
                                                </div>

                                                <div class="form-outline form-white mb-4">
                                                    <input type="text" id="typeText" class="form-control form-control-lg" siez="17" placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />
                                                    <label class="form-label" for="typeText">Card Number</label>
                                                </div>

                                                <div class="row mb-4">
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
                                                </div>

                                            </form>

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
                                                <p class="mb-2"><?php echo getTotal()+20 ?>€</p>
                                            </div>

                                            <button type="button" class="btn btn-info bg-primary btn-block btn-lg">
                                                <div class="d-flex text-white justify-content-between">

                                                <span>Tramitar Pedido:<i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                    <span><?php echo getTotal()+20 ?>€  </span>
                                                </div>
                                            </button>

                                        </div>
                                    </div>

                                </div>
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