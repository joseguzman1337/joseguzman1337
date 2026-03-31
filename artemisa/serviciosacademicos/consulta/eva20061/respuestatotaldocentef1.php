<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();

//$GLOBALS['codigodocente'];
//$GLOBALS['idgrupo'];
//session_register("codigodocente");
//session_register("idgrupo");
include("pconexionbase.php");
mysql_select_db($database_sala, $sala);
//$_POST['grupito'] ="0"; $_POST['odigomateria'] ="0";$_POST['odigodocente']="0";
?>
<script language="javascript">
function enviar()
	{
	 document.inscripcion.submit();
	}
</script>
<html>
<head>
<title>evaluacion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
</head>  
<body>
<form name="inscripcion" method="post" action="">
 <?php 
 $ddd="select distinct e.codigocarrera,c.nombrecarrera
from  respuestas r,carrera c,estudiante e 
where r.codigoperiodo='20081' and 
e.codigoestudiante=r.codigoestudiante
and e.codigocarrera = c.codigocarrera";
//echo $ddd;
	  $dsultado=mysql_query($ddd,$sala)or die("$ddd".mysql_error());
		 //echo $query_data;
		 //exit();
		 //$data = mysql_query($query_data, $sala) 
		 //$totalRows_data = mysql_num_rows($data);
		 $drow_data = mysql_fetch_assoc($dsultado);
		 $posicion = $_POST['codigocarrera'];
		 //echo $posicion;
		 ?>
<div align="center" class="Estilo3">
	<table width="586" align="center" border="0">
      <tr> 
        <td><div align="center"><img src="<?php echo $posicion?>.jpg"></div></td>
      </tr>
    </table>
<?php


if ($drow_data == "")
{
echo "hola";
} 
else
{         
?>

    </p>
</div>
  <table width="586" height="200" align="center" background="borde.jpg">
    <tr> 
      <td> 

        <table width="95%" border="0" align="center" cellpadding="3" bordercolor="#ffffff">
          <tr bgcolor='#FFFFFF'> 
            <td class="Estilo2 Estilo4">&nbsp;Fecha de la Solicitud:</td>
            <td class="Estilo1"><?php echo date("j-n-Y g:i",time())?>&nbsp; <input name="hora" type="hidden" id="hora3" value="<?php echo time()?>"> 
              <span class="Estilo16"> </span></td>
          </tr>
          <tr bgcolor='#FFFFFF'> 
            <td class="Estilo2">&nbsp;Facultad</td>
            <td class="Estilo1"><select name="codigocarrera" id="select4" onChange="enviar()">
              <option value="0" <?php if (!(strcmp("0", $_POST['codigocarrera']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
      do {  
?>
              <option value="<?php echo $drow_data['codigocarrera']?>"<?php if (!(strcmp($drow_data['codigocarrera'], $_POST['codigocarrera']))) {echo "SELECTED";} ?>><?php echo $drow_data['nombrecarrera'];?></option>
              <?php
				
      } while ($drow_data = mysql_fetch_assoc($dsultado));
		  $rows = mysql_num_rows($dsultado);
		  if($rows > 0) 
		  {
			  mysql_data_seek($dsultado, 0);
			  $drow_data = mysql_fetch_assoc($dsultado);
		  }
		
		

	//$posicion = $_POST['codigocarrera'];
	//echo "<h1>$posicion</h1>";
	
	
		 
?>
            </select></td>
			<?php 
			//echo $_POST['codigocarrera'];
        if ($_POST['codigocarrera'] <> 0)
         {  // if 1  
			$fecha = date("Y-m-d G:i:s",time());
			$_SESSION['codigodocente']= $_POST['odigodocente'];
			//echo $_POST['odigodocente'];
			$query_car = "select distinct d.nombredocente,d.apellidodocente,d.numerodocumento,e.codigocarrera,c.nombrecarrera 
			from docente d,respuestas r,grupo g,evafacultad e,carrera c
			where r.codigoperiodo='20081' and
			r.codigodocente=d.numerodocumento
			and d.numerodocumento=g.numerodocumento
			and g.idgrupo=r.idgrupo
			and r.codigoestudiante=e.codigoestudiante
			and e.codigocarrera='".$_POST['codigocarrera']."'
			and c.codigocarrera=e.codigocarrera
			order by d.nombredocente";
			//echo $query_car;
			$car = mysql_query($query_car, $sala) or die(mysql_error());
			//$row_car = mysql_fetch_assoc($car);
			//$totalRows_car = mysql_num_rows($car);
			
       }
?>
            
          </tr>
          <tr bgcolor='#FFFFFF'> 
            <td class="Estilo2">&nbsp;Docente Evaluado:</td>
            <td class="Estilo1"><select name="odigodocente" id="select6" onChange="enviar()">
                <?php
if(!isset($_POST['odigodocente']))
{
	$_POST['odigodocente'] = "0";
}
?>
                <option value="0" <?php if (!(strcmp("0", $_POST['odigodocente']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
             do {  
?>
                <option value="<?php echo $row_car['numerodocumento']?>"<?php if (!(strcmp($row_car['numerodocumento'], $_POST['odigodocente']))) {echo "SELECTED";} ?>><?php echo $row_car['nombredocente']; echo $row_car['apellidodocente'];?></option>
                <?php
				
				} while ($row_car = mysql_fetch_assoc($car));
				  $rows = mysql_num_rows($car);
				  if($rows > 0) {
					  mysql_data_seek($car, 0);
					  $row_car = mysql_fetch_assoc($car);
				  }
				  $paz=3;
?>
              </select> </td>
          </tr>
          <tr bgcolor='#FFFFFF'> 
           
            
          </tr>
        </table>
		
        <br> 
        
      </td>
    </tr>
  </table>
      
              <?php 
			  //echo $_POST['odigodocente'];
        if ($_POST['odigodocente'] <> 0)
         {  // if 1  
			$fecha = date("Y-m-d G:i:s",time());
			$_SESSION['codigodocente']= $_POST['odigodocente'];
			//echo $_POST['odigodocente'];
			$query_ddd = "SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente,m.nombremateria,m.codigomateria FROM docente d, respuestas r,materia m where r.codigoperiodo='20081' and d.numerodocumento=r.codigodocente and m.codigomateria=r.codigomateria and r.codigodocente='".$_POST['odigodocente']."' ORDER BY m.nombremateria";
			//echo $query_car;
			$ddd = mysql_query($query_ddd, $sala) or die(mysql_error());
			$row_ddd = mysql_fetch_assoc($ddd);
			$totalRows_ddd = mysql_num_rows($ddd);
       }
?>
             
  <p align="center" class="style1">
    <input name="docenteanterior" type="hidden" value="<?php echo $_POST['odigodocente']?>">
  </p>
</form>   
 
<?php
include("pconexionbase.php");
 mysql_select_db($database_sala, $sala);
//$nom=$aest['nombredocente'];
//$ape=$aest['apellidodocente'];
//$li=$_GET['no'];
$li = $_SESSION['codigodocente'];
//echo "aqui esta codigo docente".$li;
$minom=$row_data['nombredocente'];
//echo $minom;
$miape=$row_data['apellidodocente'];
$digo=$_SESSION['codigofacultad'];
//echo $digo;
$oon=$row_car['nombremateria'];
$fa=$_GET['ggg'];
//$yui=$_GET['rdi'];
//$yui= $_POST['grupito'];
$yui = $_SESSION['idgrupo'];
//echo $paz;
$pie=$_POST['odigomateria'];
//echo $pie;

//echo "$li";
//echo "aqui esta $li";
//echo "aqui esta  $yui";

//echo "materia".$_POST['odigomateria'];
//echo " grupo".$_POST['grupito'];
//echo "codigodocente".$_POST['odigodocente'];
$vali=$_POST['docenteanterior'];
//echo "codigodocenteanterior".$_POST['docenteanterior'];


if(($_POST['codigocarrera']!="0")) 
{
$sql_horario= "SELECT  horainicial,horafinal FROM horario where idgrupo='$yui' ";
$resultahorario=mysql_query($sql_horario,$sala);
$filahorario=mysql_fetch_array($resultahorario);
//echo $codicente;
/*$sql_nomfacultad="select nombreprograma from programas where codigoprograma = '$codiprograma'";
$resultadonomfac=mysql_query($sql_nomfacultad,$sala2);
$filanomfacultad = mysql_fetch_array($resultadonomfac);
$sql_nomdocente="select nombredocente from docentes where codigodocente ='$codicente'";
$resultadonomdocente=mysql_query($sql_nomdocente,$sala2);
$filanomdocente = mysql_fetch_array($resultadonomdocente);
$sql_asignatura="SELECT distinct codigomateria  FROM resultados where codigodocente = '$codicente'";
$resultadoasignatura=mysql_query($sql_asignatura,$sala2);*/

?>
<font face="tahoma"> 
<?php 





//echo "aqui va el  codigo de la materia:".$filamateria['codigomateria'];


$sql_gravo= "SELECT  gravo  FROM totalresul where grupo = '$yui' and codigodocente = '$li' and codigomateria = '$pie'";
$agravo=mysql_query($sql_gravo,$sala);
@$filgravo=mysql_num_rows($agravo);


$cunt=1;

if(($filgravo==$cunt))
{
//<p align="center"><font color="#0033FF" face="Times New Roman, Times, serif"><strong><font size="7">ya miraste este docente </font></strong>.</font></p> esto va dentro del if pilas
?>
<?php
}
else
{

 //$sql="INSERT INTO resultados values('".$fila['codigomateria']."','".$insercion2rp1."','$codigoest2','".$fila['codigodocente."',4,5,6,7,8,9,0,1,2,3)";
		$grrr="INSERT INTO totalresul values('$minom','$miape','$li','$oon','$yui','$np1','$np2','$np3','$np4','$np5','$np6','$np7','$np8','$np9','$tnp','1','$pie','$digo')"; 
		mysql_query($grrr,$sala);

  
     //echo "ya miro este docente sandrita";
   		 
}		  
?>
</font>
<table width="89%"  border="1">
  <tr>
    <td width="24%"><strong>NOMBRE DOCENTE </strong></td>
    <td width="28%"><strong>GRUPOS</strong></td>
    <td width="11%"><strong>ALUMNOS QUE EVALUARON </strong></td>
    <td width="37%"><strong>NOTA</strong></td>
  </tr>
  <?php
  //include("pconexionbase.php");
  //$query_car = "select distinct d.nombredocente,d.apellidodocente,d.numerodocumento,e.codigocarrera,c.nombrecarrera 
			//from docente d,respuestas r,grupo g,evafacultad e,carrera c
			//where r.codigoperiodo='20081' and
			//r.codigodocente=d.numerodocumento
			//and d.numerodocumento=g.numerodocumento
			//and g.idgrupo=r.idgrupo
			//and r.codigoestudiante=e.codigoestudiante
			//and e.codigocarrera='".$_POST['codigocarrera']."'
			//and c.codigocarrera=e.codigocarrera
			//order by d.nombredocente";
			echo "carrera".$_POST['codigocarrera'];
			//echo $query_car;
			$car = mysql_query($query_car, $sala) or die(mysql_error());
			//$row_car = mysql_fetch_assoc($car);
			//$totalRows_car = mysql_num_rows($car);
  while ($fcar=mysql_fetch_array($car))
		  {
		  $tnp=0; $tnp1=0;$tnp2=0;$tnp3=0;$tnp4=0;$tnp5=0;$tnp6=0;$tnp7=0;$tnp8=0;$tnp9=0;$porcenep1=0;$porcenbp1=0;$porcendp1=0;$porcenep2=0;$porcenbp2=0;$porcendp2=0;$porcenep3=0;$porcenbp3=0;$porcendp3=0;$porcenep4=0;$porcenbp4=0;$porcendp4=0;$porcenep5=0;$porcenbp5=0;$porcendp5=0;$porcenep6=0;$porcenbp6=0;$porcendp6=0;$porcenep7=0;$porcenbp7=0;$porcendp7=0;$porcenep8=0;$porcenbp8=0;$porcendp8=0;$porcenep9=0;$porcenbp9=0;$porcendp9=0;
			$numnbt=$fcar['numerodocumento'];
			
			$query_grup= "SELECT DISTINCT idgrupo FROM respuestas where codigoperiodo='20081' and codigodocente = '40442771'";
			$grup=mysql_query($query_grup,$sala);
			$contagrup=0;
			while ($totalRows_grup=mysql_fetch_array($grup))
				{
				$contagrup++;

				}
//echo "numero degrupos".$contagrup;

$sql_noencuestas= "SELECT codigoestudiante  FROM respuestas where codigoperiodo=20081 and codigodocente = '40442771'";
$resultadonoencuestas=mysql_query($sql_noencuestas,$sala);
$contanoencuestas=0;
while ($filanoencuestas=mysql_fetch_array($resultadonoencuestas))
{
$contanoencuestas++;
}
//echo "codigodocente".$numnbt;

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp1a= "SELECT codigoestudiante  FROM respuestas where codigoperiodo=20081 and codigodocente = '40442771' and resp1 = 'a'";
$resultadorp1a=mysql_query($sql_rp1a,$sala);
$contarp1e=0;
while ($filarp1e=mysql_fetch_array($resultadorp1a))
{
$contarp1a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep1 =($contarp1a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp1p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081 and codigodocente = '40442771' and resp1 = 'p'";
$resultadorp1p=mysql_query($sql_rp1p,$sala);
$contarp1b=0;
while ($filarp1b=mysql_fetch_array($resultadorp1p))
{
$contarp1p++;
}
//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;
$porcenbp1=($contarp1p/$contanoencuestas)*100;

//
$sql_rp1d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081 and codigodocente = '40442771' and resp1 = 'd'";
$resultadorp1d=mysql_query($sql_rp1d,$sala);
$contarp1d=0;
while ($filarp1d=mysql_fetch_array($resultadorp1d))
{
$contarp1d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
$porcendp1=($contarp1d/$contanoencuestas)*100;

$np1=(($porcenep1*44)+($porcenbp1*32)+($porcendp1*24))/1000;
//


//2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222
$sql_rp2a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp2 = 'a'";
$resultadorp2a=mysql_query($sql_rp2a,$sala);
$contarp2e=0;
while ($filarp2e=mysql_fetch_array($resultadorp2a))
{
$contarp2a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep2 =($contarp2a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp2p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp2 = 'p'";
$resultadorp2p=mysql_query($sql_rp2p,$sala);
$contarp2b=0;
while ($filarp2b=mysql_fetch_array($resultadorp2p))
{
$contarp2p++;
}
//echo "el numero de personas que respondieron b a la pregunta 2 son:".$contarp2b;
$porcenbp2=($contarp2p/$contanoencuestas)*100;


//
$sql_rp2d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp2 = 'd'";
$resultadorp2d=mysql_query($sql_rp2d,$sala);
$contarp2d=0;
while ($filarp2d=mysql_fetch_array($resultadorp2d))
{
$contarp2d++;
}
//echo "el numero de personas que respondieron d a la pregunta 2 son:".$contarp2b;
$porcendp2=($contarp2d/$contanoencuestas)*100;

$np2=(($porcenep2*44)+($porcenbp2*32)+($porcendp2*24))/1000;
//

//333333333333333333333333333333333333333333333333333333333333333333333333333333333
$sql_rp3a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp3 = 'a'";
$resultadorp3a=mysql_query($sql_rp3a,$sala);
$contarp3e=0;
while ($filarp3e=mysql_fetch_array($resultadorp3a))
{
$contarp3a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep3 =($contarp3a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp3p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp3 = 'p'";
$resultadorp3p=mysql_query($sql_rp3p,$sala);
$contarp3b=0;
while ($filarp3b=mysql_fetch_array($resultadorp3p))
{
$contarp3p++;
}
//echo "el numero de personas que respondieron b a la pregunta 3 son:".$contarp3b;
$porcenbp3=($contarp3p/$contanoencuestas)*100;


//
$sql_rp3d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp3 = 'd'";
$resultadorp3d=mysql_query($sql_rp3d,$sala);
$contarp3d=0;
while ($filarp3d=mysql_fetch_array($resultadorp3d))
{
$contarp3d++;
}
//echo "el numero de personas que respondieron d a la pregunta 3 son:".$contarp3b;
$porcendp3=($contarp3d/$contanoencuestas)*100;

$np3=(($porcenep3*44)+($porcenbp3*32)+($porcendp3*24))/1000;
//

//
//444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
$sql_rp4a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp4 = 'a'";
$resultadorp4a=mysql_query($sql_rp4a,$sala);
$contarp4e=0;
while ($filarp4e=mysql_fetch_array($resultadorp4a))
{
$contarp4a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep4 =($contarp4a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp4p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp4 = 'p'";
$resultadorp4p=mysql_query($sql_rp4p,$sala);
$contarp4b=0;
while ($filarp4b=mysql_fetch_array($resultadorp4p))
{
$contarp4p++;
}
//echo "el numero de personas que respondieron b a la pregunta 4 son:".$contarp4b;
$porcenbp4=($contarp4p/$contanoencuestas)*100;

//
$sql_rp4d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp4 = 'd'";
$resultadorp4d=mysql_query($sql_rp4d,$sala);
$contarp4d=0;
while ($filarp4d=mysql_fetch_array($resultadorp4d))
{
$contarp4d++;
}
//echo "el numero de personas que respondieron d a la pregunta 4 son:".$contarp4b;
$porcendp4=($contarp4d/$contanoencuestas)*100;
$np4=(($porcenep4*44)+($porcenbp4*32)+($porcendp4*24))/1000;
//

//
//55555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555
//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp5;
$sql_rp5a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp5 = 'a'";
$resultadorp5a=mysql_query($sql_rp5a,$sala);
$contarp5e=0;
while ($filarp5e=mysql_fetch_array($resultadorp5a))
{
$contarp5a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep5 =($contarp5a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp5p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp5 = 'p'";
$resultadorp5p=mysql_query($sql_rp5p,$sala);
$contarp5b=0;
while ($filarp5b=mysql_fetch_array($resultadorp5p))
{
$contarp5p++;
}
//echo "el numero de personas que respondieron b a la pregunta 5 son:".$contarp5b;
$porcenbp5=($contarp5p/$contanoencuestas)*100;

//
$sql_rp5d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp5 = 'd'";
$resultadorp5d=mysql_query($sql_rp5d,$sala);
$contarp5d=0;
while ($filarp5d=mysql_fetch_array($resultadorp5d))
{
$contarp5d++;
}
//echo "el numero de personas que respondieron d a la pregunta 5 son:".$contarp5b;
$porcendp5=($contarp5d/$contanoencuestas)*100;

$np5=(($porcenep5*44)+($porcenbp5*32)+($porcendp5*24))/1000;
//

//66666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp6a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp6 = 'a'";
$resultadorp6a=mysql_query($sql_rp6a,$sala);
$contarp6e=0;
while ($filarp6e=mysql_fetch_array($resultadorp6a))
{
$contarp6a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep6 =($contarp6a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp6p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp6 = 'p'";
$resultadorp6p=mysql_query($sql_rp6p,$sala);
$contarp6b=0;
while ($filarp6b=mysql_fetch_array($resultadorp6p))
{
$contarp6p++;
}
//echo "el numero de personas que respondieron b a la pregunta 6 son:".$contarp6b;
$porcenbp6=($contarp6p/$contanoencuestas)*100;

//
$sql_rp6d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp6 = 'd'";
$resultadorp6d=mysql_query($sql_rp6d,$sala);
$contarp6d=0;
while ($filarp6d=mysql_fetch_array($resultadorp6d))
{
$contarp6d++;
}
//echo "el numero de personas que respondieron d a la pregunta 6 son:".$contarp6b;
$porcendp6=($contarp6d/$contanoencuestas)*100;
$np6=(($porcenep6*44)+($porcenbp6*32)+($porcendp6*24))/1000;
//


//777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp5;
$sql_rp7a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp7 = 'a'";
$resultadorp7a=mysql_query($sql_rp7a,$sala);
$contarp7e=0;
while ($filarp7e=mysql_fetch_array($resultadorp7a))
{
$contarp7a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep7 =($contarp7a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp7p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp7 = 'p'";
$resultadorp7p=mysql_query($sql_rp7p,$sala);
$contarp7b=0;
while ($filarp7b=mysql_fetch_array($resultadorp7p))
{
$contarp7p++;
}
//echo "el numero de personas que respondieron b a la pregunta 7 son:".$contarp7b;
$porcenbp7=($contarp7p/$contanoencuestas)*100;

//
$sql_rp7d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp7 = 'd'";
$resultadorp7d=mysql_query($sql_rp7d,$sala);
$contarp7d=0;
while ($filarp7d=mysql_fetch_array($resultadorp7d))
{
$contarp7d++;
}
//echo "el numero de personas que respondieron d a la pregunta 7 son:".$contarp7b;
$porcendp7=($contarp7d/$contanoencuestas)*100;
$np7=(($porcenep7*44)+($porcenbp7*32)+($porcendp7*24))/1000;

//888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp8a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp8 = 'a'";
$resultadorp8a=mysql_query($sql_rp8a,$sala);
$contarp8e=0;
while ($filarp8e=mysql_fetch_array($resultadorp8a))
{
$contarp8a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep8 =($contarp8a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp8p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp8 = 'p'";
$resultadorp8p=mysql_query($sql_rp8p,$sala);
$contarp8b=0;
while ($filarp8b=mysql_fetch_array($resultadorp8p))
{
$contarp8p++;
}
//echo "el numero de personas que respondieron b a la pregunta 8 son:".$contarp8b;
$porcenbp8=($contarp8p/$contanoencuestas)*100;

//
$sql_rp8d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp8 = 'd'";
$resultadorp8d=mysql_query($sql_rp8d,$sala);
$contarp8d=0;
while ($filarp8d=mysql_fetch_array($resultadorp8d))
{
$contarp8d++;
}
//echo "el numero de personas que respondieron d a la pregunta 8 son:".$contarp8b;
$porcendp8=($contarp8d/$contanoencuestas)*100;
$np8=(($porcenep8*44)+($porcenbp8*32)+($porcendp8*24))/1000;
//

//9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp9a= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp9 = 'a'";
$resultadorp9a=mysql_query($sql_rp9a,$sala);
$contarp9e=0;
while ($filarp9e=mysql_fetch_array($resultadorp9a))
{
$contarp9a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep9 =($contarp9a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp9p= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp9 = 'p'";
$resultadorp9p=mysql_query($sql_rp9p,$sala);
$contarp9b=0;
while ($filarp9b=mysql_fetch_array($resultadorp9p))
{
$contarp9p++;
}
//echo "el numero de personas que respondieron b a la pregunta 9 son:".$contarp9b;
$porcenbp9=($contarp9p/$contanoencuestas)*100;

//
$sql_rp9d= "SELECT  codigoestudiante  FROM respuestas where codigoperiodo=20081  and codigodocente = '40442771' and resp9 = 'd'";
$resultadorp9d=mysql_query($sql_rp9d,$sala);
$contarp9d=0;
while ($filarp9d=mysql_fetch_array($resultadorp9d))
{
$contarp9d++;
}
//echo "el numero de personas que respondieron d a la pregunta 9 son:".$contarp9b;
$porcendp9=($contarp9d/$contanoencuestas)*100;
$np9=(($porcenep9*44)+($porcenbp9*32)+($porcendp9*24))/1000;
//

//TOTAL DE LA NOTA DE ESTA EVALUACION POR PROMEDIO
$tnp=($np1+$np2+$np3+$np4+$np5+$np6+$np7+$np8+$np9)/9;
		  ?>
    <tr>
    <td><?php echo  $fcar['nombredocente']; ?> <?php echo  $fcar['apellidodocente']; ?></td>
    <td><?php echo  $contagrup; ?></td>
    <td><font size="1" face="tahoma"><?php echo $contanoencuestas ?></font></td>
    <td><font size="1" face="tahoma"><strong class="Estilo4"><?php printf ( "%.2f", $tnp) ; echo a;?><?php printf ( "%.2f", $tnp1) ; echo b;?><?php printf ( "%.2f", $tnp2) ; echo c;?><?php printf ( "%.2f", $tnp3) ; echo d;?><?php printf ( "%.2f", $tnp4) ; echo e;?><?php printf ( "%.2f", $tnp5) ; echo f;?><?php printf ( "%.2f", $tnp6) ; echo g;?><?php printf ( "%.2f", $tnp7) ; echo h;?><?php printf ( "%.2f", $tnp8) ; echo i;?><?php printf ( "%.2f", $tnp9) ; echo j;?></strong></font></td>
  </tr>
   <?php }?>
</table> 
<table width="586" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#000000">
  <tr> 
      
    <td width="351" height="23" class="style1"><div align="center"><font size="2" face="tahoma"><strong><font size="1">NUMERO DE GRUPOS </font> : <span class="style1"><strong><span class="style3"> 
        <?php $comiensoh = $filahorario['horainicial']; echo $contagrup;?>
        <font size="1"> </font></span></strong></span></strong></font></div></td>
      
    <td width="226"><div align="center"><font size="1" face="tahoma"> </font>    <font size="1" face="tahoma"><strong>NOTA TOTAL = </strong><strong class="Estilo4"><?php printf ( "%.2f", $tnp) ; ?></strong></font></div></td>
  </tr>
    <tr> 
      
    <td> <div align="center"><font size="1" face="tahoma"><strong class="style1">N&Uacute;MERO 
        DE ESTUDIANTES QUE REALIZARON LA EVALUARON: </strong> </font></div></td>
      <td><div align="center"><font size="1" face="tahoma"><?php echo $contanoencuestas ?></font></div></td>
    </tr>
</table>
  
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="151"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="304"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="125"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma"><strong class="style1 style7">ASIGNATURA</strong></font></td>
    <td><font size="1" face="tahoma">El aprendizaje logrado en el curso es bueno? </font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep1) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np1) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp1) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R</strong> <span class="style8"><?php printf ( "%.2f", $porcendp1) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="151"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="323"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="106"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="151"><font size="1" face="tahoma"><strong class="style1 style7"> 
      CUMPLIMIENTO DE LOS PLANES DE TRABAJO </strong> </font></td>
    <td width="323"><font size="1" face="tahoma">El docente umple con el plan de trabajo propuesto para el desarrollo de la asignatura?</font></td>
    <td width="106"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong><span class="style1 style7"><?php printf ( "%.2f", $porcenep2) ; ?></span> 
        <span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np2) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"><?php printf ( "%.2f", $porcenbp2) ; ?> 
        %</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong><span class="style8"><?php printf ( "%.2f", $porcendp2) ; ?></span> 
        <span class="style8">%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="150"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="325"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="105"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="150"><font size="1" face="tahoma"><strong class="style1 style7">DESTREZAS  PEDAGÓGICA</strong></font></td>
    <td width="325"><font size="1" face="tahoma">Las destrezas pedag&oacute;gicas del docente son las adecuadas para el desarrollo de la asignatura?</font></td>
    <td width="105"><div align="center"><font size="1" face="tahoma"><strong>E</strong><span class="style1 style7"> 
        <?php printf ( "%.2f", $porcenep3) ; ?></span><strong> </strong> <span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np3) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp3) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp3) ; ?>%</span></font></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="151"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="329"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="100"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="151"><font size="1" face="tahoma"><strong class="style1 style7">PUNTUALIDAD EN COMPROMISOS ACAD&Eacute;MICOS</strong>&nbsp; </font></td>
    <td width="329"><font size="1" face="tahoma">El docente cumple con las actividades acad&eacute;micas definidas?</font></td>
    <td width="100"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep4) ; ?></span><span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np4) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp4) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp4) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="148"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="333"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="99"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="148"><font size="1" face="tahoma"> <strong class="style1 style7">RELACIONES INTER-PERSONALES</strong> </font></td>
    <td width="333"><font size="1" face="tahoma">La relaci&oacute;n personal establecida entre los estudiantes y el docente, es adecuada para el desarrollo de la asignatura?</font></td>
    <td width="99"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep5) ; ?></span><span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np5) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp5) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp5) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="147"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="336"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="97"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="147"><font size="1" face="tahoma"><strong class="style1 style7">APOYO AL TRABAJO DE LOS ESTUDIANTES</strong>&nbsp; </font></td>
    <td width="336"><font size="1" face="tahoma">El estudiante encuentra el apoyo necesario por parte del docente en su proceso de aprendizaje?</font></td>
    <td width="97"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep6) ; ?></span><span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np6) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp6) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp6) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="145"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="338"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="97"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="145"><font size="1" face="tahoma"><strong class="style1 style7">APOYO A LA INVES-TIGACIÓN</strong>&nbsp; </font></td>
    <td width="338"><font size="1" face="tahoma">El docente promociona de la formaci&oacute;n investigativa?</font></td>
    <td width="97"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep7) ; ?></span><span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np7) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp7) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp7) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="145"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="342"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="93"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="145"><font size="1" face="tahoma"><strong class="style1 style7">EVALUACIÓN DEL  APRENDIZAJE </strong></font></td>
    <td width="342"><font size="1" face="tahoma">El sistema de evaluaci&oacute;n aplicado promueve la formaci&oacute;n profesional?</font></td>
    <td width="93"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep8) ; ?></span><span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np8) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp8) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp8) ; ?>%</span></font></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="142"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="358"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="80"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
  </tr>
  <tr> 
    <td width="142"><font size="1" face="tahoma"><strong class="style1 style7">RECURSOS</strong>&nbsp; </font></td>
    <td width="358"><font size="1" face="tahoma">El sistema de evaluaci&oacute;n aplicado promueve la formaci&oacute;n profesional?</font></td>
    <td width="80"><div align="center"><font size="1" face="tahoma"><strong>E 
        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep9) ; ?></span><span class="style1 style7">%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np9) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp9) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp9) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="tahoma"></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="586" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      
    <td bgcolor="#C5D5D6" class="style2"><div align="center"><font size="1" face="tahoma"><strong>OBSERVACIONES:</strong></font></div></td>
    </tr>
    <tr> 
      <td> <font size="1" face="tahoma"> 
        <?php 
$obse = "SELECT observaciones FROM respuestas where codigoperiodo=20081 and codigodocente = '40442771'";
$obseq=mysql_query($obse,$sala);
//$obsercon=0;
$filob=mysql_fetch_array($obseq);
while ($filob=mysql_fetch_array($obseq))
{
echo $filob['observaciones']."<br>";
//$ovsercon++;
}

	
	?>
	<form name="form1" method="post" action="">
  <div align="center">
    <input name="imprimir" type="button" id="buton" value="Imprimir" onClick="print()">
  </div>
</form>
        </font></tr>
</table>
  
<font size="1" face="tahoma"> 
<?php }
  
  else
  		{ echo "DEBEN ESTAR LLENOS  TODOS LOS CAMPO";
		
  		}?>
<?php } ?>
</font> 

<p align="center">&nbsp;</p>
  <p>&nbsp; </p>
  <p align="center" class="style1">&nbsp; </p>
</div>
</body>
</html>






