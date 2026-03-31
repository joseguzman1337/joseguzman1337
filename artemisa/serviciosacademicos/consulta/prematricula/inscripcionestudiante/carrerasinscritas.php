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
        $modalidad_academica = $modalidadacademica;
    }
?>

<html>

<head>

<title>.:Carreras Referencia:.</title>

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

<form name="inscripcion" method="post" action="carrerasinscritas.php">

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

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion,c.codigocarrera

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

            $fecha = date("Y-m-d G:i:s",time());

			$query_car = "SELECT nombrecarrera,codigocarrera 

					      FROM carrera 

						  where codigomodalidadacademica = '".$modalidad_academica."'

						  AND fechavencimientocarrera > '".$fecha."'

						  and codigocarrera <> '".$row_data['codigocarrera']."'

						  order by 1";		

			//echo $query_car;

			//exit();

			$car = $db->Execute($query_car);

			$totalRows_car = $car->RecordCount();

			$row_car = $car->FetchRow();

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

//echo "<br>";

 // vista previa	   

		    $query_periodo = "select * from periodo p,carreraperiodo c

			                  where p.codigoperiodo = c.codigoperiodo

							  and c.codigocarrera = '".$row_data['codigocarrera']."'

			                  and p.codigoestadoperiodo like '1' 

							  order by p.codigoperiodo";

			$periodo = $db->Execute($query_periodo);

			$totalRows_periodo = $periodo->RecordCount();

			$row_periodo = $periodo->FetchRow();
                        /*
                         * Caso 107045.
                         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>.
                         * Se adiciona la condición idnumeroopcion <> '1' para que no muestre la msma carerra a la que esta inscrito
                         * Ya que esta por defecto es primera opción. 
                         * @copyright Dirección de Tecnología Universidad el Bosque
                         * @since 7 de Noviembre de 2018.
                        */      
			$query_datosgrabados = "SELECT * 
                            FROM estudiantecarrerainscripcion e,carrera c,modalidadacademica m
                            WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
                            AND m.codigomodalidadacademica = c.codigomodalidadacademica								
                            AND e.codigocarrera = c.codigocarrera
                            AND e.codigoestado like '1%'
                            AND e.idinscripcion = '".$id_inscripcion."'
                            AND e.idnumeroopcion <> '1'
                            ORDER BY idnumeroopcion";			  

                            $datosgrabados = $db->Execute($query_datosgrabados);
                            $totalRows_datosgrabados = $datosgrabados->RecordCount();
                            $row_datosgrabados = $datosgrabados->FetchRow();
                        //End Caso 107045.                        
		  if ($row_datosgrabados <> "")

		   { ?>

		       <br>

			   <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

                <tr id="trtitulogris">

					<td>Opción</td>

					<td>Carrera</td>					

                   <td>Modalidad</td>

                   <td>Editar</td>		

                </tr>

		       <?php 			    

				 do{ ?>

			        <tr>

                     <td><?php echo $row_datosgrabados['idnumeroopcion'];?></td>

					 <td><?php echo $row_datosgrabados['nombrecarrera'];?></td>

                      <td><?php echo $row_datosgrabados['nombremodalidadacademica'];?></td>

                     <td>

<?php 

					       $query_datosgrabados1 = "SELECT * 

						   FROM estudiante e,inscripcion i, situacioncarreraestudiante s 

						   WHERE i.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

						   AND e.codigocarrera = '".$row_datosgrabados['codigocarrera']."'												   								   

						   AND i.idinscripcion = '".$row_datosgrabados['idinscripcion']."'

						   AND e.idestudiantegeneral = i.idestudiantegeneral 
						   
						   AND e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante";

						   //echo $query_datosgrabados1; 

	  					 $datosgrabados1 = $db->Execute($query_datosgrabados1);

						$totalRows_datosgrabados1 = $datosgrabados1->RecordCount();

						$row_datosgrabados1 = $datosgrabados1->FetchRow();

						 if (! $row_datosgrabados1)

						 {
/**
 * @modifed RubioLeonardo@unbosque.edu.co
 * @since 28/10/2019
 * adicion de validacion variable codigoestudiante para identificar acceso como aspirante o como administrativo
 * si la variable codigoestudiante tiene valor entonces hay acceso es desde el formulario inscripcion, sino es un acceso desde las opciones del estudiante.
 */

                                if (!isset($_GET["codigoestudiante"])) {
                                    ?>

                                    <a onClick="window.open('editarcarrerasinscritas.php?id=<?php echo $row_datosgrabados['idestudiantecarrerainscripcion']; ?>','mensajes','width=800,height=300,left=300,top=500,scrollbars=yes')"
                                       style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20"
                                                                    alt="Editar"></a>

                                    <a onClick="window.open('eliminar.php?carrerasinscritas&id=<?php echo $row_datosgrabados['idestudiantecarrerainscripcion']; ?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')"
                                       style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20"
                                                                    height="20" alt="Eliminar"></a>

                                    <?php
                                }
					     }

					    else

					     {

						  echo $row_datosgrabados1["nombresituacioncarreraestudiante"];

						 }

?>

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

</tr>

 --><?php

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

      <td colspan="1"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>

	</tr>

	<tr id="trtitulogris">

 	  <td colspan="2">Carrera*</td>	  

<?php 

	 $cuentamedio = 1;

?> 

	 <tr>

          <td width="70%"><div>

		      <select name="carrera" id="especializacion" onChange="enviar()">

           <option value="0" <?php if (!(strcmp("0", $_POST['carrera']))) {echo "SELECTED";} ?>>Seleccionar</option>

 <?php

             do {  

?>

              <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'], $_POST['carrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>

<?php

				} while ($row_car = $car->FetchRow());

?>

          </select>

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

<div>

   <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">

   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  

    -->

	<br>

	<input type="button" value="Enviar" onClick="grabar()">

	<input type="button" value="Vista Previa" onClick="vista()">

	<input type="hidden" name="grabado" value="grabado">   

<?php

$banderagrabar = 1; 

$indicador = 0; 

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

	        if ($_POST['carrera'] <> 0)

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

	   if ($_POST['carrera'] == 0)

	    {

		  echo '<script language="JavaScript">alert("Debe seleccionar una Carrera"); history.go(-1);</script>';		

		  $indicador = 1;

		}	

	else

	 if ($indicador == 0)

	 {   

		$query_mayor = "select max(idnumeroopcion) as mayor

	    from estudiantecarrerainscripcion

	    where idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

		and idinscripcion = '".$row_data['idinscripcion']."'

		and codigoestado like '1%'";

  	    //echo $query_mayor;

		$mayor = $db->Execute($query_mayor);

		$totalRows_mayor = $mayor->RecordCount();

		$row_mayor = $mayor->FetchRow();

		$idnumeroopcion = $row_mayor['mayor'] + 1;

		

		$query_carrerainscripcion = "INSERT INTO estudiantecarrerainscripcion(codigocarrera, idnumeroopcion, idinscripcion, idestudiantegeneral,codigoestado) 

		VALUES('".$_POST['carrera']."', '$idnumeroopcion', '".$row_data['idinscripcion']."', '".$row_data['idestudiantegeneral']."', '100')"; 

		$inscripcion = $db->Execute($query_carrerainscripcion);

		 if ($paginaactual == 0)

		{

		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=carrerasinscritas.php?inicial=$moduloinicial'>"; 

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

	window.location.reload("carrerasinscritas.php"+dir);

	history.go();

}

function vista()

{	

   window.location.reload("vistaformularioinscripcion.php");	

}

</script>

</form>