<?php
session_start();
require_once 'Database.php';
if (isset($_POST['addItem'])) {

    $idPrenda = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $sql = "SELECT * from prendas WHERE id='$idPrenda'";

    $result = $conexion->query($sql);

    $row = mysqli_fetch_assoc($result);

    $item = ["id" => $row['id'], "nombre" => $row['nombre'], "precio" => $row['precio'], "cantidad" => $cantidad, "url" => $row['url']];

    array_push($_SESSION['carrito'], $item);
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
    <?php $row = (array) $_SESSION['carrito'];
    if (sizeof($row) > 0) {
        for ($i = 0; $i < sizeof($row); $i++) { ?>
            <form action="">
                <div class="articulo">
                    <input type="hidden" name="id" value="<?php echo $row[$i]['id'];  ?>">
                    <div class="imagen"><img src="img/<?php echo $row[$i]['url'];  ?>" /></div>
                    <div class="titulo"><?php echo $row[$i]['nombre'];  ?></div>
                    <div class="precio">$<?php echo $row[$i]['precio'];  ?> €</div>
                    <input type="number" name="cantidad" value="1">
                </div>
            </form>
        <?php } ?>

    <?php } else {
        echo '<h1?>Aun no hay articulos en el carrito</h1>';
    } ?>

</body>

</html>