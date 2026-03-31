<?php 
session_start();
include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

        $query_modalidadacademica = "SELECT m.codigomodalidadacademica, nombremodalidadacademica
            from modalidadacademica m, carrera c where c.codigomodalidadacademica=m.codigomodalidadacademica 
			AND c.codigocarrera='".$_SESSION['codigofacultad']."'";

       $modalidadacademica= $db->Execute($query_modalidadacademica);
        $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
		
		$query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo order by 1 desc";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();

		if(isset($_POST['codigomodalidadacademica'])){
			$query_carrera ="SELECT c.codigocarrera, c.nombrecarrera from carrera c,
			siq_Ainstrumentoconfiguracion s, siq_Apublicoobjetivo p, siq_Adetallepublicoobjetivo dp 
			where c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
			and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera 
			and dp.codigocarrera=c.codigocarrera 
			and dp.idsiq_Apublicoobjetivo=p.idsiq_Apublicoobjetivo 
			and s.idsiq_Ainstrumentoconfiguracion=p.idsiq_Ainstrumentoconfiguracion			
			and dp.codigocarrera=c.codigocarrera
			GROUP BY c.codigocarrera
			order by nombrecarrera";
			//echo $query_carrera;
			$carrera= $db->Execute($query_carrera);
			$totalRows_carrera = $carrera->RecordCount();   
		}

		if(isset($_POST['codigocarrera']) && isset($_POST['periodo'])){
			$query_materia ="select m.* from prematricula pr 
							inner join estudiante e on e.codigoestudiante=pr.codigoestudiante 
							inner join detalleprematricula dpr on dpr.idprematricula=pr.idprematricula 
							inner join materia m on m.codigomateria=dpr.codigomateria 
							where pr.codigoperiodo='".$_POST['periodo']."' and e.codigocarrera='".$_POST['codigocarrera']."'
							GROUP BY dpr.codigomateria
							ORDER BY m.nombremateria";
			//echo $query_materia;
			$materia= $db->Execute($query_materia);
			$totalRows_materia = $materia->RecordCount();   
		}
?>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
       
         <script language="JavaScript" type="text/javascript">

function prueba()
{
    document.form1.submit();
}
         </script>
    </head>
 <body>
     <form action=""  name="form1" method="POST">
             <table  border="0" cellpadding="3" cellspacing="3">
                 <TR>
                     <td id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" >Resultados Evaluación Docente</label>
                     </td>
                 </TR>
                 <tr>
                      <td id="tdtitulogris" >Seleccione la Modalidad </td>
                      <td>
                          <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="prueba()">
                              <option value="">
                                Seleccionar
                              </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                            <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_POST['codigomodalidadacademica']) {
                                echo "Selected";
                                 }?>>
                            <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                              </option><?php }?>
                          </select>
                      </td>
                  </tr>
                  <tr>
                      <td  id="tdtitulogris">Seleccione la Carrera </td>
                      <td>
                          <select name="codigocarrera" id="codigocarrera" onchange="prueba()">
                              <option value="">Seleccionar</option>
                                <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                    if ($row_carrera['codigocarrera']==$_POST['codigocarrera']) {
                                    echo "Selected";
                                    $nombrecarrera = $row_carrera['nombrecarrera'];
                                     }?>>
                                    <?php echo $row_carrera['nombrecarrera'];
                                    ?>
                                </option><?php };?>
                          </select>
                      </td>
                  </tr>                  
                  <tr>
                      <td  id="tdtitulogris" >Seleccione el Periodo
                      </td>
                      <td>
                          <select name="periodo" id="periodo" onchange="prueba()">
                              <option value="">
                                  Seleccionar
                              </option>
                              <?php while ($row_periodo = $periodo->FetchRow()) { ?>
                              <option value="<?php echo $row_periodo['codigoperiodo']; ?>"
                                  <?php
                                  if ($row_periodo['codigoperiodo'] == $_REQUEST['periodo']) {
                                  echo "Selected";
                                  } ?>>
                              <?php echo $row_periodo['nombreperiodo']; ?>
                              </option><?php } ?>
                          </select>
                      </td>
                  </tr>
                  <tr>
                      <td  id="tdtitulogris">Seleccione la Materia </td>
                      <td>
                          <select name="codigomateria" id="codigomateria">
                              <option value="">Seleccionar</option>
                                <?php while ($row_materia = $materia->FetchRow()){?><option value="<?php echo $row_materia['codigomateria'] ?>"<?php
                                    if ($row_materia['codigomateria']==$_POST['codigomateria']) {
                                    echo "Selected";
                                    $nombremateria = $row_materia['nombremateria'];
                                     }?>>
                                    <?php echo $row_materia['nombremateria'];
                                    ?>
                                </option><?php };?>
                          </select>
                      </td>
                  </tr>  
                  <tr>
                      <td id="tdtitulogris" ><input type="submit" name="generar" value="Ver Resultados"></td>
                  </tr>                  
              </table>
   </form>
   <?php if($_POST['codigocarrera'] != '' && $_POST['periodo'] != '' && $_POST['codigomateria'] != ''){
	   
		/*Query periodo*/
		$SQL = "select fechainicioperiodo, fechavencimientoperiodo from periodo where codigoperiodo = '".$_REQUEST['periodo']."'";
		$fechasPeriodo = $db->Execute($SQL);
		
		$SQL = "select i.idsiq_Ainstrumentoconfiguracion from siq_Adetallepublicoobjetivo d
				inner join siq_Apublicoobjetivo p ON d.idsiq_Apublicoobjetivo = p.idsiq_Apublicoobjetivo
				inner join siq_Ainstrumentoconfiguracion i ON p.idsiq_Ainstrumentoconfiguracion = i.idsiq_Ainstrumentoconfiguracion
				where d.cadena = '::".$_REQUEST['codigomateria']."' 
				and d.tipocadena = 3 
				AND DATE(i.fecha_inicio) between DATE('".$fechasPeriodo->fields['fechainicioperiodo']."') AND DATE('".$fechasPeriodo->fields['fechavencimientoperiodo']."') limit 1";
		$MGI = $db->Execute($SQL);

		
		if($MGI->_numOfRows == 0){
			echo "<script>alert('No hay evaluaciones para esta materia en el periodo seleccionado');</script>";
		}else{
			$idMGI=$MGI->fields['idsiq_Ainstrumentoconfiguracion'];
			$catMGI = "OTRAS";
			include(dirname(__FILE__)."/../../../mgi/ManagerEntity.php");
			include(dirname(__FILE__)."/../../../mgi/autoevaluacion/interfaz/instrumento_reporte.php");
		}
   } ?>
  </body>
</html>