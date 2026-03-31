<?php
    session_start();
    include_once((realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php')); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();
    //funcion para validacion de carracteres
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑ\s]', '', $cadena));
         return $cadena;
    }
    //consulta del id del usuario
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $datosusuario = $db->GetRow($sqlS);
    $user = $datosusuario['idusuario'];
    
    if($_REQUEST['Accion']== 'actualizar')
    {        
        $conveniocarrera = $_REQUEST['conveniocarrera'];     
        $estado = $_REQUEST['estado'];        
        $update = "UPDATE conveniocarrera SET codigoestado='".$estado."' WHERE (idconveniocarrera='".$conveniocarrera."')";                
        $actualiza = $db->Execute($update);
        
         
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='La carrera-convenio fue actualizada';
        echo json_encode($a_vectt);  
        exit;     
        
    }else
    {
        $contador                      = $_REQUEST['contador'];
        $estado                        = '100';
        $FechaCreacion                 = date("Y-m-d H:i:s");
        $UsuarioCreacion               = $user;
        $idconvenio                    = $_REQUEST['idconvenio'];
        $tipocontraprestacion          = $_REQUEST['IdContraprestacion']; 
        
        $tipocontraprestacion = limpiarCadena(filter_var($tipocontraprestacion,FILTER_SANITIZE_NUMBER_INT));
        $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
        $contador = limpiarCadena(filter_var($contador,FILTER_SANITIZE_NUMBER_INT));
        $UsuarioCreacion = limpiarCadena(filter_var($UsuarioCreacion,FILTER_SANITIZE_NUMBER_INT));
    
        $contador = $contador-1;
        $message = null;
        
        for($i=1; $contador >= $i; $i++)
        {   
            $carrera[$i] = $_POST['carrera'.$i];        
            if(!empty($carrera) && $tipocontraprestacion <> '0' && $carrera[$i] <> null)
            {
                $sql1="SELECT idconveniocarrera, codigoestado FROM conveniocarrera WHERE ConvenioId = '".$idconvenio."' AND codigocarrera = '". $carrera[$i]."'";
                $valores = $db->GetRow($sql1);
                if (!$valores['idconveniocarrera'])
                {
                    $sql2="insert into conveniocarrera(ConvenioId, codigocarrera, codigoestado, IdContraprestacion, UsuarioCreacion, FechaCreacion) values('".$idconvenio."', '". $carrera[$i]."','".$estado."', '".$tipocontraprestacion."', '".$user."', '".$FechaCreacion."')";
                    $agregar = $db->Execute($sql2);
                    $message = 'La carrera-convenio fue agregada';
                }else if(isset($valores['codigoestado']) &&
                    ($valores['codigoestado']== '200' || $valores['codigoestado'] == ""))
                {
                    $sql4 = "UPDATE conveniocarrera SET codigoestado='100' WHERE (convenioid ='".$idconvenio."' and codigocarrera = '". $carrera[$i]."' and idcontraprestacion = '".$tipocontraprestacion."')";
                    $upgrade = $db->Execute($sql4);
                    $message = 'La carrera-convenio fue actualizada';
                }

                else if($valores['codigoestado'] == 100)
                {
                    $message = 'El programa ya se encuentra activo para este convenio';
                }
            }
        }

        // Set up associative array
        if($message === null){
            $data = array('success'=> false,'message'=>'No se han aplicados los cambios, por favor selecciones un programa.');
        } else 
        {
            $data = array('success'=> true,'message'=>$message);
        }
        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>