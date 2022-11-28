<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ./index.php');
    exit();
}
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Available Colors">
    <meta name="description" content="">
    <title>Home</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link rel="stylesheet" href="Home.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 5.0.7, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,200,300,400,500,600,700,800,900">


    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "",
            "logo": "images/default-logo.png"
        }
    </script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Home">
    <meta property="og:type" content="website">
</head>

<body>
    <?php echo '<h1>Bienvenido ' . $_SESSION['username'] . '</h1>' ?>


    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <form action="carrito.php" method="POST">
            <div class="articulo">
                <input type="hidden" name="addItem">
                <input type="hidden" name="id" value="<?php echo $row['id'];  ?>">
                <div class="imagen"><img src="img/<?php echo $row['url'];  ?>" /></div>
                <div class="titulo"><?php echo $row['nombre'];  ?></div>
                <div class="precio"><?php echo $row['precio'];  ?> €</div>
                <input type="number" name="cantidad" value="1">
                <div class="botones">
                    <button class='btn-add'>Agregar al carrito</button>
                </div>
            </div>
        </form>


    <?php } ?>

</body>

</html>