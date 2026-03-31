<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    //session_start();
	if(!isset ($_SESSION['MM_Username'])){
		echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi&oacute;n en el sistema</strong></blink>';
		exit();
	}
    require_once("../../../mgi/templates/template.php");    
	require_once("funciones/Excel/reader.php");
    $rutaado=("../../../funciones/adodb/");
	require_once('../../../Connections/salaado-pear.php');
	require_once("../../../funciones/clases/motor/motor.php");    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Cargar Adelanto Preinscritos</title>
		<!--<link rel="stylesheet" type="text/css" href="../mgi/css/themes/smoothness/jquery-ui-1.8.4.custom.css" media="screen" /> --> 
        <link rel="stylesheet" type="text/css" href="../../../mgi/css/styleOrdenes.css" media="screen" />
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="../../../mgi/js/functions.js"></script>	
    </head>	
    <body>
        <div id="pageContainer" class="wrapper" align="center">
			<h4>Cargue de preinscritos en Excel</h4>
            <form name="f1" action="cargarPreinscripcion.php" method="POST" enctype="multipart/form-data">
               <label>Archivo con Preinscritos:</label>
				<input type="file" class="required" value="" name="file" id="file" /><br/><br/>
				<a href="ejemploPreinscritos.xls">Descargar plantilla de ejemplo</a><br/><br/>
                        <input name="buscar" type="submit" value="Cargar Preinscritos">
            </form>
        </div>
    </body>
    <?php	
    if(isset($_POST['buscar']) &&  isset($_FILES)){
        ?> 
        <table>
        <tr>
        <?php
		//PROCESAR EL ARCHIVO 
		$data = new Spreadsheet_Excel_Reader();		
		$data->setOutputEncoding('CP1251');        
		$data->read($_FILES["file"]["tmp_name"]);
        $filas = $data->sheets[0]['numRows'];
		
		//se asume la primera como titulo
		for ($z = 2; $z <= $filas; $z++) {
			$SQL="SELECT C.idciudad FROM ciudad C 
				WHERE C.nombrecortociudad LIKE '%".utf8_encode($data->sheets[0]['cells'][$z][11])."%'
				OR C.nombreciudad LIKE '%".utf8_encode($data->sheets[0]['cells'][$z][11])."%'";
					
			$idCiudad=$sala->query($SQL);
		
			$idCiudad=$idCiudad->fetchRow();
			$idCiudad=$idCiudad['idciudad'];	
			if(empty($idCiudad)){
				$idCiudad = '359';
			}
			$asistente=$data->sheets[0]['cells'][$z][1];
			$fields['asesor']=trim($data->sheets[0]['cells'][$z][1]);
            $fields['trato']=utf8_encode($data->sheets[0]['cells'][$z][2]);
            $fields['nombres']=utf8_encode($data->sheets[0]['cells'][$z][3]);
            $fields['apellido']=utf8_encode($data->sheets[0]['cells'][$z][4]);
			$fields['documento']=$data->sheets[0]['cells'][$z][5];
			$fields['periodo']=$data->sheets[0]['cells'][$z][6];
			$fields['correo']=utf8_encode($data->sheets[0]['cells'][$z][7]);
			$fields['telefono']=$data->sheets[0]['cells'][$z][8];
			$fields['celular']=$data->sheets[0]['cells'][$z][9];
			$fields['observacion']=utf8_encode($data->sheets[0]['cells'][$z][10]);
			$fields['ciudad']= $idCiudad;	
			$fields['modalidadacademica']=utf8_encode($data->sheets[0]['cells'][$z][12]);
			$fields['codigoscarreras']=$data->sheets[0]['cells'][$z][13];
			$fields['codigoscarreras2']=$data->sheets[0]['cells'][$z][14];
			$fields['codigoscarreras3']=$data->sheets[0]['cells'][$z][15];
			$fields['origen']=$data->sheets[0]['cells'][$z][16];
			if ($fields['trato'] == 'Sr(a)'){
				$fields['trato'] = 1;
			}if ($fields['trato'] == 'Dr(a)'){
				$fields['trato'] = 2;
			}if ($fields['trato'] == 'Srta'){
				$fields['trato'] = 3;
			}if ($fields['trato'] == 'Ing(a)'){
				$fields['trato'] = 4;
			}
			
			if (!empty($fields['codigoscarreras'])){
                $consultaPreinscrito=consultaPreinscrito($sala,$fields['nombres'],$fields['apellido'],$fields['documento'],$fields['periodo']);
                /*
                 * Caso  92859
                 * @modified Luis Dario Gualteros 
                 * <castroluisd@unbosque.edu.co>
                 * Se modifica la condición para que inserte registros con numero de identificación y vacios.
                 * @since Agosto 9 de 2017
                */              
       			if(!empty($consultaPreinscrito) || empty($consultaPreinscrito)){
						$sql = "INSERT INTO preinscripcion
						SET fechapreinscripcion='".date('Y-m-d')."', 
						numerodocumento='".$fields['documento']."',
						tipodocumento='02',
						codigoperiodo='".$fields['periodo']."',
						idtrato='".$fields['trato']."',
						apellidosestudiante='".$fields['apellido']."',
						nombresestudiante='".$fields['nombres']."',
						ciudadestudiante='".$fields['ciudad']."',
						emailestudiante='".$fields['correo']."',
						telefonoestudiante = '".$fields['telefono']."',
						celularestudiante = '".$fields['celular']."',
						codigoestadopreinscripcionestudiante = '300',
						idusuario = '1',
						codigoestado= '100',
						codigoindicadorenvioemailacudientepreinscripcion= '100',
						idempresa = '1',
						idtipoorigenpreinscripcion= '1',
						origen = '".$fields['origen']."';
						";
                    //End Caso 92859
                    $result=$sala->query($sql);			
					$sql = "select MAX(idpreinscripcion) as id from preinscripcion a where a.numerodocumento = '".$fields['documento']."' ;";
					$idUltimaInserccion=$sala->query($sql);
					$idUltimaInserccion=$idUltimaInserccion->fetchRow();
					$idUltimaInserccion=$idUltimaInserccion['id'];
					$sqlCarrera = "INSERT INTO preinscripcioncarrera 
						SET idpreinscripcion='".$idUltimaInserccion."', 
						codigocarrera='".$fields['codigoscarreras']."',
						codigoestado='100';
						";
                    $result=$sala->query($sqlCarrera);
				}else{
					 $sql = "UPDATE preinscripcion 
						SET fechapreinscripcion='".date('Y-m-d')."', 
						numerodocumento='".$fields['documento']."',
						tipodocumento='02',
						codigoperiodo='".$fields['periodo']."',
						idtrato='".$fields['trato']."',
						apellidosestudiante='".$fields['apellido']."',
						nombresestudiante='".$fields['nombres']."',
						ciudadestudiante='".$fields['ciudad']."',
						emailestudiante='".$fields['correo']."',
						telefonoestudiante = '".$fields['telefono']."',
						celularestudiante = '".$fields['celular']."',
						codigoestadopreinscripcionestudiante = '300',
						idusuario = '1',
						codigoestado= '100',
						codigoindicadorenvioemailacudientepreinscripcion= '100',
						idempresa = '1',
						idtipoorigenpreinscripcion= '1'
						where nombresestudiante = '".$fields['nombres']."'
						AND apellidosestudiante='".$fields['apellido']."' 
						AND codigoperiodo = '".$fields['periodo']."'
						";						
					$result=$sala->query($sql);	
				}	
            /*
             * Caso  92859
             * @modified Luis Dario Gualteros 
             * <castroluisd@unbosque.edu.co>
             * Si el interesado tiene 2da y 3era opción de carrera solo inserta en la tabla 
             * preinscripcioncarrera con el fin de evitar la dulplicidad de información.
             * @since Agosto 9 de 2017
            */      
			}if (!empty($fields['codigoscarreras2'])){
				
					$sql = "select MAX(idpreinscripcion) as id from preinscripcion a where a.numerodocumento = '".$fields['documento']."' ;";
					$idUltimaInserccion=$sala->query($sql);
					$idUltimaInserccion=$idUltimaInserccion->fetchRow();
					$idUltimaInserccion=$idUltimaInserccion['id'];
					$sqlCarrera = "INSERT INTO preinscripcioncarrera 
							SET idpreinscripcion='".$idUltimaInserccion."', 
							codigocarrera='".$fields['codigoscarreras2']."',
							codigoestado='100';
							";						
					$result=$sala->query($sqlCarrera);
				}				
			if (!empty($fields['codigoscarreras3'])){
				     
					$sql = "select MAX(idpreinscripcion) as id from preinscripcion a where a.numerodocumento = '".$fields['documento']."' ;";
					$idUltimaInserccion=$sala->query($sql);
					$idUltimaInserccion=$idUltimaInserccion->fetchRow();
					$idUltimaInserccion=$idUltimaInserccion['id'];
					$sqlCarrera = "INSERT INTO preinscripcioncarrera 
							SET idpreinscripcion='".$idUltimaInserccion."', 
							codigocarrera='".$fields['codigoscarreras3']."',
							codigoestado='100';
							";						
					$result=$sala->query($sqlCarrera);
				}								
			}
	       // End Caso 92859  		
		if($z === $filas+1)	{
			echo 'Se realizo insercción correctamente'.'<br>';			
		}else{
			echo 'No se cargaron todos los registros';
		}		
		?>
		</tr>
		<?php
    }
	function consultaPreinscrito($sala,$nombre,$apellido,$documento,$periodo){
		if(!empty($documento)){
			$sql = "select numerodocumento from preinscripcion a where a.numerodocumento = '".$documento."'";
			$idCon=$sala->query($sql);
			$idConsulta=$idCon->fetchRow();
			$estudiante=$idConsulta['numerodocumento'];
		}else{
			$sql = "select nombresestudiante from preinscripcion a where a.nombresestudiante = '".$nombre."'
			AND a.apellidosestudiante='".$apellido."' AND a.codigoperiodo = '".$periodo."'";
			$idCon=$sala->query($sql);
			$idConsulta=$idCon->fetchRow();
			$estudiante=$idConsulta['nombresestudiante'];
		}
		return $estudiante;	
	}

    ?>
</html>