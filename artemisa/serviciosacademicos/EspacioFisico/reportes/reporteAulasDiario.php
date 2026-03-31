<?php
	function DiasSemana($Fecha,$Op=''){
        if($Op=='Nombre'){
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        }else{
            $dias = array('','1','2','3','4','5','6','7');
        }        
        $fecha = $dias[date('N', strtotime($Fecha))];        
        return $fecha;
	}//  function DiasSemana
	function dameFecha($fecha,$dia){
			list($year,$mon,$day) = explode('-',$fecha);
			return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));
	}//function dameFecha
	session_start();
	include("../templates/template.php");
	//include_once('../../mgi/Menu.class.php');
	//include_once('../Interfas/InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();
	$db = writeHeader('Reportes Espacio Fisico',true);
	/* Arreglo de horas */
	$FechaInicio = $_REQUEST['FechaInicio'];
	$FechaFin = $_REQUEST['FechaFin'];
	$nuevafecha = $FechaInicio;
	$horas = array();
	$p=0;
	for($i=6;$i<=22;$i++){
		$horas[$p] = $i.':00';
		$p++;
	}
	/** Consulta Aulas */	
		$SQL = 'SELECT
					ccc.Nombre
				FROM
					ClasificacionEspacios c
				INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspacionPadreId = c.ClasificacionEspaciosId
				INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspacionPadreId = cc.ClasificacionEspaciosId
				AND c.codigoestado = 100
				AND cc.codigoestado = 100
				AND ccc.codigoestado = 100
				AND c.ClasificacionEspaciosId = '.$_REQUEST['sede'];	
	if($Resultado=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos'.$SQL;
		die;
	}
	$aulas = $Resultado->getarray();
	$i = 1;
	$dias = array();
	if($FechaInicio != $FechaFin){
		while($nuevafecha <= $FechaFin){
			$dias[$i] = DiasSemana($nuevafecha, 'Nombre');
			$nuevafecha = strtotime('+'.$i.' day',strtotime($FechaInicio));
			$nuevafecha = date('Y-m-d', $nuevafecha);
			$i++;
		}
	}
?>
<html>
<head>
	<style>
		.resultado_ocupacion th, td{
			border: 1px solid #000;
			padding: 5px;
		}
		.ocupado{
			background-color: #D66B6B;
			color:#fff;
		}
	</style>
	<link href="../css/tooltip.css" rel="stylesheet" type="text/css" />
    
</head>
	<body>
		<table class="resultado_ocupacion">
			<tr>
				<td colspan="2">Convenciones</td>
			</tr>
			<tr>
				<td>No Asignado</td><td></td>
			</tr>
			<tr>
				<td>Asignado</td><td class="ocupado"></td>
			</tr>
			<tr>
				<td>Asignado no ocupado</td><td class="ocupado">X</td>
			</tr>
		</table>
		<table class="tableWithFloatingHeader resultado_ocupacion" border="1" align="center">
			<thead class="persist-header">
				<th width="141px">Salones / Horarios</th>
				<th>6 - 7</th>
				<th>7 - 8</th>
				<th>8 - 9</th>
				<th>9 - 10</th>
				<th>10 - 11</th>
				<th>11 - 12</th>
				<th>12 - 13</th>
				<th>13 - 14</th>
				<th>14 - 15</th>
				<th>15 - 16</th>
				<th>16 - 17</th>
				<th>17 - 18</th>
				<th>18 - 19</th>
				<th>19 - 20</th>
				<th>20 - 21</th>				
				<th>21 - 22</th>				
			</thead>	
			<?php
				$p = 0;
				$h = 6;
				$buscar = array(" ", "á", "é", "í", "ó", "ú", "(", ")");
				if(!empty($dias)){
					foreach($aulas as $a){
						$p = 0;
						foreach($dias as $d){
							$h=6;
							echo '<tr>';
							echo '<td>'.$a['Nombre'].' - '.$d.'</td>';
							echo '<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'" ></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>
							<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'-'.$p.'"></td>';
							echo '</tr>';
							$p++;
						}
						$h=6;
					}
				}else{
					foreach($aulas as $a){
						echo '<tr>';
						echo '<td>'.$a['Nombre'].'</td>';
						echo '<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'" ></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>
						<td id="'.str_replace($buscar, '', $a['Nombre']).'-'.$h++.'"></td>';
						echo '</tr>';
						$p++;
						$h=6;
					}
				}
			?>	
		</table>
		<table class="resultado_ocupacion">
			<tr>
				<td colspan="2">Convenciones</td>
			</tr>
			<tr>
				<td>No Asignado</td><td></td>
			</tr>
			<tr>
				<td>Asignado</td><td class="ocupado"></td>
			</tr>
			<tr>
				<td>Asignado no ocupado</td><td class="ocupado">X</td>
			</tr>
		</table>
		<?php 
		if(empty($dias)){
		?>
		<div style="display:none" id="oculto_salones">
			<?php
				$a=6;
				for($i=0;$i<17;$i++){
					$SQL = 'SELECT
								l.Ocupado,
								c.Nombre AS Aula,
								a.AsignacionEspaciosId
							FROM
								AsignacionEspacios a
							INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
							INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
							INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
							AND ccc.ClasificacionEspaciosId = '.$_REQUEST['sede'].'
							INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
							INNER JOIN carrera car ON s.codigocarrera = car.codigocarrera
							LEFT JOIN LogsMonitoreosEspaciosFisicos l ON a.AsignacionEspaciosId = l.AsignacionEspaciosId
							WHERE
								a.codigoestado = 100
							AND c.codigoestado = 100
							AND cc.codigoestado = 100
							AND ccc.codigoestado = 100
							AND a.FechaAsignacion = "'.$FechaInicio.'"
							AND c.ClasificacionEspaciosId <> 212
							AND (HoraInicio BETWEEN "'.$horas[$i].'" AND "'.$horas[$i+1].'" OR HoraFin BETWEEN "'.$horas[$i].'" AND "'.$horas[$i+1].'")
							AND HoraFin <> "'.$horas[$i].'"
							ORDER BY HoraInicio, HoraFin, c.Nombre';
					if($Resultado=&$db->Execute($SQL)===false){
						echo 'Error en consulta a base de datos'.$SQL;
						die;
					}
					$ocupaciones = $Resultado->getarray();
					foreach($ocupaciones as $o){
						echo ','.str_replace($buscar, '', $o['Aula']).'-'.$a.'|'.$o['AsignacionEspaciosId'];
						if($o['Ocupado'] != '' && $o['Ocupado'] == '0'){
							echo ',no';
						}							
					}
					$a++;
				}
			?>
		</div>
		<script>
			var salones = $('#oculto_salones').html();
			salones = salones.split(",");
			$.each(salones,function(i){
				if(i != 0){
					var salon = salones[i].split("|");
					$('#'+salon[0]).addClass('ocupado');
					$('#'+salon[0]).attr('onclick', 'tooltip.ajax(this, \'../reportes/peticiones_ajax.php?actionID=detalleAula&aula='+salon[1]+'\');');
					if(salones[i+1] == 'no'){
						$('#'+salon[0]).html('X');
						i++;
					}					
				}
			});
		</script>
		<?php 
		}else{
		?>
		<div style="display:none;" id="oculto_salones">
			<?php
				$nuevafecha = $FechaInicio;
				$d=0;
				while($nuevafecha <= $FechaFin){					
					$a=6;
					for($i=0;$i<17;$i++){
						$SQL = 'SELECT
									l.Ocupado,
									c.Nombre AS Aula,
									a.AsignacionEspaciosId
								FROM
									AsignacionEspacios a
								INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
								INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
								INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
								AND ccc.ClasificacionEspaciosId = '.$_REQUEST['sede'].'
								INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
								INNER JOIN carrera car ON s.codigocarrera = car.codigocarrera
								LEFT JOIN LogsMonitoreosEspaciosFisicos l ON a.AsignacionEspaciosId = l.AsignacionEspaciosId
								WHERE
									a.codigoestado = 100
								AND c.codigoestado = 100
								AND cc.codigoestado = 100
								AND ccc.codigoestado = 100
								AND a.FechaAsignacion = "'.$nuevafecha.'"
								AND c.ClasificacionEspaciosId <> 212
								AND (HoraInicio BETWEEN "'.$horas[$i].'" AND "'.$horas[$i+1].'" OR HoraFin BETWEEN "'.$horas[$i].'" AND "'.$horas[$i+1].'")
								AND HoraFin <> "'.$horas[$i].'"
								ORDER BY HoraInicio, HoraFin, c.Nombre';								
						if($Resultado=&$db->Execute($SQL)===false){
							echo 'Error en consulta a base de datos'.$SQL;
							die;
						}
						$ocupaciones = $Resultado->getarray();
						foreach($ocupaciones as $o){
							echo ','.str_replace($buscar, '', $o['Aula']).'-'.$a.'-'.$d.'|'.$o['AsignacionEspaciosId'];
							if($o['Ocupado'] != '' && $o['Ocupado'] == '0'){
								echo ',no';
							}							
						}
						$a++;
					}
					$d++;
					$nuevafecha = strtotime('+'.$d.' day',strtotime($FechaInicio));
					$nuevafecha = date('Y-m-d', $nuevafecha);
				}
			?>
		</div>
		<script>
			var salones = $('#oculto_salones').html();			
			salones = salones.split(",");
			$.each(salones,function(i){
				if(i != 0){
					var salon = salones[i].split("|");
					$('#'+salon[0]).addClass('ocupado');
					$('#'+salon[0]).attr('onclick', 'tooltip.ajax(this, \'../reportes/peticiones_ajax.php?actionID=detalleAula&aula='+salon[1]+'\');');
					if(salones[i+1] == 'no'){
						$('#'+salon[0]).html('X');
						i++;
					}					
				}
			});
		</script>		
		<?php
		}
		?>
		<script>
			function _UpdateTableHeadersScroll() {
				$("div.divTableWithFloatingHeader").each(function() {
					var originalHeaderRow = $(".tableFloatingHeaderOriginal", this);
					var floatingHeaderRow = $(".tableFloatingHeader", this);
					var offset = $(this).offset();
					var scrollTop = $(window).scrollTop();
					// check if floating header should be displayed
					if ((scrollTop > offset.top) && (scrollTop < offset.top + $(this).height() - originalHeaderRow.height())) {
						floatingHeaderRow.css("visibility", "visible");
						floatingHeaderRow.css("left", -$(window).scrollLeft());
					}
					else {
						floatingHeaderRow.css("visibility", "hidden");
					}
				});
			}


			function _UpdateTableHeadersResize() {
				$("div.divTableWithFloatingHeader").each(function() {
					var originalHeaderRow = $(".tableFloatingHeaderOriginal", this);
					var floatingHeaderRow = $(".tableFloatingHeader", this);

					// Copy cell widths from original header
					$("th", floatingHeaderRow).each(function(index) {
						var cellWidth = $("th", originalHeaderRow).eq(index).css('width');
						//$(this).css('width', cellWidth);
					});

					// Copy row width from whole table
					floatingHeaderRow.css("width", Math.max(originalHeaderRow.width(), $(this).width()) + "px");
					floatingHeaderRow.css("background-color", "#fff");

				});
			}


			function ActivateFloatingHeaders(selector_str){
				$(selector_str).each(function() {
					$(this).wrap("<div class=\"divTableWithFloatingHeader\" style=\"position:relative\"></div>");

					// use first row as floating header by default
					var floatingHeaderSelector = "thead:first";
					var explicitFloatingHeaderSelector = "thead.floating-header"
					if ($(explicitFloatingHeaderSelector, this).length){
						floatingHeaderSelector = explicitFloatingHeaderSelector;
					}

					var originalHeaderRow = $(floatingHeaderSelector, this).first();
					var clonedHeaderRow = originalHeaderRow.clone()
					originalHeaderRow.before(clonedHeaderRow);

					clonedHeaderRow.addClass("tableFloatingHeader");
					clonedHeaderRow.css("position", "fixed");
					// not sure why but 0px is used there is still some space in the top
					clonedHeaderRow.css("top", "-2px");
					clonedHeaderRow.css("margin-left", $(this).offset().left);
					clonedHeaderRow.css("visibility", "hidden");

					originalHeaderRow.addClass("tableFloatingHeaderOriginal");
				});
				_UpdateTableHeadersResize();
				_UpdateTableHeadersScroll();
				$(window).scroll(_UpdateTableHeadersScroll);
				$(window).resize(_UpdateTableHeadersResize);
			}
			$(document).ready(function (){
				ActivateFloatingHeaders("table.tableWithFloatingHeader");				
			});
		</script>
	</body>
<html>