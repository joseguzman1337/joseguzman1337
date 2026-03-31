<?php //require_once('../../../Connections/sala2.php');
$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 
//session_start();
?>
<form action="modificarmatriculado.php" method="post" name="form1" class="Estilo6"> 
 <?php   
if ($_POST['modificar'])
 {	
	mysql_select_db($database_sala, $sala);
	$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '1'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);

    $periodoactual = $row_periodo['codigoperiodo'];
//////////////////////////////////////////////////////////////////
        echo "<div align='center'>";
		echo "<span align='center' class='Estilo2 Estilo23 Estilo27 Estilo1 Estilo3'>LISTADO ESTUDIANTES NO MATRICULADOS</span>";
		echo "</div>";
		echo "<br>";
		echo "<table align='center' border='0' cellpadding='5'>";
		echo "<tr  bgcolor='#C5D5D6'>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Documento</strong></td>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>orden</strong></td>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Id</strong></td>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>valor</strong></td>";				
		echo "</tr>"; 
///////////////////////////////////////////////////////////////////////////// 
   $consultapago="SELECT * 
   FROM tmp_modificamatriculado
   where indicador = '0'";
   $datos=mysql_db_query($database_sala, $consultapago);
   $respuestaconsultapago=mysql_fetch_array($datos);	

//echo $consultapago,"<br>";

$codigoestudiante = "";
do{    
   $indicadormatricula = 0;
   $cambiaestado = 0;
 
		$consultaordenpago="SELECT *
		FROM ordenpago o,fechaordenpago f,estudiantegeneral eg,estudiante e
		WHERE o.numeroordenpago = f.numeroordenpago
		AND o.codigoestudiante = e.codigoestudiante
		AND e.idestudiantegeneral = eg.idestudiantegeneral 
		AND o.numeroordenpago = '".$respuestaconsultapago['orden']."'
		AND eg.numerodocumento = '".$respuestaconsultapago['codigo']."' ";			  
		$datos2=mysql_db_query($database_sala, $consultaordenpago);
	   $respuestaconsultaordenpago=mysql_fetch_array($datos2);   
   $idprematricula = $respuestaconsultaordenpago['idprematricula'];
   if ($respuestaconsultaordenpago <> "")
    {		
		$codigoestudiante = $respuestaconsultaordenpago['codigoestudiante'];
		do{
		    if ($respuestaconsultapago['valor'] == $respuestaconsultaordenpago['valorfechaordenpago'])
			  {
			    $indicadormatricula = 1;
			  }	
		   else
		     {
			   $consultadvd="SELECT *
	           FROM descuentovsdeuda
   	           WHERE codigoestudiante = '".$respuestaconsultaordenpago['codigoestudiante']."'
		       and codigoestadodescuentovsdeuda = '01'
			   and codigoperiodo = '".$periodoactual."'";			   
			  $datos4=mysql_db_query($database_sala,$consultadvd);
	          $respuestadvd=mysql_fetch_array($datos4); 

			   do{
			       $totalpagado = 0;
				   $totalpagado = $respuestaconsultapago['valor'] + $respuestadvd['valordescuentovsdeuda']; 
					if ($totalpagado >= $respuestaconsultaordenpago['valorfechaordenpago'])
					  {
					    $indicadormatricula = 1;
					  }			 
			     }while($respuestadvd=mysql_fetch_array($datos4));
			 }

		}while($respuestaconsultaordenpago=mysql_fetch_array($datos2));	 
	}		 

/////////////////////////////////////////////////			 
  	if ($indicadormatricula == 1)
	  {  
		$base="update prematricula set  codigoestadoprematricula = 40 
        where idprematricula = '".$idprematricula."'"; 
  	   $sol=mysql_db_query($database_sala,$base);	

		 $base2="update detalleprematricula set  codigoestadodetalleprematricula = 30 
         where idprematricula = '".$idprematricula."' 
		 and numeroordenpago = '".$respuestaconsultapago['orden']."'
		 and codigoestadodetalleprematricula like '1%'"; 
		 $sol2=mysql_db_query($database_sala,$base2);	  

		$base1="update ordenpago set  codigoestadoordenpago = 40 
		where numeroordenpago = '".$respuestaconsultapago['orden']."'"; 
		$sol1=mysql_db_query($database_sala,$base1);

		//////////////////////////////////////////////////// LOG DE PREMATRICULA ////////////////////////////////////////////////
		
		 $query_log = "SELECT * FROM detalleprematricula 
		 where numeroordenpago = '".$respuestaconsultapago['orden']."'
		 and codigoestadodetalleprematricula like '1%'";
		//echo $query_log;
		 $log = mysql_query($query_log, $sala) or die(mysql_error());
		 $row_log = mysql_fetch_assoc($log);
		 $totalRows_log = mysql_num_rows($log);
       
	   if ($row_log <> "")
	    {
			do
			 {
				$query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario, ip) 
				VALUES('".$row_log['idprematricula']."','".$row_log['codigomateria']."','".$row_log['codigomateriaelectiva']."','30','10','".$row_log['idgrupo']."','".$respuestaconsultapago['orden']."','".date("Y-m-d H:i:s",time())."','admintecnologia','172.7.6.113')"; 
				$inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
			 }while($row_log = mysql_fetch_assoc($log));		 
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$base3="update descuentovsdeuda
        set  codigoestadodescuentovsdeuda = '03' 
        where codigoperiodo = '".$periodoactual."'
		and codigoestudiante = '".$codigoestudiante."'"; 
		$sol3=mysql_db_query($database_sala,$base3);	
	 }

	   mysql_select_db($database_sala, $sala);
	   $query_estudiantes = "SELECT *
	   FROM ordenpago o
	   WHERE o.numeroordenpago = '".$respuestaconsultapago['orden']."'
	   AND o.codigoestudiante = '".$codigoestudiante."'
	   and o.codigoestadoordenpago like '4%'";				
	   $estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
	   $row_estudiantes = mysql_fetch_assoc($estudiantes);	 
	 if (! $row_estudiantes)
	   {
		 echo "<tr>";
		  echo "<td align='center' class='Estilo1 Estilo4'>".$respuestaconsultapago['codigo']."</td>";	
		 echo "<td align='center' class='Estilo1 Estilo4'>".$respuestaconsultapago['orden']."</td>";	        
		 echo "<td align='center' class='Estilo1 Estilo4'>".$codigoestudiante."</td>";
		 echo "<td align='center' class='Estilo1 Estilo4'>".$respuestaconsultapago['valor']."</td>";
	     echo "</tr>";
	   }	 
     else
	  {
	    $base4="update tmp_modificamatriculado
        set indicador = '1' 
        where codigo = '".$respuestaconsultapago['codigo']."'"; 
		$sol4=mysql_db_query($database_sala,$base4);	  
	  }
}while($respuestaconsultapago=mysql_fetch_array($datos));
echo "</table>";	
} // if POST
?>
<div align="center">
 <input type="submit" name="modificar" value="Matricular Estudiantes">
</div>
</form>