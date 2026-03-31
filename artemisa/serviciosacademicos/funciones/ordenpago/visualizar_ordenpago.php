<form name="form1" method="post" action="">
    <!-- <p><?php echo $tituloorden; ?></p>-->
    <?php    

    $query_dataestudiante = "SELECT o.numeroordenpago, o.fechaordenpago, e.codigocarrera, e.codigoperiodo, ".
	" eg.numerodocumento, concat( eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral) AS nombre, ".
	" c.nombrecarrera, t.nombretipocliente, te.codigoreferenciatipoestudiante, c.codigoindicadortipocarrera, ".
	" o.idsubperiodo, o.idsubperiododestino, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, ".
	" o.fechapagosapordenpago,e.idestudiantegeneral, e.codigoestudiante ".
    " FROM ordenpago o ".
	" INNER JOIN estudiante e ON (e.codigoestudiante = o.codigoestudiante) ".
	" INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) ".
	" INNER JOIN estudiantegeneral eg ON (eg.idestudiantegeneral = e.idestudiantegeneral) ".
	" INNER JOIN tipocliente t ON (eg.codigotipocliente = t.codigotipocliente) ".
	" INNER JOIN tipoestudiante te ON (e.codigotipoestudiante = te.codigotipoestudiante) ".
    " WHERE o.numeroordenpago =".$this->numeroordenpago." ";
    $dataestudiante=mysql_query($query_dataestudiante,$this->sala) or die("$query_dataestudiante".mysql_error());
    $totalRows_dataestudiante = mysql_num_rows($dataestudiante);
    $row_dataestudiante = mysql_fetch_array($dataestudiante);

    $query_selgrupos = "select dp.idgrupo, dp.codigomateria FROM detalleprematricula dp ".
	" INNER JOIN prematricula p ON (dp.idprematricula = p.idprematricula) ".
	" where p.codigoestudiante = '".$row_dataestudiante['codigoestudiante']."' ".
	" and p.codigoperiodo = '".$row_dataestudiante['codigoperiodo']."' ".
	" AND ( dp.codigoestadodetalleprematricula = '10' OR dp.codigoestadodetalleprematricula =  '30' )".
    " AND ( p.codigoestadoprematricula IN ('10', '11') OR p.codigoestadoprematricula IN ('40', '41', '42', '44') )";
    $selgrupos=mysql_query($query_selgrupos,$this->sala) or die("$query_selgrupos".mysql_error());
    $totalRows_selgrupos = mysql_num_rows($selgrupos);
    while($row_selgrupos = mysql_fetch_array($selgrupos)) {
        $materiascongrupo[] = $row_selgrupos['idgrupo'];    
    }
    $this->existe_ordeninternaocentrobeneficio($ordeninternaocentrobeneficio, $materiascongrupo, $tipoorden);
    ?>
    <table class="table table-bordered" style="width: 80%">
        <tr id="trtituloNaranjaInst">
            <td colspan="8"><b>DATOS GENERALES</b></td>
        </tr>
        <tr >
            <td id=""><b>Id General</b></td>
            <td id=""><b>Id Estudiante</b></td>
            <td id=""><b><?php echo $tipoorden;?></b></td>
            <td id=""><b>Subperiodo</b></td>
            <td id=""><b>Subperiodo Destino</b></td>
            <td id=""><b>Cuenta por Cobrar</b></td>
            <td id=""><b>Cuenta Compensaci&oacute;n</b></td>
            <td id=""><b>Fecha de Pago</b></td>
        </tr>
        <tr>
            <td><?php echo $row_dataestudiante['idestudiantegeneral'];?>&nbsp;</td>
            <td><?php echo $row_dataestudiante['codigoestudiante'];?>&nbsp;</td>
            <td><?php if($ordeninternaocentrobeneficio != "") echo $ordeninternaocentrobeneficio; else echo "No tiene"?>&nbsp;</td>
            <td><?php echo $row_dataestudiante['idsubperiodo'];?>&nbsp;</td>
            <td><?php echo $row_dataestudiante['idsubperiododestino'];?>&nbsp;</td>
            <td colspan="1"><?php echo $row_dataestudiante['documentocuentaxcobrarsap'];?>&nbsp;</td>
            <td colspan="1"><?php echo $row_dataestudiante['documentocuentacompensacionsap'];?>&nbsp;</td>
            <td colspan="1"><?php echo $row_dataestudiante['fechapagosapordenpago'];?>&nbsp;</td>
        </tr>
        <tr >
            <td id=""><b>No. Orden</b></td>
            <td id="" colspan="3"><b>Carrera</b></td>
            <td id="" colspan="2"><b>Periodo</b></td>
            <td id="" colspan="1"><b>Tipo de Cliente</b></td>
            <td id=""><b>Fecha</b></td>
        </tr>
        <tr>
            <td><?php echo $row_dataestudiante['numeroordenpago'];?></td>
            <td colspan="3"><?php echo $row_dataestudiante['nombrecarrera'];?></td>
            <td colspan="2"><?php echo $this->codigoperiodo;?></td>
            <td colspan="1"><?php echo $row_dataestudiante['nombretipocliente'];?></td>
            <td><?php echo $row_dataestudiante['fechaordenpago'];?></td>
        </tr>
        <tr>
            <td id="" colspan="5"><b>Nombre Estudiante</b></td>
            <td id="" colspan="3"><b>Documento</b></td>
        </tr>
        <tr>
            <td colspan="5"><?php echo $row_dataestudiante['nombre'];?></td>
            <td colspan="3"><?php echo $row_dataestudiante['numerodocumento'];?></td>
        </tr>
    </table>

    <table class="table table-bordered" style="width: 80%">
        <tr id="trtituloNaranjaInst">
            <td colspan="8"><b>DETALLE ORDEN DE PAGO</b></td>
        </tr>
        <tr>
            <td id="" colspan="2"><b>C&oacute;digo Concepto</b></td>
            <td id="" colspan="3"><b>Concepto</b></td>
            <td id="" colspan="1"><b>Cantidad</b></td>
            <td id="" colspan="2"><b>Valor</b></td>
        </tr>

<?php
        $banderadeudas = 0;
        $deuda="SELECT *
	FROM detalleordenpago d,concepto c,tipoconcepto t
	WHERE d.numeroordenpago = '$this->numeroordenpago'
	AND d.codigoconcepto = c.codigoconcepto
	AND c.codigotipoconcepto = t.codigotipoconcepto";        
        $query=mysql_query($deuda,$this->sala);
        $solucion=mysql_fetch_array($query);
        $fechaconpecuniarios = false;        


        do {
            if($solucion['codigoconcepto'] == '151')
                $esMatricula = true;
            if($solucion['codigotipodetalleordenpago'] == '2' )//&& $solucion['codigotipoconcepto'] == '01')
            {
                $banderadeudas = 1;
            }
            if($solucion['codigotipodetalleordenpago'] == '3' )//&& $solucion['codigotipoconcepto'] == '01')
            {
                $fechaconpecuniarios = true;
            }
            ?>
        <tr>
            <td colspan="2"><?php echo $solucion['codigoconcepto'];?></td>
            <td colspan="3">
    <?php echo $solucion['nombreconcepto'];
    if($solucion['codigotipoconcepto'] == 01) {
                        echo "(+)";
                    }
                    if($solucion['codigotipoconcepto'] == 02) {
                        echo "(-)";
                    }
                    ?>
            </td>
            <td colspan="1"><?php echo $solucion['cantidaddetalleordenpago'];?></td>
            <td colspan="2">$&nbsp;&nbsp;<?php echo number_format($solucion['valorconcepto'],2);?></td>
        </tr>
<?php
} while ($solucion=mysql_fetch_array($query));

	$aporteFlag = false;
	$aporte_becas = "SELECT
						c.nombreconcepto,
						c.codigoconcepto,
						v.valorpecuniario
					FROM
						AportesBecas a
					INNER JOIN valorpecuniario v ON v.idvalorpecuniario = a.idvalorpecuniario
					INNER JOIN concepto c ON c.codigoconcepto = v.codigoconcepto
					WHERE
						a.numeroordenpago = '$this->numeroordenpago'
					AND a.codigoestado = 400
					AND v.codigoestado = 100
					AND c.codigoestado = 100";
	$query_becas=mysql_query($aporte_becas,$this->sala);
	if(mysql_num_rows($query_becas)>0){
		$aporteFlag = true;
		$becas=mysql_fetch_array($query_becas);
?>

	<tr>
		<td colspan="2"><?php echo $becas['codigoconcepto'];?></td>
        <td colspan="3"><?php echo $becas['nombreconcepto'];?>(+)</td>
        <td colspan="1">1</td>
        <td colspan="2">$&nbsp;&nbsp;<?php echo number_format($becas['valorpecuniario'],2);?></td>
	</tr>

<?php
	}else{
		$becas['valorpecuniario'] = 0;
	}

?>
    </table>
    <table class="table table-bordered" style="width: 80%">
        <tr id="trtituloNaranjaInst">
            <td colspan="8" ><b>FECHAS DE PAGO</b></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Tipo de Matr&iacute;cula</b></td>
            <td colspan="2">
                <b>Paguese Hasta</b></td>
            <td colspan="2">
                <b>Total a Pagar sin aporte</b></td>
			<td colspan="2">
                <b>Total a Pagar con aporte</b>
        </tr>
<?php
//if(!ereg("^3.+$",$row_dataestudiante['codigoindicadortipocarrera']))
//{
        //===========================================
        
        //se traen las validaciones del estudiante
        require_once(dirname(__FILE__). "/../../../sala/includes/adaptador.php");
        require_once(dirname(__FILE__).'/../../consulta/prematricula/descuentos/descuento.php');
        $db = Factory::createDbo();
        $descuento = new Descuento($this->numeroordenpago,$this->codigoperiodo,$db);
                
        //=============================================

        $fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago
		from fechaordenpago f
		where f.numeroordenpago = '$this->numeroordenpago'
		order by f.porcentajefechaordenpago";

        $queryfechas=mysql_query($fecha,$this->sala);
        $fechas=mysql_fetch_array($queryfechas);

        $cuentafecha = 1; 
        do {
            $nombrePago = $descuento->visualizarHeaderDescuento($cuentafecha);            

            if($aporteFlag == true){
                $aporteAPagar = $becas['valorpecuniario'] + $fechas['valorfechaordenpago'];
            }else{
                $aporteAPagar = 0;
            }
                    ?>
                <tr>
                    <td colspan="2"><?php echo $nombrePago;?></td>
                    <td colspan="2"><?php echo $fechas['fechaordenpago'];?></td>
                    <td colspan="2">$&nbsp;<?php echo number_format($fechas['valorfechaordenpago'],2);?></td>
                    <td colspan="2">$&nbsp;<?php echo number_format($aporteAPagar,2);?></td>
                </tr>
            <?php            
            $cuentafecha ++;            
        }
        while($fechas=mysql_fetch_array($queryfechas));


        ?>
