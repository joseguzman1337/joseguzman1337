<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo 'menugraduados.php';?>";
}
function regresarGET()
{
	document.location.href="<?php echo 'menugraduados.php';?>";
}

</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 


function encuentra_array_materias($objetobase,$imprimir=0){ 
 
 
if(trim($_SESSION['codigocarreragraduados'])!="todos")
$carreradestino="AND c.codigocarrera='".$_SESSION['codigocarreragraduados']."'";
else
$carreradestino="";

if($_SESSION['codigomodalidadacademicagraduados']==='todos'){
    $modalidad="";
   
}else{    
    $modalidad="and m.codigomodalidadacademica='".$_SESSION['codigomodalidadacademicagraduados']."'";     
}

/*
 * @modified Carlos Suarez <suarezcarlos@unbosque.edu.co>
 * Aranda caso  83960
 * consulta actualizadas incluyendo las nuevas tablas creadas en el nuevo sistema de grados
 * @since  November 29, 2016
*/
 $query="
 SELECT nombrecarrera,
	SUM(graduados) AS graduados,
	0 graduadosantiguos,
	SUM(Mujeres) as Mujeres,
	SUM(Hombres) as Hombres,
CodigoPeriodo,
fecha_inicial,
fecha_final FROM ( SELECT c.nombrecarrera,
COUNT(R.RegistroGradoId) as graduados,
0 graduadosantiguos,
COUNT(
		CASE
		WHEN G.codigogenero = 100 THEN
			1
		END
	) AS Mujeres,
	COUNT(
		CASE
		WHEN G.codigogenero = 200 THEN
			1
		END
	) AS Hombres,
	F.CodigoPeriodo,
IF (
	substring(P.codigoperiodo, 5, 5) = '2',
	concat(
		substring(P.codigoperiodo, 1, 4),
		'-07-16'
	),
	concat(
		substring(P.codigoperiodo, 1, 4),
		'-01-01'
	)
) fecha_inicial,

IF (
	substring(P.codigoperiodo, 5, 5) = '2',
	concat(
		substring(P.codigoperiodo, 1, 4),
		'-12-31'
	),
	concat(
		substring(P.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM RegistroGrado as R
INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
INNER JOIN carrera c ON ( c.codigocarrera = E.codigocarrera )
INNER JOIN modalidadacademica m ON ( m.codigomodalidadacademica = c.codigomodalidadacademica )
INNER JOIN genero G ON ( G.codigogenero = EG.codigogenero )
INNER JOIN FechaGrado F ON (F.CarreraId = c.codigocarrera )
INNER JOIN AcuerdoActa A ON ( A.FechaGradoId = F.FechaGradoId AND A.AcuerdoActaId = R.AcuerdoActaId )
INNER JOIN DetalleAcuerdoActa D ON ( D.AcuerdoActaId = A.AcuerdoActaId AND D.EstudianteId = R.EstudianteId )
INNER JOIN periodo P ON ( P.codigoperiodo = F.CodigoPeriodo )
WHERE R.CodigoEstado = '100' 
".$modalidad."
".$carreradestino."
AND F.CodigoPeriodo BETWEEN ".$_SESSION['codigoperiododgraduados']." and ".$_SESSION['codigoperiodofinaldgraduados']."
GROUP BY
	c.codigocarrera,
	P.codigoperiodo
UNION
SELECT c.nombrecarrera, COUNT(rg.idregistrograduado) as graduados,0 graduadosantiguos,
        COUNT(CASE WHEN g.codigogenero = 100 THEN 1 END) AS Mujeres,
	COUNT(CASE WHEN g.codigogenero = 200 THEN 1 END) AS Hombres,
p.codigoperiodo,
	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))        
fecha_inicial,
	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

fecha_final
FROM
        registrograduado rg,
	estudiante e,
	periodo p,
	carrera c,
	modalidadacademica m,
	genero g,
	estudiantegeneral eg
	WHERE
	rg.codigoestudiante=e.codigoestudiante
	".$modalidad."
	and c.codigomodalidadacademica=m.codigomodalidadacademica
	and c.codigocarrera = e.codigocarrera
	".$carreradestino."
	AND rg.codigoestado='100'
	AND rg.codigoautorizacionregistrograduado='100'
        AND eg.idestudiantegeneral = e.idestudiantegeneral
        AND g.codigogenero = eg.codigogenero
	and p.codigoperiodo between ".$_SESSION['codigoperiododgraduados']." and ".$_SESSION['codigoperiodofinaldgraduados']."
	and rg.fechagradoregistrograduado BETWEEN 

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))  AND 

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

group by c.codigocarrera,p.codigoperiodo ) B
GROUP BY nombrecarrera,
CodigoPeriodo
UNION
                SELECT
                        c.nombrecarrera,
                        0 graduados,
                        COUNT(
                                DISTINCT rg.idregistrograduadoantiguo
                        ) AS graduadosantiguos,	
                COUNT(
                        CASE
                        WHEN EG.codigogenero = 100 THEN
                                1
                        END
                ) AS Mujeres,
                COUNT(
                        CASE
                        WHEN EG.codigogenero = 200 THEN
                                1
                        END
                ) AS Hombres,
                        p.codigoperiodo,

                IF (
                        substring(p.codigoperiodo, 5, 5) = '2',
                        concat(
                                substring(p.codigoperiodo, 1, 4),
                                '-07-16'
                        ),
                        concat(
                                substring(p.codigoperiodo, 1, 4),
                                '-01-01'
                        )
                ) fecha_inicial,

        IF (
                substring(p.codigoperiodo, 5, 5) = '2',
                concat(
                        substring(p.codigoperiodo, 1, 4),
                        '-12-31'
                ),
                concat(
                        substring(p.codigoperiodo, 1, 4),
                        '-07-15'
                )
        ) fecha_final
        FROM
                registrograduadoantiguo rg,
                periodo p,
                carrera c,
                modalidadacademica m,
                estudiante E,
                estudiantegeneral EG

        WHERE
                c.codigomodalidadacademica = m.codigomodalidadacademica
        AND rg.codigocarrera = c.codigocarrera
        AND E.codigoestudiante = rg.codigoestudiante
        AND EG.idestudiantegeneral= E.idestudiantegeneral
         ".$modalidad."
	and rg.codigocarrera=c.codigocarrera
	".$carreradestino."
	and p.codigoperiodo between ".$_SESSION['codigoperiododgraduados']." and ".$_SESSION['codigoperiodofinaldgraduados']."
	and rg.fechagradoregistrograduadoantiguo BETWEEN 

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))  AND 

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

group by c.codigocarrera,p.codigoperiodo
order by codigoperiodo desc,nombrecarrera 

";
/* END */
//echo $query;		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
							  
		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	foreach($row_operacion as $llave=>$valor)
	$row[$llave]="";

	}


return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');



if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicagraduados']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicagraduados']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreragraduados']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreragraduados']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododgraduados']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododgraduados']=$_REQUEST['codigoperiodo'];

if($_REQUEST['codigoperiodofinal']!=$_SESSION['codigoperiodofinaldgraduados']&&(trim($_REQUEST['codigoperiodofinal'])!=''))
$_SESSION['codigoperiodofinaldgraduados']=$_REQUEST['codigoperiodofinal'];



unset($filacarreras);
$_SESSION['idestudianteseguimientogeneral']='';

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigocarreragraduados'],"","",0);
if(isset($datoscarrera["nombrecarrera"])!='')
$titulocarrera="EN LA CARRERA ".$datoscarrera["nombrecarrera"];
echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE GRADUADOS  DEL PERIODO ".$_SESSION['codigoperiododgraduados']." AL PERIODO ".$_SESSION['codigoperiodofinaldgraduados']."
				 ".$titulocarrera." </h3></td></tr></table>";

$cantidadestmparray=encuentra_array_materias($objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray,"ESTADISTICAS GRADUADOS ","listadoseguimiento.php",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Estudiantes','listadoseguimiento.php','listadodetalleestudianteseguimiento.php','','Codigo_Estado',"&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregarllave_drilldown('Seguimientos','listadoseguimiento.php','listadodetalleseguimiento.php','','Codigo_Estado',"&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&columna=1",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('graduados',"listadoseguimiento.php","listadodetalleestudianteseguimiento.php","totales","&codigomateria=".$_SESSION['codigomateriaseguimiento']."&codigocarrera=".$_SESSION['codigocarreraseguimiento']."&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&Codigo_Estado=todos","","","Totales");

$motor->agregar_llaves_totales('graduados',"","","totales","","","","Totales");
$motor->agregar_llaves_totales('graduadosantiguos',"","","totales","","","","Totales");
$motor->agregar_llaves_totales('Mujeres',"","","totales","","","","Totales");
$motor->agregar_llaves_totales('Hombres',"","","totales","","","","Totales");


$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
