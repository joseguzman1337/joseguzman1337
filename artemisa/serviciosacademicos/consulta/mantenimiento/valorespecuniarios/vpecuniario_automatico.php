<?php
	$rutaado=("../../../funciones/adodb/");
	require_once("../../../Connections/salaado-pear.php");
	require_once('../../../funciones/clases/autenticacion/redirect.php');

	class vpecuniario_automatico extends ADODB_Active_Record	{
	var $conexion;
	var $fechahoy;

	function vpecuniario_automatico($conexion){
		$this->conexion=$conexion;
		$this->fechahoy=date("Y-m-d H:i:s");
	}

	function facturavalorpecuniario_copia($codigoperiodo_inicio,$codigoperiodo_destino){
		$contador_loop=0;
		$query_seleccion_valorpecuniario="SELECT codigoconcepto, valorpecuniario, codigoindicadorprocesointernet, codigoestado
		FROM valorpecuniario WHERE codigoperiodo =".$codigoperiodo_inicio;
		$seleccion_valorpecuniario=$this->conexion->query($query_seleccion_valorpecuniario);
		$row_seleccion_valorpecuniario=$seleccion_valorpecuniario->fetchRow();
		do{
			$queryexiste = "SELECT idvalorpecuniario, codigoestado from valorpecuniario where codigoperiodo = ".$codigoperiodo_destino."
			and codigoconcepto = '".$row_seleccion_valorpecuniario['codigoconcepto']."'
			and valorpecuniario = '".$row_seleccion_valorpecuniario['valorpecuniario']."'
			and codigoindicadorprocesointernet = ".$row_seleccion_valorpecuniario['codigoindicadorprocesointernet']."
			and codigoestado = ".$row_seleccion_valorpecuniario['codigoestado']."";
			$valorpecuniario=$this->conexion->query($queryexiste);
			$row_valorpecuniario=$valorpecuniario->fetchRow();

			if(isset($row_valorpecuniario['idvalorpecuniario']) && !empty($row_valorpecuniario['idvalorpecuniario'])){
				$idvalorpecuniario = $row_valorpecuniario['idvalorpecuniario'];
			}else{
				//crea registro en la tabla de valorpecuniario para el nuervo periodo
				$query_inserccion="INSERT INTO valorpecuniario
				VALUES ('','$codigoperiodo_destino','".$row_seleccion_valorpecuniario['codigoconcepto']."','".
				$row_seleccion_valorpecuniario['valorpecuniario']."','".$row_seleccion_valorpecuniario['codigoindicadorprocesointernet']."','".
				$row_seleccion_valorpecuniario['codigoestado']."');";
				$inserccion=$this->conexion->query($query_inserccion);
				//Obtiene el id del registro
				$idvalorpecuniario=$this->LastInsertID($this->conexion,'idvalorpecuniario');
			}

			if($contador_loop==0){
				$codigoperiodosql = $codigoperiodo_inicio;
			}else{
				$codigoperiodosql = $codigoperiodo_destino;
			}
			//consulta davlores de la factura valor pecuniario
			$query_seleccion_factura="SELECT nombrefacturavalorpecuniario, codigocarrera FROM facturavalorpecuniario fvp WHERE
			fvp.codigoperiodo=$codigoperiodosql ORDER BY fvp.codigocarrera ";
			$operacion_seleccion_factura=$this->conexion->query($query_seleccion_factura);
			$row_operacion_seleccion_factura=$operacion_seleccion_factura->fetchRow();
			do{
				if($contador_loop==0){
					$queryexistefactura = "SELECT idfacturavalorpecuniario FROM facturavalorpecuniario where codigoperiodo = ".$codigoperiodo_destino."
					and codigocarrera = ".$row_operacion_seleccion_factura['codigocarrera']."";
					$facturaexiste=$this->conexion->query($queryexistefactura);
					$row_facturaexiste=$facturaexiste->fetchRow();
					if(isset($row_facturaexiste['idfacturavalorpecuniario']) && !empty($row_facturaexiste['idfacturavalorpecuniario'])){
							$idfacturavalorpecuniario = $row_facturaexiste['idfacturavalorpecuniario'];
					}else{
						//crea los valores de la factura
						$query_inserccion="INSERT INTO facturavalorpecuniario
						VALUES ('','".$codigoperiodo_destino."','$this->fechahoy','".$codigoperiodo_destino."','".$row_operacion_seleccion_factura['codigocarrera']."')";
						$operacion_inserccion=$this->conexion->query($query_inserccion);
						$idfacturavalorpecuniario=$this->LastInsertID($this->conexion,'idfacturavalorpecuniario');
					}
				}else{
					//consulta el id de la factura
					$query_seleccion="SELECT idfacturavalorpecuniario FROM facturavalorpecuniario
					WHERE codigocarrera='".$row_operacion_seleccion_factura['codigocarrera']."'	AND codigoperiodo=".$codigoperiodo_destino."";
					$seleccion=$this->conexion->query($query_seleccion);
					$row_seleccion=$seleccion->fetchRow();
					$idfacturavalorpecuniario=$row_seleccion['idfacturavalorpecuniario'];
				}

				$query_seleccion_dfvp="SELECT dfvp.codigotipoestudiante, vp.codigoconcepto, dfvp.codigoestado
				FROM facturavalorpecuniario fvp, detallefacturavalorpecuniario dfvp, valorpecuniario vp
				WHERE fvp.codigocarrera='".$row_operacion_seleccion_factura['codigocarrera']."'
				AND fvp.codigoperiodo='".$codigoperiodo_inicio."' AND fvp.idfacturavalorpecuniario=dfvp.idfacturavalorpecuniario
				AND vp.idvalorpecuniario=dfvp.idvalorpecuniario ORDER BY fvp.codigocarrera";
				$operacion_seleccion_dfvp=$this->conexion->query($query_seleccion_dfvp);
				$row_seleccion_dfvp=$operacion_seleccion_dfvp->fetchRow();

				do{
					$query_busca_x_concepto="SELECT idvalorpecuniario FROM valorpecuniario vp
					WHERE codigoperiodo='$codigoperiodo_destino'
					AND codigoconcepto='".$row_seleccion_dfvp['codigoconcepto']."'";
					$busca_x_concepto=$this->conexion->query($query_busca_x_concepto);
					$row_busca_x_concepto=$busca_x_concepto->fetchRow();
					if($row_busca_x_concepto['idvalorpecuniario']!=""){
						$queryexistedetalle = "SELECT iddetallefacturavalorpecuniario FROM 	detallefacturavalorpecuniario
						WHERE idfacturavalorpecuniario = ".$idfacturavalorpecuniario."
						AND idvalorpecuniario = ".$row_busca_x_concepto['idvalorpecuniario']."
						AND codigotipoestudiante = ".$row_seleccion_dfvp['codigotipoestudiante']."
						AND codigoestado = ".$row_seleccion_dfvp['codigoestado']."";
						$conceptoexiste=$this->conexion->query($queryexistedetalle);
						$row_conceptoexiste=$conceptoexiste->fetchRow();
						if(!isset($row_conceptoexiste['iddetallefacturavalorpecuniario']) && empty($row_conceptoexiste['iddetallefacturavalorpecuniario'])){
							$query_inserccion_dfvp="INSERT INTO detallefacturavalorpecuniario
							VALUES ('','$idfacturavalorpecuniario','".$row_busca_x_concepto['idvalorpecuniario']."','".
							$row_seleccion_dfvp['codigotipoestudiante']."','".$row_seleccion_dfvp['codigoestado']."')";
							$inserccion_dfvp=$this->conexion->query($query_inserccion_dfvp);
						}
					}//if
				}//do
				while($row_seleccion_dfvp=$operacion_seleccion_dfvp->fetchRow());
			}//do
			while ($row_operacion_seleccion_factura=$operacion_seleccion_factura->fetchRow());
			$contador_loop++;
		}//do
		while($row_seleccion_valorpecuniario=$seleccion_valorpecuniario->fetchRow());
	}//function facturavalorpecuniario_copia

	function escribir_cabeceras($matriz){
		echo "<tr>\n";
		while($elemento = each($matriz)){
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}//function escribir_cabeceras

	function tabla($matriz,$texto=""){
		if(is_array($matriz)){
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP>$texto</caption>";
			$this->escribir_cabeceras($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++){
				echo "<tr>\n";
				while($elemento=each($matriz[$i])){
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}else{
			echo $texto." Matriz no valida<br>";
		}
	}//function tabla
}//class vpecuniario_automatico

$valorpecuniario=new vpecuniario_automatico($sala);
$valorpecuniario->facturavalorpecuniario_copia($_GET['codigoperiodo'],$_GET['codigoperiododestino']);
