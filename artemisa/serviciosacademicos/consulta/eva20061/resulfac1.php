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
<?php include("pconexionbase.php");
 mysql_select_db($database_sala, $sala);
$fa=$_GET['ggg'];
$ddd="select distinct e.codigocarrera,c.nombrecarrera
from  respuestas r,carrera c,estudiante e 
where e.codigoestudiante=r.codigoestudiante
and e.codigocarrera = c.codigocarrera";
$dsulta=mysql_query($ddd,$sala);
//$aest=mysql_fetch_array($sultado);
$nom=$aest['nombredocente'];
$ape=$aest['apellidodocente'];
$minom=$_GET['om'];
$miape=$_GET['pe'];
$digo=$_GET['di'];
$fa=$_GET['ggg'];
//echo "$hola";
//echo "aqui esta $fa";
	 
?>
<form action="resultado11.php" method="post" name="form3" id="form3">
  <div align="center"> 
    <select name="menu2" id="menu2" onChange="MM_jumpMenu('parent',this,0)">
      <option selected><?php echo $fa?></option>
<?php   
	 while ($ttt=mysql_fetch_array($dsulta))
		  {
?>
		
		<option value="res43.php?cod=<?php echo $ttt['codigocarrera']?>&siti=<?php echo $ttt['nombrecarrera']?>"><?php echo $ttt['nombrecarrera']?></option>
		  <?php }?>
		  <option>hola </option>
		  </select>
  </div>

</form>

</body>
</html>

