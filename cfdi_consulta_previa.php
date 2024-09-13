<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/texto.css" rel="stylesheet" type="text/css">
<title>Facturación / Consulta Facturas</title>
<script src="../js/rutinastmp.js"></script>
<script type="text/javascript" src="../jscalendar/calendar.js"></script>
<script type="text/javascript" src="../jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="../jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="../js/rutinasA.js"></script>
<style type="text/css"> 
@import url("../jscalendar/calendar-blue2.css");
table {
            border-collapse: collapse;
            background-color: white;
        }
</style>
<?php 
#print_r($_POST);echo "<br>";
include('../lib/funciones.php');
$conexion = conecta();
$num_emp=$_POST['num_emp'];
#$num_emp=900518;
#$num_emp=validaUsuario();
#$area_usu=areaUsuario($num_emp);
$nombre_usu=nombreUsuario($conexion, $num_emp);

function GetUuid($xmlString){
  $doc = new DOMDocument;
  $doc->loadXML($xmlString);
  $rows = $doc->getElementsByTagName('TimbreFiscalDigital');
  return $rows->item(0)->getAttribute('UUID');
}

?>
<script>
function manda_asigna(){
	var error=0;
	var met=window.document.getElementById('metodopago').value;
	if(met==''){
		error++;
		alert('Falta el metodo de pago');
	}
	
	if(error==0){
		if(confirm('Confirma que desea continuar?\n\nSe asignar\u00E1 el metodo de pago seleccionado\n\n a TODOS estos CFDIs')){
			window.document.getElementById('recuperar').value=0;
			window.document.getElementById('asignar').value=1;
			document.facturas.submit();
		}
	}
	else{
		document.facturas.recuperar.value=0;
		document.facturas.asignar.value=0;
	}
}

function manda(){
	var error=0;
	
	if(error==0){
		if(confirm('Confirma que desea continuar?\n\nSe sellar\u00E1n TODOS estos CFDIs')){
			window.document.getElementById('asignar').value=0;
			window.document.getElementById('recuperar').value=1;
			document.facturas.submit();
		}
	}
	else{
		document.facturas.recuperar.value=0;
		document.facturas.asignar.value=0;
	}
}

function lleva(programa){
	document.facturas.action=programa;
	document.facturas.submit();
	return;
}
</script>
</head>

<body>
	<div align="center">
  <span class="tituloSistema">Sistema de Facturación Interna</span>
  <form id="facturas" name="facturas" method="post" action="">
  <input type="hidden" name="recuperar" id="recuperar"/>
  <input type="hidden" name="asignar" id="asignar"/>
  <input type="hidden" name="num_emp" id="num_emp" value="<?php echo $num_emp ?>"/>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="fondoTabla">
    <tr>
      <td align="center" valign="middle">
	  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="fondoTabla">
        <tr>
          <td height="40" colspan="7" align="center" class="tituloTabla">Consulta de documentos para sellar </td>
        </tr>
        <tr class="tituloFila">
          <td colspan="7" align="left" nowrap="nowrap">Usuario: <?php echo $nombre_usu ?></td>
        </tr>
		<tr>
          <td align="right" nowrap="NOWRAP" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
        </tr>  

        <tr><td></td>
          <!--<td align="right" nowrap="NOWRAP" class="txt10"><strong>Fecha  Inicial :
              <label> </label>
          </strong>     
            <label></label></td>
          <td class="txt10"><input name="fechaf_inicial" class="txt10" type="text" id="fechaf_inicial" size="12" maxlength="10" onblur="divide_fecha(this,'Fecha Inicial');" value="<?php 
	if(isset($_POST['fechaf_inicial'])){echo $_POST['fechaf_inicial'];} 
			  ?>">&nbsp;<input name="image" type="image" id="cal-button-1" value="..." src="../jscalendar/images/calendar5.gif">
  <script type="text/javascript">
  Calendar.setup({
  inputField    : "fechaf_inicial",  // id of the input field
  button        : "cal-button-1",
  align         : "Bl",           // alignment (defaults to "Bl") Tl
  ifFormat      : "%Y-%m-%d",     // format of the input field (even if hidden, this format will be honored)
  displayArea   : "show_f1",       // ID of the span where the date is to be shown
  daFormat      : "%A, %B %d, %Y", // format of the displayed date
  dateStatusFunc : function (date) { // disable weekend days (Saturdays == 6 and Subdays == 0)
  /*return (date.getDay() == 6 || date.getDay() == 0) ? true :*/ false;  }
  });
</script></td>-->
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10"><strong>Serie:</strong></td>
          <td class="txt10"><?php
		$rs_s=series($conexion);
		$num_rows=mysqli_num_rows($rs_s);
		#echo "num_rows=".$num_rows."<br>";
		?><select name="serie" id="serie" class="txt10">
		  <option value="">-----</option>
              <?php
			  	$sel="";
				while($row_RSs = mysqli_fetch_assoc($rs_s)){
					if($row_RSs['ps_serie']==$_POST['serie']){$sel=" selected";}else{$sel="";}
				?>
              <option value="<?php echo $row_RSs['ps_serie'] ?>" <?php echo $sel ?>><?php echo $row_RSs['ps_serie'] ?></option>
              <?php
				}
			  ?>
        </select>
			  </td>
        <td nowrap="nowrap" class="txt10">&nbsp; </td>
        <td class="txt10"><label></label></td>
        </tr>
        <tr>
            <td></td>
          <!--<td align="right" nowrap="NOWRAP" class="txt10"><strong>Fecha  Final :</strong></td>
          <td class="txt10"><label>
            <input name="fechaf_final" class="txt10" type="text" id="fechaf_final" size="12" maxlength="10" onblur="divide_fecha(this,'Fecha Final');" value="<?php 
			if(isset($_POST['fechaf_final'])){echo $_POST['fechaf_final'];} ?>" />
            <input name="image_2" type="image" id="cal-button-1_2" value="..." src="../jscalendar/images/calendar5.gif" />
            <script type="text/javascript">
  Calendar.setup({
  inputField    : "fechaf_final",  // id of the input field
  button        : "cal-button-1_2",
  align         : "Bl",           // alignment (defaults to "Bl") Tl
  ifFormat      : "%Y-%m-%d",     // format of the input field (even if hidden, this format will be honored)
  displayArea   : "show_f1",       // ID of the span where the date is to be shown
  daFormat      : "%A, %B %d, %Y", // format of the displayed date
  dateStatusFunc : function (date) { // disable weekend days (Saturdays == 6 and Subdays == 0)
  /*return (date.getDay() == 6 || date.getDay() == 0) ? true :*/ false;  }
  });
            </script>
          </label></td>-->
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10" height="20"><strong>Folio Inicial:</strong></td>
          <td class="txt10"><label>
            <input name="folio_inicial" class="txt10" type="text" id="folio_inicial" size="12" maxlength="10" value="<?php if(isset($_POST['folio_inicial'])){echo $_POST["folio_inicial"];} ?>" />
          </label></td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
        </tr>
        <!--
        <tr>
          <td align="right" nowrap="NOWRAP" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10"><strong>Folio Final:</strong></td>
          <td class="txt10"><input name="folio_final" class="txt10" type="text" id="folio_final" size="12" maxlength="10" value="<?php if(isset($_POST['folio_final'])){echo $_POST["folio_final"];} ?>" /></td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
        </tr>-->

        <tr>
          <td align="right" nowrap="NOWRAP" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
        </tr>
		
		      <tr>
          <td></td>
          <td align="right" nowrap="NOWRAP" class="txt10"><input name="button" type="button" class="txt10" onclick="lleva('http://pru.corprama.com.mx/facturacion/');" value="Menu Principal" /></td>
          <!--<td class="txt10">&nbsp;</td>-->
          <!--<td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">&nbsp;</td>-->
          <td>
          <td>
		      <input type="button" class="txt10" value="Consultar" onclick="document.facturas.submit();">
		     </td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
        </tr>
		    <tr>
          <td align="right" nowrap="NOWRAP" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
        </tr>		
        <tr>
          <td colspan="7" align="center" valign="top" nowrap="nowrap" class="txt10"><hr size="1" class="txt10"/></td>
          </tr>
        </table>
          </td>
          </tr>
          <?php
          if (!empty($_POST)){//GERERANDO CONSULTA	  
          ?>
          <tr>
            <td align="center" nowrap="nowrap">
          <?php
      
		/*$and_fecha="";
	  	if(isset($_POST['fechaf_inicial']) && $_POST['fechaf_inicial']!=""){
			$and_fecha.=" AND DATE(b.bit_fecha_creada)>='".$_POST['fechaf_inicial']."'";
		}
		if(isset($_POST['fechaf_final']) && $_POST['fechaf_final']!=""){
			$and_fecha.=" AND DATE(b.bit_fecha_creada)<='".$_POST['fechaf_final']."'";
		}
		
	  	$and_folio="";
	  	if(isset($_POST['folio_inicial']) && $_POST['folio_inicial']>0){
			$and_folio.=" AND b.bit_folio>=".$_POST['folio_inicial']."";
		}
		if(isset($_POST['folio_final']) && $_POST['folio_final']>0){
			$and_folio.=" AND b.bit_folio<=".$_POST['folio_final']."";
		}
		
		$and_serie="";
	  	if(isset($_POST['serie']) && $_POST['serie']!=""){
			$and_serie.=" AND b.bit_serie='".$_POST['serie']."'";
		}*/
		
		/*$RSa = buscaBitacoraComprobanteTest($conexion, $and_serie, $and_fecha, $and_folio);
		$filas1=mysqli_num_rows($RSa);
		if($filas1>0){
		
			include('cfdi_clases_test.php');*/
		?>
        <?php
        
        $and_folio="";
	  	  if(isset($_POST['folio_inicial']) && $_POST['folio_inicial']>0){
		  	$and_folio="".$_POST['folio_inicial']."";
		    }
        $and_serie="";
        if(isset($_POST['serie']) && $_POST['serie']!=""){
        $and_serie ="".$_POST['serie']."";
        }
        $RSa = consultaBitacora($conexion,$and_serie,$and_folio);
        
        $filas1=mysqli_num_rows($RSa);
        if($filas1>0){
        include('cfdi_clases_test.php');
        ?>

          <table border="1" cellspacing="0" colspan="20" width="100%";>

    
		      <?php
                $r=0;
                    while($linea = mysqli_fetch_assoc($RSa)){
                     // print_r($linea);echo "<br>";
                    $r++;
                    $fecha=$linea['fecha_comprobante'];
                    $tipo_comprobante=$linea['TipoComprobante'];
                    $claveCFDI=$linea['ClaveCFDI'];
                    $referencia=$linea['Referencia'];
                    $expedicion=$linea['LugarExpedicion'];
                    $forma_pago=$linea['FormaPago'];
                    $metodo_pago=$linea['MetodoPago'];
                    $moneda=$linea['Moneda'];
                    $cambio=$linea['TipoCambio'];
                    $sub_total=$linea['Subtotal'];
                    $descuento=$linea['Descuento'];
                    $total=$linea['Total'];
                    $relacion_uuid=$linea['Relacion_uuid'];
                    $relacion_tipo=$linea['Relacion_tipo'];
                    $relacion_serie=$linea['Relacion_Serie'];
                    $relacion_folio=$linea['Relacion_Folio'];
                    $motivo_cancelacion=$linea['MotivoCancelacion'];
                    $fecha_cancelacion=$linea['FechaCancelacion'];
                    $folio_sustituido=$linea['FolioSustituido'];
                    $vigente=$linea['vigente'];

                    //$rfc_Emisor=$linea['RfcEmisor'];
                    //$Nombre_Emisor=$linea['NombreEmisor'];
                    //$RegimenFiscal_Emisor=$linea['RegimenFiscal'];

                    //$rfcReceptor=$linea['RfcReceptor'];
                    //$folio=$linea['Folio_Comprobante'];
                    //$serie=$linea['Serie_Comprobante'];
                    //$NombreReceptor=$linea['NombreReceptor'];
                    //$usoCFDI=$linea['UsoCFDI'];
                    //$cp=$linea['CP'];
                    //$regimen=$linea['RegimenFiscal_receptor'];
                    //echo $NombreReceptor;

		      ?>
    <td align="center"  nowrap="nowrap" class="txt10" height="20"><strong>COMPROBANTE</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>TIPO COMPROBANTE</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>CLAVE CFDI</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>REFERENCIA</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>LUGAR EXPEDICION</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>FORMA PAGO</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>METODO PAGO</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>MONEDA</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>TIPO CAMBIO</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>SUBTOTAL</strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>DESCUENTO </strong></td>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>TOTAL</strong></td>
    <?php if(trim($relacion_uuid)!=""){ ?>
      <td align="center"  nowrap="nowrap" class="txt10"><strong>RELACION UUID </strong></td>
    <?php } ?>
    <?php if(trim($relacion_tipo)!=""){ ?>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>RELACION TIPO</strong></td>
    <?php } ?>
    <?php if(trim($relacion_serie)!=""){ ?>
    <td align="center"  nowrap="nowrap" class="txt10"><strong>RELACION SERIE</strong></td>
    <?php } ?>
    <?php if(trim($relacion_folio)!=""){ ?>
      <td align="center"  nowrap="nowrap" class="txt10"><strong>RELACION FOLIO </strong></td>
    <?php } ?>
    <?php if(trim($motivo_cancelacion)!=""){ ?>
      <td align="center"  nowrap="nowrap" class="txt10"><strong>MOTIVO CANCELACION </strong></td>
    <?php } ?>
    <?php if(trim($fecha_cancelacion)!=""){ ?>
      <td align="center"  nowrap="nowrap" class="txt10"><strong>FECHA CANCELACION</strong></td>
    <?php } ?>
    <?php if(trim($folio_sustituido)!=""){ ?>
     <td align="center"  nowrap="nowrap" class="txt10"><strong>FOLIO SUSTITUIDO</strong></td>
    <?php } ?>
    <?php if(trim($vigente)!=""){ ?>
      <td align="center"  nowrap="nowrap" class="txt10"><strong>VIGENTE</strong></td>
    <?php } ?>
    
    <tr></tr>
    <td height="15"></td>


      <td align="center"  nowrap="nowrap" class="txt10"><?php echo $tipo_comprobante; ?></td>
      <td align="center"  nowrap="nowrap" class="txt10"><?php echo $claveCFDI; ?></td>
      <td align="left"  nowrap="nowrap" class="txt10"><?php echo $referencia; ?></td>
      <td align="center"  nowrap="nowrap" class="txt10"><?php echo $expedicion; ?></td>
      <td align="center"  nowrap="nowrap"  class="txt10"><?php echo $forma_pago; ?></td>
      <td align="center"  nowrap="nowrap" class="txt10"><?php echo $metodo_pago; ?></td>
      <td align="left"  nowrap="nowrap" class="txt10"><?php echo $moneda; ?></td>
      <td align="right"  nowrap="nowrap"  class="txt10"><?php echo $cambio; ?></td>
      <td align="right"  nowrap="nowrap"  class="txt10"><?php echo $sub_total; ?></td>
      <td align="right"  nowrap="nowrap"  class="txt10"><?php echo $descuento; ?></td>
      <td align="right"  nowrap="nowrap"  class="txt10"><?php echo $total; ?></td>
      <?php if(trim($relacion_uuid)!=""){ ?>
        <td align="right" nowrap="nowrap" class="txt10"><?php  echo $relacion_uuid ?></td>
      <?php } ?>
      <?php if(trim($relacion_tipo)!=""){ ?>
        <td align="right" nowrap="nowrap" class="txt10"><?php  echo $relacion_tipo ?></td>
      <?php } ?>
      <?php if(trim($relacion_serie)!=""){ ?>
        <td align="left" nowrap="nowrap" class="txt10"><?php  echo $relacion_serie ?></td>
      <?php } ?>
      <?php if(trim($relacion_folio)!=""){ ?>
      <td align="right" nowrap="nowrap" class="txt10"><?php  echo $relacion_folio ?></td>
      <?php } ?>
      <?php if(trim($motivo_cancelacion)!=""){ ?>
      <td align="right" nowrap="nowrap" class="txt10"><?php  echo $motivo_cancelacion ?></td>
      <?php } ?>
      <?php if(trim($fecha_cancelacion)!=""){ ?>
      <td align="left" nowrap="nowrap" class="txt10"><?php  echo $fecha_cancelacion ?></td>
      <?php } ?>
      <?php if(trim($folio_sustituido)!=""){ ?>
      <td align="right" nowrap="nowrap" class="txt10"><?php  echo $folio_sustituido ?></td>
      <?php } ?>
      <?php if(trim($vigente)!=""){ ?>
      <td align="right" nowrap="nowrap" class="txt10"><?php  echo $vigente ?></td>
      <?php } ?>
      <!--<td align="center" nowrap="nowrap" class="txt10" colspan="1"></td>-->
      </tr>
      <tr height="20"></tr>
      <?php
		    }
	    ?>
    <tr>
    <td align="center" nowrap="nowrap" class="txt10" height="20"><strong>EMISOR</strong></td>
    <td align="center" nowrap="nowrap" class="txt10" ><strong>NOMBRE</strong></td>
    <td align="center" nowrap="nowrap" class="txt10" ><strong>RFC</strong></td>
    <td align="center" nowrap="nowrap" class="txt10" ><strong>REGIMEN FISCAL</strong></td>
    <td align="center" nowrap="nowrap" class="txt10" colspan="17"></td>
    </tr>

      <?php
          $and_folio="";
            if(isset($_POST['folio_inicial']) && $_POST['folio_inicial']>0){
          $and_folio="".$_POST['folio_inicial']."";
          }
              $and_serie="";
              if(isset($_POST['serie']) && $_POST['serie']!=""){
              $and_serie ="".$_POST['serie']."";
            }
              $RSa = consultaBitacora($conexion,$and_serie,$and_folio);
              
            $filas1=mysqli_num_rows($RSa);
            if($filas1>0){
              
                      $r=0;
                      while($linea = mysqli_fetch_array($RSa)){
                      $r++;
                    $rfc_Emisor=$linea['RfcEmisor'];
                    $Nombre_Emisor=  utf8_encode($linea['NombreEmisor']);
                    $RegimenFiscal_Emisor=$linea['RegimenFiscal'];
        ?>
    <tr>
    <td height="15"></td>
    <?php if(trim($Nombre_Emisor)!=""){ ?>
      <td align="left" nowrap="nowrap" class="txt10"><?php  echo $Nombre_Emisor ?></td>
      <?php } ?>
      <?php if(trim($rfc_Emisor)!=""){ ?>
      <td align="left" nowrap="nowrap" class="txt10"><?php  echo $rfc_Emisor ?></td>
      <?php } ?>
      <?php if(trim($RegimenFiscal_Emisor)!=""){ ?>
      <td align="right" nowrap="nowrap" class="txt10"><?php  echo $RegimenFiscal_Emisor ?></td>
      <?php } ?>
      <td align="left" nowrap="nowrap" class="txt10" colspan="17"></td>
      </tr>
      <tr height="20"></tr>
      <?php
        }
    ?> 
      <tr>
        <td align="center" nowrap="nowrap" class="txt10" height="0"><strong>RECEPTOR</strong></td>
        <td align="center" nowrap="nowrap" class="txt10" ><strong>NOMBRE</strong></td>
        <td align="center" nowrap="nowrap" class="txt10" ><strong>RFC</strong></td>
        <td align="center" nowrap="nowrap" class="txt10" ><strong>CP</strong></td>
        <td align="center" nowrap="nowrap" class="txt10" ><strong>REGIMEN FISCAL</strong></td>
        <td align="center" nowrap="nowrap" class="txt10" ><strong>USO CFDI</strong></td>
        <td align="center" nowrap="nowrap" class="txt10" colspan="16"></td>
      </tr>
        <?php
          }
        ?>
  <?php
        $and_folio="";
          if(isset($_POST['folio_inicial']) && $_POST['folio_inicial']>0){
         $and_folio="".$_POST['folio_inicial']."";
         }
            $and_serie="";
            if(isset($_POST['serie']) && $_POST['serie']!=""){
            $and_serie ="".$_POST['serie']."";
          }
            $RSa = consultaBitacora($conexion,$and_serie,$and_folio);
            
          $filas1=mysqli_num_rows($RSa);
          if($filas1>0){
                    $r=0;
                    while($linea = mysqli_fetch_array($RSa)){
                    $r++;

                    $rfcReceptor=$linea['RfcReceptor'];
                    $folio=$linea['Folio_Comprobante'];
                    $serie=$linea['Serie_Comprobante'];
                    $NombreReceptor=  utf8_encode($linea['NombreReceptor']);
                    $usoCFDI=$linea['UsoCFDI'];
                    $cp=$linea['CP'];
                    $regimen=$linea['RegimenFiscal_receptor'];
		?>
    <tr>
      <td height="15"></td>
      <?php if(trim($NombreReceptor)!=""){ ?>
        <td align="left" nowrap="nowrap" class="txt10"><?php  echo $NombreReceptor ?></td>
        <?php } ?>
        <?php if(trim($rfcReceptor)!=""){ ?>
        <td align="left" nowrap="nowrap" class="txt10"><?php  echo $rfcReceptor ?></td>
        <?php } ?>
        <?php if(trim($cp)!=""){ ?>
        <td align="right" nowrap="nowrap" class="txt10"><?php  echo $cp ?></td>
        <?php } ?>
        <?php if(trim($regimen)!=""){ ?>
        <td align="right" nowrap="nowrap" class="txt10"><?php  echo $regimen ?></td>
        <?php } ?>
        <?php if(trim($usoCFDI)!=""){ ?>
        <td align="center" nowrap="nowrap" class="txt10"><?php  echo $usoCFDI ?></td>
        <?php } ?>
      <td align="left" nowrap="nowrap" class="txt10" colspan="16"></td>
    </tr>
    <?php
      }
    }
	  ?>
       <?php
        
          $and_folio="";
	  	    if(isset($_POST['folio_inicial']) && $_POST['folio_inicial']>0){
		    	$and_folio="".$_POST['folio_inicial']."";
		      }
          $and_serie="";
          if(isset($_POST['serie']) && $_POST['serie']!=""){
              $and_serie ="".$_POST['serie']."";
          }
          $Rsa = consultaConcepto($conexion,$and_serie,$and_folio);
            
          $filas=mysqli_num_rows($Rsa);
             if($filas>0){
        ?>
          <tr height="20"></tr>
          <?php
                $r=0;
                    while($concepto = mysqli_fetch_array($Rsa)){
                      //print_r($concepto);echo "<br>";
                      $r++;
                      $identificacion=$concepto['NoIdentificacion'];
                      $cantidad=$concepto['Cantidad'];
                      $unidad=$concepto['Unidad'];

                      $descripcion= utf8_encode($concepto['Descripcion']);

                      $valor_unitario=$concepto['ValorUnitario'];
                      $importe=$concepto['Importe'];
                      $descuento=$concepto['Descuento'];
                      $objeto_impuesto=$concepto['ObjetoImpuesto'];
                      $base=$concepto['Tras_Base'];
                      $tras_impuesto=$concepto['Tras_Impuesto'];

                      $tasa=$concepto['Tras_Tasa'];
                      $tras_importe=$concepto['Tras_Importe'];

                      $ret_base=$concepto['Ret_Base'];
                      $ret_impuesto=$concepto['Ret_Impuesto'];
                      $ret_tipo_factor=$concepto['Ret_TipoFactor'];
                      $ret_importe=$concepto['Ret_Importe'];
                      $cuenta_predial=$concepto['CuentaPredial'];
                      $informacion_aduanera=$concepto['InformacionAduanera'];

          if($r==1){//si r es = 1 solo mostrara 1 vez los encabezados, esto en caso de mas de 1 registro
			    ?>
          <tr>
          <td align="center" nowrap="nowrap" class="txt10" height="20"><strong>CONCEPTO</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>NO. IDENTIFICACION</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>CANTIDAD</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>UNIDAD</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>DESCRIPCION</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>VALOR UNITARIO</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>IMPORTE</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>DESCUENTO</strong></td>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>OBJETO IMPUESTO</strong></td>

          <?php if(trim($base)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>TRAS BASE</strong></td>
          <?php } ?>

          <?php if(trim($tras_impuesto)!=""){ ?>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>TRAS IMPUESTO</strong></td>
          <?php } ?>

          <?php if(trim($tasa)!=""){ ?>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>TRAS TASA</strong></td>
          <?php } ?>
          <?php if(trim($tras_importe)!=""){ ?>
          <td align="center" nowrap="nowrap" class="txt10" ><strong>TRAS IMPORTE</strong></td>
          <?php } ?>

          <?php if(trim($ret_base)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>RET BASE</strong></td>
          <?php } ?>
          <?php if(trim($ret_impuesto)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>RET IMPUESTO</strong></td>
          <?php } ?>
          <?php if(trim($ret_tipo_factor)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>RET TIPO FACTOR</strong></td>
          <?php } ?>
          <?php if(trim($ret_importe)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>RET IMPORTE</strong></td>
          <?php } ?>
          <?php if(trim($cuenta_predial)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>CUENTA PREDIAL</strong></td>
          <?php } ?>
          <?php if(trim($informacion_aduanera)!=""){ ?>
            <td align="center" nowrap="nowrap" class="txt10" ><strong>INFORMACION ADUANERA</strong></td>
          <?php } ?>
          
          <td align="left" nowrap="nowrap" class="txt10" colspan="6"></td>
          </tr>
            <?php 
            }
            ?>
          <td height="15"></td>
          <?php if(trim($identificacion)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $identificacion ?></td>
          <?php } ?>
          <?php if(trim($cantidad)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $cantidad ?></td>
          <?php } ?>

          <?php if(trim($unidad)!=""){ ?>
          <td align="left" nowrap="nowrap" class="txt10"><?php  echo $unidad ?></td>
          <?php } ?>

          <?php if(trim($descripcion)!=""){ ?>
          <td align="left" nowrap="nowrap" class="txt10"><?php  echo $descripcion ?></td>
          <?php } ?>

          <?php if(trim($valor_unitario)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $valor_unitario ?></td>
          <?php } ?>
          <?php if(trim($importe)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $importe ?></td>
          <?php } ?>
          <?php if(trim($descuento)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $descuento ?></td>
          <?php } ?>
          <?php if(trim($objeto_impuesto)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $objeto_impuesto ?></td>
          <?php } ?>
          <?php if(trim($base)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $base ?></td>
          <?php } ?>
          <?php if(trim($tras_impuesto)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $tras_impuesto ?></td>
          <?php } ?>

          <?php if(trim($tasa)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $tasa ?></td>
          <?php } ?>
          <?php if(trim($tras_importe)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $tras_importe ?></td>
          <?php } ?>

          <?php if(trim($ret_base)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $ret_base ?></td>
          <?php } ?>
          <?php if(trim($ret_impuesto)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $ret_impuesto ?></td>
          <?php } ?>
          <?php if(trim($ret_tipo_factor)!=""){ ?>
          <td align="center" nowrap="nowrap" class="txt10"><?php  echo $ret_tipo_factor ?></td>
          <?php } ?>
          <?php if(trim($ret_importe)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $ret_importe ?></td>
          <?php } ?>
          <?php if(trim($cuenta_predial)!=""){ ?>
          <td align="right" nowrap="nowrap" class="txt10"><?php  echo $cuenta_predial ?></td>
          <?php } ?>
          <?php if(trim($informacion_aduanera)!=""){ ?>
          <td align="left" nowrap="nowrap" class="txt10"><?php  echo $informacion_aduanera ?></td>
          <?php } ?>
          <td align="left" nowrap="nowrap" class="txt10" colspan="6"></td> 

          </tr>
          <?php
          }
          ?>
          
         
        <!--<tr>
          <td colspan="4" align="center" nowrap="nowrap" class="txt10"><strong><?php echo date('Y-m-d H:i:s',time()+0); ?></strong></td>
          </tr>
            <?php 
            if( ( !isset($_POST['asignar']) && !isset($_POST['recuperar']) ) || ( $_POST['asignar']!=1 && $_POST['recuperar']!=1 ) ){
            ?>
              <tr>
              <td colspan="4" align="center" nowrap="nowrap" class="txt10">
                <table width="0%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="txt10"><strong>FORMA DE PAGO:</strong></td>
                    <td class="txt10">&nbsp;</td>
                    <td class="txt10"><?php
                $rsmp = listaMetodoPago($conexion);
                ?>
								<select name="metodopago" id="metodopago" class="txt10">
									<option value="">--Seleccione--</option>
									<?php
				  while($fmp=mysqli_fetch_assoc($rsmp)){
					$sel='';
					if($fmp['metodopago_cve_sat']==$_POST['metodopago']){
						$sel=' selected';
					}
				  ?>
									<option value="<?php echo $fmp['metodopago_cve_sat'] ?>" <?php echo $sel ?>><?php echo $fmp['metodopago_descripcion'] ?></option>
									<?php
				  }
				  ?>
								</select></td>
                
						</tr>
           
					
          </td>
  			   </tr>
           
          
          <?php 
          }
          ?>-->
           
          </table>
          
          <tr>
          <td align="center" nowrap="nowrap" class="txt10">
          <td align="center" nowrap="nowrap" class="txt10">&nbsp;</td>
            <td nowrap="nowrap" class="txt10">&nbsp;</td>
            <td align="center" class="txt10">&nbsp;</td>
            </tr>
          </tr>
          <tr>
              <td align="center" nowrap="nowrap" class="txt10">
              <input type="button" class="txt10" value="Menu Principal" onclick="lleva('http://pru.corprama.com.mx/facturacion/');"></td>
              <td align="center" nowrap="nowrap" class="txt10">&nbsp;</td>
              <td nowrap="nowrap" class="txt10">&nbsp;</td>
              <td align="center" class="txt10">&nbsp;</td>
          </tr>
          <?php
          if(isset($_POST['asignar']) && $_POST['asignar']==1){
          ?>
                <tr>
                  <td colspan="4" align="center" nowrap="nowrap" class="txt10">Enviar a timbrar test:
                    <input type="checkbox" name="enviar_mail" id="enviar_mail" value="1" /></td>
                </tr>
                <tr>
          <td colspan="4" align="center" nowrap="nowrap" class="txt10"><input name="botonr" type="button" class="txt10" onclick="manda();" value="Procesar Documentos" /></td>
          </tr>
          <?php 
          }
          ?>
          <?php
          }
          ?>
        </td>
        </tr>
        <tr>
          <td align="center" nowrap="nowrap"><hr size="1" class="txt10"/></td>
        </tr>
        <?php
      }
        ?>
          <?php
          }
          ?>
      </tr>
    </td>
    </tr>
  </table> 
</form> 
</div>
</body>
</html>