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
	    mtTarjetaPrueba as j
	    left JOIN mtConsumoGasolinaPrueba as a  ON a.id_tarjeta = j.id_tarjeta 
	    left JOIN mtEquipoTransportePrueba AS t ON j.id_equipo_transporte = t.id_equipo_transporte	
        WHERE
	    j.tar_status = 'A'
	    AND  j.id_equipo_transporte = '$equipo'
	    AND a.id_tarjeta != '1325'
        AND a.consumo_status='A'
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
    <title>Consumos</title>
</head>
<body>
    <div class="container" style="display: block;" id="recargar">
            <?php echo "<h2> Consumos registrados de placa: <u> $num_placa </u> </h2> "?>
            <a href="index.php">
            <input type="submit" class="btn btn-primary" name="regresar" id="regresar" value="Regresar">
            </a>
        <div>
            <table class="table"> 
                <tr>
                    <!-- <th>Placa</th> -->
                     <th>Id consumo</th> 
                    <!--<th>Num. tarjeta</th>-->
                    <!--<th>Estatus Tarjeta</th>-->
                    <th>Consumo ticket </th>
                    <th>Fecha carga</th>
                    <th>Consumo saldo anterior </th>
                    <th>Consumo importe </th>
                    <th>Consumo saldo actual </th> 
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
                <tr>
                    <?php while($row= mysqli_fetch_array($query)):?>
                    <!--<th><?php echo $row['eqtrans_placa'] ?> </th>-->
                    <th><?php echo $row['id_consumo'] ?> </th> 
                    <!--<th><?php echo $row['tar_numero'] ?></th>-->
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
                            <span title="Modificar consumo importe"><i class="bi bi-pencil-square"></i></span> </a>
                        </th>
                        <th>
                            <a href="delete.php?id_consumo=<?php echo $row['id_consumo'] ?>&id_equipo_transporte=<?php echo $row['id_equipo_transporte'] ?>&eqtrans_placa=<?php echo $row['eqtrans_placa'] ?>">
                            <span title="Borrar registro"><i class="bi bi-trash"></i></span>
                            </a>
                        </th>
                        <th>
                            <button class="btn btn-primary" onclick="location.reload()">Guardar</button>
                            </a>
                        </th> 
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <!--<div id="feedback-bg-info">
      <h3>Se recarga cada 10 segundos la página</h3>
      onclick="location.reload()" 
      <input type="button"  value="Recargar" onclick="location.reload()">
    </div>-->

    <script>
       //setInterval("location.reload()",10000);
      //setInterval("location.reload()",5000);
    </script>
    <script>
        /*
    var t=false;
    function contar(){
    if(t)clearTimeout(t);
    s=arguments[0] || 0;
    if(s>10)location.reload();
    s++;
    t=setTimeout("contar("+s+")",1000);
    }
    //console.log("se recargo");
    window.onload=document.onmousemove=contar;*/

    </script>
    <script>
       // setInterval("location.reload()",5000);
       /*
       setInterval(reloj, 5000);
        function reloj() {
        document.getElementById("feedback-bg-info").innerHTML += "";
        }*/

    </script>
    <!--
            <script>
           $(document).ready(function() {
             var refreshId =  setInterval( function(){
              $('#recargar').load('consumos.php');//actualizas el div
            }, 5000 );
            });
            </script>
                    -->

</body>
</html>