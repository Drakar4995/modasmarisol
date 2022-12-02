<?php
session_start();
require_once 'Database.php';
if (isset($_POST['detalles'])) {
    $id = $_POST['detalles'];
    //SELECT nombre,precio,cantidad,url from prendas NATURAL JOIN itemcompra WHERE itemcompra.idPrenda = prendas.id AND itemcompra.idCompra=1;
    $sql = "SELECT nombre,precio,cantidad,url,subtotal from prendas NATURAL JOIN itemcompra WHERE itemcompra.idPrenda = prendas.id AND itemcompra.idCompra='$id'";

    $sqlCompra = "SELECT * from compra WHERE id='$id'";

    $compra = mysqli_fetch_assoc($conexion->query($sqlCompra));

    $result = $conexion->query($sql);

    // while ($row = mysqli_fetch_assoc($result)) {
    //     //var_dump($row);
    // };
} else {
    header("location: compras.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Detalles de Compra</title>
</head>

<body class="u-body u-xl-mode">
    <?php include_once 'header.php'; ?>
</body>
<section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">
                            <div class="col-2"><br></div>
                            <div class="col-lg-8 align-self-center">
                                <h5 class="mb-3">
                                    <p class=" fs-2 mb-1 fw-bold">Id de la compra: <?php echo $compra['id'] ?></p>
                                </h5>
                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="mb-0 fs-5 fw-bold">Numero de Articulos: <?php echo $result->num_rows ?> </p>
                                    </div>
                                    <!-- <div>
                                            <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!" class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                                        </div> -->
                                </div>


                                <?php while ($row = mysqli_fetch_assoc($result)) :
                                    $subtotal += $row['subtotal'] ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div>
                                                        <img src="images/<?php echo $row['url'];  ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5><?php echo $row['nombre'] ?></h5>
                                                        <p class="small mb-0">Precio unidad: <?php echo $row['precio'] ?>€</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div style="width: 150px;">
                                                        <h5 class="fw-normal mb-0">Cantidad: <?php echo $row['cantidad'];  ?></h5>
                                                    </div>
                                                    <div style="width: 80px;">
                                                            <h5 class="mb-0"><?php echo $row['subtotal'];  ?>€</h5>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div >
                                    <p class="mb-0 fs-5 ">Subtotal: <?php echo $subtotal;  ?>€</p>
                                </div>
                                <div>
                                    <p class="mb-0 fs-5">Envio: 20.00€</p>
                                </div>
                                <div>
                                    <p class="mb-0 fs-5 fw-bold">Precio Total: <?php echo $compra['precioTotal'] ?>€</p>
                                </div>
                                <div class="form-outline mt-4">
                                    <a class="btn btn-primary btn-lg btn-block" href="compras.php">Volver a Compras</a>
                                </div>
                            </div>


                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
</section>

</html>