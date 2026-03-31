<?php


error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
 
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../class/table.php');
require_once('../../../class/Class_andor.php');
ini_set('max_execution_time', '12000');


$query_datosest ="select a.numerodocumento from administrativosdocentes a, tarjetainteligenteadmindocen t, tmp_desactivacarnedoceadmin td where 
a.idadministrativosdocentes=t.idadministrativosdocentes
and td.numerodocumento=a.numerodocumento
and t.codigoestado like '1%'
and td.procesado=0;
";

                $datosest= $db->Execute($query_datosest);
                $totalRows_datosest = $datosest->RecordCount();
		//$row_datosest = $datosest->FetchRow();

while($row_datosest = $datosest->FetchRow()){
$documento=$row_datosest['numerodocumento'];


$objAndor = new class_andor($documento);
        $NivelAcceso = 1;
        $objAndor->setNivelAcceso($NivelAcceso);
        $objAndor->setApellido('');
        $objAndor->setNombres('');

        if($objAndor->servidor_activo()){
            $rsutl = $objAndor->get_ws_result();
	   echo "<pre>";
	   print_r($rsutl);
		if($rsutl[0]['EstaActivo']=='true'){

		    $NivelAcceso = 1;
		    $objAndor->setNivelAcceso($NivelAcceso);
		    $objAndor->setNombres(str_replace(' ', '_',$rsutl[0]['Nombres']));
		    $objAndor->setApellido(str_replace(' ', '_',$rsutl[0]['Apellido']));
		    $objAndor->setNumeroTarjeta($rsutl[0]['NumeroTarjeta']);
		    $resultado = $objAndor->del_ws_result();
			/*echo "<pre>";	
			print_r($resultado);  */
			
			$query_inserta="insert into tmp_tarjetasdesactivadas (idtmp_tarjetasdesactivadas,numerodocumento,numerotarjeta, respuestaandover,tipopersona)
					values(0,'$documento','".$rsutl[0]['NumeroTarjeta']."','".$resultado['InactivarCardHolderResult']['Descripcion']."','DoceAdmin')";
			$inserta= $db->Execute($query_inserta);
			$query_actualiza="update tmp_desactivacarnedoceadmin set procesado=1 where numerodocumento=$documento";
                        $actualiza= $db->Execute($query_actualiza);

			unset($resultado);

		}
		elseif($rsutl[0]['EstaActivo']=='false'){
			/*echo "<pre>";
		           print_r($rsutl);*/
			$query_inserta="insert into tmp_tarjetasdesactivadas (idtmp_tarjetasdesactivadas,numerodocumento,numerotarjeta, respuestaandover,tipopersona)
                                        values(0,'$documento','".$rsutl[0]['NumeroTarjeta']."','La Tarjeta ya esta Inactiva','DoceAdmin')";
                        $inserta= $db->Execute($query_inserta);
			$query_actualiza="update tmp_desactivacarnedoceadmin set procesado=1 where numerodocumento=$documento";
                        $actualiza= $db->Execute($query_actualiza);


		}
		else{
			$query_inserta="insert into tmp_tarjetasdesactivadas (idtmp_tarjetasdesactivadas,numerodocumento,respuestaandover,tipopersona)
                                        values(0,'$documento','No existe en Andover','DoceAdmin')";
                        $inserta= $db->Execute($query_inserta);
			$query_actualiza="update tmp_desactivacarnedoceadmin set procesado=1 where numerodocumento=$documento";
                        $actualiza= $db->Execute($query_actualiza);

		}
        }
unset($objAndor);
unset($rsutl);
}


?>
