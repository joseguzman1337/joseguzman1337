<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
class objetosHTML {
	function __construct(){
		
		require('../Connections/sala2.php');
		$rutaado = "../funciones/adodb/";
		require('../Connections/salaado.php');
		//var_dump($db);
		$this->_db =$db;
	}
	function optionsSelect($valueDef="", $consulta) {
		$res = $this->_db->Execute($consulta);
		//var_dump($res);
		//var_dump($valueDef);
		$selected="";
		$options="<option value=''>Seleccione...</option>";
		if($consulta) {
			while ($row = $res->FetchRow()) {
					$selected=(trim($valueDef)==trim($row[0]))?"selected":"";	
				$options.="<option value='".$row[0]."' ".$selected.">".$row[1]."</option>";
			}
		}
		return $options;
	}
	function select($titulo="", $nombre="", $valueDef="", $requerido=0, $consulta, $ancho, $funcion, $contenidoFuncion) {
		$c_ancho=($ancho)?"style='width:".$ancho."px'":"";
		$c_funcion=($funcion)?"onchange='".$funcion."'":"";
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
		$cadena=($funcion)?"<script>".$contenidoFuncion."</script>":"";
		$cadena.="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<select id='".$nombre."' name='".$nombre."' title='".$c_titulo."' ".$c_requerido." ".$c_ancho." ".$c_funcion.">";
		if($consulta)
			$cadena.=$this->optionsSelect($valueDef, $consulta);
		$cadena.="</select>";
		return $cadena;
	}
	function textBox($titulo="", $nombre="", $valueDef="", $requerido=0, $ancho, $posicionTexto, $longitudMin, $longitudMax) {
		$c_ancho=($ancho)?"size='".$ancho."'":"";
		$c_posicionTexto=($posicionTexto)?"style='text-align:".$posicionTexto."'":"";
		$c_longitudMin=($longitudMin)?"minlength='".$longitudMin."'":"";
		$c_longitudMax=($longitudMax)?"maxlength='".$longitudMax."'":"";
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido.";
			if($longitudMin)
				$c_titulo.=" Mínimo (".$longitudMin.") caracteres.";
			if($longitudMax)
				$c_titulo.=" Máximo (".$longitudMax.") caracteres.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
		$cadena="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<input type='text' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' ".$c_ancho." ".$c_requerido." ".$c_longitudMin." ".$c_longitudMax." ".$c_posicionTexto.">";
		return $cadena;
	}
	function numberBox($titulo="", $nombre="", $valueDef="", $requerido=0, $ancho=30, $posicionTexto="left", $longitudMin="", $longitudMax="", $readonly="") {
		$c_ancho=($ancho)?"size='".$ancho."'":"";
		$c_posicionTexto=($posicionTexto)?"style='text-align:".$posicionTexto."'":"";
		$c_longitudMin=($longitudMin)?"minlength='".$longitudMin."'":"";
		$c_longitudMax=($longitudMax)?"maxlength='".$longitudMax."'":"";
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido y debe ser numérico.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo="El campo ".$titulo." debe ser numérico.";
			$c_asterisco="&nbsp;";
		}
		if($longitudMin)
			$c_titulo.=" Mínimo (".$longitudMin.") caracteres.";
		if($longitudMax)
			$c_titulo.=" Máximo (".$longitudMax.") caracteres.";
		$cadena="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<input type='number' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' ".$c_ancho." ".$c_requerido." ".$c_longitudMin." ".$c_longitudMax." ".$c_posicionTexto." ".$readonly.">";
		return $cadena;
	}
	function emailBox($titulo="", $nombre="", $valueDef="", $requerido=0, $ancho, $posicionTexto) {
		$c_ancho=($ancho)?"size='".$ancho."'":"";
		$c_posicionTexto=($posicionTexto)?"style='text-align:".$posicionTexto."'":"";
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido y debe ser tipo email.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo="El campo ".$titulo." debe ser tipo email.";
			$c_asterisco="&nbsp;";
		}
		$cadena="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<input type='email' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' ".$c_ancho." ".$c_requerido." ".$c_posicionTexto.">";
		return $cadena;
	}
	function dateBox($titulo="", $nombre="", $valueDef="", $requerido=0) {
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
                $cadena ="<script type=\"text/javascript\">";
                $cadena.="	$(function() {";
		$cadena.="		$('#".$nombre."').datepicker({";
		$cadena.="			 dateFormat: 'yy-mm-dd'";
		$cadena.="			,showOn: 'both'";
		$cadena.="			,buttonImage: 'images/calendario.png'";
		$cadena.="			,buttonImageOnly: true";
		$cadena.="			,changeMonth: true";
		$cadena.="			,changeYear: true";
		$cadena.="		});";
                $cadena.="	});";
                $cadena.="</script>";
		$cadena.="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<input type='text' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' size='8' ".$c_requerido." style='text-align:center' readonly>";
		return $cadena;
	}
	function dateTimeBox($titulo="", $nombre="", $valueDef="", $requerido=0) {
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
                $cadena ="<script type=\"text/javascript\">";
                $cadena.="	$(function() {";
		$cadena.="		$('#".$nombre."').datetimepicker({";
		$cadena.="			 dateFormat: 'yy-mm-dd'";
		$cadena.="			,showOn: 'both'";
		$cadena.="			,buttonImage: 'images/calendario.png'";
		$cadena.="			,buttonImageOnly: true";
		$cadena.="			,changeMonth: true";
		$cadena.="			,changeYear: true";
		$cadena.="			,showSecond: true";
		$cadena.="			,timeFormat: 'hh:mm:ss'";
		$cadena.="		});";
                $cadena.="	});";
                $cadena.="</script>";
		$cadena.="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<input type='text' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' size='16' ".$c_requerido." style='text-align:center' readonly>";
		return $cadena;
	}
	function checkBox($titulo="", $nombre="", $valueDef="", $requerido=0, $chequeado) {
		$c_chequeado=($chequeado)?$chequeado:"";
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="Debe chequear la casilla ".$titulo;
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
		$cadena="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<input type='checkbox' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' ".$c_requerido." ".$c_chequeado.">";
		return $cadena;
	}
	function radioButton($titulo="", $nombre="", $valueDef="", $requerido=0, $chequeado) {
		$c_chequeado=($chequeado)?$chequeado:"";
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="Debe chequear un valor";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
		$cadena="<input type='radio' id='".$nombre."' name='".$nombre."' value='".$valueDef."' title='".$c_titulo."' ".$c_requerido." ".$c_chequeado.">";
		$cadena.=$c_asterisco." ".$titulo;
		return $cadena;
	}
	function hiddenBox($nombre="", $valueDef="") {
		$cadena="<input type='hidden' id='".$nombre."' name='".$nombre."' value='".$valueDef."'>";
		return $cadena;
	}
	function textArea($titulo="", $nombre="", $valueDef="", $requerido=0, $rows="", $cols="") {
		if($requerido==1) {
			$c_requerido="required";
			$c_titulo="El campo ".$titulo." es requerido.";
			$c_asterisco="<span class='asterisco'>*</span>";
		} else {
			$c_requerido="";
			$c_titulo=$titulo;
			$c_asterisco="&nbsp;";
		}
		$cadena="<label>".$c_asterisco." ".$titulo."</label>";
		$cadena.="<textarea id='".$nombre."' name='".$nombre."' title='".$c_titulo."' ".$c_requerido." rows='".$rows."' cols='".$cols."'>".$valueDef."</textarea>";
		return $cadena;
	}
}
?>
