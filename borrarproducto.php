<?php
require_once('codes/conexion.inc');
session_start();

if ($_SESSION["autenticado"] != "SI") {
    header("Location:login.php");
    exit();
}

if (isset($_GET['cod'])) {
    $codigo = $_GET['cod'];
    $auxSql = sprintf("DELETE FROM products WHERE ProductID = %s", $codigo);
    mysqli_query($conex, $auxSql) or die(mysqli_error($conex));
}

header("Location: lstproductos.php");
exit();
?>
