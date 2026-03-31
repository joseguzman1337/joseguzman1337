<?php  
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$creditos=0;

///////////////////////////  PROMEDIO SEMESTRAL PERIODO EN PRECIERRE  ////////////////////////////////////////
mysql_select_db($database_sala,$sala);
$query_promediosemestral = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
						FROM prematricula p,detalleprematricula d,materia m,grupo g
						WHERE  p.codigoestudiante = '".$codigoestudiante."'
						AND p.idprematricula = d.idprematricula
						AND d.codigomateria = m.codigomateria
						AND d.idgrupo = g.idgrupo
						AND m.codigoestadomateria = '01'
						AND g.codigoperiodo = '".$periodo."'
						AND p.codigoestadoprematricula LIKE '4%'
						AND d.codigoestadodetalleprematricula LIKE '3%'";
						//AND g.codigomaterianovasoft = m.codigomaterianovasoft
//echo $query_Recordset1,"</br>";
$promediosemestral = mysql_query($query_promediosemestral, $sala) or die(mysql_error());
$row_promediosemestral = mysql_fetch_assoc($promediosemestral);
$totalRows_promediosemestral = mysql_num_rows($promediosemestral);

 if ($row_promediosemestral <> "")
 {// if1
      $promedio=0;	  
	  $numerocreditos = 0;

do{
////////////////////////	
	$contador= 1;
	mysql_select_db($database_sala, $sala);
	$query_calculopromediosemestral ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,grupo.codigomateria,corte.porcentajecorte 
						FROM detallenota,materia,grupo,corte 
						WHERE  materia.codigomateria=grupo.codigomateria 
						AND materia.codigoestadomateria = '01'
						AND detallenota.idgrupo=grupo.idgrupo 
						AND detallenota.idcorte=corte.idcorte 
						AND detallenota.codigoestudiante = '".$codigoestudiante."'
						AND detallenota.idgrupo = '".$row_promediosemestral['idgrupo']."'  
						AND grupo.codigoperiodo = '".$periodo."'";
						//AND materia.codigomaterianovasoft=grupo.codigomaterianovasoft 
  //echo $query_Recordset8,"</br>";
  //exit;
  $calculopromediosemestral = mysql_query($query_calculopromediosemestral, $sala) or die(mysql_error());
  $row_calculopromediosemestral = mysql_fetch_assoc($calculopromediosemestral);
  $totalRows_calculopromediosemestral = mysql_num_rows($calculopromediosemestral);	
	
     $numerocreditos = $numerocreditos + $row_promediosemestral['numerocreditos'];
       
	       $habilitacion = "";
		   $notafinal = 0;
		   $porcentajefinal = 0;
		  do{
	         if ($row_calculopromediosemestral['codigotiponota'] == 10)
			 {
			 $notafinal = $notafinal + ($row_calculopromediosemestral['nota'] * $row_calculopromediosemestral['porcentajecorte'])/100;
			 $porcentajefinal = $porcentajefinal + $row_calculopromediosemestral['porcentajecorte'];
			 $contador++;
		     }		    
		  } while ($row_calculopromediosemestral = mysql_fetch_assoc($calculopromediosemestral));		    
	      $creditosnota = $notafinal * $row_promediosemestral['numerocreditos'];
		  $promedio =  $promedio + $creditosnota;	  
	        
	$g++;
	} while ($row_promediosemestral = mysql_fetch_assoc($promediosemestral)); 
	      
	   $promediosemestral = (number_format($promedio/$numerocreditos,1));      
      
}//if 1

?>