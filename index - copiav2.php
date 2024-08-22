<?php
include('conexion/conexion.php');

// Conexión a la base de datos
$con = connection();

// Inicializar variables
$buscar = "";
$showSearchResults = false;

// Procesar formulario de búsqueda
if (isset($_POST['search'])) {
    $buscar = $_POST['busca'];

    if (!empty($buscar)) {
        $sql = "SELECT t.eqtrans_placa, a.consumo_saldo_actual, c.cliente_des_oficial, a.id_equipo_transporte,MAX(a.consumo_kilometraje_final) as consumo_kilometraje_final,mt.tar_saldo_actual,mt.tar_numero
                FROM auxiliares.mtEquipoTransporte AS t
                INNER JOIN auxiliares.mtConsumoGasolina AS a
                ON a.id_equipo_transporte = t.id_equipo_transporte
                LEFT JOIN tesoreria.gsCat_Cliente c
                ON a.id_cliente_cve = c.id_cliente_cve
                INNER JOIN auxiliares.mtTarjeta as mt 
                 on a.id_equipo_transporte=mt.id_equipo_transporte
                WHERE mt.tar_status = 'A'
                AND t.eqtrans_status = 'A'
                AND t.eqtrans_placa LIKE '%$buscar%'
                GROUP BY t.eqtrans_placa
                ORDER BY t.eqtrans_placa, c.cliente_des_oficial";
        $query = mysqli_query($con, $sql);
        $totalRegistros = mysqli_num_rows($query);
        $showSearchResults = true;
    } else {
        echo "No se ha Ingresado Placa a Buscar"; 
    } 
}
 
// Inicializar variables
$buscarT = "";
$showSearchResultsT = false;

// Procesar formulario de búsqueda
if (isset($_POST['searchT'])) {
    $buscarT = $_POST['buscaT'];
    
    if (!empty($buscarT)) {
        $sqlT = "SELECT t.eqtrans_placa, a.consumo_saldo_actual, c.cliente_des_oficial, a.id_equipo_transporte,MAX(a.consumo_kilometraje_final) as consumo_kilometraje_final,mt.tar_saldo_actual,mt.tar_numero
                FROM auxiliares.mtEquipoTransporte AS t
                INNER JOIN auxiliares.mtConsumoGasolina AS a
                ON a.id_equipo_transporte = t.id_equipo_transporte
                LEFT JOIN tesoreria.gsCat_Cliente c
                ON a.id_cliente_cve = c.id_cliente_cve
                INNER JOIN auxiliares.mtTarjeta as mt 
                 on a.id_equipo_transporte=mt.id_equipo_transporte
                WHERE mt.tar_status = 'A'
                AND t.eqtrans_status = 'A'
                AND mt.tar_numero LIKE '%$buscarT%'
                GROUP BY t.eqtrans_placa
                ORDER BY t.eqtrans_placa, c.cliente_des_oficial";
        $queryT = mysqli_query($con, $sqlT);
        $totalRegistrosT = mysqli_num_rows($queryT);
        $showSearchResultsT = true;
    } else {
        echo "No se ha ingresado tarjeta a buscar"; 
    }
}

// Consulta para obtener todos los registros si no se está buscando
$sql = "SELECT t.eqtrans_placa,c.cliente_des_oficial, a.id_equipo_transporte,MAX(a.consumo_kilometraje_final) as consumo_kilometraje_final,mt.tar_status,mt.tar_saldo_actual,mt.tar_numero
        FROM auxiliares.mtEquipoTransporte AS t
        INNER JOIN auxiliares.mtConsumoGasolina AS a
        ON a.id_equipo_transporte = t.id_equipo_transporte
        LEFT JOIN tesoreria.gsCat_Cliente as c
        ON a.id_cliente_cve = c.id_cliente_cve
        INNER JOIN auxiliares.mtTarjeta as mt 
        on a.id_equipo_transporte=mt.id_equipo_transporte 
        WHERE mt.tar_status = 'A'
        and t.eqtrans_status = 'A'
        GROUP BY t.eqtrans_placa
        ORDER BY t.eqtrans_placa, c.cliente_des_oficial";

$queryAll = mysqli_query($con, $sql);
$totalRegistrosAll = mysqli_num_rows($queryAll);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>BUSCADOR</title>
</head>
<body>

    <!-- Contenedor de búsqueda -->
    <div class="container"
        style="<?php echo !$showSearchResults && !$showSearchResultsT ? 'display: block;' : 'display: none;'; ?>">

        <div class="search-wrapper">
        <div class="search-radio">
                <h2>Selecciona opción a buscar</h2>
                <label>
                    <b> Placa </b>
                    <input type="radio" name="searchType" value="placa" onclick="toggleSearch('placa')" checked>
                    &nbsp 
                </label>
                <label>
                   <b> Tarjeta </b>
                    <input type="radio" name="searchType" value="tarjeta" onclick="toggleSearch('tarjeta')">
                </label>
            </div>
            <br>
            <!-- Formulario de búsqueda Por Placa -->
            <div id="searchSectionPlaca" class="search-section">
                <!--<h4>Buscar placa</h4>-->
                <form action="index.php" method="POST">
                    <div>
                        <input type="text" class="form-text" id="busca" name="busca" size="25"
                            placeholder="Ingrese placa" maxlength="30" value="<?php echo $buscar; ?>">
                        <input type="submit" class="btn btn-primary" name="search" id="search" value="Buscar">
                    </div>
                </form>
            </div>
            <!-- Formulario de búsqueda Por Tarjeta -->
            <div id="searchSectionTarjeta" class="search-section" style="display: none;">
                <!--<h4>Buscar tarjeta</h4>-->
                <form action="index.php" method="POST">
                    <div>
                        <input type="text" class="form-text" id="buscaT" name="buscaT" size="25"
                            placeholder="Ingrese # tarjeta" maxlength="30" value="<?php echo $buscarT; ?>">
                        <input type="submit" class="btn btn-primary" name="searchT" id="searchT" value="Buscar">
                    </div>
                </form>
            </div>
        </div>
       
    </div>
    <!-- Resultados de la búsqueda -->
    <div class="container" id="searchResults"
        style="<?php echo $showSearchResults ? 'display: block;' : 'display: none;'; ?>">
        <h2> Placa encontrada </h2>
        <a href="index.php">
            <input type="submit" class="btn btn-primary" name="placa" id="placa" value="Regresar">
            </a>
        <table class="table">
            <thead>
                <tr>
                    <th>Placa </th>
                    <th>Num. tarjeta</th>
                    <th>Sucursal asignada</th>
                    <th>Saldo actual tarjeta</th>
                    <!--<th>Kilometraje Inicial</th>-->
                    <th>Km. final</th>
                    <th>Ver consumos</th>
                    <!--<th>Regresar</th>-->
                </tr>
            </thead>
            <tbody>
                <?php if ($showSearchResults && $totalRegistros > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?php echo $row['eqtrans_placa']; ?></td>
                    <!--<td><?php echo $row['id_equipo_transporte']; ?></td>-->
                    <td><?php echo $row['tar_numero']; ?></td>
                    <td><?php echo $row['cliente_des_oficial']; ?></td>
                    <td><?php echo $row['tar_saldo_actual']; ?></td>
                    <!--<td><?php echo $row['consumo_kilometraje_inicial']; ?></td>-->
                    <td><?php echo $row['consumo_kilometraje_final']; ?></td>
                    <td><a
                            href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte']; ?>&eqtrans_placa=<?php echo $row['eqtrans_placa']; ?> "><span
                                title="Ver detalle de los consumos">Consumos</span></a></td>
                   <!-- <td>
                        <a href="index.php"><span
                        title="Regresa a la vista principal">Inicio</span></a>
                    </td>-->
                </tr>
                <?php endwhile; ?>
                <?php elseif ($showSearchResults && $totalRegistros == 0): ?>
                <tr>

                    <td colspan="7">No se encontraron registros</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Resultados de la búsqueda -->
    <div class="container" id="searchResultsT"
        style="<?php echo $showSearchResultsT ? 'display: block;' : 'display: none;'; ?>">
        <h2> Tarjeta encontrada </h2>
        <a href="index.php">
            <input type="submit" class="btn btn-primary" name="tarjeta" id="tarjeta" value="Regresar">
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th>Placa </th>
                    <th>Num. tarjeta</th>
                    <th>Sucursal asignada</th>
                    <th>Saldo actual tarjeta</th>
                    <!--<th>Kilometraje Inicial</th>-->
                    <th>Km. final</th>
                    <th>Ver consumos</th>
                    <!--<th>Regresar</th>-->  
                </tr>
            </thead>
            <tbody>
                <?php if ($showSearchResultsT && $totalRegistrosT > 0): ?>
                <?php while($row = mysqli_fetch_assoc($queryT)): ?>
                <tr>
                    <td><?php echo $row['eqtrans_placa']; ?></td>
                    <!--<td><?php echo $row['id_equipo_transporte']; ?></td>-->
                    <td><?php echo $row['tar_numero']; ?></td>
                    <td><?php echo $row['cliente_des_oficial']; ?></td>
                    <td><?php echo $row['tar_saldo_actual']; ?></td>
                    <!--<td><?php echo $row['consumo_kilometraje_inicial']; ?></td>-->
                    <td><?php echo $row['consumo_kilometraje_final']; ?></td>
                    <td><a href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte']; ?>&eqtrans_placa=<?php echo $row['eqtrans_placa']; ?> ">
                        <span title="Ver detalle de los consumos">Consumos</span></a>
                    </td>
                    <!--<td>
                    <a href="index.php"><span title="Regresa a la vista principal">Inicio</span></a>
                    </td>-->  
                </tr>
                <?php endwhile; ?>
                <?php elseif ($showSearchResultsT && $totalRegistrosT == 0): ?>
                <tr>
                    <td colspan="7">No se encontraron registros</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Todos los registros -->
    <div class="container" id="registros"
        style="<?php echo !$showSearchResults && !$showSearchResultsT ? 'display: block;' : 'display: none;'; ?>">
        <h2>Detalle placas activas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Num. tarjeta</th>
                    <th>Sucursal asignada</th>
                    <th>Saldo actual tarjeta</th>
                    <!--<th>Kilometraje Inicial</th>-->
                    <th>Km. final</th>
                    <!--<th>Status Tarjeta</th>-->
                    <th>Ver consumos</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($totalRegistrosAll > 0): ?>
                <?php while($row = mysqli_fetch_assoc($queryAll)): ?>
                <tr>
                    <td><?php echo $row['eqtrans_placa']; ?></td>
                    <!-- <td><?php echo $row['id_equipo_transporte']; ?></td>-->
                    <td><?php echo $row['tar_numero']; ?></td>
                    <td><?php echo $row['cliente_des_oficial']; ?></td>
                    <td><?php echo $row['tar_saldo_actual']; ?></td>
                    <!--<td><?php echo $row['consumo_kilometraje_inicial']; ?></td>-->
                    <td><?php echo $row['consumo_kilometraje_final']; ?></td>
                    <!--<td><?php echo $row['tar_status']; ?></td>-->
                    <td><a href="consumos.php?id_equipo_transporte=<?php echo $row['id_equipo_transporte']; ?>&eqtrans_placa=<?php echo $row['eqtrans_placa']; ?>"><span
                                title="Ver detalle de los consumos">Consumos</span>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7">No hay registros</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
    function toggleSearch(type) {
        var sectionPlaca = document.getElementById('searchSectionPlaca');
        var sectionTarjeta = document.getElementById('searchSectionTarjeta');

        if (type === 'placa') {
            sectionPlaca.style.display = 'block';
            sectionTarjeta.style.display = 'none';
        } else if (type === 'tarjeta') {
            sectionPlaca.style.display = 'none';
            sectionTarjeta.style.display = 'block';
        }
    }
    window.onload = function() {
        var selectedType = document.querySelector('input[name="searchType"]:checked').value;
        toggleSearch(selectedType);
    };
    </script>
</body>

</html>