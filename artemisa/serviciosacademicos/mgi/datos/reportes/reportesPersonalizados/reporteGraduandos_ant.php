<?PHP 

// VALORES INICIALES PARA EL REPORTE
$periodo_inicial='20101';
$periodo_final='20131';
$arrIndicadores = array( "NÚMERO DE GRADUADOS DE LA COHORTE HASTA UN AÑO LUEGO DE LA FINALIZACIÓN"
			,"NÚMERO DE MATRICULADOS PRIMERA VEZ EN EL PRIMER SEMESTRE"
			,"ÍNDICE DE ESFUERZO DE FORMACIÓN"
			,"DURACIÓN DE ESTUDIOS: NÚMERO DE SEMESTRES QUE DURÓ EL ESTUDIANTE PARA GRADUARSE"
			,"ESTUDIANTES QUE SIGUEN SIENDO ESTUDIANTES TRES SEMESTRES DESPUES"
			,"ESTUDIANTES QUE DESERTAN"
			,"INDICADOR DE RETENCIÓN ESTUDIANTIL");







?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>           
		<tr id="dataColumns"> 
			<th class="column" colspan="2">&nbsp;</th>
<?PHP 
		$query="select codigoperiodo from periodo where codigoperiodo between ".$periodo_inicial." and ".$periodo_final." order by codigoperiodo";
		$exec= $db->Execute($query);
		$cont=0;
		while($row = $exec->FetchRow()) {  
			$cont++;
?>
			<th class="column" colspan='<?PHP echo count($arrIndicadores)?>'><span>A&Ntilde;O <?PHP echo $row['codigoperiodo']?></span></th>
<?PHP  		} 
?>
		</tr>
		<tr id="dataColumns"> 
			<th class="column" colspan="2">&nbsp;</th>
<?PHP 
			for($i=1;$i<=$cont;$i++) {
				foreach ($arrIndicadores as &$valor) { 
?>
					<th class="column"><span><?PHP echo $valor?></span></th>
<?PHP 
				}
			}
?>
		</tr>
        </thead>
        <tbody>
        </tbody>        
<!--
           
                <tr id="contentColumns" class="row">
                    <td class="column">Prueba</td>                                
                    
                        <td style="text-align:center"> Prueba</td>
                </tr>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                 
                    <td style="text-align:center"> 100</td>
            </tr>
        </tfoot>
-->
</table>
