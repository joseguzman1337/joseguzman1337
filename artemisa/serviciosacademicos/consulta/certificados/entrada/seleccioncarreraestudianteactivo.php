<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$salatmp=$sala;
mysql_select_db($database_sala, $sala);
?>
<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	location.href="<?php echo 'certificadospruebas.php';?>";
}

</script>
<?


if (isset($_REQUEST['documento']))
  {
    $documentoestudiante = $_REQUEST['documento'];
  }

$znumerodocumento = $codigoestudiante;

 $query_dataestudiante = "SELECT distinct c.codigomodalidadacademica,c.nombrecarrera, c.codigocarrera,
 eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
 d.nombredocumento, d.tipodocumento,e.codigoestudiante,
eg.numerodocumento, eg.fechanacimientoestudiantegeneral,
eg.expedidodocumento,eg.idestudiantegeneral,gr.nombregenero,e.codigoperiodo,
eg.celularestudiantegeneral,eg.emailestudiantegeneral, eg.codigogenero,
s.nombresituacioncarreraestudiante, eg.direccionresidenciaestudiantegeneral,
eg.telefonoresidenciaestudiantegeneral,eg.ciudadresidenciaestudiantegeneral,
eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral,
eg.ciudadcorrespondenciaestudiantegeneral,e.codigocarrera
FROM estudiante e, carrera c,documento d,estudiantegeneral eg,
estudiantedocumento ed,situacioncarreraestudiante s,genero gr,modalidadacademica ma
WHERE e.codigocarrera = c.codigocarrera and gr.codigogenero = eg.codigogenero
AND eg.tipodocumento = d.tipodocumento and e.codigosituacioncarreraestudiante =
s.codigosituacioncarreraestudiante AND ed.idestudiantegeneral = eg.idestudiantegeneral
AND ma.codigomodalidadacademica=c.codigomodalidadacademica
AND e.idestudiantegeneral = eg.idestudiantegeneral AND e.idestudiantegeneral = ed.idestudiantegeneral
AND ed.numerodocumento = '$documentoestudiante' and c.codigomodalidadacademica  not in ('400') and c.codigocarrera not in('13')
order by e.codigosituacioncarreraestudiante desc ";
						//echo $query_dataestudiante;
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);



if ($totalRows_dataestudiante == "") {
?>
     <script type="text/javascript">
        alert('La busqueda asociada a este documento no arroja resultados, por favor verifique el numero de documento o comuniquese con Secretaría General');
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

if ($_POST["certificado"] == 17) {

        }

        switch ($_REQUEST["certificado"]) {

           case "17":

              if ($row_dataestudiante['codigocarrera'] == $row_dataestudiante['codigocarrera']
                    or $row_tipousuario['codigotipousuariofacultad'] == 200
                    or $usuario == "admintecnologia" or $usuario == "dirsecgeneral"
                    or $usuario == "auxsecgen")
	   {

			?>
              <a href="../entrada/formulariocertificadonotasemestre.php?codigoestudiante=<?php
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
         </form>
         <a href="javascript:history.go(-1)">Atrás</a>
<form name="form2" method="get" action="">
  <div align="center">
   <input type="button" value="Regresar" onclick="javascript:history.back();">
  </div>
</form>
<?php
 }while($row_dataestudiante = mysql_fetch_assoc($dataestudiante));
?>
	</table>
	</td>
	</tr>
</table>
<?php
}

?>