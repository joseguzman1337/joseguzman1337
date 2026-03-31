<?php
session_start();
$rol=$_SESSION['rol'];

//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");


?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>

<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	document.location.href="<?php echo 'menumantenimientovotaciones.php';?>";
}

</script>

<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();


?>
<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

	<?php 
			$formulario->dibujar_fila_titulo('Crear Votos En Blanco','labelresaltado');

			$condicion=" codigoestado like '1%'";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("votacion","idvotacion","nombrevotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idvotacion','".$idvotacion."',''";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Votacion","tdtitulogris","idvotacion",'requerido');
$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
		$boton[$conboton]='boton_tipo';
		$conboton++;
		$parametrobotonenviar[$conboton]="'Listado','listadocandidatoplantilla.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);


if(isset($_REQUEST['Enviar'])){
	if($formulario->valida_formulario()){
		 $query="insert into plantillavotacion
	select null,idtipoplantillavotacion,idvotacion,iddestinoplantillavotacion,'',if(c.codigocarrera=1,'Voto En Blanco',concat('Voto En Blanco ',c.nombrecarrera)) nombrecandidato,100,c.codigocarrera from plantillavotacion p, carrera c where idvotacion='".$_POST['idvotacion']."' and codigoestado ='100' and c.codigocarrera=p.codigocarrera 
and p.codigocarrera not in (
select c.codigocarrera from plantillavotacion p, carrera c where idvotacion='".$_POST['idvotacion']."' and codigoestado ='100' and c.codigocarrera=p.codigocarrera and nombreplantillavotacion like '%Voto En Blanco%'
)
group by idtipoplantillavotacion,c.codigocarrera";
		$objetobase->conexion->query($query);
		 $query="insert into detalleplantillavotacion
select null,223,now(),'',idplantillavotacion,'100',1 from plantillavotacion where idvotacion='".$_POST['idvotacion']."' and codigoestado ='100' and nombreplantillavotacion like '%Voto En Blanco%'
and idplantillavotacion not in (
select dp.idplantillavotacion from detalleplantillavotacion dp, plantillavotacion p, carrera c where idvotacion='".$_POST['idvotacion']."' and dp.codigoestado ='100' and p.codigoestado ='100' and c.codigocarrera=p.codigocarrera and nombreplantillavotacion like '%Voto En Blanco%' and dp.idplantillavotacion=p.idplantillavotacion
) group by idtipoplantillavotacion,codigocarrera";
		$objetobase->conexion->query($query);

	}
}

?>

  </table>
</form>