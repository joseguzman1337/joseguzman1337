<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

$creditos=0;
//$codigoestudiante ="05110005";

mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT * FROM periodo ORDER BY nombreperiodo DESC";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);
mysql_select_db($database_sala,$sala);
	$periodocon=$_SESSION['codigoperiodosesion'];


$query_Recordset1 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
						FROM prematricula p,detalleprematricula d,materia m,grupo g

						WHERE  p.codigoestudiante = '".$codigoestudiante."'

						AND p.idprematricula = d.idprematricula

						AND d.codigomateria = m.codigomateria

						AND d.idgrupo = g.idgrupo

						AND m.codigoestadomateria = '01'

						AND g.codigoperiodo = '".$periodocon."'

						AND p.codigoestadoprematricula LIKE '4%'

						AND d.codigoestadodetalleprematricula LIKE '3%'";

						//AND g.codigomaterianovasoft = m.codigomaterianovasoft

//echo $query_Recordset1,"</br>";

$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());

$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$totalRows_Recordset1 = mysql_num_rows($Recordset1);



mysql_select_db($database_sala, $sala);

$query_Recordset2 = "SELECT * FROM estudiante 

                      WHERE codigoestudiante = '".$codigoestudiante."'";

//echo $query_Recordset2;

$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());

$row_Recordset2 = mysql_fetch_assoc($Recordset2);

$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$facultad=$row_Recordset2['codigocarrera'];



mysql_select_db($database_sala, $sala);

$query_Recordset3 = sprintf("SELECT * FROM carrera WHERE codigocarrera = '%s'",$row_Recordset2['codigocarrera']);

$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());

$row_Recordset3 = mysql_fetch_assoc($Recordset3);

$totalRows_Recordset3 = mysql_num_rows($Recordset3);



mysql_select_db($database_sala, $sala);

$query_Recordset4 = sprintf("SELECT * FROM materia WHERE codigomateria = '%s'",$row_Recordset1['codigomateria']);

$Recordset4 = mysql_query($query_Recordset4, $sala) or die(mysql_error());

$row_Recordset4 = mysql_fetch_assoc($Recordset4);

$totalRows_Recordset4 = mysql_num_rows($Recordset4);	

 if ($row_Recordset1 <> "")

 {// if1

      $promedio=0;

	  $guardaidgrupo[]=0;

	  $g = 0;

      $banderaimprime = 0;

	  $numerocreditos = 0;

$query_Recordset9 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante

						FROM prematricula p,detalleprematricula d,materia m,grupo g

						WHERE  p.codigoestudiante = '".$codigoestudiante."'

						AND p.idprematricula = d.idprematricula

						AND d.codigomateria = m.codigomateria

						AND d.idgrupo = g.idgrupo

						AND m.codigoestadomateria = '01'

						AND g.codigoperiodo = '".$periodocon."'

						AND p.codigoestadoprematricula LIKE '4%'

						AND d.codigoestadodetalleprematricula LIKE '3%'";

						//AND g.codigomaterianovasoft = m.codigomaterianovasoft

//echo $query_Recordset1;

$Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());

$row_Recordset9 = mysql_fetch_assoc($Recordset9);

$totalRows_Recordset9 = mysql_num_rows($Recordset9);



do{

$query_fecha ="SELECT c.numerocorte

						FROM corte c

						WHERE c.codigomateria = '".$row_Recordset9['codigomateria']."'						

						AND c.codigoperiodo = '".$periodocon."'";

//and c.codigomaterianovasoft = '".$row_Recordset9['codigomaterianovasoft']."'					

//echo $query_fecha,"</br>";

$fecha = mysql_query($query_fecha,$sala) or die(mysql_error());

$row_fecha = mysql_fetch_assoc($fecha);

$totalRows_fecha = mysql_num_rows($fecha);

$i= 1;

$contadorcortes = 0;



if ($totalRows_fecha <> 0)

  {

   

  do {		

		//$cortes[$i]=$row_fecha;		

		//$i+=1;

		$contadorcortes +=1;

	 } while ($row_fecha = mysql_fetch_assoc($fecha));

    

  }

else

if ($totalRows_fecha==0) 

{		

	mysql_select_db($database_sala, $sala);

	$query_fecha = "SELECT * 
    FROM corte 
	WHERE codigocarrera = '".$facultad."'
    order by numerocorte";
	//echo $query_fecha;
	$fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
	$row_fecha = mysql_fetch_assoc($fecha);
	$totalRows_fecha = mysql_num_rows($fecha);



do {

		//$cortes[$i]=$row_fecha;		

		//$i+=1;

		$contadorcortes +=1;

	} while ($row_fecha = mysql_fetch_assoc($fecha));

}	

if ($ultimocorte < $contadorcortes)

  {    

	$ultimocorte = $contadorcortes;

  }

//echo $ultimocorte;

} while ($row_Recordset9 = mysql_fetch_assoc($Recordset9));

  

do { 

	/////////////

	

if ($banderaimprime == 0)

  {  

  // echo "<td width='10%'><span class='Estilo3'><strong>C&oacute;digo</strong></span></td>";

  // echo "<td width='28%'><span class='Estilo3'><strong>Nombre Asignatura</strong> </span></td>";

  // echo "<td width='3%'><span class='Estilo3'>Cr</span></td>"; 

  for ($i=1;$i<=$ultimocorte;$i++) 

  {   

	  //echo "<td width='3%'><div align='center' class='Estilo3'>C".$i."</div></td>";

      //echo "<td width='3%'><div align='center' class='Estilo3'>%</div></td>";

  }    

      //echo "<td width='3%'><div align='center' class='Estilo3'>F</div></td>";      

	  ///echo "<td width='3%'><span class='Estilo3'>F%</span></td>"; 

	  //echo "<td width='3%'><span class='Estilo3'>R</span></td>";      

     // echo "</tr>";

   $banderaimprime = 1;

}

////////////////////////	

	$contador= 1;

	$query_Recordset8 ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,grupo.codigomateria,corte.porcentajecorte 

						FROM detallenota,materia,grupo,corte 

						WHERE  materia.codigomateria=grupo.codigomateria 

						AND materia.codigoestadomateria = '01'

						AND detallenota.idgrupo=grupo.idgrupo 

						AND detallenota.idcorte=corte.idcorte 

						AND detallenota.codigoestudiante = '".$codigoestudiante."'

						AND detallenota.idgrupo = '".$row_Recordset1['idgrupo']."'  

						AND grupo.codigoperiodo = '".$periodocon."'";

						//AND materia.codigomaterianovasoft=grupo.codigomaterianovasoft 

  //echo $query_Recordset8,"</br>";

  //exit;

  $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());

  $row_Recordset8 = mysql_fetch_assoc($Recordset8);

  $totalRows_Recordset8 = mysql_num_rows($Recordset8);	

  	

	

     $numerocreditos = $numerocreditos + $row_Recordset1['numerocreditos'];

       

	       $habilitacion = "";

		   $notafinal = 0;

		   $porcentajefinal = 0;

		  do{

	         if ($row_Recordset8['codigotiponota'] == 10)

			 {

			 $notafinal = $notafinal + ($row_Recordset8['nota'] * $row_Recordset8['porcentajecorte'])/100;

			 $porcentajefinal = $porcentajefinal + $row_Recordset8['porcentajecorte'];

			 $contador++;

		     }		  

		    else

			if ($row_Recordset8['codigotiponota'] == 20)

			 {

			  $habilitacion = $row_Recordset8['nota'];

			 }

		  } while ($row_Recordset8 = mysql_fetch_assoc($Recordset8));		    

	      $creditosnota = $notafinal * $row_Recordset1['numerocreditos'];

		  $promedio =  $promedio + $creditosnota;		  

		  $suma = $ultimocorte - $contador; 

	        

	$g++;

	} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 

	      

	   $pro = (number_format($promedio/$numerocreditos,1));      

      

}//if 1



?>