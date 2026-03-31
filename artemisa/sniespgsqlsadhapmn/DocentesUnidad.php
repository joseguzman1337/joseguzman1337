<script language="javascript">
function validar(){

	var largoannio=document.getElementById('annio').value.length+0;

	if(largoannio < 1){
		alert('Porfavor Digite Año');
	}
	//alert("Entro2="+largoannio;

	else if(document.getElementById('periodo').value.length < 1){
		alert('Porfavor Seleccione Periodo');
	}
	else if(document.getElementById('accion').value.length < 1){
		alert('Porfavor Seleccione Accion');
	}
	else{
		document.getElementById('form1').submit();
	}
}
</script>
<form name="form1" id="form1" action="" method="POST">
<table>
<tr>
	<td>Año</td>
	<td><input name="annio" id="annio" value="<?php echo $_POST['annio']?>"></td>
</tr>
<tr>
	<td>Periodo</td>
	<td>
	<select name="periodo" id="periodo">
		<option value="">Seleccionar</option>>
		<option value="1" <?php if($_POST['periodo']=='1')echo "selected"?>>01</option>
		<option value="2" <?php if($_POST['periodo']=='2')echo "selected"?>>02</option>
	</select>
	</td>
</tr>
<tr>
	<td>Accion</td>
	<td>
	<select name="accion" id="accion">
		<option value="">Seleccionar</option>>
		<option value="1" <?php if($_POST['accion']=='1')echo "selected"?>>Reportar</option>
		<option value="2" <?php if($_POST['accion']=='2')echo "selected"?>>Insertar</option>
	</select>
	</td>
</tr>
<tr>
	<td>Tipo</td>
	<td>
	<select name="tipo" id="tipo">
		<option value="1" <?php if($_POST['tipo']=='1')echo "selected"?>>Docente</option>
		<option value="2" <?php if($_POST['tipo']=='2')echo "selected"?>>Docente_Unidad</option>
		<option value="3" <?php if($_POST['tipo']=='3')echo "selected"?>>Docente_H</option>
		<option value="4" <?php if($_POST['tipo']=='4')echo "selected"?>>Resumen</option>
		
	</select>
	</td>
</tr>

</table>
<input name="Enviar" type="button" value="Enviar" onclick="validar()">
</form>
<?php
error_reporting(0);
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');
require_once 'Excel/reader.php';
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once("../serviciosacademicos/funciones/clases/motorv2/motor.php");
echo date("Y-m-d H:i:s"),"\n\n";
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('UTF-8');
				//$data->read("archivos/PARTICIPANTES2007II.xls");
				//echo count($data->sheets[0]['cells'])-1,"<br>";
				//DibujarTabla($data->sheets[0]['cells']);
				echo "<pre>";
				//print_r($data->sheets[0]['cellsInfo']);
				echo "</pre>";
				//se ingresa en participantes los datos basicos, para luego ingresar las autoridades (integridad ref)
				
				$data2 = new Spreadsheet_Excel_Reader();
				$data2->setOutputEncoding('UTF-8');
				$data2->read("archivos/DOCENTES2007II.xls");
				//echo "<table>";
				
					/*$filatres['dedic_code']="01";
					$filatres['dedic_descr']="Tiempo Completo";
					insertar_fila_bd($snies_conexion,'dedicacion',$filatres);
				
					$filatres['dedic_code']="02";
					$filatres['dedic_descr']="Medio Tiempo";
					insertar_fila_bd($snies_conexion,'dedicacion',$filatres);
				
					$filatres['dedic_code']="03";
					$filatres['dedic_descr']="Parcial";
					insertar_fila_bd($snies_conexion,'dedicacion',$filatres);
				
					$filatres['dedic_code']="04";
					$filatres['dedic_descr']="Catedra";
					insertar_fila_bd($snies_conexion,'dedicacion',$filatres);*/
				
				//if(isset($_GET['insertar']))
				foreach ($data2->sheets[0]['cells'] as $llave => $valor)
				{
					$fila['ies_code']=$valor[1];
					$fila['codigo_unico']=$valor[2];
					$fila['annio']=$_POST['annio'];
					$fila['semestre']="0".$_POST['periodo'];
					$fila['tipo_contrato']="02";
					$fila['porcentaje_docencia']="0";
					$fila['porcentaje_investigacion']="0";
					$fila['porcentaje_administrativa']="0";
					$fila['porcentaje_bienestar']="0";
					$fila['porcentaje_edu_no_formal_ycont']="0";
					$fila['porcentaje_proy_progr_remun']="0";
					$fila['porcentaje_proy_no_remun']="0";
					$fila['premios_semestre_nal']="0";
					$fila['libros_publ_texto_calificados']="0";
					$query="select tipo_doc_unico from participante where codigo_unico='".$valor[2]."'";
				$operacionsnies=$snies_conexion->query($query);
				if(!empty($operacionsnies))
				$rowsnies=$operacionsnies->fetchRow();
				else
				$rowsnies["tipo_doc_unico"]=$valor[4];
				
					$fila['tipo_doc_unico']=$rowsnies["tipo_doc_unico"];
					$fila['porcentaje_otras_actividades']="0";
					$fila['libros_pub_investigacion']="0";
					$fila['libros_pub_texto']="0";
					$fila['reportes_investigacion']="0";
					$fila['patentes_obtenidas_semestre']="0";
					$fila['premios_semestre_internal']="0";
					
					
						
					//$fila['nivel_est_code']=$valor[3];
					//$fila['tipo_doc_unico']=$valor[4];
					//$fila['fecha_ingreso']=$valor[5];
					
					/*if($_GET['insertar']=='si'){
						insertar_fila_bd($snies_conexion,'DOCENTE',$fila);
					}*/
					//unset($fila);
				
					$query="select * from docente d, contratodocente cd,tipocontrato tc, periodo p where cd.iddocente=d.iddocente and
					 cd.codigotipocontrato=tc.codigotipocontrato
					and( p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente 
or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente 
or cd.fechainiciocontratodocente between p.fechainicioperiodo  and p.fechavencimientoperiodo  
or cd.fechafinalcontratodocente between p.fechainicioperiodo  and p.fechavencimientoperiodo )
					and p.codigoperiodo='".$_POST['annio'].$_POST['periodo']."'
					and d.numerodocumento='".$fila['codigo_unico']."'";
					$operacionsala=$sala->query($query);
					//echo "<pre>";
					//print_r($operacionsala);
					//echo "</pre>";

						if($operacionsala)
						$infosala=$operacionsala->fetchRow();
							//if(!empty($operacionsala)){
							
							switch($infosala["facultad"]){ 
				/* 			    case "CENTRO DE INVEST":
									$facultadtmp="FACULTAD DE CIENCIAS";
								break;				 
								case "ENFERMERIA":
									$facultadtmp="MEDICINA";
								break; 
								case "DIVISION HUMANID":
									$facultadtmp="FACULTAD DE CIENCIAS";
								break; 
								case "ARTES ESCENICAS":
									$facultadtmp="FORMACION MUSICAL";
								break;
								case "ING. AMBIENTAL":
									$facultadtmp="ING. INDUSTRIAL";				
								break;	
								case "INGENIERIA DE SI":
									$facultadtmp="INGENIERIA ELECTRONICA";				
								break;
								case "FACULTAD DISEÑO,":
									$facultadtmp="FACULTAD DE CIENCIAS";				
								break;
								case "COLEGIO":
									$facultadtmp="BASICO";
								break;
								case "ARTES PLASTICAS":
									$facultadtmp="FORMACION MUSICAL";
								break;
								case "FACULTAD DE EDUC":
									$facultadtmp="FACULTAD DE CIENCIAS";
								break;
								case "CLINICAS ODONTOL":
									$facultadtmp="ADMINISTRACION";
								break;
				 */				case "PROGRAMAS ESPECI":
									$facultadtmp="POSTGRADOS";
								break;
				/* 				case "BIOETICA":
									$facultadtmp="FACULTAD DE CIENCIAS";
								break;
								case "LABORATORIO DE S":
									$facultadtmp="FACULTAD DE CIENCIAS";
								break;
								case "INSTITUTO DE IDI":
									$facultadtmp="FACULTAD DE CIENCIAS";
								break;
				 */				default:
									$facultadtmp=$infosala["facultad"];
								break;
							}
							//$dedicacion=$infosala["codigosniestipocontrato"];
$dedicacion=$valor[6];
							/*switch ($infosala["tipocontratacion"]){
							case "1":
								$dedicacion="01";
								break;
							case "2":
								$dedicacion="02";
							break;
							default: 
								$dedicacion="03";
							break;
							}*/
							
							//$infosala=$operacionsala->fetchRow();
								$query="select nombre_unidad,cod_unidad from unid_organizacional where cod_unidad = 'UB'";
								$operacionsnies=$snies_conexion->query($query);
								$infonies=$operacionsnies->fetchRow();
				
								//echo "<tr>";
								/*if(is_array($infosala)){
									foreach($infosala as $llave=>$valor)
										echo "<td>".$valor."</td>";
								}
								else{
									$noencontradosdocente[]=$fila['codigo_unico'];
								}*/
								
								if(is_array($infonies)){
									//foreach($infonies as $llave=>$valor)
										//echo "<td>".$valor."</td>";				
								}
								else{
									$noencontrados[$infosala["facultad"]]=$connoencontrados[$infosala["facultad"]]++;
									//echo $infosala["facultad"];
								}
								//echo "</tr>";
				
							//}
							//else
							//echo "<H1>NO ENCONTRO ".$fila['codigo_unico']."</H1>";
								//echo "<tr>";
								//foreach($infosala as $llave=>$valor)
									//echo "<td>".$valor."</td>";
								//echo "</tr>";
				
							//}
					$fila['dedicacion']=$dedicacion;			
					$fila['cod_uni_org']=$infonies["cod_unidad"];
			//if($_GET['insertar']=='si'){
					if($_POST['accion']==2)
					insertar_fila_bd($snies_conexion,'docente_h',$fila);
					//}
					$filados['ies_code']=$fila['ies_code'];
					$filados['codigo_unico']=$fila['codigo_unico'];
					$filados['cod_unid_org']=$infonies["cod_unidad"];
					$filados['dedicacion']=$dedicacion;
					$filados['tipo_doc_unico']=$rowsnies["tipo_doc_unico"];
					if($_POST['accion']==2)
					insertar_fila_bd($snies_conexion,'docente_unidad',$filados);
					
				
					unset($fila);
					unset($filados);
				
				}
				$query="select count(*) as cuentadu from docente_unidad ";
				$operacionsnies=$snies_conexion->query($query);
				$rowsniesdu=$operacionsnies->fetchRow();
				
				
				$query="select count(*)  as cuentadh from docente_h ";
				$operacionsnies=$snies_conexion->query($query);
				$rowsniesdh=$operacionsnies->fetchRow();
				
				/*echo "</table>";
				echo "noencontradosdocente<pre>";
				print_r($noencontradosdocente);
				echo "</pre>";
				echo "noencontrados<pre>";
				print_r($noencontrados);
				echo "</pre>";*/
				// "en 0 la dedicacion";
				 
				 echo "<h1>registros docente_h =".$rowsniesdu["cuentadu"]."</h1><br>";
				 echo "<h1>registros docente_unidad =".$rowsniesdh["cuentadh"]."<h1><br>";
				
				if($_POST['tipo']==1)
					$tabla="d";
				if($_POST['tipo']==2)
					$tabla="du";
				if($_POST['tipo']==3)
					$tabla="dh";
	
						$query="SELECT  ".$tabla.".* FROM docente_h dh ,docente d, docente_unidad du where 
								dh.annio=".$_POST['annio']." and dh.semestre='"."0".$_POST['periodo']."' 
								and dh.codigo_unico=d.codigo_unico 
								and dh.tipo_doc_unico=d.tipo_doc_unico							  
								and du.codigo_unico=d.codigo_unico 
								and du.tipo_doc_unico=d.tipo_doc_unico 
								";
						$operacion=$snies_conexion->query($query);
						while ($row_operacion=$operacion->fetchRow()){
						$array_datos[]=$row_operacion;		
						}
							$motor = new matriz($array_datos);
							$motor->mostrar();
}

function insertar_fila_bd($conexion,$tabla,$fila)
{

	$claves="(";
	$valores="(";
	$i=0;
	while (list ($clave, $val) = each ($fila)) {

		if($i>0){
			$claves .= ",".$clave."";
			$valores .= ",'".$val."'";
		}
		else{
			$claves .= "".$clave."";
			$valores .= "'".$val."'";
		}
		$i++;
	}
	$claves .= ")";
	$valores .= ")";

	$sql="insert into $tabla $claves values $valores";
	echo $sql;
	$conexion->debug=true;
	$operacion=$conexion->query($sql);
	$conexion->debug=false;
}
?>
