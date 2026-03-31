<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_HojasVida = "SELECT * FROM thvsolicit ORDER BY Nombres ASC";
$HojasVida = mysql_query($query_HojasVida, $conexion) or die(mysql_error());
$row_HojasVida = mysql_fetch_assoc($HojasVida);
$totalRows_HojasVida = mysql_num_rows($HojasVida);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo24 {color: #FFFFFF}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4 Estilo24"><span class="Estilo24">CONSULTA</span> <span class="Estilo24">DE HOJAS DE VIDA CANDIDATOS </span> </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONFORMANDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>

<table border="1" bgcolor="#FFFFCC">
  <tr>
    <td>CCHojaVi</td>
    <td>Nombres</td>
    <td>Apellidos</td>
    <td>FechIngr</td>
    <td>AreaAd1</td>
    <td>AreaAd2</td>
    <td>AreaAd3</td>
    <td>AreaAd4</td>
    <td>AreaAd5</td>
    <td>Facult1</td>
    <td>Facult2</td>
    <td>Facult3</td>
    <td>Facult4</td>
    <td>Facult5</td>
    <td>CargoAd1</td>
    <td>CargoAd2</td>
    <td>CargoAd3</td>
    <td>CargoAd4</td>
    <td>CargoAd5</td>
    <td>Asignat1</td>
    <td>Asignat2</td>
    <td>Asignat3</td>
    <td>Asignat4</td>
    <td>Asignat5</td>
    <td>Sexo</td>
    <td>EstCivil</td>
    <td>Edad</td>
    <td>Nacional</td>
    <td>FechaNac</td>
    <td>LugarNac</td>
    <td>LibrMili</td>
    <td>Distrito</td>
    <td>Clase</td>
    <td>FechaExp</td>
    <td>Pasaport</td>
    <td>Profesion</td>
    <td>MatrProf</td>
    <td>MatrDe</td>
    <td>FondPens</td>
    <td>EPS</td>
    <td>GrupoSan</td>
    <td>Direccion</td>
    <td>Barrio</td>
    <td>Telefono</td>
    <td>Celular</td>
    <td>Email</td>
    <td>AvisarA</td>
    <td>TelAvis</td>
    <td>PadresVi</td>
    <td>Conyuge</td>
    <td>OcupCony</td>
    <td>NoHijos</td>
    <td>NombHij1</td>
    <td>NombHij2</td>
    <td>NombHij3</td>
    <td>NombHij4</td>
    <td>NombHij5</td>
    <td>FeNaHij1</td>
    <td>FeNaHij2</td>
    <td>FeNaHij3</td>
    <td>FeNaHij4</td>
    <td>FeNaHij5</td>
    <td>IdenHij1</td>
    <td>IdenHij2</td>
    <td>IdenHij3</td>
    <td>IdenHij4</td>
    <td>IdenHij5</td>
    <td>EdadHij1</td>
    <td>EdadHij2</td>
    <td>EdadHij3</td>
    <td>EdadHij4</td>
    <td>EdadHij5</td>
    <td>UnEdHij1</td>
    <td>UnEdHij2</td>
    <td>UnEdHij3</td>
    <td>UnEdHij4</td>
    <td>UnEdHij5</td>
    <td>SexoHij1</td>
    <td>SexoHij2</td>
    <td>SexoHij3</td>
    <td>SexoHij4</td>
    <td>SexoHij5</td>
    <td>Titulo1</td>
    <td>Titulo2</td>
    <td>Titulo3</td>
    <td>Titulo4</td>
    <td>Titulo5</td>
    <td>Titulo6</td>
    <td>Titulo7</td>
    <td>NivelT1</td>
    <td>NivelT2</td>
    <td>NivelT3</td>
    <td>NivelT4</td>
    <td>NivelT5</td>
    <td>NivelT6</td>
    <td>NivelT7</td>
    <td>Instit1</td>
    <td>Instit2</td>
    <td>Instit3</td>
    <td>Instit4</td>
    <td>Instit5</td>
    <td>Instit6</td>
    <td>Instit7</td>
    <td>CiudaT1</td>
    <td>CiudaT2</td>
    <td>CiudaT3</td>
    <td>CiudaT4</td>
    <td>CiudaT5</td>
    <td>CiudaT6</td>
    <td>CiudaT7</td>
    <td>FechaT1</td>
    <td>FechaT2</td>
    <td>FechaT3</td>
    <td>FechaT4</td>
    <td>FechaT5</td>
    <td>FechaT6</td>
    <td>FechaT7</td>
    <td>EstudAct</td>
    <td>Program1</td>
    <td>Program2</td>
    <td>Program3</td>
    <td>Program4</td>
    <td>Program5</td>
    <td>Semestr1</td>
    <td>Semestr2</td>
    <td>Semestr3</td>
    <td>Semestr4</td>
    <td>Semestr5</td>
    <td>InstAct1</td>
    <td>InstAct2</td>
    <td>InstAct3</td>
    <td>InstAct4</td>
    <td>InstAct5</td>
    <td>Horario1</td>
    <td>Horario2</td>
    <td>Horario3</td>
    <td>Horario4</td>
    <td>Horario5</td>
    <td>PrVirDi1</td>
    <td>PrVirDi2</td>
    <td>PrVirDi3</td>
    <td>PrVirDi4</td>
    <td>PrVirDi5</td>
    <td>Software1</td>
    <td>Software2</td>
    <td>Software3</td>
    <td>Software4</td>
    <td>Software5</td>
    <td>Idioma1</td>
    <td>Idioma2</td>
    <td>Idioma3</td>
    <td>Idioma4</td>
    <td>Idioma5</td>
    <td>Entidad1</td>
    <td>Entidad2</td>
    <td>Entidad3</td>
    <td>Entidad4</td>
    <td>Entidad5</td>
    <td>Entidad6</td>
    <td>Entidad7</td>
    <td>CargoOc1</td>
    <td>CargoOc2</td>
    <td>CargoOc3</td>
    <td>CargoOc4</td>
    <td>CargoOc5</td>
    <td>CargoOc6</td>
    <td>CargoOc7</td>
    <td>TelEnti1</td>
    <td>TelEnti2</td>
    <td>TelEnti3</td>
    <td>TelEnti4</td>
    <td>TelEnti5</td>
    <td>TelEnti6</td>
    <td>TelEnti7</td>
    <td>DirEnti1</td>
    <td>DirEnti2</td>
    <td>DirEnti3</td>
    <td>DirEnti4</td>
    <td>DirEnti5</td>
    <td>DirEnti6</td>
    <td>DirEnti7</td>
    <td>JefeInm1</td>
    <td>JefeInm2</td>
    <td>JefeInm3</td>
    <td>JefeInm4</td>
    <td>JefeInm5</td>
    <td>JefeInm6</td>
    <td>JefeInm7</td>
    <td>MotiRet1</td>
    <td>MotiRet2</td>
    <td>MotiRet3</td>
    <td>MotiRet4</td>
    <td>MotiRet5</td>
    <td>MotiRet6</td>
    <td>MotiRet7</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_HojasVida['CCHojaVi']; ?></td>
      <td><?php echo $row_HojasVida['Nombres']; ?></td>
      <td><?php echo $row_HojasVida['Apellidos']; ?></td>
      <td><?php echo $row_HojasVida['FechIngr']; ?></td>
      <td><?php echo $row_HojasVida['AreaAd1']; ?></td>
      <td><?php echo $row_HojasVida['AreaAd2']; ?></td>
      <td><?php echo $row_HojasVida['AreaAd3']; ?></td>
      <td><?php echo $row_HojasVida['AreaAd4']; ?></td>
      <td><?php echo $row_HojasVida['AreaAd5']; ?></td>
      <td><?php echo $row_HojasVida['Facult1']; ?></td>
      <td><?php echo $row_HojasVida['Facult2']; ?></td>
      <td><?php echo $row_HojasVida['Facult3']; ?></td>
      <td><?php echo $row_HojasVida['Facult4']; ?></td>
      <td><?php echo $row_HojasVida['Facult5']; ?></td>
      <td><?php echo $row_HojasVida['CargoAd1']; ?></td>
      <td><?php echo $row_HojasVida['CargoAd2']; ?></td>
      <td><?php echo $row_HojasVida['CargoAd3']; ?></td>
      <td><?php echo $row_HojasVida['CargoAd4']; ?></td>
      <td><?php echo $row_HojasVida['CargoAd5']; ?></td>
      <td><?php echo $row_HojasVida['Asignat1']; ?></td>
      <td><?php echo $row_HojasVida['Asignat2']; ?></td>
      <td><?php echo $row_HojasVida['Asignat3']; ?></td>
      <td><?php echo $row_HojasVida['Asignat4']; ?></td>
      <td><?php echo $row_HojasVida['Asignat5']; ?></td>
      <td><?php echo $row_HojasVida['Sexo']; ?></td>
      <td><?php echo $row_HojasVida['EstCivil']; ?></td>
      <td><?php echo $row_HojasVida['Edad']; ?></td>
      <td><?php echo $row_HojasVida['Nacional']; ?></td>
      <td><?php echo $row_HojasVida['FechaNac']; ?></td>
      <td><?php echo $row_HojasVida['LugarNac']; ?></td>
      <td><?php echo $row_HojasVida['LibrMili']; ?></td>
      <td><?php echo $row_HojasVida['Distrito']; ?></td>
      <td><?php echo $row_HojasVida['Clase']; ?></td>
      <td><?php echo $row_HojasVida['FechaExp']; ?></td>
      <td><?php echo $row_HojasVida['Pasaport']; ?></td>
      <td><?php echo $row_HojasVida['Profesion']; ?></td>
      <td><?php echo $row_HojasVida['MatrProf']; ?></td>
      <td><?php echo $row_HojasVida['MatrDe']; ?></td>
      <td><?php echo $row_HojasVida['FondPens']; ?></td>
      <td><?php echo $row_HojasVida['EPS']; ?></td>
      <td><?php echo $row_HojasVida['GrupoSan']; ?></td>
      <td><?php echo $row_HojasVida['Direccion']; ?></td>
      <td><?php echo $row_HojasVida['Barrio']; ?></td>
      <td><?php echo $row_HojasVida['Telefono']; ?></td>
      <td><?php echo $row_HojasVida['Celular']; ?></td>
      <td><?php echo $row_HojasVida['Email']; ?></td>
      <td><?php echo $row_HojasVida['AvisarA']; ?></td>
      <td><?php echo $row_HojasVida['TelAvis']; ?></td>
      <td><?php echo $row_HojasVida['PadresVi']; ?></td>
      <td><?php echo $row_HojasVida['Conyuge']; ?></td>
      <td><?php echo $row_HojasVida['OcupCony']; ?></td>
      <td><?php echo $row_HojasVida['NoHijos']; ?></td>
      <td><?php echo $row_HojasVida['NombHij1']; ?></td>
      <td><?php echo $row_HojasVida['NombHij2']; ?></td>
      <td><?php echo $row_HojasVida['NombHij3']; ?></td>
      <td><?php echo $row_HojasVida['NombHij4']; ?></td>
      <td><?php echo $row_HojasVida['NombHij5']; ?></td>
      <td><?php echo $row_HojasVida['FeNaHij1']; ?></td>
      <td><?php echo $row_HojasVida['FeNaHij2']; ?></td>
      <td><?php echo $row_HojasVida['FeNaHij3']; ?></td>
      <td><?php echo $row_HojasVida['FeNaHij4']; ?></td>
      <td><?php echo $row_HojasVida['FeNaHij5']; ?></td>
      <td><?php echo $row_HojasVida['IdenHij1']; ?></td>
      <td><?php echo $row_HojasVida['IdenHij2']; ?></td>
      <td><?php echo $row_HojasVida['IdenHij3']; ?></td>
      <td><?php echo $row_HojasVida['IdenHij4']; ?></td>
      <td><?php echo $row_HojasVida['IdenHij5']; ?></td>
      <td><?php echo $row_HojasVida['EdadHij1']; ?></td>
      <td><?php echo $row_HojasVida['EdadHij2']; ?></td>
      <td><?php echo $row_HojasVida['EdadHij3']; ?></td>
      <td><?php echo $row_HojasVida['EdadHij4']; ?></td>
      <td><?php echo $row_HojasVida['EdadHij5']; ?></td>
      <td><?php echo $row_HojasVida['UnEdHij1']; ?></td>
      <td><?php echo $row_HojasVida['UnEdHij2']; ?></td>
      <td><?php echo $row_HojasVida['UnEdHij3']; ?></td>
      <td><?php echo $row_HojasVida['UnEdHij4']; ?></td>
      <td><?php echo $row_HojasVida['UnEdHij5']; ?></td>
      <td><?php echo $row_HojasVida['SexoHij1']; ?></td>
      <td><?php echo $row_HojasVida['SexoHij2']; ?></td>
      <td><?php echo $row_HojasVida['SexoHij3']; ?></td>
      <td><?php echo $row_HojasVida['SexoHij4']; ?></td>
      <td><?php echo $row_HojasVida['SexoHij5']; ?></td>
      <td><?php echo $row_HojasVida['Titulo1']; ?></td>
      <td><?php echo $row_HojasVida['Titulo2']; ?></td>
      <td><?php echo $row_HojasVida['Titulo3']; ?></td>
      <td><?php echo $row_HojasVida['Titulo4']; ?></td>
      <td><?php echo $row_HojasVida['Titulo5']; ?></td>
      <td><?php echo $row_HojasVida['Titulo6']; ?></td>
      <td><?php echo $row_HojasVida['Titulo7']; ?></td>
      <td><?php echo $row_HojasVida['NivelT1']; ?></td>
      <td><?php echo $row_HojasVida['NivelT2']; ?></td>
      <td><?php echo $row_HojasVida['NivelT3']; ?></td>
      <td><?php echo $row_HojasVida['NivelT4']; ?></td>
      <td><?php echo $row_HojasVida['NivelT5']; ?></td>
      <td><?php echo $row_HojasVida['NivelT6']; ?></td>
      <td><?php echo $row_HojasVida['NivelT7']; ?></td>
      <td><?php echo $row_HojasVida['Instit1']; ?></td>
      <td><?php echo $row_HojasVida['Instit2']; ?></td>
      <td><?php echo $row_HojasVida['Instit3']; ?></td>
      <td><?php echo $row_HojasVida['Instit4']; ?></td>
      <td><?php echo $row_HojasVida['Instit5']; ?></td>
      <td><?php echo $row_HojasVida['Instit6']; ?></td>
      <td><?php echo $row_HojasVida['Instit7']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT1']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT2']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT3']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT4']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT5']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT6']; ?></td>
      <td><?php echo $row_HojasVida['CiudaT7']; ?></td>
      <td><?php echo $row_HojasVida['FechaT1']; ?></td>
      <td><?php echo $row_HojasVida['FechaT2']; ?></td>
      <td><?php echo $row_HojasVida['FechaT3']; ?></td>
      <td><?php echo $row_HojasVida['FechaT4']; ?></td>
      <td><?php echo $row_HojasVida['FechaT5']; ?></td>
      <td><?php echo $row_HojasVida['FechaT6']; ?></td>
      <td><?php echo $row_HojasVida['FechaT7']; ?></td>
      <td><?php echo $row_HojasVida['EstudAct']; ?></td>
      <td><?php echo $row_HojasVida['Program1']; ?></td>
      <td><?php echo $row_HojasVida['Program2']; ?></td>
      <td><?php echo $row_HojasVida['Program3']; ?></td>
      <td><?php echo $row_HojasVida['Program4']; ?></td>
      <td><?php echo $row_HojasVida['Program5']; ?></td>
      <td><?php echo $row_HojasVida['Semestr1']; ?></td>
      <td><?php echo $row_HojasVida['Semestr2']; ?></td>
      <td><?php echo $row_HojasVida['Semestr3']; ?></td>
      <td><?php echo $row_HojasVida['Semestr4']; ?></td>
      <td><?php echo $row_HojasVida['Semestr5']; ?></td>
      <td><?php echo $row_HojasVida['InstAct1']; ?></td>
      <td><?php echo $row_HojasVida['InstAct2']; ?></td>
      <td><?php echo $row_HojasVida['InstAct3']; ?></td>
      <td><?php echo $row_HojasVida['InstAct4']; ?></td>
      <td><?php echo $row_HojasVida['InstAct5']; ?></td>
      <td><?php echo $row_HojasVida['Horario1']; ?></td>
      <td><?php echo $row_HojasVida['Horario2']; ?></td>
      <td><?php echo $row_HojasVida['Horario3']; ?></td>
      <td><?php echo $row_HojasVida['Horario4']; ?></td>
      <td><?php echo $row_HojasVida['Horario5']; ?></td>
      <td><?php echo $row_HojasVida['PrVirDi1']; ?></td>
      <td><?php echo $row_HojasVida['PrVirDi2']; ?></td>
      <td><?php echo $row_HojasVida['PrVirDi3']; ?></td>
      <td><?php echo $row_HojasVida['PrVirDi4']; ?></td>
      <td><?php echo $row_HojasVida['PrVirDi5']; ?></td>
      <td><?php echo $row_HojasVida['Software1']; ?></td>
      <td><?php echo $row_HojasVida['Software2']; ?></td>
      <td><?php echo $row_HojasVida['Software3']; ?></td>
      <td><?php echo $row_HojasVida['Software4']; ?></td>
      <td><?php echo $row_HojasVida['Software5']; ?></td>
      <td><?php echo $row_HojasVida['Idioma1']; ?></td>
      <td><?php echo $row_HojasVida['Idioma2']; ?></td>
      <td><?php echo $row_HojasVida['Idioma3']; ?></td>
      <td><?php echo $row_HojasVida['Idioma4']; ?></td>
      <td><?php echo $row_HojasVida['Idioma5']; ?></td>
      <td><?php echo $row_HojasVida['Entidad1']; ?></td>
      <td><?php echo $row_HojasVida['Entidad2']; ?></td>
      <td><?php echo $row_HojasVida['Entidad3']; ?></td>
      <td><?php echo $row_HojasVida['Entidad4']; ?></td>
      <td><?php echo $row_HojasVida['Entidad5']; ?></td>
      <td><?php echo $row_HojasVida['Entidad6']; ?></td>
      <td><?php echo $row_HojasVida['Entidad7']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc1']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc2']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc3']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc4']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc5']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc6']; ?></td>
      <td><?php echo $row_HojasVida['CargoOc7']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti1']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti2']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti3']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti4']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti5']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti6']; ?></td>
      <td><?php echo $row_HojasVida['TelEnti7']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti1']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti2']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti3']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti4']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti5']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti6']; ?></td>
      <td><?php echo $row_HojasVida['DirEnti7']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm1']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm2']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm3']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm4']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm5']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm6']; ?></td>
      <td><?php echo $row_HojasVida['JefeInm7']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet1']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet2']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet3']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet4']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet5']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet6']; ?></td>
      <td><?php echo $row_HojasVida['MotiRet7']; ?></td>
    </tr>
    <?php } while ($row_HojasVida = mysql_fetch_assoc($HojasVida)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($HojasVida);
?>
