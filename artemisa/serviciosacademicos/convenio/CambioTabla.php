<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
 include_once ('../EspacioFisico/templates/template.php');
  $db = getBD();
  
  $SQL='SELECT
                IdAnexoConvenio,
                codigocarrera,
                FechaCreacion,
                UsuarioCreacion
        FROM
                AnexoConvenios
        
        WHERE
                codigoestado=100';
                
   if($Consulta=&$db->GetAll($SQL)===false){
        echo 'Error en el SQL de Anexo Convenio...<br><br>'.$SQL;
        die;
   }             

   for($i=0;$i<count($Consulta);$i++){
        $id      = $Consulta[$i]['IdAnexoConvenio'];
        $carrera = $Consulta[$i]['codigocarrera'];
        $Fecha   = $Consulta[$i]['FechaCreacion'];
        $User    = $Consulta[$i]['UsuarioCreacion'];
        
          $SQL='SELECT
                	*
                FROM
                	CarreraAnexoConvenio
                
                WHERE
                
                IdAnexoConvenio="'.$id.'"
                AND
                CodigoCarrera="'.$carrera.'"
                AND
                CodigoEstado=100';
                
           if($Valida=&$db->Execute($SQL)===false){
             echo 'Error en el SQL de la Validacion...<br><br>'.$SQL;
             die;
           }     
                
           if($Valida->EOF){     
        
        echo '<br><br>'.$i.'<->'.$InsertCarrera='INSERT INTO  CarreraAnexoConvenio(IdAnexoConvenio,CodigoCarrera,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$id.'","'.$carrera.'","'.$User.'","'.$Fecha.'","'.$User.'","'.$Fecha.'")';
        
                if($CarreraConvenioAnexo=&$db->Execute($InsertCarrera)===false){
                    echo 'Error en el Insert Carrera Convenio Anexo...<br><br>'.$InsertCarrera;
                    die;
                }
        }
   }//for 
?>