<?
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
echo "<form name='forma' action='' method='post'>";
if($_REQUEST['accion']=='Exportar') {
	$nombre_archivo_excel='resultados.xls';
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=$nombre_archivo_excel");
}
if($_REQUEST['accion']!='Exportar')
	echo "<input type='submit' name='accion' value='Exportar'>";
/*$query="select nombrecortoconvenciondireccion,nombreconvenciondireccion
	from convenciondireccion";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
while($row=mysql_fetch_array($exec)) {
	$arrConvencionCorta[]=$row['nombrecortoconvenciondireccion'];
	$arrConvencionLarga[]=$row['nombreconvenciondireccion'];
}*/
$arrConvencionCorta=array('AC','AD','ADL','AER','AG','AGP','AK','AL','ALD','ALM','AP','APTDO','ATR','AUT','AV','AVIAL','BG','BL','BLV','BRR','C','CA','CAS','CC','CD','CEL','CEN','CIR','CL','CLJ','CN','CON','CONJ','CR','CRT','CRV','CS','DG','DP','DPTO','DS','ED','EN','ES','ESQ','ESTE','ET','EX','FCA','GJ','GS','GT','HC','HG','IN','IP','IPD','IPM','KM','LC','LM','LT','MD','MJ','MLL','MN','MZ','NORTE','O','OCC','OESTE','OF','P','PA','PAR','PD','PH','PJ','PL','PN','POR','POS','PQ','PRJ','PS','PT','PW','RP','SA','SC','SD','SEC','SL','SM','SS','ST','SUITE','SUR','TER','TERPLN','TO','TV','TZ','UN','UR','URB','VRD','VTE','ZF','ZN'); 
$arrConvencionLarga=array('AVENIDA CALLE','ADMINISTRACION','ADELANTE','AEROPUERTO','AGENCIA','AGRUPACION','AVENIDA CARRERA','ALTILLO','AL LADO','ALMACEN','APARTAMENTO','APARTADO','ATRAS','AUTOPISTA','AVENIDA','ANILLO VIAL','BODEGA','BLOQUE','BOULEVARD','BARRIO','CORREGIMIENTO','CASA','CASERIO','CENTRO COMERCIAL','CIUDADELA','CELULA','CENTRO','CIRCULAR','CALLE','CALLEJON','CAMINO','CONJUNTO RESIDENCIAL','CONJUNTO','CARRERA','CARRETERA','CIRCUNVALAR','CONSULTORIO','DIAGONAL','DEPOSITO','DEPARTAMENTO','DEPOSITO SOTANO','EDIFICIO','ENTRADA','ESCALERA','ESQUINA','ESTE','ETAPA','EXTERIOR','FINCA','GARAJE','GARAJE SOTANO','GLORIETA','HACIENDA','HANGAR','INTERIOR','INSPECCION DE POLICIA','INSPECCION DEPARTAMENTAL','INSPECCION MUNICIPAL','KILOMETRO','LOCAL','LOCAL MEZZANINE','LOTE','MODULO','MOJON','MUELLE','MEZZANINE','MANZANA','NORTE','ORIENTE','OCCIDENTE','OESTE','OFICINA','PISO','PARCELA','PARQUE','PREDIO','PENTHOUSE','PASAJE','PLANTA','PUENTE','PORTERIA','POSTE','PARQUEADERO','PARAJE','PASEO','PUESTO','PARK WAY','ROUND POINT','SALON','SALON COMUNAL','SALIDA','SECTOR','SOLAR','SUPER MANZANA','SEMISOTANO','SOTANO','SUITE','SUR','TERMINAL','TERRAPLEN','TORRE','TRANSVERSAL','TERRAZA','UNIDAD','UNIDAD RESIDENCIAL','URBANIZACION','VEREDA','VARIANTE','ZONA FRANCA','ZONA');
echo "<table border='1'>";
echo "<tr>";
echo "<th>Apellidos</th>";
echo "<th>Nombres</th>";
echo "<th>Nro. Documento</th>";
echo "<th>Direcci&oacute;n Residencia</th>";
echo "<th>Programa Acad&eacute;mico</th>";
echo "<th>Pa&iacute;s Residencia</th>";
echo "</tr>";
$query=" select	 distinct
		 upper(eg.apellidosestudiantegeneral)					as apellidos
		,upper(eg.nombresestudiantegeneral)					as nombres
		,eg.numerodocumento							as documento
		,upper(trim(eg.direccionresidenciaestudiantegeneral))			as direccion
		,upper(c.nombrecarrera)							as carrera
		,upper(pa.nombrecortopais)						as pais
	from ordenpago op
	join estudiante e using(codigoestudiante)
	join estudiantegeneral eg using(idestudiantegeneral)
	join carrera c using(codigocarrera)
	left join ciudad ci on eg.ciudadresidenciaestudiantegeneral=ci.idciudad
	left join departamento de using(iddepartamento)
	left join pais pa using (idpais)
	where op.codigoperiodo in (20121,20122)
		and op.codigoestadoordenpago like '4%'
	order by eg.numerodocumento";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
$arrVocales=array('Á','É','Í','Ó','Ú','Ñ');
$arrVocalesHex=array('&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&Ntilde;');
while($row=mysql_fetch_array($exec)) {
	$cadenaDireccion=str_replace($arrConvencionLarga,$arrConvencionCorta,$row['direccion']);
	echo "<tr>";
	echo "<td>".str_replace($arrVocales,$arrVocalesHex,$row['apellidos'])."</td>";
	echo "<td>".str_replace($arrVocales,$arrVocalesHex,$row['nombres'])."</td>";
	echo "<td>".$row['documento']."</td>";
	echo "<td>".str_replace($arrVocales,$arrVocalesHex,$cadenaDireccion)."</td>";
	echo "<td>".str_replace($arrVocales,$arrVocalesHex,$row['carrera'])."</td>";
	echo "<td>".$row['pais']."</td>";
	echo "</tr>";
}
echo "</table>";
echo "</form>";
?>		
