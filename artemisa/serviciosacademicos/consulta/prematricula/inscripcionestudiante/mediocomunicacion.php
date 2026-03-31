<?php
    /*
     * Ivan Dario quintero rios
     * Modified 19 de octubre 2018
     * Ajuste de variables de session y limpieza de codigo inicial
     */
    if (!isset($_SESSION)){ 
        session_start(); 
        include_once('../../../utilidades/ValidarSesion.php'); 
        $ValidarSesion = new ValidarSesion();
        $ValidarSesion->Validar($_SESSION);
    } 
    require('../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once('../../../Connections/salaado.php'); 
    
    /*
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se agregan estas validaciones para que no solo dependa de variables de sesion sino tambien de las consultas
     * que se encuentran en el archivo vistaformularioinscripcion.php ubicado en esta misma ruta.
     * @since Octubre 26, 2018
     */ 
    
    if(isset($_SESSION['inscripcionsession'])){
        $id_inscripcion=$_SESSION['inscripcionsession'];
    }else{
        $id_inscripcion=$idinscripcion;
    }
    if(isset($_SESSION['numerodocumentosesion'])){
        $codigo_inscripcion = $_SESSION['numerodocumentosesion'];
    }else{
        $codigo_inscripcion = $codigoinscripcion;
    }
    if(isset($_SESSION['modalidadacademicasesion'])){
        $modalidad_academica = $_SESSION['modalidadacademicasesion'];
    }else{
        $modalidad_academica = $codigomodalidad;
    } 
?>

<html>
<head>
<title>.:Medio de Comunicación:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<?php

if(isset($_REQUEST['inicial'])) 

{ 

?>

<a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $codigo_inscripcion."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>" id="aparencialinknaranja">Inicio</a><br><br>

<?php

}

?>

<form name="inscripcion" method="post" action="mediocomunicacion.php">

<?php

$query_mediocomunicacion = "select *

from mediocomunicacion

order by 2";

$mediocomunicacion = $db->Execute($query_mediocomunicacion);

$totalRows_mediocomunicacion = $mediocomunicacion->RecordCount();

$row_mediocomunicacion = $mediocomunicacion->FetchRow();



$query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo

FROM inscripcionformulario ip, inscripcionmodulo im

WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo

AND ip.codigomodalidadacademica = '".$modalidad_academica."'

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

    WHERE numerodocumento = '$codigo_inscripcion'

    AND eg.idestudiantegeneral = i.idestudiantegeneral

    AND eg.idciudadnacimiento = ci.idciudad

    AND i.idinscripcion = e.idinscripcion

    AND e.codigocarrera = c.codigocarrera

    AND m.codigomodalidadacademica = i.codigomodalidadacademica 

    AND i.codigoestado like '1%'

    AND e.idnumeroopcion = '1'

    AND i.idinscripcion = '".$id_inscripcion."'"; 

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

								 FROM estudiantemediocomunicacion e,mediocomunicacion m

								 WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

								 and e.codigomediocomunicacion = m.codigomediocomunicacion

								 and e.codigoestadoestudiantemediocomunicacion like '1%'

								 order by nombremediocomunicacion";			  

		//echo $query_data; 

		$datosgrabados = $db->Execute($query_datosgrabados);

		$totalRows_datosgrabados = $datosgrabados->RecordCount();

		$row_datosgrabados = $datosgrabados->FetchRow();

		  if ($row_datosgrabados <> "")

		   { ?>

		       <br>

			   <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

	                <tr id="trtitulogris">

					<td >Medio de comunicaci&oacute;n </td>

					<td>Descripción</td>

                </tr>

		       <?php 

			     do{ ?>

			        <tr>

                     <td><?php echo $row_datosgrabados['nombremediocomunicacion'];?></td>

					 <td><?php echo $row_datosgrabados['observacionestudiantemediocomunicacion'];?></td>

                 </tr>			   

			    <?php  

				  }while($row_datosgrabados = $datosgrabados->FetchRow());

			   ?>

	    </table> 

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

          <td colspan="3"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>

        </tr>

        <tr id="trtitulogris">

		   <td>Medio</td>

		   <td>Seleccionar</td>

		   <td>Descripción</td>

       </tr>

<?php 

      $cuentamedio = 1;

	  do{

?> 

	 <tr>

          <td width="54%"><?php echo $row_mediocomunicacion['nombremediocomunicacion'] ;?></td>

          <td width="14%">

            <input type="checkbox" name="medio<?php echo $cuentamedio;?>" value="<?php echo $row_mediocomunicacion['codigomediocomunicacion'] ;?>">

          </td>

          <td width="32%">

            <input name="descripcion<?php echo $cuentamedio;?>" type="text" id="descripcion" size="40" maxlength="100" value="<?php echo $_POST['descripcion']; ?>">

          </td>

<?php 

       $cuentamedio++;

	  }while($row_mediocomunicacion = $mediocomunicacion->FetchRow());

?>         

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

function vista()

{	

   window.location.reload("vistaformularioinscripcion.php");	

}

</script>

<br>

<!--    <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">

   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  

 -->

 <input type="button" value="Enviar" onClick="grabar()">

  <input type="button" value="Vista Previa" onClick="vista()">

     <input type="hidden" name="grabado" value="grabado">   

<br><br>

<?php

$banderagrabar = 1; 

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

	          for ($i=1; $i<$cuentamedio;$i++)

	          {

		        if ($_POST['medio'.$i] <> "")

	             {	          

		          $banderagrabar_continiar = 1;	        

			     }	

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

	  for ($i=1; $i<$cuentamedio;$i++)

	   {

	     if ($_POST['medio'.$i] == "")

		  {

		    $banderagrabar++;

		  }	   

	   }

	   $indicador = 0;

	   if ($banderagrabar == $i)

	    {

		  echo '<script language="JavaScript">alert("Debe seleccionar el medio por el cual se entero de la Universidad"); history.go(-1);</script>';		

		  $indicador = 1;

		}	

	else

	 if ($indicador == 0)

	 {

        // echo $cuentamedio;

			$base="update estudiantemediocomunicacion

			set codigoestadoestudiantemediocomunicacion = '200'

			where idestudiantegeneral = '".$row_data['idestudiantegeneral']."'";		  

			$sol = $db->Execute($base);

	    for ($i=1; $i<$cuentamedio;$i++)

	     {	   

	        if ($_POST['medio'.$i] <> "")

		     {

				$query_decision = "INSERT INTO estudiantemediocomunicacion(idestudiantemediocomunicacion,idestudiantegeneral,idinscripcion,codigomediocomunicacion,codigoestadoestudiantemediocomunicacion,observacionestudiantemediocomunicacion) 

				VALUES(0,'".$row_data['idestudiantegeneral']."', '".$row_data['idinscripcion']."','".$_POST['medio'.$i]."','100','".$_POST['descripcion'.$i]."')"; 

				$decision = $db->Execute($query_decision);		

             }

		 } 

		if ($paginaactual == 0)

		 { 

		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=mediocomunicacion.php?inicial=$moduloinicial'>";

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

} // vista previa	  	

?>

</form>