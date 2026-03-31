<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}*/
$nombrearchivo = 'Listado Estudiantes con Documentación';
if(isset($_REQUEST['formato']))
{
    /*echo "sadsad".$_SESSION['sesion_tabladocumentacion'];
    exit();*/
	$formato = $_REQUEST['formato'];
	$formato = 'xls';
	switch ($formato)
	{
		case 'xls' :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
		case 'doc' :
			$strType = 'application/msword';
			$strName = $nombrearchivo.".doc";
			break;
		case 'txt' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".txt";
			break;
		case 'csv' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".csv";
			break;
		case 'xml' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".xml";
			break;
		default :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
	}
	header("Content-Type: $strType");
	header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	//header("Cache-Control: no-store, no-cache");
	header("Pragma: public");

        echo $_SESSION['sesion_tabladocumentacion'];

        exit();
}
require_once('../../Connections/sala2.php' );
require_once("../../funciones/seleccioncarrera.php");
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

?>
<html>
<head>

<title>Estudiantes</title>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<body>

<form name="f1" method="REQUEST" action="">
  <?php 
//  if(!isset($_REQUEST['formato'])){
      ?>
    <p>CRITERIO DE SELECCIÓN</p>

  <?php
  periodo();
  modalidad();
  ?>
  <table  border="0"  cellpadding="3" cellspacing="3">
  <TR><TD><INPUT type="submit" name="aceptar" value="Aceptar"></TD></TR>
  <TR id="trtitulogris">
                    <TD colspan="35" align="left"><INPUT type="submit" name="formato" id="formato" value="Exportar" ></TD>
               </TR>

 </table>
 </form>

<?php
  //}

  if(isset($_REQUEST['aceptar'])){
      /*$parametros="";
    if($_REQUEST['periodo']!=''){
        $parametros .=" and e.codigoperiodo = ".$_REQUEST['periodo'];
    }*/
    
   /*$query_estudiante = "SELECT e.codigoestudiante, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, e.codigoperiodo, s.nombresituacioncarreraestudiante, e.semestre*1 as semestre
        FROM estudiante e, estudiantegeneral eg, carrera c, situacioncarreraestudiante s
        where
        c.codigocarrera='".$_REQUEST['nacodigocarrera']."'        
        and e.idestudiantegeneral=eg.idestudiantegeneral
        and e.codigocarrera=c.codigocarrera
        and e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante
        and (s.codigosituacioncarreraestudiante like '2%' or s.codigosituacioncarreraestudiante like '3%')
        order by semestre, eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral";*/

   $query_estudiante = "SELECT ee.codigoestudiante, ee.codigoperiodo, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, e.codigoperiodo, s.nombresituacioncarreraestudiante, e.semestre*1 as semestre
                FROM estudianteestadistica ee, carrera c, estudiante e, estudiantegeneral eg, situacioncarreraestudiante s
                where e.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
		and e.idestudiantegeneral=eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '".$_REQUEST['periodo']."'
                and ee.codigoprocesovidaestudiante= 400
                and ee.codigoestado like '1%'
                union
                SELECT ee.codigoestudiante, ee.codigoperiodo, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, e.codigoperiodo, s.nombresituacioncarreraestudiante, e.semestre*1 as semestre
                FROM estudianteestadistica ee, carrera c, estudiante e, estudiantegeneral eg, situacioncarreraestudiante s
                where e.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
                and e.codigocarrera=c.codigocarrera
		and e.idestudiantegeneral=eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '".$_REQUEST['periodo']."'
                and ee.codigoprocesovidaestudiante= 401
                and ee.codigoestado like '1%'
                order by semestre, apellidosestudiantegeneral,nombresestudiantegeneral";





        $estudiante= $db->Execute($query_estudiante);
        $totalRows_estudiante = $estudiante->RecordCount();
        $row_estudiante = $estudiante->FetchRow();
        //echo $totalRows_estudiante;
		//echo $query_estudiante;
        if ($totalRows_estudiante >0){

            $query_documentos = "SELECT *
            FROM documentacion d,documentacionfacultad df
	    where d.iddocumentacion = df.iddocumentacion
	    and df.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
	    and df.fechainiciodocumentacionfacultad <= '$fechahoy'
	    and df.fechavencimientodocumentacionfacultad >= '$fechahoy' ";
		//echo $query_documentos,"<br>";
		$documentos= $db->Execute($query_documentos);
                $totalRows_documentos = $documentos->RecordCount();
                $row_documentos = $documentos->FetchRow();

                 ob_flush();
        flush();
        ob_end_clean();
        ob_start();
            ?>
    
            <table border="1"  cellpadding="3" cellspacing="3">
               <TR id="trtitulogris">
                    <TD colspan="<?php echo $totalRows_documentos+5; ?>" align="center"><LABEL id="labelresaltadogrande">LISTADO DOCUMENTACION DE ESTUDIANTES</LABEL></TD>
                </TR>
                <TR id="trtitulogris">
                    <TD colspan="<?php echo $totalRows_documentos+5; ?>" align="left"><LABEL id="labelasterisco">*</LABEL>Los documentos marcados con "X" no han sido entregados.</TD>
                </TR>
                <TR id="trtitulogris">
                    <TD align="center">Documento</TD>
                    <TD align="center">Apellidos</TD>
                    <TD align="center">Nombres</TD>
                    <TD align="center">Semestre</TD>
                    <TD align="center">Situación</TD>                    
                    <?php
                    do {
                    ?>
                    <TD align="center"><?php echo $row_documentos['nombredocumentacion']; ?></TD>
                    <?php
                    } while($row_documentos = $documentos->FetchRow());
                    ?>
                </TR>
                <?php
                do {
                    
                    ?>

                <TR>
                    <TD align="left"><?php echo $row_estudiante['numerodocumento']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['apellidosestudiantegeneral']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['nombresestudiantegeneral']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['semestre']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['nombresituacioncarreraestudiante']; ?>
                    </TD>
                    
                    
                    <?php
                    $query_documentos = "SELECT *
            FROM documentacion d,documentacionfacultad df
	    where d.iddocumentacion = df.iddocumentacion
	    and df.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
	    and df.fechainiciodocumentacionfacultad <= '$fechahoy'
	    and df.fechavencimientodocumentacionfacultad >= '$fechahoy' ";
		//echo $query_documentos,"<br>";
		$documentos= $db->Execute($query_documentos);
                $totalRows_documentos = $documentos->RecordCount();
                $row_documentos = $documentos->FetchRow();
                    do {
                        $query_documentosestuduante = "SELECT d.iddocumentacion, df.codigotipodocumentacionfacultad,
                            cast(d.fechavencimientodocumentacionestudiante as date)as fecha

		    FROM documentacionestudiante d, documentacionfacultad df
		    where d.codigoestudiante = '".$row_estudiante['codigoestudiante']."'
		    and d.codigoperiodo = '".$_REQUEST['periodo']."'
                    and d.iddocumentacion= '".$row_documentos['iddocumentacion']."'
                    and d.iddocumentacion = df.iddocumentacion 
					AND df.codigotipodocumentacionfacultad=200
					UNION 
					SELECT d.iddocumentacion, df.codigotipodocumentacionfacultad,
                            cast(d.fechavencimientodocumentacionestudiante as date)as fecha

		    FROM documentacionestudiante d, documentacionfacultad df
		    where d.codigoestudiante = '".$row_estudiante['codigoestudiante']."'
                    and d.iddocumentacion= '".$row_documentos['iddocumentacion']."'
                    and d.iddocumentacion = df.iddocumentacion 
					AND df.codigotipodocumentacionfacultad=100 and d.codigotipodocumentovencimiento=100";
		    $documentosestuduante= $db->Execute($query_documentosestuduante);
		    $totalRows_documentosestuduante = $documentosestuduante->RecordCount();
                    $row_documentosestuduante = $documentosestuduante->FetchRow();

                    ?>
                    <TD align="center"><?php if($totalRows_documentosestuduante > 0) {
                        if ($row_documentos['iddocumentacion'] == 20){
                            $query_eps = "SELECT d.idempresasalud, e.nombreempresasalud
		            FROM documentacionestudiante d, empresasalud e
			    where d.codigoestudiante = '" . $row_estudiante['codigoestudiante'] . "'
			    and d.iddocumentacion = '" . $row_documentos['iddocumentacion'] . "'
			    AND d.codigotipodocumentovencimiento = '100'
                            and e.idempresasalud = d.idempresasalud";
                             //echo  $query_documentosestuduante,"<br>";AND d.codigoperiodo = '$periodo'
                            $eps= $db->Execute($query_eps);
                            $totalRows_eps = $eps->RecordCount();
                            $row_eps = $eps->FetchRow();
                        
                            echo $row_eps['nombreempresasalud']."<br>";
                        }
                        echo "ENTREGADO<BR>";
                            if($row_documentosestuduante['codigotipodocumentacionfacultad']=='200')
                            {
                            echo $row_documentosestuduante['fecha'];
                            }
                            elseif(in_array($row_documentos['iddocumentacion'],array('61','62','63','64','65')))
                            {
                                echo $row_documentosestuduante['fecha'];
                            }
                        }
                        else{
                           echo "X";
                           }
                        ?></TD>

                    <?php
                    }
                    while($row_documentos = $documentos->FetchRow());                   
                    ?>
                </TR>
                <?php                
                } while($row_estudiante = $estudiante->FetchRow());
                
                ?>
                
            </table>
        <?php
        $_SESSION['sesion_tabladocumentacion'] = ob_get_contents();
    //ob_end_clean();
    ob_end_flush();
        }
        else {
            echo "<script language='javascript'>
            alert ('La busqueda no arroja resultados');
            </script>";
        }
  /*
    //print_r($_REQUEST);
    $reportUnit = "%2FReportes%2FEstudiantes%2Freportedocumentos%2Festudiantesporcarrera&codigoPeriodo=".$_REQUEST['periodo']."&codigocarrera=".$_REQUEST['nacodigocarrera'];
    $rutaado = "../../funciones/adodb/";
    $rutaConeccion = "../../";
    $rutaJS = "../sic/librerias/js/";
    $conJquery = false;
    $_REQUEST['reportUnit'] = $reportUnit;
    require_once('../../Reporteador/ReporteCentralInterno.php');*/

    }
  ?>
</body>
</html>
