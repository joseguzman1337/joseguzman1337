<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
include("pconexionbase.php");
//echo $_SESSION['codigo'],"session";
$codigoest = $_SESSION['codigo'];
mysql_select_db($database_sala, $sala);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Universidad el Bosque</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {font-family: Tahoma; font-size: 20px; font-weight: bold;}
-->
</style>

<body>
<p>
  <script language="JavaScript">
function enlaces(dir)
{
window.location.replace(dir)
}
<!--
/*
Este Script desabilita la función del click derecho del mouse para evitar la
copia de las imágenes contenidas en el documento
*/
         var message="Funcion no Disponible";
         function click(e) {
         if (document.all) {
         if (event.button==2||event.button==3) {
         alert(message);
         return false;
         }
         }
         if (document.layers) {
         if (e.which == 3) {
         alert(message);
         return false;
         }
         }
         }
         if (document.layers) {
         document.captureEvents(Event.MOUSEDOWN);
         }
         document.onmousedown=click;
// -->
</script>
<?php 
$con=0;
$observacion=$_POST['respac'] ;
//echo $observacion;
if(isset($_POST['enviar']))
{
	foreach($_POST as $sisi => $ree)
	{
		if(ereg("resp",$sisi))
		 {
			$con++;
			//echo $sisi; 
			//echo $ree;
					
			if($ree=="0")
			
			$vali++;
		 }

	}
	if(($con<39) || ($observacion == "") || ($vali>0) )
	{
		//echo "hola";
		//echo $con;
		//echo $observacion;
		echo '<script>alert("FAVOR LLENAR TODOS LOS CAMPOS"); history.go(-1);exit;</script>';
		
	}
	else
	{
	 
		$scodigomateria=$_POST['scodigomateria'];
		$scodigodocente = $_POST['scodigodocente'];
		$sidgrupo =$_POST['sidgrupo'];
		//$codigoest=$_POST['siguiente'];
		
		
		//$scodigomateria=$_SESSION['codigomateria'];
//$scodigodocente=$_SESSION['numerodocumento'];
//$sidgrupo=$_SESSION['idgrupo'];


          //echo " aqui debe salir algo".$_POST['resp1']."<br>";
		   //echo " la segunda".$_POST['resp2']."<br>";
		     
 
		  $inserp1=$_POST['resp1'] ;
		  $inserp2=$_POST['resp2'] ;
		  $inserp3=$_POST['resp3'] ;
		  $inserp4=$_POST['resp4'] ;
		  $inserp5=$_POST['resp5'] ;
		  $inserp6=$_POST['resp6'] ;
		  $inserp7=$_POST['resp7'] ;
		  $inserp8=$_POST['resp8'] ;
		  $inserp9=$_POST['resp9'] ;		         
		  $inserpa1=$_POST['respa1'] ;
		  $inserpb1=$_POST['respb1'] ;
		  $inserpc1=$_POST['respc1'] ;
		  $inserpd1=$_POST['respd1'] ;
		  $inserpa2=$_POST['respa2'] ;
		  $inserpb2=$_POST['respb2'] ;
		  $inserpc2=$_POST['respc2'] ;
		  $inserpd2=$_POST['respd2'] ;
		  $inserpa3=$_POST['respa3'] ;
		  $inserpb3=$_POST['respb3'] ;
		  $inserpc3=$_POST['respc3'] ;
		  $inserpd3=$_POST['respd3'] ;
		  $inserpa4=$_POST['respa4'] ;
		  $inserpb4=$_POST['respb4'] ;	  
          $inserpc4=$_POST['respc4'] ;
		  $inserpd4=$_POST['respd4'] ;
		  $inserpa5=$_POST['respa5'] ;
		  $inserpb5=$_POST['respb5'] ;
		  $inserpc5=$_POST['respc5'] ;
		  $inserpd5=$_POST['respd5'] ;
		  $inserpa6=$_POST['respa6'] ;
		  $inserpb6=$_POST['respb6'] ;
		  $inserpc6=$_POST['respc6'] ;
		  $inserpd6=$_POST['respd6'] ;
		  $inserpa7=$_POST['respa7'] ;
		  $inserpb7=$_POST['respb7'] ;
		  $inserpc7=$_POST['respc7'] ;		    
     	  $inserpd7=$_POST['respd7'] ;
		  $inserpa8=$_POST['respa8'] ;
		  $inserpb8=$_POST['respb8'] ;
		  $inserpc8=$_POST['respc8'] ;
		  $inserpd8=$_POST['respd8'] ;
		  $inserpa9=$_POST['respa9'] ;
		  $inserpb9=$_POST['respb9'] ;
		  $inserpc9=$_POST['respc9'] ;
		  $inserpd9=$_POST['respd9'] ;
		  $inserpe9=$_POST['respd9'] ;
		  
		   //echo " la cuarta".$_POST['resp4']."<br>";
		  
		  //echo "$inserp1";
		  //echo "$inserp2";
		  //echo "$inserp3";
		  //echo "$inserp4";
		 //echo "$inserp5";
		 //echo "$inserp6";
		 // echo "$inserp7";
		  //echo "$inserp8";
		  //echo "$inserp9";
	
		  //lo que viene es para evitar que el usuario vuelva a evaluar
  //mysql_query("update estudiante set evaluogeneral ='11' where codigoestudiante ='$codigoest'", $conexion);
  //aqui termina
$sql1="SELECT DISTINCT 
  estudiante.codigocarrera,
  estudiante.codigoestudiante,
  estudiantegeneral.nombresestudiantegeneral,
  estudiantegeneral.apellidosestudiantegeneral,
  carrera.nombrecarrera
FROM
 estudiante
 INNER JOIN estudiantedocumento ON (estudiante.idestudiantegeneral=estudiantedocumento.idestudiantegeneral)
 INNER JOIN estudiantegeneral ON (estudiantedocumento.idestudiantegeneral=estudiantegeneral.idestudiantegeneral)
 INNER JOIN carrera ON (estudiante.codigocarrera=carrera.codigocarrera)
 INNER JOIN prematricula ON (prematricula.codigoestudiante=estudiante.codigoestudiante)
 INNER JOIN detalleprematricula ON (detalleprematricula.idprematricula=prematricula.idprematricula)
WHERE
  (estudiante.codigoestudiante = '$codigoest')";
  
  //echo $sqll;
	  
	  $resultado = mysql_query( $sql1, $sala) or die("$sql1".mysql_error());
     $filaest=mysql_fetch_assoc($resultado);
	
	 $vv="SELECT evaluado FROM respuestas WHERE codigomateria='$scodigomateria' AND codigoestudiante='$codigoest' AND codigodocente='$scodigodocente' AND codigoperiodo='20061'";
	 //echo $vv;
	 $aare=mysql_query($vv,$sala); //or die("$vv".mysql_error());
     $eefi=mysql_fetch_assoc($aare); //or die("$vv".mysql_error());
	 $evalu =$eefi['evaluado'];
	 //echo  $filaest['apellidosestudiantegeneral']; 
	 
		  ?>

<table width="687" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
    <td height="24"><font color="#0066CC" size="4"><strong><?php //echo  $filaest['nombresestudiantegeneral']; ?> <?php //echo  $filaest['apellidosestudiantegeneral']; ?></strong></font></td>
    <td><font color="#0066CC" size="4"><strong><?php //echo  $filaest['codigoestudiante']; ?></strong></font></td>
  </tr>
  <tr> 
    <td><font color="#0066CC" size="4"><strong></strong></font></td>
    <td><font color="#0066CC" size="4">&nbsp;</font></td>
  </tr>
</table>
<p> 
<?php 
//verificacion si evaluo el docente
//echo "$codigoest";
//echo "$scodigomateria";
//echo "$scodigodocente";
//echo "$sidgrupo";
		  //lo que viene es para evitar que el usuario vuelva a evaluar
  //mysql_query("update estudiante set evaluogeneral ='11' where codigoestudiante ='$codigoest'", $conexion);
  //aqui termina
	   
//echo "$evalu";
//echo "$sidgrupo";


if(!(isset ($evalu)))
{
include("pconexionbase.php");
	  
		  
		  //$sql="INSERT INTO resultados values('".$fila['codigomateria']."','".$insercion2rp1."','$codigoest2','".$fila['codigodocente."',4,5,6,7,8,9,0,1,2,3)";
		$sqlf="INSERT INTO respuestas values('$scodigomateria','$codigoest','$scodigodocente',1,'$sidgrupo','$inserp1','$inserp2','$inserp3','$inserp4','$inserp5','$inserp6','$inserp7','$inserp8','$inserp9','$inserpa1','$inserpb1','$inserpc1','$inserpd1','$inserpa2','$inserpb2','$inserpc2','$inserpd2','$inserpa3','$inserpb3','$inserpc3','$inserpd3','$inserpa4','$inserpb4','$inserpc4','$inserpd4','$inserpa5','$inserpb5','$inserpc5','$inserpd5','$inserpa6','$inserpb6','$inserpc6','$inserpd6','$inserpa7','$inserpb7','$inserpc7','$inserpd7','$inserpa8','$inserpb8','$inserpc8','$inserpd8','$inserpa9','$inserpb9','$inserpc9','$inserpd9','$inserpe9','$observacion','20061')"; 
		//echo $sqlf;
		mysql_query($sqlf,$sala);

}
else
{
?>
<form action="pevaluacion4.php" method="post" enctype="multipart/form-data" name="prueba">
  <div align="center" class="Estilo3">Usted ya habia calificado este docente 
    <?php 		 
}		  
?></p>
    </div>
</form>
 
<p align="center" class="Estilo4"><font color="#FF0000">Ha terminado de evaluar 
  al docente.</font></p>
<form name="form1" method="post" action="pevaluacion4.php">
  <div align="center">
    <input name="siguiente" type="hidden" id="siguiente" value="<?php echo $codigoest ?>">
    <input type="submit" name="Submit" value="Evaluar otro docente">
  </div>
</form>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
	<?php }?>
<?php }?>
 

</body>
</html>
