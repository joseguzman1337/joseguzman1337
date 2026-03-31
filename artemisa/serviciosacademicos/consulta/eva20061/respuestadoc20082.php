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
where r.codigoperiodo='20082' and 
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
			//$_SESSION['codigodocente']= $_POST['odigodocente'];
			//echo $_POST['odigodocente'];
			$query_car = "select distinct d.nombredocente,d.apellidodocente,d.numerodocumento,e.codigocarrera,c.nombrecarrera 
			from docente d,respuestas r,grupo g,evafacultad e,carrera c
			where r.codigoperiodo='20082' and
			r.codigodocente=d.numerodocumento
			and d.numerodocumento=g.numerodocumento
			and g.idgrupo=r.idgrupo
			and r.codigoestudiante=e.codigoestudiante
			and e.codigocarrera='".$_POST['codigocarrera']."'
			and c.codigocarrera=e.codigocarrera
			order by d.nombredocente";
			//echo $query_car;
			$car = mysql_query($query_car, $sala) or die(mysql_error());
			$row_car = mysql_fetch_assoc($car);
			$totalRows_car = mysql_num_rows($car);
			
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
				  
?>
              </select> </td>
          </tr>
          <tr bgcolor='#FFFFFF'> 
            <td class="Estilo2">&nbsp;Materia Evaluada:</td>
            <td class="Estilo1"> 
              <?php 
			  //echo $_POST['odigodocente'];
        if ($_POST['odigodocente'] <> 0)
         {  // if 1  
			$fecha = date("Y-m-d G:i:s",time());
			$_SESSION['codigodocente']= $_POST['odigodocente'];
			//echo $_POST['odigodocente'];
			$query_ddd = "SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente,m.nombremateria,m.codigomateria FROM docente d, respuestas r,materia m where r.codigoperiodo='20082' and d.numerodocumento=r.codigodocente and m.codigomateria=r.codigomateria and r.codigodocente='".$_POST['odigodocente']."' ORDER BY m.nombremateria";
			//echo $query_car;
			$ddd = mysql_query($query_ddd, $sala) or die(mysql_error());
			$row_ddd = mysql_fetch_assoc($ddd);
			$totalRows_ddd = mysql_num_rows($ddd);
       }
?>
              <select name="odigomateria" id="select12" onChange="enviar()">
                <?php
if(!isset($_POST['odigomateria']))
{
	$_POST['odigomateria'] = "0";
}
?>
                <option value="0" <?php if (!(strcmp("0", $_POST['odigomateria']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
             do {  
?>
                <option value="<?php echo $row_ddd['codigomateria']?>"<?php if (!(strcmp($row_ddd['codigomateria'], $_POST['odigomateria']))) {echo "SELECTED";} ?>><?php echo $row_ddd['nombremateria']?></option>
                <?php
				
				} while ($row_ddd = mysql_fetch_assoc($ddd));
				  $rows = mysql_num_rows($ddd);
				  if($rows > 0) {
					  mysql_data_seek($ddd, 0);
					  $row_ddd = mysql_fetch_assoc($ddd);
				  }
				  
?>
              </select></td>
          </tr>
          <tr bgcolor='#FFFFFF'> 
            <td class="Estilo2">&nbsp;Grupo que Evaluo:</td>
            <td class="Estilo1"><span class="Estilo16"> 
              <?php 
			  
        if ($_POST['odigomateria'] <> 0)
         {  // if 1  
			$query_periodo = "SELECT DISTINCT idgrupo FROM respuestas where codigoperiodo='20082' and codigodocente='".$_POST['odigodocente']."' and codigomateria='".$_POST['odigomateria']."' ORDER BY idgrupo";
			$periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");
			$totalRows_periodo = mysql_num_rows($periodo);
			$row_periodo = mysql_fetch_assoc($periodo);
       }
?>
              <select name="grupito" id="select13" onChange="enviar()">
                <?php
if(!isset($_POST['grupito']))
{
	$_POST['grupito'] = "0";
}
?>
                <option value="0"<?php if (!(strcmp("0", $_POST['grupito']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_periodo['idgrupo']?>"<?php if (!(strcmp($row_periodo['idgrupo'], $_POST['grupito']))) {echo "SELECTED";} ?>><?php echo $row_periodo['idgrupo']?></option>
                <?php
							
} while ($row_periodo = mysql_fetch_assoc($periodo));
  $rows = mysql_num_rows($periodo);
  if($rows > 0) {
      mysql_data_seek($periodo, 0);
	  $row_periodo = mysql_fetch_assoc($periodo);
  }
  $paz=3;
?>
              </select>
              </span> </td>
          </tr>
        </table>
        <br> 
        <?php 
  if ($_POST['grupito'] <> 0)
    {
	
	$_SESSION['idgrupo']= $_POST['grupito'];
	//echo $_POST['grupito'];
	
	
		} 
?>
      </td>
    </tr>
  </table>
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
//echo $li;
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
//echo "codigodocenteanterior$vali".$_POST['odigodocente'];


if(($_POST['grupito']!="0" and $_POST['odigomateria']!="0" and $_POST['odigodocente']!="0") and ($vali == $_POST['odigodocente'])) 
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

$sql_noencuestas= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li'";
$resultadonoencuestas=mysql_query($sql_noencuestas,$sala);
$contanoencuestas=0;
while ($filanoencuestas=mysql_fetch_array($resultadonoencuestas))
{
$contanoencuestas++;
}
//echo "el numero de personas que respondieron la pregunta 1 son:".$conttrp1;
$sql_rp1t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp1 = 't'";
$resultadorp1t=mysql_query($sql_rp1t,$sala);
$contarp1t=0;
while ($filarp1t=mysql_fetch_array($resultadorp1t))
{
$contarp1t++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1t;
@$porcentp1 =($contarp1t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp1a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp1 = 'a'";
$resultadorp1a=mysql_query($sql_rp1a,$sala);
$contarp1e=0;
while ($filarp1e=mysql_fetch_array($resultadorp1a))
{
$contarp1a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep1 =($contarp1a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp1p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp1 = 'p'";
$resultadorp1p=mysql_query($sql_rp1p,$sala);
$contarp1b=0;
while ($filarp1b=mysql_fetch_array($resultadorp1p))
{
$contarp1p++;
}
//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;
@$porcenbp1=($contarp1p/$contanoencuestas)*100;
$np1=(($porcentp1*100)+($porcenep1*75)+($porcenbp1*50)+($porcendp1*25))/2000;
//
$sql_rp1d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp1 = 'd'";
$resultadorp1d=mysql_query($sql_rp1d,$sala);
$contarp1d=0;
while ($filarp1d=mysql_fetch_array($resultadorp1d))
{
$contarp1d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
@$porcendp1=($contarp1d/$contanoencuestas)*100;
//

$sql_rp1exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa1 = 'e'";
$resp1exea=mysql_query($sql_rp1exea,$sala);
$contarp1exea=0;
while ($filp1exea=mysql_fetch_array($resp1exea))
{
$contarp1exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 1 son:".$contarp1exe;
@$porcexeap1=($contarp1exea/$contanoencuestas)*100;
//
$sql_rp1exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb1 = 'e'";
$resp1exeb=mysql_query($sql_rp1exeb,$sala);
$contarp1exeb=0;
while ($filp1exeb=mysql_fetch_array($resp1exeb))
{
$contarp1exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 1 son:".$contarp1exe;
@$porcexebp1=($contarp1exeb/$contanoencuestas)*100;
//
$sql_rp1exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc1 = 'e'";
$resp1exec=mysql_query($sql_rp1exec,$sala);
$contarp1exec=0;
while ($filp1exec=mysql_fetch_array($resp1exec))
{
$contarp1exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 1 son:".$contarp1desc;
@$porcexecp1=($contarp1exec/$contanoencuestas)*100;
//
//
$sql_rp1buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa1 = 'b'";
$resp1buna=mysql_query($sql_rp1buna,$sala);
$contarp1buna=0;
while ($filp1buna=mysql_fetch_array($resp1buna))
{
$contarp1buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 1 son:".$contarp1exe;
@$porcbunap1=($contarp1buna/$contanoencuestas)*100;
//
$sql_rp1bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb1 = 'b'";
$resp1bunb=mysql_query($sql_rp1bunb,$sala);
$contarp1bunb=0;
while ($filp1bunb=mysql_fetch_array($resp1bunb))
{
$contarp1bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 1 son:".$contarp1exe;
@$porcbunbp1=($contarp1bunb/$contanoencuestas)*100;
//
$sql_rp1bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc1 = 'b'";
$resp1bunc=mysql_query($sql_rp1bunc,$sala);
$contarp1bunc=0;
while ($filp1bunc=mysql_fetch_array($resp1bunc))
{
$contarp1bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 1 son:".$contarp1desc;
@$porcbuncp1=($contarp1bunc/$contanoencuestas)*100;
//
$sql_rp1rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa1 = 'r'";
$resp1rega=mysql_query($sql_rp1rega,$sala);
$contarp1rega=0;
while ($filp1rega=mysql_fetch_array($resp1rega))
{
$contarp1rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 1 son:".$contarp1exe;
@$porcregap1=($contarp1rega/$contanoencuestas)*100;
//
$sql_rp1regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb1 = 'r'";
$resp1regb=mysql_query($sql_rp1regb,$sala);
$contarp1regb=0;
while ($filp1regb=mysql_fetch_array($resp1regb))
{
$contarp1regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 1 son:".$contarp1exe;
@$porcregbp1=($contarp1regb/$contanoencuestas)*100;
//
$sql_rp1regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc1 = 'r'";
$resp1regc=mysql_query($sql_rp1regc,$sala);
$contarp1regc=0;
while ($filp1regc=mysql_fetch_array($resp1regc))
{
$contarp1regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 1 son:".$contarp1desc;
@$porcregcp1=($contarp1regc/$contanoencuestas)*100;
//
$sql_rp1defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa1 = 'd'";
$resp1defa=mysql_query($sql_rp1defa,$sala);
$contarp1defa=0;
while ($filp1defa=mysql_fetch_array($resp1defa))
{
$contarp1defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 1 son:".$contarp1exe;
@$porcdefap1=($contarp1defa/$contanoencuestas)*100;
//
$sql_rp1defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb1 = 'd'";
$resp1defb=mysql_query($sql_rp1defb,$sala);
$contarp1defb=0;
while ($filp1defb=mysql_fetch_array($resp1defb))
{
$contarp1defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 1 son:".$contarp1exe;
@$porcdefbp1=($contarp1defb/$contanoencuestas)*100;
//
$sql_rp1defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc1 = 'd'";
$resp1defc=mysql_query($sql_rp1defc,$sala);
$contarp1defc=0;
while ($filp1defc=mysql_fetch_array($resp1defc))
{
$contarp1defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 1 son:".$contarp1desc;
@$porcdefcp1=($contarp1defc/$contanoencuestas)*100;
//
$sql_rp1nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa1 = 'n'";
$resp1nopa=mysql_query($sql_rp1nopa,$sala);
$contarp1nopa=0;
while ($filp1nopa=mysql_fetch_array($resp1nopa))
{
$contarp1nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 1 son:".$contarp1exe;
@$porcnopap1=($contarp1nopa/$contanoencuestas)*100;
//
$sql_rp1nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb1 = 'n'";
$resp1nopb=mysql_query($sql_rp1nopb,$sala);
$contarp1nopb=0;
while ($filp1nopb=mysql_fetch_array($resp1nopb))
{
$contarp1nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 1 son:".$contarp1exe;
@$porcnopbp1=($contarp1nopb/$contanoencuestas)*100;
//
$sql_rp1nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc1 = 'n'";
$resp1nopc=mysql_query($sql_rp1nopc,$sala);
$contarp1nopc=0;
while ($filp1nopc=mysql_fetch_array($resp1nopc))
{
$contarp1nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 1 son:".$contarp1desc;
@$porcnopcp1=($contarp1nopc/$contanoencuestas)*100;

//2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222

//echo "el numero de personas que respondieron la pregunta 2 son:".$conttrp2;
$sql_rp2t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp2 = 't'";
$resultadorp2t=mysql_query($sql_rp2t,$sala);
$contarp2t=0;
while ($filarp2t=mysql_fetch_array($resultadorp2t))
{
$contarp2t++;
}

//echo $sql_rp2t;
//echo "el numero de personas que respondieron e a la pregunta 2 son:".$contarp2t;
@$porcentp2 =($contarp2t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep2;
//echo $porcentp2;
//
//echo "el numero de personas que respondieron la pregunta 2 son:".$contarp2;

$sql_rp2a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp2 = 'a'";
$resultadorp2a=mysql_query($sql_rp2a,$sala);
$contarp2a=0;
while ($filarp2a=mysql_fetch_array($resultadorp2a))
{
$contarp2a++;
}
//echo $sql_rp2a;
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp2a;
@$porcenep2 =($contarp2a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep2;
//
$sql_rp2p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp2 = 'p'";
$resultadorp2p=mysql_query($sql_rp2p,$sala);
$contarp2p=0;
while ($filarp2b=mysql_fetch_array($resultadorp2p))
{
$contarp2p++;
}
//echo "el numero de personas que respondieron b a la pregunta 2 son:".$contarp2b;
@$porcenbp2=($contarp2p/$contanoencuestas)*100;
//$np2=($porcenep2+$porcenbp2)/20;
$np2=(($porcentp2*100)+($porcenep2*75)+($porcenbp2*50)+($porcendp2*25))/2000;
//
$sql_rp2d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp2 = 'd'";
$resultadorp2d=mysql_query($sql_rp2d,$sala);
$contarp2d=0;
while ($filarp2d=mysql_fetch_array($resultadorp2d))
{
$contarp2d++;
}
//echo "el numero de personas que respondieron d a la pregunta 2 son:".$contarp2b;
@$porcendp2=($contarp2d/$contanoencuestas)*100;
//

$sql_rp2exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa2 = 'e'";
$resp2exea=mysql_query($sql_rp2exea,$sala);
$contarp2exea=0;
while ($filp2exea=mysql_fetch_array($resp2exea))
{
$contarp2exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 2 son:".$contarp2exe;
@$porcexeap2=($contarp2exea/$contanoencuestas)*100;
//
$sql_rp2exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb2 = 'e'";
$resp2exeb=mysql_query($sql_rp2exeb,$sala);
$contarp2exeb=0;
while ($filp2exeb=mysql_fetch_array($resp2exeb))
{
$contarp2exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 2 son:".$contarp2exe;
@$porcexebp2=($contarp2exeb/$contanoencuestas)*100;
//
$sql_rp2exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc2 = 'e'";
$resp2exec=mysql_query($sql_rp2exec,$sala);
$contarp2exec=0;
while ($filp2exec=mysql_fetch_array($resp2exec))
{
$contarp2exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 2 son:".$contarp2desc;
@$porcexecp2=($contarp2exec/$contanoencuestas)*100;
//
//
$sql_rp2buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa2 = 'b'";
$resp2buna=mysql_query($sql_rp2buna,$sala);
$contarp2buna=0;
while ($filp2buna=mysql_fetch_array($resp2buna))
{
$contarp2buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 2 son:".$contarp2exe;
@$porcbunap2=($contarp2buna/$contanoencuestas)*100;
//
$sql_rp2bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb2 = 'b'";
$resp2bunb=mysql_query($sql_rp2bunb,$sala);
$contarp2bunb=0;
while ($filp2bunb=mysql_fetch_array($resp2bunb))
{
$contarp2bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 2 son:".$contarp2exe;
@$porcbunbp2=($contarp2bunb/$contanoencuestas)*100;
//
$sql_rp2bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc2 = 'b'";
$resp2bunc=mysql_query($sql_rp2bunc,$sala);
$contarp2bunc=0;
while ($filp2bunc=mysql_fetch_array($resp2bunc))
{
$contarp2bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 2 son:".$contarp2desc;
@$porcbuncp2=($contarp2bunc/$contanoencuestas)*100;
//
$sql_rp2rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa2 = 'r'";
$resp2rega=mysql_query($sql_rp2rega,$sala);
$contarp2rega=0;
while ($filp2rega=mysql_fetch_array($resp2rega))
{
$contarp2rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 2 son:".$contarp2exe;
@$porcregap2=($contarp2rega/$contanoencuestas)*100;
//
$sql_rp2regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb2 = 'r'";
$resp2regb=mysql_query($sql_rp2regb,$sala);
$contarp2regb=0;
while ($filp2regb=mysql_fetch_array($resp2regb))
{
$contarp2regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 2 son:".$contarp2exe;
@$porcregbp2=($contarp2regb/$contanoencuestas)*100;
//
$sql_rp2regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc2 = 'r'";
$resp2regc=mysql_query($sql_rp2regc,$sala);
$contarp2regc=0;
while ($filp2regc=mysql_fetch_array($resp2regc))
{
$contarp2regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 2 son:".$contarp2desc;
@$porcregcp2=($contarp2regc/$contanoencuestas)*100;
//
$sql_rp2defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa2 = 'd'";
$resp2defa=mysql_query($sql_rp2defa,$sala);
$contarp2defa=0;
while ($filp2defa=mysql_fetch_array($resp2defa))
{
$contarp2defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 2 son:".$contarp2exe;
@$porcdefap2=($contarp2defa/$contanoencuestas)*100;
//
$sql_rp2defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb2 = 'd'";
$resp2defb=mysql_query($sql_rp2defb,$sala);
$contarp2defb=0;
while ($filp2defb=mysql_fetch_array($resp2defb))
{
$contarp2defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 2 son:".$contarp2exe;
@$porcdefbp2=($contarp2defb/$contanoencuestas)*100;
//
$sql_rp2defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc2 = 'd'";
$resp2defc=mysql_query($sql_rp2defc,$sala);
$contarp2defc=0;
while ($filp2defc=mysql_fetch_array($resp2defc))
{
$contarp2defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 2 son:".$contarp2desc;
@$porcdefcp2=($contarp2defc/$contanoencuestas)*100;
//
$sql_rp2nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa2 = 'n'";
$resp2nopa=mysql_query($sql_rp2nopa,$sala);
$contarp2nopa=0;
while ($filp2nopa=mysql_fetch_array($resp2nopa))
{
$contarp2nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 2 son:".$contarp2exe;
@$porcnopap2=($contarp2nopa/$contanoencuestas)*100;
//
$sql_rp2nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb2 = 'n'";
$resp2nopb=mysql_query($sql_rp2nopb,$sala);
$contarp2nopb=0;
while ($filp2nopb=mysql_fetch_array($resp2nopb))
{
$contarp2nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 2 son:".$contarp2exe;
@$porcnopbp2=($contarp2nopb/$contanoencuestas)*100;
//
$sql_rp2nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc2 = 'n'";
$resp2nopc=mysql_query($sql_rp2nopc,$sala);
$contarp2nopc=0;
while ($filp2nopc=mysql_fetch_array($resp2nopc))
{
$contarp2nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 2 son:".$contarp2desc;
@$porcnopcp2=($contarp2nopc/$contanoencuestas)*100;
//
//333333333333333333333333333333333333333333333333333333333333333333333333333333333

//echo "el numero de personas que respondieron la pregunta 3 son:".$conttrp3;
$sql_rp3t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp3 = 't'";
$resultadorp3t=mysql_query($sql_rp3t,$sala);
$contarp3t=0;
while ($filarp3t=mysql_fetch_array($resultadorp3t))
{
$contarp3t++;
}
//echo "el numero de personas que respondieron e a la pregunta 3 son:".$contarp3t;
@$porcentp3 =($contarp3t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 3 e".$porcentagep3;
//echo $porcenep1;
//
//echo "el numero de personas que respondieron la pregunta 3 son:".$contarp3;

$sql_rp3a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp3 = 'a'";
$resultadorp3a=mysql_query($sql_rp3a,$sala);
$contarp3a=0;
while ($filarp3e=mysql_fetch_array($resultadorp3a))
{
$contarp3a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep3 =($contarp3a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp3p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp3 = 'p'";
$resultadorp3p=mysql_query($sql_rp3p,$sala);
$contarp3p=0;
while ($filarp3b=mysql_fetch_array($resultadorp3p))
{
$contarp3p++;
}
//echo "el numero de personas que respondieron b a la pregunta 3 son:".$contarp3b;
@$porcenbp3=($contarp3p/$contanoencuestas)*100;
//$np3=($porcenep3+$porcenbp3)/20;
$np3=(($porcentp3*100)+($porcenep3*75)+($porcenbp3*50)+($porcendp3*25))/2000;
//
$sql_rp3d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp3 = 'd'";
$resultadorp3d=mysql_query($sql_rp3d,$sala);
$contarp3d=0;
while ($filarp3d=mysql_fetch_array($resultadorp3d))
{
$contarp3d++;
}
//echo "el numero de personas que respondieron d a la pregunta 3 son:".$contarp3b;
@$porcendp3=($contarp3d/$contanoencuestas)*100;
//

$sql_rp3exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa3 = 'e'";
$resp3exea=mysql_query($sql_rp3exea,$sala);
$contarp3exea=0;
while ($filp3exea=mysql_fetch_array($resp3exea))
{
$contarp3exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 3 son:".$contarp3exe;
@$porcexeap3=($contarp3exea/$contanoencuestas)*100;
//
$sql_rp3exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb3 = 'e'";
$resp3exeb=mysql_query($sql_rp3exeb,$sala);
$contarp3exeb=0;
while ($filp3exeb=mysql_fetch_array($resp3exeb))
{
$contarp3exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 3 son:".$contarp3exe;
@$porcexebp3=($contarp3exeb/$contanoencuestas)*100;
//
$sql_rp3exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc3 = 'e'";
$resp3exec=mysql_query($sql_rp3exec,$sala);
$contarp3exec=0;
while ($filp3exec=mysql_fetch_array($resp3exec))
{
$contarp3exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 3 son:".$contarp3desc;
@$porcexecp3=($contarp3exec/$contanoencuestas)*100;
//
//
$sql_rp3buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa3 = 'b'";
$resp3buna=mysql_query($sql_rp3buna,$sala);
$contarp3buna=0;
while ($filp3buna=mysql_fetch_array($resp3buna))
{
$contarp3buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 3 son:".$contarp3exe;
@$porcbunap3=($contarp3buna/$contanoencuestas)*100;
//
$sql_rp3bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb3 = 'b'";
$resp3bunb=mysql_query($sql_rp3bunb,$sala);
$contarp3bunb=0;
while ($filp3bunb=mysql_fetch_array($resp3bunb))
{
$contarp3bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 3 son:".$contarp3exe;
@$porcbunbp3=($contarp3bunb/$contanoencuestas)*100;
//
$sql_rp3bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc3 = 'b'";
$resp3bunc=mysql_query($sql_rp3bunc,$sala);
$contarp3bunc=0;
while ($filp3bunc=mysql_fetch_array($resp3bunc))
{
$contarp3bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 3 son:".$contarp3desc;
@$porcbuncp3=($contarp3bunc/$contanoencuestas)*100;
//
$sql_rp3rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa3 = 'r'";
$resp3rega=mysql_query($sql_rp3rega,$sala);
$contarp3rega=0;
while ($filp3rega=mysql_fetch_array($resp3rega))
{
$contarp3rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 3 son:".$contarp3exe;
@$porcregap3=($contarp3rega/$contanoencuestas)*100;
//
$sql_rp3regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb3 = 'r'";
$resp3regb=mysql_query($sql_rp3regb,$sala);
$contarp3regb=0;
while ($filp3regb=mysql_fetch_array($resp3regb))
{
$contarp3regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 3 son:".$contarp3exe;
@$porcregbp3=($contarp3regb/$contanoencuestas)*100;
//
$sql_rp3regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc3 = 'r'";
$resp3regc=mysql_query($sql_rp3regc,$sala);
$contarp3regc=0;
while ($filp3regc=mysql_fetch_array($resp3regc))
{
$contarp3regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 3 son:".$contarp3desc;
@$porcregcp3=($contarp3regc/$contanoencuestas)*100;
//
$sql_rp3defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa3 = 'd'";
$resp3defa=mysql_query($sql_rp3defa,$sala);
$contarp3defa=0;
while ($filp3defa=mysql_fetch_array($resp3defa))
{
$contarp3defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 3 son:".$contarp3exe;
@$porcdefap3=($contarp3defa/$contanoencuestas)*100;
//
$sql_rp3defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb3 = 'd'";
$resp3defb=mysql_query($sql_rp3defb,$sala);
$contarp3defb=0;
while ($filp3defb=mysql_fetch_array($resp3defb))
{
$contarp3defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 3 son:".$contarp3exe;
@$porcdefbp3=($contarp3defb/$contanoencuestas)*100;
//
$sql_rp3defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc3 = 'd'";
$resp3defc=mysql_query($sql_rp3defc,$sala);
$contarp3defc=0;
while ($filp3defc=mysql_fetch_array($resp3defc))
{
$contarp3defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 3 son:".$contarp3desc;
@$porcdefcp3=($contarp3defc/$contanoencuestas)*100;
//
$sql_rp3nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa3 = 'n'";
$resp3nopa=mysql_query($sql_rp3nopa,$sala);
$contarp3nopa=0;
while ($filp3nopa=mysql_fetch_array($resp3nopa))
{
$contarp3nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 3 son:".$contarp3exe;
@$porcnopap3=($contarp3nopa/$contanoencuestas)*100;
//
$sql_rp3nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb3 = 'n'";
$resp3nopb=mysql_query($sql_rp3nopb,$sala);
$contarp3nopb=0;
while ($filp3nopb=mysql_fetch_array($resp3nopb))
{
$contarp3nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 3 son:".$contarp3exe;
@$porcnopbp3=($contarp3nopb/$contanoencuestas)*100;
//
$sql_rp3nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc3 = 'n'";
$resp3nopc=mysql_query($sql_rp3nopc,$sala);
$contarp3nopc=0;
while ($filp3nopc=mysql_fetch_array($resp3nopc))
{
$contarp3nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 3 son:".$contarp3desc;
@$porcnopcp3=($contarp3nopc/$contanoencuestas)*100;
//
//444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444

//echo "el numero de personas que respondieron la pregunta 4 son:".$conttrp4;
$sql_rp4t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp4 = 't'";
$resultadorp4t=mysql_query($sql_rp4t,$sala);
$contarp4t=0;
while ($filarp4t=mysql_fetch_array($resultadorp4t))
{
$contarp4t++;
}
//echo "el numero de personas que respondieron e a la pregunta 4 son:".$contarp4t;
@$porcentp4 =($contarp4t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 4 e".$porcentagep4;
//echo $porcenep1;
//
//echo "el numero de personas que respondieron la pregunta 4 son:".$contarp4;


$sql_rp4a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp4 = 'a'";
$resultadorp4a=mysql_query($sql_rp4a,$sala);
$contarp4e=0;
while ($filarp4e=mysql_fetch_array($resultadorp4a))
{
$contarp4a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep4 =($contarp4a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp4p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp4 = 'p'";
$resultadorp4p=mysql_query($sql_rp4p,$sala);
$contarp4b=0;
while ($filarp4b=mysql_fetch_array($resultadorp4p))
{
$contarp4p++;
}
//echo "el numero de personas que respondieron b a la pregunta 4 son:".$contarp4b;
@$porcenbp4=($contarp4p/$contanoencuestas)*100;
//$np4=($porcenep4+$porcenbp4)/20;
$np4=(($porcentp4*100)+($porcenep4*75)+($porcenbp4*50)+($porcendp4*25))/2000;
//
$sql_rp4d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp4 = 'd'";
$resultadorp4d=mysql_query($sql_rp4d,$sala);
$contarp4d=0;
while ($filarp4d=mysql_fetch_array($resultadorp4d))
{
$contarp4d++;
}
//echo "el numero de personas que respondieron d a la pregunta 4 son:".$contarp4b;
@$porcendp4=($contarp4d/$contanoencuestas)*100;
//

$sql_rp4exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa4 = 'e'";
$resp4exea=mysql_query($sql_rp4exea,$sala);
$contarp4exea=0;
while ($filp4exea=mysql_fetch_array($resp4exea))
{
$contarp4exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 4 son:".$contarp4exe;
@$porcexeap4=($contarp4exea/$contanoencuestas)*100;
//
$sql_rp4exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb4 = 'e'";
$resp4exeb=mysql_query($sql_rp4exeb,$sala);
$contarp4exeb=0;
while ($filp4exeb=mysql_fetch_array($resp4exeb))
{
$contarp4exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 4 son:".$contarp4exe;
@$porcexebp4=($contarp4exeb/$contanoencuestas)*100;
//
$sql_rp4exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc4 = 'e'";
$resp4exec=mysql_query($sql_rp4exec,$sala);
$contarp4exec=0;
while ($filp4exec=mysql_fetch_array($resp4exec))
{
$contarp4exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 4 son:".$contarp4desc;
@$porcexecp4=($contarp4exec/$contanoencuestas)*100;
//
//
$sql_rp4buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa4 = 'b'";
$resp4buna=mysql_query($sql_rp4buna,$sala);
$contarp4buna=0;
while ($filp4buna=mysql_fetch_array($resp4buna))
{
$contarp4buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 4 son:".$contarp4exe;
@$porcbunap4=($contarp4buna/$contanoencuestas)*100;
//
$sql_rp4bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb4 = 'b'";
$resp4bunb=mysql_query($sql_rp4bunb,$sala);
$contarp4bunb=0;
while ($filp4bunb=mysql_fetch_array($resp4bunb))
{
$contarp4bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 4 son:".$contarp4exe;
@$porcbunbp4=($contarp4bunb/$contanoencuestas)*100;
//
$sql_rp4bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc4 = 'b'";
$resp4bunc=mysql_query($sql_rp4bunc,$sala);
$contarp4bunc=0;
while ($filp4bunc=mysql_fetch_array($resp4bunc))
{
$contarp4bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 4 son:".$contarp4desc;
@$porcbuncp4=($contarp4bunc/$contanoencuestas)*100;
//
$sql_rp4rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa4 = 'r'";
$resp4rega=mysql_query($sql_rp4rega,$sala);
$contarp4rega=0;
while ($filp4rega=mysql_fetch_array($resp4rega))
{
$contarp4rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 4 son:".$contarp4exe;
@$porcregap4=($contarp4rega/$contanoencuestas)*100;
//
$sql_rp4regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb4 = 'r'";
$resp4regb=mysql_query($sql_rp4regb,$sala);
$contarp4regb=0;
while ($filp4regb=mysql_fetch_array($resp4regb))
{
$contarp4regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 4 son:".$contarp4exe;
@$porcregbp4=($contarp4regb/$contanoencuestas)*100;
//
$sql_rp4regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc4 = 'r'";
$resp4regc=mysql_query($sql_rp4regc,$sala);
$contarp4regc=0;
while ($filp4regc=mysql_fetch_array($resp4regc))
{
$contarp4regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 4 son:".$contarp4desc;
@$porcregcp4=($contarp4regc/$contanoencuestas)*100;
//
$sql_rp4defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa4 = 'd'";
$resp4defa=mysql_query($sql_rp4defa,$sala);
$contarp4defa=0;
while ($filp4defa=mysql_fetch_array($resp4defa))
{
$contarp4defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 4 son:".$contarp4exe;
@$porcdefap4=($contarp4defa/$contanoencuestas)*100;
//
$sql_rp4defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb4 = 'd'";
$resp4defb=mysql_query($sql_rp4defb,$sala);
$contarp4defb=0;
while ($filp4defb=mysql_fetch_array($resp4defb))
{
$contarp4defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 4 son:".$contarp4exe;
@$porcdefbp4=($contarp4defb/$contanoencuestas)*100;
//
$sql_rp4defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc4 = 'd'";
$resp4defc=mysql_query($sql_rp4defc,$sala);
$contarp4defc=0;
while ($filp4defc=mysql_fetch_array($resp4defc))
{
$contarp4defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 4 son:".$contarp4desc;
@$porcdefcp4=($contarp4defc/$contanoencuestas)*100;
//
$sql_rp4nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa4 = 'n'";
$resp4nopa=mysql_query($sql_rp4nopa,$sala);
$contarp4nopa=0;
while ($filp4nopa=mysql_fetch_array($resp4nopa))
{
$contarp4nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 4 son:".$contarp4exe;
@$porcnopap4=($contarp4nopa/$contanoencuestas)*100;
//
$sql_rp4nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb4 = 'n'";
$resp4nopb=mysql_query($sql_rp4nopb,$sala);
$contarp4nopb=0;
while ($filp4nopb=mysql_fetch_array($resp4nopb))
{
$contarp4nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 4 son:".$contarp4exe;
@$porcnopbp4=($contarp4nopb/$contanoencuestas)*100;
//
$sql_rp4nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc4 = 'n'";
$resp4nopc=mysql_query($sql_rp4nopc,$sala);
$contarp4nopc=0;
while ($filp4nopc=mysql_fetch_array($resp4nopc))
{
$contarp4nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 4 son:".$contarp4desc;
@$porcnopcp4=($contarp4nopc/$contanoencuestas)*100;
//
//55555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555

//echo "el numero de personas que respondieron la pregunta 5 son:".$conttrp5;
$sql_rp5t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp5 = 't'";
$resultadorp5t=mysql_query($sql_rp5t,$sala);
$contarp5t=0;
while ($filarp5t=mysql_fetch_array($resultadorp5t))
{
$contarp5t++;
}

//echo $sql_rp5t;
//echo "el numero de personas que respondieron e a la pregunta 5 son:".$contarp5t;
@$porcentp5 =($contarp5t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 5 e".$porcentagep5;
//echo $porcentp5;
//
//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp5;

//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp5;
$sql_rp5a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp5 = 'a'";
$resultadorp5a=mysql_query($sql_rp5a,$sala);
$contarp5e=0;
while ($filarp5e=mysql_fetch_array($resultadorp5a))
{
$contarp5a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep5 =($contarp5a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp5p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp5 = 'p'";
$resultadorp5p=mysql_query($sql_rp5p,$sala);
$contarp5b=0;
while ($filarp5b=mysql_fetch_array($resultadorp5p))
{
$contarp5p++;
}
//echo "el numero de personas que respondieron b a la pregunta 5 son:".$contarp5b;
@$porcenbp5=($contarp5p/$contanoencuestas)*100;
//$np5=($porcenep5+$porcenbp5)/20;
$np5=(($porcentp5*100)+($porcenep5*75)+($porcenbp5*50)+($porcendp5*25))/2000;
//
$sql_rp5d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp5 = 'd'";
$resultadorp5d=mysql_query($sql_rp5d,$sala);
$contarp5d=0;
while ($filarp5d=mysql_fetch_array($resultadorp5d))
{
$contarp5d++;
}
//echo "el numero de personas que respondieron d a la pregunta 5 son:".$contarp5b;
@$porcendp5=($contarp5d/$contanoencuestas)*100;
//

$sql_rp5exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa5 = 'e'";
$resp5exea=mysql_query($sql_rp5exea,$sala);
$contarp5exea=0;
while ($filp5exea=mysql_fetch_array($resp5exea))
{
$contarp5exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 5 son:".$contarp5exe;
@$porcexeap5=($contarp5exea/$contanoencuestas)*100;
//
$sql_rp5exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb5 = 'e'";
$resp5exeb=mysql_query($sql_rp5exeb,$sala);
$contarp5exeb=0;
while ($filp5exeb=mysql_fetch_array($resp5exeb))
{
$contarp5exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 5 son:".$contarp5exe;
@$porcexebp5=($contarp5exeb/$contanoencuestas)*100;
//
$sql_rp5exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc5 = 'e'";
$resp5exec=mysql_query($sql_rp5exec,$sala);
$contarp5exec=0;
while ($filp5exec=mysql_fetch_array($resp5exec))
{
$contarp5exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 5 son:".$contarp5desc;
@$porcexecp5=($contarp5exec/$contanoencuestas)*100;
//
//
$sql_rp5buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa5 = 'b'";
$resp5buna=mysql_query($sql_rp5buna,$sala);
$contarp5buna=0;
while ($filp5buna=mysql_fetch_array($resp5buna))
{
$contarp5buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 5 son:".$contarp5exe;
@$porcbunap5=($contarp5buna/$contanoencuestas)*100;
//
$sql_rp5bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb5 = 'b'";
$resp5bunb=mysql_query($sql_rp5bunb,$sala);
$contarp5bunb=0;
while ($filp5bunb=mysql_fetch_array($resp5bunb))
{
$contarp5bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 5 son:".$contarp5exe;
@$porcbunbp5=($contarp5bunb/$contanoencuestas)*100;
//
$sql_rp5bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc5 = 'b'";
$resp5bunc=mysql_query($sql_rp5bunc,$sala);
$contarp5bunc=0;
while ($filp5bunc=mysql_fetch_array($resp5bunc))
{
$contarp5bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 5 son:".$contarp5desc;
@$porcbuncp5=($contarp5bunc/$contanoencuestas)*100;
//
$sql_rp5rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa5 = 'r'";
$resp5rega=mysql_query($sql_rp5rega,$sala);
$contarp5rega=0;
while ($filp5rega=mysql_fetch_array($resp5rega))
{
$contarp5rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 5 son:".$contarp5exe;
@$porcregap5=($contarp5rega/$contanoencuestas)*100;
//
$sql_rp5regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb5 = 'r'";
$resp5regb=mysql_query($sql_rp5regb,$sala);
$contarp5regb=0;
while ($filp5regb=mysql_fetch_array($resp5regb))
{
$contarp5regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 5 son:".$contarp5exe;
@$porcregbp5=($contarp5regb/$contanoencuestas)*100;
//
$sql_rp5regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc5 = 'r'";
$resp5regc=mysql_query($sql_rp5regc,$sala);
$contarp5regc=0;
while ($filp5regc=mysql_fetch_array($resp5regc))
{
$contarp5regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 5 son:".$contarp5desc;
@$porcregcp5=($contarp5regc/$contanoencuestas)*100;
//
$sql_rp5defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa5 = 'd'";
$resp5defa=mysql_query($sql_rp5defa,$sala);
$contarp5defa=0;
while ($filp5defa=mysql_fetch_array($resp5defa))
{
$contarp5defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 5 son:".$contarp5exe;
@$porcdefap5=($contarp5defa/$contanoencuestas)*100;
//
$sql_rp5defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb5 = 'd'";
$resp5defb=mysql_query($sql_rp5defb,$sala);
$contarp5defb=0;
while ($filp5defb=mysql_fetch_array($resp5defb))
{
$contarp5defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 5 son:".$contarp5exe;
@$porcdefbp5=($contarp5defb/$contanoencuestas)*100;
//
$sql_rp5defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc5 = 'd'";
$resp5defc=mysql_query($sql_rp5defc,$sala);
$contarp5defc=0;
while ($filp5defc=mysql_fetch_array($resp5defc))
{
$contarp5defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 5 son:".$contarp5desc;
@$porcdefcp5=($contarp5defc/$contanoencuestas)*100;
//
$sql_rp5nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa5 = 'n'";
$resp5nopa=mysql_query($sql_rp5nopa,$sala);
$contarp5nopa=0;
while ($filp5nopa=mysql_fetch_array($resp5nopa))
{
$contarp5nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 5 son:".$contarp5exe;
@$porcnopap5=($contarp5nopa/$contanoencuestas)*100;
//
$sql_rp5nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb5 = 'n'";
$resp5nopb=mysql_query($sql_rp5nopb,$sala);
$contarp5nopb=0;
while ($filp5nopb=mysql_fetch_array($resp5nopb))
{
$contarp5nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 5 son:".$contarp5exe;
@$porcnopbp5=($contarp5nopb/$contanoencuestas)*100;
//
$sql_rp5nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc5 = 'n'";
$resp5nopc=mysql_query($sql_rp5nopc,$sala);
$contarp5nopc=0;
while ($filp5nopc=mysql_fetch_array($resp5nopc))
{
$contarp5nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 5 son:".$contarp5desc;
@$porcnopcp5=($contarp5nopc/$contanoencuestas)*100;
//
//66666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666
//echo "el numero de personas que respondieron la pregunta 6 son:".$conttrp6;
$sql_rp6t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp6 = 't'";
$resultadorp6t=mysql_query($sql_rp6t,$sala);
$contarp6t=0;
while ($filarp6t=mysql_fetch_array($resultadorp6t))
{
$contarp6t++;
}

//echo $sql_rp6t;
//echo "el numero de personas que respondieron e a la pregunta 6 son:".$contarp6t;
@$porcentp6 =($contarp6t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 6 e".$porcentagep6;
//echo $porcentp2;
//
//echo "el numero de personas que respondieron la pregunta 6 son:".$contarp6;

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp6a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp6 = 'a'";
$resultadorp6a=mysql_query($sql_rp6a,$sala);
$contarp6e=0;
while ($filarp6e=mysql_fetch_array($resultadorp6a))
{
$contarp6a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep6 =($contarp6a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp6p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp6 = 'p'";
$resultadorp6p=mysql_query($sql_rp6p,$sala);
$contarp6b=0;
while ($filarp6b=mysql_fetch_array($resultadorp6p))
{
$contarp6p++;
}
//echo "el numero de personas que respondieron b a la pregunta 6 son:".$contarp6b;
@$porcenbp6=($contarp6p/$contanoencuestas)*100;
//$np6=($porcenep6+$porcenbp6)/20;
$np6=(($porcentp6*100)+($porcenep6*75)+($porcenbp6*50)+($porcendp6*25))/2000;
//
$sql_rp6d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp6 = 'd'";
$resultadorp6d=mysql_query($sql_rp6d,$sala);
$contarp6d=0;
while ($filarp6d=mysql_fetch_array($resultadorp6d))
{
$contarp6d++;
}
//echo "el numero de personas que respondieron d a la pregunta 6 son:".$contarp6b;
@$porcendp6=($contarp6d/$contanoencuestas)*100;
//

$sql_rp6exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa6 = 'e'";
$resp6exea=mysql_query($sql_rp6exea,$sala);
$contarp6exea=0;
while ($filp6exea=mysql_fetch_array($resp6exea))
{
$contarp6exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 6 son:".$contarp6exe;
@$porcexeap6=($contarp6exea/$contanoencuestas)*100;
//
$sql_rp6exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb6 = 'e'";
$resp6exeb=mysql_query($sql_rp6exeb,$sala);
$contarp6exeb=0;
while ($filp6exeb=mysql_fetch_array($resp6exeb))
{
$contarp6exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 6 son:".$contarp6exe;
@$porcexebp6=($contarp6exeb/$contanoencuestas)*100;
//
$sql_rp6exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc6 = 'e'";
$resp6exec=mysql_query($sql_rp6exec,$sala);
$contarp6exec=0;
while ($filp6exec=mysql_fetch_array($resp6exec))
{
$contarp6exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 6 son:".$contarp6desc;
@$porcexecp6=($contarp6exec/$contanoencuestas)*100;
//
//
$sql_rp6buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa6 = 'b'";
$resp6buna=mysql_query($sql_rp6buna,$sala);
$contarp6buna=0;
while ($filp6buna=mysql_fetch_array($resp6buna))
{
$contarp6buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 6 son:".$contarp6exe;
@$porcbunap6=($contarp6buna/$contanoencuestas)*100;
//
$sql_rp6bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb6 = 'b'";
$resp6bunb=mysql_query($sql_rp6bunb,$sala);
$contarp6bunb=0;
while ($filp6bunb=mysql_fetch_array($resp6bunb))
{
$contarp6bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 6 son:".$contarp6exe;
@$porcbunbp6=($contarp6bunb/$contanoencuestas)*100;
//
$sql_rp6bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc6 = 'b'";
$resp6bunc=mysql_query($sql_rp6bunc,$sala);
$contarp6bunc=0;
while ($filp6bunc=mysql_fetch_array($resp6bunc))
{
$contarp6bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 6 son:".$contarp6desc;
@$porcbuncp6=($contarp6bunc/$contanoencuestas)*100;
//
$sql_rp6rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa6 = 'r'";
$resp6rega=mysql_query($sql_rp6rega,$sala);
$contarp6rega=0;
while ($filp6rega=mysql_fetch_array($resp6rega))
{
$contarp6rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 6 son:".$contarp6exe;
@$porcregap6=($contarp6rega/$contanoencuestas)*100;
//
$sql_rp6regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb6 = 'r'";
$resp6regb=mysql_query($sql_rp6regb,$sala);
$contarp6regb=0;
while ($filp6regb=mysql_fetch_array($resp6regb))
{
$contarp6regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 6 son:".$contarp6exe;
@$porcregbp6=($contarp6regb/$contanoencuestas)*100;
//
$sql_rp6regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc6 = 'r'";
$resp6regc=mysql_query($sql_rp6regc,$sala);
$contarp6regc=0;
while ($filp6regc=mysql_fetch_array($resp6regc))
{
$contarp6regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 6 son:".$contarp6desc;
@$porcregcp6=($contarp6regc/$contanoencuestas)*100;
//
$sql_rp6defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa6 = 'd'";
$resp6defa=mysql_query($sql_rp6defa,$sala);
$contarp6defa=0;
while ($filp6defa=mysql_fetch_array($resp6defa))
{
$contarp6defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 6 son:".$contarp6exe;
@$porcdefap6=($contarp6defa/$contanoencuestas)*100;
//
$sql_rp6defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb6 = 'd'";
$resp6defb=mysql_query($sql_rp6defb,$sala);
$contarp6defb=0;
while ($filp6defb=mysql_fetch_array($resp6defb))
{
$contarp6defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 6 son:".$contarp6exe;
@$porcdefbp6=($contarp6defb/$contanoencuestas)*100;
//
$sql_rp6defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc6 = 'd'";
$resp6defc=mysql_query($sql_rp6defc,$sala);
$contarp6defc=0;
while ($filp6defc=mysql_fetch_array($resp6defc))
{
$contarp6defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 6 son:".$contarp6desc;
@$porcdefcp6=($contarp6defc/$contanoencuestas)*100;
//
$sql_rp6nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa6 = 'n'";
$resp6nopa=mysql_query($sql_rp6nopa,$sala);
$contarp6nopa=0;
while ($filp6nopa=mysql_fetch_array($resp6nopa))
{
$contarp6nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 6 son:".$contarp6exe;
@$porcnopap6=($contarp6nopa/$contanoencuestas)*100;
//
$sql_rp6nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb6 = 'n'";
$resp6nopb=mysql_query($sql_rp6nopb,$sala);
$contarp6nopb=0;
while ($filp6nopb=mysql_fetch_array($resp6nopb))
{
$contarp6nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 6 son:".$contarp6exe;
@$porcnopbp6=($contarp6nopb/$contanoencuestas)*100;
//
$sql_rp6nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc6 = 'n'";
$resp6nopc=mysql_query($sql_rp6nopc,$sala);
$contarp6nopc=0;
while ($filp6nopc=mysql_fetch_array($resp6nopc))
{
$contarp6nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 6 son:".$contarp6desc;
@$porcnopcp6=($contarp6nopc/$contanoencuestas)*100;
//
//777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777
//echo "el numero de personas que respondieron la pregunta 7 son:".$conttrp7;
$sql_rp7t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp7 = 't'";
$resultadorp7t=mysql_query($sql_rp7t,$sala);
$contarp7t=0;
while ($filarp7t=mysql_fetch_array($resultadorp7t))
{
$contarp7t++;
}

//echo $sql_rp2t;
//echo "el numero de personas que respondieron e a la pregunta 7 son:".$contarp7t;
@$porcentp7 =($contarp7t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep7;
//echo $porcentp7;
//
//echo "el numero de personas que respondieron la pregunta 7 son:".$contarp7;

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp5;
$sql_rp7a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp7 = 'a'";
$resultadorp7a=mysql_query($sql_rp7a,$sala);
$contarp7e=0;
while ($filarp7e=mysql_fetch_array($resultadorp7a))
{
$contarp7a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep7 =($contarp7a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp7p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp7 = 'p'";
$resultadorp7p=mysql_query($sql_rp7p,$sala);
$contarp7b=0;
while ($filarp7b=mysql_fetch_array($resultadorp7p))
{
$contarp7p++;
}
//echo "el numero de personas que respondieron b a la pregunta 7 son:".$contarp7b;
@$porcenbp7=($contarp7p/$contanoencuestas)*100;
//$np7=($porcenep7+$porcenbp7)/20;
$np7=(($porcentp7*100)+($porcenep7*75)+($porcenbp7*50)+($porcendp7*25))/2000;
//
$sql_rp7d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp7 = 'd'";
$resultadorp7d=mysql_query($sql_rp7d,$sala);
$contarp7d=0;
while ($filarp7d=mysql_fetch_array($resultadorp7d))
{
$contarp7d++;
}
//echo "el numero de personas que respondieron d a la pregunta 7 son:".$contarp7b;
@$porcendp7=($contarp7d/$contanoencuestas)*100;
//

$sql_rp7exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa7 = 'e'";
$resp7exea=mysql_query($sql_rp7exea,$sala);
$contarp7exea=0;
while ($filp7exea=mysql_fetch_array($resp7exea))
{
$contarp7exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 7 son:".$contarp7exe;
@$porcexeap7=($contarp7exea/$contanoencuestas)*100;
//
$sql_rp7exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb7 = 'e'";
$resp7exeb=mysql_query($sql_rp7exeb,$sala);
$contarp7exeb=0;
while ($filp7exeb=mysql_fetch_array($resp7exeb))
{
$contarp7exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 7 son:".$contarp7exe;
@$porcexebp7=($contarp7exeb/$contanoencuestas)*100;
//
$sql_rp7exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc7 = 'e'";
$resp7exec=mysql_query($sql_rp7exec,$sala);
$contarp7exec=0;
while ($filp7exec=mysql_fetch_array($resp7exec))
{
$contarp7exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 7 son:".$contarp7desc;
@$porcexecp7=($contarp7exec/$contanoencuestas)*100;
//
//
$sql_rp7buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa7 = 'b'";
$resp7buna=mysql_query($sql_rp7buna,$sala);
$contarp7buna=0;
while ($filp7buna=mysql_fetch_array($resp7buna))
{
$contarp7buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 7 son:".$contarp7exe;
@$porcbunap7=($contarp7buna/$contanoencuestas)*100;
//
$sql_rp7bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb7 = 'b'";
$resp7bunb=mysql_query($sql_rp7bunb,$sala);
$contarp7bunb=0;
while ($filp7bunb=mysql_fetch_array($resp7bunb))
{
$contarp7bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 7 son:".$contarp7exe;
@$porcbunbp7=($contarp7bunb/$contanoencuestas)*100;
//
$sql_rp7bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc7 = 'b'";
$resp7bunc=mysql_query($sql_rp7bunc,$sala);
$contarp7bunc=0;
while ($filp7bunc=mysql_fetch_array($resp7bunc))
{
$contarp7bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 7 son:".$contarp7desc;

@$porcbuncp7=($contarp7bunc/$contanoencuestas)*100;
//
$sql_rp7rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa7 = 'r'";
$resp7rega=mysql_query($sql_rp7rega,$sala);
$contarp7rega=0;
while ($filp7rega=mysql_fetch_array($resp7rega))
{
$contarp7rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 7 son:".$contarp7exe;
@$porcregap7=($contarp7rega/$contanoencuestas)*100;
//
$sql_rp7regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb7 = 'r'";
$resp7regb=mysql_query($sql_rp7regb,$sala);
$contarp7regb=0;
while ($filp7regb=mysql_fetch_array($resp7regb))
{
$contarp7regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 7 son:".$contarp7exe;
@$porcregbp7=($contarp7regb/$contanoencuestas)*100;
//
$sql_rp7regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc7 = 'r'";
$resp7regc=mysql_query($sql_rp7regc,$sala);
$contarp7regc=0;
while ($filp7regc=mysql_fetch_array($resp7regc))
{
$contarp7regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 7 son:".$contarp7desc;
@$porcregcp7=($contarp7regc/$contanoencuestas)*100;
//
$sql_rp7defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa7 = 'd'";
$resp7defa=mysql_query($sql_rp7defa,$sala);
$contarp7defa=0;
while ($filp7defa=mysql_fetch_array($resp7defa))
{
$contarp7defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 7 son:".$contarp7exe;
@$porcdefap7=($contarp7defa/$contanoencuestas)*100;
//
$sql_rp7defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb7 = 'd'";
$resp7defb=mysql_query($sql_rp7defb,$sala);
$contarp7defb=0;
while ($filp7defb=mysql_fetch_array($resp7defb))
{
$contarp7defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 7 son:".$contarp7exe;
@$porcdefbp7=($contarp7defb/$contanoencuestas)*100;
//
$sql_rp7defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc7 = 'd'";
$resp7defc=mysql_query($sql_rp7defc,$sala);
$contarp7defc=0;
while ($filp7defc=mysql_fetch_array($resp7defc))
{
$contarp7defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 7 son:".$contarp7desc;
@$porcdefcp7=($contarp7defc/$contanoencuestas)*100;
//
$sql_rp7nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa7 = 'n'";
$resp7nopa=mysql_query($sql_rp7nopa,$sala);
$contarp7nopa=0;
while ($filp7nopa=mysql_fetch_array($resp7nopa))
{
$contarp7nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 7 son:".$contarp7exe;
@$porcnopap7=($contarp7nopa/$contanoencuestas)*100;
//
$sql_rp7nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb7 = 'n'";
$resp7nopb=mysql_query($sql_rp7nopb,$sala);
$contarp7nopb=0;
while ($filp7nopb=mysql_fetch_array($resp7nopb))
{
$contarp7nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 7 son:".$contarp7exe;
@$porcnopbp7=($contarp7nopb/$contanoencuestas)*100;
//
$sql_rp7nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc7 = 'n'";
$resp7nopc=mysql_query($sql_rp7nopc,$sala);
$contarp7nopc=0;
while ($filp7nopc=mysql_fetch_array($resp7nopc))
{
$contarp7nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 7 son:".$contarp7desc;
@$porcnopcp7=($contarp7nopc/$contanoencuestas)*100;
//
//888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
//echo "el numero de personas que respondieron la pregunta 8 son:".$conttrp8;
$sql_rp8t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp8 = 't'";
$resultadorp8t=mysql_query($sql_rp8t,$sala);
$contarp8t=0;
while ($filarp8t=mysql_fetch_array($resultadorp8t))
{
$contarp8t++;
}

//echo $sql_rp2t;
//echo "el numero de personas que respondieron e a la pregunta 8 son:".$contarp8t;
@$porcentp8 =($contarp8t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 8 e".$porcentagep8;
//echo $porcentp8;
//
//echo "el numero de personas que respondieron la pregunta 8 son:".$contarp8;

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp8a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp8 = 'a'";
$resultadorp8a=mysql_query($sql_rp8a,$sala);
$contarp8e=0;
while ($filarp8e=mysql_fetch_array($resultadorp8a))
{
$contarp8a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep8 =($contarp8a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp8p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp8 = 'p'";
$resultadorp8p=mysql_query($sql_rp8p,$sala);
$contarp8b=0;
while ($filarp8b=mysql_fetch_array($resultadorp8p))
{
$contarp8p++;
}
//echo "el numero de personas que respondieron b a la pregunta 8 son:".$contarp8b;
@$porcenbp8=($contarp8p/$contanoencuestas)*100;
//$np8=($porcenep8+$porcenbp8)/20;
$np8=(($porcentp8*100)+($porcenep8*75)+($porcenbp8*50)+($porcendp8*25))/2000;
//
$sql_rp8d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp8 = 'd'";
$resultadorp8d=mysql_query($sql_rp8d,$sala);
$contarp8d=0;
while ($filarp8d=mysql_fetch_array($resultadorp8d))
{
$contarp8d++;
}
//echo "el numero de personas que respondieron d a la pregunta 8 son:".$contarp8b;
@$porcendp8=($contarp8d/$contanoencuestas)*100;
//

$sql_rp8exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa8 = 'e'";
$resp8exea=mysql_query($sql_rp8exea,$sala);
$contarp8exea=0;
while ($filp8exea=mysql_fetch_array($resp8exea))
{
$contarp8exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 8 son:".$contarp8exe;
@$porcexeap8=($contarp8exea/$contanoencuestas)*100;
//
$sql_rp8exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb8 = 'e'";
$resp8exeb=mysql_query($sql_rp8exeb,$sala);
$contarp8exeb=0;
while ($filp8exeb=mysql_fetch_array($resp8exeb))
{
$contarp8exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 8 son:".$contarp8exe;
@$porcexebp8=($contarp8exeb/$contanoencuestas)*100;
//
$sql_rp8exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc8 = 'e'";
$resp8exec=mysql_query($sql_rp8exec,$sala);
$contarp8exec=0;
while ($filp8exec=mysql_fetch_array($resp8exec))
{
$contarp8exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 8 son:".$contarp8desc;
@$porcexecp8=($contarp8exec/$contanoencuestas)*100;
//
//
$sql_rp8buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa8 = 'b'";
$resp8buna=mysql_query($sql_rp8buna,$sala);
$contarp8buna=0;
while ($filp8buna=mysql_fetch_array($resp8buna))
{
$contarp8buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 8 son:".$contarp8exe;
@$porcbunap8=($contarp8buna/$contanoencuestas)*100;
//
$sql_rp8bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb8 = 'b'";
$resp8bunb=mysql_query($sql_rp8bunb,$sala);
$contarp8bunb=0;
while ($filp8bunb=mysql_fetch_array($resp8bunb))
{
$contarp8bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 8 son:".$contarp8exe;
@$porcbunbp8=($contarp8bunb/$contanoencuestas)*100;
//
$sql_rp8bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc8 = 'b'";
$resp8bunc=mysql_query($sql_rp8bunc,$sala);
$contarp8bunc=0;
while ($filp8bunc=mysql_fetch_array($resp8bunc))
{
$contarp8bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 8 son:".$contarp8desc;

@$porcbuncp8=($contarp8bunc/$contanoencuestas)*100;
//
$sql_rp8rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa8 = 'r'";
$resp8rega=mysql_query($sql_rp8rega,$sala);
$contarp8rega=0;
while ($filp8rega=mysql_fetch_array($resp8rega))
{
$contarp8rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 8 son:".$contarp8exe;
@$porcregap8=($contarp8rega/$contanoencuestas)*100;
//
$sql_rp8regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb8 = 'r'";
$resp8regb=mysql_query($sql_rp8regb,$sala);
$contarp8regb=0;
while ($filp8regb=mysql_fetch_array($resp8regb))
{
$contarp8regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 8 son:".$contarp8exe;
@$porcregbp8=($contarp8regb/$contanoencuestas)*100;
//
$sql_rp8regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc8 = 'r'";
$resp8regc=mysql_query($sql_rp8regc,$sala);
$contarp8regc=0;
while ($filp8regc=mysql_fetch_array($resp8regc))
{
$contarp8regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 8 son:".$contarp8desc;
@$porcregcp8=($contarp8regc/$contanoencuestas)*100;
//
$sql_rp8defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa8 = 'd'";
$resp8defa=mysql_query($sql_rp8defa,$sala);
$contarp8defa=0;
while ($filp8defa=mysql_fetch_array($resp8defa))
{
$contarp8defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 8 son:".$contarp8exe;
@$porcdefap8=($contarp8defa/$contanoencuestas)*100;
//
$sql_rp8defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb8 = 'd'";
$resp8defb=mysql_query($sql_rp8defb,$sala);
$contarp8defb=0;
while ($filp8defb=mysql_fetch_array($resp8defb))
{
$contarp8defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 8 son:".$contarp8exe;
@$porcdefbp8=($contarp8defb/$contanoencuestas)*100;
//
$sql_rp8defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc8 = 'd'";
$resp8defc=mysql_query($sql_rp8defc,$sala);
$contarp8defc=0;
while ($filp8defc=mysql_fetch_array($resp8defc))
{
$contarp8defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 8 son:".$contarp8desc;
@$porcdefcp8=($contarp8defc/$contanoencuestas)*100;
//
$sql_rp8nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa8 = 'n'";
$resp8nopa=mysql_query($sql_rp8nopa,$sala);
$contarp8nopa=0;
while ($filp8nopa=mysql_fetch_array($resp8nopa))
{
$contarp8nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 8 son:".$contarp8exe;
@$porcnopap8=($contarp8nopa/$contanoencuestas)*100;
//
$sql_rp8nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb8 = 'n'";
$resp8nopb=mysql_query($sql_rp8nopb,$sala);
$contarp8nopb=0;
while ($filp8nopb=mysql_fetch_array($resp8nopb))
{
$contarp8nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 8 son:".$contarp8exe;
@$porcnopbp8=($contarp8nopb/$contanoencuestas)*100;
//
$sql_rp8nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc8 = 'n'";
$resp8nopc=mysql_query($sql_rp8nopc,$sala);
$contarp8nopc=0;
while ($filp8nopc=mysql_fetch_array($resp8nopc))
{
$contarp8nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 8 son:".$contarp8desc;
@$porcnopcp8=($contarp8nopc/$contanoencuestas)*100;
//
//9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
//echo "el numero de personas que respondieron la pregunta 9 son:".$conttrp9;
$sql_rp9t= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp9 = 't'";
$resultadorp9t=mysql_query($sql_rp9t,$sala);
$contarp9t=0;
while ($filarp9t=mysql_fetch_array($resultadorp9t))
{
$contarp9t++;
}

//echo $sql_rp9t;
//echo "el numero de personas que respondieron e a la pregunta 9 son:".$contarp9t;
@$porcentp9 =($contarp9t/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep2;
//echo $porcentp2;
//
//echo "el numero de personas que respondieron la pregunta 9 son:".$contarp9;

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp9;
$sql_rp9a= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp9 = 'a'";
$resultadorp9a=mysql_query($sql_rp9a,$sala);
$contarp9e=0;
while ($filarp9e=mysql_fetch_array($resultadorp9a))
{
$contarp9a++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
@$porcenep9 =($contarp9a/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp9p= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp9 = 'p'";
$resultadorp9p=mysql_query($sql_rp9p,$sala);
$contarp9b=0;
while ($filarp9b=mysql_fetch_array($resultadorp9p))
{
$contarp9p++;
}
//echo "el numero de personas que respondieron b a la pregunta 9 son:".$contarp9b;
@$porcenbp9=($contarp9p/$contanoencuestas)*100;
//$np9=($porcenep9+$porcenbp9)/20;
$np9=(($porcentp9*100)+($porcenep9*75)+($porcenbp9*50)+($porcendp9*25))/2000;
//
$sql_rp9d= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and resp9 = 'd'";
$resultadorp9d=mysql_query($sql_rp9d,$sala);
$contarp9d=0;
while ($filarp9d=mysql_fetch_array($resultadorp9d))
{
$contarp9d++;
}
//echo "el numero de personas que respondieron d a la pregunta 9 son:".$contarp9b;
@$porcendp9=($contarp9d/$contanoencuestas)*100;
//

$sql_rp9exea= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa9 = 'e'";
$resp9exea=mysql_query($sql_rp9exea,$sala);
$contarp9exea=0;
while ($filp9exea=mysql_fetch_array($resp9exea))
{
$contarp9exea++;
}
//echo "el numero de personas que respondieron exelente a) de la pregunta 9 son:".$contarp9exe;
@$porcexeap9=($contarp9exea/$contanoencuestas)*100;
//
$sql_rp9exeb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb9 = 'e'";
$resp9exeb=mysql_query($sql_rp9exeb,$sala);
$contarp9exeb=0;
while ($filp9exeb=mysql_fetch_array($resp9exeb))
{
$contarp9exeb++;
}
//echo "el numero de personas que respondieron exelente b) de la pregunta 9 son:".$contarp9exe;
@$porcexebp9=($contarp9exeb/$contanoencuestas)*100;
//
$sql_rp9exec= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc9 = 'e'";
$resp9exec=mysql_query($sql_rp9exec,$sala);
$contarp9exec=0;
while ($filp9exec=mysql_fetch_array($resp9exec))
{
$contarp9exec++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 9 son:".$contarp9desc;
@$porcexecp9=($contarp9exec/$contanoencuestas)*100;
//
$sql_rp9exed= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respd9 = 'e'";
$resp9exed=mysql_query($sql_rp9exed,$sala);
$contarp9exed=0;
while ($filp9exed=mysql_fetch_array($resp9exed))
{
$contarp9exed++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 9 son:".$contarp9exer;
@$porcexedp9=($contarp9exed/$contanoencuestas)*100;
//echo $porcexerp9;
//
$sql_rp9exee= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respe9 = 'e'";
$resp9exee=mysql_query($sql_rp9exee,$sala);
$contarp9exee=0;
while ($filp9exee=mysql_fetch_array($resp9exee))
{
$contarp9exee++;
}
//echo "el numero de personas que respondieron exelente c) de la pregunta 9 son:".$contarp9exel;
@$porcexeep9=($contarp9exee/$contanoencuestas)*100;
//echo $porcexelp9;
//
$sql_rp9buna= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa9 = 'b'";
$resp9buna=mysql_query($sql_rp9buna,$sala);
$contarp9buna=0;
while ($filp9buna=mysql_fetch_array($resp9buna))
{
$contarp9buna++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 9 son:".$contarp9exe;
@$porcbunap9=($contarp9buna/$contanoencuestas)*100;
//
$sql_rp9bunb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb9 = 'b'";
$resp9bunb=mysql_query($sql_rp9bunb,$sala);
$contarp9bunb=0;
while ($filp9bunb=mysql_fetch_array($resp9bunb))
{
$contarp9bunb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 9 son:".$contarp9exe;
@$porcbunbp9=($contarp9bunb/$contanoencuestas)*100;
//
$sql_rp9bunc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc9 = 'b'";
$resp9bunc=mysql_query($sql_rp9bunc,$sala);
$contarp9bunc=0;
while ($filp9bunc=mysql_fetch_array($resp9bunc))
{
$contarp9bunc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;

@$porcbuncp9=($contarp9bunc/$contanoencuestas)*100;
//
//
$sql_rp9bund= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respd9 = 'b'";
$resp9bund=mysql_query($sql_rp9bund,$sala);
$contarp9bund=0;
while ($filp9bund=mysql_fetch_array($resp9bund))
{
$contarp9bund++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;

@$porcbundp9=($contarp9bund/$contanoencuestas)*100;
//
$sql_rp9bune= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respe9 = 'b'";
$resp9bune=mysql_query($sql_rp9bune,$sala);
$contarp9bune=0;
while ($filp9bune=mysql_fetch_array($resp9bune))
{
$contarp9bune++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;

@$porcbunep9=($contarp9bune/$contanoencuestas)*100;

$sql_rp9rega= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa9 = 'r'";
$resp9rega=mysql_query($sql_rp9rega,$sala);
$contarp9rega=0;
while ($filp9rega=mysql_fetch_array($resp9rega))
{
$contarp9rega++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 9 son:".$contarp9exe;
@$porcregap9=($contarp9rega/$contanoencuestas)*100;
//
$sql_rp9regb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb9 = 'r'";
$resp9regb=mysql_query($sql_rp9regb,$sala);
$contarp9regb=0;
while ($filp9regb=mysql_fetch_array($resp9regb))
{
$contarp9regb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 9 son:".$contarp9exe;
@$porcregbp9=($contarp9regb/$contanoencuestas)*100;
//
$sql_rp9regc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc9 = 'r'";
$resp9regc=mysql_query($sql_rp9regc,$sala);
$contarp9regc=0;
while ($filp9regc=mysql_fetch_array($resp9regc))
{
$contarp9regc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcregcp9=($contarp9regc/$contanoencuestas)*100;

//
$sql_rp9regd= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respd9 = 'r'";
$resp9regd=mysql_query($sql_rp9regd,$sala);
$contarp9regd=0;
while ($filp9regd=mysql_fetch_array($resp9regd))
{
$contarp9regd++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcregdp9=($contarp9regd/$contanoencuestas)*100;
//
$sql_rp9rege= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respe9 = 'r'";
$resp9rege=mysql_query($sql_rp9rege,$sala);
$contarp9rege=0;
while ($filp9rege=mysql_fetch_array($resp9rege))
{
$contarp9rege++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcregep9=($contarp9rege/$contanoencuestas)*100;
//
$sql_rp9defa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa9 = 'd'";
$resp9defa=mysql_query($sql_rp9defa,$sala);
$contarp9defa=0;
while ($filp9defa=mysql_fetch_array($resp9defa))
{
$contarp9defa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 9 son:".$contarp9exe;
@$porcdefap9=($contarp9defa/$contanoencuestas)*100;
//
$sql_rp9defb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb9 = 'd'";
$resp9defb=mysql_query($sql_rp9defb,$sala);
$contarp9defb=0;
while ($filp9defb=mysql_fetch_array($resp9defb))
{
$contarp9defb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 9 son:".$contarp9exe;
@$porcdefbp9=($contarp9defb/$contanoencuestas)*100;
//
$sql_rp9defc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc9 = 'd'";
$resp9defc=mysql_query($sql_rp9defc,$sala);
$contarp9defc=0;
while ($filp9defc=mysql_fetch_array($resp9defc))
{
$contarp9defc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcdefcp9=($contarp9defc/$contanoencuestas)*100;

//
$sql_rp9defd= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respd9 = 'd'";
$resp9defd=mysql_query($sql_rp9defd,$sala);
$contarp9defd=0;
while ($filp9defd=mysql_fetch_array($resp9defd))
{
$contarp9defd++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcdefdp9=($contarp9defd/$contanoencuestas)*100;
//
$sql_rp9defe= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respe9 = 'd'";
$resp9defe=mysql_query($sql_rp9defe,$sala);
$contarp9defe=0;
while ($filp9defe=mysql_fetch_array($resp9defe))
{
$contarp9defe++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcdefep9=($contarp9defe/$contanoencuestas)*100;
//
$sql_rp9nopa= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respa9 = 'n'";
$resp9nopa=mysql_query($sql_rp9nopa,$sala);
$contarp9nopa=0;
while ($filp9nopa=mysql_fetch_array($resp9nopa))
{
$contarp9nopa++;
}
//echo "el numero de personas que respondieron bueno a) de la pregunta 9 son:".$contarp9exe;
@$porcnopap9=($contarp9nopa/$contanoencuestas)*100;
//
$sql_rp9nopb= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respb9 = 'n'";
$resp9nopb=mysql_query($sql_rp9nopb,$sala);
$contarp9nopb=0;
while ($filp9nopb=mysql_fetch_array($resp9nopb))
{
$contarp9nopb++;
}
//echo "el numero de personas que respondieron bueno b) de la pregunta 9 son:".$contarp9exe;
@$porcnopbp9=($contarp9nopb/$contanoencuestas)*100;
//
$sql_rp9nopc= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respc9 = 'n'";
$resp9nopc=mysql_query($sql_rp9nopc,$sala);
$contarp9nopc=0;
while ($filp9nopc=mysql_fetch_array($resp9nopc))
{
$contarp9nopc++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcnopcp9=($contarp9nopc/$contanoencuestas)*100;
//
$sql_rp9nopd= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respd9 = 'n'";
$resp9nopd=mysql_query($sql_rp9nopd,$sala);
$contarp9nopd=0;
while ($filp9nopd=mysql_fetch_array($resp9nopd))
{
$contarp9nopd++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcnopdp9=($contarp9nopd/$contanoencuestas)*100;
//
$sql_rp9nope= "SELECT  distinct codigoestudiante  FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li' and respe9 = 'n'";
$resp9nope=mysql_query($sql_rp9nope,$sala);
$contarp9nope=0;
while ($filp9nope=mysql_fetch_array($resp9nope))
{
$contarp9nope++;
}
//echo "el numero de personas que respondieron bueno c) de la pregunta 9 son:".$contarp9desc;
@$porcnopep9=($contarp9nope/$contanoencuestas)*100;

//TOTAL DE LA NOTA DE ESTA EVALUACION POR PROMEDIO
$tnp=($np1+$np2+$np3+$np4+$np5+$np6+$np7+$np8+$np9)/9;
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
<table width="586" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#000000">
  <tr> 
      
    <td width="351" height="23" class="style1"><div align="center"><font size="2" face="tahoma"><strong><font size="1">HORARIO 
        MATERIA</font> : <span class="style1"><strong><span class="style3"> 
        <?php $comiensoh = $filahorario['horainicial']; echo  $filahorario['horainicial']; ?>
        <font size="1"> a</font> 
        <?php $finh = $filahorario['horafinal']; echo  $filahorario['horafinal']; ?>
        </span></strong></span></strong></font></div></td>
      
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
    <td width="86"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="57"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="143"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="39"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="53"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma"><strong class="style1 style7">ASIGNATURA</strong></font></td>
    <td><font size="1" face="tahoma">El aprendizaje logrado en el curso es bueno? </font></td>
    <td><div align="center">
      <table width="93%" height="69"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp1) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep1) ; ?>%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a..</strong>Cumplimiento de los objetivos y el programa de la asignatura</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap1) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np1) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp1) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong> Aporte de la asignatura en nuevos conocimientos y habilidades para la formaci&oacute;n</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp1) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp1) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp1) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp1) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp1) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong>Contribuci&oacute;n de la asignatura al desarrollo de las competencias para el desempe&ntilde;o del profesional de la Ingenier&iacute;a</font></td>
    <td bgcolor="#fef7ed"><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp1) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp1) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="86"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="56"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="144"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="86"><font size="1" face="tahoma"><strong class="style1 style7"> 
      CUMPLIMIENTO DE LOS PLANES DE TRABAJO </strong> </font></td>
    <td width="56"><font size="1" face="tahoma">El docente cumple con el plan de trabajo propuesto para el desarrollo de la asignatura?</font></td>
    <td width="60"><div align="center">
      <table width="100%" height="94"  border="0">
        <tr>
          <td height="42"><div align="center"><font size="1" face="tahoma"><strong>E</strong><span class="style1 style7"><?php printf ( "%.2f", $porcentp2) ; ?></span> <span class="style1 style7">%</span></font></div></td>
        </tr>
        <tr>
          <td height="46"><div align="center"><font size="1" face="tahoma"><strong>B</strong><span class="style1 style7"><?php printf ( "%.2f", $porcenep2) ; ?></span> <span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="144"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 
      Entrega formalmente el programa y reglas establecidas al comenzar el semestre.
      </font></td>
   <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap2) ; ?>%</span></font></div></td>

  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np2) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"><?php printf ( "%.2f", $porcenbp2) ; ?> 
        %</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong> Produce documentos y materiales para el desarrollo de la asignatura. </font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp2) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp2) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp2) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp2) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp2) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong><span class="style8"><?php printf ( "%.2f", $porcendp2) ; ?></span> 
        <span class="style8">%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong>Cumple con los temas y objetivos del contenido de la asignatura.</font></td>
    <td bgcolor="#fef7ed"><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp2) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp2) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="85"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="56"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="144"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="39"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="53"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="85"><font size="1" face="tahoma"><strong class="style1 style7">DESTREZAS  PEDAGÓGICA</strong></font></td>
    <td width="56"><font size="1" face="tahoma">Las destrezas pedag&oacute;gicas del docente son las adecuadas para el desarrollo de la asignatura?</font></td>
    <td width="61"><div align="center">
      <table width="102%" height="92"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong><span class="style1 style7"> <?php printf ( "%.2f", $porcentp3) ; ?></span>  <span class="style1 style7">%</span></font></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>B</strong><span class="style1 style7"> <?php printf ( "%.2f", $porcenep3) ; ?></span>  <span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="144"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 
      Domina los temas de la asignatura.</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap3) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap3) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap3) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap3) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap3) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np3) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp3) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"> <strong>b.</strong> Tiene un adecuado manejo y control del Grupo..</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp3) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp3) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong>Tiene orden, claridad y coherencia en los temas tratados.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp3) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp3) ; ?>%</span></font></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="83"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="56"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="147"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="83"><font size="1" face="tahoma"><strong class="style1 style7">PUNTUALIDAD EN COMPROMISOS ACAD&Eacute;MICOS</strong>&nbsp; </font></td>
    <td width="56"><font size="1" face="tahoma">El docente cumple con las actividades acad&eacute;micas definidas?</font></td>
    <td width="60"><div align="center">
      <table width="98%" height="66"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp4) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep4) ; ?></span><span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="147"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong>Asiste a las clases programadas del semestre.</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap4) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap4) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap4) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap4) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap4) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np4) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp4) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong>Cumple los horarios establecidos para las tutor&iacute;as o asesor&iacute;as.</font></td>
  <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp4) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp4) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Inicia y termina las clases a las horas establecidas. </font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp4) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp4) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="83"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="56"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="147"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="39"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="53"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="83"><font size="1" face="tahoma"> <strong class="style1 style7">RELACIONES INTER-PERSONALES</strong> </font></td>
    <td width="56"><font size="1" face="tahoma">La relaci&oacute;n personal establecida entre los estudiantes y el docente, es adecuada para el desarrollo de la asignatura?</font></td>
    <td width="60"><div align="center">
      <table width="100%" height="119"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp5) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td height="63"><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep5) ; ?></span><span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="147"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 
      Manifiesta respecto y tolerancia con los estudiantes.</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap5) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap5) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap5) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap5) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap5) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np5) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp5) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"> <strong>b.</strong>Establece las pautas para el trabajo en grupo desde el comienzo de semestre.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp5) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp5) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Promueve la participaci&oacute;n de equipos de trabajo en encuentros acad&eacute;micos con la comunidad acad&eacute;mica dentro y fuera de la universidad.</font></td>
     <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp5) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp5) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="83"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="56"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="146"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="39"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="53"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="83"><font size="1" face="tahoma"><strong class="style1 style7">APOYO AL TRABAJO DE LOS ESTUDIANTES</strong>&nbsp; </font></td>
    <td width="56"><font size="1" face="tahoma">El estudiante encuentra el apoyo necesario por parte del docente en su proceso de aprendizaje?</font></td>
    <td width="61"><div align="center">
      <table width="102%" height="99"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp6) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep6) ; ?></span><span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="146"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 
      Realiza actividades y promueve espacios adicionales que ayuden al estudiante a comprender los temas de la asignatura.</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap6) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap6) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap6) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap6) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap6) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np6) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp6) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong> Hace seguimiento al trabajo individual del estudiante.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp6) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp6) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Resuelve adecuadamente las inquietudes presentadas por los estudiantes.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp6) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp6) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="83"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="57"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="146"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="39"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="51"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="52"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="83"><font size="1" face="tahoma"><strong class="style1 style7">APOYO A LA INVES-TIGACIÓN</strong>&nbsp; </font></td>
    <td width="57"><font size="1" face="tahoma">El docente promociona de la formaci&oacute;n investigativa?</font></td>
    <td width="60"><div align="center">
      <table width="110%" height="53"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp7) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep7) ; ?></span><span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="146"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 
      Genera espacios en sus asignaturas para investigar y profundizar sobre diferentes temas.</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap7) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap7) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap7) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap7) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap7) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np7) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp7) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong>Actualiza los contenidos de las asignaturas a partir de nuevas investigaciones y conceptos.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp7) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp7) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Desarrolla proyectos de investigaci&oacute;n conjuntos con otras disciplinas.</font></td>
     <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp7) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp7) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="83"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="57"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="146"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="39"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="53"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="83"><font size="1" face="tahoma"><strong class="style1 style7">EVALUACIÓN DEL  APRENDIZAJE </strong></font></td>
    <td width="57"><font size="1" face="tahoma">El sistema de evaluaci&oacute;n aplicado promueve la formaci&oacute;n profesional?</font></td>
    <td width="60"><div align="center">
      <table width="126%"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp8) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td height="39"><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep8) ; ?></span><span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="146"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a. </strong>Las evaluaciones corresponden a los temas cubiertos dentro de la asignatura.</font></td>
   <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap8) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap8) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap8) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap8) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap8) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np8) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp8) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong> Realiza retroalimentaci&oacute;n a los estudiantes en su proceso de evaluaci&oacute;n.</font></td>
   <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp8) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp8) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Las notas de las evaluaciones se entregan oportunamente.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp8) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp8) ; ?>%</span></font></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="586" border="0" align="center" cellspacing="0">
  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 
    <td width="83"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 
        </strong> </font></div></td>
    <td width="58"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>
    <td width="63"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>
        (%)</strong> </span></font></div></td>
    <td width="142"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>
        </strong></span></font></div></td>
    <td width="46"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Exelente</strong> </span></font></div></td>
    <td width="34"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>Bueno</strong> </span></font></div></td>
    <td width="42"><font size="1" face="tahoma"><span class="style6"><strong>Regular</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Deficiente</strong></span></font></td>
    <td width="50"><font size="1" face="tahoma"><span class="style6"><strong>Noaplica</strong></span></font></td>
  </tr>
  <tr> 
    <td width="83"><font size="1" face="tahoma"><strong class="style1 style7">RECURSOS</strong>&nbsp; </font></td>
    <td width="58"><font size="1" face="tahoma">El sistema de evaluaci&oacute;n aplicado promueve la formaci&oacute;n profesional?</font></td>
    <td width="63"><div align="center">
      <table width="156%" height="62"  border="0">
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcentp9) ; ?>%</span></font></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="1" face="tahoma"><strong>B</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep9) ; ?></span><span class="style1 style7">%</span></font></div></td>
        </tr>
      </table>
      <font size="1" face="tahoma"></font></div></td>
    <td width="142"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a. </strong>Utilizaci&oacute;n de alg&uacute;n tipo de ayudas did&aacute;cticas o audiovisuales. </font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcexeap9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcbunap9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregap9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefap9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopap9) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np9) ; ?></strong></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><strong>R</strong><span class="style8"> 
        <?php printf ( "%.2f", $porcenbp9) ; ?>%</span></font></div></td>
    <td><font size="1" face="tahoma"><strong>b.</strong> Utilizaci&oacute;n de recursos bibliogr&aacute;ficos, lecturas y material impreso.</font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexebp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunbp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregbp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefbp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopbp9) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><font size="1" face="tahoma">&nbsp;</font></td>
    <td><div align="center" class="style8"> </div>
      <div align="center"><font size="1" face="tahoma"><strong>D</strong> <span class="style8"><?php printf ( "%.2f", $porcendp9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>d.</strong> Adecuada orientaci&oacute;n para la utilizaci&oacute;n de los recursos bibliogr&aacute;ficos e inform&aacute;ticos.</font></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexecp9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbuncp9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregcp9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefcp9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopcp9) ; ?>%</span></font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="tahoma"></font></div></td>
    <td><font size="1" face="tahoma"><strong>d.</strong> Las evaluaciones son 
      objetivas y equitativas. </font></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexedp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbundp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregdp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefdp9) ; ?>%</span></font></div></td>
    <td><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopdp9) ; ?>%</span></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>e.</strong> Adecuada distribuci&oacute;n de salones de clase, laboratorios y salas de inform&aacute;tica.</font></td>
   <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcexeep9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcbunep9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcregep9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdefep9) ; ?>%</span></font></div></td>
    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcnopep9) ; ?>%</span></font></div></td>
  </tr>
</table>
<table width="586" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      
    <td bgcolor="#C5D5D6" class="style2"><div align="center"><font size="1" face="tahoma"><strong>OBSERVACIONES:</strong></font></div></td>
    </tr>
    <tr> 
      <td> <font size="1" face="tahoma"> 
        <?php 
$obse = "SELECT observaciones FROM respuestas where codigoperiodo=20082 and idgrupo='$yui' and codigodocente = '$li'";
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
  		{ //echo "DEBEN ESTAR LLENOS  TODOS LOS CAMPO";
		
  		}?>
<?php } ?>
</font> 

<p align="center">&nbsp;</p>
  <p>&nbsp; </p>
  <p align="center" class="style1">&nbsp; </p>
</div>
</body>
</html>






