<?php 
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
//mysql_select_db($database_sala, $sala);
session_start();
$codigoperiodo = $_SESSION['codigoperiodosesion'];

if (isset($_GET['materia']))
 {
  $nombremateria = $_GET['materia'];
  $materiacompleta = explode(" ", $_GET['materia']);
  $_GET['materia'] = $materiacompleta[0];
 }
 

$query_materia = "SELECT  *
from temasdetalleplanestudio
where codigomateria = '".$_GET['materia']."'
and   codigoperiodo = '$codigoperiodo'
and   codigoestado like '1%'";						
$materia =  $db->Execute($query_materia);
$row_materia = $materia->FetchRow();
$totalRows_materia = $materia->RecordCount();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Contenidos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<form name="form1" method="post" action="">
<input name="materia" type="hidden" value="<?php if(isset($_GET['materia'])) echo $_GET['materia']; else echo $_POST['materia'];?>" >
<input name="plan" type="hidden" value="<?php if(isset($_GET['plan'])) echo $_GET['plan']; else echo $_POST['plan'];?>" >
<input name="tipomensaje" type="hidden" value="<?php if(isset($_POST['tipomensaje'])) echo $_POST['tipomensaje'];?>" >


<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>
 <p align="center">CONTENIDO DE LA MATERIA <BR>  <?php echo $nombremateria;?> <br  style="background-attachment:fixed"> <?php echo $codigoperiodo;?></p>

<table align="center"  width="70%" bordercolor="#E9E9E9" border="1" cellpadding="1" cellspacing="0">
<tr>
 <td id="tdtitulogris" bordercolorlight="#E97914">Agregar Contenido  <input name="tipomensaje" type="radio" value="1" <?php if ($_POST['tipomensaje'] == 1) echo "checked";?> ></td>
 <td id="tdtitulogris" bordercolorlight="#E97914">Editar Contenido   <input name="tipomensaje" type="radio" value="2"   <?php if ($_POST['tipomensaje'] == 2) echo "checked";?> ></td>
 <td id="tdtitulogris" bordercolorlight="#E97914">Eliminar Contenido <input name="tipomensaje" type="radio" value="3" <?php if ($_POST['tipomensaje'] == 3) echo "checked";?> ></td>
</tr>
<tr>
 <td colspan="3" align="center"> <input type="submit" name="consultar" value="Consultar"></td>
</tr>
<?php 
 if (isset($_POST['consultar']) and $_POST['tipomensaje'] == 1)
  {
?> 
   <tr> 
    <td colspan="3" ><textarea name="contenido" cols="50" rows="3" ><?php echo $_POST["contenido"];?></textarea></td>
  </tr>
  <tr>
   <td colspan="3" align="center"> <input type="submit" name="actualiza" value="Actualizar"></td>
  </tr> 
<?	 
  }
?>
<?php 
 if (isset($_POST['consultar']) and ($_POST['tipomensaje'] == 2 or $_POST['tipomensaje'] == 3) and $row_materia <> "")
  {
   $w=1;
   do{
?> 
   <tr> 
    <td colspan="3" style="border-top-color:#FF9900"><input type="checkbox" name="idmensajes<?php echo $w;?>"  value="<?php echo $row_materia['idtemasdetalleplanestudio'];?>" onClick="HabilitarGrupo('mensaje<?php echo $w;?>')"> 
	<br> <?php echo '<textarea name="mensaje'.$w.'" cols="50" rows="2" disabled>'.$row_materia['descripciontemasdetalleplanestudio'].'</textarea>';?></textarea></td>
  </tr>
<?php 
    $w++;
   }while($row_materia = $materia->FetchRow());
?> 
  <tr>
   <td height="28" colspan="3" align="center"><input type="hidden" name="totalmensajes" value="<?php echo $w;?>"> <input type="submit" name="actualiza" value="Actualizar"></td>
  </tr> 
<?	 
  }
?>
</table>

<?php 
if($_POST['actualiza'])
{
	if($_POST['tipomensaje'] == 1 and $_POST['contenido'] <> "")
	{  /////if 1
	    // strtoupper($_POST["contenido"]) // mayusculas
		$sql = "insert into temasdetalleplanestudio(idtemasdetalleplanestudio,idplanestudio,codigomateria,codigoperiodo,descripciontemasdetalleplanestudio,codigoestado)";
		$sql.= "VALUES('0','".$_POST["plan"]."','".$_POST["materia"]."','$codigoperiodo','".$_POST["contenido"]."','100')"; 
		//echo $sql;
		$result = $db->Execute($sql);
	} /////if 1
	else
	if($_POST['tipomensaje'] == 2)	   
	{ /////if 1  
      for($i=1;$i<$_POST['totalmensajes'];$i++)
		{	  
			
			if ($_POST["idmensajes".$i] == true)
			{	
				//$_POST["mensaje".$i] = strtoupper($_POST["mensaje".$i]);
				$base="update temasdetalleplanestudio
				set descripciontemasdetalleplanestudio = '".$_POST["mensaje".$i]."'
				where idtemasdetalleplanestudio        = '".$_POST["idmensajes".$i]."'";			   
				$sol=$db->Execute($base);	
				
			}
		}
	} /////if 1
	else
	if($_POST['tipomensaje'] == 3)	   
	{ /////if 2  
     
	  for($i=1;$i<$_POST['totalmensajes'];$i++)
		{	  
			
			if ($_POST["idmensajes".$i] == true)
			{					
				$base="update temasdetalleplanestudio
				set codigoestado = '200'
				where idtemasdetalleplanestudio = '".$_POST["idmensajes".$i]."'";			   
				$sol=$db->Execute($base);	
				//echo $base;
			}
		}
	} /////if 2
}
?>
</body>
</form>
</html>
<script language="javascript">
function HabilitarGrupo(seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		
		if(elemento.type == "textarea")
		{
			var reg = new RegExp("^"+seleccion);
			//elemento.name.search(regexp)
			//elemento.title == seleccion 	
			if(!elemento.name.search(reg))
			{
			  if(elemento.disabled == true)
			   {
				elemento.disabled = false;				
			   }
			  else
			   {
			    elemento.disabled = true;	
			   }
			}
		  	
		}
	}
}
</script>