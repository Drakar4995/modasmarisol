<?php
session_start();
require_once 'Database.php';
if(!isset($_SESSION['username'])){
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <form action="prendas.php">
        <button>Prendas</button>
    </form>
    <form action="index.php" method="post">
        <input type="hidden" name="logout"></input>
        <button>Logout</button>
    </form>
    <?php $row = (array) $_SESSION['carrito'];
    if (sizeof($row) > 0) { ?>
        <div class="row">

            <?php for ($i = 0; $i < sizeof($row); $i++) { ?>
                <form method="POST" action="carrito.php">
                    <div class="articulo">
                        <input type="hidden" name="" value="<?php echo $row[$i]['id'];  ?>">
                        <div class="imagen"><img src="img/<?php echo $row[$i]['url'];  ?>" /></div>
                        <div class="titulo"><?php echo $row[$i]['nombre'];  ?></div>
                        <div class="precio"><?php echo $row[$i]['precio'];  ?> €</div>
                        <div class="cantidad">Cantidad: <?php echo $row[$i]['cantidad'];  ?></div>
                        <div class="precio">Subtotal: <?php echo $row[$i]['subtotal'];  ?> €</div>

                        <div class="botones">
                            <button class='btn-add'>Agregar al carrito</button>
                        </div>
                    </div>
                </form>
            <?php } ?>

        </div>
        <form>
            <h1>Total: <?php echo getTotal() ?></h1>
        </form>
    <?php } else {
        echo '<h1?>Aun no hay articulos en el carrito</h1>';
    } ?>

</body>

</html>