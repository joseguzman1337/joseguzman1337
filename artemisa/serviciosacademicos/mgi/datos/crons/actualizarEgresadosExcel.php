<?php
	/*
	* Ivan Dario Quintero Ríos <quinteroivanqunbosque.edu.co
	* Modificado 13 de julio, 2017
	* Modificacion de la conexion a la base de datos, modificacion de diseño y ajustes de campos de celular
	*/
	if(isset($_POST['buscar']) &&  isset($_FILES))
	{
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  

	require_once('../../../../serviciosacademicos/Connections/sala2.php'); 
	require("../../../../serviciosacademicos/funciones/funcionpassword.php");
	$rutaado = "../../../../serviciosacademicos/funciones/adodb/";
	require_once('../../../../serviciosacademicos/Connections/salaado.php');    
	require_once('../../../educacionContinuada/Excel/reader.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Actualizar datos egresados</title>
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
		<link rel="stylesheet" type="text/css" href="../../../mgi/css/styleOrdenes.css" media="screen" />
		<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="../../../mgi/js/functions.js"></script>		
    </head>
    <body>
		<div class="container">
			<?php 
			if(!isset($_POST['buscar']))
			{ 
				?>
				<div id="contenido" style="margin-top: 10px;">
					<h2>Cargar Egresados a Actualizar</h2>
					<br/>
					<div id="form"> 
						<form action="actualizarEgresadosExcel.php" id="form_test" method="POST" enctype="multipart/form-data">
							<h4>Recuerde que las columnas minimas deben contener:</h4>
							<ul>
								<li>A: Tipo de documento</li>
								<li>B: Numero de documento</li>
							</ul>
							<br/>
							<label for="file">Archivo con los egresados:</label>
							<input accept="application/vnd.ms-excel" type="file" name="file" id="file">
							<br/>
							<br/>
							<input class="btn btn-fill-green-XL" type="submit" name="buscar" value="Descargar Información Actualizada" class="first" />
						</form>
					</div>
				</div>
				<?php 
			} 

			if(isset($_POST['buscar']) &&  isset($_FILES))
			{
				?> 
				<table>
					<thead>
						<tr>
							<th>IdTipoDocumento</th>
							<th>NumDocumento</th>
							<th>PrimerNombre</th>
							<th>SegundoNombre</th>
							<th>PrimerApellido</th>
							<th>SegundoApellido</th>
							<th>AnioGrado</th>
							<th>SemestreGrado</th>
							<th>CodigoIES</th>
							<th>NombreIES</th>
							<th>IdOrigen</th>
							<th>NombreOrigen</th>
							<th>IdPrograma</th>
							<th>NombrePrograma</th>
							<th>IdArea</th>
							<th>NombreArea</th>
							<th>IdNucleo</th>
							<th>NombreNucleo</th>
							<th>IdModalidad</th>
							<th>NombreModalidad</th>
							<th>IdDepartamentoProg</th>
							<th>NombreDepartamentoProg</th>
							<th>IdMunicipioProg</th>
							<th>NombreMunicipioProg</th>
							<th>Momento</th>
							<th>DIRECCION</th>
							<th>CIUDAD</th>
							<th>TELEFONO FIJO 1</th>
							<th>TELEFONO FIJO 2 </th>
							<th>CELULAR 1 </th>
							<th>CELULAR 2 </th>
							<th>MAIL 1</th>
							<th>MAIL 2</th>
						</tr>
					</thead>
					<tbody>
						<?php
						//TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
						$data = new Spreadsheet_Excel_Reader();						
						$data->setOutputEncoding('CP1251');

						$data->read($_FILES["file"]["tmp_name"]);
						$filas = $data->sheets[0]['numRows'];
						
						$contador=0;
						$errores = 0;
						
						//se asume la primera como titulo
						for ($z = 2; $z <= $filas; $z++) 
						{
							$tipoDoc=$data->sheets[0]['cells'][$z][1];
							$fields['numerodocumento']=trim($data->sheets[0]['cells'][$z][2]);
							$fields['nombre1']=$data->sheets[0]['cells'][$z][3];
							$fields['nombre2']=$data->sheets[0]['cells'][$z][4];
							$fields['apellido1']=$data->sheets[0]['cells'][$z][5];
							$fields['apellido2']=$data->sheets[0]['cells'][$z][6];
							$fields['grado']=$data->sheets[0]['cells'][$z][7];
							$fields['semestre']=$data->sheets[0]['cells'][$z][8];
							$fields['ies']=$data->sheets[0]['cells'][$z][9];
							$fields['nombreIES']=$data->sheets[0]['cells'][$z][10];
							$fields['idOrigen']=$data->sheets[0]['cells'][$z][11];
							$fields['nombreOrigen']=$data->sheets[0]['cells'][$z][12];
							$fields['IdPrograma']=$data->sheets[0]['cells'][$z][13];
							$fields['NombrePrograma']=$data->sheets[0]['cells'][$z][14];
							$fields['IdArea']=$data->sheets[0]['cells'][$z][15];
							$fields['NombreArea']=$data->sheets[0]['cells'][$z][16];
							$fields['IdNucleo']=$data->sheets[0]['cells'][$z][17];
							$fields['NombreNucleo']=$data->sheets[0]['cells'][$z][18];
							$fields['IdModalidad']=$data->sheets[0]['cells'][$z][19];
							$fields['NombreModalidad']=$data->sheets[0]['cells'][$z][20];
							$fields['IdDepartamentoProg']=$data->sheets[0]['cells'][$z][21];
							$fields['NombreDepartamentoProg']=$data->sheets[0]['cells'][$z][22];
							$fields['IdMunicipioProg']=$data->sheets[0]['cells'][$z][23];
							$fields['NombreMunicipioProg']=$data->sheets[0]['cells'][$z][24];
							$fields['Momento']=$data->sheets[0]['cells'][$z][25];
							if($tipoDoc!="")
							{
								$filaReal = true;
							}

							//verificar que no fue inscrito antes
							$sql = "SELECT d.*,c.nombreciudad FROM estudiantegeneral d inner join ciudad c on d.ciudadresidenciaestudiantegeneral=c.idciudad WHERE d.numerodocumento='".$fields['numerodocumento']."' ";
							$result = $db->GetRow($sql);

							//realiza una consulta para verificar si existe un asistente con ese numero de identificaion	
							$sql = "SELECT * FROM egresado a  WHERE a.numerodocumento='".$fields['numerodocumento']."' AND codigoestado=100";
							$egresado = $db->GetRow($sql);
							$fields['telefono1'] = "";

							if($egresado["telefonoresidenciaegresado"]!="" && $egresado["telefonoresidenciaegresado"]!=null && strpos($egresado["telefonoresidenciaegresado"],'no') !== false && count($egresado)>0)
							{
								$fields['telefono1'] = $egresado["telefonoresidenciaegresado"];
							} 
							else if(strpos($result["telefonoresidenciaestudiantegeneral"],'no') !== false) 
							{
								$fields['telefono1'] = $result["telefonoresidenciaestudiantegeneral"];
							}

							$fields['telefono2'] = "";
							if($egresado["telefonooficinaegresado"]!="" && $egresado["telefonooficinaegresado"]!=null && strpos($egresado["telefonooficinaegresado"],'no') !== false && strpos($egresado["telefonooficinaegresado"],'xxx') !== false && count($egresado)>0)
							{
								$fields['telefono2'] = $result["telefonooficinaegresado"];
							} 
							else if($result["telefono2estudiantegeneral"]!="SIN ASIGNAR" && $result["telefono2estudiantegeneral"]!="") 
							{
								$fields['telefono2'] = $result["telefono2estudiantegeneral"];
							}

							$fields['telefono2'] = $result["telefonoresidenciaestudiantegeneral"].count($egresado);

							$fields['direccion'] = "";
							if($egresado["direccionresidenciaegresado"]!="" && $egresado["direccionresidenciaegresado"]!=null && count($egresado)>0)
							{ 
								$fields['direccion'] = $egresado["direccionresidenciaegresado"];
							} 
							else 
							{
								$fields['direccion'] = $result["direccionresidenciaestudiantegeneral"];
							}

							$fields['ciudad'] = "";
							if($egresado["ciudadpaisresidenciaegresado"]!="" && $egresado["ciudadpaisresidenciaegresado"]!=null && count($egresado)>0)
							{
								$fields['ciudad'] = $egresado["ciudadpaisresidenciaegresado"];
							} 
							else 
							{
								$fields['ciudad'] = $result["nombreciudad"];
							}

							$fields['celular1'] = "";
							if($egresado["telefonorecelularegresado"]!="" && $egresado["telefonorecelularegresado"]!=null && count($egresado)>0)
							{	
								$fields['celular1'] = $egresado["telefonorecelularegresado"];
							} 
							else
							{
								if($result["celularestudiantegeneral"]!="SIN ASIGNAR" && $result["celularestudiantegeneral"]!="") 
								{
									$fields['celular1'] = $result["celularestudiantegeneral"];
								}
							} 

							$fields['email1'] = "";
							if($egresado["emailegresado"]!="" && $egresado["emailegresado"]!=null && count($egresado)>0)
							{
								$fields['email1'] = $egresado["emailegresado"];
							} 
							else if($result["emailestudiantegeneral"]!="SIN ASIGNAR" && $result["emailestudiantegeneral"]!="") 
							{
								$fields['email1'] = $result["emailestudiantegeneral"];
							}

							$fields['email2'] = "";
							if($egresado["emailoficinaegresado"]!="" && $egresado["emailoficinaegresado"]!=null && strpos($egresado["emailoficinaegresado"],'no')!== false && count($egresado)>0) 
							{
								$fields['email2'] = $egresado["telefonocelularegresado"];
							}
							else if($result["email2estudiantegeneral"]!="SIN ASIGNAR" && $result["email2estudiantegeneral"]!="") 
							{
								$fields['email2'] = $result["email2estudiantegeneral"];
							}

							?>
							<tr>
								<td><?php echo $tipoDoc; ?></td>   
								<td><?php echo $fields['numerodocumento']; ?></td>   
								<td><?php echo utf8_encode($fields['nombre1']); ?></td>   
								<td><?php echo utf8_encode($fields['nombre2']); ?></td>   
								<td><?php echo utf8_encode($fields['apellido1']); ?></td>   
								<td><?php echo utf8_encode($fields['apellido2']); ?></td>   
								<td><?php echo $fields['grado']; ?></td>       	
								<td><?php echo $fields['semestre']; ?></td>       	       
								<td><?php echo $fields['ies']; ?></td>       	       
								<td><?php echo $fields['nombreIES']; ?></td>       	       
								<td><?php echo $fields['idOrigen']; ?></td>     	       
								<td><?php echo $fields['nombreOrigen']; ?></td>              
								<td><?php echo $fields['IdPrograma']; ?></td>               
								<td><?php echo utf8_encode($fields['NombrePrograma']); ?></td>               
								<td><?php echo $fields['IdArea']; ?></td>                
								<td><?php echo utf8_encode($fields['NombreArea']); ?></td>                
								<td><?php echo $fields['IdNucleo']; ?></td>                
								<td><?php echo utf8_encode($fields['NombreNucleo']); ?></td>                
								<td><?php echo $fields['IdModalidad']; ?></td>                
								<td><?php echo $fields['NombreModalidad']; ?></td>                
								<td><?php echo $fields['IdDepartamentoProg']; ?></td>                
								<td><?php echo $fields['NombreDepartamentoProg']; ?></td>                
								<td><?php echo $fields['IdMunicipioProg']; ?></td>                
								<td><?php echo $fields['NombreMunicipioProg']; ?></td>                
								<td><?php echo $fields['Momento']; ?></td>                
								<td><?php echo $fields['direccion']; ?></td>                
								<td><?php echo $fields['ciudad']; ?></td>                
								<td><?php echo $fields['telefono1']; ?></td>                
								<td><?php echo $fields['telefono2']; ?></td>                
								<td><?php echo $fields['celular1']; ?></td>                
								<td><?php echo $fields['celular2']; ?></td>                
								<td><?php echo $fields['email1']; ?></td>                
								<td><?php echo $fields['email2']; ?></td>                 	               
							</tr>
							<?php 
						}//for
						?>
					</tbody>
				</table>
				<?php 
			}//if buscar
			?>
		</div>
  	</body>
</html>