<?php
class ObtenerDatosMail
{
	var $conexion;
	var $codigocarrera;
	var $idproceso;
	var $fechahoy;
	var $depurar;
	var $correo_destinatario;
	var $nombre_destinatario;
	var $array_datos_correspondencia;
	var $array_detalle_correspondencia;
	var $array_seguimiento;

	function ObtenerDatosMail($conexion,$codigocarrera,$idproceso,$depurar=false)
	{
		$this->conexion=$conexion;
		$this->correo_destinatario=$correo_destinatario;
		$this->nombre_destinatario=$nombre_destinatario;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->codigocarrera=$codigocarrera;
		$this->idproceso=$idproceso;
		$this->depurar=$depurar;
		if($depurar==true)
		{
			$this->conexion->debug=true;
		}
		$this->array_datos_correspondencia=$this->Obtener_datos_correspondencia();
		if(is_array($this->array_datos_correspondencia))
		{
			if(is_array($this->array_datos_correspondencia))
			{
				$this->array_detalle_correspondencia=$this->Obtener_detalle_correspondencia($this->array_datos_correspondencia);
				$this->Obtener_seguimiento($this->array_datos_correspondencia['idcorrespondencia']);
			}
		}
	}

	function Obtener_datos_correspondencia()
	{
		$query="SELECT * from correspondencia c
		WHERE
		c.idproceso='$this->idproceso'
		AND '$this->fechahoy' >= c.fechadesdecorrespondencia
		AND '$this->fechahoy' <= c.fechahastacorrespondencia
		AND c.codigocarrera='$this->codigocarrera'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($this->depurar==true)
		{
			print_r($row_operacion);
		}
		return $row_operacion;
	}

	function Obtener_detalle_correspondencia($correspondencia)
	{
		$query="
		SELECT dc.* FROM detallecorrespondencia dc, correspondencia c
		WHERE
		c.idcorrespondencia=dc.idcorrespondencia
		AND dc.codigoestado=100
		AND dc.idcorrespondencia=".$correspondencia['idcorrespondencia']."
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		if($this->depurar==true)
		{
			$this->tabla($array_interno,'detallecorrespondencia');
		}
		return $array_interno;
	}

	function Obtener_seguimiento($idcorrespondencia)
	{
		$query="
		SELECT * from correspondenciaseguimiento cs, correspondencia c
		WHERE
		cs.idcorrespondencia=c.idcorrespondencia
		AND c.idcorrespondencia='$idcorrespondencia'
		AND '$this->fechahoy' >= cs.fechainiciocorrespondenciaseguimiento
		AND '$this->fechahoy' <= cs.fechafinalcorrespondenciaseguimiento
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		$this->array_seguimiento=$array_interno;
		if($this->depurar==true)
		{
			$this->tabla($array_interno,'seguimiento');
		}
		return $array_interno;
	}
	function Obtener_trato()
	{
		$query="SELECT * FROM trato WHERE idtrato='".$_POST['idtrato']."'";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}

	function Construir_correo($destinatario,$nombre_destinatario,$trato="Señor(a)")
	{
		if(is_array($this->array_datos_correspondencia) and is_array($this->array_detalle_correspondencia))
		{
			$mail = new PHPMailer();
			$mail->From = $this->array_datos_correspondencia['correoorigencorrespondencia'];
			$mail->FromName = $this->array_datos_correspondencia['nombreorigencorrespondencia'];
			$mail->ContentType = "text/html";
			$mail->Subject = $this->array_datos_correspondencia['asuntocorrespondencia'];
			//aquí en $cuerpo se guardan, el encabezado(carreta) y la firma
			$encabezado=$trato.":<br>".$nombre_destinatario;
			$cuerpo=$encabezado."<br><br>".$this->array_datos_correspondencia['encabezamientocorrespondencia']."<br><br>".$this->array_datos_correspondencia['firmacorrespondencia'];
			$mail->Body = $cuerpo;
			$mail->AddAddress($destinatario,$nombre_destinatario);
			//$mail->AddAddress("castroabraham@unbosque.edu.co","Prueba");
			foreach ($this->array_detalle_correspondencia as $llave => $valor)
			{
				$ruta="archivos/".$valor['linkcorrespondencia'];
				$mail->AddAttachment($ruta,$valor['linkcorrespondencia']);
			}

			if(!$mail->Send())
			{
				echo "El mensaje no pudo ser enviado";
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else
			{
				if($this->depurar==true)
				{
					echo "Mensaje Enviado";
					echo "<br>";
					print_r($mail);
				}
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function Construir_correo_seguimiento($nombre_interesado,$idpreinscripcion)
	{
		if(is_array($this->array_datos_correspondencia) and is_array($this->array_detalle_correspondencia) and is_array($this->array_seguimiento))
		{
			foreach ($this->array_seguimiento as $llave => $valor)
			{
				$mail_seguimiento = new PHPMailer();
				$mail_seguimiento->From = $this->array_datos_correspondencia['correoorigencorrespondencia'];
				$mail_seguimiento->FromName=$valor['nombrecorrespondenciaseguimiento'];
				$mail_seguimiento->ContentType = "text/html";
				$mail_seguimiento->Subject = "Nuevo interesado";
				$mail_seguimiento->AddAddress($valor['emailcorrespondenciaseguimiento'],'Automático');
				$cuerpo="Nombre: ".$nombre_interesado."<br>"."No_preinscripcion: ".$idpreinscripcion."<br>".$valor['mensajecorrespondenciaseguimiento']."<br>";
				$mail_seguimiento->Body=$cuerpo;
				if(!$mail_seguimiento->Send())
				{
					echo "El mensaje no pudo ser enviado";
					echo "Mailer Error: " . $mail_seguimiento->ErrorInfo;
				}
				else
				{
					if($this->depurar==true)
					{
						echo "Mensaje Enviado";
						echo "<br>";
						print_r($mail_seguimiento);
					}
				}
				unset($mail_seguimiento);
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function escribir_cabeceras($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function tabla($matriz,$texto="")
	{
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		$this->escribir_cabeceras($matriz[0],$link);
		for($i=0; $i < count($matriz); $i++)
		{
			echo "<tr>\n";
			while($elemento=each($matriz[$i]))
			{
				echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
}
?>
