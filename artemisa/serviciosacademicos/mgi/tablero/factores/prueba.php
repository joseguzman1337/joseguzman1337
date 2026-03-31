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
				<?=$row['nombredocente']." ".$row['apellidodocente']?>			</div>
			<div id="tipodoc">
				<?=$row['numerodocumento']?>
			</div>
			<div id="periodo"><?=$labelPeriodo?></div>
		</div>
	
	   <div class="vacio"></div>
			</div>
</div>
<div id="pageContainer"> 
<?php
		$arrVocacion=array("1"=>"Enseñanaza-Aprendizaje","2"=>"Descubrimiento","3"=>"Compromiso","4"=>"Gestión Académica");
		while(list($key,$value)=each($arrVocacion)) {
?>
			<h2 class="vocacion"><?=$value?></h2>
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
							<b>Facultad:</b> <?=$row["nombrefacultad"]?><br>
							<b>Carrera:</b> <?=$row["nombrecarrera"]?><br>
							<b>Materia:</b> <?=$row["nombremateria"]?><br>
							<b>Grupo:</b> <?=$row["nombregrupo"]?><br><br></p>
<?php
						} else {
?>
							<p><b>Proyecto nombre:</b> <?=$row["proyecto_nom"]?><br><br>
							<b>Horas:</b> <?=$row["horas"]?><br><br></p>
<?php						}
						
?><p>
						<b>Descripci&oacute;n:</b> <?=$row["descripcion"]?><br><br>
						<b>Autoevaluaci&oacute;n:</b> <?=$row["autoevaluacion"]?><br><br>
						<b>Porcentaje:</b> <?=$row["porcentaje"]?><br><br>
						<b>Consolidaci&oacute;n:</b> <?=$row["consolidacion"]?><br><br>
						<b>Mejora:</b> <?=$row["mejora"]?><br><br>
						<br><hr><br></p>
<?php
					}
				} else {
?>
					<p>No existe informaci&oacute;n registrada para el periodo <b><?=$labelPeriodo?></b></p>
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
