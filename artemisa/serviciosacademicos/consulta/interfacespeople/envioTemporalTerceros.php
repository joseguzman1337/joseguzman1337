<?php
	
	session_start();
	
	$ruta = "../";
    
	while (!is_file($ruta.'Connections/sala2.php'))
	{
		$ruta = $ruta."../";
		echo "<br/><br/>".$ruta;
	}
   
    echo '<pre>';var_dump(is_file($ruta.'Connections/sala2.php'));
    include($ruta.'Connections/sala2.php');
    
    $rutaado = $ruta."funciones/adodb/";
    var_dump($hostname_sala); echo "<br/><br/>";
    include($ruta.'Connections/salaado.php');
	require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/conexionpeople.php');
	require_once(realpath(dirname(__FILE__)).'/../../../nusoap/lib/nusoap.php');
	require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/reporteCaidaPeople.php');
	require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/funcionesPS.php');
	
	function ModiEstudiante($db,$xml,$id){
		$client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 360);		
		$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);		
		$parametro = 'id:'.$result['ERRNUM'].' descripcion:'.$result['DESCRLONG'];	
		echo "<p>Reporte de registro enviado: ID ".$id." Resultado de operacion: ".$result['ERRNUM']." Descripcion: ".$result['DESCRLONG']."</p>";
		echo "Tiempo final: ".date('G:i:s');
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
	
	//if($_REQUEST['envio']){
		echo " - tiempo inicial".date('G:i:s');
		echo "<h2>Iniciando envio de terceros en 3...2...1...</h2>";
		
		$SQL = "SELECT
                    idlogtraceintegracionps,
                    enviologtraceintegracionps,
                    documentologtraceintegracionps
                FROM
                    `logtraceintegracionps`
                WHERE
                    transaccionlogtraceintegracionps = 'Actualizacion estudiante'
                AND fecharegistrologtraceintegracionps >= '2018-01-21 00:00:00'
                AND estadoenvio IN (0, 2)
                GROUP BY documentologtraceintegracionps";
		if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Buscar Data...<br><br>'.$SQL.' El error es: '.mysql_error();
            die;
        }
		
		if($Data){
            while(!$Data->EOF){
				$parametro = ModiEstudiante($db, $Data->fields['enviologtraceintegracionps'], $Data->fields['idlogtraceintegracionps']);
				ModificaSQL($db, $parametro, $Data->fields['idlogtraceintegracionps']);
				$Data->MoveNext();
            }
        }
		echo "<p>Termino el envio...</p>";
	//}
	
?>

<!--<form action="" method="post">
	Envio de datos <br />
	Fecha inicial (aaaa-mm-dd): <input type="text" name="fechaInicio" /><br />
	Fecha final (aaa-mm-dd): <input type="text" name="fechaFin" /><br />
	<input type="submit" value="enviar">
	<input type="hidden" name="envio" value="1" />
</form>-->