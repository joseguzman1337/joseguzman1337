<?php
ini_set('post_max_size', '10M');
ini_set('upload_max_filesize', '10M');
require_once("../../datos/templates/template.php");
require('oportunidad.php');
$tipoAccion = $_REQUEST['tipoAccion'];
$ruta = "evidenciaOportunidad/";
    
    if ( $tipoAccion == "guardarEvidencia" ){
        $idOportunidad = $_REQUEST['id'];
        $descripcion = $_REQUEST['descripcion'];
        $fileName = basename($_FILES["archivo"]["name"]); 
        $identificador=date("his");
        $archivo= $identificador."_".$fileName;
        $target_file=$ruta.$archivo;
        $fileTypes =array('doc', 'docx' , 'pdf','xls','xlsx');
        $fileParts = pathinfo($_FILES["archivo"]["name"]);
        $check = $fileParts["extension"];
        $numeroEvidencias = conteoEvidencia( $db , $idOportunidad );
	$filesize = filesize($_FILES["archivo"]["tmp_name"]);

        /*@modfied Diego Rivera <riveradiego>
         *Se cambia limite de envidencias de 10 a 50 (caso aranda 108343 )
         *Se cambia validacion de tamaño de archivo de 10 a 8 megas se valido el maximo permitido en post con infraestructura caso aranda(108405) 
         *@since December 17,2018   
         */
        if($numeroEvidencias["evidencias"]<=50){
			if($filesize < 8000000){
				if (in_array(strtolower($check), $fileTypes)){
					if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
						agregar( $db, $idOportunidad , $archivo, $descripcion , $_SESSION["idusuario"] , $ruta);
						echo 1;
					}
				} else {
					echo 0;
				}       
			}else{
				echo 3;
			}
        }else{
            echo 2;
        }
    } else if($tipoAccion == "modificarEvidencia"){

        $verificarArchivo = $_REQUEST["verificarArchivo"];
        $idEvidencia= $_REQUEST['id'];
        $descripcion = $_REQUEST['descripcion'];
        if($verificarArchivo==1){
            $fileName = basename($_FILES["archivo"]["name"]); 
            $identificador=date("his");
            $archivo= $identificador."_".$fileName;
            $target_file=$ruta.$archivo;
            $fileTypes =array('doc', 'docx' , 'pdf','xls','xlsx');
            $fileParts = pathinfo($_FILES["archivo"]["name"]);
            $check = $fileParts["extension"];
			
            if (in_array(strtolower($check), $fileTypes)){
                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
                    actualizarEvidencia( $db, $idEvidencia ,$archivo, $descripcion, $_SESSION["idusuario"]  );
                    echo 1;
                }
            } else {
                echo 0;
            }   
        }
        else{
            $archivoActual =  $_REQUEST["archivoActual"];
            actualizarEvidencia( $db, $idEvidencia ,$archivoActual, $descripcion, $_SESSION["idusuario"]  );
            echo 1;
        }
      }


       elseif($tipoAccion == "modificarAvance"){
            $idOportunidad = $_REQUEST['id'];
        $valoracion = $_REQUEST['valoracion'];
        $avanceevidencia = $_REQUEST['avanceevidencia'];
        modificarAvance( $db, $idOportunidad , $valoracion, $avanceevidencia , $_SESSION["idusuario"]);
            echo 1;
    }


      else if ( $tipoAccion == "eliminar" ){
          $idEvidencia= $_REQUEST['id'];
          $idOportunidad = $_REQUEST['idOportunidad'];
          $numeroEvidencias = conteoEvidencia( $db , $idOportunidad );

          if( $numeroEvidencias["evidencias"] == 1 ){
            echo 0;
          }else{
            actualizarEstadoEvidencia($db,$idEvidencia,$_SESSION["idusuario"]);
            echo 1;
          }
      }
     ?>