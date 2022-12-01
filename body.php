
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
                        <div class="imagen"><img src="images/<?php echo $row[$i]['url'];  ?>" /></div>
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