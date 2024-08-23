<?php 
include('conexion/conexion.php');
$con = connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ejemplo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>
<body>

<div class="container">
  <h2> Ejemplo Modal </h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Abrir Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Formulario Prueba</h4>
        </div>
        <div class="modal-body">
            <!--  Codigo dentro del modal -->
            <div>
               <form action="">
                <label>Nombre1</label>
                <input type="text">
                <button type="button" class="btn btn-default" data-dismiss="modal">Enviar</button> 
                </form>
            </div> 
          <p>Texto dentro del modal</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div> 
    </div>
  </div>
</div>

<div class="container">
  <h2> Ejemplo Modal2 </h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2">Abrir 2Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog" style="z-index: 1900">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Formulario Prueba</h4>
        </div>
        <div class="modal-body">
            <!--  Codigo dentro del modal -->
            <div>
               <form action="">
                <label >Nombre2</label>
                <input type="text"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Enviar</button> 
                </form>

            </div> 
          <p>Texto dentro del modal2</p> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <div class="container">
  <h2> Ejemplo Modal5 </h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal4">5Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog" style="z-index: 1900">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Formulario Prueba</h4>
        </div>
        <div class="modal-body">
            <!--  Codigo dentro del modal -->
            <div>
               <form action="">
                <label >Nombre2</label>
                <input type="text"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Enviar</button> 
                </form>

            </div> 
          <p>Texto dentro del modal2</p> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>  
            <!--  Codigo dentro del modal -->
            <?php 
    $equipo=$_GET['id_equipo_transporte'];

$sqlModal="SELECT
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
AND  j.id_equipo_transporte = '2376'
AND a.id_tarjeta != '1325'
ORDER BY a.id_consumo";

        //Query para mostrar todos los campos que queremos deacuerdo a la busqueda inicial, la busqueda se hace por num de placa. y se mandara por medio del id_consumo
    $queryModal= mysqli_query($con, $sqlModal);
    $totalRegistros = mysqli_num_rows($queryModal);
    if($totalRegistros == 0  ){
        // echo "No hay registros";
    }else{
  //echo " <h4> Placa : $num_placa </h4>"
    }
    //echo " Registros: $totalRegistros";
?>   
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal4">4pruebaModal</button>
<div id="myModal4" class="modal" style="z-index: 15-00">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2> Modal </h2>
        <!--<?php echo "<h2> Consumos registrados: <u> $num_placa </u> </h2> "?>
        <a href="indexV2.php">
        <input type="submit" class="btn btn-primary" name="regresar" id="regresar" value="Regresar">
        </a>-->
        <table class="table">
            <thead>
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
            </thead>
            <tbody>
                <tr> 
                <?php while($row= mysqli_fetch_array($queryModal)):?>
                <!--<th><?php echo $row['eqtrans_placa'] ?> </th>-->
                <th><?php echo $row['id_consumo'] ?></th>
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
                <th><a href="update.php?id_consumo=<?php echo $row['id_consumo'] ?>&id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?>&tar_numero=<?php echo $row['tar_numero'] ?>&id_tarjeta=<?php echo $row['id_tarjeta'] ?> " class="btn btn-primary">
                        <span title="Modificar consumo importe">Editar</span>
                    </a>
                    <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Modal</button>-->
                    
                    <!--<button type="submit" id="openModalBtn2" class="btn btn-primary" >  2Modal </button>-->
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2">2Modal</button>

                    </th>
                    </tr>
                    </tbody> 
            <?php endwhile; ?> 
        </table> 
    </div>
          <p>Texto dentro del modal3</p> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</body>
</html>
