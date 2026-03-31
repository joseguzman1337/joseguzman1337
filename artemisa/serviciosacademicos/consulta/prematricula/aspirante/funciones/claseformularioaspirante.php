<?php 
/* session_start();
$rol=$_SESSION['rol'];
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
 */
class formulario_aspirante extends formulario
{
	function ingresar_fila($tabla,$fila)
	{
		while (list ($clave, $val) = each ($fila)) {
  		 //echo "$clave => $val<br>";
		 $this->array_datos_formulario[]=array('tabla'=>$tabla,'campo'=>'$clave','valor'=>'$val');
		}
	}
	function recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="")
	{
		$query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}
	function insertar_fila_bd($tabla,$fila)
	{
		$claves="(";
		$valores="(";
			$i=0;
			while (list ($clave, $val) = each ($fila)) {
			
				if($i>0){
					$claves .= ",".$clave.""; 
					$valores .= ",'".$val."'";
				}
				else{
					$claves .= "".$clave."";
					$valores .= "'".$val."'";
				}
				$i++;
			}
		$claves .= ")";
		$valores .= ")";
		 $sql="insert into $tabla $claves values $valores";
		$operacion=$this->conexion->query($sql);
			
	}
	
	function cambiar_valor_campo($campo,$valor,$form="form1"){
			echo "\n<script type=\"text/javascript\">
		".$form.".".$campo.".value='".$valor."'
		</script>\n
		";
	}

	function actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla){
			$i=0;
			while (list ($clave, $val) = each ($fila)) {
			
				if($i>0){
					$claves .= ",".$clave.""; 
					$valores .= ",'".$val."'";
					$condiciones .= ",".$clave."='".$val."'";
				}
				else{
					$claves .= "".$clave."";
					$valores .= "'".$val."'";
					$condiciones .= $clave."='".$val."'";
				}
				$i++;
			}
		 $sql="update $tabla set $condiciones where $nombreidtabla=$idtabla";
		$operacion=$this->conexion->query($sql);

	}
	function boton_tipo($tipo,$nombre,$valor,$funcion="")
	{
	 echo "<input type='$tipo' name='$nombre' value='$valor' $funcion>";
	}
	function dibujar_campos($tipo,$parametros,$titulo,$estilo_titulo,$idtitulo,$tipo_titulo=""){
			echo "
			<tr>
			<td id='$estilo_titulo'>";
			$this->etiqueta("$idtitulo","$titulo","$tipo_titulo");
			//echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
			echo "</td>	
			<td>";
			for($i=0;$i<count($tipo);$i++)
			eval("\$this->".$tipo[$i]."(".$parametros[$i].");"); 
			
			echo "
			</td>
			</tr>
			";
	}
	function dibujar_campo($tipo,$parametros,$titulo,$estilo_titulo,$idtitulo,$tipo_titulo=""){
			echo "
			<tr>
			<td id='$estilo_titulo'>";
			$this->etiqueta("$idtitulo","$titulo","$tipo_titulo");
			//echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
			echo "</td>	
			<td>";
			
			eval("\$this->".$tipo."(".$parametros.");"); 
			
			echo "
			</td>
			</tr>
			";
	}

	function dibujar_fila_titulo($titulo,$estilo_titulo,$colspan="2")
	{
	
	echo "<tr>
		<td colspan='$colspan'><label id='$estilo_titulo'>'$titulo'</label></td>
		</tr>
	";
	
	}
	function recuperar_recurso_imagen($codigoestudiante,$nivel){
	
	$query= "select ed.numerodocumento, ed.fechainicioestudiantedocumento, 
	ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen,
	max(ed.idestudiantedocumento), ed.idestudiantegeneral
	from estudiantedocumento ed, estudiante e, ubicacionimagen u
	where ed.idestudiantegeneral = e.idestudiantegeneral
	and e.codigoestudiante = '$codigoestudiante'
	and u.idubicacionimagen like '1%'
	and u.codigoestado like '1%'
	group by ed.idestudiantegeneral
	order by 2 desc";
/* 	$query="select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
from estudiantedocumento ed, estudiante e, ubicacionimagen u
where ed.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = '$codigoestudiante'
and u.idubicacionimagen like '1%'
and u.codigoestado like '1%'
order by 2 desc";
 */	//echo $query;
	$operacion=$this->conexion->query($query);
	//$row_operacion=$operacion->fetchRow();
	while($row_operacion=$operacion->fetchRow())
	{
		$link = substr($row_operacion['linkidubicacionimagen'],9);
		$imagenjpg = $row_operacion['numerodocumento'].".jpg";
		$imagenJPG = $row_operacion['numerodocumento'].".JPG";
		//echo $imagecreator=$nivel.$link.$imagenJPG;
		//$linkimagen=$imagecreator;
		if(@imagecreatefromjpeg($nivel.$link.$imagenjpg))
		{
			$linkimagen = $nivel.$link.$imagenjpg;
			break;
		}
		else if(@imagecreatefromjpeg($nivel.$link.$imagenJPG))
		{
			$linkimagen = $nivel.$link.$imagenJPG;
			break;
		}
	}
	//echo $linkimagen;
	return $linkimagen;
	}
	//
	function dibujar_tabla_informacion_estudiante($nivel,$bordecolortabla="#003333",$estiloceldavalor="Estilo1",$estiloceldatitulo="Estilo2",$colorfondoceldatitulo="#C5D5D6")
	{
	
	echo "<table width='100%' border='2' align='center' cellpadding='2' bordercolor='$bordecolortabla'>
    <tr>
	<td>
	<table width='100%' border='0' align='center' cellpadding='0' bordercolor='$bordecolortabla'>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Apellidos</div></td>
        <td class='$estiloceldavalor'>
          <div align='center'>";		  
	  echo $this->array_datos_cargados['estudiantegeneral']->apellidosestudiantegeneral; 
	  echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Nombres</div></td>
        <td class='$estiloceldavalor'><div align='center'>"; 
		
		 echo $this->array_datos_cargados['estudiantegeneral']->nombresestudiantegeneral;
		 echo "
		 </div></td>
        <td rowspan='6' valign='middle' class='$estiloceldavalor' align='center'>"; 
			$linkimagen=$this->recuperar_recurso_imagen($_GET['codigoestudiante'],$nivel);
		echo "
          <div align='center'>"; echo"<img src='"; echo $linkimagen; echo "' width='80' height='120'></div></td>
      </tr>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Tipo de Documento</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
		$datosdocumento = $this->recuperar_datos_tabla('documento','tipodocumento',$this->array_datos_cargados['estudiantegeneral']->tipodocumento);
		echo $datosdocumento['nombredocumento']; 
		echo "</div></td>
        <td colspan='1' bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>N&uacute;mero</div></td>
		<td colspan='1' class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->numerodocumento; echo "</div></td>
        </tr>     
	  <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Expedido en</div></td>
        <td class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->expedidodocumento; echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Fecha de Nacimiento</div></td>
        <td class='$estiloceldavalor'><div align='center'>
        "; echo  ereg_replace(' [0-9]+:[0-9]+:[0-9]+','',$this->array_datos_cargados['estudiantegeneral']->fechanacimientoestudiantegeneral); 
		 echo "
        </div></td>
        </tr>
	   <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>G&eacute;nero</div></td>
        <td class='$estiloceldavalor'><div align='center'>"; $datosgenero = $this->recuperar_datos_tabla('genero','codigogenero',$this->array_datos_cargados['estudiantegeneral']->codigogenero);
		echo $datosgenero['nombregenero']; 		
		 echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Id</div></td>
		<td class='$estiloceldavalor' ><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->idestudiantegeneral; 
		 echo "</div></td>
        </tr>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Celular</div></td>
        <td class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->celularestudiantegeneral;
		 echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>E-mail</div></td>
		<td class='$estiloceldavalor' ><div align='center'>
		  "; echo $this->array_datos_cargados['estudiantegeneral']->emailestudiantegeneral;
		 echo "	</div></td>
        </tr>
      <tr>        
      <td  bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Dir. Estudiante</div></td>
      <td class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->direccionresidenciaestudiantegeneral;
		 echo "</div></td>
      <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Tel&eacute;fono</div></td>
      <td class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->telefonoresidenciaestudiantegeneral;
		 echo "</div></td>
      </tr>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Dir. Correspondencia</div></td>
        <td class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->direccioncorrespondenciaestudiantegeneral;
		 echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Tel&eacute;fono</div></td>
        <td class='$estiloceldavalor'><div align='center'>"; echo $this->array_datos_cargados['estudiantegeneral']->telefonocorrespondenciaestudiantegeneral;
		 echo "</div></td>
        <td class='$estiloceldavalor'>&nbsp;</td>
      </tr>	  
		</table>
		</table>";

	}
	
} 


?>