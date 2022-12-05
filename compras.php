<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['username'])) {
    header('location: ./index.php');
    exit();
}

/**
 * Cuando paypal nos confirme el pago 
 * Creamos una compra
 */
if (isset($_GET['PayerID']) && !empty($_GET['PayerID'])) {
    $data = $_SESSION['data'];
    $nombre = $data['nombre'];
    $direccion = $data['direccion'];
    $paypal = $data['email'];
    $dni = $data['dni'];
    $total = $data['total'];
    $date = date('Y-m-d');
    $id = $_SESSION['id'];
    $sqlCompra = "INSERT INTO compra (nombre,direccion,paypal,dni,fecha,precioTotal,idUsuario)VALUES('$nombre','$direccion','$paypal','$dni','$date','$total','$id')";
    /**
     * Creamos la compra con los datos del usuario
     */
    try{

        $result = $conexion->query($sqlCompra);
    }catch(Exception $e){
        var_dump($e);
    }
    /**
     * Obtenemos la ultima compra creada
     */
    $sqlOrder = "SELECT id from compra ORDER BY id DESC ";
    
    $idCompra = mysqli_fetch_assoc($conexion->query($sqlOrder))['id'];
    

    $carrito = (array) $_SESSION['carrito'];
    /**
     * Añadimos los datos a la tabla de itemcompra
     * con la prenda y el id de la compra asociada
     */
    for ($i = 0; $i < sizeof($carrito); $i++) {
        $prendaId = $carrito[$i]['id'];
        $cantidad = $carrito[$i]['cantidad'];
        $subtotal = $carrito[$i]['subtotal'];
        $sqlItem = "INSERT INTO itemcompra (idCompra,idPrenda,cantidad,subtotal)VALUES('$idCompra','$prendaId','$cantidad','$subtotal')";
        $conexion->query($sqlItem);
    }
    /**
     * Borramos el carrito y los datos intermedios
     */
    $_SESSION['carrito']=[];
    unset($_SESSION['data']);
}
/**
 * Query para mostrar todas las compras que hay
 */
$id = $_SESSION['id'];
$sql = "SELECT * FROM compra WHERE idUsuario='$id'";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="u-body u-xl-mode" data-lang="en">
    <?php include_once 'header.php'; ?>
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="row">
                                <div class="col-2"> <br></div>
                                <div class="col-8 align-self-center">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class=" fs-2 mb-1 fw-bold">Compras</p>
                                        </div>
                                        <!-- <div>
                                            <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!" class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                                        </div> -->
                                    </div>

                                    <?php
                                    if ($result->num_rows > 0) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center">

                                                            <div class="ms-3">

                                                                <h5>Compra con id: <?php echo  $row['id'] ?></h5>
                                                                <p class="small mb-0">Nombre Comprador: <?php echo $row['nombre'] ?></p>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h5>Email PayPal: <?php echo  $row['paypal'] ?></h5>
                                                                <p class="small mb-0">Dni comprador: <?php echo $row['dni'] ?></p>
                                                            </div>
                                                            <div class="ms-4">
                                                                <form action="detalles.php" method="POST">
                                                                    <input type="hidden" value="<?php echo  $row['id'] ?>" name="detalles">
                                                                    <button class="btn btn-info bg-primary btn-block btn-lg text-white" type="submit">Detalles</button>
                                                                </form>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php } else {
                                        echo '<h1?>Aun no has realizado ninguna compra</h1>';
                                    } ?>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</body>

</html>