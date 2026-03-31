<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$creditos=0;
$indicadorhistorico = 0;
if ($_GET['busqueda_codigo'] <> "")
 {
   mysql_select_db($database_sala, $sala);
	$query_Recordset2 = "SELECT  eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, 
	c.nombrecarrera, eg.numerodocumento, est.codigoperiodo,est.codigocarrera
	FROM estudiante est,estudiantegeneral eg,carrera c
	WHERE est.idestudiantegeneral = eg.idestudiantegeneral
	AND c.codigocarrera = est.codigocarrera
	AND est.codigoestudiante = '$codigoestudiante' ";
	$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);

	$facultad=$row_Recordset2['codigocarrera'];
    $carreraestudiante = $row_Recordset2['codigocarrera'];
 }

 else
  {
	mysql_select_db($database_sala, $sala);
	$query_Recordset2 = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
	c.nombrecarrera, eg.numerodocumento, est.codigoperiodo,est.codigocarrera
	FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
	WHERE est.codigoestudiante LIKE '$codigoestudiante%'				
	and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
	and eg.idestudiantegeneral = est.idestudiantegeneral
	and ed.idestudiantegeneral = eg.idestudiantegeneral
	and c.codigocarrera = est.codigocarrera
	and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
	and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
	ORDER BY 3, est.codigoperiodo";
    //echo $query_Recordset2,"<br>";
	$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	$facultad=$row_Recordset2['codigocarrera'];
    $carreraestudiante = $row_Recordset2['codigocarrera'];
 }

unset($codigoestudiante);
if ($row_Recordset2)
 {   
   $codigoestudiante = $row_Recordset2['codigoestudiante'];  
 }

//require('calculopromedioacumulado.php');

mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT m.nombremateria,m.codigomateria,d.codigomateriaelectiva,m.numerocreditos,g.idgrupo,p.codigoestudiante,p.semestreprematricula
FROM prematricula p,detalleprematricula d,materia m,grupo g
WHERE  p.codigoestudiante = '".$codigoestudiante."'
AND p.idprematricula = d.idprematricula
AND d.codigomateria = m.codigomateria
AND d.idgrupo = g.idgrupo
AND m.codigoestadomateria = '01'
AND g.codigoperiodo = '".$periodoactual."'
AND p.codigoestadoprematricula LIKE '4%'
AND d.codigoestadodetalleprematricula LIKE '3%'";
//AND g.codigomaterianovasoft = m.codigomaterianovasoft
//echo $query_Recordset1,"<br><br>";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 10px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo5 {font-family: Tahoma; font-size: 12px; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<form name="form1" method="post" action="consultanotassala.php">
 <table width="600" border="0" align="center">
    <tr>
     <td><div align="center"><img src="<?php echo $row_universidad['imagenlogouniversidad'];?>" width="200" height="62" onClick="window.print()"><br><span class="Estilo5"><?php echo $row_universidad['personeriauniversidad'];?><br><?php echo $row_universidad['entidadrigeuniversidad'];?><br><?php echo $row_universidad['nituniversidad'];?></span></div></td>
   </tr>
  </table>
 <p>&nbsp;</p>
  <table width="600"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="10" align="center" class="Estilo2"><?php echo $row_Recordset2['nombre']; ?></td>
      <td colspan="2" align="center" class="Estilo2">Documento</td>
      <td colspan="3" align="center" class="Estilo5"><?php echo $row_Recordset2['numerodocumento']; ?>&nbsp;
	</tr>
    <tr>
      <td colspan="6"><span class="Estilo2">&nbsp;Programa: &nbsp;&nbsp;</span><span class="Estilo5"><?php echo $row_Recordset2['nombrecarrera']; ?></span></td>
      <td colspan="2" align="center" class="Estilo2">Periodo</td>
      <td colspan="2" align="center" class="Estilo5"><?php echo $periodoactual; ?>&nbsp;</td>
	  <td colspan="2" align="center" class="Estilo2">Fecha</td>
      <td colspan="3" align="center" class="Estilo5"><?php echo date("j/m/Y",time());?>&nbsp;
      <div ></div></td>
    </tr>
<?php 
$ultimocorte = 0;
 if ($row_Recordset1 <> "")
 {// if1
?>     
 <tr>
<?php $promedio=0;
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
AND g.codigoperiodo = '".$periodoactual."'
AND p.codigoestadoprematricula LIKE '4%'
AND d.codigoestadodetalleprematricula LIKE '3%'";
//AND g.codigomaterianovasoft = m.codigomaterianovasoft
//echo $query_Recordset1;
$Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

do{

mysql_select_db($database_sala, $sala);
$query_fecha ="SELECT c.numerocorte
FROM corte c
WHERE c.codigomateria = '".$row_Recordset9['codigomateria']."'						
AND c.codigoperiodo = '".$periodoactual."'
and c.usuario = '".$facultad."'";
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
    and codigoperiodo = '".$periodoactual."'
	order by numerocorte";
	//echo $query_fecha,"<br>";
	$fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
	$row_fecha = mysql_fetch_assoc($fecha);
	$totalRows_fecha = mysql_num_rows($fecha);


do {
		$contadorcortes +=1;
	} while ($row_fecha = mysql_fetch_assoc($fecha));
}	

 if ($totalRows_fecha==0) 
  {	
       $query_fecha = "SELECT distinct numerocorte
	   FROM detallenota,materia,corte
	   WHERE  materia.codigoestadomateria = '01'
	   AND detallenota.codigomateria=materia.codigomateria
	   AND detallenota.idcorte=corte.idcorte
	   AND detallenota.codigoestudiante = '".$codigoestudiante."'
	   AND detallenota.codigomateria = '".$row_Recordset9['codigomateria']."'
	   AND corte.codigoperiodo = '".$periodoactual."'";				 
	  $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
	  $row_fecha = mysql_fetch_assoc($fecha);
	  $totalRows_fecha = mysql_num_rows($fecha);
   
    do {
		$contadorcortes +=1;
   } while ($row_fecha = mysql_fetch_assoc($fecha));
 } 


if ($ultimocorte < $contadorcortes)
  { 
	$ultimocorte = $contadorcortes;
  }
} while ($row_Recordset9 = mysql_fetch_assoc($Recordset9));


do { 
if ($banderaimprime == 0)
  {  
   echo "<td colspan='1' align='center' class='Estilo2'>C&oacute;digo</td>";
   echo "<td colspan='1' align='center' class='Estilo2'>Nombre Asignatura</td>";
   echo "<td colspan='1' align='center' class='Estilo2'>Cr</td>"; 
 for ($i=1;$i<=$ultimocorte;$i++) 
  {   
	 echo "<td colspan='1' align='center' class='Estilo2'>C".$i."</td>";
     echo "<td colspan='1' align='center' class='Estilo2'>%</td>";	 
  }    

      echo "<td colspan='1' align='center' class='Estilo2'>T%</td>";
	  echo "<td colspan='1' align='center' class='Estilo2'>DEF</td>";
	  echo "<td colspan='1' align='center' class='Estilo2'>R</td>"; 
	  echo "<td colspan='1' align='center' class='Estilo2'>LETRAS</td>";
	  echo "<td colspan='1' align='center' class='Estilo2'>FT</td>";
	  echo "<td colspan='1' align='center' class='Estilo2'>FP</td>";
      echo "</tr>";
   $banderaimprime = 1;
}
////////////////////////	
	$contador= 1;
	$mostrarpapa = "";
	mysql_select_db($database_sala, $sala);
	$query_Recordset8 ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,
     grupo.codigomateria,corte.porcentajecorte 
	FROM detallenota,materia,grupo,corte 
	WHERE  materia.codigomateria=grupo.codigomateria 
	AND materia.codigoestadomateria = '01'
    AND detallenota.idgrupo=grupo.idgrupo 
	AND detallenota.idcorte=corte.idcorte 
	AND detallenota.codigoestudiante = '".$codigoestudiante."'
	AND detallenota.codigomateria = '".$row_Recordset1['codigomateria']."'  
	AND grupo.codigoperiodo = '".$periodoactual."'
	ORDER BY 2";
  $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());
  $row_Recordset8 = mysql_fetch_assoc($Recordset8);
  $totalRows_Recordset8 = mysql_num_rows($Recordset8); 
	if($row_Recordset1['codigomateriaelectiva'] != "")
	{

       $query_materiaelectiva = "SELECT *
		FROM materia
		WHERE codigoindicadoretiquetamateria LIKE '1%'
		and codigomateria = ".$row_Recordset1['codigomateriaelectiva']."";
		//echo $row_Recordset1['codigomateria']." as ".$query_materiaelectiva;												
    	$materiaelectiva = mysql_query($query_materiaelectiva, $sala) or die(mysql_error());
       	$row_materiaelectiva = mysql_fetch_assoc($materiaelectiva);
	   	$totalRows_materiaelectiva = mysql_num_rows($materiaelectiva);	

		if($totalRows_materiaelectiva != "")
		{
			$row_Recordset1['codigomateria'] = $row_materiaelectiva['codigomateria'];
			$row_Recordset1['nombremateria'] = $row_materiaelectiva['nombremateria'];
			$row_Recordset1['numerocreditos'] = $row_materiaelectiva['numerocreditos'];
			// Toca definir como hacer con el calculo de creditos (Se hace con el papa o con el hijo)
			//$solicitud_historico['codigoindicadorcredito'] = $row_materiaelectiva['codigoindicadorcredito'];
		}
	   else
	    {		   
			$query_materiaelectiva1 = "SELECT nombremateria
		    FROM materia
		    WHERE codigomateria = ".$row_Recordset1['codigomateriaelectiva']."";
			//echo $query_materiaelectiva1;
			//echo $row_Recordset1['codigomateria']." as ".$query_materiaelectiva;												
			$materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die(mysql_error());
			$row_materiaelectiva1 = mysql_fetch_assoc($materiaelectiva1);
			$totalRows_materiaelectiva1 = mysql_num_rows($materiaelectiva1);	
		    $mostrarpapa = $row_materiaelectiva1['nombremateria'];			
		}
	}
?>
    <tr>
       <td colspan="1" align="center" class="Estilo1"><?php echo $row_Recordset1['codigomateria']; ?></td>
       <td colspan="1" class="Estilo1"><?php if ($mostrarpapa <> "") echo "<strong>$mostrarpapa</strong> /  "; echo $row_Recordset1['nombremateria']; ?></td>
       <td colspan="1" align="center" class="Estilo1"><?php echo $row_Recordset1['numerocreditos'];
	  $numerocreditos = $numerocreditos + $row_Recordset1['numerocreditos'];?>&nbsp;</td>
 <?php	
       $habilitacion = 0;
	   $notafinal = 0;
	   $porcentajefinal = 0;
	   $fallasteoricasperdidas = 0;
	   $fallaspracticasperdidas = 0;
	   $banderafallas = "";
	   $contadorfallas = 0;
	   $cols=0;
	   $cols=$ultimocorte * 2;
	  do{
	         if ($row_Recordset8['codigotiponota'] == 10)
			 {
			   // Valida si l aperdida es por fallas.
			 $query_perdidafallas = "SELECT  * 
		     FROM notahistorico 
		     WHERE codigoestudiante = '".$codigoestudiante."' 
		     AND codigoperiodo = '".$periodoactual."' 
		     AND codigomateria = '".$row_Recordset1['codigomateria']."' 		   
			 AND codigotiponotahistorico = '102'
			 AND codigoestadonotahistorico like '1%'";
		     //echo $query_perdidafallas;
		     $perdidafallas = mysql_query($query_perdidafallas, $sala) or die(mysql_error());
		     $row_perdidafallas = mysql_fetch_assoc($perdidafallas);
		     $totalRows_perdidafallas = mysql_num_rows($perdidafallas);
			 
		     if ($row_perdidafallas <> "")
		      {
			   
			   $banderafallas = "MATERIA PERDIDA POR FALLAS";
			   
			   if ($contadorfallas == 0)
			    {
				  echo "<td class='Estilo1' align='center' colspan= '$cols'>$banderafallas</td>";
				}
			     $contadorfallas++;
			  }			     
			 else
              {			  
			  $query_historico = "SELECT  * 
		      FROM notahistorico 
		      WHERE codigoestudiante = '".$codigoestudiante."' 
		      AND codigoperiodo = '".$periodoactual."' 
		      AND codigomateria = '".$row_Recordset1['codigomateria']."' 
		      AND codigoestadonotahistorico LIKE '1%'
		      AND codigotiponotahistorico <> 100
			  ";
	          $historico = mysql_query($query_historico, $sala) or die(mysql_error());
	          $row_historico = mysql_fetch_assoc($historico);
	          $totalRows_historico = mysql_num_rows($historico);				 
			  
			  if (!$row_historico)
			   {			 
			     echo "<td class='Estilo1' align='center'>".$row_Recordset8['nota']."&nbsp;</td>";
	           }
			  else
			   {
			     echo "<td class='Estilo1' align='center'>&nbsp;</td>";
			   }
			  } 
			  if (!$row_historico)
			   {			 
			     if ( !$banderafallas)
				  {
				   echo "<td class='Estilo1' align='center'>".$row_Recordset8['porcentajecorte']."%&nbsp;</td>";		 
                  }
			   }
			  else
			   {
			    echo "<td class='Estilo1' align='center'>&nbsp;</td>";		 
			   }
	         $notafinal = $notafinal + ($row_Recordset8['nota'] * $row_Recordset8['porcentajecorte'])/100;
			 $porcentajefinal = $porcentajefinal + $row_Recordset8['porcentajecorte'];
			 $fallasteoricasperdidas = $fallasteoricasperdidas + $row_Recordset8['numerofallasteoria'];
			 $fallaspracticasperdidas = $fallaspracticasperdidas + $row_Recordset8['numerofallaspractica'];
			 $contador++;
		     }		  
		    else
			if ($row_Recordset8['codigotiponota'] == 20)
			 {
			  $habilitacion = $row_Recordset8['nota'];
			 }
		  } while ($row_Recordset8 = mysql_fetch_assoc($Recordset8));		    

	      if ($porcentajefinal <> 0)
		  $creditosnota = (number_format($notafinal/($porcentajefinal/100),1)) * $row_Recordset1['numerocreditos'];
		  $promedio =  $promedio + $creditosnota;		  
		  $suma = $ultimocorte - $contador; 
		  for ($i=0;$i<=$suma;$i++) 
			{ 
				 echo "<td class='Estilo1'>&nbsp;</td>";
				 echo "<td class='Estilo1'>&nbsp;</td>";	
			}

	 // $notafinal = number_format($notafinal,2);
     // $notafinal = round($notafinal * 10)/10; 
      $notafinal = redondeo($notafinal);   

	 if ($porcentajefinal <> 0)
	  {	   
	    //$total = number_format($notafinal/($porcentajefinal/100),1);
         $total = $notafinal;
	   if ( !$banderafallas)
	    {
	      $total =  $notafinal ;
	    }
	   else
		{
		  $total =  substr($row_perdidafallas['notadefinitiva'],0,3);
		}
	   if (!$row_historico)
	   {		
	     echo "<td colspan='1' class='Estilo1' align='center'>".$porcentajefinal."%&nbsp;</td>";
	   }
	  else
	   {
	    echo "<td colspan='1' class='Estilo1' align='center'>&nbsp;</td>";
	   }	  
      if (!$row_historico)
	  {  
	   $query_notagrabada = "select notadefinitiva
	   from notahistorico
	   where codigoestudiante = '".$codigoestudiante."'
	   and codigomateria = '".$row_Recordset1['codigomateria']."'
	   and codigoperiodo = '".$periodoactual."'
	   and codigotiponotahistorico = '100'
	   AND codigoestadonotahistorico LIKE '1%'";
	   $notagrabada = mysql_query($query_notagrabada, $sala) or die(mysql_error());
	   $row_notagrabada= mysql_fetch_assoc($notagrabada);
	   $totalRows_notagrabada= mysql_num_rows($notagrabada);		 
       
	  if($row_notagrabada <> "")
	   {
	     $total = substr($row_notagrabada['notadefinitiva'],0,3);
         $indicadorhistorico = 1;
	   } 	 
	    echo "<td colspan='1' align='center' class='Estilo2'>".$total."&nbsp;</td>";
      }
	 else
	  {
	   echo "<td colspan='1' align='center' class='Estilo2'>&nbsp;</td>";
	  }  

	   $recuperacion = "";
        if ($row_historico <> "")
		 {
		   $recuperacion = number_format ($row_historico['notadefinitiva'],1);
		   $total=$recuperacion;		   
		 }

	    echo "<td colspan='1' class='Estilo2' align='center'>".$recuperacion."&nbsp;</td>";

	   $numero =  substr($total,0,1);
	   $numero2 = substr($total,2,3);
	 
	   require('convertirnumeros.php');		
	  }	
	  echo "<td colspan='1' class='Estilo1'>".$numu." ".$numu2."&nbsp;</td>";
	  echo "<td align='center' class='Estilo1'>".$fallasteoricasperdidas."&nbsp;</td>";
	  echo "<td align='center' class='Estilo1'>".$fallaspracticasperdidas."&nbsp;</td>";	  
	  unset($numu);
	  unset($numu2);
	  echo "</tr>";
	  $g++;
	} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    <tr class="Estilo2">
      <td height="25" colspan="7" align="center">Promedio Ponderado Acumulado:       
 <?php 	     
        $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);      
		echo $promedioacumulado;	   
 ?>     </td>
       <td colspan="20" align="center">Promedio Ponderado Semestral:&nbsp;

<?php 

//////////////////////////////////////////////////////////////  calculo promedio periodo ///////////////////////  

if($indicadorhistorico == 1)
{
	//if(isset($_GET['periodos']))
	//{
		$query_selperiodos = "SELECT distinct codigoperiodo
	    from notahistorico
	    where codigoestudiante = '$codigoestudiante'
		order by 1";
		$selperiodos = mysql_query($query_selperiodos, $sala) or die("$query_selperiodos".mysql_error());
		$total_selperiodos = mysql_num_rows($selperiodos);
		$_GET['totalperiodos'] = $total_selperiodos;
		$estei = 1;
		while($row_selperiodos = mysql_fetch_assoc($selperiodos))
		{
			$_GET["periodo".$estei] = $row_selperiodos['codigoperiodo']; 
			$estei++;
		}

	//}

	// Tomo todas las materias que vio el estudiante con su nota y las coloco en un arreglo por periodo
	$query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
	when 0 then n.notadefinitiva
	when 1 then n.notadefinitiva / 100
	end as nota, n.codigoperiodo, m.nombremateria
	from notahistorico n, materia m
	where n.codigoestudiante = '$codigoestudiante' 
	AND codigoestadonotahistorico LIKE '1%'
	and n.codigomateria = m.codigomateria
	order by 5, 3 ";	
	//echo $query_materiashistorico; 
	//exit();
	$materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error());
	$totalRows_materiashistorico = mysql_num_rows($materiashistorico);
	$cadenamateria = "";
	while($row_materiashistorico = mysql_fetch_assoc($materiashistorico))
	{
	// Coloco las materias equivalentes del estudiante en un arreglo y selecciono 
	// la mayor de esas notas, con el codigo de la materia mayor.
	// Arreglo de las materias con las mejores notas del estudiante
		if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$sala))
		{
			//echo "PAPA ".$row_materiashistorico['codigomateria']." $materiapapaito<br>";
			$formato = " n.codigomateria = ";
			// Con la materia papa selecciono las equivalencias y miro si estan en estudiante, y selecciono la mayor nota con su codigo
			// $Cad_equivalencias = seleccionarequivalenciascadena($materiapapaito, $codigoestudiante, $formato, $sala)."<br>";
			// $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
			// echo "($cadequivalencias";	
			// exit();
			$row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
			$Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
			//echo "materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
		}
		else
		{
			$Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
		}
	}
	//exit();

	$Array_materiashistoricoinicial = $Array_materiashistorico;
	// Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
	// Para esto primero creo un arreglo con las equivalencias de cada materia
    
   foreach($Array_materiashistorico as $codigomateria => $row_materia)
	{
		//echo "$codigomateria => ".$row_materia['codigoperiodo']." => ".$row_materia['nota']."<br>";
		$otranota = $row_materia['nota']*100;
		// Arreglo bidimensional con las materias en cada periodo
		$cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
  	    $Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
	}
	//exit();
	$cadenamateria = $cadenamateria."fin";
	$cadenamateria = ereg_replace("orfin","",$cadenamateria);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
	   //$periodosemestral = $periodoactual;	    
       //require('calculopromediosemestralmacheteado.php');	    
       $promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodoactual,$cadenamateria,$_GET['tipocertificado']="",$sala);    
       echo $promediosemestralperiodo;
 }	
?> 
  </td>
   </tr>
   <tr class="Estilo2">
      <td align="center">Cr: Cr&eacute;ditos</td>
      <td align="center">R: Modificaci&oacute;n</td>
      <td colspan="2" align="center">C: Corte</td>
      <td colspan="3" align="center">T%:Porcentaje total</td>
	  <td colspan="3" align="center">FT:Fallas te&oacute;ricas</td>
	  <td colspan="2" align="center">FP:Fallas pr&aacute;cticas</td>
      <td colspan="3" align="center">DEF: Definitiva</td>
    </tr>
    <tr>
     <td  colspan="20"> <p  align="justify" class="Estilo5">
<?php   if ($_GET['tipodetalleseguimiento'] == 100)
        {
	        $query_sel_seguimiento= "SELECT DISTINCT descripciondetalleseguimientoacademico
			FROM seguimientoacademico sa,detalleseguimientoacademico dsa,tipodetalleseguimiento tdsa
			WHERE sa.idseguimientoacademico = dsa.idseguimientoacademico
			AND dsa.codigotipodetalleseguimientoacademico = tdsa.codigotipodetalleseguimiento
			AND notadesdedetalleseguimientoacademico <= '$promediosemestralperiodo'
			AND notahastadetalleseguimientoacademico >= '$promediosemestralperiodo'
			AND sa.codigoestado LIKE '1%'
			AND dsa.codigoestado LIKE '1%'
			AND tdsa.codigoestado LIKE '1%'
			AND sa.codigocarrera = '$facultad'
			and sa.codigoperiodo = '$periodoactual'
			AND codigotipodetalleseguimientoacademico = '".$_GET['tipodetalleseguimiento']."'";
			//echo $query_sel_seguimiento;
			$sel_seguimiento = mysql_query($query_sel_seguimiento, $sala) or die(mysql_error());
			$row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento);
			$totalRows_sel_seguimiento = mysql_num_rows($sel_seguimiento);
   	    }
	  else
	  if ($_GET['tipodetalleseguimiento'] == 200)
		{
		    $query_sel_seguimiento= " SELECT DISTINCT descripciondetalleseguimientoacademico
			FROM seguimientoacademico sa,detalleseguimientoacademico dsa,tipodetalleseguimiento tdsa
			WHERE sa.idseguimientoacademico = dsa.idseguimientoacademico
			AND dsa.codigotipodetalleseguimientoacademico = tdsa.codigotipodetalleseguimiento
			AND notadesdedetalleseguimientoacademico <= '$promedioacumulado'
			AND notahastadetalleseguimientoacademico >= '$promedioacumulado'
			AND sa.codigoestado LIKE '1%'
			AND dsa.codigoestado LIKE '1%'
			AND tdsa.codigoestado LIKE '1%'
			AND sa.codigocarrera = '$facultad'
			and sa.codigoperiodo = '$periodoactual'
			AND codigotipodetalleseguimientoacademico = '".$_GET['tipodetalleseguimiento']."'";
			//echo $query_sel_seguimiento;
			$sel_seguimiento = mysql_query($query_sel_seguimiento, $sala) or die(mysql_error());
			$row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento);
			$totalRows_sel_seguimiento = mysql_num_rows($sel_seguimiento);		
		} 

        if ($row_sel_seguimiento <> "")
		 {
		   echo $row_sel_seguimiento['descripciondetalleseguimientoacademico'];		 
		 }
		else
		 {
		   echo "<br><br><br><br><br>";
		 } 
?>
	    
      <table align="center">
	    <tr>
<?php 
    $query_responsable = "SELECT *
	FROM directivo d,directivocertificado di,certificado c
	WHERE d.codigocarrera = '".$codigocarrera."'
	AND d.iddirectivo = di.iddirectivo
	AND di.idcertificado = c.idcertificado
	AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
	AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
	AND c.idcertificado = '1'
	ORDER BY fechainiciodirectivo";	
	//echo $query_responsable;
	//exit();
	$responsable = mysql_query($query_responsable, $sala) or die(mysql_error());
	$row_responsable = mysql_fetch_assoc($responsable);
	$totalRows_responsable = mysql_num_rows($responsable);

    $contador = 0;
   do{

?>	   
	   <td>
          <span class="Estilo2">____________________________<br>
		  <a style='cursor: pointer' onClick="window.location.reload('../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=facultad')"><?php echo $row_responsable['nombresdirectivo'],"&nbsp;",$row_responsable['apellidosdirectivo'];?><br>
		  <?php echo $row_responsable['cargodirectivo'];?></a></span></p>
      </td>

<?php
   if ($totalRows_responsable > 1 and $contador == 0)
	 {	
?> 
	    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php 
       $contador = 1;
     }
  } while($row_responsable = mysql_fetch_assoc($responsable));

?>	
     </tr> 
   </table>
      </div>
      </td>
    </tr>
  </table>
<div align="center">
  </div>
</form>
</body>
</html>
<?php 
}//if 1

mysql_free_result($Recordset2);
?>



