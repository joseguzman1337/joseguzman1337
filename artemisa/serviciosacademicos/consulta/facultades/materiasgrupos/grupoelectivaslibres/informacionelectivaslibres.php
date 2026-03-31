<?php
	//este archivo es publico
    session_start();
	require_once('../../../../Connections/sala2.php');
	$rutaado = "../../../../funciones/adodb/";
	require_once('../../../../Connections/salaado.php');

	$query_periodo="select codigoperiodo from periodo where codigoestadoperiodo like '1%'";
	$row_periodo= $db->GetRow($query_periodo);
	$codigoperiodo=$row_periodo['codigoperiodo'];

	$query_grupomaterias="select * from grupomateria g where g.codigoperiodo='$codigoperiodo' and g.codigotipogrupomateria ='100' and g.nombregrupomateria like '%apoyo%'";
	$row_grupomaterias=$db->GetAll($query_grupomaterias);	
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="">
            <table border="0" align="center" cellpadding="3">
                <tr>
                    <td  colspan="3" valign="center"><img src="../../../../../imagenes/logo_electivasinstitucionales.gif" height="71"></td>
                </tr>
            </table><br>
            <table width="60%" border="1"  cellpadding="3" cellspacing="3" align="center">
                <?php
                $num=0;
				
				foreach($row_grupomaterias as $materiasgrupo)
				{
					$num++;
					$query_materias="select * ,m.codigomateria ,dgm.idgrupomateria from materia m,grupomateria gm,detallegrupomateria dgm where gm.codigoperiodo= '$codigoperiodo' and gm.idgrupomateria=dgm.idgrupomateria and m.codigomateria=dgm.codigomateria and gm.codigotipogrupomateria ='100' and dgm.idgrupomateria='".$materiasgrupo['idgrupomateria']."' group by m.codigomateria order by m.nombremateria ";
					 $row_materias= $db->GetAll($query_materias);
					?>
                    <tr id="trgris" >
                        <td colspan="2" align="left"><br><label id="labelresaltadogrande"><font size='5'><?php echo $num.". ".$materiasgrupo['nombregrupomateria']; ?></font></label><br><br></td>
                    </tr>
                    <?php
					foreach($row_materias as $materias)
					{
						 $query_grupos="SELECT * FROM materia mat, indicadorhorario i,grupo gru left join docente doc on  doc.codigoestado like '1%' AND gru.numerodocumento = doc.numerodocumento WHERE mat.codigomateria = gru.codigomateria and mat.codigoestadomateria like '01' AND gru.codigoperiodo = '$codigoperiodo' AND gru.codigomateria = mat.codigomateria AND gru.codigomateria = '".$materias['codigomateria']."'  and gru.codigoestadogrupo like '1%' and gru.codigoindicadorhorario = i.codigoindicadorhorario ";
						 $row_grupos = $db->GetAll($query_grupos);
						 $totalRows_grupos = count($row_grupos);
						?>
                        <tr>
                            <td align="center" id="tdtitulogris">
                            	<label id="labelresaltadogrande"><?php echo strtr(strtoupper($materias['nombremateria']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"); ?></label>	
                            </td>
                        </tr>
                        <?php
						foreach($row_grupos as $totalmaterias)
						{
							$query_totalmat="SELECT COUNT(p.codigoestudiante) AS numeromatriculados FROM detalleprematricula d, prematricula p, estudiante e WHERE d.idprematricula = p.idprematricula AND p.codigoestudiante = e.codigoestudiante AND (p.codigoestadoprematricula LIKE '1%' OR  p.codigoestadoprematricula LIKE '4%') and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%') AND d.idgrupo = '".$totalmaterias['idgrupo']."' AND p.codigoperiodo = '$codigoperiodo'";
							$row_totalmat = $db->GetRow($query_totalmat);
							
							$cupomateria=$totalmaterias['maximogrupo'] - $row_totalmat['numeromatriculados'];
                        	if($cupomateria < 0){
								$cupomateria=0;
                        	}
							
							$query_horario="SELECT h.codigodia, h.codigodia, h.horainicial, h.horafinal, d.nombredia, se.nombresede, s.nombresalon, s.codigosalon, h.codigotiposalon, t.nombretiposalon FROM horario h, dia d, salon s, tiposalon t, sede se WHERE h.codigodia = d.codigodia AND h.codigosalon = s.codigosalon AND h.codigotiposalon = t.codigotiposalon AND s.codigosede = se.codigosede AND h.idgrupo = '".$totalmaterias['idgrupo']."' order by 1,2,3,4";
							$row_horario = $db->GetAll($query_horario);
							$totalRows_horario = count($row_horario);
							if($totalRows_grupos != '0')
							{
                        	?>
                            <tr>
                                <td align="center" >       
                                    <table border="1" width="100%">
                                        <tr align="center">
                                            <td id="tdtitulogris" colspan="6">GRUPO&nbsp;<?php echo  strtr(strtoupper($totalmaterias['nombregrupo']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"); ?></td>
                                        </tr>
										 <tr align="center">
                                            <td width="25%" id="tdtitulogris" colspan="2">Cupo Total Materia</td>
                                            <td width="25%" id="tdtitulogris" colspan="2">Cupo Disponible Materia</td>
                                            <td width="50%" id="tdtitulogris" colspan="2">Nombre Docente</td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="2"><?php echo $totalmaterias['maximogrupo']; ?></td>
                                            <td colspan="2"><?php echo $cupomateria; ?></td>
                                            <td colspan="2"><?php echo strtoupper($totalmaterias['nombredocente']). " ".  strtoupper($totalmaterias['apellidodocente']); ?></td>
                                        </tr>
										<?php 
                                        if($totalRows_horario != '0'){
                                        ?>
                                        <tr align="center">
                                            <td colspan="6" id="tdtitulogris">HORARIO</td>
                                        </tr>
                                        <tr align="center">
                                            <td id="tdtitulogris">Día</td>
                                            <td id="tdtitulogris">Hora Inicial</td>
                                            <td id="tdtitulogris">Hora Final</td>
                                            <td id="tdtitulogris">Sede</td>
                                            <td id="tdtitulogris">Salón</td>
                                            <td id="tdtitulogris">Tipo</td>
                                        </tr>
                                            <?php
                                            foreach($row_horario as $horario){
                                            ?>
                                            <tr align="center">
                                                <td ><?php echo $horario['nombredia']; ?></td>
                                                <td ><?php echo $horario['horainicial']; ?></td>
                                                <td ><?php echo $horario['horafinal']; ?></td>
                                                <td ><?php echo $horario['nombresede']; ?></td>
                                                <td ><?php if ($horario['codigosalon'] == 1) { echo $horario['nombresalon']; } else { echo $horario['codigosalon']; }?></td>
                                                <td ><?php echo $horario['nombretiposalon']; ?></td>
                                            </tr>
                                        <?php
                                            }//foreach4
                                        }//if
								 		else{
                                        ?>
                                          <tr align="center">
                                            <td colspan="6" id="tdtitulogris">HORARIO</td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="6" >Asignatura Sin Horario Fijo</td>
                                        </tr>
                                        <?php
                                        }
										?>                                    
                                    </table>
                                    <br>
                                </td>
                            </tr>
							<?php
							}
							else {
                         	?>
                            <tr align="center">
                            	<td ><p>No existe GRUPO para esta Materia</p></td>
                            </tr>
                         	<?php
                            }//else
						}//foreach3
					}//foreach2
				}//foreach1
				?>
            </table>
        </form>
    </body>
</html>