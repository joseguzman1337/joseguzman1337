<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', '0');

include('../../../men/templates/MenuReportes.php');

?>

    <style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                @import "data/media/css/ColReorder.css";
                @import "data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>
        <script type="text/javascript" language="javascript" src="data/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="jquery/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/FixedColumns.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColReorder.js"></script>
    <script type="text/javascript" language="javascript">
        
        $(document).ready( function () {
				var oTable = $('#example').dataTable( {
					"sDom": '<"H"Cfrltip>',
  					"sScrollX": "100%",
					"sScrollXInner": "100%",
					"bScrollCollapse": true,
                                        "bPaginate": true,
                                        "sPaginationType": "full_numbers",
                                        "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                 "aiExclude": [ 0 ]
                                          }
				} );
                                
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
			} );
</script>	
<?PHP
//    require_once('../../../Connections/sala2.php');
    $rutaado = "../../../funciones/adodb/";
    require_once("../../../funciones/clases/motorv2/motor.php");
    require_once("../../../Connections/salaado-pear.php");
    require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../../funciones/clases/formulario/clase_formulario.php");
    require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
    require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
    require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
    require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
    require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    
?>
<html>
    <body>
        <?php
        $codigomodalidadacademica=$_REQUEST['modalidad'];
        $codigomateria=$_REQUEST['codigomateria'];
        $tmaterias=$_REQUEST['tmaterias'];
        $codigocarrera=$_REQUEST['codigocarrera'];
        $codigoperiodo=$_REQUEST['periodo1'];
        $codigoperiodofinal=$_REQUEST['periodo2'];
        $tmaterias=$_REQUEST['tmaterias'];
        
function encuentra_array_materias($tmaterias,$codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$codigoperiodofinal,$objetobase,$imprimir=0){
 
 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($tmaterias!=1)
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query="select c.codigocarrera,c.nombrecarrera,m.codigomateria,m.nombremateria,g.codigoperiodo,
count(distinct e.codigoestudiante) total,

count(distinct h.codigoestudiante) definitiva,
CONCAT((ROUND((count(distinct h.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') porcentaje_definitiva

 from  grupo g, materia m, corte co, estudiante e, carrera c,detallenota d
left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	ROUND(h.notadefinitiva,1) < (select notaminimaaprobatoria from materia m5 where m5.codigomateria=h.codigomateria)

where 
d.idgrupo=g.idgrupo and
g.codigomateria=m.codigomateria and
d.codigoestudiante=e.codigoestudiante and 
co.idcorte=d.idcorte and
g.codigoperiodo between ".$codigoperiodo." and ".$codigoperiodofinal."
".$carreradestino."
".$materiadestino."
and  m.codigocarrera=c.codigocarrera 
and c.codigomodalidadacademica=".$codigomodalidadacademica."
group by g.codigoperiodo,m.codigomateria
order by c.nombrecarrera";
/*".$carreradestino."*/
/*".$materiadestino."*/		 
//echo $query;
	
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		//$array_interno[]=$row_operacion;
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["codigocarrera"]=$row_operacion["codigocarrera"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["nombrecarrera"]=$row_operacion["nombrecarrera"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["codigomateria"]=$row_operacion["codigomateria"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["nombremateria"]=$row_operacion["nombremateria"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["Total_Estudiantes_".$row_operacion["codigoperiodo"]]=$row_operacion["total"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]][".Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=$row_operacion["definitiva"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["%Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=$row_operacion["porcentaje_definitiva"];
		$arrayperiodos[$row_operacion["codigoperiodo"]]=$row_operacion["codigoperiodo"];
		
		$arraycolumnas["codigocarrera"]=1;
		$arraycolumnas["nombrecarrera"]=1;
		$arraycolumnas["codigomateria"]=1;
		$arraycolumnas["nombremateria"]=1;
		$arraycolumnas["Total_Estudiantes_".$row_operacion["codigoperiodo"]]=1;
		$arraycolumnas[".Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=1;
		$arraycolumnas["%Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=1;
		
	
		$arraylistadotmp[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["total_estudiantes."]+=$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["Total_Estudiantes_".$row_operacion["codigoperiodo"]];
		$arraylistadotmp[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["total_perdieron"]+=$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]][".Perdieron_Periodo_".$row_operacion["codigoperiodo"]];
	 	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
	if(is_array($arraylistado))
	foreach($arraylistado as $carrera => $arraymateria){
		foreach($arraylistado[$carrera] as $materia => $arrayvalores){
		 $arrayvalores["Total_Estudiantes."]=$arraylistadotmp[$carrera][$materia]["total_estudiantes."];
		 $arrayvalores["Total_Perdieron."]=$arraylistadotmp[$carrera][$materia]["total_perdieron"];
		
		 $arrayvalores["%Total_Perdieron"]=round($arraylistadotmp[$carrera][$materia]["total_perdieron"]/$arraylistadotmp[$carrera][$materia]["total_estudiantes"]*100)."%";
			foreach($arraycolumnas as $llave => $valor)
				if(!isset($arrayvalores[$llave]))
					$arrayvalores[$llave]="&nbsp";
			
			$array_lsta[]=$arrayvalores;
			
			
			
		}
	}
	$array_interno[0]=$array_lsta;
	$array_interno[1]=$arrayperiodos;
return $array_interno;
}
$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');

   
$cantidadestmparray=encuentra_array_materias($tmaterias,$codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$codigoperiodofinal,$objetobase,0);
//echo "<br>"; 
//print_r($cantidadestmparray);
$f2=$cantidadestmparray[0][0];
$i1=0;
$j1=0;
$z1=0;
$z2=0;
$val=""; $to=0;
?>
   <div id="container">
          <h2>HISTORICO DE NOTAS <?php echo $datoscarrera["nombrecarrera"] ?> POR PERIODOS <?php echo $_SESSION['codigoperiododdefinitivaperiodo'] ?> AL <?php echo $_SESSION['codigoperiodofinaldefinitivaperiodo'] ?></h2>
        </div>
          <div id="demo">
      <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <?php
                    foreach ($f2 as $index1 => $value1) {
                        ?>
                        <th><?php echo $index1 ?></th>
                        <?
                        $j1++;
                    }
                ?>
            </tr>      
        </thead>
        <tbody>
                <?php
                foreach ($cantidadestmparray[0] as $index1 => $value1) {
                    ?>
                    <tr>
                      <td><?php echo $z1+1 ?></td>
                   <?php
                    foreach ($f2 as $index1 => $value1) {
                        $val1=$cantidadestmparray[0][$z1];
                        ?>
                        <td>
                            <?php 
                            if( strpos( $index1, 'Total_Estudiantes_') !== false ){
                                $pieces = explode("_", $index1);
                                if ($val1[$index1]=='-') $val1[$index1]=0;
                                ?>
                                    <a target="_blank" href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=<?php echo $val1['codigomateria'] ?>&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $pieces[2]?>&periodof=<?php echo $pieces[2]?>&columna=0" ><?php echo $val1[$index1] ?></a>
                                <?php
                                if ($codigoperiodo==$pieces[2]){
                                    $to1_1=$to1_1+$val1[$index1];
                                }else{
                                    $to1_2=$to1_2+$val1[$index1];
                                }
                            }else if( strpos( $index1, 'Total_Estudiantes.') !== false ){
                                $pieces = explode("_", $index1);                              
                                ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=<?php echo $val1['codigomateria'] ?>&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $codigoperiodo?>&periodof=<?php echo $codigoperiodofinal?>&columna=0" ><?php echo $val1[$index1] ?></a>
                                <?php
                               if ($codigoperiodo==$pieces[2]){
                                    $to2_1=$to2_1+$val1[$index1];
                               }else{
                                  $to2_2=$to2_2+$val1[$index1];
                               }
                            }else if( strpos( $index1, '.Perdieron') !== false ){
                                $pieces1 = explode("_", $index1);
                                 ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=<?php echo $val1['codigomateria'] ?>&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $pieces[2]?>&periodof=<?php echo $pieces[2]?>&columna=5" ><?php echo $val1[$index1] ?></a>
                                <?php
                                if ($codigoperiodo==$pieces1[2]){
                                    $to3_1=$to3_1+$val1[$index1];
                                }else{
                                    $to3_2=$to3_2+$val1[$index1];
                                }
                            }else if( strpos( $index1, 'Total_Perdieron.') !== false ){
                                $pieces1 = explode("_", $index1);
                                 ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=<?php echo $val1['codigomateria'] ?>&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $codigoperiodo?>&periodof=<?php echo $codigoperiodofinal?>&columna=5" ><?php echo $val1[$index1] ?></a>
                                <?php
                                if ($codigoperiodo==$pieces1[2]){
                                    $to4_1=$to4_1+$val1[$index1];
                                }else{
                                   $to4_2=$to4_2+$val1[$index1];
                                }
                            }else{
                                echo $val1[$index1];
                            }    
                            ?>
                        </td>
                        <?php
                    }
                     $z1++;
                     ?>
                     </tr>
                    <?php
                }
                ?>
             <tr>
                 <td>Subtotales</td>
                 <?php
                      foreach ($f2 as $index2 => $value2) {
                          $val="-.-";
                         
                          ?>
                            <td>
                            <?php 
                            if( strpos( $index2, 'Total_Estudiantes_') !== false ){
                                $pieces = explode("_", $index2);
                                if ($codigoperiodo==$pieces[2]){
                                ?>
                                     <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $pieces[2]?>&periodof=<?php echo $pieces[2]?>&columna=0" ><?php echo $to1_1 ?></a>
                                 <?php
                                }else{
                                    ?>
                                     <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $pieces[2]?>&periodof=<?php echo $pieces[2]?>&columna=0" ><?php echo $to1_2 ?></a>
                                 <?php
                                }
                                
                             }else if( strpos( $index2, 'Total_Estudiantes.') !== false ){
                                $pieces = explode("_", $index2);
                                if ($codigoperiodo==$pieces[2]){
                                    //$to2_1=$to2_1+$val1[$index1];
                                     ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $codigoperiodo?>&periodof=<?php echo $codigoperiodofinal?>&columna=0" ><?php echo $to2_1 ?></a>
                                <?php
                               }else{
                                 // $to2_2=$to1_2+$val1[$index1];
                                   ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $codigoperiodo?>&periodof=<?php echo $codigoperiodofinal?>&columna=0" ><?php echo $to2_2 ?></a>
                                <?php
                               }
                               

                                
                            }else if( strpos( $index2, '.Perdieron') !== false ){
                                $pieces = explode("_", $index2);
                              if ($codigoperiodo==$pieces1[2]){
                                   // $to3_1=$to3_1+$val1[$index1];
                                    ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $pieces[2]?>&periodof=<?php echo $pieces[2]?>&columna=5" ><?php echo $to3_1 ?></a>
                                <?php
                                }else{
                                   // $to3_2=$to3_2+$val1[$index1];
                                    ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $pieces[2]?>&periodof=<?php echo $pieces[2]?>&columna=5" ><?php echo $to3_2 ?></a>
                                <?php
                                }
                                
                                
                            }else if( strpos( $index2, 'Total_Perdieron.') !== false ){
                                $pieces = explode("_", $index2);
                                if ($codigoperiodo==$pieces[2]){
                               //  echo $to4_1;
                                  ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $codigoperiodo?>&periodof=<?php echo $codigoperiodofinal?>&columna=5" ><?php echo $to4_1 ?></a>
                                <?php
                                }else{
                                  //  echo $to4_2;
                                     ?>
                                    <a target="_blank"  href="detalle_historico.php?tmateria=<?php echo $tmaterias ?>&codigomateria=todos&codigocarrera=<?php echo $val1['codigocarrera'] ?>&codigomodalidadacademica=<?php echo $codigomodalidadacademica ?>&periodoi=<?php echo $codigoperiodo?>&periodof=<?php echo $codigoperiodofinal?>&columna=5" ><?php echo $to4_2 ?></a>
                                <?php
                                }
                                    
                            }else{
                               echo $val;
                            }
                            ?>
                            </td>
                             
                         <?php
                          $z2++;
                     }
                 ?>
             </tr>
        </tbody>
      </table>
          </div>