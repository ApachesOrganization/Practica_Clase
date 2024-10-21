<?php
require_once('codes/conexion.inc');
session_start();

if ($_SESSION["autenticado"] != "SI") {
    header("Location:login.php");
    exit();
}

$auxSql = "SELECT * FROM products"; 
$regis = mysqli_query($conex, $auxSql) or die(mysqli_error($conex));
$nunFilas = mysqli_num_rows($regis);
?>

<!doctype html>
<html lang="en">

<head>
    <?php include_once('sections/head.inc'); ?>
    <meta http-equiv="refresh" content="180;url=codes/salir.php">
    <title>List of Products</title>
    <script>
        function insprod() {
            location.href = "agregarproducto.php"; 
        }
    </script>
</head>

<body class="container-fluid">
    <header class="row">
        <?php include_once('sections/header.inc'); ?>
    </header>

    <main class="row contenido">
        <div class="card tarjeta">
            <div class="card-header">
                <h4 class="card-title">Productos</h4>
            </div>
            <div class="card-body">
                <?php
                if ($nunFilas > 0) {
                    echo '<table class="table table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<td><strong>Código</strong></td>
                          <td><strong>Nombre</strong></td>
                          <td><strong>Descripción</strong></td>
                          <td><strong>Precio</strong></td>
                          <td colspan='2' align='center'><strong>Modificar</strong></td>";
                    echo "</tr>";
                    echo "</thead><tbody>";

                    while ($Tupla = mysqli_fetch_assoc($regis)) {
                        echo "<tr>";
                        echo "<td><a href='lstproductos.php?cod=" . $Tupla['ProductID'] . "'>" . $Tupla['ProductID'] . "</a></td>";
                        echo "<td>" . $Tupla['ProductName'] . "</td>";
                        echo "<td>" . $Tupla['Description'] . "</td>";
                        echo "<td>" . $Tupla['Price'] . "</td>";
                        echo "<td align='center'><a href='modificarproducto.php?cod=" . $Tupla['ProductID'] . "'>Editar</a></td>";
                        echo "<td align='center'><a href='borrarproducto.php?cod=" . $Tupla['ProductID'] . "'>Borrar</a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<h3>No hay datos disponibles</h3>";
                }
                ?>
                <button type="button" class="btn btn-sm btn-primary" onClick="insprod()">Agregar Producto</button>
            </div>
        </div>
    </main>

    <footer class="row pie">
        <?php include_once('sections/foot.inc'); ?>
    </footer>
</body>

</html>

<?php
if (isset($regis)) {
    mysqli_free_result($regis);
}
?>
