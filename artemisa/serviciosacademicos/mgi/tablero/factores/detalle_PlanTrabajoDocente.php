<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
        	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	        <title>Plan de trabajo docentes</title>
                
                <!-- styles needed by jScrollPane -->
                <link type="text/css" href="../../../PlantrabajoDocente/jquery.jscrollpane.css" rel="stylesheet" media="all" />
                <link rel="stylesheet" href="../../../PlantrabajoDocente/PlanTrabjoDocente.css">      
                <!-- latest jQuery direct from google's CDN -->
                <script type="text/javascript" src="../../js/jquery.min.js"></script>
                <!-- the mousewheel plugin - optional to provide mousewheel support -->
                <script type="text/javascript" src="../../../js/jquery.mousewheel.js"></script>
                <!-- the jScrollPane script -->
                <script type="text/javascript" src="../../../js/jquery.jscrollpane.min.js"></script>	
                <script type="text/javascript">
                    $(function()
                    {
                          $('.scroll-pane').jScrollPane();
                    });
                </script>
</head>
	<body id="white">
<?php
		include_once('../../../ReportesAuditoria/templates/mainjson.php');
		$qry = "select nombredocente,apellidodocente,numerodocumento from docente where iddocente=".$_REQUEST['iddocente'];
		$rs=$db->Execute($qry);
		$row=$rs->fetchrow();

                $periodo = $_REQUEST["codigoperiodo"];
                $arrayP = str_split($periodo, strlen($periodo)-1);
                $labelPeriodo = $arrayP[0]."-".$arrayP[1];
?>
	 <div id="encabezado">
	<div class="cajon">
		<img src="../../../PlantrabajoDocente/img/logotipo_negativo.png" id="logo">
			<div id="id">
			<div id="nombre">
				<?PHP echo $row['nombredocente']." ".$row['apellidodocente']?>			</div>
			<div id="tipodoc">
				<?PHP echo $row['numerodocumento']?>
			</div>
			<div id="periodo"><?PHP echo $labelPeriodo?></div>
		</div>
	
	   <div class="vacio"></div>
			</div>
</div>
<div id="pageContainer"> 
		
<?PHP 

$id_doc=$_REQUEST['iddocente'];
$codperiodo=$_REQUEST['codigoperiodo'];

$query_validado="select verificado from plandocente where id_docente='$id_doc' and codigoperiodo='$codperiodo' and codigoestado like '1%'";
$validado= $db->Execute($query_validado);
$row_validado = $validado->FetchRow();

?>
		  <div class="validar">Validar Información <input type="checkbox" name="validar" id="validar" <?PHP  if($row_validado['verificado']==1){ ?> checked <?PHP  } ?>>
		  <a href="../../../PlantrabajoDocente/listadodocente_PlanTrabajoDocente.php">Volver al Listado de Docentes</a></div>
<?php
		$arrVocacion=array("1"=>"Enseñanaza-Aprendizaje","2"=>"Descubrimiento","3"=>"Compromiso","4"=>"Gestión Académica");
		while(list($key,$value)=each($arrVocacion)) {
?>
			<h2 class="vocacion"><?PHP echo $value?></h2>
			<div class="planesVocacion scroll-pane" >

<?php
				$qry = "select	 autoevaluacion
						,porcentaje
						,consolidacion
						,mejora
						,proyecto_nom
						,descripcion
						,nombrefacultad
						,nombrecarrera
						,nombremateria
						,nombregrupo
						,horas
					from plandocente pd 
					join accionesplandocente_temp apdt on pd.plantrabajo_id=apdt.id_accionesplandocentetemp 
					left join grupo g on apdt.grupo_id=g.idgrupo
					left join materia m on apdt.materia_id=m.codigomateria
					left join carrera c on apdt.carrera_id=c.codigocarrera
					left join facultad f on apdt.facultad_id=f.codigofacultad
					where pd.id_docente=".$_REQUEST['iddocente']." and pd.codigoperiodo='".$_REQUEST['codigoperiodo']."' and id_vocacion=".$key."
					order by grupo_id";
				$rs=$db->Execute($qry);
				if($rs->RecordCount()>0) {
					while($row=$rs->fetchrow()) {
						if($key==1) {
?><p>
							<b>Facultad:</b> <?PHP echo $row["nombrefacultad"]?><br>
							<b>Carrera:</b> <?PHP echo $row["nombrecarrera"]?><br>
							<b>Materia:</b> <?PHP echo $row["nombremateria"]?><br>
							<b>Grupo:</b> <?PHP echo $row["nombregrupo"]?><br><br></p>
<?php
						} else {
?>
							<p><b>Proyecto nombre:</b> <?PHP echo $row["proyecto_nom"]?><br><br>
							<b>Horas:</b> <?PHP echo $row["horas"]?><br><br></p>
<?php						}
						
?><p>
						<b>Descripci&oacute;n:</b> <?PHP echo $row["descripcion"]?><br><br>
						<b>Autoevaluaci&oacute;n:</b> <?PHP echo $row["autoevaluacion"]?><br><br>
						<b>Porcentaje:</b> <?PHP echo $row["porcentaje"]?><br><br>
						<b>Consolidaci&oacute;n:</b> <?PHP echo $row["consolidacion"]?><br><br>
						<b>Mejora:</b> <?PHP echo $row["mejora"]?><br><br>
						<br><hr><br></p>
<?php
					}
				} else {
?>
					<p>No existe informaci&oacute;n registrada para el periodo <b><?PHP echo $labelPeriodo?></b></p>
<?php
				}
?>


			</div>
<?php
		}
?>


 </div><!---pageContainer---->
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function() {
	
	$('#validar').click(function() {
        if ($(this).is(':checked')) {
            if(confirm("¿Está Seguro de Validar el Plan de Trabajo Docente?")){
		
		$.ajax({
		  url:"cambiarestado.php",
		  type: "POST",
		  data:"iddocente="+<?PHP  echo $id_doc;?>+"&codigoperiodo="+<?PHP  echo $codperiodo;?>+"&activa=1",
		  success: function(opciones){		  
		    //alert('fue y volvio');		
		  }
		})
	  
            }
            else{
            $(this).attr("checked", false);
            }
        }
        else if(!$(this).is(':checked')) {
	  if(confirm("¿Está seguro de quitar la validación?")){
            
	      $.ajax({
		  url:"cambiarestado.php",
		  type: "POST",
		  data:"iddocente="+<?PHP  echo $id_doc;?>+"&codigoperiodo="+<?PHP  echo $codperiodo;?>+"&activa=0",
		  success: function(opciones){		  
		    //alert('fue y volvio qquita la val');		
		  }
		})
            
            }
        }
    });
		
	});
	
</script>
