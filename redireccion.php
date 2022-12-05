<?php
session_start();
if (isset($_POST)) {
    /**
     * Redireccion antes de poder mandar los datos a 
     * paypal, ya que si no se pierden
     */
    $data = ["total"=>$_POST['total'],"nombre"=>$_POST['nombreComprador'],"email" => $_POST['email'], "direccion" => $_POST['address1'], "dni" => $_POST['dni']];
    
    $_SESSION['data'] = $data;
}
?>

<head>
    <script>
        function myFunction() {
            document.getElementById("enviar").submit();
        }
    </script>
</head>

<body onload="myFunction()">
        <!-- Formulario que se envia a paypal -->
    <form id="enviar" action="https://www.sandbox.paypal.com/es/cgi-bin/webscr" method="POST">

        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="rm" value="1">
        <input type="hidden" name="upload" value="1">
        <INPUT TYPE="hidden" NAME="return" value="http://localhost/modasmarisol/compras.php">
        <input type="hidden" name="address_override" value="1">
        <input type="hidden" name="cancel_return" value="http://localhost/modasmarisol/carrito.php">
        <input type="hidden" name="business" value="sb-tityc22009122@business.example.com">
        <!-- -------- --->
        <input type="hidden" name="item_name" value="Compra ModasMarisol">
        <input type="hidden" name="amount" value="<?php echo $_POST['total'] ?>">
        <input type="hidden" name="currency_code" value="EUR">
        <input type="hidden">
    </form>

</body>