<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from cursoinformaldictado where idcursoinformaldictado = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocursodictado";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma}
-->
</style>
<form name="form1" method="post" action="modificarcursodictado.php">
  <div align="center">
    <p><span class="Estilo3">MODIFICACI&Oacute;N DE DATOS</span><br>
      <span class="Estilo2"></strong>
      <?php
	
 $fecha=date("Y-n-j",time());
   if (($_POST['institucioncursoinformaldictado'] == "")or($_POST['areacursoinformaldictado'] == "") or ($_POST['nombrecursoinformaldictado'] == "")or ($_POST['tiempocursoinformaldictado'] == "")or ($_POST['unidadtiempocursoinformaldictado'] == "")or ($_POST['lugarcursoinformaldictado'] == "")or ($_POST['codigotipocursodictado'] == 0)or ($_POST['tipoeventocursoinformaldictado'] == ""))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
   
else 
     {
     require_once('modificarcursodictado1.php');
	 exit();
     }

    ?>
      </span></span></span></p>
    <table width="400" border="1" cellpadding="1" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n <span class="Estilo4">*</span></td>
        <td width="240" class="Estilo1"><input name="institucioncursoinformaldictado" type="text" id="institucioncursoinformaldictado" value="<?php echo $row['institucioncursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Disciplina <span class="Estilo4">*</span></td>
        <td class="Estilo1"><input name="areacursoinformaldictado" type="text" id="areacursoinformaldictado" value="<?php echo $row['areacursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Nombre <span class="Estilo4">*</span></td>
        <td class="Estilo1"><input name="nombrecursoinformaldictado" type="text" id="nombrecursoinformaldictado" value="<?php echo $row['nombrecursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Tiempo de Duraci&oacute;n <span class="Estilo4">*</span></td>
        <td class="Estilo1"><input name="unidadtiempocursoinformaldictado" type="text" id="unidadtiempocursoinformaldictado" value="<?php echo $row['unidadtiempocursoinformaldictado'];?>" size="1">
          <select name="tiempocursoinformaldictado" id="tiempocursoinformaldictado">
            <option value="" <?php if (!(strcmp("", $row['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Horas" <?php if (!(strcmp("Horas", $row['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Horas</option>
            <option value="Dias" <?php if (!(strcmp("Dias", $row['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Dias</option>
            <option value="Semanas" <?php if (!(strcmp("Semanas", $row['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Semanas</option>
            <option value="Meses" <?php if (!(strcmp("Meses", $row['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Meses</option>
            <option value="A&ntilde;os"Años <?php if (!(strcmp("Años", $row['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>A&ntilde;os</option>
          </select>
        </span>          <?php  $ano=date("Y",strtotime($row['fechacursoinformaldictado']));
			       $mes=date("m",strtotime($row['fechacursoinformaldictado']));
			       $dia=date("d",strtotime($row['fechacursoinformaldictado']));
			?></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Lugar <span class="Estilo4">*</span></td>
        <td class="Estilo1"><input name="lugarcursoinformaldictado" type="text" id="lugarcursoinformaldictado" value="<?php echo $row['lugarcursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Tipo de Curso <span class="Estilo4">*</span></td>
        <td class="Estilo1"><select name="codigotipocursodictado" id="codigotipocursodictado">
          <option value="value" <?php if (!(strcmp("value", $row['codigotipocursodictado']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipocursodictado']?>"<?php if (!(strcmp($row_Recordset1['codigotipocursodictado'], $row['codigotipocursodictado']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipocursodictado']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Tipo de Evento <span class="Estilo4">*</span></td>
        <td class="Estilo1">
          <select name="tipoeventocursoinformaldictado" id="tipoeventocursoinformaldictado">
            <option value="" <?php if (!(strcmp("", $row['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Local" <?php if (!(strcmp("Local", $row['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Local</option>
            <option value="Regional" <?php if (!(strcmp("Regional", $row['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Regional</option>
            <option value="Nacional" <?php if (!(strcmp("Nacional", $row['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Nacional</option>
            <option value="Internacional" <?php if (!(strcmp("Internacional", $row['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Internacional</option>
          </select>
        </span></td>
      </tr>
    </table>
    <p class="Estilo1">
      <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
    </p>
  </div>
  <p align="center">
    <span class="style3">
    <input type="submit" name="Submit" value="Modificar">
    </span> </p>
</form>

<?php
mysql_free_result($Recordset1);
?>
