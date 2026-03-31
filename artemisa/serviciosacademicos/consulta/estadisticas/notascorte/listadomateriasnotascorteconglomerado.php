<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
ini_set('max_execution_time','216000');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();w
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo 'menumateriasnotascorteconglomerado.php';?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menumateriasnotascorteconglomerado.php';?>";
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
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' );
require_once("../../../funciones/sala/nota/nota.php");
require_once("../../../funciones/sala/nota/ExtensionNota.php");

function notaRiesgo($codigomateria,$nota,$objetobase){
    $datosmateria=$objetobase->recuperar_datos_tabla("materia","codigomateria",$codigomateria,"","",0);   
    
    if($nota<$datosmateria["notaminimaaprobatoria"]){
        return 1;
    }
    return 0;
}

function encuentra_array_materias($codigocarrera,$codigoperiodo,$semestreestudiante,$numerocorte,$objetobase,$imprimir=0) {


    if($codigocarrera!="todos")
        $carreradestino="AND e.codigocarrera='".$codigocarrera."'";
    else
        $carreradestino="";

    if($semestreestudiante!="todos")
        $semestredestino="and p.semestreprematricula='".$semestreestudiante."'";
    else
        $semestredestino="";

    if($codigomateria!="todos")
        $materiadestino= "AND m.codigomateria='".$codigomateria."'";
    else
        $materiadestino= "";
/*@modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se se añade relacion con tabla situacioncarreraestudiante
 *@since november 27,2018 
 */
$query="select *,m.codigomateria codigomateriareal from
materia m , prematricula p, detalleprematricula d, 
estudiante e, detallenota dn, grupo g, estudiantegeneral eg, corte co, carrera c,situacioncarreraestudiante sce
where 
m.codigomateria=d.codigomateria and
c.codigocarrera=e.codigocarrera and
d.idprematricula=p.idprematricula and
e.codigoestudiante=p.codigoestudiante and
sce.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante
and g.idgrupo=dn.idgrupo
and dn.codigoestudiante=e.codigoestudiante
and g.codigomateria=m.codigomateria
and g.codigoperiodo=p.codigoperiodo
and eg.idestudiantegeneral=e.idestudiantegeneral
and co.idcorte=dn.idcorte
AND p.codigoestadoprematricula in (40,41)
AND d.codigoestadodetalleprematricula =30
and p.codigoperiodo=".$codigoperiodo."
and dn.codigomateria=d.codigomateria
".$carreradestino."
".$semestredestino."
and co.numerocorte between '1' and '".$numerocorte."'
order by p.semestreprematricula,m.nombremateria,
		 eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,co.numerocorte";

    if($imprimir)
        echo $query;

    $operacion=$objetobase->conexion->query($query);

//$row_operacion=$operacion->fetchRow();
    while ($row_operacion=$operacion->fetchRow()) {
        $row_operacion['nombremateria'].="_Cred".$row_operacion['numerocreditos'];
        $array_armado[$row_operacion['numerodocumento']]["nombre"]=$row_operacion['apellidosestudiantegeneral']."  ".$row_operacion['nombresestudiantegeneral'];
        $array_armado[$row_operacion['numerodocumento']]["numerodocumento"]=$row_operacion['numerodocumento'];
        $array_armado[$row_operacion['numerodocumento']]["situacion"]=$row_operacion['nombresituacioncarreraestudiante'];
        $array_armado[$row_operacion['numerodocumento']]["nombrecarrera"]=$row_operacion['nombrecarrera'];
        $array_armado[$row_operacion['numerodocumento']]["semestreprematricula"]=$row_operacion['semestreprematricula'];
        $array_armado[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=$row_operacion['nota'];
        $array_armado[$row_operacion['numerodocumento']]["notas"][cambiarespacio($row_operacion['nombremateria'])][$row_operacion['numerocorte']]=$row_operacion['nota'];
        $materias[cambiarespacio($row_operacion['nombremateria'])]=$row_operacion['codigomateriareal'];
        $notasmateria[cambiarespacio($row_operacion['nombremateria'])][$row_operacion['numerocorte']]=$row_operacion['nota'];
        $notasmateriadocumento[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])][$row_operacion['numerocorte']]=$row_operacion['nota'];
        $array_creditos[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])][$row_operacion['numerocorte']]=$row_operacion['numerocreditos'];

        if($array_armado[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]<$row_operacion["notaminimaaprobatoria"])
            $notasperdidasmateria[cambiarespacio($row_operacion['nombremateria'])][]=$row_operacion['nota'];
        $row_operacion;
        $cortes[cambiarespacio($row_operacion['nombremateria'])][$row_operacion['numerocorte']]=$row_operacion['porcentajecorte'];
        
        unset($objnota);
        $objnota=new ExtensionNota($row_operacion["codigoestudiante"], $codigoperiodo);
        $array_armado[$row_operacion['numerodocumento']]["notaPPA"]=$objnota->calculaPPA();
        if(!$notaPPA=$objnota->tienePPAenBD()) {
            $notaPPA=$objnota->calculaPPA();
//echo "ENTRO?";
        }
        $acumuladoFallas[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=$objnota->acumuladoFallasCorte($numerocorte, $row_operacion['codigomateriareal']);
        unset($row['codigoperiodo']);
        $array_armado[$row_operacion['numerodocumento']]["NOTA_ACUMULADA"]=round($notaPPA,1);
        $array_armado[$row_operacion['numerodocumento']]["NOTA_SEMESTRAL"]=round($objnota->calcularPonderadoSemestral($objnota->nota,$objnota->numerocreditos,$objnota->porcentajecorte),1);
        $array_armado[$row_operacion['numerodocumento']]["NOTA_PARCIAL_SEMESTRAL"]=round($objnota->calcularPonderadoParcialSemestral($objnota->nota,$objnota->numerocreditos,$objnota->porcentajecorte),1);

        $i++;


        $notadefmateria[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=number_format(round($objnota->calcularNotaReal($objnota->nota,$objnota->numerocreditos,$objnota->porcentajecorte,$row_operacion['codigomateriareal']),1),1);
        $notadefmateriaTMP[$row_operacion['numerodocumento']][$row_operacion['codigomateria']]=number_format(round($objnota->nota[$row_operacion['codigomateriareal']],1),1);



        $porcentajecorte=$detallenota->porcentajecorte;


        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
    }
//     echo "notadefmateria<pre>";
//	print_r($notadefmateria);
//	echo "</pre>";

    $i=0;
    if(is_array($array_armado))
        foreach($array_armado as $numerodocumento => $row_armado) {
/*
            echo "notas<pre>";
            print_r($row_armado["notas"]);
            echo "</pre>";*/

            $row_otro["NOMBRE"]=$row_armado["nombre"];
            $row_otro["DOCUMENTO"]=$row_armado["numerodocumento"];
            $row_otro["SITUACION"]=$row_armado["situacion"];
            $row_otro["CARRERA"]=$row_armado["nombrecarrera"];
            $row_otro["SEMESTRE"]=$row_armado["semestreprematricula"];
            
            unset($creditos);
            unset($notas);

            foreach($materias as $materia => $numeral) {
                $cadenanotascorte="<table width='100%' ><tr>";
                $titulonotascorte="";
                $cadenatmpnotascorte="";
                //echo "if((!isset(".$row_armado[$materia]."))||(trim(".$row_armado[$materia].")==''))<br>";
                if($i==0) {
                    foreach($cortes[$materia] as $nocorte=>$tmpi) {
                        $titulonotascorte.="<td>".$tmpi."C".$nocorte."</td>";
                    }
                    $titulonotascorte.="<td valign='top'>Def</td>";
                    $titulonotascorte.="<td valign='top'>FT</td>";
                    $titulonotascorte.="<td valign='top'>FP</td></tr>";
                }

                if((!isset($row_armado[$materia]))||(trim($row_armado[$materia])=='')) {
                    $row_otro[$materia]="&nbsp;";
                    $creditos[]="0";
                    $notas[]="0";
                    /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                     *Se añade validacion si esta se cumple crea celdas con texto n/a esto para permitir realizar filtros en el excel
                     *Since november 27,2018 
                     */
                    if($row_otro[$materia]=="&nbsp;"){
                        $titulonotascorte.="<td valign='top'>n/a</td>";
                        $titulonotascorte.="<td valign='top'>n/a</td>";
                        $titulonotascorte.="<td valign='top'>n/a</td>";
                        $titulonotascorte.="<td valign='top'>n/a</td></tr>";
                    }
                    
                }
                else {

                    $creditos[]=$array_creditos[$numerodocumento][$materia][$numerocorte];
                    $notas[]=$row_armado["notas"][$materia][$numerocorte];

                    foreach($notasmateriadocumento[$numerodocumento][$materia] as $corte=>$notacorte) {

                        $cadenatmpnotascorte.="<td width='20%'>".$notacorte."</td> ";

                        //echo "<br>".$corte."=>".$notacorte;
                    }
                    if(notaRiesgo($numeral,$notadefmateria[$numerodocumento][$materia],$objetobase)){
                     $cadenatmpnotascorte.="<td style=' color:#FF140C; ' width='20%'>".$notadefmateria[$numerodocumento][$materia]."*</td>";
                    }
                    else{
                     $cadenatmpnotascorte.="<td width='20%'>".$notadefmateria[$numerodocumento][$materia]."</td>";
                    }
                    $cadenatmpnotascorte.="<td width='20%'>".$acumuladoFallas[$numerodocumento][$materia]["teorica"]."</td>";
                    $cadenatmpnotascorte.="<td width='20%'>".$acumuladoFallas[$numerodocumento][$materia]["practica"]."</td>";
                }
                if(trim($titulonotascorte)!="")
                    $titulonotascorte=$titulonotascorte."</tr><tr>";
                    $cadenanotascorte.=$titulonotascorte.$cadenatmpnotascorte."</tr></table>";
                    $row_otro[$materia]=$cadenanotascorte;


            }
           // $row_otro["PPA"]=$row_armado["notaPPA"];
            /*echo "notas<pre>";
            print_r($notas);
            echo "</pre>";
            echo "creditos<pre>";
            print_r($creditos);
            echo "</pre>";*/
            //$row_otro["PROMEDIO_PONDERADO"]=round(promedioponderado($notas,$creditos),2);
            if($row_armado["NOTA_ACUMULADA"]!="FALSO"){
                $row_otro["PROMEDIO_PONDERADO_ACUMULADO"]=$row_armado["NOTA_ACUMULADA"];
            }
            else{
                 $row_otro["PROMEDIO_PONDERADO_ACUMULADO"]="n/a";
            }
            $row_otro["PROMEDIO_PARCIAL_SEMESTRAL"]=$row_armado["NOTA_PARCIAL_SEMESTRAL"];
            if($row_armado["NOTA_SEMESTRAL"]<3){
            $row_otro["PROMEDIO_SEMESTRAL"]="<font color='#FF140C'>".$row_armado["NOTA_SEMESTRAL"]."*</font>";
            }
            else{
            $row_otro["PROMEDIO_SEMESTRAL"]=$row_armado["NOTA_SEMESTRAL"];
            }
            /*echo "$i<pre>";
		print_r($row_otro);
		echo "</pre>";
            */
            //$row_otro
            /*echo "$i<pre>";
		print_r($row_otro);
		echo "</pre>";*/

            $arrayinterno1[$i]=$row_otro;
            $i++;
        }

  /*  if(is_array($notasmateria))
        foreach ($notasmateria as $materia => $arraynotas) {
            $arrayinterno2[0]["TIPO DE CALCULO\\ASIGNATURA"]="<B>NOTA MINIMA</B>";
            $arrayinterno2[0][$materia]=min($arraynotas);
            $arrayinterno2[1]["TIPO DE CALCULO\\ASIGNATURA"]="<B>NOTA MAXIMA</B>";
            $arrayinterno2[1][$materia]=max($arraynotas);
            $arrayinterno2[2]["TIPO DE CALCULO\\ASIGNATURA"]="<B>DESVIACIÓN ESTANDAR</B>";
            $arrayinterno2[2][$materia]=round(desviacionestandar($arraynotas),2);
            $arrayinterno2[3]["TIPO DE CALCULO\\ASIGNATURA"]="<B>PROMEDIO</B>";
            $arrayinterno2[3][$materia]=round(promedio($arraynotas),2);
            $arrayinterno2[4]["TIPO DE CALCULO\\ASIGNATURA"]="<B>Nº ESTUDIANTES PERDIERON</B>";
            $arrayinterno2[4][$materia]=count($notasperdidasmateria[$materia]);
            $arrayinterno2[5]["TIPO DE CALCULO\\ASIGNATURA"]="<B>Nº ESTUDIANTES ASIGNATURA</B>";
            $arrayinterno2[5][$materia]=count($arraynotas);
        }*/
    $array_interno[0]=$arrayinterno1;
    //$array_interno[1]=$arrayinterno2;

    /*echo "<pre>";
	print_r($array_interno);
	echo "</pre>";*/


    return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');
$db=$objetobase->conexion;



if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicanotasmateriacorte']&&trim($_REQUEST['codigomodalidadacademica'])!='')
    $_SESSION['codigomodalidadacademicanotasmateriacorte']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotasmateriacorte]=".$_SESSION['codigomaterianotasmateriacorte'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreranotasmateriacorte']&&(trim($_REQUEST['codigocarrera'])!=''))
    $_SESSION['codigocarreranotasmateriacorte']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododnotasmateriacorte']&&(trim($_REQUEST['codigoperiodo'])!=''))
    $_SESSION['codigoperiododnotasmateriacorte']=$_REQUEST['codigoperiodo'];

if($_REQUEST['semestreestudiante']!=$_SESSION['semestreestudiantenotasmateriacorte']&&(trim($_REQUEST['semestreestudiante'])!=''))
    $_SESSION['semestreestudiantenotasmateriacorte']=$_REQUEST['semestreestudiante'];

if($_REQUEST['numerocorte']!=$_SESSION['numerocortenotasmateriacorte']&&(trim($_REQUEST['numerocorte'])!=''))
    $_SESSION['numerocortenotasmateriacorte']=$_REQUEST['numerocorte'];


unset($filacarreras);
echo "<table>";
echo "<tr><td>";
echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750' align='left'>";
$fila["<b>SOBRE EL REPORTE:</b> "]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
unset($fila);

$fila["<b>Nota por corte y materia</b>: El detalle se encuentra en cada columna correspondiente
    al nombre de la asignatura. El titulo de cada nota de corte es la union del porcentaje del corte ,
    la letra C y el numero del corte "]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
unset($fila);

$fila["<b>Definitiva</b>: el titulo aparece para cada materia y corresponde a la nota por asignatura, computo de las notas de los cortes por materia"]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

unset($fila);

$fila["<b>Titulo asignatura</b>:Hay una columna para cada materia , ademas del nombre de la asignatura , precedido de la abreviatura Cred puede encontrar el numero de creditos correspondiente"]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

unset($fila);

$fila["<b>PROMEDIO_PONDERADO_ACUMULADO</b>: Es el calculo del promedio acumulado historico "]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);



unset($fila);

$fila["<b>PROMEDIO_PARCIAL_SEMESTRAL</b>:Es el calculo promediado de las notas de todas
    las materias vistas en el semestre en donde intervienen el calculo de todos los cortes"]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

unset($fila);

$fila["<b>PROMEDIO_SEMESTRAL</b>:Es el calculo promediado de las notas de todas
    las materias con creditos, vistas en el semestre en donde intervienen el calculo de <b>solo los cortes registrados hasta el momento</b>"]="";
$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

echo "</table><br>";
echo "</td></tr>";
echo "<tr><td>";
//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO PROMEDIO CORTE ".$_SESSION['numerocortenotasmateriacorte']." PERIODO ".$_SESSION['codigoperiododnotasmateriacorte']." SEMESTRE ".strtoupper($_SESSION['semestreestudiantenotasmateriacorte'])."</h3></td></tr></table><br>";
if(!isset($_GET['Exportar'])){
$cantidadestmparray=encuentra_array_materias($_SESSION['codigocarreranotasmateriacorte'],$_SESSION['codigoperiododnotasmateriacorte'],$_SESSION['semestreestudiantenotasmateriacorte'],$_SESSION['numerocortenotasmateriacorte'],$objetobase,0);
$_SESSION["sesionlistadopromediocortesacumulado"]=$cantidadestmparray;

}
else{
$cantidadestmparray=$_SESSION["sesionlistadopromediocortesacumulado"];
}
echo "</td></tr>";
//echo "<pre>";
//print_r($cantidadestmparray);
//echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
echo "<tr><td>";
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

if($_GET['exporte']==2) {

    /*$motor = new matriz($cantidadestmparray[1],"RESUMEN DE PROMEDIOS CORTES","listadomateriasnotascortes.php?exporte=2",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
    $tabla->botonRecargar=false;
    $motor->mostrar();*/

    $motor = new matriz($cantidadestmparray[0],"ESTADISTICAS PROMEDIOS CORTES","listadomateriasnotascortes.php?exporte=1",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
    $tabla->botonRecargar=false;
    $motor->mostrar();
}
else {
    $motor = new matriz($cantidadestmparray[0],"ESTADISTICAS PROMEDIOS CORTES","listadomateriasnotascortes.php?exporte=1",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
    $tabla->botonRecargar=false;
    $motor->mostrar();

    /*$motor = new matriz($cantidadestmparray[1],"RESUMEN DE PROMEDIOS CORTES","listadomateriasnotascortes.php?exporte=2",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
    $tabla->botonRecargar=false;
    $motor->mostrar();*/
}
echo "</td></tr>";

?>
