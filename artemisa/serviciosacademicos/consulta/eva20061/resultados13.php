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
$nom=$aest['nombredocente'];
$ape=$aest['apellidodocente'];
$li=$_GET['no'];
$minom=$_GET['om'];
$miape=$_GET['pe'];
$digo=$_GET['di'];
$oon=$_GET['ii'];
$fa=$_GET['ggg'];
$yui=$_GET['rdi'];
$pie=$_GET['mano'];

$gigi=$_GET['hola'];//el codigo docente
//echo "paso $li";
//echo "paso $pie";
 include("pconexionbase.php");
  mysql_select_db($database_sala, $sala);
$sss="SELECT DISTINCT idgrupo FROM respuestas where codigodocente='$li' and codigomateria='$pie' ORDER BY idgrupo";
	  $sultado=mysql_query($sss,$sala);
     //$aest=mysql_fetch_array($sultado);
	 
	 
?><form name="form1" method="post" action="">
  <div align="center"> 
    <select name="menu5" onChange="MM_jumpMenu('parent',this,0)">
      <option selected><?php echo $yui?></option>
      <?php   
	 while ($aest=mysql_fetch_array($sultado))
		  {
?>
      <option value="res43.php?si=<?php echo "$li"?>&nom=<?php echo "$minom"?>&ape=<?php echo "$miape"?>&siti=<?php echo "$fa"?>&nnm=<?php echo "$oon"?>&gama=<?php echo "$pie"?>&idd=<?php echo $aest['idgrupo']?>&cod=<?php echo "$digo"?>"><?php echo $aest['idgrupo']?></option>
      <?php }?>
    </select>
		  </div>
  

</form>

</body>
</html>
