<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$action = $_REQUEST["action"];
$utils = new Utils_datos();
$success = true;
$row_mesinf=0;
if((strcmp($action,"getDataDynamic")==0)){
  $queryConsultas="select * from ".$_REQUEST['entity']." where anioperiodo='".$_REQUEST['anio']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
  $Detalles=$db->Execute($queryConsultas);
  if(!$Detalles->EOF){
    while (!$Detalles->EOF) {
      $id[]               = $Detalles->fields['idsiq_ofpresupuestos'];
      $id_Clasificacion[] = $Detalles->fields['idclasificacionesinfhuerfana'];
      $Ejecutado[]        = $Detalles->fields['ejecutado'];
      $Presupuestado[]    = $Detalles->fields['presupuestado'];
      $Detalles->MoveNext();
      }
      $a_vectt['success']            =true; 
      $a_vectt['id']                 =$id;
      $a_vectt['id_Clasificacion']   =$id_Clasificacion;
      $a_vectt['Ejecutado']          =$Ejecutado;
      $a_vectt['Presupuestado']      =$Presupuestado;
      echo json_encode($a_vectt);
      exit;
      }else{
        $query_sectores = "select idclasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$_REQUEST['padre']."' AND estado=1 order by 1 ";
        $detalleIdClasificacion=$db->Execute($query_sectores);
        while (!$detalleIdClasificacion->EOF) {
          $id_Clasificacion[] = $detalleIdClasificacion->fields['idclasificacionesinfhuerfana'];
          $detalleIdClasificacion->MoveNext();
          }
          $a_vectt['id_Clasificacion']   = array_unique($id_Clasificacion);
          $a_vectt['Presupuestado']      = "";
          $a_vectt['Ejecutado']          = "";
          $a_vectt['success']=false; 
          $a_vectt['descrip']='No hay Datos o informacion';
          echo json_encode($a_vectt);
          exit;
   }
  }elseif (strcmp($_REQUEST['action'],'financiamiento')==0) {
    $query_informacion="select * from ".$_REQUEST['entity']." where anioperiodo='".$_REQUEST['anio']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
    $Ejecuta_query=$db->Execute($query_informacion);
    $arreglos = unserialize(base64_decode($_REQUEST['idclasificacionesinfhuerfana']));
    if (!$Ejecuta_query->EOF){
      foreach ($Ejecuta_query as $ro){$variables[] = $ro['idsiq_ofpresupuestos'];}
      $i = 0;
      if (!$arreglos->EOF){
        foreach ($arreglos as $row){
          $query_update="UPDATE ".$_REQUEST['entity']." SET presupuestado ='".$_REQUEST[$row.'/presupuestado']."', ejecutado='".$_REQUEST[$row.'/ejecutado']."' WHERE idsiq_ofpresupuestos='".$variables[$i]."' ";
          if($inserta= &$db->Execute($query_update)===false){
            $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
            $a_vectt['success']=false;
            echo json_encode($a_vectt);
          }
          $i++;
        }
        $a_vectt['success']=true; 
        $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
        echo json_encode($a_vectt);
        exit;
      }else{
        $a_vectt['success']=false;  
        $a_vectt['descrip']='No hay datos';
        echo json_encode($a_vectt);
        exit;
      }
    }else{
      foreach ($arreglos as $row){
        $query_inserta="insert into ".$_REQUEST['entity']." (idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado) values('".$_REQUEST['padre']."','".$row."','".$_REQUEST[$row.'/presupuestado']."','".$_REQUEST[$row.'/ejecutado']."','".$_REQUEST['anio']."', 100)";
        if($inserta= &$db->Execute($query_inserta)===false){
          $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
          $a_vectt['success']=false;
          echo json_encode($a_vectt);
          exit;
        }
      }
      $a_vectt['success']=true; 
      $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
      echo json_encode($a_vectt);
      exit;
    }
  }elseif (strcmp($_REQUEST['action'],'desarrollo')==0) {
    $queryConsultas = "select * from siq_ofpresupuestos where anioperiodo='".$_REQUEST['anio']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
    $Detalles=$db->Execute($queryConsultas);
    $arreglos = $_REQUEST['idclasificacionesinfhuerfana'];
    $idsiq_ofpresupuestos = $Detalles->fields['idsiq_ofpresupuestos'];
    if(!$Detalles->EOF){
      $query_update="UPDATE ".$_REQUEST['entity']." SET presupuestado ='".$_REQUEST[$arreglos.'/presupuestado']."', ejecutado='".$_REQUEST[$arreglos.'/ejecutado']."' WHERE idsiq_ofpresupuestos='".$idsiq_ofpresupuestos."' ";
      if($actualiza = &$db->Execute($query_update)===false){
        $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
        $a_vectt['success']=false;
        echo json_encode($a_vectt);
        exit;
      }else{
        $a_vectt['success']=true; 
        $a_vectt['descrip']='Los datos han sido actualizados de forma correcta ';
        echo json_encode($a_vectt);
        exit;
      }
    }else{
      $query_inserta="insert into ".$_REQUEST['entity']." (idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado) values('".$_REQUEST['padre']."','".$arreglos."','".$_REQUEST[$arreglos.'/presupuestado']."','".$_REQUEST[$arreglos.'/ejecutado']."','".$_REQUEST['anio']."', 100)";
      if($inserta= &$db->Execute($query_inserta)===false){
          $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
          $a_vectt['success']=false;
          echo json_encode($a_vectt);
          exit;
        }else{
          $a_vectt['success']=true; 
          $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
          echo json_encode($a_vectt);
          exit;
        }

    }
  }elseif (strcmp($_REQUEST['action'],'investigacion')==0) {
    $query_informacion="select * from ".$_REQUEST['entity']." where anioperiodo='".$_REQUEST['anio']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
    $Ejecuta_query=$db->Execute($query_informacion);
    $arreglos = unserialize(base64_decode($_REQUEST['idclasificacionesinfhuerfana']));
    if (!$Ejecuta_query->EOF){
      foreach ($Ejecuta_query as $ro){$variables[] = $ro['idsiq_ofpresupuestos'];}
      $i = 0;
      if (!$arreglos->EOF){
        foreach ($arreglos as $row){
          $query_update="UPDATE ".$_REQUEST['entity']." SET presupuestado ='".$_REQUEST[$row.'/presupuestado']."', ejecutado='".$_REQUEST[$row.'/ejecutado']."' WHERE idsiq_ofpresupuestos='".$variables[$i]."' ";
          if($inserta= &$db->Execute($query_update)===false){
            $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
            $a_vectt['success']=false;
            echo json_encode($a_vectt);
          }
          $i++;
        }
        $a_vectt['success']=true; 
        $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
        echo json_encode($a_vectt);
        exit;
      }else{
        $a_vectt['success']=false;  
        $a_vectt['descrip']='No hay datos';
        echo json_encode($a_vectt);
        exit;
      }
    }else{
      foreach ($arreglos as $row){
        $query_inserta="insert into ".$_REQUEST['entity']." (idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado) values('".$_REQUEST['padre']."','".$row."','".$_REQUEST[$row.'/presupuestado']."','".$_REQUEST[$row.'/ejecutado']."','".$_REQUEST['anio']."', 100)";
        if($inserta= &$db->Execute($query_inserta)===false){
          $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
          $a_vectt['success']=false;
          echo json_encode($a_vectt);
          exit;
        }
      }
      $a_vectt['success']=true; 
      $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
      echo json_encode($a_vectt);
      exit;
    }
  }elseif (strcmp($_REQUEST['action'],'bienestar')==0) {
    $query_informacion="select * from ".$_REQUEST['entity']." where anioperiodo='".$_REQUEST['anio']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
    $Ejecuta_query=$db->Execute($query_informacion);
    $arreglos = unserialize(base64_decode($_REQUEST['idclasificacionesinfhuerfana']));
    $idsiq_ofpresupuestos = $Ejecuta_query->fields['idsiq_ofpresupuestos'];
    if(!$Ejecuta_query->EOF){
      $query_update="UPDATE ".$_REQUEST['entity']." SET presupuestado ='".$_REQUEST[$arreglos[0].'/presupuestado']."', ejecutado='".$_REQUEST[$arreglos[0].'/ejecutado']."' WHERE idsiq_ofpresupuestos='".$idsiq_ofpresupuestos."' ";
      if($actualiza = &$db->Execute($query_update)===false){
        $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
        $a_vectt['success']=false;
        echo json_encode($a_vectt);
        exit;
      }else{
        $a_vectt['success']=true; 
        $a_vectt['descrip']='Los datos han sido actualizados de forma correcta ';
        echo json_encode($a_vectt);
        exit;
      }
    }else{
      foreach ($arreglos as $row){
        $query_inserta="insert into ".$_REQUEST['entity']." (idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado) values('".$_REQUEST['padre']."','".$row."','".$_REQUEST[$row.'/presupuestado']."','".$_REQUEST[$row.'/ejecutado']."','".$_REQUEST['anio']."', 100)";
        if($inserta= &$db->Execute($query_inserta)===false){
          $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
          $a_vectt['success']=false;
          echo json_encode($a_vectt);
          exit;
        }
      }
      $a_vectt['success']=true; 
      $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
      echo json_encode($a_vectt);
      exit;
    }
  }elseif (strcmp($_REQUEST['action'],'biblio')==0) {
    $query_informacion="select * from ".$_REQUEST['entity']." where anioperiodo='".$_REQUEST['anio']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
    $Ejecuta_query=$db->Execute($query_informacion);
    $arreglos = unserialize(base64_decode($_REQUEST['idclasificacionesinfhuerfana']));
    if (!$Ejecuta_query->EOF){
      foreach ($Ejecuta_query as $ro){$variables[] = $ro['idsiq_ofpresupuestos'];}
      $i = 0;
      if (!$arreglos->EOF){
        foreach ($arreglos as $row){
          $query_update="UPDATE ".$_REQUEST['entity']." SET presupuestado ='".$_REQUEST[$row.'/presupuestado']."', ejecutado='".$_REQUEST[$row.'/ejecutado']."' WHERE idsiq_ofpresupuestos='".$variables[$i]."' ";
          if($inserta= &$db->Execute($query_update)===false){
            $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
            $a_vectt['success']=false;
            echo json_encode($a_vectt);
          }
          $i++;
        }
        $a_vectt['success']=true; 
        $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
        echo json_encode($a_vectt);
        exit;
      }else{
        $a_vectt['success']=false;  
        $a_vectt['descrip']='No hay datos';
        echo json_encode($a_vectt);
        exit;
      }
    }else{
      foreach ($arreglos as $row){
        $query_inserta="insert into ".$_REQUEST['entity']." (idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado) values('".$_REQUEST['padre']."','".$row."','".$_REQUEST[$row.'/presupuestado']."','".$_REQUEST[$row.'/ejecutado']."','".$_REQUEST['anio']."', 100)";
        if($inserta= &$db->Execute($query_inserta)===false){
          $a_vectt['descrip'] ='Error En el SQL Insert O Consulta....'.$query_inserta;
          $a_vectt['success']=false;
          echo json_encode($a_vectt);
          exit;
        }
      }
      $a_vectt['success']=true; 
      $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
      echo json_encode($a_vectt);
      exit;
    }
  }

?>
