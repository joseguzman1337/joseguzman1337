<?php
	$ruta="../";
	require_once('../consulta/generacionclaves.php');
	require('../Connections/sala2.php');
	mysql_select_db($database_sala, $sala);
	//echo "hola";
	
	$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna,hostestadoconexionexterna,numerosistemaestadoconexionexterna,
	mandanteestadoconexionexterna,usuarioestadoconexionexterna,passwordestadoconexionexterna
	from estadoconexionexterna e
	where e.codigoestado like '1%'";
	$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());     
	$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
	$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
  
	$host = $row_estadoconexionexterna['hostestadoconexionexterna'];
    $sistema = $row_estadoconexionexterna['numerosistemaestadoconexionexterna']; 
	$mandante =  $row_estadoconexionexterna['mandanteestadoconexionexterna']; 
	$usuario = $row_estadoconexionexterna['usuarioestadoconexionexterna'];
	$clave = $row_estadoconexionexterna['passwordestadoconexionexterna']; 
	
	$login = array (                              // Set login data to R/3 
            "ASHOST"=>"$host",             // application server host name 
            "SYSNR"=>"$sistema",                     // system number 
            "CLIENT"=>"$mandante",                    // client 
            "USER"=>"$usuario",                  // user 
            "PASSWD"=>"$clave",
			"CODEPAGE"=>"1100");              // codepage  
           $rfc = saprfc_open($login);

  // print_r($login);
     //echo $mandante;
	 function cambiaf_a_sala($fecha)
       { 
		ereg( "([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);  
		$lafecha=$mifecha[1]."-".$mifecha[2]."-".$mifecha[3];		
		return $lafecha; 
       } 
  //print_r($login);
?>
<html>
<head>
<title>Ordenes Pagas SAP</title>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">

<style type="text/css">
<!--
.Estilo1 {
	font-size: x-small;
	font-weight: bold;
}
.Estilo6 {font-family: tahoma; font-size: xx-small; font-weight: bold; }
-->
</style>
<form action="busca_pagos_sap2.php" method="post">

  <div align="center"><span class="Estilo1">BUSCA ORDENES PAGAS EN SAP
    </span>
  </div>
  <br>
<table align="center"  bordercolor="#FF9900" border="1" width="50%">
<tr  id="tdtitulogris">
<td>

<table align="center" bgcolor="#E9E9E9" width="50%">
<tr  id="tdtitulogris">
 <td id="tdtitulogris"><span class="Estilo6">Fecha Inicial</span></td>
 <td id="tdtitulogris"><span class="Estilo6">Fecha Final</span></td>
</tr>
<tr>
 <td> <input type="text" name="fecha1" value="<?php echo $_POST['fecha1'];?>">  </td>
 <td> <input type="text" name="fecha2" value="<?php echo $_POST['fecha2'];?>"></td>
</tr>
</table>


<p align="center">
  <input type="submit" name="Submit" value="Enviar">
</p>
<?php
  /*****************************   VALIDACION DE CONEXION Y EXISTENCIA DE TABLA DE PAGOS EN SAP **************************/
 if ($_POST['Submit'])
  {
  
       $query_ordenesm = "select * from ordenpago o,detalleordenpago do,estudiante e,estudiantegeneral eg,concepto c
	   where o.codigoestadoordenpago like '1%'
	   and e.codigoestudiante = o.codigoestudiante
	   AND do.codigoconcepto = c.codigoconcepto       
	   and e.idestudiantegeneral = eg.idestudiantegeneral
	   and o.numeroordenpago = do.numeroordenpago 
	   and fechaordenpago between '".$_POST['fecha1']."' and '".$_POST['fecha2']."'";
       //echo $query_ordenesm;
	   $ordenesm = mysql_query($query_ordenesm, $sala) or die("$query_ordenesm".mysql_error());
       $row_ordenesm = mysql_fetch_assoc($ordenesm);
       $totalRows_ordenesm = mysql_num_rows($ordenesm);	
	   //105033016790214  

//echo $totalRows_ordenesm ;
//exit();

do {
// echo "<br><br><br><br>".  $row_ordenesm['numeroordenpago'] ." <br><br><br><br>";
 
  if ($row_ordenesm['cuentaoperacionprincipal'] == '153')
   {
    $numeroordenpago = substr($row_ordenesm['numeroordenpago'] . $row_ordenesm['numerodocumento'],0,15);
   }
  else
   {
     $numeroordenpago = $row_ordenesm['numeroordenpago']; 
   }
// echo "<br><br><br>",$numeroordenpago,"<br><br><br>";
 
 //$numeroordenpago = '1054748';// quitar
 
 $rfcfunction = "ZFICA_REPORTAR_PAGOS_A_SALA";
 $resultstable = "SALIDA";

	$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

	if($numeroordenpago <> "")
	{ // $numeroordenpago	 
	
	// traigo la tabla interna de SAP
	saprfc_table_init($rfchandle,$resultstable);
	// importo el numero de orde de pago consultar
	saprfc_import($rfchandle,"XBLNR",$numeroordenpago); 
	
	$rfcresults = saprfc_call_and_receive($rfchandle);
    $numrows = saprfc_table_rows($rfchandle,$resultstable);
	
	} // $numeroordenpago
    unset ($tabla);
 	 for ($i=1; $i <= $numrows; $i++)
	 {
	  $tabla[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	 }	
	 $fechapagosapordenpago = "";
	 $documentocuentaxcobrarsap = "";
	 $documentocuentacompensacionsap = "";
	 $valeorden = "";
	 $valortotalordenpago = "";

   if ($tabla <> "")
	 {  // if 1 	 
	  foreach ($tabla as $valortabla => $totaltabla)
	  { // foreach 1
	      //echo $numeroordenpago,"--";
		 foreach ($totaltabla as $valor1tabla => $total1tabla) 
		  { // foreach 2		    
		    if ($valor1tabla == "BUDAT")
			 {
			   $fechapagosapordenpago = cambiaf_a_sala($total1tabla);
     		  // echo $fechapagosapordenpago,"--";
			 }	  
		    if ($valor1tabla == "OPBEL")
			 {
			   $documentocuentaxcobrarsap = $total1tabla*1;
			  //echo $documentocuentaxcobrarsap,"--";
			 }	 
			 if ($valor1tabla == "XBLNR")
			 {
			  $documentocuentacompensacionsap = $total1tabla*1;
			 //  echo $documentocuentacompensacionsap,"--";
			 }	
			 if ($valor1tabla == "BETRW")
			 {
			   $valeorden =  $total1tabla;
			   
			  if (eregi("-$", $valeorden))
			     $valeorden = $valeorden * -1;
			   //echo "<br><br><br>$valeorden<br><br><br>";	   		   
			 }	      
		  } // foreach 2
           $valortotalordenpago = $valortotalordenpago +  $valeorden;
	      
	  } // foreach 1
	   $valortotalordenpago = $valortotalordenpago * 100;
	    //echo "<br>";	 
	   // echo $valortotalordenpago,"<br>";
	// exit();
    ////////////////////////////// Reporta  los pagos a sala /////////////////////////////////////////////////////////////   
	//$numeroordenpago = 1023775;
	 $numeroordenpago = substr($numeroordenpago,0,7);
	
	 $query_primerfecha = "SELECT * FROM fechaordenpago
     WHERE numeroordenpago = '$numeroordenpago'
	 order by 3";
	//echo $query_data,"<br>";
	//exit();
	$primerfecha = mysql_query($query_primerfecha, $sala) or die(mysql_error());
	$row_primerfecha = mysql_fetch_assoc($primerfecha);
	$totalRows_primerfecha = mysql_num_rows($primerfecha);
	//$valortotalordenpago = $valortotalordenpago - 1;
	//echo "$valortotalordenpago >= '".$row_primerfecha['valorfechaordenpago']."'";
	if ( $valortotalordenpago >= $row_primerfecha['valorfechaordenpago'])
	{ // fechaordenpago
	// echo "$numeroordenpago     $documentocuentaxcobrarsap     $documentocuentacompensacionsap        $valortotalordenpago<br>";
	   $datosordenes[$numeroordenpago]= array($documentocuentaxcobrarsap,$documentocuentacompensacionsap,$valortotalordenpago);	
	 
	
	 
	 $query_data = "SELECT * FROM ordenpago
     WHERE numeroordenpago = '$numeroordenpago'";
	//echo $query_data,"<br>";
	//exit();
	$data = mysql_query($query_data, $sala) or die(mysql_error());
	$row_data = mysql_fetch_assoc($data);
	$totalRows_data = mysql_num_rows($data);
   	
	$digito = ereg_replace("^[0-9]{1,1}","",$row_data['codigoestadoordenpago']);
 	
	if ($row_data <> "")
	 { //$row_data
		    
		$query_prematricula = "UPDATE prematricula p,ordenpago o
		set codigoestadoprematricula = 4".$digito."
		where o.idprematricula = '".$row_data['idprematricula']."'
		and o.codigoestudiante = p.codigoestudiante
		and o.numeroordenpago = '$numeroordenpago'
		and o.codigoperiodo = p.codigoperiodo";
        $prematricula=mysql_db_query($database_sala,$query_prematricula);
		
		//echo $query_prematricula;
		
		$query_ordenpago = "UPDATE ordenpago
		set codigoestadoordenpago = 4".$digito.",
		documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
		documentocuentacompensacionsap = '$documentocuentacompensacionsap',
		fechapagosapordenpago = '$fechapagosapordenpago'
		where numeroordenpago = '$numeroordenpago'";
       // echo $query_ordenpago;
		$ordenpago=mysql_db_query($database_sala,$query_ordenpago);

        $query_detalleprematricula = "UPDATE detalleprematricula 
		set codigoestadodetalleprematricula = '30'
		where numeroordenpago = '$numeroordenpago'
		and codigoestadodetalleprematricula like '1%'";
        $detalleprematricula=mysql_db_query($database_sala,$query_detalleprematricula);   

        $query_conceptoorden = "SELECT do.codigoconcepto
        FROM detalleordenpago do,concepto c
        WHERE do.numeroordenpago = '$numeroordenpago'
        AND do.codigoconcepto = c.codigoconcepto
        AND c.cuentaoperacionprincipal = '153'";
        $conceptoorden=mysql_db_query($database_sala,$query_conceptoorden);
        $totalRows_conceptoorden = mysql_num_rows($conceptoorden);          
        $row_conceptoorden = mysql_fetch_array($conceptoorden);


        if ($row_conceptoorden <> "")
        { // if 2
            require_once('../funciones/funcion_inscribir.php');
            hacerInscripcion_mysql($numeroordenpago);
           /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
           SET i.codigosituacioncarreraestudiante = '107',
		   e.codigosituacioncarreraestudiante = '107'
           WHERE o.codigoestudiante = e.codigoestudiante
           AND e.idestudiantegeneral = i.idestudiantegeneral 
           AND e.codigocarrera = ec.codigocarrera
           AND i.idinscripcion = ec.idinscripcion
           AND o.numeroordenpago = '$numeroordenpago'";
           $inscripcion=mysql_db_query($database_sala,$query_inscripcion);*/
        } // if 2		
		// Verifica si esa orden tiene descuentos		
		
		 $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
		 FROM ordenpago o,detalleordenpago d
         WHERE o.numeroordenpago = '$numeroordenpago'
		 AND o.numeroordenpago = d.numeroordenpago
		 AND d.codigotipodetalleordenpago = 2";
	     //echo $query_data,"<br>";
	     $detalleorden = mysql_query($query_detalleorden, $sala) or die(mysql_error());
	     
	     
		while($row_detalleorden = mysql_fetch_assoc($detalleorden))
		 {
			
            $query_consultadvd = "SELECT iddescuentovsdeuda
			FROM descuentovsdeuda
			WHERE codigoestudiante = '".$row_detalleorden['codigoestudiante']."'
			and codigoestadodescuentovsdeuda = '01'
			and codigoperiodo = '".$row_detalleorden['codigoperiodo']."'
			and codigoconcepto = '".$row_detalleorden['codigoconcepto']."'
			and valordescuentovsdeuda = '".$row_detalleorden['valorconcepto']."'";
			$consultadvd=mysql_db_query($database_sala,$query_consultadvd) or die("$query_consultadvd".mysql_error());
			$totalRows_consultadvd = mysql_num_rows($consultadvd);          
			$row_respuestadvd = mysql_fetch_array($consultadvd);
			
			if ($row_respuestadvd <> "")
			 {
			    $base3="update descuentovsdeuda
				set  codigoestadodescuentovsdeuda = '03' 
				where iddescuentovsdeuda = '".$row_respuestadvd['iddescuentovsdeuda']."'"; 
				$sol3=mysql_db_query($database_sala,$base3);	
			  //echo $base3;
			 }		
		 }
		
		$query_operacion = "select documentocuentaxcobrarsap
        from ordenpago
        WHERE numeroordenpago = '$numeroordenpago'";
        $operacion=mysql_db_query($database_sala,$query_operacion) or die("$query_operacion".mysql_error());
        $totalRows_operacion = mysql_num_rows($operacion);          
        $row_operacion = mysql_fetch_array($operacion);		

		//CREA CUENTA CORREO
		$objetoclaveusuario=new GeneraClaveUsuario($numeroordenpago,$salaobjecttmp);
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     }
	} // fechaordenpago
   } // if 1  
  }while($row_ordenesm = mysql_fetch_assoc($ordenesm));
}  

if (is_array($datosordenes))
{
?>
  <table align="center" border="1" width="50%">
  <tr bgcolor="#E9E9E9">
  <td colspan="4"><div align="center"><span class="Estilo6">Ordenes Matriculadas </span></div></td>  
  </tr>
  <tr bgcolor="#E9E9E9">
  <td><span class="Estilo6">Orden Pago</span></td>
  <td><span class="Estilo6">No CxC</span></td>
  <td><span class="Estilo6">Compensacion</span></td>
  <td><span class="Estilo6">Valor</span></td>
  </tr>
<?php 	
	foreach ($datosordenes as $datoarray => $value)
	{
	  echo '<tr>
			<td>'.$datoarray.'</td>
			<td>'.$value[0].'</td>
			<td>'.$value[1].'</td>
			<td>'.$value[2].'</td>
			</tr>';	 
	}
?>
  
</table>
</td>
</tr>
</table>

<?php
}
 saprfc_close($rfc);
?>

</form>

</body>
</html>