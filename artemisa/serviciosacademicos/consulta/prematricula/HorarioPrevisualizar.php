<?php 
/* @modified Ivan quintero <quinteroivan@unbosque.edu.co>
*  @since  Enero 03, 2017
*  Ajuste de realpath 
*/
	require(realpath(dirname(__FILE__)).'/../../Connections/sala2.php'); 
   	$rutaado = "../../funciones/adodb/";
   	require(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');  
	//require_once("../../../kint/Kint.class.php");  
   
	$sala = $db->_connectionID;

	$grupo= $_POST['grupoid'];	
	if($grupo)
	{				
		$sqldatos = "SELECT h.codigodia, h.horainicial, h.horafinal, g.nombregrupo, 
							g.codigomateria, m.nombremateria, de.apellidodocente, de.nombredocente 
					   FROM horario h, dia d, salon s, grupo g, materia m, docente de 
					  WHERE h.codigodia = d.codigodia AND g.idgrupo = h.idgrupo AND h.codigosalon = s.codigosalon AND h.idgrupo = '".$grupo."' AND m.codigomateria = g.codigomateria AND g.numerodocumento = de.numerodocumento 
				   ORDER BY h.codigodia, h.horainicial, h.horafinal";
		//d( $sqldatos );
		$horarios = $db->GetAll($sqldatos);
		
		foreach($horarios as $datos)
		{
			$horainicial = explode(":",$datos['horainicial']);			
			$resultado['horai'][] =  $horainicial[0];
			$horafinal = explode(":",$datos['horafinal']);			
			$resultado['horaf'][] =  $horafinal[0];
			$resultado['dia'][] =  $datos['codigodia'];
			$resultado['grupo'][] = $datos['nombregrupo'];
			$resultado['idgrupo'][] = $grupo;
			$resultado['codmateria'][] = $datos['codigomateria'];
			$resultado['nombremateria'][] = $datos['nombremateria'];	
			$resultado['nombrecortomateria'][] = substr($datos['nombremateria'], 0, 13);	
			if($datos['nombredocente'] == 'SIN DEFINIR' || $datos['apellidodocente'] == 'SIN DEFINIR')
			{
				$resultado['docente'][] = 'SIN DEFINIR';				
			}else
			{
				$resultado['docente'][] = $datos['nombredocente']." ".$datos['apellidodocente'];				
			}
		}
						
		echo json_encode($resultado);		
	}
/* -- END -- */
?>