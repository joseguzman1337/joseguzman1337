<?php 
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
$rutaF = "../../../../";
include_once('../../../estadisticas/notascorte/_funcionesNotas.php');
$objetobase=new BaseDeDatosGeneral($sala);

//$objetobase->conexion->query("USE sala;");
require_once('../../../../mgi/datos/templates/template.php');
require_once("./funciones.php");
require_once('../../../../utilidades/api/funcionesAcademica.php');


$periodo_1 = $_POST['Periodo_1'];
$periodo_2 = $_POST['Periodo_2']; 

  $SQL='SELECT
        	codigoperiodo 
        FROM
        	periodo
        
        WHERE
        
        codigoperiodo BETWEEN "'.$periodo_1.'" AND "'.$periodo_2.'"';
        
$C_Periodos = $objetobase->conexion->GetAll($SQL); 

  $SQL='SELECT 
        	codigoperiodo 
        FROM 
        	periodo         
        WHERE         
        codigoestadoperiodo in (3,1) 
		ORDER BY codigoestadoperiodo DESC';
        
$periodoActual = $objetobase->conexion->GetRow($SQL); 

$Carreras = '';
if($_POST['CodigoCarrera'][0]!=1){
    for($i=0;$i<count($_POST['CodigoCarrera']);$i++){
        if($i<1){
            $Carreras = $_POST['CodigoCarrera'][$i];
        }else{
            $Carreras = $Carreras.','.$_POST['CodigoCarrera'][$i];
        }
    }
}

$queryMaterias= getQueryListadoMateriasPlanesEstudiosPregrado($Carreras);

$separarJornadas = false;
//echo "BASE DE DATOS 2<BR/><pre>";print_r($db);
$codigoperiodo = $_REQUEST['codigoperiodo'];
//$queryPlanes = getQueryPlanesEstudioActivos($codigoperiodo);
//$queryPlanes =getQueryPlanesEstudio();
//$queryMaterias= getQueryListadoMateriasPlanesEstudiosPregrado();
//$queryMaterias= getQueryListadoMateriasPlanesEstudiosPregrado("123,124,118,119,133,134");
$separarJornadas = true;

//echo $queryMaterias;die;
$planes = $objetobase->conexion->GetAll($queryMaterias);

//echo '<pre>';print_r($planes);die;

$estados[100] = "Activo";
$estados[101] = "Construccion";
$estados[200] = "Inactivo";
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
<?php //echo $Carreras."<br/><br/>";echo $queryMaterias."<br/><br/>"; ?>
    <table>
        <thead>
            <tr>
                <th>Programa académico</th>
                <th>No. Plan de Estudio</th>
                <th>Plan de Estudio</th>
                <th>Estado plan</th>
                <th>Materia</th>
                <th>Semestre</th>
                <th>Créditos</th>
                <th>Materia Padre</th>
                <th>Linea Enfasis</th>

                <?php 
                $N = count($C_Periodos)-1;
                for($p=0;$p<count($C_Periodos);$p++){
                    ?>
                    <th>Total Estudiantes <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
					<?php if($periodoActual['codigoperiodo']==$C_Periodos[$p]['codigoperiodo']){ ?>
						<th>Estudiantes que perdieron en corte 1 <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
						<th>Estudiantes que perdieron en corte 2 <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
						<th>Estudiantes que perdieron en corte 3 <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
						<th>Estudiantes que perdieron en corte 4 <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
						<th>Estudiantes que perdieron en corte 5 <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
					<?php } else { ?>
						<th>Estudiantes que perdieron <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
						<th>Porcentaje de pérdida <?php echo $C_Periodos[$p]['codigoperiodo']?></th>
					<?php } ?>
                    <?php
                }
               
                ?>
            </tr>
        </thead>
        <tbody>		
		<?php
	foreach($planes as $plan){
		$pintar = false;
		$htmlRow = "<tr>";
		$htmlRow .= "<td>".$plan["nombrecarrera"]."</td>";
		$htmlRow .= "<td>".$plan["idplanestudio"]."</td>";
		$htmlRow .= "<td>".$plan["nombreplanestudio"]."</td>";
		$htmlRow .= "<td>".$estados[$plan["codigoestadoplanestudio"]]."</td>";
		if($plan["indicadorLinea"]==="Si"){
			
			for($p=0;$p<count($C_Periodos);$p++){
				$estudiantes[$C_Periodos[$p]['codigoperiodo']]= encuentra_array_materias($plan["codMateria"],$plan["codigocarrera"],200,$C_Periodos[$p]['codigoperiodo'],$C_Periodos[$p]['codigoperiodo'],$objetobase,0,$separarJornadas);
			}

			$htmlRow .= "<td>".$plan["materia"]."</td>";
			$htmlRow .= "<td>".$plan["semestredetalleplanestudio"]."</td>";
			$htmlRow .= "<td>".$plan["creditos"]."</td>";
			$htmlRow .= "<td>".$plan["nombremateria"]."</td>";
			$htmlRow .= "<td>".$plan["linea"]."</td>";
		} else {
		   
		   for($p=0;$p<count($C_Periodos);$p++){	    
			   $estudiantes[$C_Periodos[$p]['codigoperiodo']]=  encuentra_array_materias($plan["codigomateria"],$plan["codigocarrera"],200,$C_Periodos[$p]['codigoperiodo'],$C_Periodos[$p]['codigoperiodo'],$objetobase,0,$separarJornadas);
			}

			$htmlRow .= "<td>".$plan["nombremateria"]."</td>";
			$htmlRow .= "<td>".$plan["semestredetalleplanestudio"]."</td>";
			$htmlRow .= "<td>".$plan["numerocreditos"]."</td>";
			$htmlRow .= "<td></td><td></td>";
		}
		for($p=0;$p<count($C_Periodos);$p++){
			if($estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]!=null 
				&& $estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]!=""
				&& $estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]!=0){
				$pintar = true;
			}
			if($pintar && $periodoActual['codigoperiodo']==$C_Periodos[$p]['codigoperiodo'] 
			&& $estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]==0){
				// seguramente no se ha hecho cierre entonces hacer el calculo por los cortes
				$estudiantesMatriculados = $objetobase->conexion->GetAll(getQueryEstudiantesMatriculadosMateria($plan["codigomateria"],$periodoActual['codigoperiodo']));
				$perdieron = array();
				foreach($estudiantesMatriculados as $estudiante){
					//$notas_semestre = NotasSemestre($estudiante["idusuario"],$plan["codigocarrera"],$objetobase->conexion);
					$notas_semestre = getNotaMateria($estudiante["codigomateria"],$periodoActual['codigoperiodo'],$estudiante["codigoestudiante"],$objetobase->conexion);
					$promedioA = 0;
					foreach($notas_semestre["materia"]["nota"] as $corte){
						if(!isset($perdieron[$corte["corte"]])){
							if($corte["nota"]!=null){
								$perdieron[$corte["corte"]] = 0;
							} else {
								$perdieron[$corte["corte"]] = "-";
							}
						} 
						//$promedioA += ($corte["nota"]*$corte["porcentaje"]/100);
						if($corte["nota"]<3 && $corte["nota"]!=null){							
							$perdieron[$corte["corte"]]++;
							//var_dump($estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]);die;
						}
					}
					/*if($promedioA<$estudiante["notaminimaaprobatoria"]){
						$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]++;
					}*/
				}
				
				/*if($estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]>
				$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]){
					$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']] = $estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']];
				}*/
			}
			
			$porcentaje = $estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]/$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]*100;
			$porcentaje = round($porcentaje,2);
			$htmlRow .= "<td>".$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]."</td>";
			if($periodoActual['codigoperiodo']==$C_Periodos[$p]['codigoperiodo']){
				for($co=1;$co<=5;$co++){
					if($perdieron[$co]>$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]){
						$perdieron[$co] = $estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']];
					}
					$htmlRow .= "<td>".$perdieron[$co]."</td>";
				}
			} else {
				$htmlRow .= "<td>".$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]."</td>";
				$htmlRow .= "<td>".$porcentaje."</td>";
			}
		}
		
		$htmlRow .= "</tr>";
		if($pintar){
			echo $htmlRow;
		}
	}
?>
    </tbody>
    </table>
</body>
</html>
