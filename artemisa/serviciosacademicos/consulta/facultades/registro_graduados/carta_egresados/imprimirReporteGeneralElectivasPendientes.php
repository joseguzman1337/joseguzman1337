<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
 if(!isset ($_SESSION['MM_Username'])){

    echo "No tiene permiso para acceder a esta opción";
    exit();
}

    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title>Reporte</title>


<style type="text/css">
table
{
 border-collapse: collapse;
    border-spacing: 0;
}
th, td {
border: 1px solid #000000;
    padding: 0.5em;
}
</style>
</head>
<body>

<?php  if(isset($_REQUEST["codigofacultad"]) && $_REQUEST["codigofacultad"]!=""){ 
    include_once('./functionsElectivasPendientes.php'); ?>
    <table CELLPADDING="10" id="tableResult">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Semestre</th>
                    <th>Situación Estudiante</th>
                    <th># Créditos electivas aprobados</th>
                    <th># Créditos electivas pendientes</th>
                </tr>
            </thead>
        <tbody>
            
        <?php 
            //obtener estudiantes por graduarse
            $estudiantes = getEstudiantesPorGraduarse($_REQUEST["codigofacultad"],$_REQUEST["codigoprograma"],$db);
            $creditosAprobadosTotal= 0;
            $creditosPendientesTotal = 0;
            $creditosAprobadosTotalS= 0;
            $creditosPendientesTotalS = 0;
            $planEstudio = 0;
            $numCreditos = 0;
            $html = "";
            $carrera = 0;
            $semestre = 0;
            $numEstudiantesCumplen = 0;
            $numEstudiantesNoCumplen = 0;
            $arrayCreditosPlanEstudio = array();
             while ($row = $estudiantes->FetchRow()) { 
                    if($planEstudio!=$row["idplanestudio"] && $arrayCreditosPlanEstudio[$row["idplanestudio"]]==null){
                        $planEstudio = $row["idplanestudio"];
                        $numCreditos = intval(getCreditosElectivasPlanEstudio($row["codigoestudiante"],$db));
                        $arrayCreditosPlanEstudio[$row["idplanestudio"]] = $numCreditos;
                    } else if($arrayCreditosPlanEstudio[$row["idplanestudio"]]!=null){
                        $numCreditos = $arrayCreditosPlanEstudio[$row["idplanestudio"]];
                    }       
                    $materias = $db->Execute(getQueryMateriasElectivasCPEstudiante($row["codigoestudiante"],true));
                    $numCreditosPendientes = $numCreditos;
                    $numCreditosAprobados = 0;
                    if($numCreditosPendientes>0){
                        $row_electivas = $materias->FetchRow();
 
                        if($semestre!=$row["semestre"] || $carrera!=$row["codigocarrera"]){
                            if($carrera!=$row["codigocarrera"] && $carrera!=0){
                                $semestre = 0;
                            }
                            /*var_dump($semestre);
                            var_dump($row["semestre"]);
                            var_dump($row["codigocarrera"]);
                            var_dump($carrera);                             
                            var_dump($semestre!=0 || ($carrera!=$row["codigocarrera"] && $carrera!=0)); echo "<br/><br/>";*/
                            if($semestre!=0 || ($carrera!=$row["codigocarrera"] && $carrera!=0)){
                                
                                //var_dump("Total de Créditos Semestre --> " . $creditosAprobadosTotalS );       echo "<br/><br/>"; 
                                $html .= "<tr><th>Total de Créditos Semestre</th><th> </th><th> </th><th>".$creditosAprobadosTotalS."</th><th>".$creditosPendientesTotalS."</th></tr>";
                            }
                            $semestre=$row["semestre"];         
                            $creditosPendientesTotal += $creditosPendientesTotalS;
                            $creditosAprobadosTotal += $creditosAprobadosTotalS;                   
                            $creditosAprobadosTotalS= 0;
                            $creditosPendientesTotalS = 0;
                        }
                        
                        $numAprobados = $row_electivas["numerocreditos"];                        
                        if($numAprobados=="" || $numAprobados==null){
                            $numAprobados = 0;
                        }
                        $numCreditosPendientes = $numCreditosPendientes - $numAprobados;
                        if($numCreditosPendientes<0){
                            $numCreditosPendientes = 0;
                            $numAprobados = $numCreditos;
                        } 
                        //$creditosPendientesTotal += $numCreditosPendientes;
                       // $creditosAprobadosTotal += $numAprobados;
                        $numCreditosAprobados = $numAprobados;                        
                        $creditosAprobadosTotalS += $numAprobados;
                        $creditosPendientesTotalS += $numCreditosPendientes;
                        /*while ($row_electivas = $materias->FetchRow()) { 
                            $numCreditosPendientes = $numCreditosPendientes - $row_electivas["numerocreditos"];
                            $numCreditosAprobados += $row_electivas["numerocreditos"];
                        }*/

                        if($carrera!=$row["codigocarrera"]){
                            if($carrera!=0){
                                $html .= "<tr><th>Total de Créditos Carrera</th><th> </th><th> </th><th>".$creditosAprobadosTotal."</th><th>".$creditosPendientesTotal."</th></tr>";
                            }
                            $carrera=$row["codigocarrera"];
                            $numEstudiantesCumplen = 0;
                            $numEstudiantesNoCumplen = 0;
                            $creditosAprobadosTotal= 0;
                            $creditosPendientesTotal = 0;
                            $html .= "<tr><th colspan='5' class='category' >".$row["nombrecarrera"]."</th></tr>";
                        }

                        if($numCreditosPendientes>0){
                            $numEstudiantesNoCumplen += 1 ;

                            $html .= "<tr><td>".$row["nombre"]."</td><td>".$row["semestre"]."</td>
                                <td>".$row["nombresituacioncarreraestudiante"]."</td><td>".$numCreditosAprobados."</td>
                                <td>".$numCreditosPendientes."</td></tr>";
                        } else {
                            $html .= "<tr><td>".$row["nombre"]."</td><td>".$row["semestre"]."</td>
                                <td>".$row["nombresituacioncarreraestudiante"]."</td><td>".$numCreditosAprobados."</td>
                                <td>0</td></tr>";
                            $numEstudiantesCumplen += 1; 
                        }
                    }
                } 
                    if($html === "") {
                        echo "<td colspan='5' style='text-align:center' >No se encontraron estudiantes con electivas pendientes.</td>";
                    } else {
                        $html .= "<tr><th>Total de Créditos Semestre</th><th> </th><th> </th><th>".$creditosAprobadosTotalS."</th><th>".$creditosPendientesTotalS."</th></tr>";
                        $html .= "<tr><th>Total de Créditos Carrera</th><th> </th><th> </th><th>".($creditosAprobadosTotal+$creditosAprobadosTotalS)."</th>
                            <th>".($creditosPendientesTotal+$creditosPendientesTotalS)."</th></tr>";
                        echo $html;
                    } 
       ?>

        </tbody>
    </table>
<?php } ?>
</body>
</html>