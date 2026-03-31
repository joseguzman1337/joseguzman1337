<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<!--<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />

<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>

<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>-->

<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo 'menunotascorte.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menunotascorte.php'; ?>";
    }

function ColorOut(id){
		$('#'+id).css('color','#000');
	}	
function ColorIn(id){
		$('#'+id).css('color','#090');
	}	
</script>
<style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                /*@import "data/media/css/themes/le-frog/jquery-ui-1.9.2.custom.css";*/
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                
    </style>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
<script type="text/javascript" language="javascript">
	/****************************************************************/
	$(document).ready( function () {
			
			oTable = $('#example').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
		} );
	/**************************************************************/
	$(document).ready( function () {
			
			oTable = $('#example2').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         $('#demo2').before( oTableTools.dom.container );
		} );
</script>	

<?php
$rutaado = ("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/clases/autenticacion/redirect.php' );

#echo '<br>codigomateria->'.$codigomateria.'<br>codigocarrera->'.$codigocarrera.'<br>codigomodalidadacademica->'.$codigomodalidadacademica.'<br>codigoperiodo->'.$codigoperiodo.'<br>objetobase->'.$objetobase;



function encuentra_array_materias($codigomateria, $codigocarrera, $codigomodalidadacademica, $codigoperiodo, $objetobase, $imprimir=0) {



    if ($codigocarrera != "todos")
        $carreradestino = "AND c.codigocarrera='" . $codigocarrera . "'";
    else
        $carreradestino="";

    if ($codigomateria != 0)
        $materiadestino = "AND m.codigomateria='" . $codigomateria . "'";
    else
        $materiadestino= "";

    $query = "select c.codigocarrera,c.nombrecarrera,m.codigomateria,m.nombremateria,g.codigoperiodo,
count(distinct e.codigoestudiante) Total_Estudiantes,
count(distinct d1.codigoestudiante) Perdieron_Corte1,
CONCAT((ROUND((count(distinct d1.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte1',
count(distinct d2.codigoestudiante) Perdieron_Corte2,
CONCAT((ROUND((count(distinct d2.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte2',

count(distinct d3.codigoestudiante) Perdieron_Corte3,
CONCAT((ROUND((count(distinct d3.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte3',

count(distinct d4.codigoestudiante) Perdieron_Corte4,
CONCAT((ROUND((count(distinct d4.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte4',

count(distinct h.codigoestudiante) Perdieron_Definitiva,
CONCAT((ROUND((count(distinct h.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%')  as '%Perdieron_definitiva',

count(distinct g.idgrupo) Total_Grupo

 from  grupo g, materia m, corte co, estudiante e, carrera c,detallenota d
	left join detallenota d1 on 
	d1.codigoestudiante=d.codigoestudiante and
	d1.idgrupo=d.idgrupo and
	d1.idcorte in (select idcorte from corte c1 where numerocorte=1 and c1.idcorte=co.idcorte) and
	ROUND(d1.nota,1) < (select notaminimaaprobatoria from materia m1 where m1.codigomateria=d1.codigomateria)

	left join detallenota d2 on 
	d2.codigoestudiante=d.codigoestudiante and
	d2.idgrupo=d.idgrupo and
	d2.idcorte in (select idcorte from corte c2 where numerocorte=2 and c2.idcorte=co.idcorte) and
	ROUND(d2.nota,1) < (select notaminimaaprobatoria from materia m2 where m2.codigomateria=d2.codigomateria)

	left join detallenota d3 on 
	d3.codigoestudiante=d.codigoestudiante and
	d3.idgrupo=d.idgrupo and
	d3.idcorte = (select idcorte from corte c3 where numerocorte=3 and c3.idcorte=co.idcorte) and
	ROUND(d3.nota,1) < (select notaminimaaprobatoria from materia m3 where m3.codigomateria=d3.codigomateria)


	left join detallenota d4 on 
	d4.codigoestudiante=d.codigoestudiante and
	d4.idgrupo=d.idgrupo and
	d4.idcorte = (select idcorte from corte c3 where numerocorte=4 and c3.idcorte=co.idcorte) and
	ROUND(d4.nota,1) < (select notaminimaaprobatoria from materia m4 where m4.codigomateria=d4.codigomateria)

left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	ROUND(h.notadefinitiva,1) < (select notaminimaaprobatoria from materia m5 where m5.codigomateria=h.codigomateria)

where 
d.idgrupo=g.idgrupo and
g.codigomateria=m.codigomateria and
d.codigoestudiante=e.codigoestudiante and 
co.idcorte=d.idcorte and
g.codigoperiodo=" . $codigoperiodo . "
" . $carreradestino . "
" . $materiadestino . "
 and  m.codigocarrera=c.codigocarrera and 
c.codigomodalidadacademica=" . $codigomodalidadacademica . "
AND g.codigoestadogrupo like '1%'
group by m.codigomateria
order by c.nombrecarrera";

    if ($imprimir)
        echo $query;

$iarray_interno=0;
    $operacion = $objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
    while ($row_operacion = $operacion->fetchRow()) {

        $tabla = "planestudio p,detalleplanestudio dp";
        $condicion = " and p.idplanestudio=dp.idplanestudio"
                . " and dp.codigomateria='" . $row_operacion["codigomateria"] . "'";
        $resultado = $objetobase->recuperar_resultado_tabla($tabla, "p.codigocarrera", $row_operacion["codigocarrera"], $condicion);
        $cadenasemestremateria = "";
        unset($filassemestre);
        while ($rowdetalleplan = $resultado->fetchRow()) {
            $filassemestre[$rowdetalleplan["semestredetalleplanestudio"]] = $rowdetalleplan["semestredetalleplanestudio"];
        }
        $isemestremateria = 0;
        if(is_array($filassemestre))
        foreach ($filassemestre as $ifilassemestre => $rowfilassemestre) {
            if ($isemestremateria == 0)
                $cadenasemestremateria.=$rowfilassemestre;
            else
                $cadenasemestremateria.="," . $rowfilassemestre;
            $isemestremateria++;
        }
        $row_operacion["semestremateria"] = $cadenasemestremateria;

$rowarrayinterno["codigocarrera"]=$row_operacion["codigocarrera"];
$rowarrayinterno["nombrecarrera"]=$row_operacion["nombrecarrera"];
$rowarrayinterno["codigomateria"]=$row_operacion["codigomateria"];
$rowarrayinterno["nombremateria"]=$row_operacion["nombremateria"];
$rowarrayinterno["semestremateria"]=$row_operacion["semestremateria"];
$rowarrayinterno["codigoperiodo"]=$row_operacion["codigoperiodo"];
$rowarrayinterno["Total_Estudiantes"]=$row_operacion["Total_Estudiantes"];
$rowarrayinterno["Perdieron_Corte1"]=$row_operacion["Perdieron_Corte1"];
$rowarrayinterno["%Perdieron_corte1"]=$row_operacion["%Perdieron_corte1"];
$rowarrayinterno["Perdieron_Corte2"]=$row_operacion["Perdieron_Corte2"];
$rowarrayinterno["%Perdieron_corte2"]=$row_operacion["%Perdieron_corte2"];
$rowarrayinterno["Perdieron_Corte3"]=$row_operacion["Perdieron_Corte3"];
$rowarrayinterno["%Perdieron_corte3"]=$row_operacion["%Perdieron_corte3"];
$rowarrayinterno["Perdieron_Corte4"]=$row_operacion["Perdieron_Corte4"];
$rowarrayinterno["%Perdieron_corte4"]=$row_operacion["%Perdieron_corte4"];
$rowarrayinterno["Perdieron_Definitiva"]=$row_operacion["Perdieron_Definitiva"];
$rowarrayinterno["%Perdieron_Definitiva"]=$row_operacion["%Perdieron_Definitiva"];
$rowarrayinterno["Total_Grupo"]=$row_operacion["Total_Grupo"];


        $array_interno[$iarray_interno] = $rowarrayinterno;
        $iarray_interno++;
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
    }
    return $array_interno;
}

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');


if ($_REQUEST['codigomateria'] != $_SESSION['codigomaterianotascorte'] && trim($_REQUEST['codigomateria']) != '')
    $_SESSION['codigomaterianotascorte'] = $_REQUEST['codigomateria'];


if ($_REQUEST['codigomodalidadacademica'] != $_SESSION['codigomodalidadacademicanotascorte'] && trim($_REQUEST['codigomodalidadacademica']) != '')
    $_SESSION['codigomodalidadacademicanotascorte'] = $_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if ($_REQUEST['codigocarrera'] != $_SESSION['codigocarreranotascorte'] && (trim($_REQUEST['codigocarrera']) != ''))
    $_SESSION['codigocarreranotascorte'] = $_REQUEST['codigocarrera'];

if ($_REQUEST['codigoperiodo'] != $_SESSION['codigoperiododnotascorte'] && (trim($_REQUEST['codigoperiodo']) != ''))
    $_SESSION['codigoperiododnotascorte'] = $_REQUEST['codigoperiodo'];



unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera = $objetobase->recuperar_datos_tabla('carrera', 'codigocarrera', $_SESSION['codigocarreranotascorte'], "", "", 0);
?>
	<div id="demo">
    	<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        	
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Codigo Carrera</th>
                    <th>Nombre Carrera</th>
                    <th>Codigo Materia</th>
                    <th>Nombre Materia</th>
                    <th>Semestre Materia</th>
                    <th>Codigo Periodo</th>
                    <th>Total Estudiantes</th>
                    <th>Perdieron Corte 1</th>
                    <th>% Perdieron Corte 1</th>
                    <th>Perdieron Corte 2</th>
                    <th>% Perdieron Corte 2</th>
                    <th>Perdieron Corte 3</th>
                    <th>% Perdieron Corte 3</th>
                    <th>Perdieron Corte 4</th>
                    <th>% Perdieron Corte 4</th>
                    <th>Perdieron Definitiva</th>
                    <th>% Perdieron Definitiva</th>
                    <th>Total Grupo</th>
                </tr>
            </thead>
             <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>        
            </tfoot> 
            <tbody>
            
            <?PHP 
			
			$cantidadestmparray = encuentra_array_materias($_SESSION['codigomaterianotascorte'], $_SESSION['codigocarreranotascorte'], $_SESSION['codigomodalidadacademicanotascorte'], $_SESSION['codigoperiododnotascorte'], $objetobase, 0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$motor = new matriz($cantidadestmparray, "ESTADISTICAS ALUMNOS X MATERIA ", "listadonotascortes.php?codigomateria=" . $_SESSION['codigomateria'] . "&codigocarrera=" . $_SESSION['codigocarrera'] . "&codigocarrerad=" . $_SESSION['codigocarrerad'] . "&codigoperiodo=" . $_SESSION['codigoperiodo'], 'si', 'si', 'menuasignacionsalones.php', 'listado_general.php', true, "si", "../../../");

			#echo 'Num->'.count($motor->matriz);
			
			#echo '<pre>';print_r($motor);
			
			#echo 'qqq->'.$motor->matriz[0]['codigocarrera'];
			
			for($i=0;$i<count($motor->matriz);$i++){
				?>
               	<tr>
                	<td><?PHP echo $i+1?></td>
                    <td><?PHP echo $motor->matriz[$i]['codigocarrera'];?></td>
                    <td><?PHP echo $motor->matriz[$i]['nombrecarrera'];?></td>  
                    <td><?PHP echo $motor->matriz[$i]['codigomateria'];?></td>
                    <td><?PHP echo $motor->matriz[$i]['nombremateria'];?></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['semestremateria'];?></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['codigoperiodo'];?></td>
                    <td align="center"><a  onclick="VentanaOpen('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','0','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Total Estudiantes')" style="cursor:pointer" onmouseover="ColorIn('TotalEstudiantes_<?PHP echo $i?>')" onmouseout="ColorOut('TotalEstudiantes_<?PHP echo $i?>')"><span id="TotalEstudiantes_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Total_Estudiantes'];?></span></a></td>
                    <td align="center"><a  onclick="VentanaOpen('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','1','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Perdieron Corte 1')" style="cursor:pointer" onmouseover="ColorIn('Corte1_<?PHP echo $i?>')" onmouseout="ColorOut('Corte1_<?PHP echo $i?>')"><span id="Corte1_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Perdieron_Corte1'];?></span></a></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['%Perdieron_corte1'];?></td>
                    <td align="center"><a  onclick="VentanaOpen('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','2','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Perdieron Corte 2')" style="cursor:pointer" onmouseover="ColorIn('Corte2_<?PHP echo $i?>')" onmouseout="ColorOut('Corte2_<?PHP echo $i?>')"><span id="Corte2_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Perdieron_Corte2'];?></span></a></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['%Perdieron_corte2'];?></td>
                    <td align="center"><a  onclick="VentanaOpen('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','3','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Perdieron Corte 3')" style="cursor:pointer" onmouseover="ColorIn('Corte3_<?PHP echo $i?>')" onmouseout="ColorOut('Corte3_<?PHP echo $i?>')"><span id="Corte3_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Perdieron_Corte3'];?></span></a></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['%Perdieron_corte3'];?></td>
                    <td align="center"><a  onclick="VentanaOpen('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','4','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Perdieron Corte 4')" style="cursor:pointer" onmouseover="ColorIn('Corte4_<?PHP echo $i?>')" onmouseout="ColorOut('Corte4_<?PHP echo $i?>')"><span id="Corte4_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Perdieron_Corte4'];?></span></a></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['%Perdieron_corte4'];?></td>
                    <td align="center"><a  onclick="VentanaOpen('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','5','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Perdieron Definitiva')" style="cursor:pointer" onmouseover="ColorIn('Corte5_<?PHP echo $i?>')" onmouseout="ColorOut('Corte5_<?PHP echo $i?>')"><span id="Corte5_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Perdieron_Definitiva'];?></span></a></td>
                    <td align="center"><?PHP echo $motor->matriz[$i]['%Perdieron_Definitiva'];?></td>
                    <td align="center"><a  onclick="VentanaOpenDif('<?PHP echo $_SESSION['codigoperiododnotascorte']?>','<?PHP echo $motor->matriz[$i]['codigomateria'];?>','5','<?PHP echo $motor->matriz[$i]['codigocarrera'];?>','Total Grupo')" style="cursor:pointer" onmouseover="ColorIn('Total_<?PHP echo $i?>')" onmouseout="ColorOut('Total_<?PHP echo $i?>')"><span id="Total_<?PHP echo $i?>"><?PHP echo $motor->matriz[$i]['Total_Grupo'];?></span></a></td>
                </tr>
                <?PHP
				}
			?>
           </tbody> 
        </table>
    </div> 
    <br /><br />  
    
  
<?PHP
die;

echo "<table width='100%'><tr><td align='center'><h3>LISTADO NOTAS PERDIDAS POR CORTE  " . $datoscarrera["nombrecarrera"] . " PERIODO " . $_SESSION['codigoperiododfacultadesmateriadetalle'] . "</h3></td></tr></table>";

$cantidadestmparray = encuentra_array_materias($_SESSION['codigomaterianotascorte'], $_SESSION['codigocarreranotascorte'], $_SESSION['codigomodalidadacademicanotascorte'], $_SESSION['codigoperiododnotascorte'], $objetobase, 0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$motor = new matriz($cantidadestmparray, "ESTADISTICAS ALUMNOS X MATERIA ", "listadonotascortes.php?codigomateria=" . $_SESSION['codigomateria'] . "&codigocarrera=" . $_SESSION['codigocarrera'] . "&codigocarrerad=" . $_SESSION['codigocarrerad'] . "&codigoperiodo=" . $_SESSION['codigoperiodo'], 'si', 'si', 'menuasignacionsalones.php', 'listado_general.php', true, "si", "../../../");

#echo '<pre>';print_r($motor);


//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"


$motor->agregarllave_drilldown('Total_Estudiantes', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=0", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte1', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=1", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte2', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=2", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte3', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=3", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte4', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=4", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Definitiva', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Total_Grupo', 'listadonotascorte.php', 'listadodetallegruposmaterias.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');

$motor->agregar_llaves_totales('Total_Estudiantes', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=0", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte1', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=1", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte2', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=2", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte3', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=3", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte4', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=4", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Definitiva', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", "", "", "Totales");
$motor->agregar_llaves_totales('Total_Grupo', "listadonotascorte.php", "listadodetallegruposmaterias.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", "", "", "Totales");


$tabla->botonRecargar = false;



//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
