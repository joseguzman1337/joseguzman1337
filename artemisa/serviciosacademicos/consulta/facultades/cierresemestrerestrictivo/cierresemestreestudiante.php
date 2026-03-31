<?php
       mysql_select_db($database_sala,$sala);
	   $query_cierre = "SELECT m.nombremateria,m.codigomateria,d.codigomateriaelectiva,m.numerocreditos,g.idgrupo,p.codigoestudiante
	   FROM prematricula p,detalleprematricula d,materia m,grupo g
	   WHERE  p.codigoestudiante = '".$codigoestudiante."'
	   AND p.idprematricula = d.idprematricula
	   AND d.codigomateria = m.codigomateria
	   AND d.idgrupo = g.idgrupo
	   AND m.codigoestadomateria = '01'
	   AND g.codigoperiodo = '$periodoactual'
	   AND p.codigoestadoprematricula LIKE '4%'
	   AND d.codigoestadodetalleprematricula LIKE '3%'";
	   $cierre= mysql_query($query_cierre, $sala) or die(mysql_error());
	   $row_cierre= mysql_fetch_assoc($cierre);
	   $totalRows_cierre= mysql_num_rows($cierre);    
       $codigomateriaelectiva = 1;
     //$creditosperdidos = 0;////////******************************************
     do{
	         mysql_select_db($database_sala,$sala); 
			 $query_guardarhistorico =" SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,materia.codigomateria,corte.porcentajecorte,
			 planestudioestudiante.idplanestudio,planestudioestudiante.codigoestudiante,materia.numerocreditos,materia.notaminimaaprobatoria 
			 FROM detallenota,materia,corte,planestudioestudiante 
			 WHERE  materia.codigoestadomateria = '01' 
			 AND detallenota.codigomateria=materia.codigomateria 
			 AND detallenota.idcorte=corte.idcorte
			 AND planestudioestudiante.codigoestudiante = '".$codigoestudiante."'
			 AND detallenota.codigoestudiante = planestudioestudiante.codigoestudiante
			 AND detallenota.codigomateria = '".$row_cierre['codigomateria']."'
			 AND planestudioestudiante.codigoestadoplanestudioestudiante like '1%' 
			 AND corte.codigoperiodo = '$periodoactual'";		  
		     $guardarhistorico = mysql_query($query_guardarhistorico, $sala) or die(mysql_error());
		     $row_guardarhistorico = mysql_fetch_assoc($guardarhistorico);
		     $totalRows_guardarhistorico = mysql_num_rows($guardarhistorico);
			 
			 if (!$row_guardarhistorico)
			  {
			     $query_guardarhistorico =" SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,materia.codigomateria,corte.porcentajecorte,
				 materia.numerocreditos,materia.notaminimaaprobatoria 
				 FROM detallenota,materia,corte
				 WHERE  materia.codigoestadomateria = '01' 
				 AND detallenota.codigomateria=materia.codigomateria 
				 AND detallenota.idcorte=corte.idcorte				
				 AND detallenota.codigoestudiante = '".$codigoestudiante."'
				 AND detallenota.codigomateria = '".$row_cierre['codigomateria']."'		 
				 AND corte.codigoperiodo = '$periodoactual'";		  
				 $guardarhistorico = mysql_query($query_guardarhistorico, $sala) or die(mysql_error());
				 $row_guardarhistorico = mysql_fetch_assoc($guardarhistorico);
				 $totalRows_guardarhistorico = mysql_num_rows($guardarhistorico);
			  }
		  	 
			  $codigomateria = $row_guardarhistorico['codigomateria'];
			  $planestudio = $row_guardarhistorico['idplanestudio']; 
			  $notaminima = $row_guardarhistorico['notaminimaaprobatoria'];
			  $creditos = $row_guardarhistorico['numerocreditos'];	  
		  
		  $idlinea = 0;
		  $tipomateria = 0;
		  mysql_select_db($database_sala,$sala);
		  $query_Recordset ="select codigotipomateria
		  from detalleplanestudio
		  where codigomateria = '$codigomateria'
		  and idplanestudio = '$planestudio'
		  and codigoestadodetalleplanestudio like '1%'";
		  //echo $query_Recordset,"</br>";
		  $Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());
		  $row_Recordset = mysql_fetch_assoc($Recordset);
		  $totalRows_Recordset = mysql_num_rows($Recordset);
		  
		    if ($row_Recordset <> "")
			  {// if 1
			    $tipomateria = $row_Recordset['codigotipomateria'];
			    $idlinea = 1;
			  }  // if 1
		  else
			 if (!$row_Recordset)
			  {// if 2
				 mysql_select_db($database_sala,$sala);
				 $query_Recordset ="select codigomateria
				 from detallegrupomateria
				 where codigomateria = '$codigomateria'";
				//echo $query_Recordset,"</br>";
				  $Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());
				  $row_Recordset = mysql_fetch_assoc($Recordset);
				  $totalRows_Recordset = mysql_num_rows($Recordset);
			 
			       if ($row_Recordset <> "")
			        {
			          $tipomateria = 4;
			          $idlinea = 1;
			        }
		            else
			         if (!$row_Recordset)
			          {// if 3
		                    mysql_select_db($database_sala,$sala);
							$query_Recordset ="select idlineaenfasisplanestudio,codigotipomateria
							from detallelineaenfasisplanestudio
							where codigomateriadetallelineaenfasisplanestudio = '$codigomateria'
						    and idplanestudio = '$planestudio'
						    and codigoestadodetallelineaenfasisplanestudio like '1%'";
						    //echo $query_Recordset,"</br>";
						    $Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());
						    $row_Recordset = mysql_fetch_assoc($Recordset);
						    $totalRows_Recordset = mysql_num_rows($Recordset);
							  if ($row_Recordset <> "")
								 {
									 $idlinea = $row_Recordset['idlineaenfasisplanestudio'];														 													
								     $tipomateria = $row_Recordset['codigotipomateria'];
								 }	
											
					   }//if 3
			  } // if 2 
		  if ($row_guardarhistorico <> "")
		   {
		      $notafinal = 0;					 
				  do 
					{					    
					  unset($resultado);
		              $flag = 0;
				      if ($noaplica <> "")
					   {
					     foreach($noaplica as $value => $key)
					     {
						  $validaestudiante = explode("-", $key);
						  if ($codigoestudiante == $validaestudiante[0] and $row_cierre['codigomateria'] == $validaestudiante[1])
						   {
						    $flag = 1;
						   }						  
						 }				   
					   }  
					  /* if ($flag == 1)
					   {
					     echo $validaestudiante[0],"--",$validaestudiante[1];
						 exit();
					   } */
					  $tiponota  = '100';
					  if ($flag == 0)
					   {
					    $resultado = validafallas ($row_cierre['codigomateria'],$row_cierre['idgrupo'],$codigoestudiante,$sala);
					   }
					 
					  if (is_array($resultado))
					   {
						 $notafinal = '0';
					     $tiponota  = '102';
					   }		 
					  else
					   {
						 $notafinal = $notafinal + ($row_guardarhistorico['nota'] * $row_guardarhistorico['porcentajecorte'])/100;				 
					   }
					
					
					}while($row_guardarhistorico = mysql_fetch_assoc($guardarhistorico));

            //$notafinal = number_format($notafinal,1);
			//$notafinal=round($notafinal * 10)/10;	
			$notafinal = redondeo($notafinal);			
			
			mysql_select_db($database_sala,$sala);
			$query_confirma ="select * from notahistorico
			where codigoestudiante = '".$codigoestudiante."'
	        and codigomateria = '".$codigomateria."'
		    and codigoperiodo = '".$periodoactual."' 
		    and notadefinitiva like '$notafinal%'
		    and (codigotiponotahistorico = '100' or codigotiponotahistorico = '102') ";
		    // echo $query_confirma,"</br>";
			$confirma = mysql_query($query_confirma, $sala) or die(mysql_error());
			$row_confirma = mysql_fetch_assoc($confirma);    
				
			 $codigomateriaelectiva = 1;
			 if ($row_cierre['codigomateriaelectiva'] <> "" or $row_cierre['codigomateriaelectiva'] <> 0)
			  {
			    $codigomateriaelectiva = $row_cierre['codigomateriaelectiva'];
			  }
			if ($planestudio == "")
			 {
			  $planestudio = 1; 
			 }
			 if ($idlinea == 0)
			 {
			   $idlinea = 1;
			 }
			 if ($tipomateria == 0)
			  {
			    $tipomateria = 1;
			  }
			  
			  if ($codigomateriaelectiva == 0)
			    {
				  $codigomateriaelectiva = 1;
				}
			 
			if ($row_confirma == "")
			   {			      
				$sql = "insert into notahistorico(codigoperiodo,codigomateria,codigomateriaelectiva,codigoestudiante,notadefinitiva,codigotiponotahistorico,origennotahistorico,fechaprocesonotahistorico,idgrupo,idplanestudio,idlineaenfasisplanestudio,observacionnotahistorico,codigoestadonotahistorico,codigotipomateria)";
			    $sql.= "VALUES('".$periodoactual."','".$codigomateria."','".$codigomateriaelectiva."','".$codigoestudiante."','".$notafinal."','$tiponota','10','".date("Y-m-d G:i:s",time())."','".$row_cierre['idgrupo']."','".$planestudio."','".$idlinea."','','100','".$tipomateria."')"; 
			    $result = mysql_query($sql,$sala);	         
		       }  
		  }	  
}while($row_cierre= mysql_fetch_assoc($cierre));   

?>