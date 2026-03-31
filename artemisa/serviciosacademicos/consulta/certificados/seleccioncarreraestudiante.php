<?php
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
$salatmp=$sala;
mysql_select_db($database_sala, $sala);



if (isset($_REQUEST['documento']))
  {
    $documentoestudiante = $_REQUEST['documento'];
    
  }

$znumerodocumento = $codigoestudiante;

 $query_dataestudiante = "(SELECT s.codigosituacioncarreraestudiante,c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral,
eg.nombresestudiantegeneral,e.codigoestudiante,e.codigoperiodo,s.nombresituacioncarreraestudiante
FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r, documento d, carrera c,
registrograduado rg, foliotemporal f, trato tr ,genero g,situacioncarreraestudiante s
where eg.numerodocumento = '$documentoestudiante' and tr.idtrato=eg.idtrato and g.codigogenero=eg.codigogenero
and e.codigoestudiante=r.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and eg.tipodocumento= d.tipodocumento and e.codigoestudiante=rg.codigoestudiante
and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
and f.idregistrograduado=rg.idregistrograduado and e.codigoperiodo NOT LIKE '%199%' group by c.nombrecarrera desc)
union ( SELECT s.codigosituacioncarreraestudiante,c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral,
eg.nombresestudiantegeneral,e.codigoestudiante,e.codigoperiodo,s.nombresituacioncarreraestudiante
FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t, documento d, situacioncarreraestudiante s,
foliotemporal f,trato tr,genero g
where eg.numerodocumento ='$documentoestudiante' and tr.idtrato=eg.idtrato
and g.codigogenero=eg.codigogenero and eg.idestudiantegeneral=e.idestudiantegeneral and e.codigocarrera=c.codigocarrera
 and e.codigoestudiante=r.codigoestudiante and c.codigotitulo=t.codigotitulo
and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
and eg.tipodocumento= d.tipodocumento and e.codigoperiodo NOT LIKE '%199%' and f.idregistrograduado=r.idregistrograduado group by c.nombrecarrera desc ) ";
						//echo $query_dataestudiante;
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);


/* if ($_REQUEST["certificado"]=='18') {
?>
     <script type="text/javascript">
        window.location.href='../certificados/entrada/seleccioncarreraestudianteactivo.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&certificado=<?php
              echo $_REQUEST["certificado"];
              ?>';
    </script>
<?php

}

else*/ if ($totalRows_dataestudiante == "") {

     
    ?>
     <script type="text/javascript">
        alert('La busqueda asociada a este documento no arroja resultados, por favor verifique el numero de documento y fecha de grado o comuniquese con Secretaría General');
        window.location.href='../certificados/entrada/certificadosprueba.php';
    </script>
<?php

}


if($totalRows_dataestudiante != "")
{
   

        $idestudiante = $row_dataestudiante['idestudiantegeneral'];
	 $query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera where codigocarrera = '".$row_dataestudiante['codigocarrera']."' order by 2 asc";
	$carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
	$row_carreras = mysql_fetch_assoc($carreras);
	$totalRows_carreras = mysql_num_rows($carreras);

?>
<html>
<head>
<title>Carrera Estudiante</title>
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
<p align="center" class="Estilo3">DATOS ESTUDIANTE</p>
    <table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
	<td>
	<table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Apellidos</div></td>
        <td class="Estilo1">
          <div align="center"><?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; else echo $row_dataestudiante['apellidosestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Nombres</div></td>
        <td class="Estilo1"><div align="center">
          <?php if(isset($_POST['nombres']))
              echo $_POST['nombres'];
          else
              echo $row_dataestudiante['nombresestudiantegeneral'];?>
            </div></td>
      </tr>           
</table>
  </td>
 </tr>
</table>
<br>

<br>
 <table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
	<td>
	<table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
    <tr class="Estilo2">
	  <td bgcolor="#C5D5D6"><div align="center">Id</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Nombre Carrera</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Código Carrera</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Situaci&oacute;n Carrera</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Periodo Ingreso</div></td>
	</tr>
	<?php
 do{
 ?>
	  <tr class="Estilo1">
	  <td><div align="center"><?php echo $row_dataestudiante['codigoestudiante'];?></div></td>
	  <td align="center">
<?php



        switch ($_REQUEST["certificado"]) {

            case "5":


              if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/autenticidaddetitulopdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }
          
          break;

            case "6":

                 if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/copiaactadegradopdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }

break;
            case "7":

              if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/copiaactadegradodenunciopdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }


                break;



            case "8":
                  if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/duracioncarreraperiodopdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];?>&codigoestudiante=<?php
              echo $row_dataestudiante['codigoestudiante'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }
                break;

            case "9":

                  if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/tramitedediplomapdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }
                
                break;

            case "10":

                if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/conductadelestudianteograduadopdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }

                break;
            case "14":

              if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/entrada/formulariocertificadonota.php?codigoestudiante=<?php
              echo $row_dataestudiante['codigoestudiante'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }

           break;

           case "15":

              if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/promediocarrerapdf.php?codigoestudiante=<?php
              echo $row_dataestudiante['codigoestudiante'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }

           break;

            case "17":

                  if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/puestocupadopdf.php?documento=<?php
              echo $_REQUEST['documento'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }

                break;

                 case "18":

              if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../certificados/entrada/formulariocertificadocredito.php?codigoestudiante=<?php
              echo $row_dataestudiante['codigoestudiante'];
              ?>&codigocarrera=<?php
              echo $row_dataestudiante['codigocarrera'];
              ?>">
              <?php
              echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php
	  }
            else
	   {
	     echo $row_dataestudiante['nombrecarrera'];
	   }

           break;
            
        }

			
	 
	   ?>
            </td>
	    <td><div align="center">
          <?php
	
		echo $row_dataestudiante['codigocarrera'];
       
	   ?>
	      </div></td>
	 <td><div align="center"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></div></td>
	 <td><div align="center"><?php echo $row_dataestudiante['codigoperiodo'];?></div></td>
	 </tr>

        
<?php
 }while($row_dataestudiante = mysql_fetch_assoc($dataestudiante));
?>
	</table>
	</td>
	</tr>
</table>
 <form name="form2" method="get" action="">
     
  <div align="center">
   <input type="button" value="Regresar" onclick="window.location.href='../certificados/entrada/certificadosprueba.php'">
  </div>
     </form>
<?php
}

?>