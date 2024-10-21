<?php
require_once('codes/conexion.inc');
session_start();

if ($_SESSION["autenticado"] != "SI") {
    header("Location:login.php");
    exit();
}


$queryCategorias = "SELECT CategoryID, CategoryName FROM categories";
$resultCategorias = mysqli_query($conex, $queryCategorias);


$queryProveedores = "SELECT SupplierID, CompanyName FROM suppliers";
$resultProveedores = mysqli_query($conex, $queryProveedores);

if ((isset($_POST["OC_insertar"])) && ($_POST["OC_insertar"] == "formita")) {
    $auxSql = sprintf(
        "INSERT INTO products (ProductName, SupplierID, CategoryID, QuantityPerUnit, UnitPrice, UnitsInStock, UnitsOnOrder, ReorderLevel, Discontinued) 
        VALUES ('%s', %d, %d, '%s', %f, %d, %d, %d, %d)",
        $_POST['txtNombre'],
        (int)$_POST['txtSupplierID'],
        (int)$_POST['txtCategoryID'],
        $_POST['txtQuantityPerUnit'],
        (float)$_POST['txtPrecio'],
        (int)$_POST['txtUnitsInStock'],
        (int)$_POST['txtUnitsOnOrder'],
        (int)$_POST['txtReorderLevel'],
        isset($_POST['txtDiscontinued']) ? 1 : 0 
    );

    $Regis = mysqli_query($conex, $auxSql) or die(mysqli_error($conex));
    header("Location: lstproductos.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php include_once('sections/head.inc'); ?>
    <meta http-equiv="refresh" content="180;url=codes/salir.php">
    <title>Crear Producto</title>
</head>

<body class="container-fluid">
    <header class="row">
        <?php include_once('sections/header.inc'); ?>
    </header>

    <main class="row contenido">
        <div class="card tarjeta">
            <div class="card-header">
                <h4 class="card-title">Insertar Producto</h4>
            </div>
            <div class="card-body">
                <form method="post" name="formita" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Nombre del Producto</strong></td>
                            <td><input type="text" name="txtNombre" size="15" maxlength="50" required></td>
                        </tr>
                        <tr>
                            <td><strong>Proveedor ID</strong></td>
                            <td>
                                <select name="txtSupplierID" required>
                                    <option value="">Seleccione un Proveedor</option>
                                    <?php while ($row = mysqli_fetch_assoc($resultProveedores)): ?>
                                        <option value="<?php echo $row['SupplierID']; ?>"><?php echo $row['CompanyName']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Categoría ID</strong></td>
                            <td>
                                <select name="txtCategoryID" required>
                                    <option value="">Seleccione una Categoría</option>
                                    <?php while ($row = mysqli_fetch_assoc($resultCategorias)): ?>
                                        <option value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad por Unidad</strong></td>
                            <td><input type="text" name="txtQuantityPerUnit" required></td>
                        </tr>
                        <tr>
                            <td><strong>Precio</strong></td>
                            <td><input type="number" name="txtPrecio" step="0.01" required></td>
                        </tr>
                        <tr>
                            <td><strong>Unidades en Stock</strong></td>
                            <td><input type="number" name="txtUnitsInStock" required></td>
                        </tr>
                        <tr>
                            <td><strong>Unidades en Pedido</strong></td>
                            <td><input type="number" name="txtUnitsOnOrder" required></td>
                        </tr>
                        <tr>
                            <td><strong>Nivel de Reabastecimiento</strong></td>
                            <td><input type="number" name="txtReorderLevel" required></td>
                        </tr>
                        <tr>
                            <td><strong>Descontinuado</strong></td>
                            <td><input type="checkbox" name="txtDiscontinued" value="1"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Agregar Producto">
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="OC_insertar" value="formita">
                </form>
            </div>
        </div>
    </main>

    <footer class="row pie">
        <?php include_once('sections/foot.inc'); ?>
    </footer>
</body>

</html>
