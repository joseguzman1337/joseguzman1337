<?php
function horariovalido($grupos, $codigoperiodo, $sala)
{
	//echo "<h1>Entro</h1>";
	foreach($grupos as $key => $identgrupo)
	{
		$query_horarioselegidos = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, g.codigomateria
		from horario h, dia d, salon s, grupo g
		where h.codigodia = d.codigodia
		and h.codigosalon = s.codigosalon
		and h.idgrupo = '$identgrupo'
		and g.idgrupo = h.idgrupo
		and g.codigoindicadorhorario like '1%'
		and g.codigoperiodo = '$codigoperiodo'
		order by 1,3,4";
		//echo $query_horarioselegidos."<br>go<br>";
		$horarioselegidos=mysql_query($query_horarioselegidos, $sala) or die("$query_horarioselegidos");
		$totalRows_horarioselegidos = mysql_num_rows($horarioselegidos);
			
		while($row_horarioselegidos = mysql_fetch_array($horarioselegidos))
		{
			$codigomateriahorarios[] = $row_horarioselegidos['codigomateria'];
			$diahorarios[] = $row_horarioselegidos['codigodia'];
			$horainicialhorarios[] = $row_horarioselegidos['horainicial'];
			$horafinalhorarios[] = $row_horarioselegidos['horafinal'];
		}
	}
	$maximohorarios = count($codigomateriahorarios)-1;
	//echo "<br><br>$maximohorarios = count($codigomateriahorarios)-1;<br>";
	for($llavehorario1 = 0; $llavehorario1 <= $maximohorarios; $llavehorario1++) 
  	{
   		for($llavehorario2 = 0; $llavehorario2 <= $maximohorarios; $llavehorario2++) 
     	{	  
	  		//echo "if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)<br>";
			if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)
	    	{
		  		//echo "if((date('H-i-s',strtotime($horainicialhorarios[$llavehorario1])) >= date('H-i-s',strtotime($horainicialhorarios[$llavehorario2])))and(date('H-i-s',strtotime($horainicialhorarios[$llavehorario1])) < date('H-i-s',strtotime($horafinalhorarios[$llavehorario2]))))<br>";
				if((date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) >= date("H-i-s",strtotime($horainicialhorarios[$llavehorario2])))and(date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) < date("H-i-s",strtotime($horafinalhorarios[$llavehorario2]))))
		      	{				         
					//exit();
					//echo 'FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE '.$codigomateriahorarios[$llavehorario1].' Y  '.$codigomateriahorarios[$llavehorario2].'"<br>';
					return false;
					/*echo "<script language='javascript'>
						window.location.reload('matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial');
					</script>";*/
				 	// echo "<font color=\"#003333\">FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE&nbsp;<strong>",$codigomateria[$c]," </strong>&nbsp; Y  &nbsp;<strong>",$codigomateria[$b],"</strong></br>";			     
				 	$llavehorario1 = $maximohorarios+1;
				 	$llavehorario2 = $maximohorarios+1;
				}
		   	}
		}
	}
	return true;
}

function recorrearbol($materiaraiz, $gruposelegidos, $codigoperiodo, $sala)
{
	foreach($materiaraiz as $grupoeleg => $steLlave)
	{
		//echo "<br> CUENTA HERMANOS de M0 : ".count($steMateria)."<br>";;
		foreach($steLlave as $llavegrupo => $steMateria)
		{
			$gruposelegidos[] = $grupoeleg;
			if($steMateria == 0)
			{
				if(horariovalido($gruposelegidos, $codigoperiodo, $sala))
				{
					return true;
				}
				else
				{
					// Quiar ultimo elemento del arreglo de grupos
					array_pop($gruposelegidos);
				}
			}	 
			else
			{
				//echo "gruposelegidos = $grupoeleg  Tamaño ::: ".count($gruposelegidos)."<br>";
				// Selecciona la siguiente materia
				//echo "recorrearbol($steMateria, $gruposelegidos, $codigoperiodo, $raiz, $sala)";
				if(!recorrearbol($steMateria, &$gruposelegidos, $codigoperiodo, $sala))
				{
					// Quita ultimo elemento del arreglo de grupos
					array_pop($gruposelegidos);
				}
				else
				{
					return true;
				}
			}
		}
	}
}

?>