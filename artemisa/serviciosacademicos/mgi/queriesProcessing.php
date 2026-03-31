<?php

	function traerNoticiasPantallas(){
		$sql = "SELECT g.NoticiaEventoId,g.NoticiaEventoId as id,g.TituloNoticia,g.DescripcionNoticia,g.FechaInicioVigencia,g.FechaFinalVigencia,g.AprobadoPublicacion,e.NombreEstado FROM NoticiaEvento g INNER JOIN EstadoPublicacion e ON e.EstadoPublicacionId=g.AprobadoPublicacion ";
		return $sql;
	}

?>