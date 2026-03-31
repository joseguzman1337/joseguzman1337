<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
class clasesegundoexamen
{
	var $objetobase;
	var $debug;
	function clasesegundoexamen($conexion,$debug=false){
		$this->objetobase=$conexion;
		$this->$debug=$debug;
	}	
	function LeerDatosExamen($codigoestudiante,$codigocarrera,$idsubperiodo)
	{
		$query="SELECT ea.codigoestudiante,ea.idestudianteadmision,
		dea.iddetalleestudianteadmision,dea.idhorariodetallesitioadmision
		FROM estudianteadmision ea, 
		detalleestudianteadmision dea, 
		detalleadmision da,
		admision a
		WHERE
		a.idadmision = ea.idadmision
		AND ea.idestudianteadmision = dea.idestudianteadmision
		AND dea.iddetalleadmision = da.iddetalleadmision
		AND da.codigotipodetalleadmision=1
		AND ea.codigoestudiante='$codigoestudiante'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigocarrera='$codigocarrera'
		";
		if($this->debug==true)
		{
			$this->objetobase->conexion->debug=true;
		}
		$operacion=$this->objetobase->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($this->debug==true)
		{
			$this->objetobase->conexion->debug=false;
		}
		$tienedatos=true;
		if($row_operacion['iddetalleestudianteadmision']==null)
		{
			$tienedatos=false;
		}
		//$array_interno=array('TieneDatosEstudianteadmisionDetalleestudianteadmision'=>$tienedatos,'codigoestudiante'=>$codigoestudiante,'idestudianteadmision'=>$row_operacion['idestudianteadmision'],'iddetalleestudianteadmision'=>$row_operacion['iddetalleestudianteadmision']);
		$array_interno=$row_operacion;
		return $array_interno;
	}

	function LeerDatosSegundoExamen($codigoestudiante,$codigocarrera,$idsubperiodo)
	{
		$query="SELECT ea.codigoestudiante,ea.idestudianteadmision,
		da.iddetalleadmision,ea.codigoestadoestudianteadmision
		FROM estudianteadmision ea, 
		detalleadmision da,
		admision a
		WHERE
		a.idadmision = ea.idadmision and
		da.idadmision=a.idadmision 
		AND da.codigotipodetalleadmision=2
		and ea.codigoestudiante='".$codigoestudiante."'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigocarrera='$codigocarrera'
		and ea.codigoestado like '1%'
		and a.codigoestado like '1%'
		";
		if($this->debug==true)
		{
			$this->objetobase->conexion->debug=true;
		}
		$operacion=$this->objetobase->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($this->debug==true)
		{
			$this->objetobase->conexion->debug=false;
		}
		$tienedatos=true;
		if($row_operacion['iddetalleadmision']==null)
		{
			$tienedatos=false;
		}
		$array_interno=$row_operacion;
		$array_interno["TieneDatosEstudianteadmisionDetalleestudianteadmision"]=$tienedatos;
		//array('TieneDatosEstudianteadmisionDetalleestudianteadmision'=>$tienedatos,'codigoestudiante'=>$codigoestudiante,'idestudianteadmision'=>$row_operacion['idestudianteadmision'],'iddetalleestudianteadmision'=>$row_operacion['iddetalleestudianteadmision']);
		return $array_interno;
	}
	
	function ActualizarDatosPruebasSegundoExamen($array_datos,$array_puntajes)
	{
		echo "array_datos<pre>"; print_r($array_datos); echo "</pre>";
		echo "array_puntajes<pre>"; print_r($array_puntajes); echo "</pre>";

		if (count($array_datos)==count($array_puntajes))
		{
			for ($i=0;$i<count($array_datos);$i++)
			{
				if($array_datos[$i]['TieneDatosEstudianteadmisionDetalleestudianteadmision']==true)
				{
					//$query="UPDATE detalleestudianteadmision SET resultadodetalleestudianteadmision='".$array_puntajes[$i]['puntaje']."'
					//WHERE iddetalleestudianteadmision='".$array_datos[$i]['iddetalleestudianteadmision']."'
					//";
					$tabla="detalleestudianteadmision";
					$fila["fechadetalleestudianteadmision"]=date("Y-m-d H:i:s");
					$fila["idestudianteadmision"]=$array_datos[$i]["idestudianteadmision"];
					$fila["iddetalleadmision"]=$array_datos[$i]["iddetalleadmision"];
					$fila["resultadodetalleestudianteadmision"]=$array_puntajes[$i]['puntaje'];
						//   resultadodetalleestudianteadmision
					$fila["idhorariodetallesitioadmision"]=$array_datos[$i]["idhorariodetallesitioadmision"];
					$fila["codigoestado"]="100";
					$fila["codigoestadoestudianteadmision"]=$array_datos[$i]["codigoestadoestudianteadmision"];
					$fila["observacionesdetalleestudianteadmision"]="";
					$condicionactualiza=" iddetalleadmision=".$fila["iddetalleadmision"].
										" and idestudianteadmision=".$fila["idestudianteadmision"];
				//echo "<pre>";
				$this->objetobase->insertar_fila_bd($tabla,$fila,1,$condicionactualiza);
				//echo "</pre>";
					
					if($this->debug==true)
					{
						$this->objetobase->conexion->debug=true;
					}
					//$operacion=$this->objetobase->conexion->query($query);
					$actualizadoOK=true;

				}
				else
				{
					$actualizadoOK=false;
				}
				$array_resultado_datos_actualizados[]=array('numerodocumento'=>$array_puntajes[$i]['numerodocumento'],'codigoestudiante'=>$array_datos[$i]['codigoestudiante'],'puntaje'=>$array_puntajes[$i]['puntaje'],'actualizadoOK'=>$actualizadoOK);
			}
		}
		if($this->debug==true)
		{
			$this->conexion->debug=false;
		}
		//exit();
		return $array_resultado_datos_actualizados;
	}

}

?>