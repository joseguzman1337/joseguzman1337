<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
      
require('../../../Connections/sala2.php'); 



$rutaado = "../../../funciones/adodb/";

require_once('../../../Connections/salaado.php'); 



@session_start();

?>

<html>

<head>

<title>.:Carreras:.</title>

<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

<script language="JavaScript" src="calendario/javascripts.js"></script>

</head>

<body>

<?php

if(isset($_REQUEST['inicial'])) 

{ 

?>

<a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $_SESSION['numerodocumentosesion']."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>" id="aparencialinknaranja">Inicio</a><br><br>

<?php

}

?>

<form name="inscripcion" method="post" action="carreraspreferencia.php">

<?php

   $codigoinscripcion = $_SESSION['numerodocumentosesion']; 

   $query_actividad = "select *

   from tipoestudiantelaboral

   order by 2";

	$actividad = $db->Execute($query_actividad);

	$totalRows_actividad = $actividad->RecordCount();

	$row_actividad = $actividad->FetchRow();

	

	$query_ciudad1 = "select *

	from ciudad

	order by 3";

	$ciudad1 = $db->Execute($query_ciudad1);

	$totalRows_ciudad1 = $ciudad1->RecordCount();

	$row_ciudad1 = $ciudad1->FetchRow();

	

	$query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo

    FROM inscripcionformulario ip, inscripcionmodulo im

	WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo

	AND ip.codigomodalidadacademica = '".$_SESSION['modalidadacademicasesion']."'

	AND ip.codigoestado LIKE '1%'

	order by posicioninscripcionformulario";

	$formularios = $db->Execute($query_formularios);

	$totalRows_formularios = $formularios->RecordCount();

	$row_formularios = $formularios->FetchRow();

unset($modulos);

unset($nombremodulo);

unset($iddescripcion);

$limitemodulo = $totalRows_formularios;

$cuentamodulos = 1; 

 do{

    $modulos[$cuentamodulos] = $row_formularios['linkinscripcionmodulo'];

    $nombremodulo[$cuentamodulos] = $row_formularios['nombreinscripcionmodulo'];

	$iddescripcion[$cuentamodulos] = $row_formularios['idinscripcionmodulo'];

	//echo $nombremodulo[$cuentamodulos],"/<br>";

	$cuentamodulos++;

 }while($row_formularios = $formularios->FetchRow());

	$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion

     FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci

	 WHERE numerodocumento = '$codigoinscripcion'

     AND eg.idestudiantegeneral = i.idestudiantegeneral

     AND eg.idciudadnacimiento = ci.idciudad

     AND i.idinscripcion = e.idinscripcion

     AND e.codigocarrera = c.codigocarrera

     AND m.codigomodalidadacademica = i.codigomodalidadacademica

     and i.codigoestado like '1%'

     AND e.idnumeroopcion = '1'

     and i.idinscripcion = '".$_SESSION['inscripcionsession']."'"; 

	//echo $query_data; 

	$data = $db->Execute($query_data);

	$totalRows_data = $data->RecordCount();

	$row_data = $data->FetchRow();

if(isset($_POST['inicial']) or isset($_GET['inicial'])) 

  { // vista previa	  

?>

	<p>FORMULARIO DEL ASPIRANTE</p>

<?php

	 if (isset($_GET['inicial']))

	   {

	      $moduloinicial = $_GET['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 

	   }

	  else

	   {

	      $moduloinicial = $_POST['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';

	   }

?>

 <table width="70%" border="0" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

 <tr>

 <td>	

<?php 

	require("funcionformulario.php");

	cabecera_formulario($nombremodulo, $cuentamodulos, $modulos, $row_data, 1);

} // vista previa	  	    

		  $query_datosgrabados = "SELECT * 

								 FROM estudiantecarrerapreferencia e

								 WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

								 and e.codigoestado like '1%'

								 order by nombreestudiantecarrerapreferencia";			  

		//echo $query_data; 

		$datosgrabados = $db->Execute($query_datosgrabados);

		$totalRows_datosgrabados = $datosgrabados->RecordCount();

		$row_datosgrabados = $datosgrabados->FetchRow();

		  if ($row_datosgrabados <> "")

		   { ?>

		       <br>

			   <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

                <tr id="trtitulogris">

					<td>Carrera</td>

					<td>Descripción</td>					

                    <td>Acción</td>

                </tr>

		       <?php 

			     do{ ?>

			        <tr>

                     <td><?php echo $row_datosgrabados['nombreestudiantecarrerapreferencia'];?></td>

					 <td><?php echo $row_datosgrabados['porqueestudiantecarrerapreferencia'];?></td>

                     <td><a onClick="window.open('editarcarreraspreferencia.php?id=<?php echo $row_datosgrabados['idestudiantecarrerapreferencia'];?>','mensajes','width=800,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a>

					 <a onClick="window.open('eliminar.php?carreraspreferencia&id=<?php echo $row_datosgrabados['idestudiantecarrerapreferencia'];?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a></td>

	             </tr>			   

			    <?php  

				  }while($row_datosgrabados = $datosgrabados->FetchRow());

			   ?>

	    </table> 

	   <?php

		   }

		   else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) 

		   {

		   ?>

<!-- <tr>

<td>Sin datos diligenciados</td>

</tr> -->

<?php

		   }	     	      

if(isset($_POST['inicial']) or isset($_GET['inicial'])) 

  { // vista previa	  	   

     if (isset($_GET['inicial']))

	   {

	      $moduloinicial = $_GET['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 

	   }

	  else

	   {

	      $moduloinicial = $_POST['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">'; 

	   }	

	?>

	<br>

	<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

	    <tr id="trtitulogris">

          <td colspan="2"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>

        </tr>

        <tr id="trtitulogris">

          <td>Carrera<span class="Estilo4">*</span></td>

          <td>Descripci&oacute;n</td>

        </tr>

        <tr>

		 <td>

		   <input name="carrera" type="text" id="carrera" size="40" maxlength="50" value="<?php echo $_POST['carrera'];?>">

	      </td>

          <td>

            <input name="descripcion" type="text" id="descripcion" size="70" maxlength="100" value="<?php echo $_POST['descripcion'];?>">

          </td>

        </tr>		

</table>

</td> 

</tr>   

</table>     

<script language="javascript">

function grabar()

 {

  document.inscripcion.submit();

 }

</script>

<br><br>

<!-- 

   <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">

   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  

    -->

	<input type="button" value="Enviar" onClick="grabar()">

	<input type="button" value="Vista Previa" onClick="vista()">

	<input type="hidden" name="grabado" value="grabado">   

<br><br>

<?php

$banderagrabar = 0; 

if (isset($_GET['inicial']))

  {

     $moduloinicial = $_GET['inicial'];

     echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 

  }

 else

  {

     $moduloinicial = $_POST['inicial'];

      echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">'; 

  }

	  if($moduloinicial > 1)

		{

			$atras = $moduloinicial - 1;

			//echo '<a href="'.$modulos[$atras].'?inicial='.$atras.'"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Atras"></a>';

		    //echo '<input type="image" src="../../../../imagenes/izquierda.gif" name="atras" value="atras" width="25" height="25" alt="Atras">';

		}

		echo "";		

		if($moduloinicial < $limitemodulo)

		{

			$adelante = $moduloinicial + 1;

			//echo '<a href="'.$modulos[$adelante].'?inicial='.$adelante.'"><img src="../../../../imagenes/derecha.gif" width="20" height="20" alt="Adelante"></a>';

		    //echo '<input type="image" src="../../../../imagenes/derecha.gif" name="adelante" value="adelante" width="25" height="25" alt="Adelante">';

		}

		$banderagrabar_continiar = 0;

		$paginaactual = 1;

		foreach ($_POST as $key => $value)

        {         

		 if (ereg("adelante",$key) or ereg("atras",$key))		

          {	  

	        if ($_POST['descripcion'] <> "" or $_POST['carrera'] <> "")

	         {	          

		      $banderagrabar_continiar = 1;	        

			 }			 

		  }

		 else

		  if (ereg("Guardar", $key) || ereg("grabado",$key))

		  {

			$banderagrabar_continiar = 1;	 

			$paginaactual = 0;

		  }

        }

if ($banderagrabar_continiar == 1)

 {	 

	  if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['carrera']) or $_POST['carrera'] == ""))

	  {

	    echo '<script language="JavaScript">alert("Debe escribir una Carrera")</script>';		

		$banderagrabar = 1;

	  }

	 else

	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['descripcion']) and $_POST['descripcion'] <> ""))

	  {

	    echo '<script language="JavaScript">alert("Digite la descripción")</script>';		

		$banderagrabar = 1;

	  }	

	else

	 if ($banderagrabar == 0)

	 {

	    $descripcion = "";

		if ($_POST['descripcion'] <> "")

		 {

		    $descripcion = $_POST['descripcion'];		 

		 }

		else

		 {

		    $descripcion = "SIN DEFINIR";	

		 }

		$query_preferencia = "INSERT INTO estudiantecarrerapreferencia(idestudiantecarrerapreferencia,nombreestudiantecarrerapreferencia,porqueestudiantecarrerapreferencia,idestudiantegeneral,idinscripcion,codigoestado) 

		VALUES(0,'".$_POST['carrera']."','".$descripcion."','".$row_data['idestudiantegeneral']."', '".$row_data['idinscripcion']."','100')"; 

		//echo "$query_insestudiantedocumento <br>";

		$preferencia = $db->Execute($query_preferencia);

		if ($paginaactual == 0)

		 {

		   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=carreraspreferencia.php?inicial=$moduloinicial'>";

		 } //aca

		else

        if (ereg("adelante",$key) or ereg("atras",$key))

        {

          foreach ($_POST as $key => $value)

          {

           if (ereg("adelante",$key))

            {	       

		     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";

		     exit(); 			

	        }

	       else

	       if (ereg("atras",$key))

	        {		    

		     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";

		     exit();			

	        } 

          }

        } // aca 

	 }

 }	

else

 if (ereg("adelante",$key) or ereg("atras",$key))

 {

  foreach ($_POST as $key => $value)

    {

     if (ereg("adelante",$key))

       {	       

		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";

		 exit(); 			

	   }

	 else

	  if (ereg("atras",$key))

	  {		    

		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";

		  exit();			

	  } 

     }

 }

}// vista previa	  

?>

<script language="javascript">

function recargar(dir)

{

	window.location.reload("carreraspreferencia.php"+dir);

	history.go();

}

function vista()

{	

   window.location.reload("vistaformularioinscripcion.php");	

}

</script> 

</form>