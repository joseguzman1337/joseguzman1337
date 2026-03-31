<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/sala2.php');
session_start();
//$periodoactual = 20052;
//$carrera = '050';
$contadorprematriculas = 0;
$periodoactual = $_SESSION['codigoperiodosesion'];


     $fecha = date("Y-m-d G:i:s",time());
		mysql_select_db($database_sala, $sala);
		$query_car = "SELECT nombrecarrera,codigocarrera 
						FROM carrera
						WHERE codigomodalidadacademica = '001'						
					    AND fechavencimientocarrera > '".$fecha."'	
					    order by 1";		
		$car = mysql_query($query_car, $sala) or die(mysql_error());
		$row_car = mysql_fetch_assoc($car);
		$totalRows_car = mysql_num_rows($car);

  $usuario = $_SESSION['MM_Username'];
 
  mysql_select_db($database_sala, $sala);
  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
  $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
  $row_tipousuario = mysql_fetch_assoc($tipousuario);
  $totalRows_tipousuario = mysql_num_rows($tipousuario);
    
	 if ($row_tipousuario['codigotipousuariofacultad'] == 200)
      {		
        $carrera = $_POST['carrera'];  
      }
	 else
	  {
	    $carrera = $_SESSION['codigofacultad'];	  
	  }
	  
     mysql_select_db($database_sala, $sala);
     $query_documentosestuduante = "SELECT * 
				                     FROM estadoordenpago							     
									 ";
	//echo $query_documentosestuduante,"<br>";	 
	$documentosestuduante  = mysql_query($query_documentosestuduante , $sala) or die(mysql_error());
	$row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante );
	$totalRows_documentosestuduante  = mysql_num_rows($documentosestuduante );

?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: xx-small;
}
.Estilo2 {font-size: xx-small}
.Estilo3 {font-size: xx-small; font-weight: bold; }
.Estilo4 {font-family: tahoma; font-size: xx-small; }
.Estilo5 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo9 {font-size: 12px}
.Estilo10 {font-size: 12}
.Estilo22 {font-size: 12px; font-weight: bold; }
-->
</style>
<body class="Estilo1">
<form name="form1" method="post" action="reporteprematriculas.php">
<?php 
if ($_POST['fecha1'] == "")
  {
    $_POST['fecha1'] = date("Y-m-d");
  }
if ($_POST['fecha2'] == "")
  {
     $_POST['fecha2'] = date("Y-m-d");
  }
?>

  <p align="center" class="Estilo5">LISTADO DE PREMATRICULAS </p>
  <table width="80%"  border="1" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
      <td><div align="center"><span class="Estilo10"><span class="Estilo9"><strong>Fecha Inicio:</strong></span>
          <input name="fecha1" type="text" value="<?php echo $_POST['fecha1'];?>" size="12" maxlength="10">
          <span class="Estilo9">aaaa-mm-dd</span></span></div></td>
      <td><div align="center"><span class="Estilo10"><span class="Estilo9"><strong>Fecha Final:</strong></span>
          <input name="fecha2" type="text" value="<?php echo $_POST['fecha2'];?>" size="12" maxlength="10">
          <span class="Estilo9">      aaaa-mm-dd</span></span></div></td>
    </tr>
    <tr>
      <td colspan="2"><p align="center" class="Estilo2"><span class="Estilo9"><strong>Estado Prematricula:</strong>&nbsp;&nbsp;</span>
          <select name="situacion" id="situacion">
          <option value="0" <?php if (!(strcmp(0, $_POST['situacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php

do {  

?>
          <option value="<?php echo $row_documentosestuduante['codigoestadoordenpago']?>"<?php if (!(strcmp($row_documentosestuduante['codigoestadoordenpago'], $_POST['situacion']))) {echo "SELECTED";} ?>><?php echo $row_documentosestuduante['nombreestadoordenpago']?></option>
          <?php
} while ($row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante));
  $rows = mysql_num_rows($documentosestuduante);
  if($rows > 0) {
      mysql_data_seek($documentosestuduante, 0);
	  $row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante);
  }
?>
        </select>
      &nbsp; 
 <?php 
  if ($row_tipousuario['codigotipousuariofacultad'] == 200)
   { // if 1
 ?> 
 	   <select name="carrera" id="carrera">
	   <option value="0" <?php if (!(strcmp(0,$_POST['carrera']))) {echo "SELECTED";} ?>>Seleccionar La Facultad</option>
		<?php
		 do {  
		?>
	   <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'],$_POST['carrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
		<?php
			} while ($row_car = mysql_fetch_assoc($car));
 		  $rows = mysql_num_rows($car);
		  if($rows > 0) 
		    {
			  mysql_data_seek($car, 0);
			  $row_car = mysql_fetch_assoc($car);
		    }
?>
 </select>
<?php  
  } // if 1
 ?>      
	  </p>
   	  </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="Submit" value="Consultar">
      </div></td>
    </tr>
  </table> 
  <p class="Estilo10">
    <?php 
   if (isset($_POST['situacion']))
     {
	    $estadoprematricula = $_POST['situacion'];
        $fecha1= $_POST['fecha1'];
        $fecha2= $_POST['fecha2'] ;
        $query_prematricula = "SELECT e.codigoestudiante, eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, f.valorfechaordenpago,
		                        det.valorconcepto, p.semestreprematricula,o.numeroordenpago,o.fechaordenpago,eo.nombreestadoordenpago,eg.numerodocumento
								FROM ordenpago o, estudiante e, fechaordenpago f, prematricula p,estadoordenpago eo, 
								detalleordenpago det,estudiantegeneral eg
								WHERE e.codigoestudiante=o.codigoestudiante
								AND e.idestudiantegeneral = eg.idestudiantegeneral
								AND o.numeroordenpago=f.numeroordenpago
								AND o.numeroordenpago=det.numeroordenpago
								AND e.codigoestudiante=p.codigoestudiante
								AND o.idprematricula=p.idprematricula
								and o.codigoestadoordenpago = eo.codigoestadoordenpago
								AND e.codigocarrera = '".$carrera."'
								AND o.fechaordenpago BETWEEN '".$fecha1."' AND '".$fecha2."'
								AND o.codigoperiodo='".$periodoactual."'
								AND o.codigoestadoordenpago ='".$estadoprematricula."'
								AND f.porcentajefechaordenpago=0
								and det.codigoconcepto=151
								ORDER BY 4";
		//echo $query_prematricula;		
		$prematricula = mysql_query($query_prematricula, $sala) or die(mysql_error());
		$row_prematricula = mysql_fetch_assoc($prematricula);
		$totalRows_prematricula = mysql_num_rows($prematricula);
       
	   if ($row_prematricula <> "")
	     {	 
		 ?>
  </p>
<table width="80%"  border="0" align="center" cellpadding="2" >
<tr>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Documento</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Nombre</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">N&ordm; Orden</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Fecha</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Valor</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Valor Matricula</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Cr&eacute;ditos Semestre</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Cr&eacute;ditos Seleccionados</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Semestre</div></td>
		   <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">% Matricula</div></td>
		
    </tr>		   
		   
		  <?php 		   
					  
			echo "<div align='center' class='Estilo22'><strong>Se encontraron&nbsp;",$totalRows_prematricula,"&nbsp;prematriculas en estado &nbsp;",$row_prematricula['nombreestadoordenpago'],"&nbsp;</strong></div>"; 
			echo "<br>";
			 do {
		
		$query_prematricula1 = "SELECT idplanestudio
								FROM planestudioestudiante
								WHERE codigoestudiante='".$row_prematricula['codigoestudiante']."'
								AND codigoestadoplanestudioestudiante=101";
		$prematricula1 = mysql_query($query_prematricula1, $sala) or die(mysql_error());
		$row_prematricula1 = mysql_fetch_assoc($prematricula1);
		
		$query_prematricula2 = "SELECT d.semestredetalleplanestudio, SUM(d.numerocreditosdetalleplanestudio) numerocreditos
								FROM detalleplanestudio d
								WHERE d.idplanestudio='".$row_prematricula1['idplanestudio']."'
								AND d.semestredetalleplanestudio='".$row_prematricula['semestreprematricula']."'
								GROUP by 1";
		$prematricula2 = mysql_query($query_prematricula2, $sala) or die(mysql_error());
		$row_prematricula2 = mysql_fetch_assoc($prematricula2);
		$mitadcreditos=$row_prematricula2['numerocreditos']/2;
		
		$usarcondetalleprematricula = true;
		$codigoestudiante = $row_prematricula['codigoestudiante'];
		$codigoperiodo = $periodoactual;
		require('../prematricula/calculocreditossemestre.php');
		if ($creditoscalculados<=$mitadcreditos)
					{
						$avisomenor='50%';
					}
				else
		  		   {
		  				$avisomenor='100%';
				   }     
			?>
			   <tr>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['numerodocumento'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['apellidosestudiantegeneral'];?>&nbsp;<?php echo $row_prematricula['nombresestudiantegeneral'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['numeroordenpago'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['fechaordenpago'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['valorfechaordenpago'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['valorconcepto'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula2['numerocreditos'];?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $creditoscalculados;?></div></td>
			   <td><div align="center" class="Estilo4"><?php echo $row_prematricula['semestreprematricula'];?></div></td>			   
			   <td><div align="center" class="Estilo4"><?php echo $avisomenor;?></div></td>
			   </tr>		   
			   
				 
		 <?php
		   $contadorprematriculas++;
		   }while($row_prematricula = mysql_fetch_assoc($prematricula));
		  ?> 		  
  </table>


<?php		 
		 }
       else
        {
          echo '<p align="center"><strong><span class="Estilo22">No se produjo ningún resultado</span></strong></p>'; 
        }
 }

?>
</form>
