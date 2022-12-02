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

<!DOCTYPE html>
<html lang="en">

<head>

    <script>
        function myFunction(id) {
            document.getElementById("GFG" + id).submit()
        };
    </script>

</head>

<body class="u-body u-xl-mode" data-lang="en">
    <?php include_once 'header.php'; ?>
    <section class="u-clearfix u-section-1" id="carousel_4d9b">
        <div class="u-clearfix u-sheet u-sheet-1">
            <div class="u-align-center u-container-style u-group u-group-1">
                <div class="u-container-layout u-valign-middle u-container-layout-1">
                    <h2 class="u-custom-font u-font-roboto-slab u-text u-text-1">Prendas Disponibles</h2>
                    <h6 class="u-text u-text-custom-color-2 u-text-2">Selecciona tus prendas</h6>
                </div>
            </div>
            <div class="u-clearfix u-gutter-20 u-layout-wrap u-layout-wrap-1">
                <div class="u-layout">
                    <div class="u-layout-row">

                        <!-- ESTE ES EL PRODUCTO A CAMBIAR -->
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>

                            <div class="u-container-style u-expand-resize u-layout-cell u-left-cell u-size-20 u-size-20-md u-layout-cell-1">
                                <div class="u-container-layout u-container-layout-2">
                                    
                                    <form id="GFG<?php echo $row['id'] ?>" action="carrito.php" method="POST">
                                        <input type="hidden" name="addItem">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

                                        <img class="u-image u-image-1" style="background: #fff;" src="images/<?php echo $row['url'] ?>">
                                        <h4 class="u-align-center u-text u-text-custom-color-2 u-text-3"><?php echo $row['nombre'] ?>
                                        </h4>
                                        <p class="u-align-center u-text u-text-4" style="margin-bottom:10px;"><?php echo $row['precio'];  ?> €</p>
                                        <h4 class="u-align-center u-text u-text-custom-color-2 u-text-3">Cantidad
                                        </h4>
                                        <div class="u-align-center u-text u-text-4" style="margin-bottom: 10px;">
                                            <input style="width: 100px;height:30px" type="number" name="cantidad" min="1" value="1" width="100">
                                        </div>

                                        <a onclick="myFunction(<?php echo $row['id'] ?>)" style="margin-left:60px; margin-top:5px" class="u-active-none u-btn u-button-style u-hover-none u-none u-text-hover-palette-2-base u-text-palette-1-base u-btn-1">
                                            <span class="u-icon u-text-palette-2-base">

                                                <svg class="u-svg-content" viewBox="0 0 511.334 511.334" style="width: 1em; height: 1em">
                                                    <path d="m506.887 114.74c-3.979-5.097-10.086-8.076-16.553-8.076h-399.808l-5.943-66.207c-.972-10.827-10.046-19.123-20.916-19.123h-42.667c-11.598 0-21 9.402-21 21s9.402 21 21 21h23.468l23.018 256.439c.005.302-.01.599.007.903.047.806.152 1.594.286 2.37l.842 9.376c.016.177.034.354.055.529 2.552 22.11 13.851 41.267 30.19 54.21-8.466 10.812-13.532 24.407-13.532 39.172 0 35.106 28.561 63.667 63.666 63.667 35.106 0 63.667-28.561 63.667-63.667 0-7.605-1.345-14.9-3.801-21.667h114.936c-2.457 6.767-3.801 14.062-3.801 21.667 0 35.106 28.561 63.667 63.667 63.667s63.667-28.561 63.667-63.667-28.561-63.667-63.667-63.667h-234.526c-15.952 0-29.853-9.624-35.853-23.646l335.608-19.724c9.162-.538 16.914-6.966 19.141-15.87l42.67-170.67c1.567-6.272.158-12.918-3.821-18.016z"></path>
                                                </svg><img /></span>&nbsp;Añadir al carrito
                                        </a>
                                    </form>

                                </div>
                            </div>
                        <?php endwhile ?>
                        <!-- Fin del producto -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-6c94">
        <div class="u-clearfix u-sheet u-sheet-1">
            <p class="u-small-text u-text u-text-variant u-text-1">® Modas Marisol </p>
        </div>
    </footer>


</body>

</html>