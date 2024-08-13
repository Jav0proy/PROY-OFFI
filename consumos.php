<?php
include('conexion/conexion.php'); //Se conecta a la base de datos, que esta en la carpeta de conexion y en el archivo de conexion.php.
        $con= connection();
        
        $equipo=$_GET['id_equipo_transporte'];
        $equipo_transporte=$_POST['id_equipo_transporte'];
        $ticket=$_GET['consumo_no_ticket'];
        $consumo_anterior=$_GET['consumo_saldo_anterior'];
        $consumo_importe=$_GET['consumo_importe'];
        $consumo_saldo_actual=$_GET['consumo_saldo_actual'];
        $num_placa=$_GET['eqtrans_placa'];
        $hora=$_GET['consumo_hora_reg'];
        $id_consumo=$_GET['id_consumo'];
        $id_tarjeta=$_GET['id_tarjeta'];
        $status_tarjeta=$_GET['tar_status'];

        $sql="SELECT
	a.id_equipo_transporte,
	a.consumo_no_ticket,
	a.consumo_saldo_anterior,
	a.consumo_importe,
	a.consumo_saldo_actual,
	a.id_consumo,
	a.id_tarjeta,
	t.eqtrans_placa,
	j.tar_status 
FROM
	 mtTarjetaPrueba as j
	left JOIN mtConsumoGasolinaPrueba as a  ON a.id_tarjeta = j.id_tarjeta 
	left JOIN mtEquipoTransportePrueba AS t ON j.id_equipo_transporte = t.id_equipo_transporte	
WHERE
	  j.tar_status = 'A'
	AND  j.id_equipo_transporte = '$equipo'
	AND a.id_tarjeta != '1325' 
ORDER BY
	a.id_consumo";
                //Query para mostrar todos los campos que queremos deacuerdo a la busqueda inicial, la busqueda se hace por num de placa. y se mandara por medio del id_consumo
            $query= mysqli_query($con, $sql);
            $totalRegistros = mysqli_num_rows($query);
            if($totalRegistros == 0  ){
                // echo "No hay registros";
                
            }else{
          //echo " <h4> Placa : $num_placa </h4>";
        
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Consumos</title>
</head>
<body>

    <div class="container" style="display: block;">
        <form action="index.php" method="POST" class="#">
        </form> 
        <div class="container" id="" style=" 'display: block;' ">
        <?php echo "<h2> Consumos Registrados De La Placa: ' $num_placa '</h2> "?>
        </div>
        <div>

        </div>
        <div>
        <table class="table">
                <tr>
                    <!-- <th>Placa</th> -->
                    <th>Id Consumo</th>
                    <th>Id Tarjeta</th>
                    <!--<th>Estatus Tarjeta</th>-->
                    <th>Consumo no Ticket </th>
                    <th>Consumo saldo anterior </th>
                    <th>Consumo Importe </th> 
                    <th>Consumo Saldo actual </th>
                    <th></th>
                </tr>
                <tr>
                <?php while($row= mysqli_fetch_array($query)):?>
                <!--<th><?php echo $row['eqtrans_placa'] ?> </th>-->
                <th><?php echo $row['id_consumo'] ?> </th>
                <th><?php echo $row['id_tarjeta'] ?>  
                </th>
                <!--<th><?php echo $row['tar_status'] ?></th>-->
                <th><?php echo $row['consumo_no_ticket'] ?> </th>
                <th><?php echo $row['consumo_saldo_anterior'] ?> </th>
                <th><?php echo $row['consumo_importe'] ?> </th> 
                <th><?php if($row['consumo_saldo_actual']=== null)
                    echo "0.00";
                else
                echo $row['consumo_saldo_actual'] ?> </th>
                <th></th>
                <th> <a href="update.php?id_consumo=<?php echo $row['id_consumo'] ?>&id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?>&id_tarjeta=<?php echo $row['id_tarjeta'] ?> ">
                    Editar </a></th>
                </tr>
                <?php endwhile; ?> 
        </table>
        </div> 
    </div>
    <!--
    <div>
        <div>
            <table class="">
                <tr>
                    <th>Id Tarjeta</th>
                </tr>
                <tr>
                <?php while($row= mysqli_fetch_assoc($query_tar)):?>
                    <th>
                        <select>
                            <option value=""><?php echo $row['id_tarjeta'] ?></option>
                            <option value=""><?php echo $row['id_tarjeta'] ?></option>
                        </select>
                    </th>
                </tr>
                <?php endwhile; ?> 
            </table>
        </div>
    </div>-->
</body>
</html>