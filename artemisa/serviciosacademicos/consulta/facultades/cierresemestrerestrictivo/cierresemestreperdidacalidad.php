<?php
///////////////// borrar ///////////////////////
/*require_once('../../../Connections/sala2.php');
$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR);

require('funcionequivalenciapromedio.php');
$periodoactual = 20071;
$codigoestudiante = 30866;
$fechahoy = date("Y-m-d");
$usuario= "admintecnologia";*/
//////////////////////////////////////////////
unset($Arregloequivalencias);
mysql_select_db($database_sala, $sala);
$query_creditos = " SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante,pe.idplanestudio
					FROM prematricula p,detalleprematricula d,materia m,grupo g,planestudioestudiante pe
					WHERE  p.codigoestudiante = '$codigoestudiante'
					and p.codigoestudiante = pe.codigoestudiante
					AND p.idprematricula = d.idprematricula
					AND d.codigomateria = m.codigomateria
					AND d.idgrupo = g.idgrupo
					AND m.codigoestadomateria = '01'
					AND g.codigoperiodo = '$periodoactual'
					AND p.codigoestadoprematricula LIKE '4%'
					AND d.codigoestadodetalleprematricula LIKE '3%'";
					//echo $query_creditos,"<br>";
$res_creditos = mysql_query($query_creditos, $sala) or die(mysql_error());
$solicitud_creditos = mysql_fetch_assoc($res_creditos);
$creditossemestre = 0;
$indicadormateriasperdidas = 0;

	do {
		$creditossemestre = $creditossemestre + $solicitud_creditos['numerocreditos'];
/////////////////////////////////////////////////////////////

	   $equivalencia = seleccionarequivalencias1($solicitud_creditos['codigomateria'],$solicitud_creditos['idplanestudio'],$sala);
	   //echo $equivalencia,"<br>";
	   $Arregloequivalencias = seleccionarequivalencias($equivalencia,$solicitud_creditos['idplanestudio'],$sala);

	   if ($equivalencia == "")
	    {
		 //echo $solicitud_creditos['codigomateria'],"<br><br><br>";
		 $Arregloequivalencias[] = $solicitud_creditos['codigomateria'];
		}
	    $Arregloequivalencias[] = $equivalencia;
		$cuentamateriaperdida = 0;
        if(!array_search($solicitud_creditos['codigomateria'], $Arregloequivalencias))
            $Arregloequivalencias[] = $solicitud_creditos['codigomateria'];
		foreach($Arregloequivalencias as $key3 => $selEquivalencias)
		{ // foreach

		  if($selEquivalencias <> "")
		   {
			 $query_historico = "SELECT n.notadefinitiva,m.notaminimaaprobatoria
								FROM notahistorico n,materia m
								WHERE n.codigoestudiante = '".$codigoestudiante."'
								and n.codigomateria = '$selEquivalencias'
								and n.codigomateria = m.codigomateria
								and n.codigoestadonotahistorico like '1%'";
								//echo $query_historico,"qq<br><br><br>";
			$res_historico = mysql_query($query_historico, $sala) or die(mysql_error());
			$solicitud_historico = mysql_fetch_assoc($res_historico);
		   }
		if ($solicitud_historico <> "")
		{
			do {
				  // echo $selEquivalencias,"&nbsp;&nbsp;&nbsp;",$solicitud_historico['notadefinitiva'],"&nbsp;",$solicitud_historico['notaminimaaprobatoria'],"aca<br>";
				   if ($solicitud_historico['notadefinitiva'] < $solicitud_historico['notaminimaaprobatoria'])
					 {
					   $cuentamateriaperdida ++;
					 }
					else
				  if ($solicitud_historico['notadefinitiva'] >= $solicitud_historico['notaminimaaprobatoria'])
					 {
					   $cuentamateriaperdida = 0;

					 }

			 }while($solicitud_historico = mysql_fetch_assoc($res_historico));

		     // echo $cuentamateriaperdida,"perdida<br>";
		      if ($cuentamateriaperdida > 1)
			   {
				 $indicadormateriasperdidas = 1;
			   }
		}
//////////////////////////////////////////////////////////////
    // echo $indicadormateriasperdidas,"indicador<br>";
   } // foreach

 }while($solicitud_creditos = mysql_fetch_assoc($res_creditos));

//exit();

							 //echo $creditossemestre."<br>";
						    /*************************************/
							$query_materia = "SELECT *
											    FROM notahistorico n,materia m
											    WHERE n.codigoestudiante = '".$codigoestudiante."'
												and n.codigomateria = m.codigomateria
												AND n.codigoperiodo = '$periodoactual'
												AND n.codigotiponotahistorico like '10%'
												and n.codigoestadonotahistorico like '1%'";
							//echo $query_materia,"</br>";
							$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
							$solicitud_materia = mysql_fetch_assoc($res_materia);
							$creditosperdidos = 0;
							$notatotal = 0;
		                    $creditos  = 0;
							$promediosemestralperiodo = 0;
							do {
							     //echo $solicitud_materia['notadefinitiva'],"&nbsp;&nbsp;",$solicitud_materia['notaminimaaprobatoria'],"<br>";
							      $notatotal = $notatotal + ($solicitud_materia['notadefinitiva'] * $solicitud_materia['numerocreditos']) ;
		                          $creditos = $creditos + $solicitud_materia['numerocreditos'];

								if ($solicitud_materia['notadefinitiva'] < $solicitud_materia['notaminimaaprobatoria'])
								     {
								       $creditosperdidos = $creditosperdidos +  $solicitud_materia['numerocreditos'];
        							 }
							}while($solicitud_materia = mysql_fetch_assoc($res_materia));

							//$promediosemestralperiodo = (number_format($notatotal/$creditos,1));
							//@$promediototal = number_format($notatotal/$creditos,1);
							//$promediosemestralperiodo=round($promediototal * 10)/10;
							@$promediototal = $notatotal/$creditos;
							$promediosemestralperiodo = redondeo($promediototal);
							//echo $promediosemestralperiodo,"->>>>>>>>>>>>";
							unset($Arregloequivalencias);
							$carreraestudiante = $_SESSION['codigofacultad'];

							///require('calculopromedioacumulado.php');
							$promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);
							$calculoperdida = $creditossemestre / 2;
							//echo $indicadormateriasperdidas ;
							//echo $codigoestudiante,"&nbsp;",$creditosperdidos,">=&nbsp;",$calculoperdida,"&nbsp;",$indicadormateriasperdidas,"&nbsp;",$promedioacumulado,"&nbsp;"/*,$numero*/,"<br>";
							    $cambiosituacion = 100;
								$query_historicosituacion = "select *
								from historicosituacionestudiante
								where codigoestudiante = '".$codigoestudiante."'
								order by 1 desc
								";
								$historicosituacion = mysql_query($query_historicosituacion, $sala) or die("$query_historicosituacion".mysql_error());
								$row_historicosituacion = mysql_fetch_assoc($historicosituacion);
								$totalRows_historicosituacion = mysql_num_rows($historicosituacion);

							if (($creditosperdidos >= $calculoperdida) or ($indicadormateriasperdidas == 1) or ($promedioacumulado < 3.3 and $row_historicosituacion['codigosituacioncarreraestudiante'] == 200) )//
							  {
								$query_historicosituacionhoy = "select *
								from historicosituacionestudiante
								where codigoestudiante = '".$codigoestudiante."'
								and fechainiciohistoricosituacionestudiante LIKE '".date("Y-m-d")."%'
								order by 1 desc
								";
								$historicosituacionhoy = mysql_query($query_historicosituacionhoy, $sala) or die("$query_historicosituacionhoy".mysql_error());
								$row_historicosituacionhoy = mysql_fetch_assoc($historicosituacionhoy);
								$totalRows_historicosituacionhoy = mysql_num_rows($historicosituacionhoy);

								if ($row_historicosituacionhoy == "")
								{
								 if($row_historicosituacion['codigosituacioncarreraestudiante'] <> $cambiosituacion)
								 {
									 $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
									 $sql.= "VALUES('0','".$codigoestudiante."','$cambiosituacion','".$periodoactual."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."')";
									 //echo $sql,"<br>";
									 $result = mysql_query($sql,$sala);

								    $query_updest1 = "UPDATE historicosituacionestudiante
									SET fechafinalhistoricosituacionestudiante = '".$fechahoy."'
									WHERE idhistoricosituacionestudiante = '".$row_historicosituacion['idhistoricosituacionestudiante']."'";
									$updest1 = mysql_query($query_updest1,$sala);
								 }

									$base1= "update estudiante set
									codigosituacioncarreraestudiante ='$cambiosituacion'
									where  codigoestudiante = '".$codigoestudiante."'";
									$sol1=mysql_db_query($database_sala,$base1);
							   }
							  }
							 else
							 if ($promediosemestralperiodo < 3.3 or $promedioacumulado < 3.3)
							 {
							    $cambiosituacion = 200;

								$query_historicosituacion = "select *
								from historicosituacionestudiante
								where codigoestudiante = '".$codigoestudiante."'
								order by 1 desc
								";
								$historicosituacion = mysql_query($query_historicosituacion, $sala) or die("$query_historicosituacion".mysql_error());
								$row_historicosituacion = mysql_fetch_assoc($historicosituacion);
								$totalRows_historicosituacion = mysql_num_rows($historicosituacion);

								$query_historicosituacionhoy = "select *
								from historicosituacionestudiante
								where codigoestudiante = '".$codigoestudiante."'
								and fechainiciohistoricosituacionestudiante LIKE '".date("Y-m-d")."%'
								order by 1 desc
								";
								//echo $query_historicosituacionhoy;
								$historicosituacionhoy = mysql_query($query_historicosituacionhoy, $sala) or die("$query_historicosituacionhoy".mysql_error());
								$row_historicosituacionhoy = mysql_fetch_assoc($historicosituacionhoy);
								$totalRows_historicosituacionhoy = mysql_num_rows($historicosituacionhoy);

								if ($row_historicosituacionhoy == "")
								{

								 if($row_historicosituacion['codigosituacioncarreraestudiante'] <> $cambiosituacion)
								 {
								 $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
								 $sql.= "VALUES('0','".$codigoestudiante."','$cambiosituacion','".$periodoactual."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."')";
								 //echo $sql,"<br>";
								 $result = mysql_query($sql,$sala);

								   $query_updest1 = "UPDATE historicosituacionestudiante
									SET fechafinalhistoricosituacionestudiante = '".$fechahoy."'
									WHERE idhistoricosituacionestudiante = '".$row_historicosituacion['idhistoricosituacionestudiante']."'";
									$updest1 = mysql_query($query_updest1,$sala);
								 }

								$base1= "update estudiante set
								codigosituacioncarreraestudiante ='$cambiosituacion'
								where  codigoestudiante = '".$codigoestudiante."'";
							    $sol1=mysql_db_query($database_sala,$base1);
							  }
							 }
							 else
							 {
							    $cambiosituacion = 301;

								$query_historicosituacion = "select *
								from historicosituacionestudiante
								where codigoestudiante = '".$codigoestudiante."'
								order by 1 desc
								";
								$historicosituacion = mysql_query($query_historicosituacion, $sala) or die("$query_historicosituacion".mysql_error());
								$row_historicosituacion = mysql_fetch_assoc($historicosituacion);
								$totalRows_historicosituacion = mysql_num_rows($historicosituacion);

								$query_historicosituacionhoy = "select *
								from historicosituacionestudiante
								where codigoestudiante = '".$codigoestudiante."'
								and fechainiciohistoricosituacionestudiante LIKE '".date("Y-m-d")."%'
								order by 1 desc
								";
								$historicosituacionhoy = mysql_query($query_historicosituacionhoy, $sala) or die("$query_historicosituacionhoy".mysql_error());
								$row_historicosituacionhoy = mysql_fetch_assoc($historicosituacionhoy);
								$totalRows_historicosituacionhoy = mysql_num_rows($historicosituacionhoy);

								if ($row_historicosituacionhoy == "")
								{
								 if($row_historicosituacion['codigosituacioncarreraestudiante'] <> $cambiosituacion)
								 {
								 $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
								 $sql.= "VALUES('0','".$codigoestudiante."','$cambiosituacion','".$periodoactual."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."')";
								 //echo $sql,"<br>";
								 $result = mysql_query($sql,$sala);

								   $query_updest1 = "UPDATE historicosituacionestudiante
									SET fechafinalhistoricosituacionestudiante = '".$fechahoy."'
									WHERE idhistoricosituacionestudiante = '".$row_historicosituacion['idhistoricosituacionestudiante']."'";
									$updest1 = mysql_query($query_updest1,$sala);
								 }

								$base1= "update estudiante set
								codigosituacioncarreraestudiante ='$cambiosituacion'
								where  codigoestudiante = '".$codigoestudiante."'";
							    $sol1=mysql_db_query($database_sala,$base1);
							  }
							 }
unset($Arregloequivalencias);
?>