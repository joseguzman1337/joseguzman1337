<?php
 session_start(); 

require_once("../templates/template.php");
$db = getBD();

$utils = new Utils_datos();

function updateNumeroPersonas($db,$periodoActualizar,$utils){
    $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoperiodo='".$periodoActualizar['codigoperiodo']."' AND codigoestado='100'"; 
    $fields = $db->GetRow($sql);    
    $num = count($fields);
    //hacer las consultas para sacar el total de esto
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);    
        $fields["numAcademicos"] = $resultado["total"];
     
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Administrativo' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);
        
        $fields["numAdministrativos"] = $resultado["total"];
        
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND tipoContrato='AFS' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);
    //academicos adjuntos
        $fields["numAcademicosSemestral"] = $resultado["total"];
        
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND tipoContrato='AFA' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
    //cuerpo profesoral
        $fields["numAcademicosAnual"] = $resultado["total"];
    
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND tipoContrato IN ('CMA','CTI','CPC','AMA','CPS') AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicosNucleoProfesoral"] = $resultado["total"];
    
    $horas = 48;
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND horasSemanales>".($horas*3/4)." AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicosTC"] = $resultado["total"];   
        
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND horasSemanales>".($horas*1/2)." AND horasSemanales<=".($horas*3/4)." AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicos34T"] = $resultado["total"];   
        
   $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND horasSemanales>".($horas*1/4)." AND horasSemanales<=".($horas*1/2)." AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicosMT"] = $resultado["total"];  
     
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE tipoEmpleado='Académico' AND horasSemanales<=".($horas*1/4)." AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicos14T"] = $resultado["total"]; 
        
    if($num==0){
        $fields["codigoperiodo"] = $periodoActualizar['codigoperiodo'];
        $id=$utils->processData("save","formTalentoHumanoNumeroPersonas",$fields,false);
    } else {
        $id=$utils->processData("update","formTalentoHumanoNumeroPersonas",$fields,false);
    }
}

function updateDocentesEscalafon($db,$utils){
    $year = date("Y");
    $sql = "SELECT * FROM siq_formTalentoHumanoDocentesEscalafon WHERE codigoperiodo='".$year."' AND codigoestado='100'"; 
    $fields = $db->GetRow($sql);    
    $num = count($fields);
    //hacer las consultas para sacar el total de esto
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE escalafonDocente='Profesor Titular' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);    
        $fields["numAcademicosPTitular"] = $resultado["total"];
     
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE escalafonDocente='Profesor Asociado' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);
        
        $fields["numAcademicosPAsociado"] = $resultado["total"];
        
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE escalafonDocente='Profesor Asistente' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);
    //academicos adjuntos
        $fields["numAcademicosPAsistente"] = $resultado["total"];
        
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE escalafonDocente='Instructor Asociado' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
    //cuerpo profesoral
        $fields["numAcademicosIAsociado"] = $resultado["total"];
    
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE escalafonDocente='Instructor Asistente' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicosIAsistente"] = $resultado["total"];
    
    $horas = 48;
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE escalafonDocente NOT IN ('Profesor Asociado','Instructor Asistente','Instructor Asociado','Profesor Asistente','Profesor Titular') AND tipoEmpleado='Académico' AND codigoestado='100'";
    $resultado = $db->GetRow($sql);   
        $fields["numAcademicosOtros"] = $resultado["total"];   
        
    if($num==0){
        $fields["codigoperiodo"] = $year;
        $id=$utils->processData("save","formTalentoHumanoDocentesEscalafon",$fields,false);
    } else {
        $id=$utils->processData("update","formTalentoHumanoDocentesEscalafon",$fields,false);
    }
}

function updatePrestacionServicios($db,$utils,$idActividad,$idTipoCentroCosto,$periodoActualizar){
	$sql = "SELECT * FROM siq_formTalentoHumanoPersonalPrestacionServicios WHERE codigoperiodo='".$periodoActualizar['codigoperiodo']."' 
	AND idActividad='".$idActividad."' AND codigoestado='100'"; 
    $fields = $db->GetRow($sql);    
    $num = count($fields);
     
    $sql = "SELECT COUNT(p.idpersonalPrestacionServiciosPeopleSoft) as total, 
			SUM(p.valorBruto) as valorServicios FROM sala.personalPrestacionServiciosPeopleSoft p
			inner join centrocosto c on c.codigocentrocosto=centroCosto 
			inner join tipocentrocosto t on t.codigotipocentrocosto=c.codigotipocentrocosto
			and t.codigotipocentrocosto='".$idTipoCentroCosto."' and p.codigoestado='100'";
    $resultado = $db->GetRow($sql);
        $fields["idActividad"] = $idActividad;
        $fields["numPersonas"] = $resultado["total"];
		$fields["valorServicios"] = $resultado["valorServicios"];
        
    if($num==0){
        $fields["codigoperiodo"] = $periodoActualizar['codigoperiodo'];
        $id=$utils->processData("save","formTalentoHumanoPersonalPrestacionServicios",$fields,false);
    } else {
        $id=$utils->processData("update","formTalentoHumanoPersonalPrestacionServicios",$fields,false);
    }
}
   
if(sizeof($_FILES)==0){
     echo "No se puede subir el archivo";
     exit();
  }

  //////////trae los datos del archivo
 $tempFile = $_FILES['files']['tmp_name'];
 $nombre = $_FILES['files']['name'];
 $tipo = $_FILES['files']['type'];
 $tamano = $_FILES['files']['size'];
 $handle = fopen($tempFile,"r"); 
 
 if((strcmp($_REQUEST["entity"],"personalUniversidadPeopleSoft")==0)){
 $i=0;
 //lee las lineas del archivo
 $sql = "UPDATE personalUniversidadPeopleSoft SET codigoestado=200";
 $db->Execute($sql);
   while ($data = fgetcsv ($handle, 1000, ";")){ 
       $fields = array();
        //se vuela las primeras lineas porque son textos
       //var_dump($data);echo "<br/><br/>";
       //si el empleado esta activo y no es de colegio
            if ($i>1 && strcmp($data[5],"Activo")==0 && strcmp($data[18],"GP_COLEGIO")!=0){
                $fields['nombreEmpleado']=mysql_real_escape_string(utf8_encode($data[4]));
                
                $fields['tipoDocumento']=$data[0];
                $fields['numeroDocumento']=$data[1];
                $fields['idEmpleadoPeopleSoft']=$data[2];
                $fields['tipoEmpleado']=utf8_encode($data[41]);
                $fields['numeroContrato']=intval($data[15]);
                //AFA = Contrato Acad.Ter.Fijo Anual, CMA = Contrato  Fijo Mayor a un año, AFS = Cont.Acad.Ter.Fij.Semest
                //CTI = Contrato Termino Indefinido, CPC = Contrato Prestamos Condonables (este cpc no lo cuento xq es un prestamo)
                //AMA = Cont.Fij.Menor a un año, CPS = 
                $fields['tipoContrato']=$data[16];
                $fields['horasSemanales']=$data[29];
                $fields['dedicacionPeopleSoft']=utf8_encode($data[32]);
                
                //llega en formato dia/mes/año
                $pieces = explode("/", $data[11]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];
                $fields['fechaInicioContrato']=$fechaC;                
                
                $pieces = explode("/", $data[13]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];
                $fields['fechaFinContrato']=$fechaC;
                
                $unidad = $data[33];
                $sql = "SELECT codigofacultad FROM relacionUnidadNegocioFacultad WHERE unidadNegocio='".$unidad."' AND codigoestado='100'";
                $facultad = $db->GetRow($sql);
                if(count($facultad)>0){
                    $fields['codigofacultad']=$facultad["codigofacultad"];
                } else {
                    $fields['codigofacultad']="NULL";
                }
                
                $fecha = strtotime($fields['fechaInicioContrato']);
                $fecha = date('Y-m-d', $fecha);
                
                $sql = "SELECT codigoperiodo FROM periodo WHERE '".$fecha."' between fechainicioperiodo and fechavencimientoperiodo"; 
                $periodo = $db->GetRow($sql);
                //toca calcularlo con la fecha del contrato
                $fields['codigoperiodo']=$periodo['codigoperiodo'];
                
                $sql = "SELECT * FROM personalUniversidadPeopleSoft WHERE idEmpleadoPeopleSoft='".$fields['idEmpleadoPeopleSoft']."' 
                    AND numeroContrato<'".$fields['numeroContrato']."'"; 
                $empleado = $db->GetRow($sql);
                
                if(count($empleado)==0){
                    $sql = "SELECT * FROM personalUniversidadPeopleSoft WHERE idEmpleadoPeopleSoft='".$fields['idEmpleadoPeopleSoft']."'"; 
                    $empleado = $db->GetRow($sql);
                    $fields['codigoestado']=100;
                    //asegurarme que no hay un num de contrato mas alto
                    if(count($empleado)==0){
                        $id=$utils->processData("save",$_REQUEST["entity"],$fields,false,false,"");
                    } else {
                        //solo me toca re-activarlo
                        $fields = array();
                        $fields['idpersonalUniversidadPeopleSoft']=$empleado["idpersonalUniversidadPeopleSoft"];
                        $fields['codigoestado']=100;
                        $id=$utils->processData("update",$_REQUEST["entity"],$fields,false,false,"");
                    }
                } else {
                    $fields['idpersonalUniversidadPeopleSoft']=$empleado["idpersonalUniversidadPeopleSoft"];
                    $fields['codigoestado']=100;
                    $id=$utils->processData("update",$_REQUEST["entity"],$fields,false,false,"");
                }
            }
            $i++;
    } 
    
    //actualizar los formularios de info huerfana para el periodo actual 
    $currentdate  = date("Y-m-d H:i:s");
    $sql = "SELECT codigoperiodo FROM periodo WHERE '".$currentdate."' between fechainicioperiodo and fechavencimientoperiodo"; 
    $periodoActualizar = $db->GetRow($sql);
    //$sql = "SELECT codigoperiodo FROM docentePeopleSoft GROUP BY codigoperiodo"; 
    //$periodosActualizar = $db->GetAll($sql);
    updateNumeroPersonas($db,$periodoActualizar,$utils);
    
            $location = "./index.php";
 } else if((strcmp($_REQUEST["entity"],"docentesPeopleSoft")==0)){
     $_REQUEST["entity"] = "personalUniversidadPeopleSoft";
     $_POST["entity"] = "personalUniversidadPeopleSoft";
 $i=0;
 //lee las lineas del archivo
 $sql = "UPDATE personalUniversidadPeopleSoft SET escalafonDocente=NULL WHERE codigoestado='100'";
 $db->Execute($sql);
   while ($data = fgetcsv ($handle, 1000, ";")){ 
       $fields = array();
        //se vuela las primeras lineas porque son textos
       //var_dump($data);echo "<br/><br/>";
       //si el empleado esta activo y no es de colegio
            if ($i>1){
                $fields['idEmpleadoPeopleSoft'] = $data[0];
                $sql = "SELECT * FROM personalUniversidadPeopleSoft WHERE idEmpleadoPeopleSoft='".$fields['idEmpleadoPeopleSoft']."' 
                    AND codigoestado='100'"; 
               //var_dump($sql);
                $empleado = $db->GetRow($sql);
                //var_dump($empleado); die();
                //solo si existe le agrego el escalafon
                if(count($empleado)!=0){
                    $fields['idpersonalUniversidadPeopleSoft']=$empleado["idpersonalUniversidadPeopleSoft"];
                    $fields['codigoestado']=100;
                    $fields['tipoEmpleado']="Académico";
                    $fields['horasSemanales']=$data[5];
                    $fields['escalafonDocente']=$data[17];
                    $id=$utils->processData("update",$_REQUEST["entity"],$fields,false,false,"");
                }                
                
            }
            $i++;
    } 
    
    //actualizar los formularios de info huerfana para el periodo actual 
    $currentdate  = date("Y-m-d H:i:s");
    $sql = "SELECT codigoperiodo FROM periodo WHERE '".$currentdate."' between fechainicioperiodo and fechavencimientoperiodo"; 
    $periodoActualizar = $db->GetRow($sql);
    //$sql = "SELECT codigoperiodo FROM docentePeopleSoft GROUP BY codigoperiodo"; 
    //$periodosActualizar = $db->GetAll($sql);
    updateNumeroPersonas($db,$periodoActualizar,$utils);
    
    //actualizar Escalafones
    updateDocentesEscalafon($db,$utils);
    
            $location = "./docentesEscalafon.php";
 } else  if((strcmp($_REQUEST["entity"],"desvinculadosPeopleSoft")==0)){
     $_REQUEST["entity"] = "personalUniversidadPeopleSoft";
     $_POST["entity"] = "personalUniversidadPeopleSoft";
 $i=0;
 //lee las lineas del archivo
   while ($data = fgetcsv ($handle, 1000, ";")){ 
       $fields = array();
        //se vuela las primeras lineas porque son textos
       //var_dump($data);echo "<br/><br/>";
       //si el empleado esta activo y no es de colegio
            if ($i>1 && strcmp($data[5],"Inactivo")==0 && strcmp($data[18],"GP_COLEGIO")!=0){
                $fields['nombreEmpleado']=mysql_real_escape_string(utf8_encode($data[4]));
                
                $fields['tipoDocumento']=$data[0];
                $fields['numeroDocumento']=$data[1];
                $fields['idEmpleadoPeopleSoft']=$data[2];
                $fields['tipoEmpleado']=utf8_encode($data[41]);
                $fields['numeroContrato']=intval($data[15]);
                //AFA = Contrato Acad.Ter.Fijo Anual, CMA = Contrato  Fijo Mayor a un año, AFS = Cont.Acad.Ter.Fij.Semest
                //CTI = Contrato Termino Indefinido, CPC = Contrato Prestamos Condonables (este cpc no lo cuento xq es un prestamo)
                $fields['tipoContrato']=$data[16];
                $fields['horasSemanales']=$data[29];
                $fields['dedicacionPeopleSoft']=utf8_encode($data[32]);
                
                //ABC = Abandono Cargo, DEF = Defunción, FCA = Fin Contrato Aprendiz, FCT = Fin Contrato Término Fijo
                //INR = Intersemestralidad Retiro, INT = Intersemestralidad, MUA = Mutuo Acuerdo, PDV = Pensión Vejez
                //PER = Motivos Personales, REN = Renuncia, RWU = Cesación Pagos, TCA = Terminación Convenio Académico
                //TSJ = Terminación Unilat sin Jus Cau, TUJ = Terminación Unilateral just Ca, UFC = Circunstancias Imprevistas
                $fields['motivoDesvinculacion']=$data[8];
                
                //llega en formato dia/mes/año
                $pieces = explode("/", $data[11]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];
                $fields['fechaInicioContrato']=$fechaC;                
                
                $pieces = explode("/", $data[13]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];
                $fields['fechaFinContrato']=$fechaC;
                
                $pieces = explode("/", $data[10]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];                
                $fecha = strtotime($fechaC);
                $fecha = date('Y-m-d', $fecha);
                
                $sql = "SELECT codigoperiodo FROM periodo WHERE '".$fecha."' between fechainicioperiodo and fechavencimientoperiodo"; 
                $periodo = $db->GetRow($sql);
                //toca calcularlo con la fecha efectiva
                $fields['codigoperiodo']=$periodo['codigoperiodo'];
                
                $sql = "SELECT * FROM personalUniversidadPeopleSoft WHERE idEmpleadoPeopleSoft='".$fields['idEmpleadoPeopleSoft']."' 
                    AND numeroContrato<'".$fields['numeroContrato']."'"; 
                $empleado = $db->GetRow($sql);
                
                if(count($empleado)==0){
                    $sql = "SELECT * FROM personalUniversidadPeopleSoft WHERE idEmpleadoPeopleSoft='".$fields['idEmpleadoPeopleSoft']."'"; 
                    $empleado = $db->GetRow($sql);
                    $fields['codigoestado']=200;
                    //asegurarme que no hay un num de contrato mas alto
                    if(count($empleado)==0){
                        $id=$utils->processData("save",$_REQUEST["entity"],$fields,false,false,"");
                    } else {
                        //solo me toca inactivarlo
                        $fields = array();
                        $fields['idpersonalUniversidadPeopleSoft']=$empleado["idpersonalUniversidadPeopleSoft"];
                        $fields['codigoestado']=200;
                        $id=$utils->processData("update",$_REQUEST["entity"],$fields,false,false,"");
                    }
                } else {
                    $fields['idpersonalUniversidadPeopleSoft']=$empleado["idpersonalUniversidadPeopleSoft"];
                    $fields['codigoestado']=200;
                    $id=$utils->processData("update",$_REQUEST["entity"],$fields,false,false,"");
                }
            }
            $i++;
    } 
    
    //actualizar los formularios de info huerfana para el periodo actual 
    $currentdate  = date("Y-m-d H:i:s");
    $sql = "SELECT codigoperiodo FROM periodo WHERE '".$currentdate."' between fechainicioperiodo and fechavencimientoperiodo"; 
    $periodoActualizar = $db->GetRow($sql);
    //$sql = "SELECT codigoperiodo FROM docentePeopleSoft GROUP BY codigoperiodo"; 
    //$periodosActualizar = $db->GetAll($sql);
    updateNumeroPersonas($db,$periodoActualizar,$utils);
    
    //actualizar Escalafones
    updateDocentesEscalafon($db,$utils);
    
    $sql = "SELECT * FROM siq_formTalentoHumanoAcademicosDesvinculados WHERE codigoperiodo='".$periodoActualizar['codigoperiodo']."' AND codigoestado='100'"; 
    $fields = $db->GetRow($sql);    
    $num = count($fields);
    //hacer las consultas para sacar el total de esto
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion IN ('FCA','FCT','INR','INT') AND codigoestado='200' ";
    $resultado = $db->GetRow($sql);    
        $fields["numTerminacionContrato"] = $resultado["total"];
     
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion='REN' AND codigoestado='200' ";
    $resultado = $db->GetRow($sql);
        
        $fields["numRenunciaOportunidad"] = $resultado["total"];
        
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion='PER' AND codigoestado='200' ";
    $resultado = $db->GetRow($sql);
    //academicos adjuntos
        $fields["numRenunciaMotivosPersonales"] = $resultado["total"];
      
        // no hay forma de saber
    //$sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion='Académico' AND codigoestado='200'";
    //$resultado = $db->GetRow($sql);   
    //cuerpo profesoral
        $fields["numRenunciaCondicionesLaborales"] = "0";
    
        //no hay forma de saber
    //$sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion='Académico' AND codigoestado='200'";
    //$resultado = $db->GetRow($sql);   
        $fields["numRenunciaViaje"] = "0";
    
    $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion IN ('TUJ','TSJ') AND codigoestado='200' ";
    $resultado = $db->GetRow($sql);    
        $fields["numDespido"] = $resultado["total"];
        
   $sql = "SELECT COUNT(*) as total FROM personalUniversidadPeopleSoft WHERE motivoDesvinculacion NOT IN ('FCA','FCT','TUJ','TSJ','PER','REN','INR','INT') AND codigoestado='200' ";
    $resultado = $db->GetRow($sql);    
        $fields["numOtro"] = $resultado["total"];
        
    if($num==0){
        $fields["codigoperiodo"] = $periodoActualizar['codigoperiodo'];
        $id=$utils->processData("save","formTalentoHumanoAcademicosDesvinculados",$fields,false);
    } else {
        $id=$utils->processData("update","formTalentoHumanoAcademicosDesvinculados",$fields,false);
    }
    
            $location = "./docentesDesvinculados.php";
 } else  if((strcmp($_REQUEST["entity"],"prestacionServiciosPeopleSoft")==0)){
     $_REQUEST["entity"] = "personalPrestacionServiciosPeopleSoft";
     $_POST["entity"] = "personalPrestacionServiciosPeopleSoft";
	
 $i=0;
 //lee las lineas del archivo
 $sql = "UPDATE personalPrestacionServiciosPeopleSoft SET codigoestado=200";
 $db->Execute($sql);
   while ($data = fgetcsv ($handle, 1000, ";")){ 
       $fields = array();
        //se vuela las primeras lineas porque son textos
       //var_dump($data);echo "<br/><br/>";
       //si el empleado esta activo y no es de colegio
            if ($i>1){
                $fields['nombreProveedor']=mysql_real_escape_string(utf8_encode($data[6]));
                
                $fields['tipoDocumento']=$data[4];
                $fields['numeroDocumento']=$data[5];
                $fields['acuerdoCompra']=$data[2];
                $fields['idProveedor']=$data[3];
                $fields['valorBruto']=intval($data[7]);
                $fields['centroCosto']=$data[12];
                $fields['numeroProyecto']=$data[13];
                $fields['comentarios']=mysql_real_escape_string(utf8_encode($data[10]));
                
                //llega en formato dia/mes/año
                $pieces = explode("/", $data[8]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];
                $fields['fechaInicio']=$fechaC;                
                
                $pieces = explode("/", $data[9]);
                $fechaC = $pieces[2]."-".$pieces[1]."-".$pieces[0];
                $fields['fechaVencimiento']=$fechaC;
                               
                $fecha = strtotime($fields['fechaInicio']);
                $fecha = date('Y-m-d', $fecha);
                
                $sql = "SELECT codigoperiodo FROM periodo WHERE '".$fecha."' between fechainicioperiodo and fechavencimientoperiodo"; 
                $periodo = $db->GetRow($sql);
                //toca calcularlo con la fecha de inicio
                $fields['codigoperiodo']=$periodo['codigoperiodo'];
                
                $sql = "SELECT * FROM personalPrestacionServiciosPeopleSoft WHERE acuerdoCompra='".$fields['acuerdoCompra']."'"; 
                $empleado = $db->GetRow($sql);
                
                if(count($empleado)==0){
                   $id=$utils->processData("save",$_REQUEST["entity"],$fields,false,false,"");
                } else {
                    $fields['idpersonalPrestacionServiciosPeopleSoft']=$empleado["idpersonalPrestacionServiciosPeopleSoft"];
                    $fields['codigoestado']=100;
                    $id=$utils->processData("update",$_REQUEST["entity"],$fields,false,false,"");
                }
            }
            $i++;
    } 
    
    //actualizar los formularios de info huerfana para el periodo actual 
    $currentdate  = date("Y-m-d H:i:s");
    $sql = "SELECT codigoperiodo FROM periodo WHERE '".$currentdate."' between fechainicioperiodo and fechavencimientoperiodo"; 
    $periodoActualizar = $db->GetRow($sql);
    //$sql = "SELECT codigoperiodo FROM docentePeopleSoft GROUP BY codigoperiodo"; 
    
	
    //curso básico 
    updatePrestacionServicios($db,$utils,1,16,$periodoActualizar);
	
    //pregrado
    updatePrestacionServicios($db,$utils,2,2,$periodoActualizar);
	
    //especializacion
    updatePrestacionServicios($db,$utils,3,3,$periodoActualizar);
	
    //maestria
    updatePrestacionServicios($db,$utils,4,4,$periodoActualizar);
	
    //doctorado
    updatePrestacionServicios($db,$utils,5,5,$periodoActualizar);
	
    //EC
    updatePrestacionServicios($db,$utils,6,7,$periodoActualizar);
	
    //orquesta
    updatePrestacionServicios($db,$utils,7,12,$periodoActualizar);
	
    //investigacion
    updatePrestacionServicios($db,$utils,8,10,$periodoActualizar);
	
    //administrativas
    updatePrestacionServicios($db,$utils,9,1,$periodoActualizar);
	
    //Centro de Lenguas
    updatePrestacionServicios($db,$utils,13,13,$periodoActualizar);
	
    //programas especiales
    updatePrestacionServicios($db,$utils,14,6,$periodoActualizar);
	
    //laboratorios
    updatePrestacionServicios($db,$utils,15,11,$periodoActualizar);
    
            $location = "./prestacionServicios.php";
 } //die();
    
    ///Envia el mensaje
    if (!empty($id)){
        $result='Se importó la información de forma correcta';
    }else{
        $result='Ocurrió un error al momento de importar la información';
    }
    ?>
    <script>
        alert("<?php echo $result ?>");
        window.location.href="<?php echo $location; ?>";
        
    </script>
    <?
?>