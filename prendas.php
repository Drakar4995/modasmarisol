<?php
session_start();
require_once 'Database.php';
$sql = "SELECT * from prendas";
$result = $conexion->query($sql);
?>
<form action="index.php" method="post">
    <input type="hidden" name="logout"></input>
    <button>Logout</button>
</form>

<form action="carrito.php" method="post">
    <input type="hidden" name="logout"></input>
    <button>Carrito</button>
</form>

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
    <?php echo '<h1?>Bienvenido ' . $_SESSION['username'] . '</h1>' ?>


    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <form action="carrito.php" method="POST">
            <div class="articulo">
                <input type="hidden" name="addItem">
                <input type="hidden" name="id" value="<?php echo $row['id'];  ?>">
                <div class="imagen"><img src="img/<?php echo $row['url'];  ?>" /></div>
                <div class="titulo"><?php echo $row['nombre'];  ?></div>
                <div class="precio">$<?php echo $row['precio'];  ?> €</div>
                <input type="number" name="cantidad" value="1">
                <div class="botones">
                    <button class='btn-add'>Agregar al carrito</button>
                </div>
            </div>
        </form>


    <?php } ?>

</body>

</html>