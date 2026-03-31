<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     //require_once('../../../Connections/usuarios.php'); 
require_once('../../Connections/sala2.php'); 
session_start();

/* if (! isset ($_SESSION['nombreprograma']))
 {
?>
	 <script>
	   window.location.reload("../login.php");
	 </script>
<?php	
 }
 else 
 if ($_SESSION['nombreprograma'] <> "cortesala.php")
{
?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php	 	
} */
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 
 // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
   // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$colname_Recordset1 = "1";
if (isset($_SESSION['codigofacultad']))
{
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['codigofacultad'] : addslashes($_SESSION['codigofacultad']);
}
mysql_select_db($database_sala, $sala);
$query_Recordset1 ="SELECT codigomateria, nombremateria 
FROM materia 
WHERE codigoestadomateria = '01'  
and codigocarrera = '$colname_Recordset1'
ORDER BY nombremateria ";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT codigoperiodo 
FROM periodo 
WHERE codigoestadoperiodo = '1'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

mysql_select_db($database_sala, $sala);
$query_fechacortes ="SELECT fechacortenotas
FROM fechaacademica
WHERE codigocarrera = '$colname_Recordset1'
and  codigoperiodo = '".$row_periodo['codigoperiodo']."'";
//echo $query_fechacortes;
$fechacortes = mysql_query($query_fechacortes, $sala) or die(mysql_error());
$row_fechacortes = mysql_fetch_assoc($fechacortes);
$totalRows_fechacortes = mysql_num_rows($fechacortes);

 if ($row_fechacortes['fechacortenotas'] < date("Y-m-d"))
   {
     echo '<script language="javascript">alert("La Fecha máxima para digitación de Cortes era hasta '.$row_fechacortes['fechacortenotas'].'")</script>';
     $crearcortes=1;
   }

mysql_select_db($database_sala, $sala);
$query_notas ="SELECT DISTINCT dn.codigoestudiante  
FROM grupo g,nota n,detallenota dn,materia m
WHERE g.idgrupo = n.idgrupo
AND dn.idgrupo = n.idgrupo
AND m.codigomateria = g.codigomateria
AND g.codigoperiodo = '".$row_periodo['codigoperiodo']."'
AND m.codigocarrera = '$colname_Recordset1'";
//echo $query_fechacortes;
$notas = mysql_query($query_notas, $sala) or die(mysql_error());
$row_notas = mysql_fetch_assoc($notas);
$totalRows_notas = mysql_num_rows($notas);

if ($row_notas <> "")
   {
     echo '<script language="javascript">alert("Ya han digitado notas en algunas materias, No es posible abrir mas cortes")</script>';
     $crearcortes=1;
   }
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px }
.Estilo2 {font-family: Tahoma; font-weight: bold; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-weight: bold; font-size: 14px}
-->
</style>
<form name="form1" method="post" action="cortesala.php">
  <span class="style1">  </span>
  <table width="500"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr valign="middle">
      <td  bgcolor="#C5D5D6" class="Estilo2" align="center">Facultad</td>
      <td colspan="3" class="Estilo1"><?php echo $_SESSION['codigofacultad'];?>&nbsp;       
<?php 
	  echo $_SESSION['nombrefacultad']; 
?>      </td>
    </tr>
    <tr valign="middle">
      <td  bgcolor="#C5D5D6" class="Estilo2" align="center">Materia</td>
      <td class="Estilo1">
        <select name="materia" id="materia"<?php if($crearcortes == 1){ ?>  disabled="true" <?php }?>>
	    <option value="1">Todas las Materias</option>
<?php

do{ 

	if (!empty($_POST['materia'])){
		if($_POST['materia'] == $row_Recordset1['codigomateria'] ){
			?>  <option selected value="<?php echo $row_Recordset1['codigomateria']?>"><?php echo $row_Recordset1['nombremateria']." - ".$row_Recordset1['codigomateria'];?></option><?php
		}else
		
		   ?>  <option  value="<?php echo $row_Recordset1['codigomateria']?>"><?php echo $row_Recordset1['nombremateria']." - ".$row_Recordset1['codigomateria'];?></option><?php
	}else{
?>
          <option value="<?php echo $row_Recordset1['codigomateria']?>"><?php echo $row_Recordset1['nombremateria']." - ".$row_Recordset1['codigomateria'];?></option>
<?php
	}
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      </span>
      <input name="codigoperiodo" type="hidden" id="codigoperiodo" value="<?php echo $row_periodo['codigoperiodo']; ?>">     
	  <input name="ano" type="hidden" id="ano" value="<?php echo date("Y",time())?>">      
	  <input name="materia1" type="hidden" id="materia1" value="<?php echo $_POST['materia'];?>">
          <span class="Estilo4"> </span></td>
      <td  bgcolor="#C5D5D6" class="Estilo2" align="center">No.  de cortes</td>
      <td class="Estilo1"><input name="cantidadcortes" type="text" id="cantidadcortes" value="<?php echo $_POST['cantidadcortes'] ;?>" size="1" maxlength="2" <?php if($crearcortes == 1){ ?>  disabled="true" <?php }?>></td>
    </tr>
    <tr valign="middle">
    	<?php if($crearcortes != 1){ ?> 
      <td colspan="4"   class="style1"><div align="center">
        <input name="submit" type="submit" id="submit" value="Digitar Cortes">
      </div></td>
        <?php } else {?>
		<td colspan="4" bgcolor="#C5D5D6" class="Estilo2" align="center">No puede adicionar cortes nuevos, para modificación de fechas y porcentajes lo puede realizar por la opción Consultar y modificar fechas y porcentajes para la digitación de notas.</td>
        <?php } ?>
    </tr>
  </table>
  <br>  
  <div align="center">	</br> 
    <?php 
    if ($_POST['Submit'])
	 {
	  require_once('validarcortesala.php');
	   exit();
	 }  
   if ($_POST['cantidadcortes'] <> "")
	   {////if 1
  ?>
    
</div>
  <div align="center"></div>
  <table width="50%"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td width="22%" align="center"  bgcolor="#C5D5D6" class="Estilo2">Cortes</td>
<?php 
     for($i = 1; $i <= $_POST['cantidadcortes'] ; $i++)
     {
      echo "<td  bgcolor='#C5D5D6' colspan='2' class='Estilo1' align='center'>".$i."</td>";
     }
  echo "</tr>"; 
?>
   </tr>
    <tr>
      <td  bgcolor="#C5D5D6" rowspan="2" class="EStilo2" align="center">Fecha Inicial</td>
<?php
	   for($i = 1; $i <= $_POST['cantidadcortes'] ; $i++)
	     {
	      echo "<td class='Estilo2' align='center'>D&iacute;a</td>";
	      echo "<td class='Estilo2' align='center'>Mes</td>";
		 }
?>  
    </tr>
    <tr>
<?php
     for($i = 1; $i <= $_POST['cantidadcortes'] ; $i++)
	     {
           echo "<td class='Estilo1'>";
           echo "<select name='diaini".$i."' id='diaini'>"; ?>
          <option> </option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
          <option>6</option>
          <option>7</option>
          <option>8</option>
          <option>9</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          <option>13</option>
          <option>14</option>
          <option>15</option>
          <option>16</option>
          <option>17</option>
          <option>18</option>
          <option>19</option>
          <option>20</option>
          <option>21</option>
          <option>22</option>
          <option>23</option>
          <option>24</option>
          <option>25</option>
          <option>26</option>
          <option>27</option>
          <option>28</option>
          <option>29</option>
          <option>30</option>
          <option>31</option>
        </select>
</td>      
<?php
	    echo "<td class='Estilo1'>"; 
        echo "<select name='mesini".$i."' id='mesini'>";
?> 
		<option> </option>
        <option value="01">Ene</option>
        <option value="02">Feb</option>
        <option value="03">Mar</option>
        <option value="04">Abr</option>
        <option value="05">May</option>
        <option value="06">Jun</option>
        <option value="07">Jul</option>
        <option value="08">Ago</option>
        <option value="09">Sep</option>
        <option value="10">Oct</option>
        <option value="11">Nov</option>
        <option value="12">Dic</option>
      </select>
</td>	  
	<?php }?> 
    </tr>
    <tr>
      <td  bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha Final</td>
<?php 
   for($i = 1; $i <= $_POST['cantidadcortes'] ; $i++)
	     {  
			echo "<td class='Estilo1'>";
			echo "<select name='diafin".$i."' id='select15'>";
?>
          <option> </option>
		  <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
          <option>6</option>
          <option>7</option>
          <option>8</option>
          <option>9</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          <option>13</option>
          <option>14</option>
          <option>15</option>
          <option>16</option>
          <option>17</option>
          <option>18</option>
          <option>19</option>
          <option>20</option>
          <option>21</option>
          <option>22</option>
          <option>23</option>
          <option>24</option>
          <option>25</option>
          <option>26</option>
          <option>27</option>
          <option>28</option>
          <option>29</option>
          <option>30</option>
          <option>31</option>
        </select>
</td>
<?php	  
           echo "<td class='Estilo1'>";
           echo "<select name='mesfin".$i."' id='select37'>";
?>
		  <option value="<?php $_POST['mesfin1'.$i] ?>"> </option>
		  <option value="01">Ene</option>
          <option value="02">Feb</option>
          <option value="03">Mar</option>
          <option value="04">Abr</option>
          <option value="05">May</option>
          <option value="06">Jun</option>
          <option value="07">Jul</option>
          <option value="08">Ago</option>
          <option value="09">Sep</option>
          <option value="10">Oct</option>
          <option value="11">Nov</option>
          <option value="12">Dic</option>
        </select>
      </td>
	  <?php }?>
    </tr>
    <tr>
      <td  bgcolor="#C5D5D6" class="Estilo2" align="center">Porcentaje</td>
    <?php
	 for($i = 1; $i <= $_POST['cantidadcortes'] ; $i++)
	     {  
	       echo "<td colspan='2' class='Estilo1' align='center'><input name='porcentaje".$i."' type='text' size='1' maxlength='3' value='".$_POST['porcentaje1'.$i]."'> %</td>";
         }?>
    </tr>
    <tr>
      <td colspan="50" class="Estilo" align="center"><input name="Submit" type="submit" value="Guardar Cambios"></td>
    </tr>
  </table>
 <?php 
 }//if 1
 ?> 
  <br>
</form>
<?php
mysql_free_result($Recordset1);
mysql_free_result($periodo);
?>



