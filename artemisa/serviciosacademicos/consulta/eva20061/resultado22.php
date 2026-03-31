<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
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
$digo = $_SESSION['codigofacultad'];
//echo $_SESSION['nombrefacultad'];
//$digo=$_GET['di'];
//echo "paso digo $digo";
//$sss="SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente,m.codigocarrera,c.nombrecarrera 
//FROM docente d, respuestas r,materia m,grupo g,carrera c 
//where d.numerodocumento=r.codigodocente 
//and m.codigomateria=r.codigomateria 
//and r.idgrupo=g.idgrupo 
//ORDER BY d.nombredocente";
/*$sss="select distinct d.nombredocente, d.apellidodocente,r.codigodocente,m.codigocarrera,c.nombrecarrera
FROM docente d, respuestas r,materia m,grupo g,carrera c 
where m.codigomateria = r.codigomateria 
and d.numerodocumento = r.codigodocente
and m.codigocarrera = c.codigocarrera
and m.codigocarrera='$digo'
and r.idgrupo=g.idgrupo
ORDER BY d.nombredocente";
*/
$sss="select distinct d.nombredocente,d.apellidodocente,d.numerodocumento,e.codigocarrera,c.nombrecarrera 
from docente d,respuestas r,grupo g,evafacultad e,carrera c
where r.codigodocente=d.numerodocumento
and d.numerodocumento=g.numerodocumento
and g.idgrupo=r.idgrupo
and r.codigoestudiante=e.codigoestudiante
and e.codigocarrera='731'
and c.codigocarrera=e.codigocarrera
order by d.nombredocente";
//echo $sss;
	  $sultado=mysql_query($sss,$sala);
     //$aest=mysql_fetch_array($sultado);
	 $nom=$aest['nombredocente'];
	 $ape=$aest['apellidodocente'];
	 $minom=$_GET['om'];
	 $miape=$_GET['pe'];
	 //$digo=$_GET['di'];
	 $fa=$_GET['ggg'];
//	 echo "paso $nom";
	 //echo "$hola";
	 
?>
<form action="resultado11.php" method="post" name="form3" id="form3">
  <div align="center"> 
    <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
      <option selected><?php echo $minom?> <?php echo $miape?></option>
      <?php   
	 while ($aest=mysql_fetch_array($sultado))
		  {
?>
      <option value="res43.php?si=<?php echo $aest['numerodocumento']?>&nom=<?php echo $aest['nombredocente']?>&ape=<?php echo $aest['apellidodocente']?>&siti=<?php echo $aest['nombrecarrera']?>&cod=<?php echo "$digo"?>"><?php echo $aest['nombredocente']?> 
      <?php echo $aest['apellidodocente']?></option>
      <?php }?>
    </select>
  </div>

</form>

</body>
</html>
