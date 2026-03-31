<?php 
	
	function getInformePercepcion($codigoFactor,$style){
		$codigoFactor=str_replace("FACTOR N°","",$codigoFactor);
		if($codigoFactor=="1"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_1.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 1</a>';
		} else if($codigoFactor=="2"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_2.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 2</a>';
		} else if($codigoFactor=="3"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_3.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 3</a>';
		} else if($codigoFactor=="4"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_4.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 4</a>';
		} else if($codigoFactor=="5"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_5.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 5</a>';
		} else if($codigoFactor=="6"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_6.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 6</a>';
		} else if($codigoFactor=="7"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_7.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 7</a>';
		} else if($codigoFactor=="8"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_8.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 8</a>';
		} else if($codigoFactor=="9"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_9.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 9</a>';
		} else if($codigoFactor=="10"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_10.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 10</a>';
		} else if($codigoFactor=="11"){
			echo '<a href="../../SQI_Documento/Documento_upload/RESULTADOS_FACTOR_11.pdf" style="'.$style.'">Informe de Resultados de Percepción Factor 11</a>';
		} 
	}
	?>