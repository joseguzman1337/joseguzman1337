<?php require_once('../Connections/usuarios.php'); ?>
<?php
$creditos=0;
$periodocon="";
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
function MyApprox($fValue,$sigdigits=0,$mode=0,$inverseNeg=0)
// mode=-1 gives floor
// mode=0 (default) gives automatic Round to nearest digit : >5 -> +1
// mode=1 gives ceil
// inverseNeg=0 (default)-> PHP floor/ceil behavior, floor(-2.3)=-6, floor towards -INF
// inverseNeg=1 -> inverse floor/ceil behavior means floor(-2.3)=-5, floor towards 0 in case of need
{
   $sValue=''.(float)($fValue);
   $lenght=strlen($sValue);
   $isNeg=$fValue<0;
   if(($sigdigits<=0)||($sigdigits==False))
     {
       if(($inverseNeg)&&($isNeg)) $mode=-$mode;
       if($mode==-1) return floor($fValue);
       if($mode==1) return ceil($fValue);
       return round($fValue);
     }
   
   $posDot=strpos($sValue,'.');  
   $sResult=str_replace(array('.','-'),'', $sValue);
   $fResult=0.0;
   if(($mode==0)&&(intval($sResult{$sigdigits})>=5)) $fResult=1.0;
   $sResult=substr($sResult,0,$sigdigits);
   
   $fResult+=(float)$sResult;
   if($isNeg)
     {
       if($inverseNeg)
         {
           if($mode==1) $fResult+=1;
         }
       else if($mode==-1) $fResult+=1;
     }
   else if($mode==1) $fResult+=1;
   
   if($posDot==False) $posDot=$lenght;
   $numb=$sigdigits-($posDot-$isNeg);
   if($numb>0) for($i=0;$i<$numb;$i++) $fResult/=10.0;
   else if($numb<0) for($i=0;$i<$numb;$i++) $fResult*=10.0;
   if($isNeg) return -$fResult;
   else return $fResult;
}
session_start();
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

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?><?php
mysql_select_db($database_usuarios, $usuarios);
$query_periodo = "SELECT * FROM periodo ORDER BY nombreperiodo DESC";
$periodo = mysql_query($query_periodo, $usuarios) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);
mysql_select_db($database_usuarios, $usuarios);

if (!$_POST['periodo'])
{
	$periodocon=$row_periodo['codigoperiodo'];
	
}
else
{
	$periodocon=$_POST['periodo'];
	
}
/*if (!$periodocon)
{
	$periodocon=$row_periodo['codigoperiodo'];
}*/
$query_Recordset1 = sprintf("SELECT nota.*,materia.nombremateria,materia.numerocreditos, grupo.codigomateria FROM nota,materia,grupo WHERE nota.codigomateria=materia.codigomateria and materia.codigomateria=grupo.codigomateria and nota.codigogrupo=grupo.codigogrupo and codigoestudiante = '%s' and nota.codigoperiodo = '%s' ",$_SESSION['codigo'],$periodocon);
$Recordset1 = mysql_query($query_Recordset1, $usuarios) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_usuarios, $usuarios);
$query_Recordset2 = sprintf("SELECT * FROM estudiante WHERE codigoestudiante = '%s'",$_SESSION['codigo']);
$Recordset2 = mysql_query($query_Recordset2, $usuarios) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$facultad=$row_Recordset2['codigocarrera'];

mysql_select_db($database_usuarios, $usuarios);
$query_Recordset3 = sprintf("SELECT * FROM carrera WHERE codigocarrera = '%s'",$row_Recordset2['codigocarrera']);
$Recordset3 = mysql_query($query_Recordset3, $usuarios) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_usuarios, $usuarios);
$query_Recordset4 = sprintf("SELECT * FROM materia WHERE codigomateria = '%s'",$row_Recordset1['codigomateria']);
$Recordset4 = mysql_query($query_Recordset4, $usuarios) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

if (($row_Recordset2['codigocarrera']==100) or ($row_Recordset2['codigocarrera']==200) ) {
	?>
	<p align="center"><span class="Estilo9">En Este momento no se encuentran habilitadas las notas para esta facultad.<br>
  Lamentamos los Inconvenientes
  </span>
<?php

} else {
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana;
	font-weight: bold;
	font-size: 10px;
}
.Estilo3 {font-family: Verdana; font-weight: bold; font-size: x-small; }
.Estilo9 {font-family: Verdana; font-size: small; font-weight: bold; }
.style1 {
	font-family: Verdana;
	font-size: 10px;
}
.Estilo17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.Estilo19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo22 {font-size: 10px}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_jumpMenuGo(selName,targ,restore){ //v3.0
  var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
}
//-->
</script>
</head>

<body>
<form name="form1" method="post" action="notas.php">
  <table width="90%"  border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="3"><span class="Estilo19"><?php echo $row_Recordset2['nombresestudiante']; ?> <?php echo $row_Recordset2['apellidosestudiante']; ?> </span></td>
      <td><span class="Estilo19"> CODIGO: <?php echo $row_Recordset1['codigoestudiante']; ?></span></td>
    </tr>
    <tr>
      <td colspan="4"><div align="center" class="Estilo19">REGISTRO DE CALIFICACIONES </div></td>
    </tr>
    <tr>
      <td width="10%"><span class="Estilo19">Periodo</span></td>
      <td width="47%"><span class="Estilo21">
        <select name="periodo" onChange="MM_jumpMenu('notas.php',this,0)">
          <?php
do {  
?>
          <option value="<?php echo $row_periodo['codigoperiodo']?>"><?php echo $row_periodo['nombreperiodo']?></option>
          <?php
} while ($row_periodo = mysql_fetch_assoc($periodo));
  $rows = mysql_num_rows($periodo);
  if($rows > 0) {
      mysql_data_seek($periodo, 0);
	  $row_periodo = mysql_fetch_assoc($periodo);
  }
?>
        </select>
        <input type="submit" name="Button1" value="Actualizar" onClick="MM_jumpMenuGo('menu1','parent',0)">
        </span></td>
      <td><span class="Estilo19">Fecha</span></td>
      <td class="Estilo17 Estilo22"><?php echo date("j/m/Y",time());?>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="Estilo19">Facultad</span></td>
      <td class="Estilo21">&nbsp;</td>
      <td width="16%"><span class="Estilo19">Programa </span></td>
      <td width="27%"><span class="Estilo21"><?php echo $row_Recordset3['nombrecarrera']; ?></span></td>
    </tr>
  </table>
  <br>
  <table width="90%"  border="1" cellpadding="2" cellspacing="1" bordercolor="#E97914">
    <tr>
      <td width="10%"><span class="Estilo19">C&oacute;digo</span></td>
      <td width="28%"><span class="Estilo19">Nombre Asignatura </span></td>
      <td width="3%"><span class="Estilo19">C</span></td>
      <td width="3%"><div align="center" class="Estilo1 Estilo21">G</div></td>
      <td width="3%"><div align="center" class="Estilo3 Estilo21 Estilo22">1</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">2</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">3</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">4</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">5</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">6</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">7</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">8</div></td>
      <td width="3%"><div align="center" class="Estilo19">%</div></td>
      <td width="3%"><div align="center" class="Estilo19">F</div></td>
      <td width="3%"><span class="Estilo19">F%</span></td>
      <td width="3%"><span class="Estilo19">R</span></td>
      <td width="3%"><span class="Estilo19">%</span></td>
      <td width="3%"><span class="Estilo22"></span></td>
    </tr>
    <?php $promedio=0;do { ?>
    <tr>
      <td class="Estilo21"><?php echo $row_Recordset1['codigomateria']; ?></td>
      <td class="Estilo21"><?php echo $row_Recordset1['nombremateria']; ?></td>
      <td class="Estilo21"><?php echo $row_Recordset1['numerocreditos'];?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['codigogrupo']; ?>&nbsp;</td>
      <td class="Estilo21"><?php  if($row_Recordset1['porcentaje1']>0){ echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota1']*100/$row_Recordset1['porcentaje1']));} ?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje1']; ?>&nbsp;</td>
      <td class="Estilo21"><?php  if($row_Recordset1['porcentaje2']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota2']*100/$row_Recordset1['porcentaje2'])); } ?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje2']; ?>&nbsp;</td>
      <td class="Estilo21"><?php if($row_Recordset1['porcentaje3']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota3']*100/$row_Recordset1['porcentaje3']));}?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje3']; ?>&nbsp;</td>
      <td class="Estilo21"><?php if($row_Recordset1['porcentaje4']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota4']*100/$row_Recordset1['porcentaje4'])); }?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje4']; ?>&nbsp;</td>
      <td class="Estilo21"><?php if($row_Recordset1['porcentaje5']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota5']*100/$row_Recordset1['porcentaje5'])); }?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje5']; ?>&nbsp;</td>
      <td class="Estilo21"><?php if($row_Recordset1['porcentaje6']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota6']*100/$row_Recordset1['porcentaje6'])); }?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje6']; ?>&nbsp;</td>
      <td class="Estilo21"><?php if($row_Recordset1['porcentaje7']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota7']*100/$row_Recordset1['porcentaje7'])); }?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje7']; ?>&nbsp;</td>
      <td class="Estilo21"><?php if($row_Recordset1['porcentaje8']>0){echo sprintf("%.2f",sprintf("%.1f",$row_Recordset1['nota8']*100/$row_Recordset1['porcentaje8'])); }?>&nbsp;</td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentaje8']; ?>&nbsp;</td>
      <td class="style1"><span class="Estilo21">
        <?php 
	  	$final1=$row_Recordset1['nota1']+$row_Recordset1['nota2']+$row_Recordset1['nota3']+$row_Recordset1['nota4']+$row_Recordset1['nota5']+$row_Recordset1['nota6']+$row_Recordset1['nota7']+$row_Recordset1['nota8'];
		$final=sprintf("%.1f",$final1);
		$final=sprintf("%.2f",$final);
		echo $final;
		$nota=$final*$row_Recordset1['numerocreditos'];
		$creditos=$creditos+$row_Recordset1['numerocreditos'];
		$promedio=$promedio+$nota;?>
      </span></td>
      <td class="style1"><span class="Estilo21">
        <?php 
	  	$finalpor=$row_Recordset1['porcentaje1']+$row_Recordset1['porcentaje2']+$row_Recordset1['porcentaje3']+$row_Recordset1['porcentaje4']+$row_Recordset1['porcentaje5']+$row_Recordset1['porcentaje6']+$row_Recordset1['porcentaje7']+$row_Recordset1['porcentaje8'];
		echo $finalpor;
		?>
      </span></td>
      <td class="Estilo21"><?php 
	  	if ($row_Recordset1['notarecuperacion']){
			$promedio=$promedio-$nota;
			$promedio=$promedio+($row_Recordset1['notarecuperacion']*$row_Recordset1['numerocreditos']);
			echo $row_Recordset1['notarecuperacion'];
		} ?></td>
      <td class="Estilo21"><?php echo $row_Recordset1['porcentajerecuperacion']; ?></td>
      <td class="Estilo21">&nbsp;</td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    <tr>
      <td colspan="25"><span class="Estilo19">Promedio Semestre:</span>        <span class="Estilo21">
        <?php 
		if ($creditos>0){
			$prom=$promedio/$creditos;
			$prom=sprintf("%.1f",$prom);
			$prom=sprintf("%.2f",$prom);
		} else { $prom=0; }
		?>        
        <?php echo $prom  ?> </span> </td>
    </tr>
  </table>
  <br>
  <table width="90%"  border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td width="17%"><span class="Estilo19">1,2,3,4,5,6,7,8:&nbsp;&nbsp; CORTE</span></td>
      <td width="14%"><span class="Estilo19">R: RECUPERACION</span></td>
      <td width="9%"><span class="Estilo19">G: GRUPO </span></td>
      <td width="10%"><span class="Estilo19">C: CREDITOS </span></td>
      <td width="12%"><span class="Estilo19">F= NOTA FINAL </span></td>
      <td width="17%"><span class="Estilo19">F%= PORCENTAJE FINAL</span></td>
      <td width="21%"><span class="Estilo19">% = PORCENTAJE DEL CORTE </span></td>
    </tr>
    <tr>
      <td height="44" colspan="7"><div align="center" class="Estilo21"><strong>FORMATO NO VALIDO COMO CERTIFICADO DE NOTAS <br>
        Cualquier inconsistencia favor comunicarla a su Facultad.      </strong></div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
  $insertSQL = sprintf("INSERT INTO log (fechaconsulta, numerodocumento, codigolog) VALUES (%s, %s, %s)",
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($_SESSION['codigo'], "text"),
                       GetSQLValueString(1, "int"));
					   
  mysql_select_db($database_usuarios, $usuarios);
  $Result1 = mysql_query($insertSQL, $usuarios) or die(mysql_error());
}

mysql_free_result($periodo);




  
mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
