<html>
	<head>
		<title>:: INFORMACION HISTORICA SNIES ::</title>
		<script>
			function generar() {
				document.forma.accion.value="Generar";
				document.forma.accion2.value="";
				document.forma.submit();
			}
			function exportar() {
				document.forma.accion.value="Generar";
				document.forma.accion2.value="Exportar";
				document.forma.submit();
			}
		</script>
                <link type="text/css" rel="stylesheet" media="all" href="../serviciosacademicos/consulta/simulacioncredito/css_simulador.css" />
	</head>
	<body>
		<form name="forma" action="" method="post">
		<input type="hidden" name="accion" value="Generar">
		<input type="hidden" name="accion2" value="">
<?php
		$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
		require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
		if($_REQUEST["accion2"]=="Exportar") {
			header("Content-Type: application/vnd.ms-excel");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=NOMBRE.xls");
		} else {
?>
			<center><h2>Informaci&oacute;n Hist&oacute;rica SNIES</h2></center>
			<table border="1" align="center">
				<tr>
					<td><b>A&ntilde;o</b></td>
					<td>
						<select name="anio">
							<option value='2010' <?=($_REQUEST["anio"]=="2008")?"selected":"";?>>2008</option>
							<option value='2010' <?=($_REQUEST["anio"]=="2009")?"selected":"";?>>2009</option>
							<option value='2010' <?=($_REQUEST["anio"]=="2010")?"selected":"";?>>2010</option>
							<option value='2011' <?=($_REQUEST["anio"]=="2011")?"selected":"";?>>2011</option>
							<option value='2012' <?=($_REQUEST["anio"]=="2012")?"selected":"";?>>2012</option>
							<option value='2013' <?=($_REQUEST["anio"]=="2013")?"selected":"";?>>2013</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><b>Periodo</b></td>
					<td>
						<select name="periodo">
							<option value='01' <?=($_REQUEST["periodo"]=="1")?"selected":"";?>>Primero</option>
							<option value='02' <?=($_REQUEST["periodo"]=="2")?"selected":"";?>>Segundo</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><b>Variable</b></td>
					<td>
						<select name="variable">
							<option value='1' <?=($_REQUEST["variable"]=="1")?"selected":"";?>>MATRICULADOS</option> 
							<option value='2' <?=($_REQUEST["variable"]=="2")?"selected":"";?>>INSCRITOS</option>
							<option value='3' <?=($_REQUEST["variable"]=="3")?"selected":"";?>>ADMITIDOS</option>
							<option value='4' <?=($_REQUEST["variable"]=="4")?"selected":"";?>>EGRESADOS</option>
							<option value='5' <?=($_REQUEST["variable"]=="5")?"selected":"";?>>GRADUADOS</option>
							<option value='6' <?=($_REQUEST["variable"]=="6")?"selected":"";?>>DOCENTES</option>
						</select>
					</td>
				</tr>
			</table>
			<br>
			<center><input type="button" value="Generar" onclick="generar()"></center>
			<br>
<?php
		}
		if($_REQUEST["accion"]=="Generar") {
			if($_REQUEST["variable"]==1) {
?>
				<table align="center" border="1">
					<tr>
						<td colspan="10"><h3><img src="excel.png" onclick="exportar()">&nbsp;&nbsp;MATRICULADOS / <?=$_REQUEST["anio"]."-".$_REQUEST["periodo"]?></h3></td>
					</tr>
					<tr>
						<th>tipo documento</th>
						<th>documento</th>
						<th>primer apellido</th>
						<th>segundo apellido</th>
						<th>primer nombre</th>
						<th>segundo nombre</th>
						<th>departamento</th>
						<th>municipio</th>
						<th>c&oacute;digo programa</th>
						<th>programa</th>
					</tr>
<?php
				$cadena="select *
					from matriculado m 
					join programa using(pro_consecutivo) 
					join participante p on m.codigo_unico=p.codigo_unico and m.tipo_doc_unico=p.tipo_doc_unico
					where est_annio=".$_REQUEST["anio"]."
						and est_semestre='".$_REQUEST["periodo"]."'";
				$operacion=$snies_conexion->query($cadena);
				while($row=$operacion->fetchRow()) {
?>
					<tr>
						<td><?=$row["tipo_doc_unico"]?></td>
						<td><?=$row["codigo_unico"]?></td>
						<td><?=$row["primer_apellido"]?></td>
						<td><?=$row["segundo_apellido"]?></td>
						<td><?=$row["primer_nombre"]?></td>
						<td><?=$row["segundo_nombre"]?></td>
						<td><?=$row["departamento"]?></td>
						<td><?=$row["municipio"]?></td>
						<td><?=$row["pro_consecutivo"]?></td>
						<td><?=$row["prog_nombre"]?></td>
					</tr>
<?php
				}
?>
				</table>
<?php
			}
			if($_REQUEST["variable"]==2) {
?>
				<table align="center" border="1">
					<tr>
						<td colspan="10"><h3><img src="excel.png" onclick="exportar()">&nbsp;&nbsp;INSCRITOS / <?=$_REQUEST["anio"]."-".$_REQUEST["periodo"]?></h3></td>
					</tr>
					<tr>
						<th>tipo documento</th>
						<th>documento</th>
						<th>primer apellido</th>
						<th>segundo apellido</th>
						<th>primer nombre</th>
						<th>segundo nombre</th>
						<th>departamento</th>
						<th>municipio</th>
						<th>c&oacute;digo programa</th>
						<th>programa</th>
					</tr>
<?php
				$cadena="select * 
					from inscrito i 
					join programa p on i.prog_prim_opc=p.pro_consecutivo
					where ins_annio=".$_REQUEST["anio"]."
						and ins_semestre='".$_REQUEST["periodo"]."'";
				$operacion=$snies_conexion->query($cadena);
				while($row=$operacion->fetchRow()) {
?>
					<tr>
						<td><?=$row["tipo_ident_code"]?></td>
						<td><?=$row["documento"]?></td>
						<td><?=$row["primer_apellido"]?></td>
						<td><?=$row["segundo_apellido"]?></td>
						<td><?=$row["primer_nombre"]?></td>
						<td><?=$row["segundo_nombre"]?></td>
						<td><?=$row["departamento"]?></td>
						<td><?=$row["municipio"]?></td>
						<td><?=$row["pro_consecutivo"]?></td>
						<td><?=$row["prog_nombre"]?></td>
					</tr>
<?php
				}
?>
				</table>
<?php
			}
			if($_REQUEST["variable"]==3) {
?>
				<table align="center" border="1">
					<tr>
						<td colspan="10"><h3><img src="excel.png" onclick="exportar()">&nbsp;&nbsp;ADMITIDOS / <?=$_REQUEST["anio"]."-".$_REQUEST["periodo"]?></h3></td>
					</tr>
					<tr>
						<th>tipo documento</th>
						<th>documento</th>
						<th>primer apellido</th>
						<th>segundo apellido</th>
						<th>primer nombre</th>
						<th>segundo nombre</th>
						<th>departamento</th>
						<th>municipio</th>
						<th>c&oacute;digo programa</th>
						<th>programa</th>
					</tr>
<?php
				$cadena="select *
					from admitido
					join programa using(pro_consecutivo)
					where adm_annio=".$_REQUEST["anio"]."
						and adm_semestre='".$_REQUEST["periodo"]."'";
				$operacion=$snies_conexion->query($cadena);
				while($row=$operacion->fetchRow()) {
?>
					<tr>
						<td><?=$row["tipo_identif"]?></td>
						<td><?=$row["documento"]?></td>
						<td><?=$row["primer_apellido"]?></td>
						<td><?=$row["segundo_apellido"]?></td>
						<td><?=$row["primer_nombre"]?></td>
						<td><?=$row["segundo_nombre"]?></td>
						<td><?=$row["departamento"]?></td>
						<td><?=$row["municipio"]?></td>
						<td><?=$row["pro_consecutivo"]?></td>
						<td><?=$row["prog_nombre"]?></td>
					</tr>
<?php
				}
?>
				</table>
<?php
			}
			if($_REQUEST["variable"]==4) {
?>
				<table align="center" border="1">
					<tr>
						<td colspan="10"><h3><img src="excel.png" onclick="exportar()">&nbsp;&nbsp;EGRESADOS / <?=$_REQUEST["anio"]."-".$_REQUEST["periodo"]?></h3></td>
					</tr>
					<tr>
						<th>tipo documento</th>
						<th>documento</th>
						<th>primer apellido</th>
						<th>segundo apellido</th>
						<th>primer nombre</th>
						<th>segundo nombre</th>
						<th>departamento</th>
						<th>municipio</th>
						<th>c&oacute;digo programa</th>
						<th>programa</th>
					</tr>
<?php
				$cadena="select * 
					from egresado e 
					join programa using(pro_consecutivo) join participante p on e.codigo_unico=p.codigo_unico and e.tipo_doc_unico=p.tipo_doc_unico
					where ins_annio=".$_REQUEST["anio"]."
						and ins_semestre='".$_REQUEST["periodo"]."'";
				$operacion=$snies_conexion->query($cadena);
				while($row=$operacion->fetchRow()) {
?>
					<tr>
						<td><?=$row["tipo_doc_unico"]?></td>
						<td><?=$row["codigo_unico"]?></td>
						<td><?=$row["primer_apellido"]?></td>
						<td><?=$row["segundo_apellido"]?></td>
						<td><?=$row["primer_nombre"]?></td>
						<td><?=$row["segundo_nombre"]?></td>
						<td><?=$row["departamento"]?></td>
						<td><?=$row["municipio"]?></td>
						<td><?=$row["pro_consecutivo"]?></td>
						<td><?=$row["prog_nombre"]?></td>
					</tr>
<?php
				}
?>
				</table>
<?php
			}
			if($_REQUEST["variable"]==5) {
?>
				<table align="center" border="1">
					<tr>
						<td colspan="10"><h3><img src="excel.png" onclick="exportar()">&nbsp;&nbsp;GRADUADOS / <?=$_REQUEST["anio"]."-".$_REQUEST["periodo"]?></h3></td>
					</tr>
					<tr>
						<th>tipo documento</th>
						<th>documento</th>
						<th>primer apellido</th>
						<th>segundo apellido</th>
						<th>primer nombre</th>
						<th>segundo nombre</th>
						<th>departamento</th>
						<th>municipio</th>
						<th>c&oacute;digo programa</th>
						<th>programa</th>
					</tr>
<?php
				$cadena="select *
					from graduado g
					join programa pr using(pro_consecutivo)
					join participante p on g.codigo_unico=p.codigo_unico and g.tipo_doc_unico=p.tipo_doc_unico 
					where grad_annio=".$_REQUEST["anio"]."
						and grad_semestre='".$_REQUEST["periodo"]."'";
				$operacion=$snies_conexion->query($cadena);
				while($row=$operacion->fetchRow()) {
?>
					<tr>
						<td><?=$row["tipo_doc_unico"]?></td>
						<td><?=$row["codigo_unico"]?></td>
						<td><?=$row["primer_apellido"]?></td>
						<td><?=$row["segundo_apellido"]?></td>
						<td><?=$row["primer_nombre"]?></td>
						<td><?=$row["segundo_nombre"]?></td>
						<td><?=$row["departamento"]?></td>
						<td><?=$row["municipio"]?></td>
						<td><?=$row["pro_consecutivo"]?></td>
						<td><?=$row["prog_nombre"]?></td>
					</tr>
<?php
				}
?>
				</table>
<?php
			}
			if($_REQUEST["variable"]==6) {
?>
				<table align="center" border="1">
					<tr>
						<td colspan="9"><h3><img src="excel.png" onclick="exportar()">&nbsp;&nbsp;DOCENTES / <?=$_REQUEST["anio"]."-".$_REQUEST["periodo"]?></h3></td>
					</tr>
					<tr>
						<th>tipo documento</th>
						<th>documento</th>
						<th>primer apellido</th>
						<th>segundo apellido</th>
						<th>primer nombre</th>
						<th>segundo nombre</th>
						<th>nivel dedicaci&oacute;n</th>
						<th>nivel formaci&oacute;n</th>
						<th>tipo contrato</th>
					</tr>
<?php
				$cadena="select distinct h.codigo_unico,h.tipo_doc_unico,p.primer_apellido,p.segundo_apellido,p.primer_nombre,p.segundo_nombre,h.dedicacion,dd.valor,d.nivel_est_code,ne.nivel_descr,tipo_contrato,tc.contrato_descr
					from   participante p, docente_h h
					,tipo_contrato tc
					,nivel_estudio ne
					,dedicacion_docente dd
					,       docente d LEFT OUTER JOIN estudio_docente e on
							     (d.ies_code=e.ies_code and
							      d.codigo_unico=e.codigo_unico and
							      d.tipo_doc_unico=e.tipo_doc_unico)
							 LEFT OUTER JOIN capacitacion_docente c on
							     (d.ies_code=c.ies_code and
							      d.codigo_unico=c.codigo_unico and
							      d.tipo_doc_unico=c.tipo_doc_unico)
					where  h.ies_code=p.ies_code
					and    h.codigo_unico=p.codigo_unico
					and    h.tipo_doc_unico=p.tipo_doc_unico
					and    h.ies_code=d.ies_code
					and    h.codigo_unico=d.codigo_unico
					and    h.tipo_doc_unico=d.tipo_doc_unico
					and h.tipo_contrato=tc.contrato_code
					and d.nivel_est_code=ne.nivel_code
					and h.dedicacion=dd.identificacion
					and    h.ies_code='1729' AND h.ANNIO=".$_REQUEST["anio"]." AND h.SEMESTRE='".$_REQUEST["periodo"]."'";
				$operacion=$snies_conexion->query($cadena);
				while($row=$operacion->fetchRow()) {
?>
					<tr>
						<td><?=$row["tipo_doc_unico"]?></td>
						<td><?=$row["codigo_unico"]?></td>
						<td><?=$row["primer_apellido"]?></td>
						<td><?=$row["segundo_apellido"]?></td>
						<td><?=$row["primer_nombre"]?></td>
						<td><?=$row["segundo_nombre"]?></td>
						<td><?=$row["valor"]?></td>
						<td><?=$row["nivel_descr"]?></td>
						<td><?=$row["contrato_descr"]?></td>
					</tr>
<?php
				}
?>
				</table>
<?php
			}

		}
?>
		</form>
	</body>
</html>
