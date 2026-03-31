<?php
if($procesoautomatico){
	require_once('../../../funciones/funciontiempo.php');
}else{
	require_once('../../funciones/funciontiempo.php');
}

$codigocarrera;
$codigocarreramatricula = $codigocarrera;
$query_selectpecuniarios = "select v.codigoconcepto, v.valorpecuniario 
from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, concepto c
where v.idvalorpecuniario = dfv.idvalorpecuniario
and v.codigoperiodo = '$codigoperiodo'
and fv.codigoperiodo = v.codigoperiodo
and fv.codigocarrera = '$codigocarrera'
and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
and dfv.codigotipoestudiante = '$codigotipoestudiante'
and dfv.codigoestado like '1%'
and c.codigoconcepto = v.codigoconcepto
and c.codigoreferenciaconcepto = '100'";
$selectpecuniarios = mysql_query($query_selectpecuniarios, $sala) or die("$query_selectpecuniarios");
$totalRows_selectpecuniarios = mysql_num_rows($selectpecuniarios);

$debecobrarpecuniarios = false;
// Se seleccionan todos los valores pecuniarios
while($row_selectpecuniarios = mysql_fetch_assoc($selectpecuniarios)){
	$codigoconceptopecuniario = $row_selectpecuniarios['codigoconcepto'];
	$valorconceptopecuniario = $row_selectpecuniarios['valorpecuniario'];
	// Mira si las ordenes que tiene el estudiante activas
	// Tienen pago el concepto
	if($codigomodalidadacademica != 100){
		$query_selectordenconconcepto = "SELECT o.numeroordenpago
		FROM ordenpago o, detalleordenpago d
		where o.codigoestudiante = '$codigoestudiante'
		and (o.codigoestadoordenpago like '4%' or o.codigoestadoordenpago like '1%')
		and o.codigoperiodo = '$codigoperiodo'
		and d.numeroordenpago = o.numeroordenpago
		and d.codigoconcepto = '$codigoconceptopecuniario'";
	}else{
		$query_selectordenconconcepto = "SELECT o.numeroordenpago
		FROM ordenpago o, detalleordenpago d, grupoperiodocarrera g, detallegrupoperiodocarrera dg
		where o.codigoestudiante = '$codigoestudiante'
		and (o.codigoestadoordenpago like '4%' or o.codigoestadoordenpago like '1%')
		and o.codigoperiodo = dg.codigoperiodo
		and d.numeroordenpago = o.numeroordenpago
		and d.codigoconcepto = '$codigoconceptopecuniario'
		and g.codigocarrera = '$codigocarrera'
		and g.idgrupoperiodocarrera = dg.idgrupoperiodocarrera
		and g.fechainiciogrupoperiodocarrera <= '".date("Y-m-d")."'
		and g.fechafinalgrupoperiodocarrera >= '".date("Y-m-d")."'";
	}

	$selectordenconconcepto = mysql_query($query_selectordenconconcepto, $sala) or die("$query_selectordenconconcepto".mysql_error());
	$totalRows_selectordenconconcepto = mysql_num_rows($selectordenconconcepto);

	if($totalRows_selectordenconconcepto == ""){
		$debecobrarpecuniarios = true;
		$pecuniariosacobrar[$codigoconceptopecuniario] = $valorconceptopecuniario;
	}
}
// Cobro de descuentos vs deudas y pecuniarios
$guardar = 0;
$recargototalvalormatricula = $totalvalormatricula;
$codigoconceptoarreglo[$guardar] = $codigoconcepto;
$valorconcepto[$guardar] = $totalvalormatricula;
$codigotipodetalle[$guardar] = 01; 
$guardar = $guardar + 1;
$valorpecuniario = 0;
$descuento = 0;
$saldo = 0;

// Seleccion de deudas y descuentos del estudiante para la carrera
if(!isset($_SESSION['cursosvacacionalessesion'])){
	// Descuentos vs deudas, muy improbablemente se modifica
	$query_seldeudas = "SELECT d.codigoconcepto, d.valordescuentovsdeuda, d.codigoestudiante, c.nombreconcepto, c.codigotipoconcepto
	FROM descuentovsdeuda d, tipoconcepto t, concepto c
	WHERE d.codigoestudiante = '$codigoestudiante'
	and d.codigoestadodescuentovsdeuda = '01'
	and d.codigoconcepto = c.codigoconcepto
	and c.codigotipoconcepto = t.codigotipoconcepto
	and d.codigoperiodo = '$codigoperiodo'";
	$seldeudas = mysql_query($query_seldeudas, $sala) or die("$query_seldeudas".mysql_error());
	$totalRows_seldeudas = mysql_num_rows($seldeudas);
	if($totalRows_seldeudas != "")
	{
		while($row_seldeudas = mysql_fetch_array($seldeudas)){
		// Si la deuda ya se referencia en un concepto de orden no se toma en cuenta
		// Si no se debe adicionar a la orden de pago
		
		// Las ordenes que se usan para ver si existe la deuda es la del periodo activo
		// Es decir que si generan una orden de pago este tomaria la deuda para cada periodo
		
		if($codigomodalidadacademica != 100){
			$query_selconceptoexiste = "SELECT o.numeroordenpago
			FROM ordenpago o, detalleordenpago d
			where o.codigoestudiante = '$codigoestudiante'
			and o.codigoestadoordenpago like '1%'
			and o.codigoperiodo = '$codigoperiodo'
			and d.numeroordenpago = o.numeroordenpago
			and d.codigoconcepto = '".$row_seldeudas['codigoconcepto']."'";	
		}else{
			$query_selconceptoexiste = "SELECT o.numeroordenpago
			FROM ordenpago o, detalleordenpago d, grupoperiodocarrera g, detallegrupoperiodocarrera dg
			where o.codigoestudiante = '$codigoestudiante'
			and o.codigoestadoordenpago like '1%'
			and o.codigoperiodo = dg.codigoperiodo
			and d.numeroordenpago = o.numeroordenpago
			and d.codigoconcepto = '".$row_seldeudas['codigoconcepto']."'
			and g.codigocarrera = '$codigocarrera'
			and g.idgrupoperiodocarrera = dg.idgrupoperiodocarrera
			and g.fechainiciogrupoperiodocarrera <= '".date("Y-m-d")."'
			and g.fechafinalgrupoperiodocarrera >= '".date("Y-m-d")."'";	
		}
		$selconceptoexiste = mysql_query($query_selconceptoexiste, $sala) or die("$query_selconceptoexiste".mysql_error());
		$totalRows_selconceptoexiste = mysql_num_rows($selconceptoexiste);
		if($totalRows_selconceptoexiste == ""){
			$codigoconceptoarreglo[$guardar] = $row_seldeudas['codigoconcepto'];
			$valorconcepto[$guardar] = $row_seldeudas['valordescuentovsdeuda'];
			$codigotipodetalle[$guardar] = 02; 
			$guardar = $guardar + 1;  
			
			if($row_seldeudas['codigotipoconcepto'] == 01)
			{
				$totalvalormatricula = $totalvalormatricula + $row_seldeudas['valordescuentovsdeuda'];
				$descuento = $descuento + $row_seldeudas['valordescuentovsdeuda'];  
			}
			else if($row_seldeudas['codigotipoconcepto'] == 02)
			{
				$totalvalormatricula = $totalvalormatricula - $row_seldeudas['valordescuentovsdeuda'];
				$saldo = $saldo + $row_seldeudas['valordescuentovsdeuda'];
			}
		}
	}
}
	$codigocarreraantes = $codigocarrera;
	$codigoestudiante = $_SESSION['codigo'];
	require_once('../estadocredito/tomar_saldofavorcontra.php');
   
// Las deudas las debe tomar de la tabla en caso de no haber conexion
if(!is_array($saldoafavor))
{

// Se toman las deudas de la tabla de sala
}else{
	$codigocarreraantes = $codigocarrera;
	$codigoestudianteantes = $codigoestudiante;

	$codigocarrera = $codigocarreraantes;
	$codigoestudiante = $codigoestudianteantes;
	if(isset($saldoafavor)){
		foreach($saldoafavor as $key => $arregloconceptos){
			// Si la deuda ya se referencia en un concepto de orden no se toma en cuenta
			// Si no se debe adicionar a la orden de pago
			
			// Las ordenes que se usan para ver si existe la deuda es la del periodo activo
			// Es decir que si generan una orden de pago este tomaria la deuda para cada periodo
			if($arregloconceptos[0] == $codigocarrera){
				// Convertir positivo				
				$valorsaldofavor=$arregloconceptos[4]*(-1);

				if($codigomodalidadacademica != 100){
					$query_selconceptoexiste = "SELECT o.numeroordenpago
					FROM ordenpago o, detalleordenpago d
					where o.codigoestudiante = '$codigoestudiante'
					and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
					and o.codigoperiodo = '$codigoperiodo'
					and d.numeroordenpago = o.numeroordenpago
					and d.codigoconcepto = '".$arregloconceptos[1]."'";	
				}else{
					$query_selconceptoexiste = "SELECT o.numeroordenpago
					FROM ordenpago o, detalleordenpago d, grupoperiodocarrera g, detallegrupoperiodocarrera dg
					where o.codigoestudiante = '$codigoestudiante'
					and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
					and o.codigoperiodo = dg.codigoperiodo
					and d.numeroordenpago = o.numeroordenpago
					and d.codigoconcepto = '".$arregloconceptos[1]."'
					and g.codigocarrera = '$codigocarrera'
					and g.idgrupoperiodocarrera = dg.idgrupoperiodocarrera
					and g.fechainiciogrupoperiodocarrera <= '".date("Y-m-d")."'
					and g.fechafinalgrupoperiodocarrera >= '".date("Y-m-d")."'";
				}
				$selconceptoexiste = mysql_query($query_selconceptoexiste, $sala) or die("$query_selconceptoexiste".mysql_error());
				$totalRows_selconceptoexiste = mysql_num_rows($selconceptoexiste);
				if($totalRows_selconceptoexiste == ""){
					$codigoconceptoarreglo[$guardar] = $arregloconceptos[1];
					$valorconcepto[$guardar] = $arregloconceptos[4];
					$codigotipodetalle[$guardar] = 02; 
					$guardar = $guardar + 1;  

					$totalvalormatricula.' - '.$valorsaldofavor;
					$totalvalormatricula= $totalvalormatricula - $valorsaldofavor;

					$saldo = ($saldo + $arregloconceptos[4]);
				}
			}
		}
	}
}

// Seleccion de Impuestos a cobrar al estudiante, actualmente esta la ARP, 
// estos impuestos se cobran para el estudiante institucionalmente

// Primero mira si la carrera necesita cobro de ARP
// Las fechas de aplicación de la ARP deben estar dentro de las fechas del periodo
    
$codigocarrera = $codigocarreramatricula; 
    
    
 $query_selcarreraarp = "select a.codigoconcepto, a.porcentajeaplicaarp, a.porcentajeaplicaarp, a.valorfijoaplicaarp, 
c.codigotipoconcepto, p.codigoperiodo, p.fechainicioperiodo, p.fechavencimientoperiodo
from aplicaarp a, concepto c, periodo p
where a.codigocarrera = '$codigocarrera'
and a.semestreinicioaplicaarp <= '$semestrecalculado'
and a.semestrefinalaplicaarp >= '$semestrecalculado'
and a.codigoperiodo = '$codigoperiodo'
and a.codigotipoaplicaarp = '100'
and a.codigoconcepto = c.codigoconcepto
and p.codigoestadoperiodo = '1'";	

$selcarreraarp = mysql_query($query_selcarreraarp, $sala) or die("$query_selcarreraarp".mysql_error());
$totalRows_selcarreraarp = mysql_num_rows($selcarreraarp);
if($totalRows_selcarreraarp != ""){
	while($row_selcarreraarp = mysql_fetch_array($selcarreraarp)){
		// Si la carrera necesita cobro de ARP, entonces se mira si el estudiante ya tiene ARP
		$query_selestudiantearp = "select ea.idestudiantegeneral
		from estudiantearp ea, periodo p
		where ea.idestudiantegeneral = '$idestudiantegeneral'
		and ea.fechainicioestudiantearp >= p.fechainicioperiodo
		and ea.fechafinalestudiantearp <= p.fechavencimientoperiodo
		and p.codigoestadoperiodo = '1'
		and p.fechavencimientoperiodo >= '".date("Y-m-d")."'";	
		$selestudiantearp = mysql_query($query_selestudiantearp, $sala) or die("$query_selestudiantearp".mysql_error());
		$totalRows_selestudiantearp = mysql_num_rows($selestudiantearp);
		if($totalRows_selestudiantearp == "")
		{
			// Si entra quiere decir que al estudiante se le debe cobrar ARP
			
			// Si la deuda ya se referencia en un concepto de orden no se toma en cuenta
			// Si no se debe adicionar a la orden de pago
			
			// Las ordenes que se usan para ver si existe la deuda es la del periodo activo
			// Es decir que si generan una orden de pago este tomaria la deuda para cada periodo
			
			$query_selconceptoexiste = "SELECT o.numeroordenpago
			FROM ordenpago o, detalleordenpago d
			where o.codigoestudiante = '$codigoestudiante'
			and o.codigoestadoordenpago like '1%'
			and o.codigoperiodo = '$codigoperiodo'
			and d.numeroordenpago = o.numeroordenpago
			and d.codigoconcepto = '".$row_selcarreraarp['codigoconcepto']."'";	
			$selconceptoexiste = mysql_query($query_selconceptoexiste, $sala) or die("$query_selconceptoexiste".mysql_error());
			$totalRows_selconceptoexiste = mysql_num_rows($selconceptoexiste);
			if($totalRows_selconceptoexiste == "")
			{
				// Si el concepto no existe entonces se debe insertar
				// Para el calculo de los conceptos se debe manejar las fechas.
				
				// MANEJO DEL LAS FECHAS
				// 1. Si la fecha es menor a la del comienzo del periodo, se debe tomar todo el periodo para la cuenta
				// 2. Si la fecha esta dentro del periodo la cuenta
				
				$fechainicioperiodo = $row_selcarreraarp['fechainicioperiodo'];
				$fechavencimientoperiodo = $row_selcarreraarp['fechavencimientoperiodo'];
				

				$codigoconceptoarreglo[$guardar] = $row_selcarreraarp['codigoconcepto'];
				$valoracobrar = round($row_selcarreraarp['valorfijoaplicaarp'],-2);
				//$valoracobrar = round($row_selcarreraarp['valorfijoaplicaarp']*$diasacobrar/$diasperiodo,-2);
				$valorconcepto[$guardar] = $valoracobrar;
				$codigotipodetalle[$guardar] = 03; 
				$guardar = $guardar + 1;  
				
				if($row_selcarreraarp['codigotipoconcepto'] == 01)
				{
					$totalvalormatricula = $totalvalormatricula + $valoracobrar;
					$descuento = $descuento + $valoracobrar;
				}
				else if($row_selcarreraarp['codigotipoconcepto'] == 02)
				{
					$totalvalormatricula = $totalvalormatricula - $valoracobrar;
					$saldo = $saldo + $valoracobrar;
				}
			}
		}
		else
		{
			// Al estudiante no se le cobra ARP
			break;
		}
	}
}


// Código par generar la primera cuota
if($generarordenprimeracuota)
{
	require_once("plan_pagos.php");
	if(isset($saldoencontra))
	{
		foreach($saldoencontra as $key => $arregloconceptos)
		{
			// Si la deuda ya se referencia en un concepto de orden no se toma en cuenta
			// Si no se debe adicionar a la orden de pago
			
			// Las ordenes que se usan para ver si existe la deuda es la del periodo activo
			// Es decir que si generan una orden de pago este tomaria la deuda para cada periodo
			if($arregloconceptos[0] == $codigocarrera)
			{
				$debemodificarplandepago = true;

				$codigoconceptoarreglo[$guardar] = $arregloconceptos[1];
				$valorconcepto[$guardar] = round($arregloconceptos[4],0);
				$query_tipoconcepto="SELECT codigotipodetalleordenpago 
				from detalleordenpago
				where codigoconcepto = '".$arregloconceptos[1]."'
				and numeroordenpago = '$numerorodenpagoplandepagosap'";
				$tipoconcepto=mysql_query($query_tipoconcepto,$sala) or die("$query_tipoconcepto<br>".mysql_error());
				$row_tipoconcepto=mysql_fetch_array($tipoconcepto);
				if($row_tipoconcepto == ""){
					$codigotipodetalle[$guardar] = 2;
				}else{
					$codigotipodetalle[$guardar] = 3;
				}
				$guardar = $guardar + 1;
				$totalvalormatricula = $totalvalormatricula + $arregloconceptos[4];
			}
		}
		$debecobrarpecuniarios = false;

		foreach($valorconcepto as $key => $value){
			$codigoconceptoarreglo[$guardar] = $key;
			$valorconcepto[$guardar] = $value;
			$codigotipodetalle[$guardar] = 2;
			$guardar = $guardar + 1;
		}
		
		if($debemodificarplandepago){
			// Hacerle update al plan de pagos para colocar la nueva orden
			$query_updordenpagopp = "UPDATE ordenpagoplandepago 
			SET numerorodencoutaplandepagosap = '$numeroordenpago'
			WHERE numerorodenpagoplandepagosap = '$numerorodenpagoplandepagosap'
			and numerorodencoutaplandepagosap like '1%'
			and codigoestado like '1%'";
			$updordenpagopp = mysql_db_query($database_sala,$query_updordenpagopp) or die("$query_updordenpagopp");
		}
	}
}

if($debecobrarpecuniarios){
	foreach($pecuniariosacobrar as $codigodelpecuniario => $valordelpecuniario){
		$totalvalormatricula = $totalvalormatricula + $valordelpecuniario;
		$valorpecuniario = $valorpecuniario + $valordelpecuniario;	
		$codigoconceptoarreglo[$guardar] = $codigodelpecuniario;
		$valorconcepto[$guardar] = $valordelpecuniario;
		$codigotipodetalle[$guardar] = 03; 
		$guardar = $guardar + 1;
	}
}

// Seleccion de descuentos por estudiante
$query_seldescuentoestudiante = "select d.codigoconcepto, d.porcentajedescuentoeducacioncontinuada, d.codigotipodescuentoeducacioncontinuada, 100 AS codigoindicadordescuentouniversidad 
from descuentoestudianteeducacioncontinuada de, descuentoeducacioncontinuada d
where de.iddescuentoeducacioncontinuada = d.iddescuentoeducacioncontinuada
and de.codigoestudiante = '$codigoestudiante'
and de.fechadesdedescuentoestudianteeducacioncontinuada <= '".date("Y-m-d")."'
and de.fechahastadescuentoestudianteeducacioncontinuada >= '".date("Y-m-d")."'
and d.fechadesdedescuentoeducacioncontinuada <= '".date("Y-m-d")."'
and d.fechahastadescuentoeducacioncontinuada >= '".date("Y-m-d")."'
union
select d.codigoconcepto, d.porcentajedescuentoeducacioncontinuada, d.codigotipodescuentoeducacioncontinuada, dc.codigoindicadordescuentouniversidad
from descuentocarreraeducacioncontinuada dc, descuentoeducacioncontinuada d
where dc.iddescuentoeducacioncontinuada = d.iddescuentoeducacioncontinuada
and dc.codigocarrera = '$codigocarrera'
and dc.fechadesdedescuentocarreraeducacioncontinuada <= '".date("Y-m-d")."'
and dc.fechahastadescuentocarreraeducacioncontinuada >= '".date("Y-m-d")."'
and d.fechadesdedescuentoeducacioncontinuada <= '".date("Y-m-d")."'
and d.fechahastadescuentoeducacioncontinuada >= '".date("Y-m-d")."'
union
select d.codigoconcepto, d.porcentajedescuentoeducacioncontinuada, d.codigotipodescuentoeducacioncontinuada, 100 AS codigoindicadordescuentouniversidad
from descuentogrupoeducacioncontinuada dg, descuentoeducacioncontinuada d
where dg.iddescuentoeducacioncontinuada = d.iddescuentoeducacioncontinuada
and dg.idgrupo = '$idgrupofinal'
and dg.fechadesdedescuentogrupoeducacioncontinuada <= '".date("Y-m-d")."'
and dg.fechahastadescuentogrupoeducacioncontinuada >= '".date("Y-m-d")."'
and d.fechadesdedescuentoeducacioncontinuada <= '".date("Y-m-d")."'
and d.fechahastadescuentoeducacioncontinuada >= '".date("Y-m-d")."'";	
$seldescuentoestudiante = mysql_query($query_seldescuentoestudiante, $sala) or die("$query_seldescuentoestudiante".mysql_error());
$totalRows_seldescuentoestudiante = mysql_num_rows($seldescuentoestudiante);
	if($totalRows_seldescuentoestudiante != ""){
		$valorfinaldescuento = 0;
		while($row_seldescuentoestudiante = mysql_fetch_array($seldescuentoestudiante)){
			// De todos los conceptos tomo el mayor
			// Las ordenes que se usan para ver si existe la deuda es la del periodo activo
			// Es decir que si generan una orden de pago este tomaria la deuda para cada periodo
			if(ereg("^2.+$",$row_seldescuentoestudiante['codigotipodescuentoeducacioncontinuada'])){
				$valorcalculadodescuento = $row_seldescuentoestudiante['porcentajedescuentoeducacioncontinuada'];
			}else{
				// En el arreglo en el $valorconcepto[0] esta el valor bruto de la matricula
				$valorcalculadodescuento = $valorconcepto[0]*$row_seldescuentoestudiante['porcentajedescuentoeducacioncontinuada']/100;
			}
			if(ereg("^1.+$",$row_seldescuentoestudiante['codigoindicadordescuentouniversidad'])){
				if($valorfinaldescuento < $valorcalculadodescuento){
					$valorfinaldescuento = $valorcalculadodescuento;
					$codigoconcepto = $row_seldescuentoestudiante['codigoconcepto'];
				}
			}else{
				// Si el estudiante esta en otra carrera o su sitiacion es diferente a las siguientes
				if(($codigosituacioncarreraestudiante != 105 && $codigosituacioncarreraestudiante != 106 && $codigosituacioncarreraestudiante != 107) || $totalRows_selcarrerasestudiante > 1)
				{
					if($valorfinaldescuento < $valorcalculadodescuento)
					{
						$valorfinaldescuento = $valorcalculadodescuento;
						$codigoconcepto = $row_seldescuentoestudiante['codigoconcepto'];
					}
				}
			}
			// Si la deuda ya se referencia en un concepto de orden no se toma en cuenta
			// Si no se debe adicionar a la orden de pago
		}

		if($codigomodalidadacademica != 100){
			$query_selconceptoexiste = "SELECT o.numeroordenpago
			FROM ordenpago o, detalleordenpago d
			where o.codigoestudiante = '$codigoestudiante'
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
			and o.codigoperiodo = '$codigoperiodo'
			and d.numeroordenpago = o.numeroordenpago
			and d.codigoconcepto = '$codigoconcepto'";
		}else{
			$query_selconceptoexiste = "SELECT o.numeroordenpago
			FROM ordenpago o, detalleordenpago d, grupoperiodocarrera g, detallegrupoperiodocarrera dg
			where o.codigoestudiante = '$codigoestudiante'
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
			and o.codigoperiodo = dg.codigoperiodo
			and d.numeroordenpago = o.numeroordenpago
			and d.codigoconcepto = '$codigoconcepto'
			and g.codigocarrera = '$codigocarrera'
			and g.idgrupoperiodocarrera = dg.idgrupoperiodocarrera
			and g.fechainiciogrupoperiodocarrera <= '".date("Y-m-d")."'
			and g.fechafinalgrupoperiodocarrera >= '".date("Y-m-d")."'";
		}

		$selconceptoexiste = mysql_query($query_selconceptoexiste, $sala) or die("$query_selconceptoexiste".mysql_error());
		$totalRows_selconceptoexiste = mysql_num_rows($selconceptoexiste);
		if($totalRows_selconceptoexiste == ""){
			$codigoconceptoarreglo[$guardar] = $codigoconcepto;
			$valorconcepto[$guardar] = $valorfinaldescuento;
			$codigotipodetalle[$guardar] = 02;
			$guardar = $guardar + 1;

			$totalvalormatricula = $totalvalormatricula - $valorfinaldescuento;
			$saldo = $saldo + $valorfinaldescuento;
		}
	}
}


if($generarordenprimeracuota){
	$totalvalormatricula = 0;
}

$query_selsubperiodo="SELECT s.idsubperiodo
FROM periodo p, carreraperiodo cp, subperiodo s,estudiante e
WHERE p.codigoperiodo  = cp.codigoperiodo
AND s.idcarreraperiodo = cp.idcarreraperiodo
AND cp.codigocarrera = e.codigocarrera
AND e.codigoestudiante = '$codigoestudiante'
AND fechainiciofinancierosubperiodo <= '".date("Y-m-d")."'
AND fechafinalfinancierosubperiodo >= '".date("Y-m-d")."'";
$selsubperiodo=mysql_query($query_selsubperiodo,$sala) or die("$query_selsubperiodo<br>".mysql_error());
$row_selsubperiodo=mysql_fetch_array($selsubperiodo);	

for($i = 0; $i < $guardar; $i++){
	if($valorconcepto[$i] > 0){
		$query_concept = "select * 
		from cobroconcepto 
		where codigoconcepto = '".$codigoconceptoarreglo[$i]."'
		and  idsubperiodo = '".$row_selsubperiodo['idsubperiodo']."'
		and fechavencimientocobroconcepto >= now()
		and codigoestado like '1%'";		
		$concept = mysql_db_query($database_sala,$query_concept) or die("$query_concept");
		$totalRows_concept = mysql_num_rows($concept);
	 	$row_concept=mysql_fetch_array($concept);			
		

		if ($row_concept <> ""){
			if ($row_concept['codigotipocobroconcepto'] == 1){
				$valorconcepto[$i] = $valorconcepto[$i] * ( $row_concept['valorcobroconcepto'] / 100 );
			}else if ($row_concept['codigotipocobroconcepto'] == 2){
				$valorconcepto[$i] = $row_concept['valorcobroconcepto'] * $creditoscalculados;
			}
			$totalvalormatricula = $valorconcepto[$i];
		}
		
		if($generarordenprimeracuota){
			$query_insdetalleordenpago = "insert into detalleordenpago(numeroordenpago,codigoconcepto,cantidaddetalleordenpago,valorconcepto,codigotipodetalleordenpago)
			VALUES('$numeroordenpago','".$codigoconceptoarreglo[$i]."',1,'".$valorconcepto[$i]."','".$codigotipodetalle[$i]."')"; 
			$insdetalleordenpago = mysql_query($query_insdetalleordenpago,$sala);
			
			if($insdetalleordenpago){
				$totalvalormatricula = $totalvalormatricula + $valorconcepto[$i];
			}
		}else{
			for ($i=0;$i<count($valorconcepto);$i++ ) {
   				$query_insdetalleordenpago = "insert into detalleordenpago(numeroordenpago,codigoconcepto,cantidaddetalleordenpago,valorconcepto,codigotipodetalleordenpago)
				VALUES('$numeroordenpago','".$codigoconceptoarreglo[$i]."',1,'".$valorconcepto[$i]."','".$codigotipodetalle[$i]."')";
				$insdetalleordenpago = mysql_query($query_insdetalleordenpago,$sala) or die("$query_insdetalleordenpago");
			}//for
		}
	}	
}//for


if($procesoautomatico){
	require("../validarfecha.php");
}else{
	require("validarfecha.php");
}
?>

