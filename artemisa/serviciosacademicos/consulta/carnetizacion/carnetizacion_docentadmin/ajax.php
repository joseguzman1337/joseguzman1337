<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../../../class/Class_andor.php');
require_once('../../../class/table.php');

if ($_REQUEST['Inactivar']=="true"){    
    $objAndor = new class_andor($_REQUEST['v_documento']);
    /*nivel de acceso por defecto = 1*/
    $NivelAcceso = 1;
    $objAndor->setNivelAcceso($NivelAcceso);
    $objAndor->setNombres(str_replace(' ', '_',$_REQUEST['v_nombre']));
    $objAndor->setApellido(str_replace(' ', '_',$_REQUEST['v_apellido']));
    $objAndor->setNumeroTarjeta($_REQUEST['v_tarjeta']);
    if($objAndor->servidor_activo()){
    $rsutl = $objAndor->del_ws_result();
    }
    $objAndor->setNombres('');
    $objAndor->setNumeroTarjeta('');
    if($objAndor->servidor_activo()){
    $rsutl = $objAndor->get_ws_result();
    }
    echo  $objAndor->table_cardholder($rsutl);
}

if ($_REQUEST['Inactivar']=="false"){
    $objAndor = new class_andor($_REQUEST['v_documento']);
    /*nivel de acceso por defecto = 1*/
    $NivelAcceso = 1;
    $objAndor->setNivelAcceso($NivelAcceso);
    $objAndor->setNombres(str_replace(' ', '_',$_REQUEST['v_nombre']));
    $objAndor->setApellido(str_replace(' ', '_',$_REQUEST['v_apellido']));    
    $objAndor->setNumeroTarjeta($_REQUEST['v_tarjeta']);
    if($objAndor->servidor_activo()){
    $rsutl = $objAndor->set_ws_result();
    }
    $objAndor->setNombres('');
    $objAndor->setNumeroTarjeta('');
    if($objAndor->servidor_activo()){
    $rsutl = $objAndor->get_ws_result();
    }
    echo  $objAndor->table_cardholder($rsutl);
}

if($_REQUEST['Guardar']== 'SI'){
    $objAndor = new class_andor($_REQUEST['documento']);    
    $NivelAcceso = 1;
    $objAndor->setNivelAcceso($NivelAcceso);
    
    $nombreandover = str_replace(' ', '_',strtoupper($_REQUEST['nombres']));
    $apellidoandover = str_replace(' ', '_',strtoupper($_REQUEST['apellidos']));

    //echo $_REQUEST['nombres']." ". $_REQUEST['apellidos'];
    

    $obj_update = new table("tarjetainteligenteadmindocen");
    $obj_update->sql_where = " codigotarjetainteligenteadmindocen = '".$_REQUEST['numerotarjeta']."' and idadministrativosdocentes = '".$_REQUEST['idadministrativosdocentes']."'";
    $tar_admin = $obj_update->getData();
    $tar_admin = $tar_admin[0];
    $array_administrativo        =array('idadministrativosdocentes','nombresadministrativosdocentes','apellidosadministrativosdocentes','tipodocumento','numerodocumento','expedidodocumento','idtipogruposanguineo','codigogenero','celularadministrativosdocentes','emailadministrativosdocentes','direccionadministrativosdocentes','telefonoadministrativosdocentes','fechaterminacionadministrativosdocentes','cagoadministrativosdocentes','codigoestado','nombresadministrativosdocentesandover','apellidosadministrativosdocentesandover','idtipousuarioadmdocen');
    $array_tarjeta                    = array('idtarjetainteligenteadmindocen','codigotarjetainteligenteadmindocen','idadministrativosdocentes','fecharegistrotarjetainteligenteadmindocen','codigoestado','sincandover');
    $fieldarray_administrativo = array('idadministrativosdocentes'=>$_REQUEST['idadministrativosdocentes'],
            'nombresadministrativosdocentes'=>$_REQUEST['nombres'],
            'apellidosadministrativosdocentes'=>$_REQUEST['apellidos'],                        
            'tipodocumento'=>$_REQUEST['tipodocumento'],
            'numerodocumento'=>$_REQUEST['documento'],
            'expedidodocumento'=>$_REQUEST['expedido'],
            'idtipogruposanguineo'=>$_REQUEST['idtipogruposanguineo'],
            'codigogenero'=>$_REQUEST['genero'],
            'celularadministrativosdocentes'=>$_REQUEST['celular'],
            'emailadministrativosdocentes'=>$_REQUEST['email'],
            'direccionadministrativosdocentes'=>$_REQUEST['direccion1'],
            'telefonoadministrativosdocentes'=>$_REQUEST['telefono'],
            'codigoestado'=>100,
            'nombresadministrativosdocentesandover'=>$nombreandover,
            'apellidosadministrativosdocentesandover'=>$apellidoandover);
    
    if (is_array($tar_admin)){
        /*esta actulizando la misma tarjeta*/
        $obj_update->table("administrativosdocentes");
        $obj_update->fieldlist = $array_administrativo;
        $obj_update->fieldlist['idadministrativosdocentes'] = array('pkey' => 'y');
        //$obj_update->debug = true;
        $obj_update->updateRecord($fieldarray_administrativo);
        /*inactivamos todas las tarjetas en sala y dejamos una sola tarjeta activa*/
        $obj_update->table("tarjetainteligenteadmindocen");
        $obj_update->fieldlist = $array_tarjeta;
        $fieldarray_tarjeta = array('idadministrativosdocentes'=>$_REQUEST['idadministrativosdocentes'],'codigoestado'=>200);
        $obj_update->fieldlist['idadministrativosdocentes'] = array('pkey' => 'y');
        $obj_update->updateRecord($fieldarray_tarjeta);
        if($objAndor->servidor_activo()){
            $sinc = 1;
        }else{
            $sinc = 0;
        }
        $fieldarray_tarjeta = array('idadministrativosdocentes'=>$_REQUEST['idadministrativosdocentes'],'idtarjetainteligenteadmindocen'=>$tar_admin['idtarjetainteligenteadmindocen'],'codigoestado'=>100,'sincandover'=>$sinc);
        $obj_update->fieldlist['idtarjetainteligenteadmindocen'] = array('pkey' => 'y');
        $obj_update->updateRecord($fieldarray_tarjeta);
        /*dejamos activa la tarjeta en el cardholder del web service>*/
        /*activa la tarjeta si existe si no la crea*/
        $objAndor->setApellido(strtoupper($_REQUEST['apellidos'])); 
        $objAndor->setNombres(strtoupper($_REQUEST['nombres']));
        $objAndor->setNumeroTarjeta($_REQUEST['numerotarjeta']); 
       if($objAndor->servidor_activo()){
        $rsutl = $objAndor->set_ws_result();
       }
        $objAndor->setNombres('');
        $objAndor->setApellido('');
        $objAndor->setNumeroTarjeta('');
        if($objAndor->servidor_activo()){
        $rsutl = $objAndor->get_ws_result();
        }
        echo  $objAndor->table_cardholder($rsutl);
        exit();
    }
    /*la tarjeta no existe
     se verifica que nadie mas tenga la tarjeta primero en sala y luego en adover*/
    $obj_update = new table("tarjetainteligenteadmindocen");
    $obj_update->sql_where = " codigotarjetainteligenteadmindocen = '".$_REQUEST['numerotarjeta']."' ";
    $tar_admin = $obj_update->getData();
    $tar_admin = $tar_admin[0];    
    if (is_array($tar_admin)){
        echo "<div align='center'>proceso incompleto, la tarjeta ya esta asigna a otra persona<div>";
        exit();
    }else{        
        $objAndor->setNombres('');
        $objAndor->setApellido('');
        $objAndor->setDocumento('');        
        $objAndor->setNumeroTarjeta($_REQUEST['numerotarjeta']);
        if($objAndor->servidor_activo()){
        $rsutl = $objAndor->get_ws_result();
        }
        if($rsutl[0]['Documento']!=''){
            echo '<div align="center">proceso incompleto, la tarjeta ya esta asigna a otra persona<div>';    
            /*buscar el idadministrativo docente de quien tiene la tarjeta para sincronizar*/
            $obj_update = new table("administrativosdocentes");
            $obj_update->sql_where = " numerodocumento = '".$rsutl[0]['Documento']."'";
            $tar_admin = $obj_update->getData();
            $tar_admin = $tar_admin[0];            
            //print_r($tar_admin);
            /*actualizo en sala con la tarjeta que esta en andover y no en sala con estado activo*/            
            if($tar_admin['idadministrativosdocentes']!=''){
                $obj_update = new table("tarjetainteligenteadmindocen");
                $obj_update->fieldlist = $array_tarjeta;
                $fieldarray_tarjeta = array('idtarjetainteligenteadmindocen'=>NULL,
                'codigotarjetainteligenteadmindocen'=>$rsutl[0]['NumeroTarjeta'],
                'idadministrativosdocentes'=> $tar_admin['idadministrativosdocentes'],
                    'fecharegistrotarjetainteligenteadmindocen'=>date('Y-m-d'),'codigoestado'=>200);
                $obj_update->insertRecord($fieldarray_tarjeta);
                 exit();
            }
            exit();
        }else{
            /* Insertar tarjeta nueva en andover y si todo esta bien en sala*/             
            $objAndor->setNombres(str_replace(' ', '_',$_REQUEST['nombres']));
            $objAndor->setApellido(str_replace(' ', '_',$_REQUEST['apellidos']));
            $objAndor->setDocumento($_REQUEST['documento']);
            $objAndor->setNumeroTarjeta($_REQUEST['numerotarjeta']);
            if($objAndor->servidor_activo()){
            $rsutl = $objAndor->set_ws_result();
            }
            $obj_update = new table("tarjetainteligenteadmindocen");
            $obj_update->fieldlist = $array_tarjeta;

            if($objAndor->servidor_activo()){
                $sinc = 1;
            }   else {
                $sinc = 0;
            }

            $fieldarray_tarjeta = array('idtarjetainteligenteadmindocen'=>NULL,
            'codigotarjetainteligenteadmindocen'=>$_REQUEST['numerotarjeta'],
            'idadministrativosdocentes'=> $_REQUEST['idadministrativosdocentes'],'fecharegistrotarjetainteligenteadmindocen'=>date('Y-m-d'),'codigoestado'=>100,'sincandover'=>$sinc);
            $obj_update->insertRecord($fieldarray_tarjeta);
            $objAndor->setNombres('');
            $objAndor->setApellido('');
            $objAndor->setNumeroTarjeta('');
            if($objAndor->servidor_activo()){
            $rsutl = $objAndor->get_ws_result();
            }
            echo  $objAndor->table_cardholder($rsutl);           
            exit();
        }        
        echo  $objAndor->table_cardholder($rsutl);
        exit();
    }
    exit();       
}

?>
