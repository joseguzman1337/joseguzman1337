<?php
    session_start();
    include_once((realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php')); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');
    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();
   
    if($_POST['Action']== 'GuardarCon')
    {
        //consulta del id del usuario 
        $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";        
        $datosusuario = $db->GetRow($sqlS);
        $user = $datosusuario['idusuario'];

        $message = null;
        $id                             = $_POST['idcontra'];
        $idtipopracticante              = $_POST['idtipopracticante'];
        $IdTipoPagoContraprestacion     = $_POST['IdTipoPagoContraprestacion'];
        $ValorContraprestacion          = $_POST['ValorContraprestacion'];
        $FechaCreacion                  = date("Y-m-d H:i:s");
        $tipocontraprestacion           = $_POST['tipocontraprestacion'];
        $codigoestado                   = $_POST['codigoestado'];
        $idconvenio                     = $_POST['idconvenio'];
        $institucionubicacion           = $_POST['IdUbicacionInstitucion'];
        $articulo                       = $_POST['articulo'];

        //validacion y sanetizacion de las vriables de ingreso.
        $institucionubicacion = limpiarCadena(filter_var($institucionubicacion,FILTER_SANITIZE_NUMBER_INT));
        $tipocontraprestacion = limpiarCadena(filter_var($tipocontraprestacion,FILTER_SANITIZE_NUMBER_INT));
        $codigoestado = limpiarCadena(filter_var($codigoestado,FILTER_SANITIZE_NUMBER_INT));
        $idtipopracticante = limpiarCadena(filter_var($idtipopracticante,FILTER_SANITIZE_NUMBER_INT));
        $valorcontraprestacion = limpiarCadena(filter_var($valorcontraprestacion,FILTER_SANITIZE_NUMBER_INT));
        $IdTipoPagoContraprestacion = limpiarCadena(filter_var($IdTipoPagoContraprestacion,FILTER_SANITIZE_NUMBER_INT));
        $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));    
        
        $select = "select IdContraprestacion from Contraprestaciones where IdUbicacionInstitucion = '".$institucionubicacion."' and idsiq_contraprestacion = '".$tipocontraprestacion."' and IdTipoPracticante = '".$idtipopracticante."' and codigoestado='".$codigoestado."'";
        $buscar = $db->GetRow($select);        
        $consulta = $buscar['IdContraprestacion'];
        
        if(!empty($id))
        {
            if($_POST['accion'] == 'update')
            {
                //actualiza los registros modificados de la contraprestacion
                $sqlupdate = "UPDATE Contraprestaciones SET ValorContraprestacion='".$ValorContraprestacion."', IdTipoPagoContraprestacion='".$IdTipoPagoContraprestacion."', IdTipoPracticante='".$idtipopracticante."', FechaUltimaModificacion ='".$FechaCreacion."', UsuarioUltimaModificacion='".$user."', idsiq_contraprestacion ='".$tipocontraprestacion."', codigoestado = '".$codigoestado."', Detalle ='".$articulo."'  WHERE (IdContraprestacion='".$id."')";

                $db->execute($sqlupdate);       
                $message="La contraprestacion se modifico correctamente.";
            }
        }else
        {
            if($consulta)
            {
               $message="La contraprestacion ya existe."; 
            }else{
                
                if($_POST['accion'] == 'insert')
                {
                    //crear una nueva contraprestacion para el convenio actual.
                    $sqlinsert="insert into Contraprestaciones(IdUbicacionInstitucion, idsiq_contraprestacion, IdTipoPracticante, IdTipoPagocontraprestacion, ValorContraprestacion, codigoestado, UsuarioCreacion, FechaCreacion, ConvenioId, Detalle) values('".$institucionubicacion."', '".$tipocontraprestacion."','".$idtipopracticante."', '".$IdTipoPagoContraprestacion."', '".$ValorContraprestacion."', '".$codigoestado."', '".$user."', '".$FechaCreacion."', '".$idconvenio."', '".$articulo."')";
                    $db->execute($sqlinsert); 
                    $message="La contraprestacion se creo correctamente.";
                }
            }
        }
        
        // Set up associative array
        if($message===null){
            $data = array('success'=> false,'message'=>'Ha ocurrido un problema con la contraprestacion.');
        } else 
        {
            $data = array('success'=> false,'message'=>$message);
        }
        // JSON encode and send back to the server
        echo json_encode($data);
    }else
    {
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema con la contraprestacion.');
        echo json_encode($data);
    }
?>