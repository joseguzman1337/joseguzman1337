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

<div align="center" class="Estilo3">

<?php



	$posicion = $_SESSION['codigofacultad'];

	//echo "<h1>$posicion</h1>";

	

	?>

	<table width="586" align="center" border="0">

      <tr> 

        <td><div align="center"><img src="<?php echo $posicion?>.jpg"></div></td>

      </tr>

    </table>



  <?php 

        $sss="select distinct d.nombredocente,d.apellidodocente,d.numerodocumento,e.codigocarrera,c.nombrecarrera 

from docente d,respuestas r,grupo g,evafacultad e,carrera c

where r.codigodocente=d.numerodocumento

and d.numerodocumento=g.numerodocumento

and g.idgrupo=r.idgrupo

and r.codigoestudiante=e.codigoestudiante

and e.codigocarrera='$posicion'

and c.codigocarrera=e.codigocarrera

order by d.nombredocente";

//echo $sss;

	  $sultado=mysql_query($sss,$sala)or die("$sss".mysql_error());

		 //echo $query_data;

		 //exit();

		 //$data = mysql_query($query_data, $sala) 

		 //$totalRows_data = mysql_num_rows($data);

		 $row_data = mysql_fetch_assoc($sultado);

if ($row_data == "")

{

echo "<script>window.location.reload('comunicado.php');</script>";

} 

else

{         

?>



    </p>

</div>

  <table width="586" height="200" align="center" background="borde.jpg">

    <tr> 

      <td> 
<?php
if ($row_data <> "")

 { 

?>

        <br> 

        <?php		  

		  }

?>

        <table width="95%" border="0" align="center" cellpadding="3" bordercolor="#ffffff">

          <tr bgcolor='#FFFFFF'> 

            <td class="Estilo2">&nbsp;Fecha de la Solicitud:</td>

            <td class="Estilo1"><?php echo date("j-n-Y g:i",time())?>&nbsp; <input name="hora" type="hidden" id="hora3" value="<?php echo time()?>">

              <span class="Estilo16"> </span></td>

          </tr>

          <tr bgcolor='#FFFFFF'> 

            <td class="Estilo2">&nbsp;Docente Evaluado:</td>

            <td class="Estilo1"> <select name="odigodocente" id="select11" onChange="enviar()">

                <option value="0" <?php if (!(strcmp("0", $_POST['odigodocente']))) {echo "SELECTED";} ?>>Seleccionar</option>

                <?php

      do {  

?>

                <option value="<?php echo $row_data['numerodocumento']?>"<?php if (!(strcmp($row_data['numerodocumento'], $_POST['odigodocente']))) {echo "SELECTED";} ?>><?php echo $row_data['nombredocente'];?>&nbsp;<?php echo $row_data['apellidodocente'];?></option>

                <?php

				

      } while ($row_data = mysql_fetch_assoc($sultado));

		  $rows = mysql_num_rows($sultado);

		  if($rows > 0) 

		  {

			  mysql_data_seek($car, 0);

			  $row_data = mysql_fetch_assoc($sultado);

		  }

		$paz=1;  

?>

              </select></td>

          </tr>

          <tr bgcolor='#FFFFFF'> 

            <td class="Estilo2">&nbsp;Materia Evaluada:</td>

            <td class="Estilo1"> 

              <?php 

        if ($_POST['odigodocente'] <> 0)

         {  // if 1  

			$fecha = date("Y-m-d G:i:s",time());

			$_SESSION['codigodocente']= $_POST['odigodocente'];

			//echo $_POST['odigodocente'];

			$query_car = "SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente,m.nombremateria,m.codigomateria FROM docente d, respuestas r,materia m where d.numerodocumento=r.codigodocente and m.codigomateria=r.codigomateria and r.codigodocente='".$_POST['odigodocente']."' ORDER BY m.nombremateria";

			//echo $query_car;

			$car = mysql_query($query_car, $sala) or die(mysql_error());

			$row_car = mysql_fetch_assoc($car);

			$totalRows_car = mysql_num_rows($car);

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

                <option value="<?php echo $row_car['codigomateria']?>"<?php if (!(strcmp($row_car['codigomateria'], $_POST['odigomateria']))) {echo "SELECTED";} ?>><?php echo $row_car['nombremateria']?></option>

                <?php

				

				} while ($row_car = mysql_fetch_assoc($car));

				  $rows = mysql_num_rows($car);

				  if($rows > 0) {

					  mysql_data_seek($car, 0);

					  $row_car = mysql_fetch_assoc($car);

				  }

				  $paz=2;

?>

              </select></td>

          </tr>

          <tr bgcolor='#FFFFFF'> 

            <td class="Estilo2">&nbsp;Grupo que Evaluo:</td>

            <td class="Estilo1"><span class="Estilo16"> 

              <?php 

			  

        if ($_POST['odigomateria'] <> 0)

         {  // if 1  

			$query_periodo = "SELECT DISTINCT idgrupo FROM respuestas where codigodocente='".$_POST['odigodocente']."' and codigomateria='".$_POST['odigomateria']."' ORDER BY idgrupo";

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

$nom=$aest['nombredocente'];

$ape=$aest['apellidodocente'];

//$li=$_GET['no'];

$li = $_SESSION['codigodocente'];

//echo $li;

$minom=$_GET['om'];

$miape=$_GET['pe'];

$digo=$_GET['di'];

$oon=$_GET['ii'];

$fa=$_GET['ggg'];

//$yui=$_GET['rdi'];

//$yui= $_POST['grupito'];

$yui = $_SESSION['idgrupo'];

//echo $paz;

$pie=$_GET['mano'];



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

$sql_horario= "SELECT  horainicial,horafinal FROM horario where idgrupo = '$yui' ";

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



$sql_noencuestas= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li'";

$resultadonoencuestas=mysql_query($sql_noencuestas,$sala);

$contanoencuestas=0;

while ($filanoencuestas=mysql_fetch_array($resultadonoencuestas))

{

$contanoencuestas++;

}



//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;

$sql_rp1e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp1 = 'e'";

$resultadorp1e=mysql_query($sql_rp1e,$sala);

$contarp1e=0;

while ($filarp1e=mysql_fetch_array($resultadorp1e))

{

$contarp1e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep1 =($contarp1e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp1b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp1 = 'b'";

$resultadorp1b=mysql_query($sql_rp1b,$sala);

$contarp1b=0;

while ($filarp1b=mysql_fetch_array($resultadorp1b))

{

$contarp1b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp1=($contarp1b/$contanoencuestas)*100;

$np1=($porcenep1+$porcenbp1)/20;

//

$sql_rp1b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp1 = 'r'";

$resultadorp1d=mysql_query($sql_rp1b,$sala);

$contarp1d=0;

while ($filarp1d=mysql_fetch_array($resultadorp1d))

{

$contarp1d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp1=($contarp1d/$contanoencuestas)*100;

//

$sql_rp1p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp1 = 'm'";

$resultadorp1p=mysql_query($sql_rp1p,$sala);

$contarp1p=0;

while ($filarp1p=mysql_fetch_array($resultadorp1p))

{

$contarp1p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp1=($contarp1p/$contanoencuestas)*100;

//

$sql_rp1desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa1 = 'd'";

$resp1desa=mysql_query($sql_rp1desa,$sala);

$contarp1desa=0;

while ($filp1desa=mysql_fetch_array($resp1desa))

{

$contarp1desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap1=($contarp1desa/$contanoencuestas)*100;

//

$sql_rp1desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb1 = 'd' ";

$resp1desb=mysql_query($sql_rp1desb,$sala);

$contarp1desb=0;

while ($filp1desb=mysql_fetch_array($resp1desb))

{

$contarp1desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp1=($contarp1desb/$contanoencuestas)*100;

//

$sql_rp1desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc1 = 'd'";

$resp1desc=mysql_query($sql_rp1desc,$sala);

$contarp1desc=0;

while ($filp1desc=mysql_fetch_array($resp1desc))

{

$contarp1desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp1=($contarp1desc/$contanoencuestas)*100;

//

$sql_rp1desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd1 = 'd'";

$resp1desd=mysql_query($sql_rp1desd,$sala);

$contarp1desd=0;

while ($filp1desd=mysql_fetch_array($resp1desd))

{

$contarp1desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp1=($contarp1desd/$contanoencuestas)*100;

//

//

$sql_rp1meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa1 = 'm'";

$resp1meja=mysql_query($sql_rp1meja,$sala);

$contarp1meja=0;

while ($filp1meja=mysql_fetch_array($resp1meja))

{

$contarp1meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap1=($contarp1meja/$contanoencuestas)*100;

//

$sql_rp1mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb1 = 'm' ";

$resp1mejb=mysql_query($sql_rp1mejb,$sala);

$contarp1mejb=0;

while ($filp1mejb=mysql_fetch_array($resp1mejb))

{

$contarp1mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp1=($contarp1mejb/$contanoencuestas)*100;

//

$sql_rp1mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc1 = 'm' ";

$resp1mejc=mysql_query($sql_rp1mejc,$sala);

$contarp1mejc=0;

while ($filp1mejc=mysql_fetch_array($resp1mejc))

{

$contarp1mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp1=($contarp1mejc/$contanoencuestas)*100;

//

$sql_rp1mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd1 = 'm'  ";

$resp1mejd=mysql_query($sql_rp1mejd,$sala);

$contarp1mejd=0;

while ($filp1mejd=mysql_fetch_array($resp1mejd))

{

$contarp1mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp1=($contarp1mejd/$contanoencuestas)*100;

//

//2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222

$sql_rp2e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp2 = 'e'";

$resultadorp2e=mysql_query($sql_rp2e,$sala);

$contarp2=0;

while ($filarp2e=mysql_fetch_array($resultadorp2e))

{

$contarp2e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep2 =($contarp2e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp2b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp2 = 'b'";

$resultadorp2b=mysql_query($sql_rp2b,$sala);

$contarp2b=0;

while ($filarp2b=mysql_fetch_array($resultadorp2b))

{

$contarp2b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp2=($contarp2b/$contanoencuestas)*100;

$np2=($porcenep2+$porcenbp2)/20;

//

$sql_rp2b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp2 = 'r'";

$resultadorp2d=mysql_query($sql_rp2b,$sala);

$contarp2d=0;

while ($filarp2d=mysql_fetch_array($resultadorp2d))

{

$contarp2d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp2=($contarp2d/$contanoencuestas)*100;

//

$sql_rp2p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp2 = 'm'";

$resultadorp2p=mysql_query($sql_rp2p,$sala);

$contarp2p=0;

while ($filarp2p=mysql_fetch_array($resultadorp2p))

{

$contarp2p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp2=($contarp2p/$contanoencuestas)*100;

//

$sql_rp2desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa2 = 'd'";

$resp2desa=mysql_query($sql_rp2desa,$sala);

$contarp2desa=0;

while ($filp2desa=mysql_fetch_array($resp2desa))

{

$contarp2desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap2=($contarp2desa/$contanoencuestas)*100;

//

$sql_rp2desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb2 = 'd' ";

$resp2desb=mysql_query($sql_rp2desb,$sala);

$contarp2desb=0;

while ($filp2desb=mysql_fetch_array($resp2desb))

{

$contarp2desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp2=($contarp2desb/$contanoencuestas)*100;

//

$sql_rp2desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc2 = 'd'";

$resp2desc=mysql_query($sql_rp2desc,$sala);

$contarp2desc=0;

while ($filp2desc=mysql_fetch_array($resp2desc))

{

$contarp2desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp2=($contarp2desc/$contanoencuestas)*100;

//

$sql_rp2desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd2 = 'd'";

$resp2desd=mysql_query($sql_rp2desd,$sala);

$contarp2desd=0;

while ($filp2desd=mysql_fetch_array($resp2desd))

{

$contarp2desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp2=($contarp2desd/$contanoencuestas)*100;

//

//

$sql_rp2meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa2 = 'm'";

$resp2meja=mysql_query($sql_rp2meja,$sala);

$contarp2meja=0;

while ($filp2meja=mysql_fetch_array($resp2meja))

{

$contarp2meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap2=($contarp2meja/$contanoencuestas)*100;

//

$sql_rp2mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb2 = 'm' ";

$resp2mejb=mysql_query($sql_rp2mejb,$sala);

$contarp2mejb=0;

while ($filp2mejb=mysql_fetch_array($resp2mejb))

{

$contarp2mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp2=($contarp2mejb/$contanoencuestas)*100;

//

$sql_rp2mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc2 = 'm' ";

$resp2mejc=mysql_query($sql_rp2mejc,$sala);

$contarp2mejc=0;

while ($filp2mejc=mysql_fetch_array($resp2mejc))

{

$contarp2mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp2=($contarp2mejc/$contanoencuestas)*100;

//

$sql_rp2mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd2 = 'm'  ";

$resp2mejd=mysql_query($sql_rp2mejd,$sala);

$contarp2mejd=0;

while ($filp2mejd=mysql_fetch_array($resp2mejd))

{

$contarp2mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp2=($contarp2mejd/$contanoencuestas)*100;

//

//333333333333333333333333333333333333333333333333333333333333333333333333333333333

$sql_rp3e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp3 = 'e'";

$resultadorp3e=mysql_query($sql_rp3e,$sala);

$contarp3=0;

while ($filarp3e=mysql_fetch_array($resultadorp3e))

{

$contarp3e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep3 =($contarp3e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp3b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp3 = 'b'";

$resultadorp3b=mysql_query($sql_rp3b,$sala);

$contarp3b=0;

while ($filarp3b=mysql_fetch_array($resultadorp3b))

{

$contarp3b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp3=($contarp3b/$contanoencuestas)*100;

$np3=($porcenep3+$porcenbp3)/20;

//

$sql_rp3b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp3 = 'r'";

$resultadorp3d=mysql_query($sql_rp3b,$sala);

$contarp3d=0;

while ($filarp3d=mysql_fetch_array($resultadorp3d))

{

$contarp3d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp3=($contarp3d/$contanoencuestas)*100;

//

$sql_rp3p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp3 = 'm'";

$resultadorp3p=mysql_query($sql_rp3p,$sala);

$contarp3p=0;

while ($filarp3p=mysql_fetch_array($resultadorp3p))

{

$contarp3p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp3=($contarp3p/$contanoencuestas)*100;

//

$sql_rp3desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa3 = 'd'";

$resp3desa=mysql_query($sql_rp3desa,$sala);

$contarp2desa=0;

while ($filp3desa=mysql_fetch_array($resp3desa))

{

$contarp3desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap3=($contarp3desa/$contanoencuestas)*100;

//

$sql_rp3desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb3 = 'd' ";

$resp3desb=mysql_query($sql_rp3desb,$sala);

$contarp3desb=0;

while ($filp3desb=mysql_fetch_array($resp3desb))

{

$contarp3desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp3=($contarp3desb/$contanoencuestas)*100;

//

$sql_rp3desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc3 = 'd'";

$resp3desc=mysql_query($sql_rp3desc,$sala);

$contarp3desc=0;

while ($filp3desc=mysql_fetch_array($resp3desc))

{

$contarp3desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp3=($contarp3desc/$contanoencuestas)*100;

//

$sql_rp3desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd3 = 'd'";

$resp3desd=mysql_query($sql_rp3desd,$sala);

$contarp3desd=0;

while ($filp3desd=mysql_fetch_array($resp3desd))

{

$contarp3desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp3=($contarp3desd/$contanoencuestas)*100;

//

//

$sql_rp3meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa3 = 'm'";

$resp3meja=mysql_query($sql_rp3meja,$sala);

$contarp3meja=0;

while ($filp3meja=mysql_fetch_array($resp3meja))

{

$contarp3meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap3=($contarp3meja/$contanoencuestas)*100;

//

$sql_rp3mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb3 = 'm' ";

$resp3mejb=mysql_query($sql_rp3mejb,$sala);

$contarp3mejb=0;

while ($filp3mejb=mysql_fetch_array($resp3mejb))

{

$contarp3mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp3=($contarp3mejb/$contanoencuestas)*100;

//

$sql_rp3mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc3 = 'm' ";

$resp3mejc=mysql_query($sql_rp3mejc,$sala);

$contarp3mejc=0;

while ($filp3mejc=mysql_fetch_array($resp3mejc))

{

$contarp3mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp3=($contarp3mejc/$contanoencuestas)*100;

//

$sql_rp3mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd3 = 'm'  ";

$resp3mejd=mysql_query($sql_rp3mejd,$sala);

$contarp3mejd=0;

while ($filp3mejd=mysql_fetch_array($resp3mejd))

{

$contarp3mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp3=($contarp3mejd/$contanoencuestas)*100;

//

//444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;

$sql_rp4e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp4 = 'e'";

$resultadorp4e=mysql_query($sql_rp4e,$sala);

$contarp4e=0;

while ($filarp4e=mysql_fetch_array($resultadorp4e))

{

$contarp4e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep4 =($contarp4e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp4b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp4 = 'b'";

$resultadorp4b=mysql_query($sql_rp4b,$sala);

$contarp4b=0;

while ($filarp4b=mysql_fetch_array($resultadorp4b))

{

$contarp4b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp4=($contarp4b/$contanoencuestas)*100;

$np4=($porcenep4+$porcenbp4)/20;

//

$sql_rp4b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp4 = 'r'";

$resultadorp4d=mysql_query($sql_rp4b,$sala);

$contarp4d=0;

while ($filarp4d=mysql_fetch_array($resultadorp4d))

{

$contarp4d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp4=($contarp4d/$contanoencuestas)*100;

//

$sql_rp4p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp4 = 'm'";

$resultadorp4p=mysql_query($sql_rp4p,$sala);

$contarp4p=0;

while ($filarp4p=mysql_fetch_array($resultadorp4p))

{

$contarp4p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp4=($contarp4p/$contanoencuestas)*100;

//

$sql_rp4desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa4 = 'd'";

$resp4desa=mysql_query($sql_rp4desa,$sala);

$contarp4desa=0;

while ($filp4desa=mysql_fetch_array($resp4desa))

{

$contarp4desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap4=($contarp4desa/$contanoencuestas)*100;

//

$sql_rp4desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb4 = 'd' ";

$resp4desb=mysql_query($sql_rp4desb,$sala);

$contarp4desb=0;

while ($filp4desb=mysql_fetch_array($resp4desb))

{

$contarp4desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp4=($contarp4desb/$contanoencuestas)*100;

//

$sql_rp4desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc4 = 'd'";

$resp4desc=mysql_query($sql_rp4desc,$sala);

$contarp4desc=0;

while ($filp4desc=mysql_fetch_array($resp4desc))

{

$contarp4desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp4=($contarp4desc/$contanoencuestas)*100;

//

$sql_rp4desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd4 = 'd'";

$resp4desd=mysql_query($sql_rp4desd,$sala);

$contarp4desd=0;

while ($filp4desd=mysql_fetch_array($resp4desd))

{

$contarp4desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp4=($contarp4desd/$contanoencuestas)*100;

//

//

$sql_rp4meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa4 = 'm'";

$resp4meja=mysql_query($sql_rp4meja,$sala);

$contarp4meja=0;

while ($filp4meja=mysql_fetch_array($resp4meja))

{

$contarp4meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap4=($contarp4meja/$contanoencuestas)*100;

//

$sql_rp4mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb4 = 'm' ";

$resp4mejb=mysql_query($sql_rp4mejb,$sala);

$contarp4mejb=0;

while ($filp4mejb=mysql_fetch_array($resp4mejb))

{

$contarp4mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp4=($contarp4mejb/$contanoencuestas)*100;

//

$sql_rp4mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc4 = 'm' ";

$resp4mejc=mysql_query($sql_rp4mejc,$sala);

$contarp4mejc=0;

while ($filp4mejc=mysql_fetch_array($resp4mejc))

{

$contarp4mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 4 son:".$contarp1mejc;

@$porcmejcp4=($contarp4mejc/$contanoencuestas)*100;

//

$sql_rp4mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd4 = 'm'  ";

$resp4mejd=mysql_query($sql_rp4mejd,$sala);

$contarp4mejd=0;

while ($filp4mejd=mysql_fetch_array($resp4mejd))

{

$contarp4mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp4=($contarp4mejd/$contanoencuestas)*100;

//

//55555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555

//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp5;

$sql_rp5e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp5 = 'e'";

$resultadorp5e=mysql_query($sql_rp5e,$sala);

$contarp5e=0;

while ($filarp5e=mysql_fetch_array($resultadorp5e))

{

$contarp5e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep5 =($contarp5e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp5b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp5 = 'b'";

$resultadorp5b=mysql_query($sql_rp5b,$sala);

$contarp5b=0;

while ($filarp5b=mysql_fetch_array($resultadorp5b))

{

$contarp5b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp5=($contarp5b/$contanoencuestas)*100;

$np5=($porcenep5+$porcenbp5)/20;

//

$sql_rp5b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp5 = 'r'";

$resultadorp5d=mysql_query($sql_rp5b,$sala);

$contarp5d=0;

while ($filarp5d=mysql_fetch_array($resultadorp5d))

{

$contarp5d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp5=($contarp5d/$contanoencuestas)*100;

//

$sql_rp5p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp5 = 'm'";

$resultadorp5p=mysql_query($sql_rp5p,$sala);

$contarp5p=0;

while ($filarp5p=mysql_fetch_array($resultadorp5p))

{

$contarp5p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp5=($contarp5p/$contanoencuestas)*100;

//

$sql_rp5desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa5 = 'd'";

$resp5desa=mysql_query($sql_rp5desa,$sala);

$contarp5desa=0;

while ($filp5desa=mysql_fetch_array($resp5desa))

{

$contarp5desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap5=($contarp5desa/$contanoencuestas)*100;

//

$sql_rp5desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb5 = 'd' ";

$resp5desb=mysql_query($sql_rp5desb,$sala);

$contarp5desb=0;

while ($filp5desb=mysql_fetch_array($resp5desb))

{

$contarp5desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp5=($contarp5desb/$contanoencuestas)*100;

//

$sql_rp5desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc5 = 'd'";

$resp5desc=mysql_query($sql_rp5desc,$sala);

$contarp5desc=0;

while ($filp5desc=mysql_fetch_array($resp5desc))

{

$contarp5desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp5=($contarp5desc/$contanoencuestas)*100;

//

$sql_rp5desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd5 = 'd'";

$resp5desd=mysql_query($sql_rp5desd,$sala);

$contarp5desd=0;

while ($filp5desd=mysql_fetch_array($resp5desd))

{

$contarp5desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp5=($contarp5desd/$contanoencuestas)*100;

//

//

$sql_rp5meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa5 = 'm'";

$resp5meja=mysql_query($sql_rp5meja,$sala);

$contarp5meja=0;

while ($filp5meja=mysql_fetch_array($resp5meja))

{

$contarp5meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap5=($contarp5meja/$contanoencuestas)*100;

//

$sql_rp5mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb5 = 'm' ";

$resp5mejb=mysql_query($sql_rp5mejb,$sala);

$contarp5mejb=0;

while ($filp5mejb=mysql_fetch_array($resp5mejb))

{

$contarp5mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp5=($contarp5mejb/$contanoencuestas)*100;

//

$sql_rp5mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc5 = 'm' ";

$resp5mejc=mysql_query($sql_rp5mejc,$sala);

$contarp5mejc=0;

while ($filp5mejc=mysql_fetch_array($resp5mejc))

{

$contarp5mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp5=($contarp5mejc/$contanoencuestas)*100;

//

$sql_rp5mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd5 = 'm'  ";

$resp5mejd=mysql_query($sql_rp5mejd,$sala);

$contarp5mejd=0;

while ($filp5mejd=mysql_fetch_array($resp5mejd))

{

$contarp5mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp5=($contarp5mejd/$contanoencuestas)*100;

//

//66666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;

$sql_rp6e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp6 = 'e'";

$resultadorp6e=mysql_query($sql_rp6e,$sala);

$contarp6e=0;

while ($filarp6e=mysql_fetch_array($resultadorp6e))

{

$contarp6e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep6 =($contarp6e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp6b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp6 = 'b'";

$resultadorp6b=mysql_query($sql_rp6b,$sala);

$contarp6b=0;

while ($filarp6b=mysql_fetch_array($resultadorp6b))

{

$contarp6b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp6=($contarp6b/$contanoencuestas)*100;

$np6=($porcenep6+$porcenbp6)/20;

//

$sql_rp6b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp6 = 'r'";

$resultadorp6d=mysql_query($sql_rp6b,$sala);

$contarp6d=0;

while ($filarp6d=mysql_fetch_array($resultadorp6d))

{

$contarp6d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp6=($contarp6d/$contanoencuestas)*100;

//

$sql_rp6p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp6 = 'm'";

$resultadorp6p=mysql_query($sql_rp6p,$sala);

$contarp6p=0;

while ($filarp6p=mysql_fetch_array($resultadorp6p))

{

$contarp6p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp6=($contarp6p/$contanoencuestas)*100;

//

$sql_rp6desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa6 = 'd'";

$resp6desa=mysql_query($sql_rp6desa,$sala);

$contarp6desa=0;

while ($filp6desa=mysql_fetch_array($resp6desa))

{

$contarp6desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap6=($contarp6desa/$contanoencuestas)*100;

//

$sql_rp6desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb6 = 'd' ";

$resp6desb=mysql_query($sql_rp6desb,$sala);

$contarp6desb=0;

while ($filp6desb=mysql_fetch_array($resp6desb))

{

$contarp6desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp6=($contarp6desb/$contanoencuestas)*100;

//

$sql_rp6desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc6 = 'd'";

$resp6desc=mysql_query($sql_rp6desc,$sala);

$contarp6desc=0;

while ($filp6desc=mysql_fetch_array($resp6desc))

{

$contarp6desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp6=($contarp6desc/$contanoencuestas)*100;

//

$sql_rp6desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd6 = 'd'";

$resp6desd=mysql_query($sql_rp6desd,$sala);

$contarp6desd=0;

while ($filp6desd=mysql_fetch_array($resp6desd))

{

$contarp6desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp6=($contarp6desd/$contanoencuestas)*100;

//

//

$sql_rp6meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa6 = 'm'";

$resp6meja=mysql_query($sql_rp6meja,$sala);

$contarp6meja=0;

while ($filp6meja=mysql_fetch_array($resp6meja))

{

$contarp6meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap6=($contarp6meja/$contanoencuestas)*100;

//

$sql_rp6mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb6 = 'm' ";

$resp6mejb=mysql_query($sql_rp6mejb,$sala);

$contarp6mejb=0;

while ($filp6mejb=mysql_fetch_array($resp6mejb))

{

$contarp6mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp6=($contarp6mejb/$contanoencuestas)*100;

//

$sql_rp6mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc6 = 'm' ";

$resp6mejc=mysql_query($sql_rp6mejc,$sala);

$contarp6mejc=0;

while ($filp6mejc=mysql_fetch_array($resp6mejc))

{

$contarp6mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp6=($contarp6mejc/$contanoencuestas)*100;

//

$sql_rp6mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd6 = 'm'  ";

$resp6mejd=mysql_query($sql_rp6mejd,$sala);

$contarp6mejd=0;

while ($filp6mejd=mysql_fetch_array($resp6mejd))

{

$contarp6mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp6=($contarp6mejd/$contanoencuestas)*100;

//

//777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;

$sql_rp7e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp7 = 'e'";

$resultadorp7e=mysql_query($sql_rp7e,$sala);

$contarp7e=0;

while ($filarp7e=mysql_fetch_array($resultadorp7e))

{

$contarp7e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep7 =($contarp7e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp7b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp7 = 'b'";

$resultadorp7b=mysql_query($sql_rp7b,$sala);

$contarp7b=0;

while ($filarp7b=mysql_fetch_array($resultadorp7b))

{

$contarp7b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp7=($contarp7b/$contanoencuestas)*100;

$np7=($porcenep7+$porcenbp7)/20;

//

$sql_rp7b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp7 = 'r'";

$resultadorp7d=mysql_query($sql_rp7b,$sala);

$contarp7d=0;

while ($filarp7d=mysql_fetch_array($resultadorp7d))

{

$contarp7d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp7=($contarp7d/$contanoencuestas)*100;

//

$sql_rp7p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp7 = 'm'";

$resultadorp7p=mysql_query($sql_rp7p,$sala);

$contarp7p=0;

while ($filarp7p=mysql_fetch_array($resultadorp7p))

{

$contarp7p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp7=($contarp7p/$contanoencuestas)*100;

//

$sql_rp7desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa7 = 'd'";

$resp7desa=mysql_query($sql_rp7desa,$sala);

$contarp7desa=0;

while ($filp7desa=mysql_fetch_array($resp7desa))

{

$contarp7desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap7=($contarp7desa/$contanoencuestas)*100;

//

$sql_rp7desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb7 = 'd' ";

$resp7desb=mysql_query($sql_rp7desb,$sala);

$contarp7desb=0;

while ($filp7desb=mysql_fetch_array($resp7desb))

{

$contarp7desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp7=($contarp7desb/$contanoencuestas)*100;

//

$sql_rp7desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc7 = 'd'";

$resp7desc=mysql_query($sql_rp7desc,$sala);

$contarp7desc=0;

while ($filp7desc=mysql_fetch_array($resp7desc))

{

$contarp7desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp7=($contarp7desc/$contanoencuestas)*100;

//

$sql_rp7desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd7 = 'd'";

$resp7desd=mysql_query($sql_rp7desd,$sala);

$contarp7desd=0;

while ($filp7desd=mysql_fetch_array($resp7desd))

{

$contarp7desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp7=($contarp7desd/$contanoencuestas)*100;

//

//

$sql_rp7meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa7 = 'm'";

$resp7meja=mysql_query($sql_rp7meja,$sala);

$contarp7meja=0;

while ($filp7meja=mysql_fetch_array($resp7meja))

{

$contarp7meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap7=($contarp7meja/$contanoencuestas)*100;

//

$sql_rp7mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb7 = 'm' ";

$resp7mejb=mysql_query($sql_rp7mejb,$sala);

$contarp7mejb=0;

while ($filp7mejb=mysql_fetch_array($resp7mejb))

{

$contarp7mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp7=($contarp7mejb/$contanoencuestas)*100;

//

$sql_rp7mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc7 = 'm' ";

$resp7mejc=mysql_query($sql_rp7mejc,$sala);

$contarp7mejc=0;

while ($filp7mejc=mysql_fetch_array($resp7mejc))

{

$contarp7mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp7=($contarp7mejc/$contanoencuestas)*100;

//

$sql_rp7mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd7 = 'm'  ";

$resp7mejd=mysql_query($sql_rp7mejd,$sala);

$contarp7mejd=0;

while ($filp7mejd=mysql_fetch_array($resp7mejd))

{

$contarp7mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp7=($contarp7mejd/$contanoencuestas)*100;

//

//888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;

$sql_rp8e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp8 = 'e'";

$resultadorp8e=mysql_query($sql_rp8e,$sala);

$contarp8e=0;

while ($filarp8e=mysql_fetch_array($resultadorp8e))

{

$contarp8e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep8 =($contarp8e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp8b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp8 = 'b'";

$resultadorp8b=mysql_query($sql_rp8b,$sala);

$contarp8b=0;

while ($filarp8b=mysql_fetch_array($resultadorp8b))

{

$contarp8b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp8=($contarp8b/$contanoencuestas)*100;

$np8=($porcenep8+$porcenbp8)/20;

//

$sql_rp8b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp8 = 'r'";

$resultadorp8d=mysql_query($sql_rp8b,$sala);

$contarp8d=0;

while ($filarp8d=mysql_fetch_array($resultadorp8d))

{

$contarp8d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp8=($contarp8d/$contanoencuestas)*100;

//

$sql_rp8p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp8 = 'm'";

$resultadorp8p=mysql_query($sql_rp8p,$sala);

$contarp8p=0;

while ($filarp8p=mysql_fetch_array($resultadorp8p))

{

$contarp8p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp8=($contarp8p/$contanoencuestas)*100;

//

$sql_rp8desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa8 = 'd'";

$resp8desa=mysql_query($sql_rp8desa,$sala);

$contarp8desa=0;

while ($filp8desa=mysql_fetch_array($resp8desa))

{

$contarp8desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap8=($contarp8desa/$contanoencuestas)*100;

//

$sql_rp8desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb8 = 'd' ";

$resp8desb=mysql_query($sql_rp8desb,$sala);

$contarp8desb=0;

while ($filp8desb=mysql_fetch_array($resp8desb))

{

$contarp8desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp8=($contarp8desb/$contanoencuestas)*100;

//

$sql_rp8desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc8 = 'd'";

$resp8desc=mysql_query($sql_rp8desc,$sala);

$contarp8desc=0;

while ($filp8desc=mysql_fetch_array($resp8desc))

{

$contarp8desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp8=($contarp8desc/$contanoencuestas)*100;

//

$sql_rp8desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd8 = 'd'";

$resp8desd=mysql_query($sql_rp8desd,$sala);

$contarp8desd=0;

while ($filp8desd=mysql_fetch_array($resp8desd))

{

$contarp8desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp8=($contarp8desd/$contanoencuestas)*100;

//

//

$sql_rp8meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa8 = 'm'";

$resp8meja=mysql_query($sql_rp8meja,$sala);

$contarp8meja=0;

while ($filp8meja=mysql_fetch_array($resp8meja))

{

$contarp8meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap8=($contarp8meja/$contanoencuestas)*100;

//

$sql_rp8mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb8 = 'm' ";

$resp8mejb=mysql_query($sql_rp8mejb,$sala);

$contarp8mejb=0;

while ($filp8mejb=mysql_fetch_array($resp8mejb))

{

$contarp8mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp8=($contarp8mejb/$contanoencuestas)*100;

//

$sql_rp8mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc8 = 'm' ";

$resp8mejc=mysql_query($sql_rp8mejc,$sala);

$contarp8mejc=0;

while ($filp8mejc=mysql_fetch_array($resp8mejc))

{

$contarp8mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp8=($contarp8mejc/$contanoencuestas)*100;

//

$sql_rp8mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd8 = 'm'  ";

$resp8mejd=mysql_query($sql_rp8mejd,$sala);

$contarp8mejd=0;

while ($filp8mejd=mysql_fetch_array($resp8mejd))

{

$contarp8mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp8=($contarp8mejd/$contanoencuestas)*100;

//

//9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;

$sql_rp9e= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp9 = 'e'";

$resultadorp9e=mysql_query($sql_rp9e,$sala);

$contarp9e=0;

while ($filarp9e=mysql_fetch_array($resultadorp9e))

{

$contarp9e++;

}

//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;

@$porcenep9 =($contarp9e/$contanoencuestas)*100;

//echo "el porsentaje de la pregunta 1 e".$porcentagep1;

//echo $porcenep1;

//

$sql_rp9b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp9 = 'b'";

$resultadorp9b=mysql_query($sql_rp9b,$sala);

$contarp9b=0;

while ($filarp9b=mysql_fetch_array($resultadorp9b))

{

$contarp9b++;

}

//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;

@$porcenbp9=($contarp9b/$contanoencuestas)*100;

$np9=($porcenep9+$porcenbp9)/20;

//

$sql_rp9b= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp9 = 'r'";

$resultadorp9d=mysql_query($sql_rp9b,$sala);

$contarp9d=0;

while ($filarp9d=mysql_fetch_array($resultadorp9d))

{

$contarp9d++;

}

//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;

@$porcendp9=($contarp9d/$contanoencuestas)*100;

//

$sql_rp9p= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and resp9 = 'm'";

$resultadorp9p=mysql_query($sql_rp9p,$sala);

$contarp9p=0;

while ($filarp9p=mysql_fetch_array($resultadorp9p))

{

$contarp9p++;

}

//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;

@$porcenpp9=($contarp9p/$contanoencuestas)*100;

//

$sql_rp9desa= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa9 = 'd'";

$resp9desa=mysql_query($sql_rp9desa,$sala);

$contarp9desa=0;

while ($filp9desa=mysql_fetch_array($resp9desa))

{

$contarp9desa++;

}

//echo "el numero de personas que respondieron desa a) de la pregunta 1 son:".$contarp1desa;

@$porcdesap9=($contarp9desa/$contanoencuestas)*100;

//

$sql_rp9desb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb9 = 'd' ";

$resp9desb=mysql_query($sql_rp9desb,$sala);

$contarp9desb=0;

while ($filp9desb=mysql_fetch_array($resp9desb))

{

$contarp9desb++;

}

//echo "el numero de personas que respondieron desa b) de la pregunta 1 son:".$contarp1desb;

@$porcdesbp9=($contarp9desb/$contanoencuestas)*100;

//

$sql_rp9desc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc9 = 'd'";

$resp9desc=mysql_query($sql_rp9desc,$sala);

$contarp9desc=0;

while ($filp9desc=mysql_fetch_array($resp9desc))

{

$contarp9desc++;

}

//echo "el numero de personas que respondieron desa c) de la pregunta 1 son:".$contarp1desc;

@$porcdescp9=($contarp9desc/$contanoencuestas)*100;

//

$sql_rp9desd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd9 = 'd'";

$resp9desd=mysql_query($sql_rp9desd,$sala);

$contarp9desd=0;

while ($filp9desd=mysql_fetch_array($resp9desd))

{

$contarp9desd++;

}

//echo "el numero de personas que respondieron desa d) de la pregunta 1 son:".$contarp1desd;

@$porcdesdp9=($contarp9desd/$contanoencuestas)*100;

//

//

$sql_rp9meja= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respa9 = 'm'";

$resp9meja=mysql_query($sql_rp9meja,$sala);

$contarp9meja=0;

while ($filp9meja=mysql_fetch_array($resp9meja))

{

$contarp9meja++;

}

//echo "el numero de personas que respondieron meja a) de la pregunta 1 son:".$contarp1meja;

@$porcmejap9=($contarp9meja/$contanoencuestas)*100;

//

$sql_rp9mejb= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respb9 = 'm' ";

$resp9mejb=mysql_query($sql_rp9mejb,$sala);

$contarp9mejb=0;

while ($filp9mejb=mysql_fetch_array($resp9mejb))

{

$contarp9mejb++;

}

//echo "el numero de personas que respondieron meja b) de la pregunta 1 son:".$contarp1mejb;

@$porcmejbp9=($contarp9mejb/$contanoencuestas)*100;

//

$sql_rp9mejc= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respc9 = 'm' ";

$resp9mejc=mysql_query($sql_rp9mejc,$sala);

$contarp9mejc=0;

while ($filp9mejc=mysql_fetch_array($resp9mejc))

{

$contarp9mejc++;

}

//echo "el numero de personas que respondieron mejc c) de la pregunta 1 son:".$contarp1mejc;

@$porcmejcp9=($contarp9mejc/$contanoencuestas)*100;

//

$sql_rp9mejd= "SELECT  distinct codigoestudiante  FROM respuestas where idgrupo = '$yui' and codigodocente = '$li' and respd9 = 'm'  ";

$resp9mejd=mysql_query($sql_rp9mejd,$sala);

$contarp9mejd=0;

while ($filp9mejd=mysql_fetch_array($resp9mejd))

{

$contarp9mejd++;

}

//echo "el numero de personas que respondieron mejd d) de la pregunta 1 son:".$contarp1mejd;

@$porcmejdp9=($contarp9mejd/$contanoencuestas)*100;



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

</font><font size="1" face="tahoma"><?php echo $oon?></font> 

<table width="586" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#000000">

  <tr> 

      

    <td width="351" height="23" class="style1"><div align="center"><font size="2" face="tahoma"><strong><font size="1">HORARIO 

        MATERIA</font> : <span class="style1"><strong><span class="style3"> 

        <?php $comiensoh = $filahorario['horainicial']; echo  $filahorario['horainicial']; ?>

        <font size="1"> a</font> 

        <?php $finh = $filahorario['horafinal']; echo  $filahorario['horafinal']; ?>

        </span></strong></span></strong></font></div></td>

      

    <td width="226"><div align="center"><font size="1" face="tahoma"><strong>NOTA TOTAL = </strong><strong class="Estilo4"><?php printf ( "%.2f", $tnp) ; ?></strong> </font> </div></td>

  </tr>

    <tr> 

      

    <td> <div align="center"><font size="1" face="tahoma"><strong class="style1">N&Uacute;MERO 

        DE ESTUDIANTES QUE REALIZARON LA EVALUACI&Oacute;N: </strong> </font></div></td>

      <td><div align="center"><font size="1" face="tahoma"><?php echo $contanoencuestas ?></font></div></td>

    </tr>

</table>

  

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="217"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="57"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma"><strong class="style1 style7">ASIGNATURA</strong></font></td>

    <td><font size="1" face="tahoma">El desarrollo de la asignatura es : </font></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>E</strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep1) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> Aporta nuevos conocimientos 

      y habilidades para la formaci&oacute;n profesional.</font></td>

    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap1) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap1) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np1) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B</strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp1) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Las lecturas y referentes 

      bibliogr&aacute;fico son los adecuados.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp1) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp1) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R</strong> <span class="style8"><?php printf ( "%.2f", $porcendp1) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Los recursos Inform&aacute;ticos, 

      audiovisuales, laboratorios y aulas, son adecuados. </font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp1) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp1) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp1) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Las actividades (ejercicios, 

      talleres, proyectos) Contribuyen al aprendizaje.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp1) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp1) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"><strong class="style1 style7"> 

      DOCENTE: PRESENTACIÓN DE LA ASIGNATURA </strong> </font></td>

    <td width="99"><font size="1" face="tahoma">La presentación y contextualización de la 

      asignatura por parte del docente, es:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong><span class="style1 style7"><?php printf ( "%.2f", $porcenep2) ; ?></span> 

        <span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Entrega formalmente el programa y reglas establecidas al comenzar el semestre. 

      </font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap2) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap2) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np2) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"><?php printf ( "%.2f", $porcenbp2) ; ?> 

        %</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Cumple con los objetivos 

      académicos definidos. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp2) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp2) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong><span class="style8"><?php printf ( "%.2f", $porcendp2) ; ?></span> 

        <span class="style8">%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Cumple 

      con los compromisos definidos.</font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp2) ; ?><font size="1" face="tahoma"><span class="style8">%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp2) ; ?><font size="1" face="tahoma"><span class="style8">%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp2) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> El desarrollo de la asignatura 

      le agrega valor a su formación </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp2) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp2) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"><strong class="style1 style7">CUMPLIMIENTO 

      ACTIVIDADES ACADEMICAS</strong></font></td>

    <td width="99"><font size="1" face="tahoma">El cumplimiento de las actividades 

      académicas por parte del docente es:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E</strong><span class="style1 style7"> 

        <?php printf ( "%.2f", $porcenep3) ; ?></span><strong> </strong> <span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Inicia y termina las clases a las horas establecidas</font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap3) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap3) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np3) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp3) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"> <strong>b.</strong> Asiste a las clases 

      programadas del semestre.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp3) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp3) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp3) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong>Cumple 

      los horarios establecidos para las tutorías</font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp3) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp3) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp3) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Cumple con las fechas 

      programadas para las evaluaciones y actividades de evaluación.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp3) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp3) ; ?>%</span></font></div></td>

  </tr>

</table>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"><strong class="style1 style7">DESTREZA 

      PEDAGÓGICAS</strong>&nbsp; </font></td>

    <td width="99"><font size="1" face="tahoma">Las destrezas pedagógicas del 

      docente, son:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep4) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Es claro en la exposición y presentación de los temas.</font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap4) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap4) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np4) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp4) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Utiliza una adecuada 

      metodología para la explicación de conceptos.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp4) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp4) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp4) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> El 

      docente posee un adecuado manejo de grupo. </font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp4) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp4) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp4) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Presenta orden, claridad 

      y coherencia en los temas tratados</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp4) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp4) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"> <strong class="style1 style7">FORMA 

      DE PRESENTAR LA MATERIA FRENTE AL CONTEXTO QUE LO RODEA</strong> </font></td>

    <td width="99"><font size="1" face="tahoma">El docente relaciona la asignatura 

      con el entorno:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep5) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Relaciona la asignatura con otras asignaturas</font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap5) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap5) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np5) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp5) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"> <strong>b.</strong> Relaciona los contenidos 

      de la asignatura con las competencias de la formación profesional.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp5) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp5) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp5) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Relaciona 

      la asignatura con disciplinas afines y la realidad nacional.</font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp5) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp5) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp5) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Relaciona la asignatura 

      con la misión de la Universidad.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp5) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp5) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"><strong class="style1 style7">MOTIVACIÓN 

      EN EL PROCESO DE APRENDIZAJE</strong>&nbsp; </font></td>

    <td width="99"><font size="1" face="tahoma">La destreza que tiene el docente 

      para fomentar el aprendizaje en los estudiantes, es:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep6) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Motiva a los estudiantes a participar en el desarrollo de la asignatura.</font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap6) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap6) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np6) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp6) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Resuelve adecuadamente 

      las inquietudes presentadas por los estudiantes.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp6) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp6) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp6) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Motiva 

      las actividades académicas no presénciales del estudiante para el logro 

      de los objetivos.</font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp6) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp6) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp6) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Incentiva la utilización 

      de recursos bibliográficos y nuevas tecnologías. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp6) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp6) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"><strong class="style1 style7">RELACIÓN 

      CON EL ESTUDIANTE</strong>&nbsp; </font></td>

    <td width="99"><font size="1" face="tahoma">La relación establecida entre 

      los estudiantes y el docente, es:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep7) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Manifiesta respeto y tolerancia.</font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap7) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap7) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np7) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp7) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Demuestra interés por 

      el aprendizaje de los estudiantes. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp7) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp7) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp7) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Promueve 

      la formación integral y de valores en los estudiantes. </font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp7) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp7) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp7) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Estimula y reconoce el 

      trabajo de los estudiantes. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp7) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp7) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma">&nbsp; <strong class="style1 style7">FORMACIÓN 

      INVESTIGATIVA</strong></font></td>

    <td width="99"><font size="1" face="tahoma">La promoción de la formación investigativa, 

      por parte del docente, es:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep8) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a. </strong>Produce 

      documentos y materiales para el desarrollo de 

      la asignatura. </font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap8) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap8) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np8) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp8) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Fomenta espacios para 

      investigar y profundizar sobre diferentes temas. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp8) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp8) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp8) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Actualiza 

      los contenidos de la asignatura a partir de nuevas investigaciones y conceptos.</font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp8) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp8) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp8) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> El desarrollo de los 

      laboratorios y talleres satisfacen sus requerimientos y expectativas de 

      investigación y desarrollo académico. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp8) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp8) ; ?>%</span></font></div></td>

  </tr>

</table>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<table width="586" border="0" align="center" cellspacing="0">

  <tr bordercolor="#000000" bgcolor="#C5D5D6" class="style2"> 

    <td width="117"> <div align="center"><font size="1" face="tahoma"><strong class="style2 style6">ASPECTO 

        </strong> </font></div></td>

    <td width="71"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>PREGUNTA</strong></span></font></div></td>

    <td width="60"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>RESPUESTA<br>

        (%)</strong> </span></font></div></td>

    <td width="218"><div align="center"><font size="1" face="tahoma"><span class="style6"><strong>CRITERIOS<br>

        </strong></span></font></div></td>

    <td width="52"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DESTACA </strong> </span></font></div></td>

    <td width="61"> <div align="center"><font size="1" face="tahoma"><span class="style6"><strong>SE 

        DEBE MEJORAR </strong> </span></font></div></td>

  </tr>

  <tr> 

    <td width="84"><font size="1" face="tahoma"><strong class="style1 style7">EVALUACIÓN 

      DEL PROCESO DE APRENDIZAJE</strong>&nbsp; </font></td>

    <td width="99"><font size="1" face="tahoma">El sistema de evaluación que el 

      docente aplica, es:</font></td>

    <td width="60"><div align="center"><font size="1" face="tahoma"><strong>E 

        </strong> <span class="style1 style7"><?php printf ( "%.2f", $porcenep9) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="218"bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>a.</strong> 

      Las evaluaciones corresponden a los temas cubiertos dentro de la asignatura.</font></td>

    <td width="52" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcdesap9) ; ?></span><span class="style1 style7">%</span></font></div></td>

    <td width="61" bgcolor="#fef7ed"><div align="center"><font size="1" face="tahoma"><span class="style1 style7"><?php printf ( "%.2f", $porcmejap9) ; ?></span><span class="style1 style7">%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="left"><font size="1" face="tahoma"><strong>NOTA: </strong><strong class="Estilo4"><?php printf ( "%.2f", $np9) ; ?></strong></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><strong>B </strong><span class="style8"> 

        <?php printf ( "%.2f", $porcenbp9) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>b.</strong> Hace retroalimentación 

      a partir de los resultados de las evaluaciones. </font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesbp9) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejbp9) ; ?>%</span></font></div></td>

  </tr>

  <tr> 

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><font size="1" face="tahoma">&nbsp;</font></td>

    <td><div align="center" class="style8"> </div>

      <div align="center"><font size="1" face="tahoma"><strong>R </strong> <span class="style8"><?php printf ( "%.2f", $porcendp9) ; ?>%</span></font></div></td>

    <td bgcolor="#fef7ed"><font size="1" face="tahoma"><strong>c.</strong> Las 

      notas de las evaluaciones se entregan oportunamente.</font></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdescp9) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

    <td bgcolor="#fef7ed"><div align="center" class="style8"><font size="1" face="tahoma"><span class="style8"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejcp9) ; ?>%</span></font></span></font> 

      </div>

      <div align="center"><font size="1" face="tahoma"></font></div></td>

  </tr>

  <tr> 

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><div align="center"><font size="1" face="tahoma"><strong>M</strong> <span class="style8"><?php printf ( "%.2f", $porcenpp9) ; ?>%</span></font></div></td>

    <td><font size="1" face="tahoma"><strong>d.</strong> Las evaluaciones son 

      objetivas y equitativas.</font></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcdesdp9) ; ?>%</span></font></div></td>

    <td><div align="center"><font size="1" face="tahoma"><span class="style8"><?php printf ( "%.2f", $porcmejdp9) ; ?>%</span></font></div></td>

  </tr>

</table>

<table width="586" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr> 

      

    <td bgcolor="#C5D5D6" class="style2"><div align="center"><font size="1" face="tahoma"><strong>OBSERVACIONES:</strong></font></div></td>

    </tr>

    <tr> 

      <td> <font size="1" face="tahoma"> 

        <?php 

$obse = "SELECT observaciones FROM respuestas where idgrupo = '$yui' and codigodocente = '$li'";

$obseq=mysql_query($obse,$sala);

//$obsercon=0;

$filob=mysql_fetch_array($obseq);

while ($filob=mysql_fetch_array($obseq))

{

echo $filob['observaciones']."<br>";

//$ovsercon++;

}

	

	?>

        </font></tr>

</table>

  

<font size="1" face="tahoma"> 

<form name="form1" method="post" action="">

  <div align="center">

    <input name="imprimir" type="button" id="buton" value="Imprimir" onClick="print()">

  </div>

</form>

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













