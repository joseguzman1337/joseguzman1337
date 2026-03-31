<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from membresia where idmembresia = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
.Estilo4 {font-family: Tahoma; font-size: 12px; font-weight: bold; color: #FF0000}
-->
</style>
<body class="style1">
<form name="form1" method="post" action="modificarmembresia.php"><div align="center">
<p><strong><span class="Estilo3">MODIFICACI&Oacute;N DE  DATOS</span><br>
    <span class="Estilo2"><br>
    </span></strong><span class="Estilo2">
    <?php
	 $fecha=date("Y-n-j",time());
	   if ($_POST['nombremembresia'] == "")
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
 
else
{
    require_once('modificarmembresia1.php');
	exit();
}

    ?>
    </span></p>
    <table border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n <span class="Estilo4">*</span>&nbsp;</td>
        <td class="Estilo1"><input name="nombremembresia" type="text" id="nombremembresia" value="<?php echo $row['nombremembresia'];?>" size="40"></td>
      </tr>
    </table>
    <p>
      <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
    </p>
    </div>
  <p align="center">
    <input type="submit" name="Submit" value="Modificar">
  </p>
</form>

