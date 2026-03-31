<?php
//$db->debug = true;
$codigoinscripcion = $_SESSION['numerodocumentosesion']; 
//mysql_select_db($database_sala, $sala);
$query_parentesco = "select *
from tipoestudiantefamilia
order by 2";
$parentesco = $db->Execute($query_parentesco);
$totalRows_parentesco = $parentesco->RecordCount();
$row_parentesco = $parentesco->FetchRow();

$query_niveleducacion = "select *
from niveleducacion
order by 2";
$niveleducacion = $db->Execute($query_niveleducacion);
$totalRows_niveleducacion = $niveleducacion->RecordCount();
$row_niveleducacion = $niveleducacion->FetchRow();

$query_ciudad2 = "select *
from ciudad
order by 3";
$ciudad2 = $db->Execute($query_ciudad2);
$totalRows_ciudad2 = $ciudad2->RecordCount();
$row_ciudad2 = $ciudad2->FetchRow();

$query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo
FROM inscripcionformulario ip, inscripcionmodulo im
WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
AND ip.codigomodalidadacademica = '".$codigomodalidadacademicasesion."'
AND ip.codigoestado LIKE '1%'
order by posicioninscripcionformulario";
$formularios = $db->Execute($query_formularios);
$totalRows_formularios = $formularios->RecordCount();
$row_formularios = $formularios->FetchRow();
?>

<!-- <label id="labelresaltado">Los datos de Padre y Madre son obligatorios.</label> -->

<?php 
////
////Datos de la encuesta familiar de la parte de observatorio 
//	Editado por:Ing. Milton Chacon Fecha 03/09/2014
//  Descripcion: obtener los datos precargados de la encuesta si existen previamente
/* 
Inicio Adaptacion
*/

/*$query_encuesta = "SELECT DISTINCT
*
FROM
obs_admitidos_entrevista_conte
WHERE 
obs_admitidos_entrevista_conte.codigoestudiante=(SELECT estudiante.codigoestudiante FROM estudiante WHERE estudiante.idestudiantegeneral='".$this->estudiantegeneral->idestudiantegeneral."' 
													ORDER BY estudiante.codigoestudiante ASC LIMIT 1) 
ORDER BY obs_admitidos_entrevista_conte.idobs_admitidos_contextoP";
*/

$query_encuesta = "SELECT 
EstudianteDetallesPersonales.idobs_admitidos_contexto,
EstudianteDetallesPersonales.IdItemRespuesta
FROM EstudianteDetallesPersonales WHERE idestudiantegeneral='".$this->estudiantegeneral->idestudiantegeneral."' AND idobs_admitidos_contexto!='1'  LIMIT 8";

//echo $query_encuesta;
$encuesta = $db->Execute($query_encuesta);
$totalRows_encuesta = $encuesta->RecordCount();
$dataC = $encuesta->GetArray();


////fin de adaptacion */



$query_datosgrabados = "SELECT t.nombretipoestudiantefamilia, e.nombresestudiantefamilia, e.apellidosestudiantefamilia,
e.telefonoestudiantefamilia, e.ocupacionestudiantefamilia, e.idestudiantefamilia, e.idtipoestudiantefamilia
FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n 
WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia								 							 
and e.idniveleducacion = n.idniveleducacion 
and e.codigoestado like '1%'
order by e.idtipoestudiantefamilia";			  
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
if ($row_datosgrabados <> "") {
    ?>
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr id="trtitulogris">
        <td>Parentesco</td>
        <td>Nombre</td>
        <!--  <td>Nivel de educación</td> -->
        <!--  <td>Profesi&oacute;n</td> -->
        <!-- <td>Dirección</td>  -->
        <td>Ocupación</td>
        <td>Teléfono</td>
        <td>Actualizar</td>
    </tr>
    <?php
        do {
            ?>
    <tr>
        <td><?php echo $row_datosgrabados['nombretipoestudiantefamilia'];?></td>
        <td><?php echo $row_datosgrabados['nombresestudiantefamilia'];?> <?php echo $row_datosgrabados['apellidosestudiantefamilia'];?></td>
<!-- <td><?php echo $row_datosgrabados['nombreniveleducacion'];?></td>  -->
        <!-- <td><?php echo $row_datosgrabados['profesionestudiantefamilia'];?></td>  -->
        <!-- <td><?php echo $row_datosgrabados['direccionestudiantefamilia'];?></td>  -->
        <td><?php echo $row_datosgrabados['ocupacionestudiantefamilia'];?></td>
        <td><?php echo $row_datosgrabados['telefonoestudiantefamilia'];?></td>
        <!-- <td><?php echo $row_datosgrabados['celularestudiantefamilia'];?></td>  -->
        <td><a onClick="window.location.href='editardatosfamiliares_new.php?id=<?php echo $row_datosgrabados['idestudiantefamilia'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/editar.png" width="20" height="20" alt="Editar"></a>
            <a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?datosfamiliares&id=<?php echo $row_datosgrabados['idestudiantefamilia'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a></td>
    </tr>
    <?php
    }
        while($row_datosgrabados = $datosgrabados->FetchRow());
        ?>
</table> 
    <?php
}
else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) {
        ?>
<!-- <tr>
<td>Sin datos diligenciados</td>
</tr> -->
    <?php
    }
//if(isset($_POST['inicial']) or isset($_GET['inicial'])) 
{ // vista previa	  	   
    if (isset($_GET['inicial'])) {
        $moduloinicial = $_GET['inicial'];
        echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';

    }
    else {
        $moduloinicial = $_POST['inicial'];
        echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
    }
    ?>	
<script language="javascript">
    function grabar()
    {
        document.inscripcion.submit();
    }
    $(function() {
        $( document ).tooltip();
    });
</script>

<input type="hidden" name="grabado" value="grabado">   
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td colspan="6" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a></td>
    </tr>
    <tr>
        <td id="tdtitulogris">Parentesco*</td>
        <td><select name="idtipoestudiantefamilia">
                <option value="0" <?php if (!(strcmp("0", $_POST['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>
    <?php
    do {
        ?>
                <option value="<?php echo $row_parentesco['idtipoestudiantefamilia']?>"<?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $_POST['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>><?php echo $row_parentesco['nombretipoestudiantefamilia']?></option>
    <?php
                    }
                    while($row_parentesco = $parentesco->FetchRow());
                    ?>
            </select>
        </td>
        <td id="tdtitulogris">Nombre*</td>
        <td>
            <input type="text" name="nombresestudiantefamilia" size="25" value="<?php echo $_POST['nombresestudiantefamilia'];?>">
        </td>
        <td id="tdtitulogris">Apellidos*</td>
        <td><input type="text" name="apellidosestudiantefamilia"  size="25" value="<?php echo $_POST['apellidosestudiantefamilia'];?>"></td>
        <!--  </tr>
        <tr> -->
         <!--   <td id="tdtitulogris">Edad</td>
          <td>
            <input name="edad" type="text" id="edad" size="2" maxlength="3" value="<?php echo $_POST['edadfamiliares'];?>">
          </td> -->
    </tr>
    <tr>
    <!-- <td id="tdtitulogris">Profesión</td>
     <td>
      <input type="text" name="profesion" size="25" value="<?php echo $_POST['profesion'];?>">
    </td> -->
        <td id="tdtitulogris">Ocupación</td>
        <td><input type="text" name="ocupacionestudiantefamilia" size="25" value="<?php echo $_POST['ocupacionestudiantefamilia'];?>"></td>
        <!--  </tr>
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
    do {
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
                </td> -->
        <td id="tdtitulogris">Tel&eacute;fono</td>
        <td>
            <input name="telefonoestudiantefamilia" type="text" id="Celular4" size="25" value="<?php echo $_POST['telefonoestudiantefamilia'];?>">
        </td>
    </tr>
    <tr>
     <?php //* codigo actualizado para preguntas de entrevista Milton Chacon 03/09/2014 */ ?>
	 <table width="100%" border="1"  cellspacing="0" bordercolor="#E9E9E9">
		 <form action="" method="post" id="form_test2">
		  <input type="hidden" name="entity2" id="entity2" value="admitidos_entrevista_conte">
		  <input type="hidden" name="codigoestado" id="codigoestado" value="100" />

			
									<tr>
										<td colspan="6"><b><center>PREGUNTAS DE LA FAMILIA  Y DEL CONTEXTO EN GENERAL</center></b></td>
									 <tr>
										<td id="tdtitulogris" colspan="3"><b><center>Pregunta</center></b></td>
										<td id="tdtitulogris" colspan="3"><b><center>Opciones</center></b></td>
										
									 </tr>
									 <?php
										 
                                         /////mensajes de ayuda///////////
                                         $mensajes[0]="Indique si su lugar de residencia permanente es diferente a la ciudad de Bogotá y acaba de llegar para realizar sus estudios.";
                                         $mensajes[1]="Seleccione la opción que corresponda según su desempeño académico en el Colegio.";
                                         $mensajes[2]="Indique el nivel académico alcanzado de su  madre.";
                                         $mensajes[3]="Indique si se encuentra laborando actualmente como empleado o independiente. De lo contrario, seleccione “Ninguno”";
                                         $mensajes[4]="Seleccione el rango de edad en la cual presentó la Prueba Saber 11";
                                         $mensajes[5]="Seleccione la cantidad de hermanos en su núcleo familiar.";
                                         $mensajes[6]="En caso de tener hermanos, seleccione su posición en orden de nacimiento.";
                                         /////////////////////////////////
                                         
										 $sql_con="select * from obs_admitidos_contexto where idpadre=0 AND idobs_admitidos_contexto <> '1'";
										
										 //echo $sql_con;
										 $data_in=$db->Execute($sql_con);
										 $i=0; $j=0;
										 foreach($data_in as $dt){
											 ?>
												<tr>
													<td id="tdtitulogris" colspan="3"><?php echo $dt['nombre'] ?><label id="labelresaltado">*</label><img alt="<?php echo $mensajes[$i];?>" src="../../../../imagenes/pregunta.gif">
														<input type="hidden" name="idobs_admitidos_contextoP[]" id="idobs_admitidos_contextoP"  value="<?php echo $dt['idobs_admitidos_contexto'] ?>" >
													
														
													</td>
													<td colspan="3"><?php
															
															$id=$dt['idobs_admitidos_contexto'];
															$query_op= "select * from obs_admitidos_contexto where idpadre='".$id."' and codigoestado='100'";
															//echo $query_op;
															$reg_op =$db->Execute($query_op);
															$z=0;
															?>
														<select id="idobs_admitidos_contexto_<?php echo $i ?>" name="idobs_admitidos_contexto[]">
															<option value="">-Seleccione-</option>
															<?php
															foreach($reg_op as $dt1){
																/*   ///codigo de respaldo
                                                                 if($id==14){
																	$id2=$dataC[7]['IdItemRespuesta'];
																}else{
																	$id2=$dataC[$id-1]['IdItemRespuesta'];
																}*/
                                                                $id2=$dataC[$i]['IdItemRespuesta'];															
															  ?>
																<option value="<?php echo $dt1['idobs_admitidos_contexto'] ?>"
																		<?php
                                                                        
																   if($id2==$dt1['idobs_admitidos_contexto']) echo "selected"     
																		?>><?php echo $dt1['nombre']; ?></option>
															  <?php
															  
															}
														  ?>  
														 </select>
												  </td>
												  
												   
												</tr>      
											<?php
										   
											$i++; $j++;
										 }
										 $iT=$i-1;
									 ?>
							   
								<input type="hidden" name="cant_con" id="cant_con" value="<?php echo $iT?>" />
							
							  
		</form>
	</table>
	  <?php ///  fin codigo actualizado para preguntas de entrevista Milton Chacon 03/09/2014 */ ?>
    </tr>
	
   <!-- <tr>
     <td id="tdtitulogris">Nivel de Educaci&oacute;n</td>
     <td><select name="niveleducacion">
         <option value="0" <?php if (!(strcmp("0", $_POST['niveleducacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
    <?php
    do {
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
   </tr> -->
</table>
<!--       <br>
          <input type="button" value="Enviar" onClick="grabar()">
          <input type="button" value="Vista Previa" onClick="vista()"> -->
     <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar"> -->
<?php
} // vista previa	  
?>
     <!-- <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  -->
<script language="javascript">
    /*function recargar(dir)
{
        window.location.reload("datosfamiliares.php"+dir);
        history.go();
}*/
    function vista()
    {
        window.location.reload("vistaformularioinscripcion.php");
    }
    
    function validar2(){
             var i=0;
             jQuery("select[name='idobs_admitidos_contexto[]']").each(function() {
                 //alert($(this).val()+'-->');
                 if($(this).val()==''){
                      alert("Debe escoger una de las opciones");
                        $(this).css('border-color','#F00');
                        $(this).focus();
                         i++;
                 }
             });
             if (i>0){
                 return false;
             }else{
                 return true;
             }
       }
</script> 
