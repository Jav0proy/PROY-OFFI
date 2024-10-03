<?php
error_reporting(0);
if ($_POST['excel'] == 1) {
    header('Content-type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=reporteMensual.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    include('../lib/funciones.php');

    $con = conecta();
}
?>
<fieldset>
    <legend style="font-weight: bold">REFACCIONARIA CALIFORNIA Y HERSASA <br>CEDULA TOTAL DE GASTOS</br></legend>
    <table cellpadding="0" cellspacing="0" align="center" id="detalle" border='1' class="fondoTabla">
        <thead>
            <tr class="encabezado">
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>1</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>2</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>3</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>4</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>5</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>6</th>
                <td class="espacio">&nbsp;</td>
                <th colspan="3" style="font-weight: bold" bgcolor='#ffc932' align='center'>7</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>8</th>
                <th colspan="3" style="font-weight: bold" bgcolor='#ffc932' align='center'>9</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>10</th>
                <td class="espacio">&nbsp;</td>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>11</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>12</th>
                <td class="espacio">&nbsp;</td>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>13</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>14</th>
                <td class="espacio">&nbsp;</td>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>15</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>16</th>
                <td class="espacio">&nbsp;</td>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>17</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>18</th>
                <td class="espacio">&nbsp;</td>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>19</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>20</th>
                <th style="font-weight: bold" bgcolor='#ffc932' align='center'>21</th>
            </tr>
            <tr class="encabezado">
                <td align='center' rowspan="3">No.</td>
                <td align='center' rowspan="3">RA</td>
                <td align='center' rowspan="3">MOSTRADOR</td>
                <td align='center' colspan="2" rowspan="2">DATOS DE LA MOTO</td>
                <td align='center' rowspan="3">TOTAL DE MANTENIMIENTO</td>
                <td class="espacio">&nbsp;</td>
                <td align='center' colspan="8"><?php echo $meses[$_POST['mes']]; ?></td>
                <td class="espacio">&nbsp;</td>
                <?php
                $meseSel = $_POST['mes'];
                $axo = $_POST['axo'];
                $fecha = $_POST['tipoFecha'];
                for ($i = $axo; $i > $axo - 4; $i--) {
                    ?>
                    <td align='center' colspan="2" rowspan="2"><?php echo $i; ?></td>
                    <td class="espacio">&nbsp;</td>
                    <?php
                }
                ?>

                <td align='center' rowspan="2">ACUMU. DE GASTOS</td>
                <td align='center' rowspan="3">KILOMETROS</td>
                <td align='center' rowspan="3">GASTOS POR KM. RECORRIDO</td>
            </tr>
            <tr>
                <td class="espacio">&nbsp;</td>
                <td align="center" colspan="3">CONTROL DE ACTIVOS</td>
                <td align="center" rowspan="2">MOSTRADOR</td>
                <td align="center" colspan="3">ACUMULADO</td>
                <td align="center">CONSUMOS INTERNOS</td>
            </tr>
            <tr class="encabezado">
                <td align='center' >PLACA</td>
                <td align='center' >MESES DE USO</td>
                <td class="espacio" >&nbsp;</td>
                <td align='center' >MANTENIMIENTO</td>
                <td align='center' >ACCESORIOS</td>
                <td align='center' >TOTAL</td>
                <td align='center' >MANTENIMIENTO</td>
                <td align='center' >ACCESORIOS</td>
                <td align='center' >TOTAL</td>
                <td align='center' >TOTAL CI.</td>

                <td class="espacio">&nbsp;</td>
                <td align='center' >SUMA</td>
                <td align='center' >PROMEDIO</td>
                <td class="espacio">&nbsp;</td>
                <td align='center' >SUMA</td>
                <td align='center' >PROMEDIO</td>
                <td class="espacio">&nbsp;</td>
                <td align='center' >SUMA</td>
                <td align='center' >PROMEDIO</td>
                <td class="espacio">&nbsp;</td>
                <td align='center' >SUMA</td>
                <td align='center' >PROMEDIO</td>
                <td class="espacio">&nbsp;</td>
                <td align='center' >SUMA</td>
            </tr>
            <tr>
                <td colspan="26" class="espacio">&nbsp;</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $queryAxox = "";
            for ($i = $axo; $i > $axo - 4; $i--) {
                $and = "";
                if ($i == $axo) {
                    $and = " AND d.$fecha<='$i-$meseSel-31' ";
                }
                $queryAxox .= "(select sum(d.docto_subtotal) from mtDocumento as d  where $fecha like '$i-%' and d.id_equipo_transporte=e.id_equipo_transporte $and  ) as sumaTotalAxo$i,";
            }
            $query = "
                     SELECT
                    TIMESTAMPDIFF(MONTH, e.eqtrans_fecha_alta, CURDATE()) as mesesUso,
                    e.id_equipo_transporte,
                    e.eqtrans_placa,
                    IF(asg.id_cliente_cve=1, 'CONTROL DE ACTIVOS', c.cliente_des_oficial) as cliente_des_oficial,
                    (SELECT acomodo_numero FROM `mtAcomodoCliente` as a WHERE `fecha_captura` <= '$axo-$meseSel-31'  AND a.id_cliente_cve=c.id_cliente_cve order by fecha_captura desc,hora_captura desc limit 1) as acomodo_numero,
                    (SELECT acomodo_rango  FROM `mtAcomodoCliente` as a WHERE `fecha_captura` <= '$axo-$meseSel-31'  AND a.id_cliente_cve=c.id_cliente_cve order by fecha_captura desc,hora_captura desc limit 1) as cliente_rango,
                    asg.id_asignacion_transporte,
                    e.eqtrans_fecha_alta,
                    (select count(*) from mtDocumento as d  where d.$fecha like '$axo-$meseSel-%'  and d.id_equipo_transporte=e.id_equipo_transporte and id_tipo_mantto<>12 ) as numeroDocumentos,
                    (select sum(d.docto_subtotal) from mtDocumento as d  where d.$fecha like '$axo-$meseSel-%'  and d.id_equipo_transporte=e.id_equipo_transporte and d.usuario_empresa like '4%'  and id_tipo_mantto<>12) as sumaCorpo,
                    (SELECT SUM(de.docto_det_importe) FROM mtDocumento AS d
                        INNER JOIN mtDocumentoDetalle AS de ON de.id_equipo_transporte = d.id_equipo_transporte AND de.id_proveedor=d.id_proveedor AND de.docto_numero = d.docto_numero
                        INNER JOIN mtCat_ConceptoMantto AS con ON con.id_concepto_mantto = de.id_concepto_mantto
                        INNER JOIN mtCat_TipoConcepto AS t ON t.id_tipo_concepto = con.id_tipo_concepto
                        WHERE
                            t.id_tipo_concepto = 1
                            AND d.$fecha LIKE '$axo-$meseSel-%'
                            AND d.id_equipo_transporte = e.id_equipo_transporte
                            AND d.usuario_empresa LIKE '4%'
							and id_tipo_mantto<>12
                        ) AS sumaCorpoMantto,
	            (SELECT SUM(de.docto_det_importe) FROM mtDocumento AS d
                        INNER JOIN mtDocumentoDetalle AS de ON de.id_equipo_transporte = d.id_equipo_transporte AND de.id_proveedor=d.id_proveedor AND de.docto_numero = d.docto_numero
                        INNER JOIN mtCat_ConceptoMantto AS con ON con.id_concepto_mantto = de.id_concepto_mantto
                        INNER JOIN mtCat_TipoConcepto AS t ON t.id_tipo_concepto = con.id_tipo_concepto
                        WHERE
                            t.id_tipo_concepto = 2
                            AND d.$fecha LIKE '$axo-$meseSel-%'
                            AND d.id_equipo_transporte = e.id_equipo_transporte
                            AND d.usuario_empresa LIKE '4%'
							and id_tipo_mantto<>12
                        ) AS sumaCorpoAccesorios,
                    (select sum(d.docto_subtotal) from mtDocumento as d  where d.$fecha like '$axo-$meseSel-%'  and d.id_equipo_transporte=e.id_equipo_transporte and d.usuario_empresa not like '4%'  and id_tipo_mantto<>12) as sumaRc,
                    (select sum(d.docto_subtotal) from mtDocumento as d  where d.$fecha like '$axo-$meseSel-%'  and d.id_equipo_transporte=e.id_equipo_transporte  and id_tipo_mantto<>12 ) as sumaTotal,
                    (SELECT SUM(de.docto_det_importe) FROM mtDocumento AS d
                        INNER JOIN mtDocumentoDetalle AS de ON de.id_equipo_transporte = d.id_equipo_transporte AND de.id_proveedor=d.id_proveedor AND de.docto_numero = d.docto_numero
                        INNER JOIN mtCat_ConceptoMantto AS con ON con.id_concepto_mantto = de.id_concepto_mantto
                        INNER JOIN mtCat_TipoConcepto AS t ON t.id_tipo_concepto = con.id_tipo_concepto
                        WHERE
                            t.id_tipo_concepto = 1
                            AND d.$fecha LIKE '$axo-$meseSel-%' AND d.id_equipo_transporte = e.id_equipo_transporte and id_tipo_mantto<>12 ) AS sumaTotalMantto,

                    (SELECT SUM(de.docto_det_importe) FROM mtDocumento AS d
                        INNER JOIN mtDocumentoDetalle AS de ON de.id_equipo_transporte = d.id_equipo_transporte AND de.id_proveedor=d.id_proveedor AND de.docto_numero = d.docto_numero
                        INNER JOIN mtCat_ConceptoMantto AS con ON con.id_concepto_mantto = de.id_concepto_mantto
                        INNER JOIN mtCat_TipoConcepto AS t ON t.id_tipo_concepto = con.id_tipo_concepto
                        WHERE
                            t.id_tipo_concepto = 2
                            AND d.$fecha LIKE '$axo-$meseSel-%' AND d.id_equipo_transporte = e.id_equipo_transporte and id_tipo_mantto<>12) AS sumaTotalAccesorios,
                    (select sum(d.docto_subtotal) from mtDocumento as d  where d.$fecha BETWEEN '$axo-$meseSel-01' AND '$axo-$meseSel-31' and d.id_equipo_transporte=e.id_equipo_transporte and d.usuario_empresa like '4%' and id_tipo_mantto<>12) as sumaCorpoAxo,
                    (select sum(d.docto_subtotal) from mtDocumento as d  where d.$fecha BETWEEN '$axo-$meseSel-01' AND '$axo-$meseSel-31' and d.id_equipo_transporte=e.id_equipo_transporte and d.usuario_empresa not like '4%' and id_tipo_mantto<>12) as sumaRcAxo,
                    (select sum(d.docto_subtotal) from mtDocumento as d  where d.$fecha BETWEEN '$axo-$meseSel-01' AND '$axo-$meseSel-31' and d.id_equipo_transporte=e.id_equipo_transporte and id_tipo_mantto<>12 ) as sumaTotalAxo,
 					$queryAxox
                    (SELECT sum(consumo_recorrido) FROM mtConsumoGasolina AS g where g.id_equipo_transporte=e.id_equipo_transporte and g.consumo_fecha_captura <='$axo-$meseSel-31') as kilometraje
                        FROM
                            mtEquipoTransporte AS e
                        INNER JOIN (
                            SELECT
                                A.id_equipo_transporte,
                                MAX( id_asignacion_transporte ) AS id_asignacion_transporte
                            FROM
                                mtAsignacionTransporte AS A
                            WHERE
                                asig_fecha_asignacion < DATE_ADD( '$axo-$meseSel-01', INTERVAL + 1 MONTH )
                            GROUP BY
                                A.id_equipo_transporte) AS a ON e.id_equipo_transporte = a.id_equipo_transporte
                        INNER JOIN mtAsignacionTransporte AS asg ON a.id_asignacion_transporte=asg.id_asignacion_transporte
                        INNER JOIN tesoreria.gsCat_Cliente as c on c.id_cliente_cve=asg.id_cliente_cve
                        WHERE
                            c.cliente_tipo_empresa ='RCS'
                            AND c.cliente_tipo = 'FIL'
                            AND (e.eqtrans_status = 'A' or e.eqtrans_fecha_baja>='$axo-$meseSel-01')
                            and e.id_tipo_transporte=3 ORDER BY e.eqtrans_fecha_alta ASC";

            //echo $query . "<br>";
            $result = mysql_query($query, $con) or die(mysql_error($con) . '<br>' . $query);
            if (mysql_num_rows($result) > 0) {
                $acum_mantto = 0;
                $acum_sumaTotal = 0;
                $acum_sumaTotalMantto = 0;
                $acum_sumaTotalAccesorios = 0;
                $acum_sumaCorpo = 0;
                $acum_sumaCorpoMantto = 0;
                $acum_sumaCorpoAccesorios = 0;
                $acum_sumaRc = 0;
                $acum_acumulado = 0;
                $acum_axoNuevo = 0;

                $axo1 = $axo;
                $axo2 = $axo1 - 1;
                $axo3 = $axo2 - 1;
                $axo4 = $axo3 - 1;
                $acumAxo1 = 0;
                $acumAxo2 = 0;
                $acumAxo3 = 0;
                $acumAxo4 = 0;
                $acum_promAxo1 = 0;
                $acum_promAxo2 = 0;
                $acum_promAxo3 = 0;
                $acum_promAxo4 = 0;
                $acum_kilometraje = 0;
                $acum_consumoMoto = 0;

                while ($datos = mysql_fetch_assoc($result)) {

                    foreach ($datos as $k => $v)
                        $$k = $v;

                    $importeConsumoMoto = 0;
                    $queryImporteConsumoMoto = "SELECT
                                c.cliente_id_uname,
                                c.cliente_des_corta,
                                d.detalleValeConsumo_claveArticulo,
                                d.detalleValeConsumo_detalleArticulo,
                                d.detalleValeConsumo_costoUnitario,
                                v.valeConsumo_fechaEntregado,
                                v.valeConsumo_tipo,
                        SUM(d.detalleValeConsumo_costoUnitario*d.detalleValeConsumo_cantidadAutorizada) AS totalMoto

                        FROM
                                consumos_detalleVale d
                                LEFT JOIN consumos_vale v ON d.id_valeConsumo = v.id_valeConsumo
                                LEFT JOIN tesoreria.gsCat_Cliente c ON v.valeConsumo_idUname = c.cliente_id_uname

                        WHERE v.valeConsumo_tipo = 'M'
                        AND id_equipo_transporte = '" . $id_equipo_transporte . "'
                           AND MONTH(v.valeConsumo_fechaEntregado) = '" . $meseSel . "'
                                GROUP BY v.valeConsumo_idUname";
                    $excImporteConsumoMoto = mysql_query($queryImporteConsumoMoto, $con)or die($queryImporteConsumoMoto);
                    $numeroRows = mysql_num_rows($excImporteConsumoMoto);

                    if ($numeroRows > 0) {
                        $resImporteConsumoMoto = mysql_fetch_assoc($excImporteConsumoMoto);
                        $importeConsumoMoto = $resImporteConsumoMoto['totalMoto'];
                    }
                    ?>
                    <tr>
                        <td style="border-color:#000" align='center'><?php echo $acomodo_numero; ?></td>
                        <td style="border-color:#000" align='center'><?php echo $cliente_rango; ?></td>
                        <td style="border-color:#000" align='center'><?php echo $cliente_des_oficial; ?></td>
                        <td style="border-color:#000" align='center'><?php echo $eqtrans_placa; ?></td>
                        <td style="border-color:#000" align='center'><?php echo $mesesUso; ?></td>
                        <td style="border-color:#000" align='center'><?php echo $numeroDocumentos; ?></td>
                        <td style="border-color:#000" class="espacio">&nbsp;</td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaCorpoMantto > 0) ? number_format(round($sumaCorpoMantto, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaCorpoAccesorios > 0) ? number_format(round($sumaCorpoAccesorios, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaCorpo > 0) ? number_format(round($sumaCorpo, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaRc > 0) ? number_format(round($sumaRc, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaTotalMantto > 0) ? number_format(round($sumaTotalMantto, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaTotalAccesorios > 0) ? number_format(round($sumaTotalAccesorios, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo ($sumaTotal > 0) ? number_format(round($sumaTotal, 2), 2) : ''; ?></td>
                        <td style="border-color:#000" class="numero"><?php echo number_format($importeConsumoMoto, 2) ?></td>
                        <td style="border-color:#000" class="espacio">&nbsp;</td>

                        <?php
                        $acumulado = 0;


                        for ($i = $axo; $i > $axo - 4; $i--) {

                            #*************************Acumulado anual consumos internos moto********************************#


                            $acumuladoAnualConsumoMoto = 0;
                            $queryAcumuladoAnualConsumoMoto = "SELECT
                                c.cliente_id_uname,
                                c.cliente_des_corta,
                                d.detalleValeConsumo_claveArticulo,
                                d.detalleValeConsumo_detalleArticulo,
                                d.detalleValeConsumo_costoUnitario,
                                v.valeConsumo_fechaEntregado,
                                v.valeConsumo_tipo,
                        SUM(d.detalleValeConsumo_costoUnitario) AS totalMoto

                        FROM
                                consumos_detalleVale d
                                LEFT JOIN consumos_vale v ON d.id_valeConsumo = v.id_valeConsumo
                                LEFT JOIN tesoreria.gsCat_Cliente c ON v.valeConsumo_idUname = c.cliente_id_uname

                        WHERE v.valeConsumo_tipo = 'M'
                        AND id_equipo_transporte = '" . $id_equipo_transporte . "'
                        AND YEAR(v.valeConsumo_fechaEntregado) = '" . $axo . "'
                                GROUP BY v.valeConsumo_idUname";
                            $excAcumuladoAnualConsumoMoto = mysql_query($queryAcumuladoAnualConsumoMoto, $con)or die($queryAcumuladoAnualConsumoMoto);
                            $numeroRows = mysql_num_rows($excAcumuladoAnualConsumoMoto);

                            if ($numeroRows > 0) {
                                $resAcumuladoAnualConsumoMoto = mysql_fetch_assoc($excAcumuladoAnualConsumoMoto);
                                $acumuladoAnualConsumoMoto = $resAcumuladoAnualConsumoMoto['totalMoto'];
                            }

                            $queryAcumuladoAnual = "";

                            #**************************************************************************************************************#


                            $acumulado += $datos['sumaTotalAxo' . $i];
                            $acumulado += $acumuladoAnualConsumoMoto;
                            $datos['sumaTotalAxo' . $i] += $acumuladoAnualConsumoMoto;


                            $divide = 12;

                            if ($i == $axo) {
                                $divide = intval($meseSel);
                            }

                            $promAxo = ($datos['sumaTotalAxo' . $i] / $divide > 0) ? round(($datos['sumaTotalAxo' . $i] / $divide), 2) : '';
                            if ($axo1 === $i) {
                                $acumAxo1 += $datos['sumaTotalAxo' . $i];
                                $acum_promAxo1 += ($promAxo);
                            }
                            if ($axo2 === $i) {
                                $acumAxo2 += $datos['sumaTotalAxo' . $i];
                                $acum_promAxo2 += ($promAxo);
                            }
                            if ($axo3 === $i) {
                                $acumAxo3 += $datos['sumaTotalAxo' . $i];
                                $acum_promAxo3 += ($promAxo);
                            }
                            if ($axo4 === $i) {
                                $acumAxo4 += $datos['sumaTotalAxo' . $i];
                                $acum_promAxo4 += ($promAxo);
                            }
                            ?>
                            <td  class="numero"><?php echo ($datos['sumaTotalAxo' . $i] > 0) ? number_format(round($datos['sumaTotalAxo' . $i], 2), 2) : ''; ?></td>
                            <td  class="numero"><?php echo number_format(round($promAxo, 2), 2) ?></td>
                            <td  class="espacio">&nbsp;</td>
                            <?php
                            //echo $i . "<br>";
                        }
                        ?>
                        <td  class="numero"><?php echo ($acumulado > 0) ? number_format(round($acumulado, 2), 2) : ''; ?></td>
                        <td  class="numero"><?php if ($kilometraje > 0) echo number_format($kilometraje); ?></td>
                        <td  class="numero"><?php if ($kilometraje > 0) echo number_format(round($acumulado / $kilometraje, 2), 2); ?></td>
                    </tr>
                    <?php
                    $acum_mantto += $numeroDocumentos;
                    $acum_sumaTotal += $sumaTotal;
                    $acum_sumaTotalMantto += $sumaTotalMantto;
                    $acum_sumaTotalAccesorios += $sumaTotalAccesorios;
                    $acum_sumaCorpo += $sumaCorpo;
                    $acum_sumaCorpoMantto += $sumaCorpoMantto;
                    $acum_sumaCorpoAccesorios += $sumaCorpoAccesorios;
                    $acum_sumaRc += $sumaRc;
                    $acum_acumulado += $acumulado;
                    $acum_kilometraje += $kilometraje;
                    $acum_consumoMoto += number_format($importeConsumoMoto, 2);
                }
            } else {
                ?>
                <tr>
                    <td colspan="26">No existe informacion con los filtros seleccionados.</td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td style="color:white" bgcolor="#4bad56" colspan="5" align="center">TOTALES</td>
                <td style="color:white" bgcolor="#4bad56" align='center'><?php echo $acum_mantto ?></td>
                <td class="espacio">&nbsp;</td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaCorpoMantto, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaCorpoAccesorios, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaCorpo, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaRc, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaTotalMantto, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaTotalAccesorios, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_sumaTotal, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format($acum_consumoMoto, 2) ?></td>
                <td class="espacio">&nbsp;</td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acumAxo1, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_promAxo1, 2), 2) ?></td>
                <td class="espacio">&nbsp;</td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acumAxo2, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_promAxo2, 2), 2) ?></td>
                <td class="espacio">&nbsp;</td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acumAxo3, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_promAxo3, 2), 2) ?></td>
                <td class="espacio">&nbsp;</td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acumAxo4, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_promAxo4, 2), 2) ?></td>
                <td class="espacio">&nbsp;</td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_acumulado, 2), 2) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format($acum_kilometraje) ?></td>
                <td class="numero" style="color:white" bgcolor="#4bad56"><?php echo number_format(round($acum_acumulado / $acum_kilometraje, 2), 2) ?></td>
            </tr>
        </tbody>
    </table>
</fieldset>