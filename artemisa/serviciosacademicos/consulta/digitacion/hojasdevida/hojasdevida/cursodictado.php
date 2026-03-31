<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo4 {color: #FF0000}
-->
</style>
<form name="form1" method="post" action="cursodictado.php">
  <div align="center">
    <h6 align="center" class="Estilo3"><strong>CURSOS DICTADOS</strong></h6>
    <div align="center" class="Estilo1">
      <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
        if (! $row){
		 echo "La información básica es obligatoria.";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		}  
	else	
		 do
		{  ?>
      <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";?>
      <?php }while ($row=mysql_fetch_array($sol)); 
    
	
	  $base= "select * from cursoinformaldictado,tipocursodictado where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(cursoinformaldictado.codigotipocursodictado=tipocursodictado.codigotipocursodictado))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {?>
	      <br>&nbsp;</br>
	      <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr class="style1">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Tipo de curso </div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Instituci&oacute;n</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Disciplina</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Nombre</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Duraci&oacute;n</div></td>
			 <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Lugar</div></td>
			 <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Tipo evento &nbsp;</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
           </tr>
<?php      
		 do{  ?>
            <tr>
              <td><div align="center" class="Estilo1"><?php echo $row['nombretipocursodictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['institucioncursoinformaldictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['areacursoinformaldictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['nombrecursoinformaldictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['unidadtiempocursoinformaldictado'];?>&nbsp;<?php echo $row['tiempocursoinformaldictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['lugarcursoinformaldictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['tipoeventocursoinformaldictado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo "<a href='modificarcursodictado.php?modificar=".$row['idcursoinformaldictado']."'>MODIFICAR</a>" ?></div></td>
            <?php }while ($row=mysql_fetch_array($sol)); }?>
            <?php
//
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocursodictado ORDER BY tipocursodictado.codigotipocursodictado";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
            <title></title>
      </table>
    </div>
    <h6 class="Estilo1">
      <?php
	  //$fecha=date("Y-n-j",time());
   if (($_POST['institucioncursoinformaldictado'] == "")or($_POST['areacursoinformaldictado'] == "") or ($_POST['nombrecursoinformaldictado'] == "")or ($_POST['unidadtiempocursoinformaldictado'] == "")or ($_POST['tiempocursoinformaldictado'] == "")or ($_POST['lugarcursoinformaldictado'] == "")or ($_POST['codigotipocursodictado'] == 0)or ($_POST['tipoeventocursoinformaldictado'] == ""))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
  /* else
  if ( !( checkdate($_POST['mes'],$_POST['dia'],$_POST['ano']))or ($_POST['ano'] > date("Y",strtotime($fecha)))or ($_POST['ano'] < 1930)or(($_POST['ano'] >= date("Y",strtotime($fecha))) and ($_POST['mes'] >= date("m",strtotime($fecha))) and ($_POST['dia'] >= date("d",strtotime($fecha))))) {

   echo "<h5>Fecha Incorrecta</h5>";
}*/

   
else 
     {
     require_once('capturacursodictado.php');
	 exit();
     }

    ?>
    </h6>
    <table width="430" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n <span class="Estilo4">* </span></td>
        <td width="240" class="Estilo1"><input name="institucioncursoinformaldictado" type="text" id="institucioncursoinformaldictado" value="<?php echo $_POST['institucioncursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Disciplina <span class="Estilo4">* </span></td>
        <td class="Estilo1"><input name="areacursoinformaldictado" type="text" id="areacursoinformaldictado" value="<?php echo $_POST['areacursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nombre <span class="Estilo4">* </span></td>
        <td class="Estilo1"><input name="nombrecursoinformaldictado" type="text" id="nombrecursoinformaldictado" value="<?php echo $_POST['nombrecursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tiempo de Duraci&oacute;n <span class="Estilo4">* </span></td>
        <td class="Estilo1"><input name="unidadtiempocursoinformaldictado" type="text" id="unidadtiempocursoinformaldictado" value="<?php echo $_POST['unidadtiempocursoinformaldictado'];?>" size="1">
          <select name="tiempocursoinformaldictado" id="tiempocursoinformaldictado">
            <option value="" <?php if (!(strcmp("", $_POST['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Horas" <?php if (!(strcmp("Horas", $_POST['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Horas</option>
            <option value="Dias" <?php if (!(strcmp("Dias", $_POST['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Dias</option>
            <option value="Semanas" <?php if (!(strcmp("Semanas", $_POST['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Semanas</option>
            <option value="Meses" <?php if (!(strcmp("Meses", $_POST['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Meses</option>
            <option value="Años" <?php if (!(strcmp("Años", $_POST['tiempocursoinformaldictado']))) {echo "SELECTED";} ?>>Años</option>
          </select></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Lugar <span class="Estilo4">* </span></td>
        <td class="Estilo1"><input name="lugarcursoinformaldictado" type="text" id="lugarcursoinformaldictado" value="<?php echo $_POST['lugarcursoinformaldictado'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Curso <span class="Estilo4">* </span></td>
        <td class="Estilo1"><select name="codigotipocursodictado" id="codigotipocursodictado">
            <option value="value" <?php if (!(strcmp("value", $_POST['codigotipocursodictado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['codigotipocursodictado']?>"<?php if (!(strcmp($row_Recordset1['codigotipocursodictado'], $_POST['codigotipocursodictado']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipocursodictado']?></option>
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
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Evento <span class="Estilo4">* </span></td>
        <td class="Estilo1"><select name="tipoeventocursoinformaldictado" id="tipoeventocursoinformaldictado">
          <option value="value" <?php if (!(strcmp("value", $_POST['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <option value="Local" <?php if (!(strcmp("Local", $_POST['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Local</option>
          <option value="Regional" <?php if (!(strcmp("Regional", $_POST['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Regional</option>
          <option value="Nacional" <?php if (!(strcmp("Nacional", $_POST['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Nacional</option>
          <option value="Internacional" <?php if (!(strcmp("Internacional", $_POST['tipoeventocursoinformaldictado']))) {echo "SELECTED";} ?>>Internacional</option>
        </select></td>
      </tr>
    </table>
    <p class="Estilo1">
      <input type="submit" name="Submit" value="Grabar">
    </p>
    <p align="right" class="style1"><strong><span class="style7"> <span class="Estilo8"><a href="investigacion.php">Continuar >></a></span></span></strong></p>
  </div>
</form>
<?php
mysql_free_result($Recordset1);
?>