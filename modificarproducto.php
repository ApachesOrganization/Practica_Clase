<?php
require_once('codes/conexion.inc');
session_start();

if ($_SESSION["autenticado"] != "SI") {
    header("Location:login.php");
    exit();
}


if (!isset($_GET['cod']) || empty($_GET['cod'])) {
    die("ID de producto no especificado.");
}


$productID = (int)$_GET['cod'];


$auxSql = "SELECT * FROM products WHERE ProductID = $productID";
$result = mysqli_query($conex, $auxSql) or die(mysqli_error($conex));
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Producto no encontrado.");
}

if (isset($_POST['OC_actualizar']) && $_POST['OC_actualizar'] == "formita") {
    
    $auxSql = sprintf(
        "UPDATE products SET 
        ProductName = '%s', 
        SupplierID = %d, 
        CategoryID = %d, 
        QuantityPerUnit = '%s', 
        UnitPrice = %f, 
        UnitsInStock = %d, 
        UnitsOnOrder = %d, 
        ReorderLevel = %d, 
        Discontinued = %d 
        WHERE ProductID = %d",
        $_POST['txtNombre'],
        (int)$_POST['txtSupplierID'],
        (int)$_POST['txtCategoryID'],
        $_POST['txtQuantityPerUnit'],
        (float)$_POST['txtPrecio'],
        (int)$_POST['txtUnitsInStock'],
        (int)$_POST['txtUnitsOnOrder'],
        (int)$_POST['txtReorderLevel'],
        (int)$_POST['txtDiscontinued'],
        $productID
    );

    $regis = mysqli_query($conex, $auxSql) or die(mysqli_error($conex));
    header("Location: lstproductos.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php include_once('sections/head.inc'); ?>
    <meta http-equiv="refresh" content="180;url=codes/salir.php">
    <title>Editar Producto</title>
</head>

<body class="container-fluid">
    <header class="row">
        <?php include_once('sections/header.inc'); ?>
    </header>

    <main class="row contenido">
        <div class="card tarjeta">
            <div class="card-header">
                <h4 class="card-title">Editar Producto</h4>
            </div>
            <div class="card-body">
                <form method="post" name="formita" action="<?php echo $_SERVER['PHP_SELF'] . '?cod=' . $productID; ?>">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Nombre del Producto</strong></td>
                            <td><input type="text" name="txtNombre" value="<?php echo htmlspecialchars($product['ProductName']); ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Proveedor ID</strong></td>
                            <td><input type="number" name="txtSupplierID" value="<?php echo $product['SupplierID']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Categoría ID</strong></td>
                            <td><input type="number" name="txtCategoryID" value="<?php echo $product['CategoryID']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad por Unidad</strong></td>
                            <td><input type="text" name="txtQuantityPerUnit" value="<?php echo htmlspecialchars($product['QuantityPerUnit']); ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Precio</strong></td>
                            <td><input type="number" name="txtPrecio" step="0.01" value="<?php echo $product['UnitPrice']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Unidades en Stock</strong></td>
                            <td><input type="number" name="txtUnitsInStock" value="<?php echo $product['UnitsInStock']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Unidades en Pedido</strong></td>
                            <td><input type="number" name="txtUnitsOnOrder" value="<?php echo $product['UnitsOnOrder']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Nivel de Reabastecimiento</strong></td>
                            <td><input type="number" name="txtReorderLevel" value="<?php echo $product['ReorderLevel']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><strong>Descontinuado</strong></td>
                            <td><input type="checkbox" name="txtDiscontinued" value="1" <?php echo $product['Discontinued'] ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Actualizar Producto">
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="OC_actualizar" value="formita">
                </form>
            </div>
        </div>
    </main>

    <footer class="row pie">
        <?php include_once('sections/foot.inc'); ?>
    </footer>
</body>

</html>

<?php
if (isset($result)) {
    mysqli_free_result($result);
}
?>
