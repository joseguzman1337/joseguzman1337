<?

 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 include_once "../inc/"."parametros.inc.php";  
 $link=Conexion();

 include_once "../inc/"."identif.php";
 Administracion();
 if (!isset($Fecha_Recepcion)){$Fecha_Recepcion='';}

?> 
<html>

<head>
<title><? echo Titulo_Sitio();?></title>
</head>

<body>
<P>
<?

  include_once "../inc/"."fgenhist.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."parametros.inc.php";
  include_once "../inc/"."network.inc";
  include_once "../inc/funcarch.php";
  global $IdiomaSitio;
   $Mensajes = Comienzo ("rev-001",$IdiomaSitio);

function vectorTieneArchivos($_FILES)
{
	$retorno =(($_FILES['userfile']['size'] != 0) || ($_FILES['userfile1']['size'] != 0) ||($_FILES['userfile2']['size'] != 0) || ($_FILES['userfile3']['size'] != 0) || ($_FILES['userfile4']['size'] != 0));
  return $retorno;
}


function subirArchivosYAociar($Id,$_FILES)
//toma el vector de files y sube y asocia todos los archivos con el pedido cuyo Id es $Id
{
	if ($_FILES['userfile']['size'] != 0) {
	   

                $nombre=$Id."_01.pdf";
				upload_File($nombre,$_FILES['userfile']['tmp_name']);
			    asociarPedidoAArchivo($Id,$nombre, 1,0);
			         }

				if ($_FILES['userfile1']['size'] != 0)
					{ 
                    $nombre=$Id."_02.pdf";
     			    upload_File($nombre,$_FILES['userfile1']['tmp_name']);
	     		    asociarPedidoAArchivo($Id,$nombre, 1,0);
			        }
			    if ($_FILES['userfile2']['size'] != 0) 
					{
					$nombre=$Id."_03.pdf";
            		upload_File($nombre,$_FILES['userfile2']['tmp_name']);
			        asociarPedidoAArchivo($Id,$nombre, 1,0);
			       }
			    if ($_FILES['userfile3']['size'] != 0) 
				   {
               		$nombre=$Id."_04.pdf";
    			    upload_File($nombre,$_FILES['userfile3']['tmp_name']);
		    	    asociarPedidoAArchivo($Id,$nombre, 1,0);
			       }
			    if ($_FILES['userfile4']['size'] != 0)
					{
                     $nombre=$Id."_05.pdf";
   				     upload_File($nombre,$_FILES['userfile4']['tmp_name']);
			         asociarPedidoAArchivo($Id,$nombre, 1,0);
			        }


}
   
?>
   
<script language="JavaScript">

function actualizar ()
{
	
	<?
		switch($Modo)
		{
		case 1:
		case 2:
		case 3:
		case 4:
            $accion="busqueda.php";
			break;
		case 5:	
			$accion="manpedadm.php";
			break;
		case 11: 
			$accion="manpedadmc.php";
			break;
		case 12:
			$accion="manpedustodos.php";
			break;
		case 13:
			$accion="manpedcolecc.php";
			break;
		case 14:
			$accion="manpedcoltl.php";			
			break;
		case 15:
			$accion="manpeddest.php";			
			break;			
		}	
	?>
   
	window.close();
    window.opener.document.forms.form2.action='<? echo $accion; ?>';
    window.opener.document.forms.form2.Modo.value=<? echo $Modo; ?>;
    window.opener.document.forms.form2.submit(); 
	    
    return true;
}
</script>

<p>
<?
  if (!isset($operacion))
  {
    	if ( ereg( "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $Fecha_Recepcion, $regs ) ) 
       {
       	 $FechaHoy = $Fecha_Recepcion;
       }
       else
       {
       	   $Dia = date ("d");
           $Mes = date ("m");
           $Anio = date ("Y");
           $FechaHoy =$Anio."-".$Mes."-".$Dia;
        }

     
        if (!isset($Paises))
    	 {
       	$Paises = 0;       
    	  }
    
    	 if (!isset($Instituciones))
    	 {
      		$Instituciones = 0;
    	 }
    
    	 if (!isset($Dependencias))
    	 {
      		$Dependencias = 0;
    	  }
    
    	 if (!isset($Numero_Paginas))
    	 {
      		$Numero_Paginas = 0;
    	 }
      
    	 if (isset($Es_Privado))
    	 {
      		$Es_Privado = 1;
    	  }
    	 else
    	 {
      		$Es_Privado = 0; 
    	 }
    
    
    	 
    	 $Instruccion = armar_expresion_busqueda();
    	 $Instruccion = $Instruccion."WHERE Pedidos.Id='".$Id."'";
    	 //echo $Instruccion;
    	 $result = mysql_query($Instruccion); 
    	 $row = mysql_fetch_row($result);
		 $usuario = $row[39];
		 
		
    	 // esto se usa para controlar la concurrencia en la toma de los pedidos
    	 // pendientes. Buscar otra forma
    
    	 if (true)
     	 {
          /*  if (Devuelve_Evento_PDFEnviado() == $Evento)
             { //Si se subieron archivos, los mismos se envían a la carpeta correspondiente
			   //y se asocia el pedido con el o los archivos
			   //Observar que a la funcion asociarPedidoAArchivo se le pasa el parámetro
			   if ($_FILES['userfile']['size'] != 0) {
			   upload_File($_FILES['userfile']['name'],$_FILES['userfile']['tmp_name']);
			    asociarPedidoAArchivo($Id,$_FILES['userfile']['name'], 1,0);
			   }
			    if ($_FILES['userfile1']['size'] != 0) { 
			    upload_File($_FILES['userfile1']['name'],$_FILES['userfile1']['tmp_name']);
			     asociarPedidoAArchivo($Id,$_FILES['userfile1']['name'], 1,0);
			    }
			    if ($_FILES['userfile2']['size'] != 0) {
			    upload_File($_FILES['userfile2']['name'],$_FILES['userfile2']['tmp_name']);
			     asociarPedidoAArchivo($Id,$_FILES['userfile2']['name'], 1,0);
			    }
			    if ($_FILES['userfile3']['size'] != 0) {
			    upload_File($_FILES['userfile3']['name'],$_FILES['userfile3']['tmp_name']);
			     asociarPedidoAArchivo($Id,$_FILES['userfile3']['name'], 1,0);
			    }
			    if ($_FILES['userfile4']['size'] != 0) {
                  upload_File($_FILES['userfile4']['name'],$_FILES['userfile4']['tmp_name']);
			     asociarPedidoAArchivo($Id,$_FILES['userfile4']['name'], 1,0);
			    }
	     }*/
            if(!isset($Es_Privado)) {$Es_Privado = 0;}


     		$Instruccion = "INSERT INTO Eventos (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
     		$Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas) VALUES ('".$Id."',".$Evento.",".$Paises.",".$Instituciones.",".$Dependencias;
     		$Instruccion = $Instruccion.",'".$FechaHoy."','".AddSlashes($Observaciones)."',".$Operador.",".$Es_Privado.",".$Numero_Paginas.")";
            
     		$result = mysql_query($Instruccion);
			$Id_Evento = mysql_insert_id();     		
			
     		echo mysql_error();                

     		if (mysql_affected_rows()>0)       
    		{
    		
    		   // Si no valida la fecha ingresada
    		   // asigna la fecha de hoy
    		   
   				if ( ereg( "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $Fecha_Recepcion, $regs ) ) 
      			{
      	 		  $DiaHoy = $Fecha_Recepcion;
      			}
      			else
      			{
       	 	  $Dia = date ("d");
           	  $Mes = date ("m");
           	  $Anio = date ("Y");
           	  $DiaHoy =$Anio."-".$Mes."-".$Dia;
       		}    
    		 	$Estado = Determinar_Estado ($Evento);
		         //echo "<h1> Evento: ".$Evento.", estado: ".$Estado."</h1>";;
	
    		 	switch ($Estado)
    		 	{
    		   		case Devuelve_Evento_Solicitado():
    		   				
		   			
    		      		$Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador.",Estado=".$Estado.",Ultimo_Pais_Solicitado=".$Paises.",Ultima_Institucion_Solicitado=".$Instituciones.",Ultima_Dependencia_Solicitado=".$Dependencias.",Fecha_Solicitado='".$DiaHoy."' WHERE Pedidos.Id='".$Id."'";
						$Evento_Me_Interesa=1;
					//	echo $DescDepe;
						$Biblioteca_Destino=$DescDepe;
						$Request=$Observaciones;
    		      		break;
    		         
    		   		case Devuelve_Evento_Tomado():
    		    
    		      		$Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador.",Estado=".$Estado.",Fecha_Inicio_Busqueda='".$DiaHoy."' WHERE Pedidos.Id='".$Id."'";
    		      		break;
    		      
    		   		case Devuelve_Evento_recepcion():
    		   
    		     		// Las tardanzas se calculan aca para permitir que
    		     		// sean modificadas de acuerdo a características especiales
    		     		// feriados, paros, etc.
    		     		
    		     		// Hay algunos datos que no tienen fecha de Inicio de Busqueda
    		     		// Se reasignan contra fecha de alta. Son aquellos
						// Datos que transladan un viejo error del soft
    		      
    		           if ($row[35]=="") { $row[35]=$DiaHoy; }
					   if ($row[47]=="") { $row[47]=$row[35]; }       		             		          
      		           if ($row[40]=="") { $row[40]=$DiaHoy; }
      		          
					       		               
                 		$Tardanza_Atencion = Calcular_Dias($row[35],$row[47]);
       		  		    $Tardanza_Busqueda = Calcular_Dias($row[47],$row[40]);
				  		$Tardanza_Recepcion = Calcular_Dias($row[40],$DiaHoy);

    		   
  
						

/* Si fue recibido y aparte hay archivos, entonces pasa a SolicitarPDF */
$hayArchivos = vectorTieneArchivos($_FILES);

       if($hayArchivos) {
               		   subirArchivosYAociar($Id,$_FILES);

   	   		      		$Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador;
    		      		$Instruccion = $Instruccion.",Estado=".Devolver_Estado_SolicitarPDF().",Ultimo_Pais_Solicitado=".$Paises.",Ultima_Institucion_Solicitado=";
    		      		$Instruccion = $Instruccion.$Instituciones.",Ultima_Dependencia_Solicitado=".$Dependencias.",Numero_Paginas=".$Numero_Paginas;
    		      		$Instruccion = $Instruccion.",Fecha_Recepcion='".$DiaHoy."',Tardanza_Atencion=".$Tardanza_Atencion.",Tardanza_Busqueda=".$Tardanza_Busqueda;
    		      		$Instruccion = $Instruccion.",Tardanza_Recepcion=".$Tardanza_Recepcion;
    		      		$Instruccion = $Instruccion." WHERE Pedidos.Id='".$Id."'"; 

	     }
      else  //Si no habia archivos, se registra como listo para entrega
			{ 
	   		      		$Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador;
    		      		$Instruccion = $Instruccion.",Estado=".$Estado.",Ultimo_Pais_Solicitado=".$Paises.",Ultima_Institucion_Solicitado=";
    		      		$Instruccion = $Instruccion.$Instituciones.",Ultima_Dependencia_Solicitado=".$Dependencias.",Numero_Paginas=".$Numero_Paginas;
    		      		$Instruccion = $Instruccion.",Fecha_Recepcion='".$DiaHoy."',Tardanza_Atencion=".$Tardanza_Atencion.",Tardanza_Busqueda=".$Tardanza_Busqueda;
    		      		$Instruccion = $Instruccion.",Tardanza_Recepcion=".$Tardanza_Recepcion;
    		      		$Instruccion = $Instruccion." WHERE Pedidos.Id='".$Id."'"; 
	             }
          /* fin actualiazacion PDF */

				   		break;	   		    
  				
 					case Devuelve_Evento_Observado():
  				
  				  		$Instruccion = "UPDATE Pedidos SET Observado=1 WHERE Id='".$Id."'";
    		      		break;
						
    		       case Devuelve_Evento_Entrega():
  				
  				  		$Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador.",Estado=".$Estado.",Fecha_Entrega='".$DiaHoy."' WHERE Pedidos.Id='".$Id."'";
    		      		break;

					case Devuelve_Evento_PDFEnviado():
						   //subirArchivo($archivo);
						   
						   //echo "<h1> En Evento PDF Enviado".$archivo."</h1>";
						   //asociarPedidoAArchivo($Id,$archivo, 1,0);
						   break;
				
           		default:
    		   
    		      		$Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador.",Estado=".$Estado.",Numero_Paginas=".$Numero_Paginas." WHERE Pedidos.Id='".$Id."'";
    		      
 
    		 		}
	
    		 	$result = mysql_query($Instruccion); 
    		 	echo mysql_error();			
		     
		    	// Recordar que puede pasar a historico
		    	// por ejemplo por desición del usuario
		    	// ante ser pago, con lo cual si cancela siempre va a 
		    	// pasar por aca, cuando entrega pasa por opera_ped.php 
		    
		    			    			  
			 	if (Pasa_Historico($Estado)==1)
    		 	{    
    		   		 Bajar_Historico($Id);
    		 	}
    		 
    		 	if ($Env_Mail=="ON")
    		 		// Ahora me ocupo de recuperar la plantilla adecuada de acuerdo 
    		 		// al tipo de evento generado y reemplazar los caracteres variables
    		 		// de la misma
					// Modificación 30-4 : En caso de ser el perfil bibliotecario
					// quien creó este pedido mandar al mail del bibliotecario
					// $Mail proviene de la consulta original del pedido y se translada
					// hasta aquí
    		 	{
						If ($RolCreador==2)
						{
							// Implica que el usuario que generó el pedido del que se
							// trata es bibliotecario y debería tener su e-mail
							$Instruccion = "SELECT EMail FROM Usuarios WHERE Id=".$IdCreador;
							$result = mysql_query($Instruccion);
							$rowz=mysql_fetch_array($result);
							if ($rowz!="")
							{
								$Mail.=",".$rowz[0];
							}	
							
						}
						if (!isset($hayArchivos))
							  $hayArchivos = 0;
						if ($hayArchivos) {
							  $Evento = Devuelve_Evento_PDFEnviado();
						} 
    		   			$Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Cuando_Usa=".$Evento;
				        //echo $Instruccion;
						$result = mysql_query($Instruccion);
						echo mysql_error();    		   
    		   			$roww = mysql_fetch_array($result);
    		   			if (mysql_num_rows($result)<=0)
					      {
						   $roww[0]='';
                           $roww[1]='';
						  }
						$cita = Devolver_Descriptivo_Material_Email($row[4],$row,1,0);
    		   			$roww[1]=reemplazar_variables ($roww[1],$Id,$Nombre,$Numero_Paginas,$cita,0,"","",""); 
						
						
    		  	} 
    		

//ya se registró toda la información. Si no checkeó la opcion de enviar email, se cierra la ventana.
if (!isset($Env_Mail)) { 

   echo "<script> 
           window.close();
		   window.opener.location.reload(true);
         </script>";
   return;
}
?>
<p>

<div align="center">
  <center>
  
<form method="POST" action="reg_evento.php?operacion=1">

<table border="0" width="75%" height="1" cellspacing="0">
  <tr>
    <td width="136%" valign="top" height="21" bgcolor="#006699">
    <font face="MS Sans Serif" size="2" color="#FFFFCC">&nbsp;
    <b><? echo $Mensajes["tf-1"]; ?>&nbsp;</b><?echo $Id; ?></font>
    </td>
  </tr>
  <tr>
    <td width="187%" height="15" valign="top" align="center">
    </td>
  </tr>
  <tr>
    <td width="187%" height="15" valign="top" align="center">
    <font face="MS Sans Serif" size="1" color="#0000FF">
    <? echo $Mensajes["tf-2"]; ?></font>
    </td>
  </tr>
  <tr>
    <td width="187%" height="15" valign="top" align="center">
    </td>
  </tr>
  </center>

  <tr>
    <td width="187%" height="15" valign="top" align="center">
    <p align="left">
    <input type="text" name="Direccion" size="51" value="<? if ($Env_Mail=="ON"){echo $Mail; } ?>"></p>
    </td>
  </tr>
  <tr>
    <td width="187%" height="15" valign="top" align="center">
    <p align="left"><font face="MS Sans Serif" size="1" color="#FF0000">
    <input type="checkbox" name="Corrige_Direccion" value="ON">  <? echo $Mensajes["tf-3"]; ?></font></p>
    </td>
  </tr>
  <tr>
    <td width="187%" height="15" valign="top" align="center">
    <p align="left">
    <input type="text" name="Asunto" size="51" value="<? if (isset($Env_Mail)) {if(isset($roww)){ echo $roww[0];} } ?>" ></p>
    </td>
  </tr>
  <tr>
    <td width="187%" height="15" valign="top" align="center">
     <p align="left">
     <font face="MS Sans Serif" size="1">
     <textarea rows="8" cols="54" name="Texto"><? if(isset($roww)) {echo $roww[1];} ?></textarea>
     </font>
     </p>
    </td>
  </tr>
</table>

  <input type="hidden" name="usuario" value="<? echo $usuario; ?>">
  <input type="hidden" name="Id" value="<? echo $Id; ?>">
  <input type="hidden" name="Modo" value="<? echo $Modo; ?>">
  <input type="hidden" name="Id_Evento" value ="<? echo $Id_Evento; ?>">
  <input type="hidden" name="Paises" value ="<? echo $Paises; ?>">
  <input type="hidden" name="Instituciones" value ="<? echo $Instituciones; ?>">
  <input type="hidden" name="Dependencias" value ="<? echo $Dependencias; ?>">
  <input type="hidden" name="Evento_Me_Interesa" value ="<? echo $Evento_Me_Interesa; ?>">
  <input type="hidden" name="Request" value ="<? echo $Request; ?>">
  <input type="hidden" name="Biblioteca_Destino" value ="<? echo $Biblioteca_Destino; ?>">

   <p align="center">
   <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B3" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold"></p>
</form>
</div>


<?                }
    }
    else
   { 
 
 ?>
<p>&nbsp;</p>
<p align="center"><font face="MS Sans Serif" size="2" color="#800000"><b><? echo $Mensajes["err-1"]; ?></b></font></p>
<p>&nbsp;
<form method="POST">
   <p align="center">
   <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" OnClick="actualizar()" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold"></p>
</form>
<?   } ?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>
rev-001</FONT></P>
<?
  }
  else
  {
    if ($Direccion!="")
    {
      $Dia = date ("d");
      $Mes = date ("m");
      $Anio = date ("Y");
      $fecha =$Anio."-".$Mes."-".$Dia;
     
      $hora = strftime ("%H:%M:%S"); 

  	  $Instruccion = "INSERT INTO mail (Codigo_usuario,Fecha,Hora,Direccion,Asunto,Texto,Codigo_Pedido)";
  	  $Instruccion = $Instruccion." VALUES ($usuario,'$fecha','$hora','$Direccion','$Asunto','$Texto','$Id')";
  	  $result = mysql_query($Instruccion);
  	  echo mysql_error();
  	  $Correo = mysql_insert_id();
  	  
  	  mail ($Direccion,$Asunto,$Texto,"From:".Destino_Mail());
  	  
  	  $Instruccion = "UPDATE Eventos SET Id_Correo=".$Correo." WHERE Id=".$Id_Evento;
  	  $result = mysql_query($Instruccion);
  	    	  
  	  
  	  if ($Corrige_Direccion=="ON")
  	  {
  	  	$Instruccion = "UPDATE Usuarios SET EMail='".$Direccion."' WHERE Id=".$usuario;
       $result = mysql_query($Instruccion);
  	    echo mysql_error(); 
  	  }
	  
	  // Esta sería la última parte de la generación de los eventos
	  // aca voy a chequear si es o no un evento de envio 
	  // y voy a intentar generar el pedido en la ubicación remota
	 
	  
  	 } 
	 if (Celsius_se_Conecta() && $Evento_Me_Interesa==1)
     {
	  	Generar_Pedido_Remoto($Paises,$Instituciones,$Dependencias,$Id,$link,$Request,$Biblioteca_Destino);
	 } 
	 
?>

<script language="Javascript">
	actualizar()
</script>
<? 
  }  		  	

 mysql_close($link);
  ?>
</body>




























































































