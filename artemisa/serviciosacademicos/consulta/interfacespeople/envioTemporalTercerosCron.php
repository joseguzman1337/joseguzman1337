<?php
	
	/*
	 * @modified David Perez <perezdavid@unbosque.edu.co>
	 * @since  Octubre 10, 2017
	 * Archivo que permite la creacion de terceros del día anterior, ejecutado por cron y el resultado se guarda en la carpeta log
	*/
	
	$fechaAEnviar = date('Y-m-d', strtotime($stop_date . ' -1 day'));
	
	session_start();
	
	$ruta = "../";
    
	while (!is_file($ruta.'Connections/sala2.php'))
	{
		$ruta = $ruta."../";
		echo "<br/><br/>".$ruta;
	}

    include($ruta.'Connections/sala2.php');
    
    $rutaado = $ruta."funciones/adodb/";
    include($ruta.'Connections/salaado.php');
	require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/conexionpeople.php');
	require_once(realpath(dirname(__FILE__)).'/../../../nusoap/lib/nusoap.php');
	require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/reporteCaidaPeople.php');
	require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/funcionesPS.php');
	
	function ModiEstudiante($db,$xml,$id){
		$client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 30);		
		$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);		
		$parametro = 'id:'.$result['ERRNUM'].' descripcion:'.$result['DESCRLONG'];	
		echo "<p>Reporte de registro enviado: ID ".$id." Resultado de operacion: ".$result['ERRNUM']." Descripcion: ".$result['DESCRLONG']."</p>";
		return $parametro;
	}
	
	function ModificaSQL($db,$parametro,$id){
    
        $SQL="UPDATE logtraceintegracionps 
              SET    respuestalogtraceintegracionps='".$parametro."',
                     estadoenvio=1,
                     fecharegistrologtraceintegracionps=NOW()
              WHERE  idlogtraceintegracionps=".$id;
              
		if($Modifica=$db->Execute($SQL)==false){
			Echo '<br />Error en el Modificar Log....<br><br>'.$SQL.' El error es: '.mysql_error();
			//die;
		}
	}//function ModificaSQL
	
	/*if($_REQUEST['envio']){*/
		
		echo "<h2>Iniciando envio de terceros en 3...2...1... para el ".$fechaAEnviar."</h2>";
		
		$SQL = "SELECT
					idlogtraceintegracionps,
					enviologtraceintegracionps
				FROM
					`logtraceintegracionps`
				WHERE
					transaccionlogtraceintegracionps = 'Actualizacion estudiante'
				AND fecharegistrologtraceintegracionps BETWEEN '".$fechaAEnviar." 00:00:00'
				AND '".$fechaAEnviar." 23:59:59'
				AND estadoenvio IN (0, 2)";
								
		if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Buscar Data...<br><br>'.$SQL.' El error es: '.mysql_error();
            die;
        }
		
		     
		$nombreArchivo = "log/".$fechaAEnviar.".txt"; 
	 
		if(file_exists($nombre_archivo))
		{
			echo "El Archivo $nombreArchivo se ha modificado";
		}
		else
		{
			echo "El Archivo $nombreArchivo se ha creado";
		}
	 
		if($archivo = fopen($nombreArchivo, "a"))
		{
			
		
			if($Data){
				while(!$Data->EOF){
					$parametro = ModiEstudiante($db, $Data->fields['enviologtraceintegracionps'], $Data->fields['idlogtraceintegracionps']);
					fwrite($archivo, date("d m Y H:m:s"). " logtraceID: ".$Data->fields['enviologtraceintegracionps']." ".$parametro."\n");
					//ModificaSQL($db, $parametro, $Data->fields['idlogtraceintegracionps']);
					$Data->MoveNext();
				}
			}
		
			fclose($archivo);
		}
		echo "<p>Termino el envio...</p>";
	//}
	
?>