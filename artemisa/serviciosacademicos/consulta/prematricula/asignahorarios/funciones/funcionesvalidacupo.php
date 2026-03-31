<?php 
function cupopertenecemateria($codigomateria,$codigocarrera,$row_datosgrupos1)
{

//if($codigomateria==1578)
//echo "<br>ENTRO AQUI 2<br>";
//}
				 $query_pertenecemateria = "select codigomateria
					from materia
					where codigomateria = '".$codigomateria."'
					and codigocarrera = '$codigocarrera'";
					$pertenecemateria=mysql_query($query_pertenecemateria);
					//echo "$query_pertenecemateria<br>";
					$totalRows_pertenecemateria = mysql_num_rows($pertenecemateria);
					$sincupo = false;
					if($totalRows_pertenecemateria != "")
					{
						$estructuradatosmateria[$codigomateria]['pertenecemateria']=1;
					}
					else
					{
						$estructuradatosmateria[$codigomateria]['pertenecemateria']=0;
					}
					
					$cupo=($row_datosgrupos1['summaximogrupo']-$row_datosgrupos1['summaximogrupoelectiva'])-$row_datosgrupos1['summatriculadosgrupo'];
					if($codigomateria==1578)
					$mensaje= $cupo."=(".$row_datosgrupos1['summaximogrupo']."-".$row_datosgrupos1['summaximogrupoelectiva'].")-".$row_datosgrupos1['summatriculadosgrupo'];

					if(!$estructuradatosmateria[$codigomateria]['pertenecemateria'])
						if($row_datosgrupos1['summaximogrupoelectiva']!=0)
							$cupo=$row_datosgrupos1['summaximogrupoelectiva']-$row_datosgrupos1['summatriculadosgrupoelectiva'];
				return $cupo;
				//return $mensaje
}
function validacupoelectiva($row_datosgrupo,$pertenecemateria){

	if($row_datosgrupo['matriculadosgrupo'] >= ($row_datosgrupo['maximogrupo']-$row_datosgrupo['maximogrupoelectiva']))
		$cupolleno=1;
	else
		$cupolleno=0;
						
	if(!$pertenecemateria){
		if($row_datosgrupo['maximogrupoelectiva'] != 0)
		{
			if($row_datosgrupo['matriculadosgrupoelectiva'] >= $row_datosgrupo['maximogrupoelectiva'])
			{
				$cupolleno=1;
			}
			else
			{
				$cupolleno=0;
			}
		}
	}
	return $cupolleno;
}

?>