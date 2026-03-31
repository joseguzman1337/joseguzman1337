<?php          
		 // $codigoestudiante = '01171030';
		 // $periodoactual = '20051';
		  mysql_select_db($database_sala,$sala);
		  $query_Recordset9 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante,
		                       eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,eg.numerodocumento
								FROM prematricula p,detalleprematricula d,materia m,grupo g,estudiante e,estudiantegeneral eg
								WHERE  p.codigoestudiante = '".$codigoestudiante."'
								and eg.idestudiantegeneral = e.idestudiantegeneral
								and p.codigoestudiante = e.codigoestudiante
								AND p.idprematricula = d.idprematricula
								AND d.codigomateria = m.codigomateria
								AND d.idgrupo = g.idgrupo
								AND m.codigoestadomateria = '01'
								AND g.codigoperiodo = '".$periodoactual."'
								AND p.codigoestadoprematricula LIKE '4%'
								AND d.codigoestadodetalleprematricula LIKE '3%'
								order by 1";
							//AND g.codigomaterianovasoft = m.codigomaterianovasoft
	//echo $query_Recordset9,"<br><br><br><br>";
	//exit();
	$Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
	$row_Recordset9 = mysql_fetch_assoc($Recordset9);
	$totalRows_Recordset9 = mysql_num_rows($Recordset9);
     do{        
			$nombre = $row_Recordset9['apellidosestudiantegeneral']."&nbsp;".$row_Recordset9['nombresestudiantegeneral'];
			
			if ($row_Recordset9 == "")
			 {
			   $query_study = "SELECT *
								FROM estudiantegeneral eg,estudiante e
								WHERE  e.codigoestudiante = '".$codigoestudiante."'
								and eg.idestudiantegeneral = e.idestudiantegeneral
								";
							//AND g.codigomaterianovasoft = m.codigomaterianovasoft
				//echo $query_Recordset9,"<br><br><br><br>";
				//exit();
				$study = mysql_query($query_study, $sala) or die(mysql_error());
				$row_study = mysql_fetch_assoc($study);
				$totalRows_study = mysql_num_rows($study);
			    
				$row_Recordset9['numerodocumento'] = $row_study['numerodocumento']; ; 
			    $nombre = $row_study['apellidosestudiantegeneral']."&nbsp;".$row_study['nombresestudiantegeneral'];
			 }			
			$codigomateria = $row_Recordset9['codigomateria'];
			$nombremateria = $row_Recordset9['nombremateria']; 
			
			 mysql_select_db($database_sala,$sala);
			 $query_Recordset8 ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,
			                    corte.porcentajecorte
								FROM detallenota,materia,corte
								WHERE  materia.codigoestadomateria = '01'
								AND detallenota.codigomateria=materia.codigomateria
								AND detallenota.idcorte=corte.idcorte
								AND detallenota.codigoestudiante = '".$codigoestudiante."'
								AND detallenota.codigomateria = '".$codigomateria."'
								AND corte.codigoperiodo = '".$periodoactual."'
								";							
		   // echo $query_Recordset8,"<br><br><br>";
		
		  $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());
		  $row_Recordset8 = mysql_fetch_assoc($Recordset8);
		  $totalRows_Recordset8 = mysql_num_rows($Recordset8);  
		  
		  
		  $porcentaje = 0;    
		  do{	    
			 $porcentaje = $porcentaje + $row_Recordset8['porcentajecorte'];	    
		   }while($row_Recordset8 = mysql_fetch_assoc($Recordset8));           
		  
		     if ($porcentaje < 100 or $porcentaje > 100)
			   { //if 2
			        $banderaporcentaje = 1;	
					 $numerodocumentototal[$contadorfaltantes] = $row_Recordset9['numerodocumento'];
					 $codigototal[$contadorfaltantes]=$codigoestudiante;	        
					 $nombretotal[$contadorfaltantes]=$nombre;
					 $codigomateriatotal[$contadorfaltantes]=$codigomateria;
					 $nombremateriatotal[$contadorfaltantes]=$nombremateria;
					 $faltante[$contadorfaltantes] = (100 - $porcentaje);		   
			      ///echo $codigototal[$contadorfaltantes],'&nbsp;&nbsp;',$faltante[$contadorfaltantes],'&nbsp;&nbsp;',$nombremateriatotal[$contadorfaltantes],'&nbsp;&nbsp;',$nombretotal[$contadorfaltantes],"<br>"; 
				  $contadorfaltantes++;
			   } //if 2
}while($row_Recordset9 = mysql_fetch_assoc($Recordset9));
//exit();
//echo "hola";
?>