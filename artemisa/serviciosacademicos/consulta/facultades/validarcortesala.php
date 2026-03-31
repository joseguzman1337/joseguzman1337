<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	session_start();
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;    
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
	$total=0;
	 for($i = 1; $i <= $_POST['cantidadcortes'] ; $i++)
	  {
	    $total+=$_POST['porcentaje'.$i];
	  }

	if ($total>100){
		echo "<font size='2' face='Tahoma'>El porcentaje total debe ser 100%";
	} else if ($total<100){
		echo "<font size='2' face='Tahoma'>El porcentaje no debe ser menor al 100%";
	} else if ($total=100){

		$fechamenor=0;
			for ($r=1;$r<=$_POST['cantidadcortes'];$r++){
				$fecha1=mktime(0,0,0,$_POST['mesini'.$r],$_POST['diaini'.$r],$_POST['ano']);
				$fecha2=mktime(0,0,0,$_POST['mesfin'.$r],$_POST['diafin'.$r],$_POST['ano']);
				$resultdate=$fecha2-$fecha1;				
				if ($resultdate<=0){
					$fechamenor+=1;
				}
			}
			$fechacruzada=0;
			for($t=1;$t<$_POST['cantidadcortes'];$t++) {
				$fechafin=mktime(0,0,0,$_POST['mesfin'.$t],$_POST['diafin'.$t],$_POST['ano']);
				$fechaini=mktime(0,0,0,$_POST['mesini'.($t+1)],$_POST['diaini'.($t+1)],$_POST['ano']);
				$resultadocruce=$fechaini-$fechafin;
				if ($resultadocruce<=0) {
					$fechacruzada+=1;
				}
			}		
			//echo $fechamenor;
			if ($fechamenor==0){

				if ($fechacruzada==0) {

					if ($_POST['materia1']==1){

						$colname1_facultad = "0";

						if (isset($_SESSION['codigofacultad'])) {

						  $colname1_facultad = (get_magic_quotes_gpc()) ? $_SESSION['codigofacultad'] : addslashes($_SESSION['codigofacultad']);

						}

						mysql_select_db($database_sala, $sala);
						$query_facultad = "SELECT * 
                        FROM corte 
					    WHERE codigocarrera = '$colname1_facultad'
					    and codigoperiodo = '".$row_periodo['codigoperiodo']."'";
						$facultad = mysql_query($query_facultad, $sala) or die(mysql_error());
						$row_facultad = mysql_fetch_assoc($facultad);
						$totalRows_facultad = mysql_num_rows($facultad);

						if ($totalRows_facultad==0) {
							echo " <table width='43%'  border='1' cellpadding='2' bordercolor='#003333'>
									  <tr>
										<th scope='col'><div bgcolor='#C5D5D6'><font size='2' face='Tahoma'><strong>Facultad</strong></th>
										<th scope='col'><div bgcolor='#C5D5D6'><font size='2' face='Tahoma'><strong>Corte</strong></th>
										<th scope='col'><div bgcolor='#C5D5D6'><font size='2' face='Tahoma'><strong>Fecha Inicial</strong></th>
										<th scope='col'><div bgcolor='#C5D5D6'><font size='2' face='Tahoma'><strong>Fecha Final</strong></th>
										<th scope='col'><div bgcolor='#C5D5D6'><font size='2' face='Tahoma'><strong>Porcentaje</strong></th>
									  </tr>";
							for ($r=1;$r<=$_POST['cantidadcortes'];$r++){
								echo "<tr>";
								$fecha1="".$_POST['ano']."-".$_POST['mesini'.$r]."-".$_POST['diaini'.$r];
								$fecha2="".$_POST['ano']."-".$_POST['mesfin'.$r]."-".$_POST['diafin'.$r];												   
					   

							      $insertSQL = "INSERT INTO corte (codigocarrera, codigoperiodo,codigomateria,numerocorte, fechainicialcorte, fechafinalcorte, porcentajecorte,usuario)"; 
							      $insertSQL.= "VALUES (
			    	               '".$_SESSION['codigofacultad']."',
								   '".$_POST['codigoperiodo']."',
								   '1',											   
								   '".$r."',
								   '".$fecha1."',
								   '".$fecha2."',
								   '".$_POST['porcentaje'.$r]."',
								   '".$_SESSION['codigofacultad']."')";
								//echo $insertSQL;
								//exit();
								mysql_select_db($database_sala, $sala);
								$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
								echo "<td align='center'><font size='2' face='Tahoma'>".$_SESSION['codigofacultad']."</td>";
								echo "<td align='center'><font size='2' face='Tahoma'>".$r."</td>";
								echo "<td align='center'><font size='2' face='Tahoma'>".$fecha1."</td>";
								echo "<td align='center'><font size='2' face='Tahoma'>".$fecha2."</td>";
								echo "<td align='center'><font size='2' face='Tahoma'>".$_POST['porcentaje'.$r]."</td>";
								echo "</tr>";

							}

						} else {

							echo "<font size='2' face='Tahoma'>Usted ya ha digitado el corte para todas las materias";

						}

					} else{

						$colname1_materia = "0";

						if (isset($_POST['materia1'])) {

						  $colname1_materia = (get_magic_quotes_gpc()) ? $_POST['materia1'] : addslashes($_POST['materia']);

						}
						mysql_select_db($database_sala, $sala);
						$query_materia = "SELECT * FROM corte 
	                    WHERE codigomateria = '".$colname1_materia."'
                    	and codigoperiodo = '".$row_periodo['codigoperiodo']."'";
						$materia = mysql_query($query_materia, $sala) or die(mysql_error());
						$row_materia = mysql_fetch_assoc($materia);
						$totalRows_materia = mysql_num_rows($materia);

						if ($totalRows_materia==0){

							echo " <table width='43%'  border='1' cellpadding='2' bordercolor=#003333>

									  <tr bgcolor='#C5D5D6'>

										<th scope='col'><font size='2' face='Tahoma'><strong>Materia</strong></th>

										<th scope='col'><font size='2' face='Tahoma'><strong>Corte</strong></th>

										<th scope='col'><font size='2' face='Tahoma'><strong>Fecha Inicial</strong></th>

										<th scope='col'><font size='2' face='Tahoma'><strong>Fecha Final</strong></th>

										<th scope='col'><font size='2' face='Tahoma'><strong>Porcentaje</strong></th>

									  </tr>";

							for ($r=1;$r<=$_POST['cantidadcortes'];$r++){

								echo"<tr>";

								$fecha1="".$_POST['ano']."-".$_POST['mesini'.$r]."-".$_POST['diaini'.$r];

								$fecha2="".$_POST['ano']."-".$_POST['mesfin'.$r]."-".$_POST['diafin'.$r];								

								

								$insertSQL = "INSERT INTO corte (codigocarrera, codigoperiodo,codigomateria,numerocorte, fechainicialcorte, fechafinalcorte, porcentajecorte,usuario)"; 
						        $insertSQL.= "VALUES (
					            '1',
							    '".$_POST['codigoperiodo']."',
								'".$_POST['materia1']."',											  
								'".$r."',
								'".$fecha1."',
								'".$fecha2."',
								'".$_POST['porcentaje'.$r]."',
								'".$_SESSION['codigofacultad']."')";	
								// echo $insertSQL;						
								mysql_select_db($database_sala, $sala);
								$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());

								echo "<td align='center'><font size='2' face='Tahoma'>".$_POST['materia']."</td>";

								echo "<td align='center'><font size='2' face='Tahoma'>".$r."</td>";

								echo "<td align='center'><font size='2' face='Tahoma'>".$fecha1."</td>";

								echo "<td align='center'><font size='2' face='Tahoma'>".$fecha2."</td>";

								echo "<td align='center'><font size='2' face='Tahoma'>".$_POST['porcentaje'.$r]."</td>";

								echo "</tr>";								

							}

						}else {

							echo "<font size='2' face='Tahoma'>Usted ya digitó el corte para esta materia";

						}

					}

				} else {

					echo "<br><font size='2' face='Tahoma'>Hay ".$fechacruzada." fecha(s) de el corte ".$longi." que se cruzan con las fechas de inicio de corte"; 				

				}

									

			}else {

				echo "<br><font size='2' face='Tahoma'>Hay ".$fechamenor." fecha(s) de el corte  ".$longi." que son menores a la fecha de inicio"; 

			}

		}else {

			echo "<font size='2' face='Tahoma'>Debe selecionar los cortes en orden";

		}

	//} 

?>