<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

function getHorario($codigomateria, $codigoperiodo, $codigoestudiante)
{
	global $sala;
	
	//$html = 'probando';
	$html = '
<p style="font-size: 8px;">HORARIO</p>
';
	
$query_datosmateria = " SELECT m.codigomateria, m.nombremateria, d.idgrupo
                        FROM detalleprematricula d
                        , prematricula p
                        , materia m
                        , estudiante e
                        , estadodetalleprematricula edp
                        where d.codigomateria = m.codigomateria 
                                and d.idprematricula = p.idprematricula
                                and p.codigoestudiante = e.codigoestudiante
                                and e.codigoestudiante = '$codigoestudiante'
                                and edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula
                                and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                                and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
                                and m.codigomateria = '$codigomateria'";

//and m.codigotipomateria = '4'";
$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
$totalRows_datosmateria = mysql_num_rows($datosmateria);
if($totalRows_datosmateria != "")
{
	//while($row_datosmateria = mysql_fetch_array($datosmateria))
	$row_datosmateria = mysql_fetch_array($datosmateria);
	{
		// Arreglo que guarda el nombre de las materias
		$nombresmateria[$codigomateria] = $row_datosmateria['nombremateria'];
		$html .= '
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;">
    <tr> 
      <td colspan="8" style="border-bottom-color:#000000"><label id="labelresaltado">'.$row_datosmateria['nombremateria'].'</label></td>
      <td id="tdtitulogris" style="border-top-color:#000000; border-left-color:#000000; border-bottom-color:#000000">Código</td>
      <td style="border-top-color:#000000; border-right-color:#000000; border-bottom-color:#000000">'.$row_datosmateria['codigomateria'].'</td>
    </tr>
';
		
		//Selecciona los datos de los grupos para una materia   
		$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, 
		g.maximogrupo,  g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, 
		g.codigoindicadorhorario, g.nombregrupo, g.fechainiciogrupo, g.fechafinalgrupo 
		from grupo g, docente d
		where g.numerodocumento = d.numerodocumento
		and g.codigomateria = '$codigomateria'
		and g.idgrupo = '".$row_datosmateria['idgrupo']."'
		and g.codigoestadogrupo = '10'";				
		$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
		$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		$grupoencontrado = false;
			
		if($totalRows_datosgrupos != "")
		{
			$tieneprimergrupoconhorarios = 0;
			$grupoencontrado = true;
			unset($desabilitardesabilitar);
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Selecciona los datos de los horarios
				$query_datoshorarios = "select h.codigodia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, d.nombredia,h.idhorario
				from horario h, dia d, salon s
				where h.codigodia = d.codigodia
				and h.codigosalon = s.codigosalon
				and h.idgrupo = '".$row_datosgrupos['idgrupo']."'
				order by 1,2,3";
				$datoshorarios=mysql_query($query_datoshorarios, $sala) or die("$query_datoshorarios");
				//echo "$query_datoshorarios<br>";
				$totalRows_datoshorarios = mysql_num_rows($datoshorarios);
				$total = $row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva'];
				$html .= '
    <tr> 
      <td id="tdtitulogris" style="border-top-color:#000000">Grupo</td>
      <td style="border-top-color:#000000">'.$row_datosgrupos['idgrupo'].'</td>
      <td id="tdtitulogris" style="border-top-color:#000000">Docente</td>
      <td style="border-top-color:#000000">'.$row_datosgrupos['nombre'].'</td>
      <td id="tdtitulogris" style="border-top-color:#000000">Nombre Grupo</td>
      <td style="border-top-color:#000000">'.$row_datosgrupos['nombregrupo'].'</td>
	  <td id="tdtitulogris" style="border-top-color:#000000">Max. Grupo</td>
      <td style="border-top-color:#000000">'.$row_datosgrupos['maximogrupo'].'</td>
      <td id="tdtitulogris" style="border-top-color:#000000">Matri./Prematri.</td>
      <td style="border-top-color:#000000">'.$total.'</td>
    </tr>
	<tr>
	<td colspan="10">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
	<tr>
      <td><strong>Fecha de Inicio</strong></td>
      <td>'.$row_datosgrupos['fechainiciogrupo'].'</td>
	  <td><strong>Fecha de Vencimiento</strong></td>
      <td>'.$row_datosgrupos['fechafinalgrupo'].'</td>
	';
				if(ereg("^1+",$row_datosgrupos['codigoindicadorhorario']))
				{
					if($totalRows_datoshorarios != "")
					{
						$tieneprimergrupoconhorarios++;
						$html .= '
	    <tr id="trtitulogris"> 
		  <td>D&iacute;a</td>
		  <td>Hora Inicial</td>
		  <td>Hora Final</td>
		  <td>Sal&oacute;n</td>
 	    </tr>
 	    ';

 	    				while($row_datoshorarios = mysql_fetch_array($datoshorarios))
						{
							$tieneprimergrupoconhorarios++;
							$html .= '
		    <tr>
		  <td>'.$row_datoshorarios['nombredia'].'</td>
		  <td>'.$row_datoshorarios['horainicial'].'</td>
		  <td>'.$row_datoshorarios['horafinal'].'</td>
		  <td>'.$row_datoshorarios['codigosalon'].'</td>
	    </tr>
	    ';
	    					}
					}
					else
					{
						$horariorequerido = true;
						$desabilitardesabilitar=1;
						$html .= '
	<tr>
	  <td colspan="11"><label id="labelresaltado">Este grupo requiere horario, dirijase a su facultad para informarlo.</label></td>
	</tr>
						';
					}
				}
				else
				{
					//continue;
					$html .= '
	<tr>
	  <td colspan="11"><label id="labelresaltado">Este grupo no necesita horario.</label></td>
	</tr>
					';
				}
$html .= '
</table>
</td>
</tr>
';
			}
			if(!$grupoencontrado)
			{
				foreach($materiaselegidas as $key => $value)
				{
					$html .= '
<tr>
  <td colspan="11"><label id="labelresaltado">Esta materia 1 no tiene grupos, informelo a la facultad. Regrese y deseleccione la materia, o si continua no le ser&aacute; adicionada la materia.</label></td>
</tr>
					';
				}
			}
$html .= '
<tr><td colspan="11">&nbsp;</td></tr>
</table>
';
		}
		else
		{
			$html .= '					
<tr>
  <td colspan="11"><label id="labelresaltado">Esta materia no tiene grupos, informelo a la facultad. Regrese y deseleccione la materia, o si continua no le ser&aacute; adicionada la materia.</label></td>
</tr>
				';
		}
	}
}else{
	$html .= 'La materia no tiene horarios ni grupos, informelo a la facultad';
}
$html = trim($html);
$sustituye = array("\r\n", "\n\r", "\n", "\r");
$html = str_replace($sustituye, "", $html);  
$html = ereg_replace("\"","",$html);
$html =  trim($html);
return $html;
}

?>
