<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

//    ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);

$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
require_once(realpath(dirname(__FILE__)).'/funciones.php');
//$codigocarrera = $_SESSION['codigofacultad'];
$fechahoy=date("Y-m-d H:i:s");
$varguardar = 0;
if (!isset ($_SESSION['sesion_materias'])){
    if($HTTP_SERVER_VARS['HTTP_REFERER'] != '')
        $_SERVER['HTTP_REFERER'] = $HTTP_SERVER_VARS['HTTP_REFERER'];
    $_SESSION['sesion_materias'] = $_SERVER['HTTP_REFERER'];
}

$SQL="select rol.* from usuariorol rol 
inner join UsuarioTipo ut on ut.UsuarioTipoId = rol.idusuariotipo
inner join usuario u on u.idusuario = ut.UsuarioId
WHERE u.usuario = '".$_SESSION['usuario']."' AND rol.idrol=13";

if($Acceso=&$db->Execute($SQL)===false){
    echo 'Error en el Sistema....';
    die;
}

?>
<script language="javascript">
    function cambio(){
        document.form1.submit();
    }
</script>

<?php

  if (isset($_POST['grabar'])) {
    $suma_porcentaje=($_POST['porcentajeteoricamateria']+$_POST['porcentajepracticamateria']);

    if ($_POST['codigomodalidadmateria'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Modalidad de la Materia")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['codigolineaacademica'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Linea Académica ")</script>';
                $varguardar = 1;
                }
       elseif ($_POST['codigoindicadorgrupomateria'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador Grupo Materia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigotipomateria'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de Materia")</script>';
                $varguardar = 1;
                }
	elseif ($_POST['tiporotacion'] == "") {
            echo '<script language="JavaScript">alert("Debe Indicar El Tipo de Rotación de la materia")</script>';
                $varguardar = 1;
                }

        elseif ($_POST['codigoindicadoretiquetamateria'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Indicador Etiqueta Materia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigotipocalificacionmateria'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo Calificación Materia")</script>';
                $varguardar = 1;
              }
        elseif ($_POST['codigoindicarcredito'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar Indicar Crédito")</script>';
                $varguardar = 1;
              }
        elseif ($_POST['codigoindicarcredito']==100 && $_POST['numerocreditos'] == "" || $_POST['numerocreditos'] < 0){
            echo '<script language="JavaScript">alert("Debe Digitar Número de Créditos y el Número debe ser Mayor a Cero")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigoindicarcredito']==100 && !is_numeric($_POST['numerocreditos'])){
            echo '<script language="JavaScript">alert("Debe Digitar Número de Créditos y el Dato debe ser Numérico")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigoindicarcredito']==200 && $_POST['ulasa'] == "" || $_POST['ulasa'] < 0) {
            echo '<script language="JavaScript">alert("Debe Digitar ULASA")</script>';
                $varguardar = 1;
                }

        elseif ($_POST['codigoindicarcredito']==200 && !is_numeric($_POST['ulasa'])) {
            echo '<script language="JavaScript">alert("Debe Digitar ULASA y el dato debe ser Numérico")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigoindicarcredito']==200 && $_POST['ulasb'] == "" || $_POST['ulasb'] < 0) {
            echo '<script language="JavaScript">alert("Debe Digitar ULASB")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigoindicarcredito']==200 && !is_numeric($_POST['ulasb'])) {
            echo '<script language="JavaScript">alert("Debe Digitar ULASB y el dato debe ser Numérico")</script>';
                $varguardar = 1;
                }

        elseif ($_POST['codigoindicarcredito']==200 && $_POST['ulasc'] == "" || $_POST['ulasc'] < 0) {
            echo '<script language="JavaScript">alert("Debe Digitar ULASC")</script>';
                $varguardar = 1;
                }

        elseif ($_POST['codigoindicarcredito']==200 && !is_numeric($_POST['ulasc'])) {
            echo '<script language="JavaScript">alert("Debe Digitar ULASC y el dato debe ser Numérico")</script>';
                $varguardar = 1;
                }

        elseif ($_POST['nombrecortomateria'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar Nombre Corto de la Materia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['nombremateria'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre de la Materia")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['codigoperiodo'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Periodo")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['notaminimaaprobatoria'] == "" || $_POST['notaminimaaprobatoria'] > 5.0 || $_POST['notaminimaaprobatoria'] < 0 || !is_numeric($_POST['notaminimaaprobatoria'])) {
            echo '<script language="JavaScript">alert("Debe Digitar la Nota Mínima Aprobatoria, no debe Ser Mayor a 5.0 y debe ser un Dato Numérico")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['notaminimahabilitacion'] == "" || $_POST['notaminimahabilitacion'] > 5.0 || $_POST['notaminimahabilitacion'] < 0 || !is_numeric($_POST['notaminimahabilitacion'])) {
            echo '<script language="JavaScript">alert("Debe Digitar la Nota Mínima Habilitación, no debe Ser Mayor a 5.0 y el Dato debe ser Numérico")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['numerosemana'] == "" || $_POST['numerosemana'] < 0 || !is_numeric($_POST['numerosemana'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Número de Semanas y el Dato debe ser Numérico")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['numerohorassemanales'] == "" || $_POST['numerohorassemanales'] < 0 || !is_numeric($_POST['numerohorassemanales'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Número de Horas Semanales y el dato debe ser Numérico")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['sesionesmateria'] == "" || $_POST['sesionesmateria'] < 0 || !is_numeric($_POST['sesionesmateria'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Número de Sesiones y el Dato debe ser Numérico")</script>';
              $varguardar = 1;
              }      
        elseif ($_POST['porcentajeteoricamateria'] == "" || !is_numeric($_POST['porcentajeteoricamateria'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Porcentaje Teórico y el Dato debe ser Numérico")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['porcentajepracticamateria'] == "" || !is_numeric($_POST['porcentajepracticamateria'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Porcentaje de Práctica y el Dato debe ser Numérico")</script>';
              $varguardar = 1;
              }

        elseif ($suma_porcentaje != 100){
            echo '<script language="JavaScript">alert("La Suma de los Valores de Porcentaje Teórico y Porcentaje Práctica no debe ser diferente a el 100%")</script>';
              $varguardar = 1;
              }

        elseif ($_POST['porcentajefallasteoriamodalidadmateria'] == "" || $_POST['porcentajefallasteoriamodalidadmateria'] > 100 || $_POST['porcentajefallasteoriamodalidadmateria'] < 0 || !is_numeric($_POST['porcentajefallasteoriamodalidadmateria'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Porcentaje de Fallas Teoría, el valor no debe ser Mayor al 100% y el Dato debe ser Numérico")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['porcentajefallaspracticamodalidadmateria'] == ""|| $_POST['porcentajefallaspracticamodalidadmateria'] > 100 || $_POST['porcentajefallaspracticamodalidadmateria'] < 0 || !is_numeric($_POST['porcentajefallaspracticamodalidadmateria'])) {
            echo '<script language="JavaScript">alert("Debe Digitar el Porcentaje de Fallas Práctica,  el valor no debe ser Mayor al 100% y debe ser un dato Numérico")</script>';
              $varguardar = 1;
              }

        elseif ($varguardar == 0) {
            //echo $_REQUEST['codigomateria'];
            
                if (isset($_REQUEST['codigomateria'])){
                   $CarreraUpdate = "";
                   
                    if ($_POST['codigoindicarcredito']==100){
                        
                   if($_POST['programaAcademico']){
                        $CarreraUpdate = ",codigocarrera='".$_POST['programaAcademico']."', codigoestadomateria='".$_POST['EstadoMateria']."'";//EstadoMateria
						$_REQUEST["codigocarrera"]=$_POST['programaAcademico'];
						$_GET["codigocarrera"]=$_POST['programaAcademico'];
                   }     
                        
           $query_actualizar = "UPDATE materia SET 
           nombrecortomateria='".$_POST['nombrecortomateria']."',
           nombremateria='".$_POST['nombremateria']."',
           numerocreditos='".$_POST['numerocreditos']."',
           codigoperiodo='".$_POST['codigoperiodo']."',
           notaminimaaprobatoria='".$_POST['notaminimaaprobatoria']."', 
           notaminimahabilitacion='".$_POST['notaminimahabilitacion']."', 
           numerosemana='".$_POST['numerosemana']."',
           numerohorassemanales='".$_POST['numerohorassemanales']."',
           sesionesmateria='".$_POST['sesionesmateria']."',            
           porcentajeteoricamateria='".$_POST['porcentajeteoricamateria']."', 
           porcentajepracticamateria='".$_POST['porcentajepracticamateria']."', 
           porcentajefallasteoriamodalidadmateria='".$_POST['porcentajefallasteoriamodalidadmateria']."', 
           porcentajefallaspracticamodalidadmateria='".$_POST['porcentajefallaspracticamodalidadmateria']."',
           codigomodalidadmateria='".$_POST['codigomodalidadmateria']."', 
           codigolineaacademica='".$_POST['codigolineaacademica']."',
           codigoindicadorgrupomateria='".$_POST['codigoindicadorgrupomateria']."', 
           codigotipomateria='".$_POST['codigotipomateria']."', 
           TipoRotacionId='".$_POST['tiporotacion']."',
           ulasa=0, 
           ulasb=0, 
           ulasc=0,
           codigoindicadorcredito='".$_POST['codigoindicarcredito']."', 
           codigoindicadoretiquetamateria='".$_POST['codigoindicadoretiquetamateria']."',  
           codigotipocalificacionmateria='".$_POST['codigotipocalificacionmateria']."'
           $CarreraUpdate 
           where codigomateria = '{$_REQUEST['codigomateria']}'";
           
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            
            $query_cambiarnumerocreditos= "update detalleplanestudio set numerocreditosdetalleplanestudio='".$_POST['numerocreditos']."'
            where codigomateria = '{$_REQUEST['codigomateria']}'";
            $cambiarnumerocreditos=$db->Execute ($query_cambiarnumerocreditos) or die("$query_cambiarnumerocreditos".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
            
            
            
                }
              else if ($_POST['codigoindicarcredito']==200){
                
                 if($_POST['programaAcademico']){
                        $CarreraUpdate = ",codigocarrera='".$_POST['programaAcademico']."', codigoestadomateria='".$_POST['EstadoMateria']."'";
						$_REQUEST["codigocarrera"]=$_POST['programaAcademico'];
						$_GET["codigocarrera"]=$_POST['programaAcademico'];
                   }   
                
           $query_actualizar = "UPDATE materia SET  
           nombrecortomateria='".$_POST['nombrecortomateria']."',
           nombremateria='".$_POST['nombremateria']."',
           numerocreditos = 0,
           codigoperiodo='".$_POST['codigoperiodo']."', 
           notaminimaaprobatoria='".$_POST['notaminimaaprobatoria']."', 
           notaminimahabilitacion='".$_POST['notaminimahabilitacion']."', 
           numerosemana='".$_POST['numerosemana']."',
           numerohorassemanales='".$_POST['numerohorassemanales']."',
           sesionesmateria='".$_POST['sesionesmateria']."',           
           porcentajeteoricamateria='".$_POST['porcentajeteoricamateria']."',
           porcentajepracticamateria='".$_POST['porcentajepracticamateria']."', 
           porcentajefallasteoriamodalidadmateria='".$_POST['porcentajefallasteoriamodalidadmateria']."', 
           porcentajefallaspracticamodalidadmateria='".$_POST['porcentajefallaspracticamodalidadmateria']."',
           codigomodalidadmateria='".$_POST['codigomodalidadmateria']."', 
           codigolineaacademica='".$_POST['codigolineaacademica']."',
           codigoindicadorgrupomateria='".$_POST['codigoindicadorgrupomateria']."', 
           codigotipomateria='".$_POST['codigotipomateria']."',
           TipoRotacionId='".$_POST['tiporotacion']."',
           ulasa='".$_POST['ulasa']."', 
           ulasb='".$_POST['ulasb']."', 
           ulasc='".$_POST['ulasc']."',
           codigoindicadorcredito='".$_POST['codigoindicarcredito']."', 
           codigoindicadoretiquetamateria='".$_POST['codigoindicadoretiquetamateria']."',  
           codigotipocalificacionmateria='".$_POST['codigotipocalificacionmateria']."'
           $CarreraUpdate
           where codigomateria = '{$_REQUEST['codigomateria']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
            
            
                }

            }
            else {
                    if ($_POST['codigoindicarcredito']==100){
            $query_guardar = "INSERT INTO materia (codigomateria, nombrecortomateria, nombremateria, numerocreditos, codigoperiodo, notaminimaaprobatoria, notaminimahabilitacion, numerosemana, numerohorassemanales, porcentajeteoricamateria, porcentajepracticamateria, porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria, codigomodalidadmateria, codigolineaacademica, codigocarrera, codigoindicadorgrupomateria, codigotipomateria, codigoestadomateria, ulasa, ulasb, ulasc, codigoindicadorcredito, codigoindicadoretiquetamateria, codigotipocalificacionmateria, sesionesmateria, TipoRotacionId) values (0, '{$_POST['nombrecortomateria']}','{$_POST['nombremateria']}','{$_POST['numerocreditos']}','{$_POST['codigoperiodo']}','{$_POST['notaminimaaprobatoria']}','{$_POST['notaminimahabilitacion']}','{$_POST['numerosemana']}','{$_POST['numerohorassemanales']}','{$_POST['porcentajeteoricamateria']}','{$_POST['porcentajepracticamateria']}','{$_POST['porcentajefallasteoriamodalidadmateria']}','{$_POST['porcentajefallaspracticamodalidadmateria']}','{$_POST['codigomodalidadmateria']}','{$_POST['codigolineaacademica']}','{$_REQUEST['codigocarrera']}','{$_POST['codigoindicadorgrupomateria']}','{$_POST['codigotipomateria']}','01',0,0,0,'{$_POST['codigoindicarcredito']}','{$_POST['codigoindicadoretiquetamateria']}','{$_POST['codigotipocalificacionmateria']}','{$_POST['sesionesmateria']}','{$_POST['tiporotacion']}')";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['codigomateria'] = $db->Insert_ID();
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
                    }
                    else if ($_POST['codigoindicarcredito']==200){
            $query_guardar = "INSERT INTO materia (codigomateria, nombrecortomateria, nombremateria, numerocreditos, codigoperiodo, notaminimaaprobatoria, notaminimahabilitacion, numerosemana, numerohorassemanales, porcentajeteoricamateria, porcentajepracticamateria, porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria, codigomodalidadmateria, codigolineaacademica, codigocarrera, codigoindicadorgrupomateria, codigotipomateria, codigoestadomateria, ulasa, ulasb, ulasc, codigoindicadorcredito, codigoindicadoretiquetamateria, codigotipocalificacionmateria, sesionesmateria, TipoRotacionId) values (0, '{$_POST['nombrecortomateria']}','{$_POST['nombremateria']}',0,'{$_POST['codigoperiodo']}','{$_POST['notaminimaaprobatoria']}','{$_POST['notaminimahabilitacion']}','{$_POST['numerosemana']}','{$_POST['numerohorassemanales']}','{$_POST['porcentajeteoricamateria']}','{$_POST['porcentajepracticamateria']}','{$_POST['porcentajefallasteoriamodalidadmateria']}','{$_POST['porcentajefallaspracticamodalidadmateria']}','{$_POST['codigomodalidadmateria']}','{$_POST['codigolineaacademica']}','{$_POST['codigocarrera']}','{$_POST['codigoindicadorgrupomateria']}','{$_POST['codigotipomateria']}','01','{$_POST['ulasa']}','{$_POST['ulasb']}','{$_POST['ulasc']}','{$_POST['codigoindicarcredito']}','{$_POST['codigoindicadoretiquetamateria']}','{$_POST['codigotipocalificacionmateria']}','{$_POST['sesionesmateria']}','{$_POST['tiporotacion']}')";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['codigomateria'] = $db->Insert_ID();

            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
                     }
                }
         }
  }

$Condicion = "";

if($Acceso->EOF){
    $Condicion = " and m.codigoestadomateria = '01'";
}

$query_datos ="SELECT m.codigomateria, m.nombrecortomateria, m.nombremateria, m.numerocreditos, m.codigoperiodo, m.notaminimaaprobatoria, m.notaminimahabilitacion, m.numerosemana, m.numerohorassemanales, m.porcentajeteoricamateria, m.porcentajepracticamateria, m.porcentajefallasteoriamodalidadmateria, m.porcentajefallaspracticamodalidadmateria, m.codigomodalidadmateria, m.codigolineaacademica, m.codigocarrera, m.codigoindicadorgrupomateria, m.codigotipomateria, m.codigoestadomateria, m.ulasa, m.ulasb, m.ulasc, m.codigoindicadorcredito, m.codigoindicadoretiquetamateria, m.codigotipocalificacionmateria, m.sesionesmateria,m.TipoRotacionId FROM  materia m
    where m.codigomateria = '".$_REQUEST['codigomateria']."' ".$Condicion;
    

$datos= $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();

$row_datos = $datos->FetchRow();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Modificar Materia</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript">
function cambiar()
{
    document.form1.submit();
}

$( document ).ready(function() {
	$(document).on('change', '#modalidadAcademica', function() {
		var carrera = "<?php echo $_REQUEST['codigocarrera']; ?>"
		var modalidad = $( "#modalidadAcademica" ).val();
		$.ajax({
			dataType: 'html',
			type: 'POST',
			async: false,
				url: 'funciones.php',  
			data: {carrera: carrera,modalidad:modalidad},                
			success:function(data){	   
				$("#programaAcademico").html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		   }); 
	});
});
</script>
</head>
    <body>
<form name="form1" id="form1"  method="POST">
    <INPUT type="hidden" name="codigocarrera" value="<?php echo $_REQUEST['codigocarrera'];?>">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">MANTENIMIENTO DE MATERIAS</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['codigomateria'])){

                echo $row_datos['nombremateria'];
                 }
             ?>
            </label></TD>
         </TR>
    </table>


            <TABLE width="750px"  border="1" align="center">
                <?php if (isset($_REQUEST['codigomateria'])){ ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Código Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        $row_datos['codigomateria']==$_POST['codigomateria'];?>
                        <INPUT type="text" name="codigomateria" id="codigomateria" readonly="true"  value="<?php echo $row_datos['codigomateria']; ?>">
                        </div>
                    </td>
                </tr>
                <?php }
                ?>
          <?php
          $query_codigomodalidadmateria ="SELECT m.codigomodalidadmateria, m.nombremodalidadmateria FROM modalidadmateria m ";
                $codigomodalidadmateria= $db->Execute($query_codigomodalidadmateria);
                $totalRows_codigomodalidadmateria = $codigomodalidadmateria->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Modalidad Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigomodalidadmateria" id="codigomodalidadmateria">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigomodalidadmateria = $codigomodalidadmateria->FetchRow()){?>
                            <option value="<?php echo $row_codigomodalidadmateria['codigomodalidadmateria'];?>"
                                <?php
                                 if($row_codigomodalidadmateria['codigomodalidadmateria']==$_POST['codigomodalidadmateria']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigomodalidadmateria']==$row_codigomodalidadmateria['codigomodalidadmateria'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigomodalidadmateria['nombremodalidadmateria'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

                <?php
          $query_codigolineaacademica="SELECT l.codigolineaacademica, l.nombrelineaacademica FROM lineaacademica l";
                $codigolineaacademica= $db->Execute($query_codigolineaacademica);
                $totalRows_codigolineaacademica = $codigolineaacademica->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Linea Académica<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigolineaacademica" id="codigolineaacademica">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigolineaacademica = $codigolineaacademica->FetchRow()){?>
                            <option value="<?php echo $row_codigolineaacademica['codigolineaacademica'];?>"
                                <?php
                                 if($row_codigolineaacademica['codigolineaacademica']==$_POST['codigolineaacademica']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigolineaacademica']==$row_codigolineaacademica['codigolineaacademica'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigolineaacademica['nombrelineaacademica'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

          <?php
          $query_codigoindicadorgrupomateria="SELECT i.codigoindicadorgrupomateria, i.nombreindicadorgrupomateria FROM indicadorgrupomateria i ";
                $codigoindicadorgrupomateria= $db->Execute($query_codigoindicadorgrupomateria);
                $totalRows_codigoindicadorgrupomateria = $codigoindicadorgrupomateria->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador Grupo Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigoindicadorgrupomateria" id="codigoindicadorgrupomateria">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigoindicadorgrupomateria = $codigoindicadorgrupomateria->FetchRow()){?>
                            <option value="<?php echo $row_codigoindicadorgrupomateria['codigoindicadorgrupomateria'];?>"
                                <?php
                                 if($row_codigoindicadorgrupomateria['codigoindicadorgrupomateria']==$_POST['codigoindicadorgrupomateria']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigoindicadorgrupomateria']==$row_codigoindicadorgrupomateria['codigoindicadorgrupomateria'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigoindicadorgrupomateria['nombreindicadorgrupomateria'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
         <?php
          $query_codigotipomateria="SELECT codigotipomateria, nombretipomateria FROM tipomateria";
                $codigotipomateria= $db->Execute($query_codigotipomateria);
                $totalRows_codigotipomateria = $codigotipomateria->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Tipo de Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigotipomateria" id="codigotipomateria">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigotipomateria = $codigotipomateria->FetchRow()){?>
                            <option value="<?php echo $row_codigotipomateria['codigotipomateria'];?>"
                                <?php
                                 if($row_codigotipomateria['codigotipomateria']==$_POST['codigotipomateria']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigotipomateria']==$row_codigotipomateria['codigotipomateria'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigotipomateria['nombretipomateria'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

		<tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Tipo de Rotación Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
            			<select name="tiporotacion" id="tiporotacion">
            			<option value="">Seleccionar</option>
                        <?php
                            $sqlrotaciones = "select TipoRotacionId, NombreTipoRotacion from TipoRotaciones where codigoestado = '100'";
                            $valoresRotaciones = $db->execute($sqlrotaciones);
							
                            foreach($valoresRotaciones as $datosrotacion){ ?>
								<option value="<?php echo $datosrotacion['TipoRotacionId']?>" 
								<?php if($row_datos['TipoRotacionId']==$datosrotacion['TipoRotacionId']){ ?>selected="selected"<?php } ?>>
								<?php echo $datosrotacion['NombreTipoRotacion']?></option>
								<?php 
                            }
                        ?>
                        </div>
                    </td>
                </tr>


        <?php
          $query_codigoindicadoretiquetamateria="SELECT codigoindicadoretiquetamateria, nombreindicadoretiquetamateria FROM indicadoretiquetamateria";
                $codigoindicadoretiquetamateria= $db->Execute($query_codigoindicadoretiquetamateria);
                $totalRows_codigoindicadoretiquetamateria = $codigoindicadoretiquetamateria->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicador Etiqueta Materia <label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigoindicadoretiquetamateria" id="codigoindicadoretiquetamateria">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigoindicadoretiquetamateria = $codigoindicadoretiquetamateria->FetchRow()){?>
                            <option value="<?php echo $row_codigoindicadoretiquetamateria['codigoindicadoretiquetamateria'];?>"
                                <?php
                                 if($row_codigoindicadoretiquetamateria['codigoindicadoretiquetamateria']==$_POST['codigoindicadoretiquetamateria']) {
                                echo "Selected";
                                 }
                               else if($row_datos['codigoindicadoretiquetamateria']==$row_codigoindicadoretiquetamateria['codigoindicadoretiquetamateria'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigoindicadoretiquetamateria['nombreindicadoretiquetamateria'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
         <?php
          $query_codigotipocalificacionmateria="SELECT codigotipocalificacionmateria, nombretipocalificacionmateria FROM tipocalificacionmateria";
                $codigotipocalificacionmateria= $db->Execute($query_codigotipocalificacionmateria);
                $totalRows_codigotipocalificacionmateria = $codigotipocalificacionmateria->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Tipo Calificación &nbsp; Materia <label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigotipocalificacionmateria" id="codigotipocalificacionmateria">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigotipocalificacionmateria = $codigotipocalificacionmateria->FetchRow()){?>
                            <option value="<?php echo $row_codigotipocalificacionmateria['codigotipocalificacionmateria'];?>"
                                <?php
                                 if($row_codigotipocalificacionmateria['codigotipocalificacionmateria']==$_POST['codigotipocalificacionmateria']) {
                                echo "Selected";
                                 }
                               else if($row_datos['codigotipocalificacionmateria']==$row_codigotipocalificacionmateria['codigotipocalificacionmateria'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigotipocalificacionmateria['nombretipocalificacionmateria'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

            <?php
        $query_codigoindicarcredito="SELECT codigoindicarcredito, nombreindicarcredito FROM indicarcredito";
        $codigoindicarcredito1= $db->GetAll($query_codigoindicarcredito);
        ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Indicar Crédito<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigoindicarcredito" id="codigoindicarcredito" onchange="cambio()">
                                <option value="">Seleccionar</option>
                                <?php
                                foreach($codigoindicarcredito1 as $indicadores){
                                    ?>
                                  <option value="<?php echo $indicadores['codigoindicarcredito'];?>"
                                  <?php
                                  if(isset($_POST['codigoindicarcredito'])){
                                      if($indicadores['codigoindicarcredito'] == $_POST['codigoindicarcredito'])
                                      {
                                          echo 'selected';
                                      }
                                  }
                                  else{
                                      if($indicadores['codigoindicarcredito'] == $row_datos['codigoindicadorcredito'])
                                      {
                                          echo 'selected';
                                      }
                                  }
                                  ?>
                                  >
                                      <?php echo $indicadores['nombreindicarcredito'];?>
                                  </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>

                <?php
                if ((is_null($_POST['codigoindicarcredito']) && $row_datos['codigoindicadorcredito']==100) || $_POST['codigoindicarcredito'] == 100){
                    ?>
                    <script type="text/javascript">
                        function utilizaconfirm(){
                            var r=confirm("Si se modifica el número de créditos de la materia también se modificaran los créditos de la misma materia en todos los planes de estudio donde se encuentre. ¿Esta seguro de realizar esta acción?");
                            if (r==false){
                                document.getElementById("numerocreditos").value=<?php echo $row_datos['numerocreditos'];?>
                            }
                        }
                    </script>

                    <tr align="left" >
                        <td width="30%" id="tdtitulogris">
                            <div align="left">Número de Créditos<label id="labelasterisco">*</label></div>
                        </td>
                        <td id="tdtitulogris">
                            <div align="justify">
                            <?php
                                if (isset($_REQUEST['codigomateria'])){
                                    $row_datos['numerocreditos']==$_POST['numerocreditos'];?>
                                    <INPUT type="text" name="numerocreditos" id="numerocreditos"  value="<?php echo $row_datos['numerocreditos']; ?>" onchange="utilizaconfirm()">
                                <?php
                                }else {
                                    ?>
                                    <INPUT type="text" name="numerocreditos" id="numerocreditos"  value="<?php if ($_POST['numerocreditos']!=""){
                                    echo $_POST['numerocreditos']; } ?>">
                                    <?php
                                }//else ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }//if  codigoindicarcredito 100
                elseif ((is_null($_POST['codigoindicarcredito']) && $row_datos['codigoindicadorcredito']==200 || $_POST['codigoindicarcredito']==200)){
                    ?>
                    <tr align="left" >
                        <td width="30%" id="tdtitulogris"><div align="left">ULASA<label  id="labelasterisco">*</label></div>
                        </td>
                        <td id="tdtitulogris">
                            <div align="justify">
                            <?php

                                if (isset($_REQUEST['codigomateria'])){
                                    $row_datos['ulasa']==$_POST['ulasa'];?>
                                    <INPUT type="text" name="ulasa" id="ulasa"  value="<?php echo $row_datos['ulasa']; ?>">
                                    <?php
                                }else {
                                    ?>
                                    <INPUT type="text" name="ulasa" id="ulasa"  value="<?php if ($_POST['ulasa']!=""){
                                    echo $_POST['ulasa']; } ?>">
                                    <?php
                                }//else
                            ?>
                            </div>
                        </td>
                    </tr>
                    <tr align="left" >
                        <td width="30%" id="tdtitulogris"><div align="left">ULASB<label  id="labelasterisco">*</label></div>
                        </td>
                        <td id="tdtitulogris">
                            <div align="justify">
                            <?php
                                if (isset($_REQUEST['codigomateria'])){
                                    $row_datos['ulasb']==$_POST['ulasb'];?>
                                    <INPUT type="text" name="ulasb" id="ulasb"  value="<?php echo $row_datos['ulasb']; ?>">
                                    <?php
                                }else {
                                    ?>
                                    <INPUT type="text" name="ulasb" id="ulasb"  value="<?php if ($_POST['ulasb']!=""){
                                    echo $_POST['ulasb']; } ?>">
                                 <?php
                                }?>
                            </div>
                        </td>
                    </tr>
                    <tr align="left" >
                        <td width="30%" id="tdtitulogris"><div align="left">ULASC<label  id="labelasterisco">*</label></div>
                        </td>
                        <td id="tdtitulogris">
                            <div align="justify">
                            <?php
                            if (isset($_REQUEST['codigomateria'])){
                            $row_datos['ulasc']==$_POST['ulasc'];?>
                            <INPUT type="text" name="ulasc" id="ulasc"  value="<?php echo $row_datos['ulasc']; ?>">
                            <?php
                             }
                             else {?>
                            <INPUT type="text" name="ulasc" id="ulasc"  value="<?php if ($_POST['ulasc']!=""){
                            echo $_POST['ulasc']; } ?>">
                             <?php }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }// codigoindicarcredito 200 ?>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nombre Corto Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['nombrecortomateria']==$_POST['nombrecortomateria'];?>
                        <INPUT type="text" name="nombrecortomateria" id="nombrecortomateria"  value="<?php echo $row_datos['nombrecortomateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombrecortomateria" id="nombrecortomateria"  value="<?php if ($_POST['nombrecortomateria']!=""){
                        echo $_POST['nombrecortomateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nombre Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['nombremateria']==$_POST['nombremateria'];?>
                        <INPUT type="text" name="nombremateria" id="nombremateria"  value="<?php echo $row_datos['nombremateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombremateria" id="nombremateria"  value="<?php if ($_POST['nombremateria']!=""){
                        echo $_POST['nombremateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
         <?php
          $query_codigoperiodo="select p.codigoperiodo from periodo p order by p.codigoperiodo desc";
                $codigoperiodo= $db->Execute($query_codigoperiodo);
                $totalRows_codigoperiodo = $codigoperiodo->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Periodo<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigoperiodo" id="codigoperiodo" >
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigoperiodo = $codigoperiodo->FetchRow()){?>
                            <option value="<?php echo $row_codigoperiodo['codigoperiodo'];?>"
                                <?php
                                 if($row_codigoperiodo['codigoperiodo']==$_POST['codigoperiodo']) {
                                echo "Selected";
                                 }
                               else if($row_datos['codigoperiodo']==$row_codigoperiodo['codigoperiodo'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigoperiodo['codigoperiodo'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nota Mínima Aprobatoria<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['notaminimaaprobatoria']==$_POST['notaminimaaprobatoria'];?>
                        <INPUT type="text" name="notaminimaaprobatoria" id="notaminimaaprobatoria"  value="<?php echo $row_datos['notaminimaaprobatoria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="notaminimaaprobatoria" id="notaminimaaprobatoria"  value="<?php if ($_POST['notaminimaaprobatoria']!=""){
                        echo $_POST['notaminimaaprobatoria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nota Mínima Habilitación<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['notaminimahabilitacion']==$_POST['notaminimahabilitacion'];?>
                        <INPUT type="text" name="notaminimahabilitacion" id="notaminimahabilitacion"  value="<?php echo $row_datos['notaminimahabilitacion']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="notaminimahabilitacion" id="notaminimahabilitacion"  value="<?php if ($_POST['notaminimahabilitacion']!=""){
                        echo $_POST['notaminimahabilitacion']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Número Semanas<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['numerosemana']==$_POST['numerosemana'];?>
                        <INPUT type="text" name="numerosemana" id="numerosemana"  value="<?php echo $row_datos['numerosemana']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="numerosemana" id="numerosemana"  value="<?php if ($_POST['numerosemana']!=""){
                        echo $_POST['numerosemana']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Número Horas Semanales<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['numerohorassemanales']==$_POST['numerohorassemanales'];?>
                        <INPUT type="text" name="numerohorassemanales" id="numerohorassemanales"  value="<?php echo $row_datos['numerohorassemanales']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="numerohorassemanales" id="numerohorassemanales"  value="<?php if ($_POST['numerohorassemanales']!=""){
                        echo $_POST['numerohorassemanales']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Número de Sesiones<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['sesionesmateria']==$_POST['sesionesmateria'];?>
                        <INPUT type="text" name="sesionesmateria" id="sesionesmateria"  value="<?php echo $row_datos['sesionesmateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="sesionesmateria" id="sesionesmateria"  value="<?php if ($_POST['sesionesmateria']!=""){
                        echo $_POST['sesionesmateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Porcentaje Teórica Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['porcentajeteoricamateria']==$_POST['porcentajeteoricamateria'];?>
                        <INPUT type="text" name="porcentajeteoricamateria" id="porcentajeteoricamateria"  value="<?php echo $row_datos['porcentajeteoricamateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="porcentajeteoricamateria" id="porcentajeteoricamateria"  value="<?php if ($_POST['porcentajeteoricamateria']!=""){
                        echo $_POST['porcentajeteoricamateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Porcentaje Práctica Materia<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['porcentajepracticamateria']==$_POST['porcentajepracticamateria'];?>
                        <INPUT type="text" name="porcentajepracticamateria" id="porcentajepracticamateria"  value="<?php echo $row_datos['porcentajepracticamateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="porcentajepracticamateria" id="porcentajepracticamateria"  value="<?php if ($_POST['porcentajepracticamateria']!=""){
                        echo $_POST['porcentajepracticamateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Porcentaje Fallas Teoría<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['porcentajefallasteoriamodalidadmateria']==$_POST['porcentajefallasteoriamodalidadmateria'];?>
                        <INPUT type="text" name="porcentajefallasteoriamodalidadmateria" id="porcentajefallasteoriamodalidadmateria"  value="<?php echo $row_datos['porcentajefallasteoriamodalidadmateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="porcentajefallasteoriamodalidadmateria" id="porcentajefallasteoriamodalidadmateria"  value="<?php if ($_POST['porcentajefallasteoriamodalidadmateria']!=""){
                        echo $_POST['porcentajefallasteoriamodalidadmateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Porcentaje Fallas Práctica<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['codigomateria'])){
                        $row_datos['porcentajefallaspracticamodalidadmateria']==$_POST['porcentajefallaspracticamodalidadmateria'];?>
                        <INPUT type="text" name="porcentajefallaspracticamodalidadmateria" id="porcentajefallaspracticamodalidadmateria"  value="<?php echo $row_datos['porcentajefallaspracticamodalidadmateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="porcentajefallaspracticamodalidadmateria" id="porcentajefallaspracticamodalidadmateria"  value="<?php if ($_POST['porcentajefallaspracticamodalidadmateria']!=""){
                        echo $_POST['porcentajefallaspracticamodalidadmateria']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <?PHP 
                if(!$Acceso->EOF){
                ?>
                <tr>
                    <td width="30%"><strong>Modalidad Acad&eacute;mica<label  id="labelasterisco">*</label></strong></td>
                    <td>
                       <?PHP ModalidadCarreraSeccion($db,$_REQUEST['codigocarrera']);?>
                    </td>
                </tr>
                <tr>
                    <td width="30%"><strong>Programa Acad&eacute;mico<label  id="labelasterisco">*</label></strong></td>
                    <td>
                       <?PHP echo CarreraSeccion($db,$_REQUEST['codigocarrera']);?>
                    </td>
                </tr>
                <tr>
                    <td width="30%"><strong>Estado Materia<label  id="labelasterisco">*</label></strong></td>
                    <td>
                       <?PHP EstadoMateria($db,$_REQUEST['codigomateria']);?>
                    </td>
                </tr>
               <?PHP 
               }
               ?>     

             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">
                <INPUT type="button" value="Regresar" onClick="window.location.href='<?php echo $_SESSION['sesion_materias']; ?>'">
                <?php

                    if (isset($_REQUEST['codigomateria'])){
                ?>
                <input type="hidden" name="codigomateria" value="<?php echo $_REQUEST['codigomateria']; ?>">
                <!--<INPUT type="button" value="Objetivos Materia" onClick="window.location.href='../objetivos/lista_objetivos_materia.php?codigomateria=<?php //echo $_REQUEST['codigomateria']; ?>'"> -->

                    <?php
                    }
                    ?>               
             </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>
