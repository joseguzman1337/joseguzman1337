<?php

function verificarHistoricoMateria($sala,$codigoestudiante,$periodoactual,$codigomateria) {
     $query_historico = "SELECT  * FROM notahistorico
		      WHERE codigoestudiante = '".$codigoestudiante."'
		      AND codigoperiodo = '".$periodoactual."'
		      AND codigomateria = '".$codigomateria."'
		      AND codigoestadonotahistorico LIKE '2%'
		      AND codigotiponotahistorico in (101,100) 
			  AND codigomateria NOT IN 
				(
				SELECT  codigomateria FROM notahistorico
							  WHERE codigoestudiante = '".$codigoestudiante."'
		      AND codigoperiodo = '".$periodoactual."'
		      AND codigomateria = '".$codigomateria."'
				AND codigoestadonotahistorico like '1%' 
				)";
             /* echo "$query_historico <br>";
			  echo "<pre>";*/
	          $historico = mysql_query($query_historico, $sala) or die(mysql_error());
	          $row_historico2 = mysql_fetch_assoc($historico);
	return $row_historico2;
}
?>