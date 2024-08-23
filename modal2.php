<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo Modal</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos del modal */
        .modalfade{
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px; 
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Contenido de tu página -->
     
<!-- Botón que activa el modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Abrir Modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Título del Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
        $num_tarjeta=$_GET['tar_numero'];

        $sql="SELECT
	    a.id_equipo_transporte,
	    a.consumo_no_ticket,
	    a.consumo_saldo_anterior,
	    a.consumo_importe,
	    a.consumo_saldo_actual,
	    a.id_consumo,
	    a.id_tarjeta,
        a.consumo_fecha_carga,
	    t.eqtrans_placa,
	    j.tar_status,
        j.tar_numero
        FROM
	    mtTarjeta as j
	    left JOIN mtConsumoGasolina as a  ON a.id_tarjeta = j.id_tarjeta 
	    left JOIN mtEquipoTransporte AS t ON j.id_equipo_transporte = t.id_equipo_transporte	
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
<div class="container" style="display: block;">
    
    <div class="container" id="" style=" 'display: block;' ">
        <?php echo "<h2> Consumos registrados de placa: <u> $num_placa </u> </h2> "?>
        <a href="index.php">
        <input type="submit" class="btn btn-primary" name="regresar" id="regresar" value="Regresar">
        </a>
    </div>
    <div>
        <table class="table"> 
            <tr>
                <!-- <th>Placa</th> -->
                <th>Id consumo</th>
                <th>Num. tarjeta</th>
                <!--<th>Estatus Tarjeta</th>-->
                <th>Consumo no ticket </th>
                <th>Fecha carga</th>
                <th>Consumo saldo anterior </th>
                <th>Consumo importe </th>
                <th>Consumo saldo actual </th>
                <th>Editar</th>
            </tr>
            <tr>
                <?php while($row= mysqli_fetch_array($query)):?>
                <!--<th><?php echo $row['eqtrans_placa'] ?> </th>-->
                <th><?php echo $row['id_consumo'] ?> </th>
                <th><?php echo $row['tar_numero'] ?></th>
                <!--<th><?php echo $row['tar_status'] ?></th>-->
                <th><?php echo $row['consumo_no_ticket'] ?> </th>
                <th><?php echo $row['consumo_fecha_carga'] ?></th>
                <th><?php echo $row['consumo_saldo_anterior'] ?> </th>
                <th><?php echo $row['consumo_importe'] ?> </th>
                <th><?php if($row['consumo_saldo_actual']=== null)
                echo "0.00";
            else
            echo $row['consumo_saldo_actual'] ?> </th>
                
                <th><a href="update.php?id_consumo=<?php echo $row['id_consumo'] ?>&id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?>&tar_numero=<?php echo $row['tar_numero'] ?>&id_tarjeta=<?php echo $row['id_tarjeta'] ?>">
                        <span title="Modificar consumo importe">Editar</span> </a>
                    </th>
            </tr>
            <?php endwhile; ?> 
        </table>
    </div>
</div>
        




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

    <!-- Bootstrap y jQuery (necesario para el funcionamiento de los modales) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
  $(document).ready(function() {
    $('#exampleModal').on('shown.bs.modal', function () {
      console.log('El modal se ha mostrado.');
    });
  });
</script>

</body>
</html>

