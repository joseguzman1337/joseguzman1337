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

<body><?php include("pconexionbase.php");
$sss="SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente FROM docente d, respuestas r,materia m,grupo g where d.numerodocumento=r.codigodocente and m.codigomateria=r.codigomateria and r.idgrupo=g.idgrupo ORDER BY d.nombredocente";
	  $sultado=mysql_query($sss,$conexion);
     //$aest=mysql_fetch_array($sultado);
	 $nom=$aest['nombredocente'];
	 $ape=$aest['apellidodocente'];
	 
?>
<form name="form1" method="post" action="">
  <div align="center">
  

  <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
      <option selected>ESCOGA EL DOCENTE</option>
<?php   
	 while ($aest=mysql_fetch_array($sultado))
		  {
?>
 <option value="resultado.php?si=<?php echo $aest['codigodocente']?>&nom=<?php echo $aest['nombredocente']?>&ape=<?php echo $aest['apellidodocente']?>"><?php echo $aest['nombredocente']?> <?php echo $aest['apellidodocente']?></option>
		
		  <?php }?>
		   
			<option value="33">sis</option>
		  </select>
  </div>

  </form>

</body>
</html>
