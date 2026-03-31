<script language="javascript">
function validar(){

	if(document.getElementById('accion').value.length < 1){
		alert('Porfavor Seleccione Accion');
	}
	else{
		document.getElementById('form1').submit();
	}
}
</script>
<form name="form1" id="form1" action="" method="POST">
<table>
<tr>
	<td>Dedicacion</td>
	<td>
	<select name="accion" id="accion">
		<option value="">Seleccionar</option>>
		<option value="1" <?php if($_POST['accion']=='1')echo "selected"?>>Tiempo Completo</option>
		<option value="2" <?php if($_POST['accion']=='2')echo "selected"?>>Medio tiempo</option>
		<option value="3" <?php if($_POST['accion']=='3')echo "selected"?>>Contrato por horas</option>
	</select>
	</td>
</tr>
</table>
<input name="Enviar" type="submit" value="Enviar" onclick="validar()">
</form>
<?php 
//echo "<H1>ENTRO A ESTA VAINA 1</H1>";
//require_once("claseldap.php");
$rutaado=("../serviciosacademicos/funciones/adodb/");
require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once("../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
//echo "<H1>ENTRO A ESTA VAINA 2</H1>";

if(isset($_REQUEST['Enviar'])){
//echo "ENTRO A ESTA VAINA";
$objetobase=new BaseDeDatosGeneral($sala);
//$condicion="and ( cargo like '%DOCENTE%'  or categoria like '%profesor%' or categoria like '%instructor%' )";
$groupby=" group by codigo";

/*$condicion=" and centrocosto not like '%Servicios%Generales%' and 
			centrocosto not like '%mantenimiento%' and centrocosto not like '%seguridad%' and idtempcotizacionmicrosoft not in (select 
			idtempcotizacionmicrosoft from tmpcotizacionmicrosoft where 1= '1' and ( cargo like '%DOCENTE%'
			  or categoria like '%profesor%' or categoria like '%instructor%') )";*/
/*$query =" select t.idtempcotizacionmicrosoft from tmpcotizacionmicrosoft t 
	where  horassemana >= all (select horassemana from tmpcotizacionmicrosoft t2 
		where t.idtempcotizacionmicrosoft=t2.idtempcotizacionmicrosoft)
	group by codigo";*/
	$condicion="";
$operacion=$objetobase->recuperar_resultado_tabla("tmpdocentesnies","1","1",$condicion." ".$groupby," ,sum(horasmes) sumhorasmes,sum(horassemana) sumhorassemana,sum(horasdiarias) sumhorasdia",1);
//$operacion=$objetobase->conexion->query($query);

echo "<table>";

while($row=$operacion->fetchRow()){
			$dedicacionv=explode("/",$row["dedicacion"]);
			$horassemestre=$row["sumhorassemana"]*20;
			//$row["sumhorasmes"];
			switch($_POST['accion']){
				case '1':
				//1 Docente tiempo completo
				if($row["sumhorassemana"]>=40){  
					$fila["tipocontratacion"]=1;
					$fila["principal"]=1;
					$objetobase->actualizar_fila_bd("tmpdocentesnies",$fila,"idtempcotizacionmicrosoft",$row["idtempcotizacionmicrosoft"],"",1);		
					unset($fila);		
				}
				break;
				case '2':
				//2 Docente Medio tiempo
				if(($row["sumhorassemana"]<40)&&($row["sumhorassemana"]>=20)){
					$fila["tipocontratacion"]=2;
					$fila["principal"]=1;			$objetobase->actualizar_fila_bd("tmpdocentesnies",$fila,"idtempcotizacionmicrosoft",$row["idtempcotizacionmicrosoft"],"",1);
					unset($fila);
				}		
				break;
				case '3':
				//3 Docente por horas
				if($row["sumhorassemana"]<20){  
					$fila["tipocontratacion"]=3;
					$fila["principal"]=1;
					$objetobase->actualizar_fila_bd("tmpdocentesnies",$fila,"idtempcotizacionmicrosoft",$row["idtempcotizacionmicrosoft"],"",1);
					unset($fila);
				}			
			
			}
	/*if(trim($dedicacionv[1])=="SEMANA")
	{ echo "Entro ".$row["idtempcotizacionmicrosoft"]."<br>"; }*/
	echo "<tr>";
	foreach ($row as $llave=>$valor)
	{
		echo "<td>".$row[$llave]."</td>";
	}
	echo "</tr>";

}
echo "</table>";

}
?>