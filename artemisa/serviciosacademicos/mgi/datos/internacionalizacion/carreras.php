<?php

require_once("../templates/template.php");

//$db = writeHeader("Internacionalizacion",TRUE);
 $db = getBD();
$utils = new Utils_datos();

/*PARA TRAER LAS CARRERAS*/

if(isset($_POST["codigomodalidadacademicasic"]))
 {
    $opciones = '<option value="todasc">Todas</option>';
    
    $query_selcarrera = "select codigocarrera, nombrecarrera from carrera where codigomodalidadacademicasic = '".$_POST['codigomodalidadacademicasic']."'";
    $selcarrera = $db->Execute($query_selcarrera);
    $totalRows_selcarrera = $selcarrera->RecordCount();
    
    while($row_selcarrera = $selcarrera->FetchRow())
    {
    
       $opciones.='<option value="'.$row_selcarrera["codigocarrera"].'">'.$row_selcarrera["nombrecarrera"].'</option>';
    }
     echo $opciones;
 }

/*PARA TRAER LA SITUACION DEL HIJO QUE VIENE DEL PADRE*/
if(isset($_POST["idsituacionmovilidad"]))
 {
 
 //echo "entra";
 
    $opciones = '<option value=""></option>';
    
    $query_tiposituacion = "select idsituacionmovilidad, nombre from situacionmovilidad where idpadresituacionmovilidad ='".$_POST['idsituacionmovilidad']."' and codigoestado=100";
    $tiposituacion = $db->Execute($query_tiposituacion);
    $totalRows_tiposituacion = $tiposituacion->RecordCount();
    
    while($row_tiposituacion = $tiposituacion->FetchRow())
    {
    
       $opciones.='<option value="'.$row_tiposituacion["idsituacionmovilidad"].'">'.$row_tiposituacion["nombre"].'</option>';
    }
     echo $opciones;
     //die;
     
  }
  
/*PARA TRAER LA SITUACION DEL NIETO QUE VIENE DEL HIJO*/  
if(isset($_POST["idsituacionmovilidad2"]))
 {
 
 $query_tipodetallesituacion = "select idsituacionmovilidad, nombre from situacionmovilidad where idpadresituacionmovilidad ='".$_POST['idsituacionmovilidad2']."' and codigoestado=100";
    $tipodetallesituacion = $db->Execute($query_tipodetallesituacion);
    $totalRows_tipodetallesituacion = $tipodetallesituacion->RecordCount();
    if($totalRows_tipodetallesituacion >0){
    
    $imprime= '<label for="tipodetallesituaestudiante" class="grid-2-12">Tipo Detalle Situación Estudiante: <span class="mandatory">(*)</span></label>';
    $imprime.='<select name="tipodetallesituaestudiante" id="tipodetallesituaestudiante" style="font-size:0.8em" class="required">';
    $imprime.='<option value=""></option>';
    
    while($row_tipodetallesituacion= $tipodetallesituacion->FetchRow()) {    
      $imprime.='<option value="'.$row_tipodetallesituacion["idsituacionmovilidad"].'">'.$row_tipodetallesituacion["nombre"].'</option>';
    }  
    $imprime.='</select>';
 
     }
     
     echo $imprime;
  }
  

/*PARA ALMACENAR Y MODIFICAR LA INFORMACION DE LA SITUACION DE MOVILIDAD DEL ESTUDIANTE*/
if(isset($_POST['codigoestudiante'])){  
  
  if(isset($_POST['tiposituaestudiante']) && !isset($_POST['tipodetallesituaestudiante'])){
  
    if($_POST['periodoinicial'] > $_POST['periodofinal']){ 
                $a_vectt['class'] = 'msg-success msg-error';
                $a_vectt['mensaje'] = 'El periodo inicial no puede ser mayor al periodo final';
                echo json_encode($a_vectt);
                //exit;
      //echo json_encode('mensaje'=>'El periodo inicial no puede ser mayor al periodo final');
    }
    else{
	$query_verificaexistente = "select * from estudiantesituacionmovilidad where codigoestudiante='".$_POST['codigoestudiante']."' and periodoinicial='".$_POST['periodoinicial']."' and codigoestado=100";
	$verificaexistente = $db->Execute($query_verificaexistente);
	$totalRows_verificaexistente = $verificaexistente->RecordCount();
	if($totalRows_verificaexistente >0){
	//echo json_encode('mensaje'=>'Ya Existe información Almacenada para el periodo seleccionado');
	        $a_vectt['class'] = 'msg-success msg-error';
	        $a_vectt['mensaje'] = 'Ya Existe información Almacenada para el periodo inicial seleccionado';
                echo json_encode($a_vectt);
                //exit;
	}
	else{
	
	  if(isset($_POST['idsitua'])){  
	  
		$query_actualizaestudiante = "update estudiantesituacionmovilidad set idsituacionmovilidad='".$_POST['tiposituaestudiante']."', periodoinicial='".$_POST['periodoinicial']."', periodofinal='".$_POST['periodofinal']."' 
		where codigoestudiante='".$_POST['codigoestudiante']."' and idestudiantesituacionmovilidad='".$_POST['idsitua']."'";
		$actualizaestudiante = $db->Execute($query_actualizaestudiante);
	  
	        $a_vectt['class'] = 'msg-success';
	        $a_vectt['mensaje'] = 'Se ha modificado la información correctamente';
                echo json_encode($a_vectt);  
	  }
	  else{
	
	   $query_ingresaest = "insert into estudiantesituacionmovilidad (idsituacionmovilidad, codigoestudiante, periodoinicial, periodofinal) 
	  values('".$_POST['tiposituaestudiante']."', '".$_POST['codigoestudiante']."','".$_POST['periodoinicial']."','".$_POST['periodofinal']."')";
	  $ingresaest = $db->Execute($query_ingresaest);
	  //echo json_encode('mensaje'=>'Se ha almacenado la información correctamente');
	        $a_vectt['class'] = 'msg-success';
	        $a_vectt['mensaje'] = 'Se ha almacenado la información correctamente';
                echo json_encode($a_vectt);
                //exit;
                
           }
	}
    
    
    }
      
  }
  elseif(isset($_POST['tiposituaestudiante']) && isset($_POST['tipodetallesituaestudiante'])){
  
    if($_POST['periodoinicial'] > $_POST['periodofinal']){ 
                $a_vectt['class'] = 'msg-success msg-error';
                $a_vectt['mensaje'] = 'El periodo inicial no puede ser mayor al periodo final';
                echo json_encode($a_vectt);
                //exit;
      //echo json_encode('mensaje'=>'El periodo inicial no puede ser mayor al periodo final');
    }
    else{
	$query_verificaexistente = "select * from estudiantesituacionmovilidad where codigoestudiante='".$_POST['codigoestudiante']."' and periodoinicial='".$_POST['periodoinicial']."' and codigoestado=100";
	$verificaexistente = $db->Execute($query_verificaexistente);
	$totalRows_verificaexistente = $verificaexistente->RecordCount();
	if($totalRows_verificaexistente >0){
	//echo json_encode('mensaje'=>'Ya Existe información Almacenada para el periodo seleccionado');
	        $a_vectt['class'] = 'msg-success msg-error';
	        $a_vectt['mensaje'] = 'Ya Existe información Almacenada para el periodo inicial seleccionado';
                echo json_encode($a_vectt);
                //exit;
	}
	else{
	
	if(isset($_POST['idsitua'])){  
	  
	        $query_actualizaestudiante = "update estudiantesituacionmovilidad set idsituacionmovilidad='".$_POST['tipodetallesituaestudiante']."', periodoinicial='".$_POST['periodoinicial']."', periodofinal='".$_POST['periodofinal']."' 
		where codigoestudiante='".$_POST['codigoestudiante']."' and idestudiantesituacionmovilidad='".$_POST['idsitua']."'";
		$actualizaestudiante = $db->Execute($query_actualizaestudiante);
	  
	        $a_vectt['class'] = 'msg-success';
	        $a_vectt['mensaje'] = 'Se ha modificado la información correctamente';
                echo json_encode($a_vectt);  
  
	  }
	  else{
	
	   $query_ingresaest = "insert into estudiantesituacionmovilidad (idsituacionmovilidad, codigoestudiante, periodoinicial, periodofinal) 
	  values('".$_POST['tipodetallesituaestudiante']."', '".$_POST['codigoestudiante']."','".$_POST['periodoinicial']."','".$_POST['periodofinal']."')";
	  $ingresaest = $db->Execute($query_ingresaest);
	  //echo json_encode('mensaje'=>'Se ha almacenado la información correctamente');
	        $a_vectt['class'] = 'msg-success';
	        $a_vectt['mensaje'] = 'Se ha almacenado la información correctamente';
                echo json_encode($a_vectt);
                //exit;                
          }
	}
    
    
    }
  
  }  
  
}

if(isset($_POST['idestudiantesituacionmovilidad'])){

//echo "imprime la entrada".$_POST['idestudiantesituacionmovilidad'];
$query_actualizaest = "update estudiantesituacionmovilidad set codigoestado='200' where  idestudiantesituacionmovilidad='".$_POST['idestudiantesituacionmovilidad']."' and codigoestado=100";
    $actualizaest = $db->Execute($query_actualizaest);
    echo "ok";

}


?>
