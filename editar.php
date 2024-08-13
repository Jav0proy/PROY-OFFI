<?php
include('conexion/conexion.php');
$con= connection();
//$consumo_saldo_actual=$_POST['consumo_saldo_actual'];

$consumo = $_POST['id_consumo'];
$equipo_transporte=$_POST['id_equipo_transporte'];
$saldo_actual_tarjeta=$_POST['ultimoValor'];

//print_r($_POST);

$i=0;
    foreach($_POST['id_consumo'] as $consumos){
    $consumo_importe= $_POST['saldo_importe'][$i];
    $consumo_anterior=$_POST['saldo_anterior'][$i];
    $consumo_saldo_actual=$_POST['saldo_actual'][$i];
    //$saldo_actual_tarjeta =$_POST['tar_saldo_actual'][$i];
    //$saldo_actual_tarjeta = isset($_POST['ultimoValor'][$i]) ? mysqli_real_escape_string($con, $_POST['ultimoValor'][$i]) : '';
    //$equipo_transporte = isset($_POST['id_equipo_transporte'][$i]) ? mysqli_real_escape_string($con, $_POST['id_equipo_transporte'][$i]) : '';
    $i++;
    //$saldo_actual_tarjetas[$saldo_actual_tarjeta] = $saldo_actual_tarjeta;
    //$equipo_transporte_i[$equipo_transporte] = $equipo_transporte;

    $sql= "UPDATE mtConsumoGasolinaPrueba SET 
    consumo_importe='$consumo_importe',
    consumo_saldo_anterior='$consumo_anterior',
    consumo_saldo_actual='$consumo_saldo_actual'
    WHERE id_consumo='$consumos'"; 
   // $query= mysqli_query($con, $sql);
   if(mysqli_query($con, $sql)){
    echo "Registro actualizado correctamente en mtConsumoGasolinaPrueba para id_consumo: $consumos<br><br>";
        } else {
            echo "Error al actualizar en mtConsumoGasolinaPrueba para id_consumo: $consumos - " . mysqli_error($con) . "<br><br>";
        }
    }
    $i=0;
    foreach ($_POST['id_equipo_transporte'] as $equipo) { 
        
       $saldo_actual_tarjeta=$_POST['ultimoValor'][0];
       $equipo_transporte=$_POST['id_equipo_transporte'][$i];

       //$saldo_actual_tarjeta = isset($_POST['ultimoValor'][$i]) ? mysqli_real_escape_string($con, $_POST['ultimoValor'][$i]) : '';
       $i++;
       //echo (count($saldo_actual_tarjeta)); 
       //print_r($saldo_actual_tarjeta);

       $sql_tarjeta = "UPDATE mtTarjetaPrueba
                        SET 
                            tar_saldo_actual = '$saldo_actual_tarjeta'
                        WHERE id_equipo_transporte = '$equipo'
                        and tar_status = 'A' ";

       /* $sql_tarjeta = "UPDATE mtTarjetaPrueba
        INNER JOIN mtConsumoGasolinaPrueba 
        ON mtTarjetaPrueba.id_equipo_transporte = mtConsumoGasolinaPrueba.id_equipo_transporte
        SET 
            mtTarjetaPrueba.tar_saldo_actual = '$saldo_actual_tarjeta'
        WHERE mtTarjetaPrueba.id_equipo_transporte = '$equipo'";*/

        if (mysqli_query($con, $sql_tarjeta)) {
            echo "Registro actualizado correctamente en mtTarjetaPrueba para id_equipo_transporte: $equipo_transporte<br><br>"."Saldo actual :$saldo_actual_tarjeta <br><br>";
        } else {
            echo "Error al actualizar en mtTarjetaPrueba para id_consumo: $consumos - " . mysqli_error($con) . "<br><br>";
        } 
    }
?>
<!DOCTYPE html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="refresh" content="0; URL=http://pru-dev.corprama.com.mx/javierjp/Buscar_placa_tarjeta/index.php" />-->
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <title></title>
</head>
<body>
    <div>
        <!--<h1>Datos Actualizados</h1>-->
    </div>
</body>
</html>