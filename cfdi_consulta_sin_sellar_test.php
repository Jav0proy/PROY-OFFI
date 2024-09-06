<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/texto.css" rel="stylesheet" type="text/css">
<title>Facturación / Consulta Facturas</title>
<script src="../js/rutinastmp.js"></script>
<script type="text/javascript" src="../jscalendar/calendar.js"></script>
<script type="text/javascript" src="../jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="../jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="../js/rutinasA.js"></script>
<style type="text/css"> 
@import url("../jscalendar/calendar-blue2.css");
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
  <table width="800" border="0" cellpadding="0" cellspacing="0" class="fondoTabla">
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
        <tr>
          <td align="right" nowrap="NOWRAP" class="txt10"><strong>Fecha  Inicial :
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
</script></td>
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
          <td align="right" nowrap="NOWRAP" class="txt10"><strong>Fecha  Final :</strong></td>
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
          </label></td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10"><strong>Folio Inicial:</strong></td>
          <td class="txt10"><label>
            <input name="folio_inicial" class="txt10" type="text" id="folio_inicial" size="12" maxlength="10" value="<?php if(isset($_POST['folio_inicial'])){echo $_POST["folio_inicial"];} ?>" />
          </label></td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" nowrap="NOWRAP" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10"><strong>Folio Final:</strong></td>
          <td class="txt10"><input name="folio_final" class="txt10" type="text" id="folio_final" size="12" maxlength="10" value="<?php if(isset($_POST['folio_final'])){echo $_POST["folio_final"];} ?>" /></td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
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
          <td align="right" nowrap="NOWRAP" class="txt10"><input name="button" type="button" class="txt10" onclick="lleva('http://pru.corprama.com.mx/facturacion/');" value="Menu Principal" /></td>
          <td class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">
		  <input type="button" class="txt10" value="Consultar" onclick="document.facturas.submit();">
		  </td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
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

		$and_fecha="";
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
		}
		
		$RSa = buscaBitacoraComprobanteTest($conexion, $and_serie, $and_fecha, $and_folio);
		$filas1=mysqli_num_rows($RSa);
		if($filas1>0){
		
			include('cfdi_clases_test.php');
		?>
<table border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td nowrap="nowrap" class="txt10">&nbsp;</td>
    <td nowrap="nowrap" class="txt10">&nbsp;</td>
    <td align="left" nowrap="nowrap" class="txt10"><strong>FOLIO</strong></td>
    <td nowrap="nowrap" class="txt10">&nbsp;</td>
  </tr>
		<?php
			$r=0;
			while($linea_b = mysqli_fetch_array($RSa)){
				$r++;
				
				$bit_pagadora=$linea_b['bit_pagadora'];
				$bit_serie=$linea_b['bit_serie'];
				$bit_folio=$linea_b['bit_folio'];
				
				$bit_forma_p=$linea_b['FormaPago'];
				$bit_metodo_p=$linea_b['MetodoPago'];
				
				$bit_cliente_tipo=$linea_b['cliente_tipo'];
				$bit_rfc=$linea_b['cliente_rfc'];
				$bit_cliente=$linea_b['id_cliente_cve'];
				$bit_cliente_email="";
				$bit_cliente_email=$linea_b['cliente_email'];
				
				$bit_tipo_doc="";
				
				if(substr($bit_serie,-2)=='FA'){
					$bit_tipo_doc="I";
				}
				elseif(substr($bit_serie,-2)=='NC'){
					$bit_tipo_doc="E";
				}
				elseif(substr($bit_serie,-2)=='PA'){
					$bit_tipo_doc="P";
				}

			?>
  <tr>
    <td align="right" nowrap="nowrap" class="txt10"><strong><?php echo $r." .-" ?></strong></td>
    <td align="left" nowrap="nowrap" class="txt10">&nbsp;</td>
    <td align="left" nowrap="nowrap" class="txt10"><?php echo $bit_serie."-".$bit_folio." : ".$bit_tipo_doc.""; ?></td>
    <td align="left" class="txt10"><strong>
      <?php
	  			if(isset($_POST['metodopago']) && $_POST['metodopago']!=''){
					if(trim($bit_tipo_doc)!="P"){
						echo " ASIGNANDO TEST ".$_POST['metodopago']."";
						include('cfdi_asigna_metodo.php');
					}
				}
				
				if(isset($_POST['recuperar']) && $_POST['recuperar']==1){
					echo " SELLANDO TEST ".$bit_tipo_doc."<br>";
					if(trim($bit_tipo_doc)=="I"){
						include('cfdi_construye_i_test.php');
					}
					elseif(trim($bit_tipo_doc)=="E"){
						include('cfdi_construye_e_test.php');
					}
					elseif(trim($bit_tipo_doc)=="P"){
						include('cfdi_construye_p_test.php');
						
					}
				}
	?>
    </strong></td>
  </tr>
			<?php
			}
			?>
  <tr>
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
					</table>				</td>
  			</tr>
            <tr>
            	<td colspan="4" align="center" nowrap="nowrap" class="txt10"><input name="botonr2" type="button" class="txt10" onclick="manda_asigna();" value="Asignar" /></td>
            </tr>
			<?php 
			}
			?>
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
</table>
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
      <tr>
      <td align="center" valign="middle"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="fondoTabla">
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
          <td align="right" nowrap="NOWRAP" class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td class="txt10">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="txt10">
		  <input type="button" class="txt10" value="Menu Principal" onclick="lleva('http://pru.corprama.com.mx/facturacion/');"></td>
         <td align="right" nowrap="nowrap" class="txt10">&nbsp;</td>
          <td nowrap="nowrap" class="txt10">&nbsp;</td>
          <td align="center" class="txt10">&nbsp;</td>
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
      </table></td>
    </tr>
  </table> 
</form>
</div>

</body>
</html>