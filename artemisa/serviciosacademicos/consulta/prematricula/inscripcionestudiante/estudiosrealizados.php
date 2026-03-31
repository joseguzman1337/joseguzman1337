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
    $sala2 = $sala;
    $rutaado = "../../../funciones/adodb/";
    require_once('../../../Connections/salaado.php'); 
    require_once("../../../funciones/funcionboton.php");
    
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
        $modalidad_academica = $modalidadacademica;
    }
?>
<html>
    <head>
        <title>.:Inscripciones:.</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
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

<form name="inscripcion" method="post" action="estudiosrealizados.php">

<script language="javascript">

function enviar()

{

 document.inscripcion.submit();

}

</script>

<?php

mysql_select_db($database_sala, $sala2);

$query_niveleducacion = "select *

from niveleducacion

order by 2";

$niveleducacion = $db->Execute($query_niveleducacion);

$totalRows_niveleducacion = $niveleducacion->RecordCount();

$row_niveleducacion = $niveleducacion->FetchRow();

echo '<input type="hidden" name="grabado" value="grabado">';

$query_titulo = "select *

from titulo

where codigotitulo <> 1

order by 2";

$titulo = $db->Execute($query_titulo);

$totalRows_titulo = $titulo->RecordCount();

$row_titulo = $titulo->FetchRow();



$query_ciudad = "select *

from ciudad

order by 3";

$ciudad = $db->Execute($query_ciudad);

$totalRows_ciudad = $ciudad->RecordCount();

$row_ciudad = $ciudad->FetchRow();



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

 }

while($row_formularios = $formularios->FetchRow());

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion

FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci

WHERE numerodocumento = '$codigo_inscripcion'

AND eg.idestudiantegeneral = i.idestudiantegeneral

AND eg.idciudadnacimiento = ci.idciudad

AND i.idinscripcion = e.idinscripcion

AND e.codigocarrera = c.codigocarrera

AND m.codigomodalidadacademica = i.codigomodalidadacademica 

AND e.idnumeroopcion = '1'

and i.codigoestado like '1%'

and i.idinscripcion = '".$id_inscripcion."'"; 

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

} 



$query_datosgrabados = "SELECT * 

FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t

WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

and e.idniveleducacion = n.idniveleducacion

and ins.idinstitucioneducativa = e.idinstitucioneducativa

and e.codigotitulo = t.codigotitulo								 

and e.codigoestado like '1%'

order by anogradoestudianteestudio";			  

$datosgrabados = $db->Execute($query_datosgrabados);

$totalRows_datosgrabados = $datosgrabados->RecordCount();

$row_datosgrabados = $datosgrabados->FetchRow();

if($row_datosgrabados <> "")

{ 

?>

		       <br><table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

                <tr>

					<td id="tdtitulogris">Nivel</td>

					<td id="tdtitulogris">Institución</td>					

					<td id="tdtitulogris">Titulo</td>

					<td id="tdtitulogris">Ciudad</td>

					<td id="tdtitulogris">Año</td>

					<td id="tdtitulogris">Observaciones</td>

					<td id="tdtitulogris">Acción</td>

                </tr>

<?php 

	do

	{ 

				 ?>

			        <tr>

                     <td><?php echo $row_datosgrabados['nombreniveleducacion'];?></td>

    				 <td><?php if($row_datosgrabados['idinstitucioneducativa'] != '1'){ echo $row_datosgrabados['nombreinstitucioneducativa'];} else{ echo $row_datosgrabados['otrainstitucioneducativaestudianteestudio'];} ?></td>

                     <td><?php if($row_datosgrabados['codigotitulo'] != '1'){ echo $row_datosgrabados['nombretitulo'];} else{ echo $row_datosgrabados['otrotituloestudianteestudio'];}?></td>

					  <td><?php echo $row_datosgrabados['ciudadinstitucioneducativa'];?></td>

					 <td><?php echo $row_datosgrabados['anogradoestudianteestudio'];?></td>

					 <td><?php echo $row_datosgrabados['observacionestudianteestudio'];?></td>
                        <td>
                        <?php
                        /**
                         * @modifed RubioLeonardo@unbosque.edu.co
                         * @since 28/10/2019
                         * adicion de validacion variable codigoestudiante para identificar acceso como aspirante o como administrativo
                         * si la variable codigoestudiante tiene valor entonces hay acceso es desde el formulario inscripcion, sino es un acceso desde las opciones del estudiante.
                         */

                        if (!isset($_GET["codigoestudiante"])){?>
					 <a onClick="window.open('editarestudiosrealizados.php?id=<?php echo $row_datosgrabados['idestudianteestudio'];?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a>

					 <a onClick="window.open('eliminar.php?estudiosrealizados&id=<?php echo $row_datosgrabados['idestudianteestudio'];?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a>
                        <?php } ?>
					 </td>

			        </tr>			   

<?php  

	}

	while($row_datosgrabados = $datosgrabados->FetchRow());

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

        <table  width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

		<tr>

          <td colspan="6" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></div></td>

          </tr>

          <tr>

            <td id="tdtitulogris">Nivel<label id="labelresaltado">*</label></td>

            <td><select name="niveleducacion">

                <option value="0" <?php if (!(strcmp("0", $_POST['niveleducacion']))) {echo "SELECTED";} ?>>Seleccionar</option>

<?php

	do 

	{ 

?>

                  <option value="<?php echo $row_niveleducacion['idniveleducacion']?>"<?php if (!(strcmp($row_niveleducacion['idniveleducacion'], $_POST['niveleducacion']))) {echo "SELECTED";} ?>><?php echo $row_niveleducacion['nombreniveleducacion']?></option>

<?php

	}

	while($row_niveleducacion = $niveleducacion->FetchRow());

?>

              </select>

            </td>

            <td colspan="2" id="tdtitulogris">Titulo<label id="labelresaltado">*</label></td>

            <td colspan="2"><select name="tituloobtenido">

              <option value="0" <?php if (!(strcmp("0", $_POST['tituloobtenido']))) {echo "SELECTED";} ?>>Seleccionar</option>

<?php

	do 

	{  

?>

              <option value="<?php echo $row_titulo['codigotitulo']?>"<?php if (!(strcmp($row_titulo['codigotitulo'], $_POST['tituloobtenido']))) {echo "SELECTED";} ?>><?php echo $row_titulo['nombretitulo'];?></option>

<?php				  

	}

	while($row_titulo = $titulo->FetchRow());

?>

            </select>

           <!--  <input type="button" name="nuevo1" value="..." onClick="creartitulo()"> -->

		    <?php crearunicoboton($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, "20", $sala2);?>

		  <br><label id="labelresaltado">Si el titulo no aparece en el listado digitelo en el siguiente campo de texto</label>

		   <input type="text" name="otrotituloestudianteestudio" style="width:100%" value="<?php echo $_REQUEST['otrotituloestudianteestudio'] ?>">

		   </td>

          </tr>

		  <tr>

            <td colspan="6" id="tdtitulogris">Si conoce el Código asignado por el icfes de la institución Educativa Digitelo <input name="codigocolegio" type="text"  size="10" maxlength="15" value="<?php echo $_POST['codigocolegio'];?>"><br> 

              De lo contrario Seleccione la Instituci&oacute;n a continuación:</td>

          </tr>

	  <tr>

          <td id="tdtitulogris">Instituci&oacute;n<label id="labelresaltado">*</label></td>

          <td colspan="5">

			<INPUT name="institucioneducativa" size="70" readonly onclick="window.open('editarestudiantecolegio.php?codigomodalidad=<?php echo $row_institucioneducativa2['codigomodalidadacademica'];?>','mensajes','width=800,height=400,left=150,top=200,scrollbars=yes')"  value="<?php if (isset($_POST['institucioneducativa'])) echo $_POST['institucioneducativa']; else echo $row_institucioneducativa['nombreinstitucioneducativa'];?>">

            <INPUT name="id"  type="hidden" value="<?php if (isset($_POST['id'])) echo $_POST['id']; else echo $row_institucioneducativa['idinstitucioneducativa'];?>">

<?php 

               crearunicoboton($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, "21",$sala2);?>

			   <br><br><label id="labelresaltado">Si la institución no aparece en el listado digitelo en el siguiente campo de texto</label>

		   <input type="text" name="otrainstitucioneducativaestudianteestudio" style="width:100% " value="<?php echo $_REQUEST['otrainstitucioneducativaestudianteestudio'] ?>">

		  		    </td>

         </tr>

          <tr>

            <td id="tdtitulogris">Ciudad<label id="labelresaltado">*</label></td>

            <td><span class="style2"><input name="ciudad" type="text" id="ciudad" size="25" maxlength="50" value="<?php echo $_POST['ciudad'];?>"></label></td>            

			<td id="tdtitulogris">A&ntilde;o<label id="labelresaltado">*</label></td>

             <td><span class="style2"><input name="ano" type="text" id="ano" size="2" maxlength="4" value="<?php echo $_POST['ano'];?>"></label></td>

            <td id="tdtitulogris">Observaciones</td>

            <td><input name="observaciones" type="text" id="observaciones" size="35" maxlength="50" value="<?php echo $_POST['observaciones'];?>"> Salón Eje: (A301)</td>

          </tr>

		   <tr>

           <td colspan="6"><a href="ingresoicfes.php?inicial&idestudiante=<?php echo $row_data['idestudiantegeneral'];?>" id="aparencialinknaranja">RESULTADO PRUEBA DE ESTADO</a></td>

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

<div >   

  <!--  <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>  --> 

   <input type="button" value="Enviar" onClick="grabar()">

   <input type="button" value="Vista Previa" onClick="vista()">

<!--    <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a> -->



<br>

<br>

<?php

//print_r($_POST);

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

	//echo "";		

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

	    	if ($_POST['niveleducacion'] <> 0 or $_POST['tituloobtenido'] <> 0  or $_POST['ano'] <> "" )

	        {	          

		    	$banderagrabar_continiar = 1;	        

			}			 

		}

		else if (ereg("Guardar", $key) || ereg("grabado",$key))

		{

			$banderagrabar_continiar = 1;	 

			$paginaactual = 0;

		}

  	}		

	if ($banderagrabar_continiar == 1)

 	{	 

   		if ($_POST['codigocolegio'] <> "")

	 	{

	    	$query_institucion = "SELECT * 

			FROM institucioneducativa ins

			WHERE nombrecortoinstitucioneducativa = '".$_POST['codigocolegio']."'";			  

			//echo $query_data; 

			$institucion = $db->Execute($query_institucion);

			$totalRows_institucion = $institucion->RecordCount();

			$row_institucion = $institucion->FetchRow();

			if ($row_institucion <> "")

		 	{

		    	$_POST['id'] = $row_institucion['idinstitucioneducativa']; 

		  	}

			else

		  	{

				echo '<script language="JavaScript">alert("Código de Colegio no valido");</script>';	

				$banderagrabar = 1;

		  	}

	 	}

  		if ($_POST['niveleducacion'] == 0)

	  	{

			echo '<script language="JavaScript">alert("Debe seleccionar el Nivel de educación");</script>';	

			$banderagrabar = 1;

	  	}	

	  	else if ($_POST['tituloobtenido'] == 0 && $_REQUEST['otrotituloestudianteestudio'] == "")

	  	{

	    	echo '<script language="JavaScript">alert("Debe seleccionar un titulo o digitarlo");</script>';		

			$banderagrabar = 1;

	  	}

	   	else if ($_POST['institucioneducativa'] == "" and $_POST['codigocolegio'] == "" and $_POST['otrainstitucioneducativaestudianteestudio'] == "")

	  	{

	    	echo '<script language="JavaScript">alert("Debe seleccionar una Institución ó digitar su Código ó digitar un colégio");</script>';		

			$banderagrabar = 1;

      	}

	  	else if (!eregi("^[0-9]{1,15}$", $_POST['ano']) or $_POST['ano'] > date("Y") or $_POST['ano'] < substr($row_data['fechanacimientoestudiantegeneral'],0,4))

	  	{

	    	echo '<script language="JavaScript">alert("Año Incorrecto");</script>';		

			$banderagrabar = 1;

	  	} 

	    else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['ciudad']) or $_POST['ciudad'] == ""))

	    {

	     echo '<script language="JavaScript">alert("Debe digitar al Ciudad de la Institucion Educativa")</script>';		    		  

		 $banderagrabar = 1;

	    }      

		else if ($banderagrabar == 0)

	 	{

	    	if($_POST['tituloobtenido'] == 0)

			{

				$_POST['tituloobtenido'] = 1;

			}

			if($_POST['id'] == "" || $_POST['id'] == 0)

			{

				$_POST['id'] = 1;

			}

			$query_estudios = "INSERT INTO estudianteestudio(idestudianteestudio, idestudiantegeneral, idinscripcion, idniveleducacion, anogradoestudianteestudio, idinstitucioneducativa,ciudadinstitucioneducativa, otrainstitucioneducativaestudianteestudio, codigotitulo, otrotituloestudianteestudio, observacionestudianteestudio, codigoestado)

			VALUES(0, '".$row_data['idestudiantegeneral']."','".$row_data['idinscripcion']."', '".$_POST['niveleducacion']."', '".$_POST['ano']."','".$_POST['id']."','".$_POST['ciudad']."', '".$_POST['otrainstitucioneducativaestudianteestudio']."','".$_POST['tituloobtenido']."', '".$_POST['otrotituloestudianteestudio']."', '".$_POST['observaciones']."','100')"; 

			$estudios = $db->Execute($query_estudios);

			session_unregister('codigoestudiantecolegionuevo');

			if ($paginaactual == 0)

		 	{

		  		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=estudiosrealizados.php?inicial=$moduloinicial'>";	      

		 	}

			else if (ereg("adelante",$key) or ereg("atras",$key))

			{

				foreach ($_POST as $key => $value)

				{

					if (ereg("adelante",$key))

					{	       

						echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";

						exit(); 			

					}

					else if (ereg("atras",$key))

					{		    

						echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";

						exit();			

					} 

				}

	        }

		}

	}	

	else if (ereg("adelante",$key) or ereg("atras",$key))

	{

		foreach ($_POST as $key => $value)

		{

			if (ereg("adelante",$key))

			{	       

				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";

				exit(); 			

			}

			else if (ereg("atras",$key))

			{		    

				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";

				exit();			

			} 

		}

	}

} // vista previa

?>

</div>

<script language="javascript">

function recargar(dir)

{

	window.location.reload("estudiosrealizados.php"+dir);

	history.go();

}



function recargar1(codigocolegio, nombrecolegio)

{

 document.inscripcion.id.value=codigocolegio;

 document.inscripcion.institucioneducativa.value=nombrecolegio;

}





function crear()

{	

    window.open('crearcolegio.php','institucion','width=800,height=300,left=150,top=50,scrollbars=yes');

}

function creartitulo()

{	

    window.open('creartitulo.php','titulo','width=800,height=300,left=150,top=50,scrollbars=yes');

}



function vista()

{	

   window.location.reload("vistaformularioinscripcion.php");	

}

</script> 

</form>

</body>

</html>