<?php
include_once("./consultas_class.php");

if($_POST['action']=='consultaBloques'){
  $objeto = new ConsultarEspacios;
  $consultaBloquesBosque = $objeto->ConsultarEspaciosBosque($_POST['ClasificacionEspaciosId']);
  echo "<label>Bloque:</label>";
  echo "<select name='Bloque' onchange='salones(this.value)'>";
  echo "<option value='0'>Seleccione Bloque</option>";

  while (!$consultaBloquesBosque->EOF) {
    ?>
        <option value="<?php echo $consultaBloquesBosque->fields['ClasificacionEspaciosId'];?>">
            <?php echo $consultaBloquesBosque->fields['Nombre']." - ".$consultaBloquesBosque->fields['descripcion']; ?>
        </option>
    <?php
    $consultaBloquesBosque->MoveNext();
  }
  echo "</select> ";
  exit();
}elseif($_POST['action']=='consultaSalones'){
  $objeto = new ConsultarEspacios;
  $consultaSalonesBosque = $objeto->ConsultarEspaciosBosque($_POST['ClasificacionEspaciosId']);
  ?>
  <fieldset>
  <legend>Salones</legend>
  <?PHP
  while (!$consultaSalonesBosque->EOF) {
    ?>
        <a style="cursor: pointer;" onclick="mostrarAgenda(<?php echo $consultaSalonesBosque->fields['ClasificacionEspaciosId'];?>)"><?php echo $consultaSalonesBosque->fields['Nombre'].' :: '. $consultaSalonesBosque->fields['CapacidadEstudiantes']; ?></a>
        <br />
    <?php
    $consultaSalonesBosque->MoveNext();
  }
  ?>
  </fieldset>
  <?PHP
  
  exit();
}
elseif($_POST['action']=='consultaAgenda'){
  ?>
  <fieldset style="width: 100%;">
    <legend>11212</legend>
     <object
      type="text/html"
      data="<?PHP echo $_POST['Url']?>calendario3/wdCalendar/sample.php?id=<?php echo $_POST['ClasificacionEspaciosId']; ?>" 
      style="width: 250%; height:930px; text-align: center; margin-left: 50%;" >
      ERROR (no puede mostrarse el objeto)
    </object>
  </fieldset>

<?php
  exit();
}elseif($_POST['action']=='Name'){
    
    include_once("../templates/template.php");
		
    $db = getBD();
    
    $id= $_POST['id'];
    
    $SQL='SELECT Nombre FROM ClasificacionEspacios WHERE ClasificacionEspaciosId="'.$id.'"';
    
    if($Name=&$db->Execute($SQL)===false){
        $a_vectt['val']			=FALSE;
        $a_vectt['Descrip']		='Error en la Consulta...';
        echo json_encode($a_vectt);
        exit;
    }
        $a_vectt['val']			=TRUE;
        $a_vectt['Name']		=$Name->fields['Nombre'];
        echo json_encode($a_vectt);
        exit;
    
}
?>