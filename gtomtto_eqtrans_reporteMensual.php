<?php
error_reporting(0);
session_start();
include('../lib/funciones.php');
include './layout.php';
$num_emp = validaUsuario();
$numbre_usu = nombreUsuario($num_emp);
$nivel_usu = nivelUsuario($num_emp);
//print_r($_POST);

if (!isset($_POST['mes']) || strlen($_POST['mes']) == 0) {
    $_POST['mes'] = date('m');
}

if (!isset($_POST['axo']) || strlen($_POST['axo']) == 0) {
    $_POST['axo'] = date('Y');
}

if (!isset($_POST['tipoFecha']) || strlen($_POST['tipoFecha']) == 0) {
    $_POST['tipoFecha'] = 'docto_fecha';
}


$meses = array(
    '01' => 'ENERO',
    '02' => 'FEBRERO',
    '03' => 'MARZO',
    '04' => 'ABRIL',
    '05' => 'MAYO',
    '06' => 'JUNIO',
    '07' => 'JULIO',
    '08' => 'AGOSTO',
    '09' => 'SEPTIEMBRE',
    '10' => 'OCTUBRE',
    '11' => 'NOVIEMBRE',
    '12' => 'DICIEMBRE'
);
$axos = array();
for ($i = date('Y'); $i > date('Y') - 4; $i--) {
    $axos[] = $i;
}

$tipoDocumneto = array("docto_fecha" => "Fecha documento", "docto_fecha_captura" => "Fecha de captura");


$con = conecta();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=edge" />
        <link href="../css/texto.css" href='../css/texto_reportes.css' rel="stylesheet" type="text/css">

            <script src="../js/rutinas.js"></script>
            <title>Mantenimiento Equipo de Transporte</title>

            <script>

                $(document).ready(function() {

                    $("#filtro").button();

                });

                function proceso_cambios(id_eqtrans) {
                    document.form1.id_eqtrans.value = id_eqtrans;
                    document.form1.action = "gtomtto_eqtrans_cambios.php";
                    document.form1.submit();
                }

                function validaformulario(fo) {
                    fo.action = 'gtomtto_eqtrans_reporteMensual.php';
                    fo.target = '_self';
                    if (fo.excel.value == 1) {
                        fo.target = '_blank';
                        fo.action = 'gtomtto_eqtrans_reporteMensual_tabla.php';
                    }
                    return true;
                }

            </script>
    </head>
    <style>
        select {
            background-color: #2168af;
            border: grey 1px solid;
            width: 123px;
            margin: 1px auto;
            font-weight: bold;
            color:white;
        }

        .encabezado th {

            font-weight: bold;
            text-align: center;
            font-size: 10pt;
            background: #2168af;
            border: 1px solid black;
            padding-bottom: 3px;
            padding-top: 3px;
            color: white;
        }

        .encabezado td {
            empty-cells: show;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
            border: 1px solid black;
            color: #000;
            padding: 5px;
        }

        #detalle td{
            empty-cells: show;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            border: 1px solid black;
            color: #000;

        }
        #detalle .numero{
            text-align: right;
        }
        #detalle .espacio{
            border: 0px;
        }

    </style>

    <body class="bbg">
        <form id="form1" name="form1" method="post" action="" onsubmit="return validaformulario(this)">
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fondoTabla">
                <thead>
                    <tr>
                        <td>
                            <fieldset><legend>B&uacute;squeda</legend>
                                <table id="seleccion" class="fondoTabla">
                                    <thead>
                                        <tr>
                                            <th>A&Ntilde;O</th>
                                            <th>MES</th>
                                            <th>FECHA</th>
                                            <td>GENERAR EXCEL</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>
                                                <select name='axo' id='axo'>
                                                    <?php
                                                    foreach ($axos as $key => $values) {
                                                        $s = "";
                                                        if (isset($_POST['axo']) && $values == $_POST['axo']) {
                                                            $s = " selected";
                                                        }
                                                        ?>
                                                        <option value='<?php echo $values; ?>' <?php echo $s; ?> ><?php echo $values; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name='mes' id='mes'>
                                                    <?php
                                                    foreach ($meses as $key => $values) {
                                                        if (isset($_POST['mes']) && strlen($_POST['mes']) > 0) {
                                                            $s = ($key == $_POST['mes']) ? "selected" : '';
                                                        } else {
                                                            $s = (date('m') == $key) ? "selected" : '';
                                                        }
                                                        ?>
                                                        <option value='<?php echo $key; ?>' <?php echo $s; ?> ><?php echo $values; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="tipoFecha" id="tipoFecha">
                                                    <?php
                                                    foreach ($tipoDocumneto as $key => $value) {
                                                        $s = (isset($_POST['tipoFecha']) && strlen($_POST['tipoFecha']) > 0 && $key == $_POST['tipoFecha']) ? "selected" : "";
                                                        ?>
                                                        <option value="<?php echo $key; ?>" <?php echo $s; ?>><?php echo $value; ?></option><?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name='excel' id="excel">
                                                    <option value="0">NO</option>
                                                    <option value="1">SI</option>
                                                </select>
                                            </td>
                                            <th><input type="submit" name='filtro' id='filtro' value="Buscar" class="txt10"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td height="91">
                            <?php
                            include_once 'gtomtto_eqtrans_reporteMensual_tabla.php';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <fieldset><legend>Men&uacute; Principal</legend>
                                <table>
                                    <tr>
                                        <td heigth='50' align="left">
                                            <input name="menu_anterior" type="button" id="menu_anterior" value="Regresar Men&uacute; Principal" onclick="proceso_menumttos();" class="txt10">
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>
<script>
    function proceso_menumttos()
    {
        document.form1.action = "../index.php";
        document.form1.submit();
    }
</script>