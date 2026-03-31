<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	if ($_POST['eps'] <> 0)
	 {
	   $pos=$_POST['eps'];  
	 }
	else
	 {
	   $pos = 1;
	 }	
		mysql_select_db($database_sala, $sala);
		$query_documentos = "SELECT * 
		                     FROM documentacion d,documentacionfacultad df
							 where d.iddocumentacion = df.iddocumentacion
							 and df.codigocarrera = '$carrera'
							 and df.fechainiciodocumentacionfacultad <= '".date("Y-m-d")."'
							 and df.fechavencimientodocumentacionfacultad >= '".date("Y-m-d")."'
							 AND (df.codigogenerodocumento = '300' 
							 OR df.codigogenerodocumento = '".$row['codigogenero']."')";
		//echo $query_documentos,"<br>";
		$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
		$row_documentos = mysql_fetch_assoc($documentos);
		$totalRows_documentos = mysql_num_rows($documentos);
		$doc = 1;
		  do
			{	   
			   mysql_select_db($database_sala, $sala);
				$query_documentosestuduante = "SELECT * 
				                               FROM documentacionestudiante d
											   where d.codigoestudiante = '".$codigo."'
											   and d.iddocumentacion = '".$row_documentos['iddocumentacion']."'
											   and codigoperiodo = '".$periodoactual."'";
				///echo $query_documentosestuduante,"<br>";and d.fechainiciodocumentacionestudiante <= '".date("Y-m-d")."'
									          /* and d.fechavencimientodocumentacionestudiante >= '".date("Y-m-d")."'
											   and codigotipodocumentovencimiento = '100'
											   AND d.codigotipodocumentovencimiento = t.codigotipovencimientodocumento */			
				//echo $query_documentosestuduante,"<br>";
				$documentosestuduante  = mysql_query($query_documentosestuduante , $sala) or die(mysql_error());
				$row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante );
				$totalRows_documentosestuduante  = mysql_num_rows($documentosestuduante );	
			   
			   if (!$row_documentosestuduante)
			     {
				   if($_POST["documento".$doc] <> "")
				    {
					   $sql = "insert into documentacionestudiante(codigoestudiante,iddocumentacion,codigoperiodo,fechainiciodocumentacionestudiante,fechavencimientodocumentacionestudiante,codigotipodocumentovencimiento,idempresasalud)";
					   $sql.= "VALUES('".$codigo."','".$_POST["documento".$doc]."','".$periodoactual."','".date("Y-m-d")."','".$_POST["fecha".$doc]."','100','".$pos."')"; 
					   //echo $sql,"<br>";
					   //exit();
					   $result = mysql_query($sql,$sala);		 
				    }
				 } 
		     else
			   {
			    
				if($_POST["documento".$doc] <> "")
				    {
					   if ($_POST["documento".$doc] == 20)
					    {
							$base="update documentacionestudiante set  
								   fechavencimientodocumentacionestudiante = '".$_POST["fecha".$doc]."',
								   codigotipodocumentovencimiento = '100',
								   idempresasalud = '".$pos."'			   
								   where codigoestudiante = '".$codigo."'
								   and iddocumentacion = '".$_POST["documento".$doc]."'					   
								   and codigoperiodo = '".$periodoactual."'";           
						  // echo $base,"<br>";
						   $sol=mysql_db_query($database_sala,$base);				  
				       }
				      else
					   {
					     $base="update documentacionestudiante set  
								   fechavencimientodocumentacionestudiante = '".$_POST["fecha".$doc]."',
								   codigotipodocumentovencimiento = '100'				   
								   where codigoestudiante = '".$codigo."'
								   and iddocumentacion = '".$_POST["documento".$doc]."'					   
								   and codigoperiodo = '".$periodoactual."'";           
						  // echo $base;
						   $sol=mysql_db_query($database_sala,$base);				
					   
					   }
					}			   
			   }
		 
		 $doc++;
		 //exit();
		 }while($row_documentos = mysql_fetch_assoc($documentos));
				
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultadocumentacionformulario.php?codigo=".$codigo."'>";
?>		   