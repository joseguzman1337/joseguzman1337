<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
$digo=$_GET['di'];
$nom=$aest['nombredocente'];
$ape=$aest['apellidodocente'];
$li=$_GET['no'];
$minom=$_GET['om'];
$miape=$_GET['pe'];
$digo=$_GET['di'];
$oon=$_GET['ii'];
$fa=$_GET['ggg'];
//echo "paso $li";
 include("pconexionbase.php");
 mysql_select_db($database_sala, $sala);
$sss="SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente,m.nombremateria,m.codigomateria FROM docente d, respuestas r,materia m where d.numerodocumento=r.codigodocente and m.codigomateria=r.codigomateria and r.codigodocente='$li' ORDER BY m.nombremateria";
	  $sultado=mysql_query($sss,$sala);
     //$aest=mysql_fetch_array($sultado);
	 
	 
?><form name="form1" method="post" action="">
  <div align="center"> 
    <select name="menu5" onChange="MM_jumpMenu('parent',this,0)">
      <option selected><?php echo $oon?></option>
<?php   
	 while ($aest=mysql_fetch_array($sultado))
		  {
?>
        <option value="res43.php?si=<?php echo $aest['codigodocente']?>&nom=<?php echo $aest['nombredocente']?>&ape=<?php echo $aest['apellidodocente']?>&siti=<?php echo "$fa"?>&nnm=<?php echo $aest['nombremateria']?>&gama=<?php echo $aest['codigomateria']?>&cod=<?php echo "$digo"?>"><?php echo $aest['nombremateria']?></option>
		
		
		  <?php }?>
		  </select>
		  </div>
  

</form>

</body>
</html>
