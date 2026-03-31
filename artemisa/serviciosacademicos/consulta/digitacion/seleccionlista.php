<?php
session_start();
//require_once('Connections/sala.php');
require_once('../../Connections/sala2.php');
require_once('../../funciones/clases/autenticacion/redirect.php' );
if ($_POST['listado'] == 0)
  {
      echo '<script language="JavaScript">alert("Debe Seleccionar un Listado")</script>';			
      echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listassala.php'>";
  }
else 
if ($_POST['listado'] == 1)
  {
     require_once('despliegalistasala.php'); 
  }
else 
if ($_POST['listado'] == 2)
  {
     require_once('despliegalistasala1.php'); 
  }
  else if($_POST['listado'] == 3) {
      /*
      //print_r($_REQUEST);
      $_REQUEST['reportUnit'] = "%2FReportes%2FFacultades%2FPlantillas%2FplantillaAsistencia&grupo=".$_REQUEST['grupo']."&corte=".$_REQUEST['numerocorte'];
      $rutaado = "../../funciones/adodb/";
      $rutaConeccion = "../../";
      $rutaJS = "../sic/librerias/js/";*/
?>

<?php
      //require_once('../../Reporteador/ReporteCentralInterno.php');
      require_once('despliegalistasalaasistencia.php'); 
  }
?>