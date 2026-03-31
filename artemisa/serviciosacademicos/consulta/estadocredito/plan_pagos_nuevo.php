<?php      
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
          
	  require_once($ruta.'Connections/sala2.php');    
	  mysql_select_db($database_sala, $sala);	
	  @session_start();      
	  //require_once($ruta.'Connections/sap.php');
	  require_once($ruta.'funciones/cambia_fecha_sap.php'); 
	  $link = $ruta."../imagenes/estudiantes/"; 	
	  require_once($ruta.'funciones/datosestudiante.php');   
	  $cont = 0;
	 
	 // print_r($login);
	 // $codigoestudiante = $_SESSION['codigo'];
	
	  
	 /*
	$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, 
	e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
	e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
	from estadoconexionexterna e
	where e.codigoestado like '1%'";
	//and dop.codigoconcepto = '151'
	//echo "sdas $query_ordenes<br>";
	$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());     
	$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
	$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);

	if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
	{
		$login = array (                              // Set login data to R/3 
		"ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name 
		"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number 
		"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client 
		"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user 
		"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
		"CODEPAGE"=>"1100");              												// codepage  
		//$login['ASHOST'] = "172.16.6.9";
		//$login['CLIENT'] = "500";/
		$rfc = saprfc_open($login);
		if(!$rfc) 
		{
			// We have failed to connect to the SAP server
			//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
			//exit(1);
		}
	} 
	   $mandante = $row_estadoconexionexterna['mandanteestadoconexionexterna'];
	  */
	   $query_dataestudiante = "SELECT * 
       FROM estudiante e,estudiantegeneral eg 
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral
   	   and e.codigoestudiante = '".$codigoestudiante."'";
      //echo $query_dataestudiante;
	   $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
       $row_dataestudiante = mysql_fetch_assoc($dataestudiante);
       $totalRows_dataestudiante = mysql_num_rows($dataestudiante);	  
	   
	   $idestudiante = $row_dataestudiante['idestudiantegeneral'];
	
	$rfcfunction = "ZFICA_SALA_CONSULT_PLAN_PAGO";
	$resultstable = "ZTAB_PAGOS";
   
	
	@$rfchandle = saprfc_function_discover($rfc, $rfcfunction);
	
	// traigo la tabla interna de SAP
	@saprfc_table_init($rfchandle,$resultstable);
	// importo el numero de documento a consultar
	 //echo $idestudiante;
	
	@saprfc_import($rfchandle,"GPART",$idestudiante); 
	
	@$rfcresults = saprfc_call_and_receive($rfchandle);
	
    $numrows = saprfc_table_rows($rfchandle,$resultstable);
 
 	 for ($i=1; $i <= $numrows; $i++)
	 {
	  $results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	 }	
	//print_r($results); 
	
     
?>	 

<style type="text/css">
<!--
.Estilo10 {
	font-family: tahoma;
	font-weight: bold;
}
.Estilo12 {font-size: 9px}
.Estilo13 {font-family: tahoma}
.Estilo14 {font-size: x-small}
.Estilo15 {font-family: tahoma; font-size: x-small; }
-->
</style>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">

	 

<?php 
//datosestudiante($codigoestudiante,$sala,$database_sala,$link); 

 if ($results <> "")
  { // if 1 
  	$tieneplanpagos = true;	
?>
<br><br>
<hr width="750" align="left">
<p>PLAN DE PAGOS</p>
<table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">	
<tr id="trtitulogris">
  <td colspan="5">CUOTAS PENDIENTES</td>
</tr>
<tr id="trtitulogris">
  <td >Nro Orden</td>
  <td>Fecha Vencimiento</td>
  <td  colspan="2">Valor</td>
  <!-- <td  colspan="1">Ordenes</td> -->
</tr>
<?php 	 

	 foreach ($results as $valor => $total)
	  {  // foreach 1
        $ordenpago = "";
        $cxc = "";
        $cxp = "";
		$fechapago = "";
		$value = "";
		$colspan = 1;
		
		unset($valorconcepto);
		
?>	 
 <tr>	  
<?php	
       
	   foreach ($total as $valor1 => $total1) 
		{ // foreach 2  
		 
		  if ($valor1 <> "DOCCC_SAP" and $valor1 <> "DOCPP_SAP" and $valor1 <> "OPPAL" and $valor1 <> "OPPAR" and $valor1 <> "TEXT")
		    { 
		      if ($valor1 == "VPAGO")
			   {
			     $colspan = 2;
			   }
			 			 
			 if($valor1 == "FPAGO")
			  {
			   echo "<td colspan='$colspan'>",cambiaf_a_sala($total1),"</td>";
	          }
			 else
			 if ($valor1 == "VPAGO")
			   {
			    echo "<td colspan='$colspan'>",number_format($total1,0),"</td>";
			   }
			  else
			  {
			   echo "<td colspan='$colspan'>",$total1,"</td>";			  
			  }
			} 			
		
		 if ($valor1 == "AUFNR")
		   {	     
		     $ordenpago = $total1;
	         
		   }
		  else
		   if ($valor1 == "DOCCC_SAP")
		    {	     
		      $cxc= $total1;
			
	        }
		   else
		   if ($valor1 == "DOCPP_SAP")
		    {
			  $cxp = $total1;
			  
		    }
		  else
		  if ($valor1 == "FPAGO")
		    {
			  $fechapago = cambiaf_a_sala($total1);	
			 
			}
		  else
		  if ($valor1 == "VPAGO")
		    {
			  $value = round($total1,0);			 
			}
		  else
		  if ($valor1 == "OPPAL")
		    {
			  $ppal = $total1;			  
			}
			else
			if ($valor1 == "OPPAR")
		    {
			 $pcial = $total1;			
			}	
			else
			if ($valor1 == "TEXT")
			 {
			  $text = substr($total1,0,7);
			 }		
 		} // foreach 1 
		
	    $query_conceptosala = "SELECT * 
        FROM concepto
        WHERE cuentaoperacionprincipal = '$ppal'
   	    and cuentaoperacionparcial = '$pcial'";
      //echo $query_dataestudiante;
	   $conceptosala = mysql_query($query_conceptosala, $sala) or die("$query_conceptosala".mysql_error());
       $row_conceptosala = mysql_fetch_assoc($conceptosala);
       $totalRows_conceptosala = mysql_num_rows($conceptosala);
		//echo $query_conceptosala ;
		//exit();
		$conceptoorden = $row_conceptosala['codigoconcepto'];
		$valorconcepto[$conceptoorden] = "$value"; 
		
		
		$hoy = date('Y-m-d');
	    $fechalimite = $fechapago;   
		if ($fechapago <> "" and $value <> "")
		  {	 			  
			 /*if ($cont == 0)
			   {
			    $fechapago = "2006-03-01";
				$cont ++;
			   }*/
			   if ($fechapago < $hoy)  
			    {			
				  $fechalimite = $hoy; 
				  $timestamp = strtotime($fechapago);
				  $undias = ($timestamp + (60 * 60 * 24 * 1));
                  $fechapago = date ('Y-m-d',$undias);
				  				 
				  $fechapago = ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})",$fechapago, $mifecha); 
				  $fechapago = $mifecha[1].$mifecha[2].$mifecha[3];
				  $hoy = ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})",$hoy, $mifecha); 
				  $hoy = $mifecha[1].$mifecha[2].$mifecha[3];
				  
				  $funcion = "ZFKK_INTEREST_CALC";
	              $existe = saprfc_function_discover($rfc, $funcion);
				  saprfc_table_init($existe,"I_ITEMTAB");
				  saprfc_table_init($existe,"E_ITEMTAB");				  
				  saprfc_table_append ($existe,"I_ITEMTAB", array ("I_POSNO"=>"0000000001","I_CLIENT"=>$mandante,"I_IRULE"=>"RULE UB01","I_FROMDAT"=>$fechapago,"I_TODAT"=>$hoy,"I_KEYDAT"=>$hoy,"I_KEYDAY"=>"00","I_INTINT"=>"","I_AMOUNT"=>$value,"I_CURR"=>"COP","I_EXCT"=>"","I_EXCV"=>"","I_BUKRS"=>"UB01"));
	              //echo '('.$existe.',"I_ITEMTAB", array ("I_POSNO"=>"0000000001","I_CLIENT"=>'.$mandante.',"I_IRULE"=>"RULE UB01","I_FROMDAT"=>'.$fechapago.',"I_TODAT"=>'.$hoy.',"I_KEYDAT"=>'.$hoy.',"I_KEYDAY"=>"","I_INTINT"=>"","I_AMOUNT"=>'.$value.',"I_CURR"=>"COP","I_EXCT"=>"","I_EXCV"=>"","I_BUKRS"=>"UB01"))',"<br>";    
	                
                 $respuesta = saprfc_call_and_receive($existe);
				
				 $retorno = saprfc_export($existe,"RETURN");  
				 			  
				  $numrows = saprfc_table_rows($existe,"E_ITEMTAB");
                 
					 for ($i=1; $i <= $numrows; $i++)
					  {
					   $tabla[$i] = saprfc_table_read($existe,"E_ITEMTAB",$i);
					  }		
				
				    // print_r($tabla);
					 //echo "<h1>",$tabla['E_INT'],"Valor Calculado</h1><br>";
					if ($tabla <> "")
					 { // if22				     
					  foreach ($tabla as $calculo => $pagar)
	                   {  // foreach 1
				         foreach ($pagar as $calculo1 => $pagar1)
	                     {
						    if($calculo1 == "E_INT")
							 {
							    $cadena = round($pagar1,0);  
							    $valorconcepto[115] = "$cadena";
							    //echo "<h1>",round($pagar1,0),"Valor Calculado</h1><br>";
							 } 						 
						  } 
					    }	  
				      } //  if22		
				   
				   }		
		     }	
			 
		// Miro si tiene cuota paga.
		  
		    $query_ordenconplan = "SELECT * 
			FROM ordenpagoplandepago 
			WHERE codigoestado = '100'
			and (codigoindicadorprocesosap = '300' or codigoindicadorprocesosap = '200') 
			and numerorodenpagoplandepagosap = '$ordenpago'";
		  //echo $query_dataestudiante;
		   $ordenconplan = mysql_query($query_ordenconplan, $sala) or die("$query_ordenconplan".mysql_error());
		   $row_ordenconplan = mysql_fetch_assoc($ordenconplan);
		   $totalRows_ordenconplan = mysql_num_rows($ordenconplan);
		   
		   $indicadorplancuotapaga = '';
		     
		   if ($totalRows_ordenconplan >= '1')
		    {
			  $indicadorplancuotapaga = '1';
			 // echo 'Pagas<br>';
			} 	 
		  /*  else
		    {
			// Miro si tiene garantias.		  
		    $query_ordencongarantia = "SELECT *  
			FROM ordenpagoplandepago 
			WHERE codigoestado = '100'
			and   codigoindicadorprocesosap	= '200'
			and numerorodenpagoplandepagosap = '$ordenpago'";
		  //echo $query_ordencongarantia;
		   $ordencongarantia = mysql_query($query_ordencongarantia, $sala) or die("$query_ordencongarantia".mysql_error());
		   $row_ordencongarantia = mysql_fetch_assoc($ordencongarantia);
		   $totalRows_ordencongarantia = mysql_num_rows($ordencongarantia);
		   
		   $indicadorplan = '';
		     
		   if ($row_ordencongarantia <> '')
		    {
			  $indicadorplan = '1';
			 // echo 'Plan<br>';
			} 	 
		  }	
	 // Miro si la orden papa tiene materias.
		   
		   $query_ordenconmaterias = "SELECT * 
		   FROM detalleprematricula 
		   WHERE numeroordenpago = '$ordenpago'";
		  //echo $query_dataestudiante;
		   $ordenconmaterias = mysql_query($query_ordenconmaterias, $sala) or die("$query_ordenconmaterias".mysql_error());
		   $row_ordenconmaterias = mysql_fetch_assoc($ordenconmaterias);
		   $totalRows_ordenconmaterias = mysql_num_rows($ordenconmaterias);
		   
		   $indicadormaterias = '';
		   //echo $indicadorplan,"---",$indicadorplancuotapaga,'<br>';
		     
		   if ($row_ordenconmaterias <> '' and ($indicadorplan == '1' or $indicadorplancuotapaga == '1'))
		    {
			  $indicadormaterias = '1';
			  //echo "materias<br>";
			}			    */
		   
		  if ($indicadorplancuotapaga == '1' and $text <> 'BLOQUEO')
		   {
		     $tmp = serialize($valorconcepto); 
             echo "<!-- <td><a href='generarorden.php?ordenpago=$ordenpago&cxc=$cxc&cxp=$cxp&fechalimite=$fechalimite&valores=$tmp'>Generar Orden Pago</a></td> -->";
           }
		  else
		  if ($text == 'BLOQUEO')
		   {
		    echo  "<!-- <td>Cuota bloqueada y enviada a Covinoc</td> -->";
		   }
		  else
		   {
		     echo "<!-- <td>&nbsp;</td> -->";
		   } 
?>	 
 </tr>	  
<?php	
  	  } // foreach 1
     
  } // if 1
//  saprfc_function_free($rfcfunction);
?>
</table>
<br>	
<?php 
@saprfc_close($rfc);
?>
