<?php
	session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	global $db;
	include(realpath(dirname(__FILE__))."/../ReportesAuditoria/templates/mainjson.php");


    $archivo = $_FILES["file"]["tmp_name"];
	//Definimos un array para almacenar el tamaño del archivo
	$tamanio=array();
	//OBTENEMOS EL TAMAÑO DEL ARCHIVO
	$tamanio = $_FILES["file"]["size"];
	//OBTENEMOS EL TIPO MIME DEL ARCHIVO
	$tipo = $_FILES["file"]["type"];
	
	if ( $archivo != "none" ){
	//ABRIMOS EL ARCHIVO EN MODO SOLO LECTURA
	// VERIFICAMOS EL TAÑANO DEL ARCHIVO
	$fp = fopen($archivo, "rb");

    while (($data = fgetcsv($fp, 1000, ";")) !== FALSE) 
	{
        /*
        $data[0]->Numero de Documento
        $data[1]->Apellido
        $data[2]->Nombre
        $data[3]->Genero F - M
        $data[4]->Area
        */
        
		/*
		* @Ivan quintero <quintero.ivan@unbosque.edu.co>
		* Se adiciona la "AND iddocente <> 1" para que no adicionen datos de un nuemero de documento que no existe
		*/
        $SQL='SELECT iddocente FROM docente WHERE numerodocumento="'.$data[0].'" AND codigoestado=100 AND iddocente <> 1';
		/*
		* END
		*/
        if($Docente=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Docente...<br><br>'.$SQL;
            die;
        }
        
        if(!$Docente->EOF)
		{
            $Docente_id = $Docente->fields['iddocente'];
            
        }else{
            
            /*
            tipodocumento->01
            clavedocente->0
            codigogenero->
            codigodocente->Numerodocumento
            idpaisnacimiento->1
            iddepartamentonacimiento->3
            idciudadnacimiento->359
            idestadocivil->1
            idciudadresidencia->359
            fechanacimientodocente->0000-00-00
            codigoestado->100
            */
            if($data[3]=='F'){
                $Genero = '100';
            }else{
                $Genero = '200';
            }
            
            $Insert_D='INSERT INTO docente(apellidodocente,nombredocente,numerodocumento,tipodocumento,clavedocente,codigogenero,codigodocente,idpaisnacimiento,iddepartamentonacimiento,idciudadnacimiento,idestadocivil,idciudadresidencia,fechanacimientodocente,codigoestado)VALUES("'.utf8_encode($data[1]).'","'.utf8_encode($data[2]).'","'.$data[0].'","01","0","'.$Genero.'","'.$data[0].'","1","3","359","1","359","0000-00-00","100")';
            
            if($DocenteNew=&$db->Execute($Insert_D)===false){
                echo 'Error en el SQL de Docentes New...<br><br>'.$Insert_D;
                die;
            }
            ##################################
            $Docente_id=$db->Insert_ID();
            ##################################
        }
        
        $SQL_A='SELECT idAreaPrograma FROM AreaPrograma WHERE codigoestado=100 AND Nombre="'.utf8_encode($data[4]).'"';
		if($Area=&$db->Execute($SQL_A)===false)
		{
        	echo 'Error en el Area Programa.....<br><br>'.$SQL_A;
            die;
		}    
		if(!$Area->EOF){

			$Area_id   = $Area->fields['idAreaPrograma'];

		}else{

			$Insert_A='INSERT INTO AreaPrograma(Nombre,entrydate,userid)VALUES("'.utf8_encode($data[4]).'",NOW(),"4186")';

			if($AreaNew=&$db->Execute($Insert_A)===false){
				echo 'Error en el Insert  del Area Nueva.....<br><br>'.$Insert_A;
				die;
			}
			##################################
			$Area_id=$db->Insert_ID();
			#################################
		}  
		if($Docente_id!='1')
		{
			$Insert_AD='INSERT INTO AreaDocente(id_docente,idAreaPrograma,userid,entrydate)VALUES("'.$Docente_id.'","'.$Area_id.'","4186",NOW())';
			if($DocenteArea=&$db->Execute($Insert_AD)===false){
				echo 'Error en el SQl ...<br><br>'.$Insert_AD;
				die;
			}
		}       
     }//while
   }
?>