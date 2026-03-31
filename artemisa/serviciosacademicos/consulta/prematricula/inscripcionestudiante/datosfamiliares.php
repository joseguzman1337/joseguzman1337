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
    $query_parentesco = "select idtipoestudiantefamilia, nombretipoestudiantefamilia from tipoestudiantefamilia order by 2";
    $parentesco = $db->Execute($query_parentesco);
    $totalRows_parentesco = $parentesco->RecordCount();
    $row_parentesco = $parentesco->FetchRow();
    $query_niveleducacion = "select idniveleducacion, nombreniveleducacion, codigomodalidadacademica, pesoniveleducacion "
    ."from niveleducacion order by 2";
    $niveleducacion = $db->Execute($query_niveleducacion);
    $totalRows_niveleducacion = $niveleducacion->RecordCount();
    $row_niveleducacion = $niveleducacion->FetchRow();
    $query_ciudad2 = "select idciudad, nombreciudad, nombrecortociudad, iddepartamento, codigosapciudad, codigoestado from ciudad order by 3";
    $ciudad2 = $db->Execute($query_ciudad2);
    $totalRows_ciudad2 = $ciudad2->RecordCount();
    $row_ciudad2 = $ciudad2->FetchRow();
    
           
?>
<html>
    <head>
        <title>.:iNGRESOiCFES:.</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <script language="JavaScript" src="calendario/javascripts.js"></script>
    </head>
    <body>
        <?php
        if(isset($_REQUEST['inicial'])){ 
            ?>
            <a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $codigo_inscripcion."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>" id="aparencialinknaranja">
                Inicio
            </a>
            <br><br>
            <?php
        }//if
        ?>
        <form name="inscripcion" method="post" action="datosfamiliares.php">
            <?php  
            //consulta
            $query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo "
            ."FROM inscripcionformulario ip, inscripcionmodulo im "
            ." WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo "
            ." AND ip.codigomodalidadacademica = '".$modalidad_academica."'" 
            ." AND ip.codigoestado LIKE '1%' order by posicioninscripcionformulario";
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
            and i.codigoestado like '1%'
            AND e.idnumeroopcion = '1' 
            and i.idinscripcion = '".$id_inscripcion."'"; 
            $data = $db->Execute($query_data);
            $totalRows_data = $data->RecordCount();
            $row_data = $data->FetchRow();
            if(isset($_POST['inicial']) or isset($_GET['inicial'])) { // vista previa	  
                ?>
                <p>FORMULARIO DEL ASPIRANTE</p>
                <?php
                if (isset($_GET['inicial'])){
                    $moduloinicial = $_GET['inicial'];
                    echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 
                }else{
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

            $query_datosgrabados = "SELECT * FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n 
            WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
            and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia								 							 
            and e.idniveleducacion = n.idniveleducacion 
            and e.codigoestado like '1%'
            order by e.idtipoestudiantefamilia";			  		
            $datosgrabados = $db->Execute($query_datosgrabados);
            $totalRows_datosgrabados = $datosgrabados->RecordCount();
            $row_datosgrabados = $datosgrabados->FetchRow();

            if ($row_datosgrabados <> ""){ 
                ?>
                <br>
                <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                    <tr id="trtitulogris">
                        <td>Parentesco</td>
                        <td>Nombre</td>
                        <td>Nivel de educación</td>
                        <td>Profesi&oacute;n</td>
                        <td>Dirección</td>
                        <td>Teléfono</td>
                        <td>Celular</td>
                        <td>Acción</td>
                    </tr>
                    <?php

                        do{ ?>
                            <tr>
                                <td><?php echo $row_datosgrabados['nombretipoestudiantefamilia'];?></td>
                                <td><?php echo $row_datosgrabados['nombresestudiantefamilia'];?> <?php echo $row_datosgrabados['apellidosestudiantefamilia'];?></td>
                                <td><?php echo $row_datosgrabados['nombreniveleducacion'];?></td>
                                <td><?php echo $row_datosgrabados['profesionestudiantefamilia'];?></td>
                                <td><?php echo $row_datosgrabados['direccionestudiantefamilia'];?></td>
                                <td><?php echo $row_datosgrabados['telefonoestudiantefamilia'];?></td>					 
                                <td><?php echo $row_datosgrabados['celularestudiantefamilia'];?></td>					 
                                <td>
                                <?php
                                /**
                                * @modifed RubioLeonardo@unbosque.edu.co
                                 * @since 28/10/2019
                                 * adicion de validacion variable codigoestudiante para identificar acceso como aspirante o como administrativo
                                 * si la variable codigoestudiante tiene valor entonces hay acceso es desde el formulario inscripcion, sino es un acceso desde las opciones del estudiante.
                                 */

                                if (!isset($_GET["codigoestudiante"])){?>
                                    <a onClick="window.open('editardatosfamiliares.php?id=<?php echo $row_datosgrabados['idestudiantefamilia'];?>','mensajes','width=850,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a>
                                <a onClick="window.open('eliminar.php?datosfamiliares&id=<?php echo $row_datosgrabados['idestudiantefamilia'];?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a></td>
                                <?php } ?>
                            </tr>
			    <?php  
                        }while($row_datosgrabados = $datosgrabados->FetchRow());
                    ?>
                </table> 
                <?php
            }else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])){
                ?>
                <!-- <tr>
                <td>Sin datos diligenciados</td>
                </tr> -->
                <?php
            }
            if(isset($_POST['inicial']) or isset($_GET['inicial'])){ // vista previa	  	   

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

<script language="javascript">

function grabar()

 {

  document.inscripcion.submit();

 }

</script>

<input type="hidden" name="grabado" value="grabado">   

<br>

   <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

     <tr>

       <td colspan="6" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>

     </tr>

     <tr>

       <td id="tdtitulogris">Parentesco*</td>

       <td><select name="parentesco">

           <option value="0" <?php if (!(strcmp("0", $_POST['parentesco']))) {echo "SELECTED";} ?>>Seleccionar</option>

           <?php

				do 

				{  

?>

           <option value="<?php echo $row_parentesco['idtipoestudiantefamilia']?>"<?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $_POST['parentesco']))) {echo "SELECTED";} ?>><?php echo $row_parentesco['nombretipoestudiantefamilia']?></option>

           <?php	  

                } 

				while($row_parentesco = $parentesco->FetchRow());

				?>

         </select>

       </td>

       <td id="tdtitulogris">Nombre*</td>

       <td>

         <input type="text" name="nombres" size="25" value="<?php echo $_POST['nombres'];?>">

       </td>

       <td id="tdtitulogris">Apellidos*</td>

       <td><input type="text" name="apellidos"  size="25" value="<?php echo $_POST['apellidos'];?>"></td>

     </tr>

     <tr>

       <td id="tdtitulogris">Edad</td>

       <td>

         <input name="edad" type="text" id="edad" size="2" maxlength="3" value="<?php echo $_POST['edad'];?>">

       </td>

       <td id="tdtitulogris">Profesión</td>

       <td>

         <input type="text" name="profesion" size="25" value="<?php echo $_POST['profesion'];?>">

       </td>

       <td id="tdtitulogris">Ocupación</td>

       <td><input type="text" name="ocupacion" size="25" value="<?php echo $_POST['ocupacion'];?>"></td>

     </tr>

     <tr>

       <td id="tdtitulogris">E-mail</td>

       <td colspan="3"><input type="text" name="email" size="40" value="<?php echo $_POST['email'];?>"></td>

       <td id="tdtitulogris">Celular</td>

       <td><input type="text" name="celular" size="20" value="<?php echo $_POST['celular'];?>"></td>

     </tr>

    <tr>

            <td id="tdtitulogris">Ciudad</td>

            <td>

			  <select name="ciudadfamilia">

                <option value="0" <?php if (!(strcmp("0", $_POST['ciudadfamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>

                <?php

				do 

				{  

?>

                <option value="<?php echo $row_ciudad2['idciudad']?>"<?php if (!(strcmp($row_ciudad2['idciudad'], $_POST['ciudadfamilia']))) {echo "SELECTED";} ?>><?php echo $row_ciudad2['nombreciudad'];?></option>

                <?php				  

                } 

				while($row_ciudad2 = $ciudad2->FetchRow());

				?>

              </select>

			</td>

            <td id="tdtitulogris">Direcci&oacute;n</td>

            <td> <input name="direccion1" type="text" id="direccion1" size="25" maxlength="50" value="<?php echo $_POST['direccion1'];?>">

            </td>

            <td id="tdtitulogris">Tel&eacute;fono</td>

            <td>

              <input name="telefono1" type="text" id="Celular4" size="25" value="<?php echo $_POST['telefono1'];?>">

            </td>

      </tr>

     <tr>

       <td id="tdtitulogris">Nivel de Educaci&oacute;n</td>

       <td><select name="niveleducacion">

           <option value="0" <?php if (!(strcmp("0", $_POST['niveleducacion']))) {echo "SELECTED";} ?>>Seleccionar</option>

           <?php

				do 

				{

				?>

           <option value="<?php echo $row_niveleducacion['idniveleducacion']?>"<?php if (!(strcmp($row_niveleducacion['idniveleducacion'], $_POST['niveleducacion']))) {echo "SELECTED";} ?>><?php echo $row_niveleducacion['nombreniveleducacion'];?></option>

           <?php				  

                } 

				while($row_niveleducacion = $niveleducacion->FetchRow());

				?>

         </select>

       </td>

       <td id="tdtitulogris">Direcci&oacute;n Correspondencia</td>

       <td>

             

               <input name="direccion2" type="text" id="direccion2" size="25"  value="<?php echo $_POST['direccion2']?>">

            </td>

       <td id="tdtitulogris">Tel&eacute;fono</td>

       <td>

         <input name="telefono2" type="text" id="telefono2" size="25" value="<?php echo $_POST['telefono2']?>">

       </td>

     </tr>

   </table>

 </td> 

</tr>   

</table>     

      <br>

	  <input type="button" value="Enviar" onClick="grabar()">

	  <input type="button" value="Vista Previa" onClick="vista()">

     <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar"> -->

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

	        if ($_POST['parentesco'] <> 0 or $_POST['nombres'] <> "" or $_POST['apellidos'] <> "" or $_POST['edad'] <> "" or $_POST['telefono1'] <> "" or $_POST['telefono2'] <> "" or $_POST['celular'] <> "" or $_POST['email'] <> "")

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

	  $email = "^[A-z0-9\._-]+"

	  ."@"

	  ."[A-z0-9][A-z0-9-]*"

  	  ."(\.[A-z0-9_-]+)*"

 	  ."\.([A-z]{2,6})$";

	  if ($_POST['parentesco'] == 0)

	   {

	     echo '<script language="JavaScript">alert("Debe elegir el parentesco")</script>';		

		 $banderagrabar = 1;

	   }

	  else	  

       if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombres']) or $_POST['nombres'] == ""))

	  {

	    echo '<script language="JavaScript">alert("Falta digitar el nombre")</script>';		

		$banderagrabar = 1;

	  }

	 else

	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['apellidos']) or $_POST['apellidos'] == ""))

	  {

	    echo '<script language="JavaScript">alert("Falta digitar los apellidos")</script>';		

		$banderagrabar = 1;

	  }	

	 else

	  if (!eregi("^[0-9]{1,15}$", $_POST['edad']) and $_POST['edad'] <> "")

	  {

	    echo '<script language="JavaScript">alert("Falta digitar la edad")</script>';		

		$banderagrabar = 1;

	  }	

	 else

	  if (!eregi("^[0-9]{1,15}$", $_POST['telefono1']) and $_POST['telefono1'] <> "")

	  {

	    echo '<script language="JavaScript">alert("Teléfono Incorrecto")</script>';		

		$banderagrabar = 1;

	  }

	 else

	  if (!eregi("^[0-9]{1,15}$", $_POST['telefono2']) and $_POST['telefono2'] <> "")

	  {

	    echo '<script language="JavaScript">alert("Teléfono2 Incorrecto")</script>';		

		$banderagrabar = 1;

	  }	

	 else

	  if (!eregi("^[0-9]{1,15}$", $_POST['celular']) and $_POST['celular'] <> "")

	  {

	    echo '<script language="JavaScript">alert("Celular Incorrecto")</script>';		

		$banderagrabar = 1;

	  }

	else	  

	  if (!eregi($email,$_POST['email']) and $_POST['email'] <> "")

	   {

	     echo '<script language="JavaScript">alert("E-mail Incorrecto")</script>';		    		  

   	     $banderagrabar = 1;

	   } 

	else

	 if ($banderagrabar == 0)

	 {	   

	    $nivel = "";

	    $ciudad = "";

	    if ($_POST['niveleducacion'] <> 0)

		 {

		   $nivel = $_POST['niveleducacion'];

		 }

		else 

		 {

		   $nivel = 5; 

		 }		 

	    if ($_POST['ciudadfamilia'] <> 0)

		 {

		   $ciudad = $_POST['ciudadfamilia'];

		 }

		else 

		 {

		   $ciudad = 1;

		 }

	    $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idinscripcion,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado) 

		VALUES(0,'".$_POST['apellidos']."','".$_POST['nombres']."','".$_POST['edad']."', '".$_POST['direccion1']."','".$ciudad."','".$_POST['telefono1']."','".$_POST['telefono2']."','".$_POST['celular']."','".$_POST['email']."','".$_POST['direccion2']."','".$row_data['idestudiantegeneral']."','".$row_data['idinscripcion']."','".$_POST['parentesco']."','".$_POST['profesion']."','".$_POST['ocupacion']."','".$nivel."','100')"; 

		//echo "$query_insestudiantedocumento <br>";

		$familia = $db->Execute($query_familia);

		 if ($paginaactual == 0)

		 {

		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosfamiliares.php?inicial=$moduloinicial'>";

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

     <!-- <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  -->

<script language="javascript">

function recargar(dir)

{

	window.location.reload("datosfamiliares.php"+dir);

	history.go();

}

function vista()

{	

   window.location.reload("vistaformularioinscripcion.php");	

}

</script> 

</form>