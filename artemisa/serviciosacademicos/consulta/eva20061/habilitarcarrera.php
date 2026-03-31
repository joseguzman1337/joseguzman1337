<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();

$codigocarrera = $_SESSION['codigofacultad'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>EVALUACION</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 12px;
}
.Estilo2 {color: #006600}
-->
</style>
</head>

<body>
<div align="center">
  <form name="form1" method="post" action="habilitarcarrera.php">
      <table width="307" border="1" align="center">
      <tr bgcolor="#E6EEEC">
        <td colspan="2"><div align="center"><span class="Estilo1">Si desea habilitar la evaluaci&oacute;n docente<br>
            <span class="Estilo2">escoja una carrera </span></span></div></td>
      </tr>
      <tr>
        <td width="194"><div align="center">
          <select name="codecar" id="codecar">
            <option value="">Escoja carrera</option>
            <option value="124">Ingenier&iacute;a de Sistemas Diurno</option>
            <option value="123">Ingenier&iacute;a de Sistemas Noche</option>
            <option value="118">Ingenier&iacute;a de Electronica Noche</option>
            <option value="119">Ingenier&iacute;a de Electroncica Diurno</option>
            <option value="126">Ingenier&iacute;a Industrial </option>
            <option value="125">Ingenier&iacute;a Ambiental</option>
            <option value="5">Administraci&oacute;n de Empresas</option>
			<option value="122">Biologia</option>
                    </select>
</div></td>
        <td width="136"><div align="center">
          <input type="submit" name="Submit" value="Habilitar">
		
		  
        </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table>
  </form>
<?php 
 
  include("pconexionbase.php");
    
		  $codecar=$_POST['codecar'];
		  //echo $codecar;
		 

	$r = mysql_query("SELECT DATABASE()") or die (mysql_error());
	//echo "<br>Base".mysql_result($r,0);
  //echo $ceduli;
  //if(!(isset ($ceduli)))
  if($codecar=='')
  {
  echo "debe escoger una carrera";
  
  } 
  
  else
  {
     $cevinst="select * from evaluacioncarrera where carrera='$codecar' and codigoperiodo='20081'";
	 $cteoc=mysql_db_query($database_sala,$cevinst,$sala) or die(mysql_error());
     $cidegen=mysql_fetch_array($cteoc);
	 //echo "<br>".mysql_info($sala);
	 //echo "<br>".$database_sala;	
	 $ctomelo=$cidegen['carrera'];
	 
	 
	//echo $exite.'no existe';
	//echo $tomelo.'tomelo';
	//echo $fccc.'no existe';
	   if ($ctomelo=='')
	      {
	 $ctuig="INSERT INTO evaluacioncarrera VALUES('$codecar',20081)";
	  $cres=mysql_db_query($database_sala,$ctuig,$sala) or die(mysql_error());
	  //echo "<br>".$tuig;
	  //echo "<br>".mysql_affected_rows();
	  //echo "<br>".mysql_info();
	  //echo $tuig;
	  echo "ya pueda presentar evaluación esta carrera".$codecar;
	      }
		    
		     if ($ctomelo==$codecar)
	           {
	           echo "ya habia sido habilitada la carrera";
	           }
		        
	  }

   
  ?>
</div>
</body>
</html>
