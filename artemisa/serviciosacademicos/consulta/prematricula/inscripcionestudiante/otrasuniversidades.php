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
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="inscripcion" method="post" action="otrasuniversidades.php">
<?php
    mysql_select_db($database_sala, $sala);       
    $query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo,im.idinscripcionmodulo
    FROM inscripcionformulario ip, inscripcionmodulo im
    WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
    AND ip.codigomodalidadacademica = '".$modalidad_academica."'
    AND ip.codigoestado LIKE '1%'
    order by posicioninscripcionformulario";
    $formularios = mysql_query($query_formularios, $sala) or die("$query_selgenero");
    $totalRows_formularios = mysql_num_rows($formularios);
    $row_formularios = mysql_fetch_assoc($formularios);
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
    }while($row_formularios = mysql_fetch_assoc($formularios));

    $query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion,c.codigocarrera
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
    $data = mysql_query($query_data, $sala) or die("$query_data");
    $totalRows_data = mysql_num_rows($data);
    $row_data = mysql_fetch_assoc($data);

    if(isset($_POST['inicial']) or isset($_GET['inicial'])){ // vista previa	             
        ?>
        <div align="center" class="style1">
            <p><img src="../../../../imagenes/inscripcion.gif" ></p>
        </div>
        <br>
        <?php
        if (isset($_GET['inicial'])){
            $moduloinicial = $_GET['inicial'];
            echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 
        }else{
            $moduloinicial = $_POST['inicial'];
            echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
        }
        ?>
        <table width="70%" border="1" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">
            <tr>
                <td>	
                    <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
                        <tr>        
                            <td colspan="2">
                                <table border="0" align="center" cellpadding="1" bordercolor="#003333">
                                    <tr>      
                                    <?php				      
                                        for($i= 1; $i < $cuentamodulos;$i++){
                                            if ($i == $moduloinicial){ 
                                                echo "<td  bgcolor='#FEF7ED' border='3' align='center' cellpadding='3' bordercolor='#003333'>"; 
                                                echo '<strong><div align = "center"><font size="1" face="Tahoma" color="#990033">',$nombremodulo[$i],"</font></div></strong>";
                                                echo "</td>"; 							  
                                            }else{
                                                echo "<td bgcolor='#CCDADD'>"; 
                                                echo '<strong><div align = "center"><font size="1" face="Tahoma">',$nombremodulo[$i],"</font></div></strong>";
                                                echo "</td>"; 							
                                            }
                                        }//for				   
                                    ?>			   
                                    </tr>	   
                                </table>
                            </td>
                        </tr>	  
                        <tr  bgcolor='#FEF7ED'>
                            <td class="Estilo2">&nbsp;Nombre</td>
                            <td class="Estilo1"><?php echo $row_data['nombresestudiantegeneral'];?>&nbsp;<?php echo $row_data['apellidosestudiantegeneral'];?></td>
                        </tr>
                        <tr  bgcolor='#FEF7ED'>
                            <td class="Estilo2">&nbsp;Modalidad Acad&eacute;mica</td>
                            <td class="Estilo1"><?php echo $row_data['nombremodalidadacademica'];?>&nbsp;</td>
                        </tr> 
                        <tr  bgcolor='#FEF7ED'>
                            <td width="37%" class="Estilo2">&nbsp;Nombre del Programa</td>
                            <td class="Estilo1"><?php echo $row_data['nombrecarrera'];?>&nbsp;</td>
                        </tr>
                    </table>
                    <?php
    } // vista previa	   

    $query_datosgrabados = "SELECT * FROM estudianteuniversidad e WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'								 						 
    and e.codigoestado like '1%'order by anoestudianteuniversidad";			  
    $datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios".mysql_error());
    $totalRows_datosgrabados = mysql_num_rows($datosgrabados);
    $row_datosgrabados = mysql_fetch_assoc($datosgrabados);   
    if ($row_datosgrabados <> ""){ 
        ?>
        <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
            <tr bgcolor="#CCDADD" class="Estilo2">
                <td align="center">Institución</td>
                <td align="center">Programa</td>
                <td align="center">Año</td>
                <td align="center">Editar</td>							
            </tr>
            <?php 
            do{ ?>
                <tr  bgcolor='#FEF7ED' class="Estilo1">
                    <td>
                        <div align="center">
                            <?php echo $row_datosgrabados['institucioneducativaestudianteuniversidad'];?>&nbsp;
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo $row_datosgrabados['programaacademicoestudianteuniversidad'];?>&nbsp;
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo $row_datosgrabados['anoestudianteuniversidad'];?>&nbsp;
                        </div>
                    </td>
                    <?php
                    /**
                     * @modifed RubioLeonardo@unbosque.edu.co
                     * @since 28/10/2019
                     * adicion de validacion variable codigoestudiante para identificar acceso como aspirante o como administrativo
                     * si la variable codigoestudiante tiene valor entonces hay acceso es desde el formulario inscripcion, sino es un acceso desde las opciones del estudiante.
                     */
                    ?>

                    <td>
                        <?php
                    if (!isset($_GET["codigoestudiante"])){?>
                        <div align="center">
                            <a onClick="window.open('editarotrasuniversidades.php?id=<?php echo $row_datosgrabados['idestudianteuniversidad'];?>','mensajes','width=800,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar">
                            </a>
                        </div>
                    <?php } ?>
                    </td>

                </tr>			   
                <?php  
            }while($row_datosgrabados = mysql_fetch_assoc($datosgrabados));
            ?>
            </table> 
            <?php
    }//if	      

    if(isset($_POST['inicial']) or isset($_GET['inicial'])){ // vista previa	  
        if (isset($_GET['inicial'])){
            $moduloinicial = $_GET['inicial'];
            echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 
        }else{
            $moduloinicial = $_POST['inicial'];
            echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">'; 
        }	
        ?>
        <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
            <tr class="Estilo3">
                <td colspan="3" bgcolor="#CCDADD"><div align="center" ><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" width="18" height="18" alt="Ayuda"></a></div></td>
            </tr>
            <tr class="Estilo2">
                <td bgcolor="#CCDADD" align="center">Instituci&oacute;n<span class="Estilo4">*</span></td>
                <td width="35%" bgcolor="#CCDADD" align="center">Programa<span class="Estilo4">*</span></td>
                <td width="31%" bgcolor="#CCDADD" align="center">Año Presentación</td>
            </tr>
            <tr  bgcolor='#FEF7ED' class="Estilo1">
                <td width="34%">
                    <div align="center">
                        <input type="text" name="institucion" size="50" value="<?php echo $_POST['institucion'];?>">
                    </div></td>



          <td ><div align="center">



            <input type="text" name="programa" size="50" value="<?php echo $_POST['programa'];?>">



          </div></td>



		  <td ><div align="center"><input name="ano" type="text" id="ano" size="2" maxlength="4" value="<?php echo $_POST['ano'];?>"></div></td>



		</tr>        



  </table>



  </td> 



</tr>   



</table>     



<script language="javascript">
function grabar(){
    document.inscripcion.submit();
}
function vista(){	
    window.location.reload("vistaformularioinscripcion.php");	
}
</script>
<br><br>
<div align="center">
   <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">
   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  
   <input type="hidden" name="grabado" value="grabado">
</div>

<div align="center">
   <br> <br>
    <?php
    $banderagrabar = 0; 
    if (isset($_GET['inicial'])){
        $moduloinicial = $_GET['inicial'];
        echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 
    }else{
        $moduloinicial = $_POST['inicial'];
        echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">'; 
    }



    if($moduloinicial > 1){
        $atras = $moduloinicial - 1;			
        echo '<input type="image" src="../../../../imagenes/izquierda.gif" name="atras" value="atras" width="25" height="25" alt="Atras">';
    }

		echo "&nbsp;&nbsp;";		

		if($moduloinicial < $limitemodulo)

		{

			$adelante = $moduloinicial + 1;

			//echo '<a href="'.$modulos[$adelante].'?inicial='.$adelante.'"><img src="../../../../imagenes/derecha.gif" width="20" height="20" alt="Adelante"></a>';

		    echo '<input type="image" src="../../../../imagenes/derecha.gif" name="adelante" value="adelante" width="25" height="25" alt="Adelante">';

		}

		 if ( $_POST['institucion'] <> "" or $_POST['programa'] <> "" or $_POST['ano'] <> "")

		

		$banderagrabar_continiar = 0;

		$paginaactual = 1;

		foreach ($_POST as $key => $value)

        {         

		 if (ereg("adelante",$key) or ereg("atras",$key))		

          {	         

		      if ( $_POST['institucion'] <> "" or $_POST['programa'] <> "" or $_POST['ano'] <> "")

	           {	          

		         $banderagrabar_continiar = 1;	        

			   }				 

		   }

		 else

		  if (ereg("Guardar", $key))

		  {

			$banderagrabar_continiar = 1;	 

			$paginaactual = 0;

		  }

        }

		



if ($banderagrabar_continiar == 1)

 {		

	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['institucion'])) or $_POST['institucion'] == "")

	    {

		  echo '<script language="JavaScript">alert("Digite la institución"); history.go(-1);</script>';		

		 $banderagrabar = 1;

		}	

	else

	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['programa'])) or $_POST['programa'] == "")

	 {   

		 echo '<script language="JavaScript">alert("Digite el programa"); history.go(-1);</script>';		

		$banderagrabar = 1;	

     }

	else

	if ((!eregi("^[0-9]{1,15}$", $_POST['ano']) or $_POST['ano'] > date("Y") or $_POST['ano'] < substr($row_data['fechanacimientoestudiantegeneral'],0,4)) and $_POST['ano'] <> "")

	  {

	    echo '<script language="JavaScript">alert("Año Incorrecto")</script>';		

		$banderagrabar = 1;

	  }      

   else

    if ($banderagrabar == 0){
        $query_carrerainscripcion = "INSERT INTO estudianteuniversidad(idestudiantegeneral, idinscripcion,institucioneducativaestudianteuniversidad,programaacademicoestudianteuniversidad,anoestudianteuniversidad,codigoestado) 
        VALUES('".$row_data['idestudiantegeneral']."','".$row_data['idinscripcion']."', '".$_POST['institucion']."','".$_POST['programa']."', '".$_POST['ano']."' ,'100')"; 		
        $inscripcion = mysql_db_query($database_sala,$query_carrerainscripcion) or die("query_carrerainscripcion".mysql_error());
        if ($paginaactual == 0){ 
		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=otrasuniversidades.php?inicial=$moduloinicial'>"; 
         } //aca
		else
        if (ereg("adelante",$key) or ereg("atras",$key)){
          foreach ($_POST as $key => $value){
           if (ereg("adelante",$key)){	       
		     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";
		     exit(); 			
	        }
	       else
	       if (ereg("atras",$key)){		    
		     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";
		     exit();			
	        } 
          }
        } // aca   
      }
 }
 else
 if (ereg("adelante",$key) or ereg("atras",$key)){
  foreach ($_POST as $key => $value){
     if (ereg("adelante",$key)){	       
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";
		 exit(); 			
	   }
	 else
	  if (ereg("atras",$key)){		    
		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";
		  exit();			
	  } 
     }//foreach
 }//if		
} // vista previa	  
?>
</div> 
<script language="javascript">
function recargar(dir){ 
  window.location.reload("otrasuniversidades.php"+dir);
  history.go();
}
</script>