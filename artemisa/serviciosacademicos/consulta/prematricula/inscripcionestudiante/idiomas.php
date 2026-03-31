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
    
    if(isset($_SESSION['numerodocumentosesion'])){
        $codigo_inscripcion = $_SESSION['numerodocumentosesion'];
    }else{
        $codigo_inscripcion = $codigoinscripcion;
    }
    if(isset($_SESSION['modalidadacademicasesion'])){
        $modalidad_academica = $_SESSION['modalidadacademicasesion'];
    }else{
        $modalidad_academica = $modalidadacademica;
    }
?>
<html>
    <head>
        <title>.:Idiomas:.</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <script language="JavaScript" src="calendario/javascripts.js"></script>
    </head>
    <body>
        <?php
        if(isset($_REQUEST['inicial'])){
            ?>
            <a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $codigo_inscripcion."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>" id="aparencialinknaranja">Inicio</a><br><br>
            <?php
        }
        ?>
        <form name="inscripcion" method="post" action="idiomas.php">
            <?php
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

WHERE numerodocumento = '$codigoinscripcion'

AND eg.idestudiantegeneral = i.idestudiantegeneral

AND eg.idciudadnacimiento = ci.idciudad

AND i.idinscripcion = e.idinscripcion

AND e.codigocarrera = c.codigocarrera

AND m.codigomodalidadacademica = i.codigomodalidadacademica 

and i.codigoestado like '1%'

AND e.idnumeroopcion = '1'

AND i.codigomodalidadacademica = '".$modalidad_academica."'"; 

//echo $query_data; 

$data = $db->Execute($query_data);

$totalRows_data = $data->RecordCount();

$row_data = $data->FetchRow();



$query_idiomaestudiante = "SELECT *

FROM estudianteidioma e

WHERE  e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

ORDER BY 2";

$idiomaestudiante = $db->Execute($query_idiomaestudiante);

$totalRows_idiomaestudiante = $idiomaestudiante->RecordCount();

$row_idiomaestudiante = $idiomaestudiante->FetchRow();

$sinidioma = "i.ididioma <> ".$row_idiomaestudiante['ididioma'];

   if ($row_idiomaestudiante <> "")

    {		

	  do{

	     $sinidioma = $sinidioma ." and i.ididioma <> ".$row_idiomaestudiante['ididioma'];

	    //echo $sinidioma ,"<br>";

	  }while($row_idiomaestudiante = $idiomaestudiante->FetchRow());

		$query_idioma = "SELECT *

		FROM idioma i

		WHERE ($sinidioma)					

		ORDER BY 2";

		$idioma = $db->Execute($query_idioma);

		$totalRows_idioma = $idioma->RecordCount();

		$row_idioma = $idioma->FetchRow();

	}

  else

   {

       	$query_idioma = "SELECT *

       	FROM idioma i								

   	   	ORDER BY 2";

	   	$idioma = $db->Execute($query_idioma);

		$totalRows_idioma = $idioma->RecordCount();

		$row_idioma = $idioma->FetchRow(); 

   }

	//echo $query_idioma;

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

}// vista previa	   

	      $query_datosgrabados = "SELECT * 

								 FROM estudianteidioma e,idioma i

								 WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

								 and e.ididioma = i.ididioma								 

								 and e.codigoestado like '1%'

								 order by nombreidioma";			  

		$datosgrabados = $db->Execute($query_datosgrabados);

		$totalRows_datosgrabados = $datosgrabados->RecordCount();

		$row_datosgrabados = $datosgrabados->FetchRow();

		  if ($row_datosgrabados <> "")

		   { ?>

			   <br><table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

                <tr id="trtitulogris">

					<td>Idioma</td>

					<td>Lee</td>

					<td>Habla</td>

					<td>Escribe</td>

					<td>Descripción</td>

					<td>Acción</td>

                </tr>

		       <?php 

			     do{ ?>

			        <tr>

                     <td><?php echo $row_datosgrabados['nombreidioma'];?></td>

					 <td><?php echo $row_datosgrabados['porcentajeleeestudianteidioma'];?>%</td>

                     <td><?php echo $row_datosgrabados['porcentajehablaestudianteidioma'];?>%</td>

					 <td><?php echo $row_datosgrabados['porcentajeescribeestudianteidioma'];?>%</td>

					 <td><?php echo $row_datosgrabados['descripcionestudianteidioma'];?></td>					 

					 <td>

                         <?php
                         /**
                          * @modifed RubioLeonardo@unbosque.edu.co
                          * @since 28/10/2019
                          * adicion de validacion variable codigoestudiante para identificar acceso como aspirante o como administrativo
                          * si la variable codigoestudiante tiene valor entonces hay acceso es desde el formulario inscripcion, sino es un acceso desde las opciones del estudiante.
                          */

                         if (!isset($_GET["codigoestudiante"])){?>
                         <a onClick="window.open('editaridiomas.php?id=<?php echo $row_datosgrabados['idestudianteidioma'];?>','mensajes','width=800,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a>
					 <a onClick="window.open('eliminar.php?idiomas&id=<?php echo $row_datosgrabados['idestudianteidioma'];?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a>
                        <?php } ?>
                     </td>

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

        <td colspan="6"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>

      </tr>

      <tr id="trtitulogris">

        <td>Nombre</td>

        <td>Seleccionar</td>

        <td>Lee</td>

        <td>Habla</td>

        <td>Escribe</td>

        <td>Descripción</td>

      </tr>

      <?php 

      $cuentaidioma = 1;

	 if ($row_idioma <> "")

	  { 

	   do{

?>

      <tr>

        <td width="24%"><?php echo $row_idioma['nombreidioma'] ;?></td>

        <td width="15%">

            

              <input type="checkbox" name="idiomaseleccionado<?php echo $cuentaidioma;?>" value="<?php echo $row_idioma['ididioma'] ;?>" >

            </td>

        <td width="13%">

            

                <input name="lee<?php echo $cuentaidioma;?>" type="text" id="lee" size="1" maxlength="3" value="<?php echo $_POST['lee'.$cuentaidioma]; ?>">

            %</td>

        <td width="13%">

            

                <input name="habla<?php echo $cuentaidioma;?>" type="text" id="habla" size="1" maxlength="3" value="<?php echo $_POST['habla'.$cuentaidioma]; ?>">

            %</td>

        <td width="13%">

            

                <input name="escribe<?php echo $cuentaidioma;?>" type="text" id="escribe" size="1" maxlength="3" value="<?php echo $_POST['escribe'.$cuentaidioma]; ?>">

            %</td>

        <td width="22%" >

          <input name="descripcion<?php echo $cuentaidioma;?>" type="text" id="descripcion" size="40" maxlength="100" value="<?php echo $_POST['descripcion'.$cuentaidioma]; ?>">

        </td>

        <?php

       $cuentaidioma ++; 

      }while($row_idioma = $idioma->FetchRow());

   }

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

<input type="button" value="Enviar" onClick="grabar()">

	  <input type="button" value="Vista Previa" onClick="vista()">

  <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">

  <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>   -->

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

	          for ($i=1; $i<$cuentaidioma;$i++)

	          {

		       if ($_POST['idiomaseleccionado'.$i] <> "")

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

	  for ($i=1; $i<$cuentaidioma;$i++)

	   {

	     if ($_POST['idiomaseleccionado'.$i] <> "" and ( (!eregi("^[0-9]{1,15}$", $_POST['lee'.$i]) or !eregi("^[0-9]{1,15}$", $_POST['habla'.$i]) or !eregi("^[0-9]{1,15}$", $_POST['escribe'.$i]) or $_POST['lee'.$i] > 100 or $_POST['habla'.$i] > 100 or $_POST['escribe'.$i] > 100)))

		  {

		    $banderagrabar = 1;

		  }	   

	   }	  

	  if ($banderagrabar == 1)

	   {

		  echo '<script language="JavaScript">alert("Debe digitar todos los porcentajes del idioma seleccionado");</script>';		  

	      $banderagrabar = 1;

	   }	

	 else

	   if ($banderagrabar == 0)

	   {   

	    for ($i=1; $i<$cuentaidioma;$i++)

	     {	   

	        if ($_POST['idiomaseleccionado'.$i] <> "")

		     {

				$query_idioma = "INSERT INTO estudianteidioma(idestudianteidioma,idestudiantegeneral,idinscripcion,ididioma,porcentajeleeestudianteidioma,porcentajeescribeestudianteidioma,porcentajehablaestudianteidioma,descripcionestudianteidioma,codigoestado) 

				VALUES(0,'".$row_data['idestudiantegeneral']."','".$row_data['idinscripcion']."','".$_POST['idiomaseleccionado'.$i]."','".$_POST['lee'.$i]."','".$_POST['escribe'.$i]."','".$_POST['habla'.$i]."','".$_POST['descripcion'.$i]."','100' )"; 

				//echo "$query_idioma <br>";

				//exit();

				$idioma = $db->Execute($query_idioma);

             }

		 } 

		 if ($paginaactual == 0)

		  { 

		   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=idiomas.php?inicial=$moduloinicial'>";

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



<script language="javascript">

function recargar(dir)

{

	window.location.reload("idiomas.php"+dir);

	history.go();

}

</script> 

</form>