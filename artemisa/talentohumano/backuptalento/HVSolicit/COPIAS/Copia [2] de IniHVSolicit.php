<?php require_once('../Connections/conexion.php'); ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO thvsolicit (CCHojaVi, Nombres, Apellidos, FechIngr, AreaAd1, AreaAd2, AreaAd3, AreaAd4, AreaAd5, Facult1, Facult2, Facult3, Facult4, Facult5, CargoAd1, CargoAd2, CargoAd3, CargoAd4, CargoAd5, Asignat1, Asignat2, Asignat3, Asignat4, Asignat5, Sexo, EstCivil, Edad, Nacional, FechaNac, LugarNac, LibrMili, Distrito, Clase, FechaExp, Pasaport, Profesion, MatrProf, MatrDe, FondPens, EPS, GrupoSan, Direccion, Barrio, Telefono, Celular, Email, AvisarA, TelAvis, PadresVi, Conyuge, OcupCony, NoHijos, NombHij1, NombHij2, NombHij3, NombHij4, NombHij5, FeNaHij1, FeNaHij2, FeNaHij3, FeNaHij4, FeNaHij5, IdenHij1, IdenHij2, IdenHij3, IdenHij4, IdenHij5, EdadHij1, EdadHij2, EdadHij3, EdadHij4, EdadHij5, UnEdHij1, UnEdHij2, UnEdHij3, UnEdHij4, UnEdHij5, SexoHij1, SexoHij2, SexoHij3, SexoHij4, SexoHij5, Titulo1, Titulo2, Titulo3, Titulo4, Titulo5, Titulo6, Titulo7, NivelT1, NivelT2, NivelT3, NivelT4, NivelT5, NivelT6, NivelT7, Instit1, Instit2, Instit3, Instit4, Instit5, Instit6, Instit7, CiudaT1, CiudaT2, CiudaT3, CiudaT4, CiudaT5, CiudaT6, CiudaT7, FechaT1, FechaT2, FechaT3, FechaT4, FechaT5, FechaT6, FechaT7, EstudAct, Program1, Program2, Program3, Program4, Program5, Semestr1, Semestr2, Semestr3, Semestr4, Semestr5, InstAct1, InstAct2, InstAct3, InstAct4, InstAct5, Horario1, Horario2, Horario3, Horario4, Horario5, PrVirDi1, PrVirDi2, PrVirDi3, PrVirDi4, PrVirDi5, Software1, Software2, Software3, Software4, Software5, Idioma1, Idioma2, Idioma3, Idioma4, Idioma5, Entidad1, Entidad2, Entidad3, Entidad4, Entidad5, Entidad6, Entidad7, CargoOc1, CargoOc2, CargoOc3, CargoOc4, CargoOc5, CargoOc6, CargoOc7, TelEnti1, TelEnti2, TelEnti3, TelEnti4, TelEnti5, TelEnti6, TelEnti7, DirEnti1, DirEnti2, DirEnti3, DirEnti4, DirEnti5, DirEnti6, DirEnti7, JefeInm1, JefeInm2, JefeInm3, JefeInm4, JefeInm5, JefeInm6, JefeInm7, MotiRet1, MotiRet2, MotiRet3, MotiRet4, MotiRet5, MotiRet6, MotiRet7) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CCHojaVi'], "int"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['FechIngr'], "date"),
                       GetSQLValueString($_POST['AreaAd1'], "text"),
                       GetSQLValueString($_POST['AreaAd2'], "text"),
                       GetSQLValueString($_POST['AreaAd3'], "text"),
                       GetSQLValueString($_POST['AreaAd4'], "text"),
                       GetSQLValueString($_POST['AreaAd5'], "text"),
                       GetSQLValueString($_POST['Facult1'], "text"),
                       GetSQLValueString($_POST['Facult2'], "text"),
                       GetSQLValueString($_POST['Facult3'], "text"),
                       GetSQLValueString($_POST['Facult4'], "text"),
                       GetSQLValueString($_POST['Facult5'], "text"),
                       GetSQLValueString($_POST['CargoAd1'], "text"),
                       GetSQLValueString($_POST['CargoAd2'], "text"),
                       GetSQLValueString($_POST['CargoAd3'], "text"),
                       GetSQLValueString($_POST['CargoAd4'], "text"),
                       GetSQLValueString($_POST['CargoAd5'], "text"),
                       GetSQLValueString($_POST['Asignat1'], "text"),
                       GetSQLValueString($_POST['Asignat2'], "text"),
                       GetSQLValueString($_POST['Asignat3'], "text"),
                       GetSQLValueString($_POST['Asignat4'], "text"),
                       GetSQLValueString($_POST['Asignat5'], "text"),
                       GetSQLValueString($_POST['Sexo'], "text"),
                       GetSQLValueString($_POST['EstCivil'], "text"),
                       GetSQLValueString($_POST['Edad'], "int"),
                       GetSQLValueString($_POST['Nacional'], "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString($_POST['LugarNac'], "text"),
                       GetSQLValueString($_POST['LibrMili'], "int"),
                       GetSQLValueString($_POST['Distrito'], "text"),
                       GetSQLValueString($_POST['Clase'], "text"),
                       GetSQLValueString($_POST['FechaExp'], "date"),
                       GetSQLValueString($_POST['Pasaport'], "text"),
                       GetSQLValueString($_POST['Profesion'], "text"),
                       GetSQLValueString($_POST['MatrProf'], "text"),
                       GetSQLValueString($_POST['MatrDe'], "text"),
                       GetSQLValueString($_POST['FondPens'], "text"),
                       GetSQLValueString($_POST['EPS'], "text"),
                       GetSQLValueString($_POST['GrupoSan'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Barrio'], "text"),
                       GetSQLValueString($_POST['Telefono'], "text"),
                       GetSQLValueString($_POST['Celular'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['AvisarA'], "text"),
                       GetSQLValueString($_POST['TelAvis'], "text"),
                       GetSQLValueString($_POST['PadresVi'], "text"),
                       GetSQLValueString($_POST['Conyuge'], "text"),
                       GetSQLValueString($_POST['OcupCony'], "text"),
                       GetSQLValueString($_POST['NoHijos'], "int"),
                       GetSQLValueString($_POST['NombHij1'], "text"),
                       GetSQLValueString($_POST['NombHij2'], "text"),
                       GetSQLValueString($_POST['NombHij3'], "text"),
                       GetSQLValueString($_POST['NombHij4'], "text"),
                       GetSQLValueString($_POST['NombHij5'], "text"),
                       GetSQLValueString($_POST['FeNaHij1'], "date"),
                       GetSQLValueString($_POST['FeNaHij2'], "date"),
                       GetSQLValueString($_POST['FeNaHij3'], "date"),
                       GetSQLValueString($_POST['FeNaHij4'], "date"),
                       GetSQLValueString($_POST['FeNaHij5'], "date"),
                       GetSQLValueString($_POST['IdenHij1'], "int"),
                       GetSQLValueString($_POST['IdenHij2'], "int"),
                       GetSQLValueString($_POST['IdenHij3'], "int"),
                       GetSQLValueString($_POST['IdenHij4'], "int"),
                       GetSQLValueString($_POST['IdenHij5'], "int"),
                       GetSQLValueString($_POST['EdadHij1'], "int"),
                       GetSQLValueString($_POST['EdadHij2'], "int"),
                       GetSQLValueString($_POST['EdadHij3'], "int"),
                       GetSQLValueString($_POST['EdadHij4'], "int"),
                       GetSQLValueString($_POST['EdadHij5'], "int"),
                       GetSQLValueString($_POST['UnEdHij1'], "text"),
                       GetSQLValueString($_POST['UnEdHij2'], "text"),
                       GetSQLValueString($_POST['UnEdHij3'], "text"),
                       GetSQLValueString($_POST['UnEdHij4'], "text"),
                       GetSQLValueString($_POST['UnEdHij5'], "text"),
                       GetSQLValueString($_POST['SexoHij1'], "text"),
                       GetSQLValueString($_POST['SexoHij2'], "text"),
                       GetSQLValueString($_POST['SexoHij3'], "text"),
                       GetSQLValueString($_POST['SexoHij4'], "text"),
                       GetSQLValueString($_POST['SexoHij5'], "text"),
                       GetSQLValueString($_POST['Titulo1'], "text"),
                       GetSQLValueString($_POST['Titulo2'], "text"),
                       GetSQLValueString($_POST['Titulo3'], "text"),
                       GetSQLValueString($_POST['Titulo4'], "text"),
                       GetSQLValueString($_POST['Titulo5'], "text"),
                       GetSQLValueString($_POST['Titulo6'], "text"),
                       GetSQLValueString($_POST['Titulo7'], "text"),
                       GetSQLValueString($_POST['NivelT1'], "text"),
                       GetSQLValueString($_POST['NivelT2'], "text"),
                       GetSQLValueString($_POST['NivelT3'], "text"),
                       GetSQLValueString($_POST['NivelT4'], "text"),
                       GetSQLValueString($_POST['NivelT5'], "text"),
                       GetSQLValueString($_POST['NivelT6'], "text"),
                       GetSQLValueString($_POST['NivelT7'], "text"),
                       GetSQLValueString($_POST['Instit1'], "text"),
                       GetSQLValueString($_POST['Instit2'], "text"),
                       GetSQLValueString($_POST['Instit3'], "text"),
                       GetSQLValueString($_POST['Instit4'], "text"),
                       GetSQLValueString($_POST['Instit5'], "text"),
                       GetSQLValueString($_POST['Instit6'], "text"),
                       GetSQLValueString($_POST['Instit7'], "text"),
                       GetSQLValueString($_POST['CiudaT1'], "text"),
                       GetSQLValueString($_POST['CiudaT2'], "text"),
                       GetSQLValueString($_POST['CiudaT3'], "text"),
                       GetSQLValueString($_POST['CiudaT4'], "text"),
                       GetSQLValueString($_POST['CiudaT5'], "text"),
                       GetSQLValueString($_POST['CiudaT6'], "text"),
                       GetSQLValueString($_POST['CiudaT7'], "text"),
                       GetSQLValueString($_POST['FechaT1'], "date"),
                       GetSQLValueString($_POST['FechaT2'], "date"),
                       GetSQLValueString($_POST['FechaT3'], "date"),
                       GetSQLValueString($_POST['FechaT4'], "date"),
                       GetSQLValueString($_POST['FechaT5'], "date"),
                       GetSQLValueString($_POST['FechaT6'], "date"),
                       GetSQLValueString($_POST['FechaT7'], "date"),
                       GetSQLValueString($_POST['EstudAct'], "text"),
                       GetSQLValueString($_POST['Program1'], "text"),
                       GetSQLValueString($_POST['Program2'], "text"),
                       GetSQLValueString($_POST['Program3'], "text"),
                       GetSQLValueString($_POST['Program4'], "text"),
                       GetSQLValueString($_POST['Program5'], "text"),
                       GetSQLValueString($_POST['Semestr1'], "int"),
                       GetSQLValueString($_POST['Semestr2'], "int"),
                       GetSQLValueString($_POST['Semestr3'], "int"),
                       GetSQLValueString($_POST['Semestr4'], "int"),
                       GetSQLValueString($_POST['Semestr5'], "int"),
                       GetSQLValueString($_POST['InstAct1'], "text"),
                       GetSQLValueString($_POST['InstAct2'], "text"),
                       GetSQLValueString($_POST['InstAct3'], "text"),
                       GetSQLValueString($_POST['InstAct4'], "text"),
                       GetSQLValueString($_POST['InstAct5'], "text"),
                       GetSQLValueString($_POST['Horario1'], "text"),
                       GetSQLValueString($_POST['Horario2'], "text"),
                       GetSQLValueString($_POST['Horario3'], "text"),
                       GetSQLValueString($_POST['Horario4'], "text"),
                       GetSQLValueString($_POST['Horario5'], "text"),
                       GetSQLValueString($_POST['PrVirDi1'], "text"),
                       GetSQLValueString($_POST['PrVirDi2'], "text"),
                       GetSQLValueString($_POST['PrVirDi3'], "text"),
                       GetSQLValueString($_POST['PrVirDi4'], "text"),
                       GetSQLValueString($_POST['PrVirDi5'], "text"),
                       GetSQLValueString($_POST['Software1'], "text"),
                       GetSQLValueString($_POST['Software2'], "text"),
                       GetSQLValueString($_POST['Software3'], "text"),
                       GetSQLValueString($_POST['Software4'], "text"),
                       GetSQLValueString($_POST['Software5'], "text"),
                       GetSQLValueString($_POST['Idioma1'], "text"),
                       GetSQLValueString($_POST['Idioma2'], "text"),
                       GetSQLValueString($_POST['Idioma3'], "text"),
                       GetSQLValueString($_POST['Idioma4'], "text"),
                       GetSQLValueString($_POST['Idioma5'], "text"),
                       GetSQLValueString($_POST['Entidad1'], "text"),
                       GetSQLValueString($_POST['Entidad2'], "text"),
                       GetSQLValueString($_POST['Entidad3'], "text"),
                       GetSQLValueString($_POST['Entidad4'], "text"),
                       GetSQLValueString($_POST['Entidad5'], "text"),
                       GetSQLValueString($_POST['Entidad6'], "text"),
                       GetSQLValueString($_POST['Entidad7'], "text"),
                       GetSQLValueString($_POST['CargoOc1'], "text"),
                       GetSQLValueString($_POST['CargoOc2'], "text"),
                       GetSQLValueString($_POST['CargoOc3'], "text"),
                       GetSQLValueString($_POST['CargoOc4'], "text"),
                       GetSQLValueString($_POST['CargoOc5'], "text"),
                       GetSQLValueString($_POST['CargoOc6'], "text"),
                       GetSQLValueString($_POST['CargoOc7'], "text"),
                       GetSQLValueString($_POST['TelEnti1'], "text"),
                       GetSQLValueString($_POST['TelEnti2'], "text"),
                       GetSQLValueString($_POST['TelEnti3'], "text"),
                       GetSQLValueString($_POST['TelEnti4'], "text"),
                       GetSQLValueString($_POST['TelEnti5'], "text"),
                       GetSQLValueString($_POST['TelEnti6'], "text"),
                       GetSQLValueString($_POST['TelEnti7'], "text"),
                       GetSQLValueString($_POST['DirEnti1'], "text"),
                       GetSQLValueString($_POST['DirEnti2'], "text"),
                       GetSQLValueString($_POST['DirEnti3'], "text"),
                       GetSQLValueString($_POST['DirEnti4'], "text"),
                       GetSQLValueString($_POST['DirEnti5'], "text"),
                       GetSQLValueString($_POST['DirEnti6'], "text"),
                       GetSQLValueString($_POST['DirEnti7'], "text"),
                       GetSQLValueString($_POST['JefeInm1'], "text"),
                       GetSQLValueString($_POST['JefeInm2'], "text"),
                       GetSQLValueString($_POST['JefeInm3'], "text"),
                       GetSQLValueString($_POST['JefeInm4'], "text"),
                       GetSQLValueString($_POST['JefeInm5'], "text"),
                       GetSQLValueString($_POST['JefeInm6'], "text"),
                       GetSQLValueString($_POST['JefeInm7'], "text"),
                       GetSQLValueString($_POST['MotiRet1'], "text"),
                       GetSQLValueString($_POST['MotiRet2'], "text"),
                       GetSQLValueString($_POST['MotiRet3'], "text"),
                       GetSQLValueString($_POST['MotiRet4'], "text"),
                       GetSQLValueString($_POST['MotiRet5'], "text"),
                       GetSQLValueString($_POST['MotiRet6'], "text"),
                       GetSQLValueString($_POST['MotiRet7'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

mysql_select_db($database_conexion, $conexion);
$query_Facultades = "SELECT * FROM tfacultad";
$Facultades = mysql_query($query_Facultades, $conexion) or die(mysql_error());
$row_Facultades = mysql_fetch_assoc($Facultades);
$totalRows_Facultades = mysql_num_rows($Facultades);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
	font-family: Tahoma;
}
.Estilo2 {font-family: Tahoma}
.Estilo4 {
	color: #596221;
	font-weight: bold;
}
.Estilo7 {font-size: 10px}
.Estilo9 {
	font-family: Tahoma;
	color: #FF0000;
	font-weight: bold;
}
.Estilo10 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="850" border="1">
  <tr>
    <td width="152" bgcolor="#98BD0D"><div align="center"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="A" width="141" height="61" /></div></td>
    <td width="682" bgcolor="#98BD0D"><p align="center" class="Estilo1">HOJA DE VIDA ASPIRANTES </p>
        <p align="center" class="Estilo1">CARGO DOCENTE O ADMINISTRATIVO </p></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFB112" class="Estilo4"><div align="center" class="Estilo2">DEPARTAMENTO DE TALENTO HUMANO - <span class="Estilo10">CONSTRUYENDO UN MEJOR EQUIPO </span></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="850" border="0">
  <tr>
    <td><div align="center" class="Estilo9">
      <p>Por favor NO oprima ENTER  en ning&uacute;n momento. <br />
        Si llegara a hacerlo, perder&aacute; la oportunidad de ingresar  su hoja de vida. <br />
        Utilice la tecla de Tabulaci&oacute;n para pasar al siguiente campo. <br />
      Cuando ingrese todos los datos, oprima el bot&oacute;n &quot;Enviar Hoja de Vida&quot;. </p>
      </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" class="Estilo2">
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="3"><div align="center" class="Estilo4">Si su inter&eacute;s es postularse a un cargo  de docente o administrativo <br />
        por favor ingrese la informaci&oacute;n que se solicita a  continuaci&oacute;n</div></td>
    </tr>
    <tr>
      <td width="199">&nbsp;</td>
      <td width="328">&nbsp;</td>
      <td width="309">&nbsp;</td>
    </tr>
    <tr>
      <td height="50"><span class="Estilo4">C&eacute;dula</span><br />
        <input type="text" name="CCHojaVi" value="" size="26" /></td>
      <td><strong class="Estilo4">Nombres</strong><br />
        <input type="text" name="Nombres" value="" size="50" /></td>
      <td><strong class="Estilo4">Apellidos</strong><br />
        <input type="text" name="Apellidos" value="" size="50" /></td>
    </tr>
    <tr>
      <td height="50">&nbsp;</td>
      <td><span class="Estilo4">Fecha de ingreso (aaaa-mm-dd) </span><br />
      <input type="text" name="FechIngr" value="" size="50" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="2"><div align="center" class="Estilo4"><strong>CARGO SOLICITADO </strong></div></td>
    </tr>
    <tr>
      <td width="408"><strong class="Estilo4">En el &Aacute;rea Administrativa </strong></td>
      <td width="432">&nbsp;</td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="center"><strong>Area</strong></div></td>
      <td class="Estilo4"><div align="center"><strong>Cargo</strong></div></td>
    </tr>
    <tr>
      <td><input type="text" name="AreaAd1" value="" size="68" /></td>
      <td><input type="text" name="CargoAd1" value="" size="68" /></td>
    </tr>
    <tr>
      <td><input type="text" name="AreaAd2" value="" size="68" /></td>
      <td><input type="text" name="CargoAd2" value="" size="68" /></td>
    </tr>
    <tr>
      <td><input type="text" name="AreaAd3" value="" size="68" /></td>
      <td><input type="text" name="CargoAd3" value="" size="68" /></td>
    </tr>
    <tr>
      <td><input type="text" name="AreaAd4" value="" size="68" /></td>
      <td><input type="text" name="CargoAd4" value="" size="68" /></td>
    </tr>
    <tr>
      <td><input type="text" name="AreaAd5" value="" size="68" /></td>
      <td><input type="text" name="CargoAd5" value="" size="68" /></td>
    </tr>
  </table>
  <p>
    <label></label></p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td width="231" class="Estilo4"><strong>En el &Aacute;rea Docente </strong></td>
      <td width="609" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="center"><strong>Facultad</strong></div></td>
      <td class="Estilo4"><div align="center"><strong>Asignatura</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">
          <select name="Facult1" id="Facult1">
            <option value="No lo ha definido">Seleccione la facultad</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Facultades['Facultad']?>"><?php echo $row_Facultades['Facultad']?></option>
            <?php
} while ($row_Facultades = mysql_fetch_assoc($Facultades));
  $rows = mysql_num_rows($Facultades);
  if($rows > 0) {
      mysql_data_seek($Facultades, 0);
	  $row_Facultades = mysql_fetch_assoc($Facultades);
  }
?>
          </select>
      </div></td>
      <td><input type="text" name="Asignat1" value="" size="100" /></td>
    </tr>
    <tr>
      <td><div align="center">
          <select name="Facult2" id="Facult2">
            <option value="No lo ha definido">Seleccione la facultad</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Facultades['Facultad']?>"><?php echo $row_Facultades['Facultad']?></option>
            <?php
} while ($row_Facultades = mysql_fetch_assoc($Facultades));
  $rows = mysql_num_rows($Facultades);
  if($rows > 0) {
      mysql_data_seek($Facultades, 0);
	  $row_Facultades = mysql_fetch_assoc($Facultades);
  }
?>
          </select>
      </div></td>
      <td><input type="text" name="Asignat2" value="" size="100" /></td>
    </tr>
    <tr>
      <td><div align="center">
          <select name="Facult3" id="Facult3">
            <option value="No lo ha definido">Seleccione la facultad</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Facultades['Facultad']?>"><?php echo $row_Facultades['Facultad']?></option>
            <?php
} while ($row_Facultades = mysql_fetch_assoc($Facultades));
  $rows = mysql_num_rows($Facultades);
  if($rows > 0) {
      mysql_data_seek($Facultades, 0);
	  $row_Facultades = mysql_fetch_assoc($Facultades);
  }
?>
          </select>
      </div></td>
      <td><input type="text" name="Asignat3" value="" size="100" /></td>
    </tr>
    <tr>
      <td><div align="center">
          <select name="Facult4" id="Facult4">
            <option value="No lo ha definido">Seleccione la facultad</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Facultades['Facultad']?>"><?php echo $row_Facultades['Facultad']?></option>
            <?php
} while ($row_Facultades = mysql_fetch_assoc($Facultades));
  $rows = mysql_num_rows($Facultades);
  if($rows > 0) {
      mysql_data_seek($Facultades, 0);
	  $row_Facultades = mysql_fetch_assoc($Facultades);
  }
?>
          </select>
      </div></td>
      <td><input type="text" name="Asignat4" value="" size="100" /></td>
    </tr>
    <tr>
      <td><div align="center">
          <select name="Facult5" id="Facult5">
            <option value="No lo ha definido">Seleccione la facultad</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Facultades['Facultad']?>"><?php echo $row_Facultades['Facultad']?></option>
            <?php
} while ($row_Facultades = mysql_fetch_assoc($Facultades));
  $rows = mysql_num_rows($Facultades);
  if($rows > 0) {
      mysql_data_seek($Facultades, 0);
	  $row_Facultades = mysql_fetch_assoc($Facultades);
  }
?>
          </select>
      </div></td>
      <td><input type="text" name="Asignat5" value="" size="100" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="4"><div align="center" class="Estilo4">DATOS PERSONALES </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="202"><span class="Estilo4">Nacionalidad
      </span>
      <input type="text" name="Nacional" value="" size="32" /></td>
      <td width="204"><div align="center"><span class="Estilo4"> Sexo
      </span></div>
        <label>
      <div align="center">
        <select name="Sexo">
          <option value="No lo ha definido">Seleccione el sexo</option>
          <option value="Femenino">Femenino</option>
          <option value="Masculino">Masculino</option>
        </select>
      </div>
      </label></td>
      <td width="209"><span class="Estilo4">Estado civil
      </span>
        <label> <br />
        <select name="EstCivil" id="EstCivil">
          <option value="No lo ha definido">Seleccione el estado civil </option>
        <option value="Soltera(o)">Soltera(o)</option>
        <option value="Casada(o)">Casada(o)</option>
        <option value="Union libre">Union libre</option>
        <option value="Viuda(o)">Viuda(o)</option>
        </select>
      </label></td>
      <td width="217"><span class="Estilo4">Edad
      (a&ntilde;os)
        </span>
        <input type="text" name="Edad" value="" size="32" /></td>
    </tr>
    <tr>
      <td><p align="left"><span class="Estilo4">Fecha de nacimiento</span><br />
          <input type="text" name="FechaNac" value="" size="32" />
      </p>      </td>
      <td><span class="Estilo4">Lugar de nacimiento </span>
        <input type="text" name="LugarNac" value="" size="32" /></td>
      <td><span class="Estilo4">Grupo sangu&iacute;neo
          <input type="text" name="GrupoSan" value="" size="32" />
      </span></td>
      <td><span class="Estilo4">Pasaporte No. </span>
        <input type="text" name="Pasaport" value="" size="32" /></td>
    </tr>
    <tr>
      <td><span class="Estilo4">Libreta militar No</span>.<br />
      <input type="text" name="LibrMili" value="" size="32" /></td>
      <td><span class="Estilo4">Distrito<br />
      </span>
        <input type="text" name="Distrito" value="" size="32" />
      <br /></td>
      <td><span class="Estilo4">Clase</span><br />
        <input type="text" name="Clase" value="" size="32" /></td>
      <td><span class="Estilo4">Fecha de expedici&oacute;n</span>
        
      <input type="text" name="FechaExp" value="" size="32" /></td>
    </tr>
    <tr>
      <td colspan="2"><span class="Estilo4">Profesi&oacute;n </span> <br />
        <input type="text" name="Profesion" value="" size="69" /></td>
      <td><span class="Estilo4">Matr&iacute;cula profesional No.</span><br />
        <input type="text" name="MatrProf" value="" size="32" /></td>
      <td><span class="Estilo4">De (departamento) </span><br />
      <input type="text" name="MatrDe" value="" size="32" /></td>
    </tr>
    <tr>
      <td colspan="2"><span class="Estilo4">Fondo de pensiones<br />
          <input type="text" name="FondPens" value="" size="69" />
      </span></td>
      <td colspan="2"><span class="Estilo4">EPS<br />
        <input type="text" name="EPS" value="" size="69" />
      </span></td>
    </tr>
    <tr>
      <td colspan="2" class="Estilo4">Direcci&oacute;n<br />
      <input type="text" name="Direccion" value="" size="69" /></td>
      <td class="Estilo4">Barrio<br />
      <input type="text" name="Barrio" value="" size="32" /></td>
      <td class="Estilo4">Tel&eacute;fono<br />
      <input type="text" name="Telefono" value="" size="32" /></td>
    </tr>
    <tr>
      <td class="Estilo4">Celular<br />
      <input type="text" name="Celular" value="" size="32" /></td>
      <td colspan="3" class="Estilo4"><div align="left">Email<br />
          <input type="text" name="Email" value="" size="106" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2" class="Estilo4"><strong>En caso de emergencia  avisar a <br />
      </strong>
        <input type="text" name="AvisarA" value="" size="69" /></td>
      <td colspan="2" class="Estilo4">Tel&eacute;fono de esta persona<br />
      <input type="text" name="TelAvis" value="" size="69" /></td>
    </tr>
    <tr>
      <td colspan="4" class="Estilo4"><strong>Nombre de padres  actualmente vivos</strong><br />
      <input type="text" name="PadresVi" value="" size="143" /></td>
    </tr>
    <tr>
      <td colspan="2" class="Estilo4"><strong>Nombre del Conyugue</strong><br />
      <input type="text" name="Conyuge" value="" size="69" /></td>
      <td class="Estilo4">Ocupaci&oacute;n<br />
      <input type="text" name="OcupCony" value="" size="32" /></td>
      <td class="Estilo4">No. de hijos<br />
      <input type="text" name="NoHijos" value="" size="32" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="5"><div align="center" class="Estilo4">Informaci&oacute;n de los hijos </div></td>
    </tr>
    <tr>
      <td class="Estilo4">&nbsp;</td>
      <td class="Estilo4">&nbsp;</td>
      <td class="Estilo4">&nbsp;</td>
      <td class="Estilo4">&nbsp;</td>
      <td class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td width="232" class="Estilo4"><div align="center"><strong>Nombre y Apellidos</strong></div></td>
      <td width="163" class="Estilo4"><div align="center"><strong>Fecha nacimiento</strong></div></td>
      <td width="153" class="Estilo4"><div align="center"><strong>Identificaci&oacute;n</strong></div></td>
      <td width="166" class="Estilo4"><div align="center"><strong>Edad <span class="Estilo7"><br />
      (N&uacute;mero/a&ntilde;os o meses)</span> </strong></div></td>
      <td width="114" class="Estilo4"><div align="center"><strong>Sexo</strong></div></td>
    </tr>
    <tr>
      <td><input type="text" name="NombHij1" value="" size="38" /></td>
      <td><div align="center">
        <input type="text" name="FeNaHij1" value="" size="25" />
      </div></td>
      <td><div align="center">
        <input type="text" name="IdenHij1" value="" size="23" />
      </div></td>
      <td><div align="center">
        <input type="text" name="EdadHij1" value="" size="4" />
        <select name="UnEdHij1" id="select5">
          <option value="No lo ha definido">Seleccione</option>
          <option value="A&ntilde;os">A&ntilde;os</option>
          <option value="Meses">Meses</option>
        </select>
      </div></td>
      <td>
        
        <div align="center">
            <select name="SexoHij1" id="SexoHij1">
              <option value="No lo ha definido">Seleccione</option>
              <option value="Femenino">Femenino</option>
              <option value="Masculino">Masculino</option>
            </select>
        </div></td>
    </tr>
    <tr>
      <td><input type="text" name="NombHij2" value="" size="38" /></td>
      <td><div align="center">
        <input type="text" name="FeNaHij2" value="" size="25" />
      </div></td>
      <td><div align="center">
        <input type="text" name="IdenHij2" value="" size="23" />
      </div></td>
      <td><div align="center">
        <input type="text" name="EdadHij2" value="" size="4" />
        <select name="UnEdHij2" id="select6">
          <option value="No lo ha definido">Seleccione</option>
          <option value="A&ntilde;os">A&ntilde;os</option>
          <option value="Meses">Meses</option>
        </select>
      </div></td>
      <td>
        
          <div align="center">
              <select name="SexoHij2" id="select">
                <option value="No lo ha definido">Seleccione</option>
                <option value="Femenino">Femenino</option>
                <option value="Masculino">Masculino</option>
              </select>
        </div></td>
    </tr>
    <tr>
      <td><input type="text" name="NombHij3" value="" size="38" /></td>
      <td><div align="center">
        <input type="text" name="FeNaHij3" value="" size="25" />
      </div></td>
      <td><div align="center">
        <input type="text" name="IdenHij3" value="" size="23" />
      </div></td>
      <td><div align="center">
        <input type="text" name="EdadHij3" value="" size="4" />
        <select name="UnEdHij3" id="select7">
          <option value="No lo ha definido">Seleccione</option>
          <option value="A&ntilde;os">A&ntilde;os</option>
          <option value="Meses">Meses</option>
        </select>
      </div></td>
      <td>
        
        <div align="center">
            <select name="SexoHij3" id="select2">
              <option value="No lo ha definido">Seleccione</option>
              <option value="Femenino">Femenino</option>
              <option value="Masculino">Masculino</option>
            </select>
        </div></td>
    </tr>
    <tr>
      <td><input type="text" name="NombHij4" value="" size="38" /></td>
      <td><div align="center">
        <input type="text" name="FeNaHij4" value="" size="25" />
      </div></td>
      <td><div align="center">
        <input type="text" name="IdenHij4" value="" size="23" />
      </div></td>
      <td><div align="center">
        <input type="text" name="EdadHij4" value="" size="4" />
        <select name="UnEdHij4" id="select8">
          <option value="No lo ha definido">Seleccione</option>
          <option value="A&ntilde;os">A&ntilde;os</option>
          <option value="Meses">Meses</option>
        </select>
      </div></td>
      <td>
        
        <div align="center">
            <select name="SexoHij4" id="select3">
              <option value="No lo ha definido">Seleccione</option>
              <option value="Femenino">Femenino</option>
              <option value="Masculino">Masculino</option>
            </select>
        </div></td>
    </tr>
    <tr>
      <td><input type="text" name="NombHij5" value="" size="38" /></td>
      <td><div align="center">
        <input type="text" name="FeNaHij5" value="" size="25" />
      </div></td>
      <td><div align="center">
        <input type="text" name="IdenHij5" value="" size="23" />
      </div></td>
      <td><div align="center">
        <input type="text" name="EdadHij5" value="" size="4" />
        <select name="UnEdHij5" id="select9">
          <option value="No lo ha definido">Seleccione</option>
          <option value="A&ntilde;os">A&ntilde;os</option>
          <option value="Meses">Meses</option>
        </select>
      </div></td>
      <td>
        
        <div align="center">
            <select name="SexoHij5" id="select4">
              <option value="No lo ha definido">Seleccione</option>
              <option value="Femenino">Femenino</option>
              <option value="Masculino">Masculino</option>
            </select>
        </div></td>
    </tr>
  </table>
  <p>
    <label></label>
    <label></label>
  </p>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="5"><div align="center" class="Estilo4">ESTUDIOS REALIZADOS </div></td>
    </tr>
    
    <tr>
      <td width="252" class="Estilo4"><div align="center">T&iacute;tulo obtenido </div></td>
      <td width="133" class="Estilo4"><div align="center">Nivel</div></td>
      <td width="223" class="Estilo4"><div align="center">Instituci&oacute;n</div></td>
      <td width="116" class="Estilo4"><div align="center">Ciudad</div></td>
      <td width="104" class="Estilo4"><div align="center">Fecha de terminaci&oacute;n </div></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo1" value="" size="35" /></td>
      <td><label>
      <select name="NivelT1" id="NivelT1">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Bachillerato">Bachillerato</option>
        <option value="Tecnico">Tecnico</option>
        <option value="Tecnologo">Tecnologo</option>
        <option value="Profesional">Profesional</option>
        <option value="Especialista">Especialista</option>
        <option value="Maestria">Maestria</option>
        <option value="Doctorado">Doctorado</option>
      </select>
      </label></td>
      <td><input type="text" name="Instit1" value="" size="32" /></td>
      <td><input type="text" name="CiudaT1" value="" size="20" /></td>
      <td><input type="text" name="FechaT1" value="" size="20" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo2" value="" size="35" /></td>
      <td><select name="NivelT2" id="NivelT2">
          <option value="No lo ha definido">Seleccione</option>
          <option value="Bachillerato">Bachillerato</option>
          <option value="Tecnico">Tecnico</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
      </select></td>
      <td><input type="text" name="Instit2" value="" size="32" /></td>
      <td><input type="text" name="CiudaT2" value="" size="20" /></td>
      <td><input type="text" name="FechaT2" value="" size="20" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo3" value="" size="35" /></td>
      <td><select name="NivelT3" id="NivelT3">
          <option value="No lo ha definido">Seleccione</option>
          <option value="Bachillerato">Bachillerato</option>
          <option value="Tecnico">Tecnico</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
      </select></td>
      <td><input type="text" name="Instit3" value="" size="32" /></td>
      <td><input type="text" name="CiudaT3" value="" size="20" /></td>
      <td><input type="text" name="FechaT3" value="" size="20" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo4" value="" size="35" /></td>
      <td><select name="NivelT4" id="NivelT4">
          <option value="No lo ha definido">Seleccione</option>
          <option value="Bachillerato">Bachillerato</option>
          <option value="Tecnico">Tecnico</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
      </select></td>
      <td><input type="text" name="Instit4" value="" size="32" /></td>
      <td><input type="text" name="CiudaT4" value="" size="20" /></td>
      <td><input type="text" name="FechaT4" value="" size="20" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo5" value="" size="35" /></td>
      <td><select name="NivelT5" id="NivelT5">
          <option value="No lo ha definido">Seleccione</option>
          <option value="Bachillerato">Bachillerato</option>
          <option value="Tecnico">Tecnico</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
      </select></td>
      <td><input type="text" name="Instit5" value="" size="32" /></td>
      <td><input type="text" name="CiudaT5" value="" size="20" /></td>
      <td><input type="text" name="FechaT5" value="" size="20" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo6" value="" size="35" /></td>
      <td><select name="NivelT6" id="NivelT6">
          <option value="No lo ha definido">Seleccione</option>
          <option value="Bachillerato">Bachillerato</option>
          <option value="Tecnico">Tecnico</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
      </select></td>
      <td><input type="text" name="Instit6" value="" size="32" /></td>
      <td><input type="text" name="CiudaT6" value="" size="20" /></td>
      <td><input type="text" name="FechaT6" value="" size="20" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Titulo7" value="" size="35" /></td>
      <td><select name="NivelT7" id="NivelT7">
          <option value="No lo ha definido">Seleccione</option>
          <option value="Bachillerato">Bachillerato</option>
          <option value="Tecnico">Tecnico</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
      </select></td>
      <td><input type="text" name="Instit7" value="" size="32" /></td>
      <td><input type="text" name="CiudaT7" value="" size="20" /></td>
      <td><input type="text" name="FechaT7" value="" size="20" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="5"><div align="center"><span class="Estilo4">Estudia actualmente</span></div>
        <label> 
        <div align="center"><span class="Estilo4">Si</span>
          <input name="EstudAct" type="radio" value="Si" />
            <span class="Estilo4">No</span>
          <input name="EstudAct" type="radio" value="No" />
        </div>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="center">Programa</div></td>
      <td class="Estilo4"><div align="center">Semestre</div></td>
      <td class="Estilo4"><div align="center">Instituci&oacute;n</div></td>
      <td class="Estilo4"><div align="center">Horario</div></td>
      <td class="Estilo4"><div align="center">Tipo</div></td>
    </tr>
    <tr>
      <td><input type="text" name="Program1" value="" size="42" /></td>
      <td><select name="Semestr1" id="Semestr1">
        <option value="No lo ha definido">Seleccione</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
      </select></td>
      <td><input type="text" name="InstAct1" value="" size="38" /></td>
      <td><select name="Horario1" id="Horario1">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Diurno">Diurno</option>
        <option value="Nocturno">Nocturno</option>
        <option value="No aplica">No aplica</option>
      </select></td>
      <td><select name="PrVirDi1" id="PrVirDi1">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Presencial">Presencial</option>
        <option value="A Distancia">A Distancia</option>
        <option value="Virtual">Virtual</option>
      </select></td>
    </tr>
    <tr>
      <td><input type="text" name="Program2" value="" size="42" /></td>
      <td><select name="Semestr2" id="select10">
        <option value="No lo ha definido">Seleccione</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
      </select></td>
      <td><input type="text" name="InstAct2" value="" size="38" /></td>
      <td><select name="Horario2" id="Horario2">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Diurno">Diurno</option>
        <option value="Nocturno">Nocturno</option>
        <option value="No aplica">No aplica</option>
      </select></td>
      <td><select name="PrVirDi2" id="PrVirDi2">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Presencial">Presencial</option>
        <option value="A Distancia">A Distancia</option>
        <option value="Virtual">Virtual</option>
      </select></td>
    </tr>
    <tr>
      <td><input type="text" name="Program3" value="" size="42" /></td>
      <td><select name="Semestr3" id="select11">
        <option value="No lo ha definido">Seleccione</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
      </select></td>
      <td><input type="text" name="InstAct3" value="" size="38" /></td>
      <td><select name="Horario3" id="Horario3">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Diurno">Diurno</option>
        <option value="Nocturno">Nocturno</option>
        <option value="No aplica">No aplica</option>
      </select></td>
      <td><select name="PrVirDi3" id="PrVirDi3">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Presencial">Presencial</option>
        <option value="A Distancia">A Distancia</option>
        <option value="Virtual">Virtual</option>
      </select></td>
    </tr>
    <tr>
      <td><input type="text" name="Program4" value="" size="42" /></td>
      <td><select name="Semestr4" id="select12">
        <option value="No lo ha definido">Seleccione</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
      </select></td>
      <td><input type="text" name="InstAct4" value="" size="38" /></td>
      <td><select name="Horario4" id="Horario4">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Diurno">Diurno</option>
        <option value="Nocturno">Nocturno</option>
        <option value="No aplica">No aplica</option>
      </select></td>
      <td><select name="PrVirDi4" id="PrVirDi4">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Presencial">Presencial</option>
        <option value="A Distancia">A Distancia</option>
        <option value="Virtual">Virtual</option>
      </select></td>
    </tr>
    <tr>
      <td><input type="text" name="Program5" value="" size="42" /></td>
      <td><select name="Semestr5" id="select13">
        <option value="No lo ha definido">Seleccione</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
      </select></td>
      <td><input type="text" name="InstAct5" value="" size="38" /></td>
      <td><select name="Horario5" id="select14">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Diurno">Diurno</option>
        <option value="Nocturno">Nocturno</option>
        <option value="No aplica">No aplica</option>
      </select></td>
      <td><select name="PrVirDi5" id="PrVirDi5">
        <option value="No lo ha definido">Seleccione</option>
        <option value="Presencial">Presencial</option>
        <option value="A Distancia">A Distancia</option>
        <option value="Virtual">Virtual</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td class="Estilo4"><div align="center"><strong>QU&Eacute; SOFTWARE O PROGRAMAS DE  COMPUTACI&Oacute;N MANEJA</strong></div></td>
      <td class="Estilo4">&nbsp;</td>
      <td class="Estilo4"><div align="center"><strong>QU&Eacute; IDIOMAS EXTRANJEROS  DOMINA&nbsp; </strong></div></td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="text" name="Software1" value="" size="50" />
      </div></td>
      <td>&nbsp;</td>
      <td><div align="center">
        <input type="text" name="Idioma1" value="" size="32" />
      </div></td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="text" name="Software2" value="" size="50" />
      </div></td>
      <td>&nbsp;</td>
      <td><div align="center">
        <input type="text" name="Idioma2" value="" size="32" />
      </div></td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="text" name="Software3" value="" size="50" />
      </div></td>
      <td>&nbsp;</td>
      <td><div align="center">
        <input type="text" name="Idioma3" value="" size="32" />
      </div></td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="text" name="Software4" value="" size="50" />
      </div></td>
      <td>&nbsp;</td>
      <td><div align="center">
        <input name="Idioma4" type="text" id="Idioma4" value="" size="32" />
      </div></td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="text" name="Software5" value="" size="50" />
      </div></td>
      <td>&nbsp;</td>
      <td><div align="center">
        <input name="Idioma5" type="text" id="Idioma5" value="" size="32" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td colspan="6"><p align="center" class="Estilo4"><strong>EXPERIENCIA  LABORAL</strong></p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="center">Entidad</div></td>
      <td class="Estilo4"><div align="center">Cargo</div></td>
      <td class="Estilo4"><div align="center">Tel&eacute;fono</div></td>
      <td class="Estilo4"><div align="center">Direcci&oacute;n</div></td>
      <td class="Estilo4"><div align="center">Jefe inmediato </div></td>
      <td class="Estilo4"><div align="center">Motivo de retiro </div></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad1" value="" size="32" /></td>
      <td><input type="text" name="CargoOc1" value="" size="32" /></td>
      <td><input type="text" name="TelEnti1" value="" size="20" /></td>
      <td><input type="text" name="DirEnti1" value="" size="32" /></td>
      <td><input type="text" name="JefeInm1" value="" size="28" /></td>
      <td><input type="text" name="MotiRet1" value="" size="32" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad2" value="" size="32" /></td>
      <td><input type="text" name="CargoOc2" value="" size="32" /></td>
      <td><input type="text" name="TelEnti2" value="" size="20" /></td>
      <td><input type="text" name="DirEnti2" value="" size="32" /></td>
      <td><input type="text" name="JefeInm2" value="" size="28" /></td>
      <td><input type="text" name="MotiRet2" value="" size="32" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad3" value="" size="32" /></td>
      <td><input type="text" name="CargoOc3" value="" size="32" /></td>
      <td><input type="text" name="TelEnti3" value="" size="20" /></td>
      <td><input type="text" name="DirEnti3" value="" size="32" /></td>
      <td><input type="text" name="JefeInm3" value="" size="28" /></td>
      <td><input type="text" name="MotiRet3" value="" size="32" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad4" value="" size="32" /></td>
      <td><input type="text" name="CargoOc4" value="" size="32" /></td>
      <td><input type="text" name="TelEnti4" value="" size="20" /></td>
      <td><input type="text" name="DirEnti4" value="" size="32" /></td>
      <td><input type="text" name="JefeInm4" value="" size="28" /></td>
      <td><input type="text" name="MotiRet4" value="" size="32" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad5" value="" size="32" /></td>
      <td><input type="text" name="CargoOc5" value="" size="32" /></td>
      <td><input type="text" name="TelEnti5" value="" size="20" /></td>
      <td><input type="text" name="DirEnti5" value="" size="32" /></td>
      <td><input type="text" name="JefeInm5" value="" size="28" /></td>
      <td><input type="text" name="MotiRet5" value="" size="32" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad6" value="" size="32" /></td>
      <td><input type="text" name="CargoOc6" value="" size="32" /></td>
      <td><input type="text" name="TelEnti6" value="" size="20" /></td>
      <td><input type="text" name="DirEnti6" value="" size="32" /></td>
      <td><input type="text" name="JefeInm6" value="" size="28" /></td>
      <td><input type="text" name="MotiRet6" value="" size="32" /></td>
    </tr>
    <tr>
      <td><input type="text" name="Entidad7" value="" size="32" /></td>
      <td><input type="text" name="CargoOc7" value="" size="32" /></td>
      <td><input type="text" name="TelEnti7" value="" size="20" /></td>
      <td><input type="text" name="DirEnti7" value="" size="32" /></td>
      <td><input type="text" name="JefeInm7" value="" size="28" /></td>
      <td><input type="text" name="MotiRet7" value="" size="32" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Enviar Hoja de Vida"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p class="Estilo2">&nbsp;</p>
<p class="Estilo2">&nbsp;</p>
<p class="Estilo2">&nbsp;</p>
<p class="Estilo2">&nbsp;</p>
<p class="Estilo2">&nbsp;</p>
<p class="Estilo2">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Facultades);
?>
