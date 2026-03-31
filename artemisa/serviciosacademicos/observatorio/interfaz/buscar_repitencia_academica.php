<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

include('../templates/templateObservatorio.php');
include("funciones.php");

 $db =writeHeader("Repitecia <br> Academica",true,"PAE");
    //require_once('../../funciones/sala/nota/nota.php');
    //require_once('../../funciones/sala/estudiante/estudiante.php');
    $fun = new Observatorio();
    $tipo=$_REQUEST['tipo'];
    $codigoperiodo=$_REQUEST['periodo'];
    $codigocarrera=$_REQUEST['carrera'];
    $modalidad=$_REQUEST['modalidad'];
    $codigomateria=$_REQUEST['materia'];
    $estudiante=$_REQUEST['nestudiante'];
	
	 function estaEnPruebaA($codigoestudiante){
        global $db;
        //$db->debug = true;
        $query_situacion = "select e.codigoestudiante
        from estudiante e
        where e.codigosituacioncarreraestudiante in (200)
        and e.codigoestudiante = '$codigoestudiante'";
        //echo $query_situacion;
        $situacion = $db->Execute($query_situacion);
        $totalRows_situacion = $situacion->RecordCount();
        return $totalRows_situacion;


    }

       ?>
<script>
     $(document).ready( function () {
				var oTable = $('#customers').dataTable( {
                                        "sDom": '<"H"Cfrltip>',
                                        "bJQueryUI": false,
                                        "bProcessing": true,
					"bScrollCollapse": true,
                                        "bPaginate": true,
                                        "sPaginationType": "full_numbers",
                                        "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                 "aiExclude": [ 0 ]
                                          }

				} );
				//new FixedColumns( oTable );
                                
      
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
                            
    });


</script>
<?php
     $smat=""; $sestu='';
        if ($codigomateria!=''){
            $smat="  AND m.codigomateria='".$codigomateria."'  ";
        }
       if ($estudiante!=''){
            $sestu="  AND g.numerodocumento='".$estudiante."'  ";
        }
    if (empty($tipo)){
       $query_carrera="SELECT
                            c.codigocarrera,
                        	c.nombrecarrera,
                        	m.codigomateria,
                        	m.nombremateria,
                        	e.semestre,
                        	p.codigoestudiante,
                        	g.numerodocumento,
                        	g.nombresestudiantegeneral,
                        	g.apellidosestudiantegeneral
                          
                        FROM
                        prematricula p                         
                        INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula
                        INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante
                        INNER JOIN estudiantegeneral g ON g.idestudiantegeneral=e.idestudiantegeneral
                        INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                        INNER JOIN materia m ON m.codigomateria=dp.codigomateria
                        
                        WHERE
                        
                        p.codigoperiodo='".$codigoperiodo."'
                        AND
                        p.codigoestadoprematricula IN(40,41)
                        AND
                        dp.codigoestadodetalleprematricula=30
                        AND
                        e.codigocarrera='".$codigocarrera."' 
                        ".$smat." ".$sestu."                        
                        
                        GROUP BY
                        	p.codigoestudiante
                        ORDER BY
                        	g.apellidosestudiantegeneral,
                        	g.nombresestudiantegeneral";
  
   $data_in= $db->Execute($query_carrera);

        
 ?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
    <td>N Identificaci&oacute;n</td>
        <td>Nombre</td>
        <td>Carrera</td>
        <td>Semestre</td>
        <td>Codigo Asignatura</td> 
        <td>Asignatura</td>
        <td>No de Repeticiones</td> 
        <td>Periodo</td>
        
        <td>Nota</td>
		<td>Estado del Estudiante</td>
    </thead>
    <tbody>
    <?php foreach($data_in as $dt){ 
        
        $sql_Ccarr="SELECT nombremateria, codigoestudiante, p.codigoperiodo, dp.codigomateria, count(dp.codigomateria) as tot_mat
            FROM prematricula as p
            INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
            INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
            INNER JOIN materia as m on (dp.codigomateria=m.codigomateria)
            where p.codigoestudiante = '".$dt['codigoestudiante']."'  ".$smat."
            and ep.codigoestadoprematricula IN (40,41) and dp.codigoestadodetalleprematricula=30
            group by dp.codigomateria HAVING tot_mat > 1";
        // echo $sql_Ccarr;die;
         $data_C= $db->Execute($sql_Ccarr);
         foreach($data_C as $dtC){
//             $sqlnota="select * from notahistorico 
//                        where codigoestudiante='".$dt['codigoestudiante']."' 
//                            and codigomateria='".$dtC['codigomateria']."' and codigoperiodo='".$dtC['codigoperiodo']."' and codigotiponotahistorico=100;";
//            
             $sqlnota="SELECT nombremateria, p.codigoestudiante, p.codigoperiodo, dp.codigomateria, h.notadefinitiva
                        FROM prematricula as p 
                        INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula) 
                        INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula) 
                        INNER JOIN materia as m on (dp.codigomateria=m.codigomateria) 
                        INNER JOIN notahistorico  AS h on (p.codigoestudiante=h.codigoestudiante 
                                                          and p.codigoperiodo=h.codigoperiodo
                                                          and dp.codigomateria=h.codigomateria)
                        where p.codigoestudiante = '".$dt['codigoestudiante']."' and ep.codigoestadoprematricula IN (40,41) 
                        and dp.codigomateria='".$dtC['codigomateria']."' and codigotiponotahistorico=100
                        and dp.codigoestadodetalleprematricula=30";
             $data_N= $db->Execute($sqlnota);
            //$dataN= $data_N ->GetArray();
            //$dataN=$dataN[0];
            foreach($data_N as $dtN){
                     //if($dtC['tot_mat']>1){
                ?>
                        <tr>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral']; ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['semestre'] ?></td>
                            <td><?php echo $dtC['codigomateria']?></td>
                            <td><?php echo $dtC['nombremateria']?></td>
                            <td><?php echo $dtC['tot_mat'] ?></td>
                            <td><?php echo $dtN['codigoperiodo'] ?></td>
                            <td><?php echo $dtN['notadefinitiva'];?></td>
                            <td><?php $prueba=estaEnPruebaA($dt['codigoestudiante']); 
                              if($prueba!= 0){
                                       echo "Está en prueba académica";
                                    }
                            ?></td>
                        </tr>
                    <?php
                    $i++;
             }
           }
        }
    ?>
    </tbody>
</table>
<br />
<?PHP 
$Data_Info = PorcentajeRepitencia($db,$codigocarrera,$codigomateria,$codigoperiodo);
?>
 <table border="0" class="CSSTableGenerator">
     <tr>
         <td>% de Repitencia de Asignatura <?php echo $Data_Info["Name"]; ?></td>
         <td><strong><?php echo $Data_Info["Porcentaje"]; ?>&nbsp;%</strong></td>
    </tr>
 </table>
<?php
    }else if ($tipo==2) {
		$smat=""; 
		$smat2=""; 
		$materias = array();
        if ($codigomateria!=''){
            $smat="  AND dp.codigomateria='".$codigomateria."'  ";
            $smat2="  AND nh.codigomateria='".$codigomateria."'  ";
			 $query_materias_carrera = "SELECT m.codigomateria, m.nombremateria   
				FROM materia m WHERE m.codigomateria='".$codigomateria."' ";
				//echo $query_materias_carrera."<br/>";
				$materias[0]= $db->GetRow($query_materias_carrera);				
			
        } else {
			 $query_materias_carrera = "SELECT m.codigomateria, m.nombremateria   
				FROM planestudio p
				inner join detalleplanestudio dp on dp.idplanestudio=p.idplanestudio 
				inner join materia m on m.codigomateria=dp.codigomateria 
				where p.codigocarrera='".$codigocarrera."' GROUP BY m.codigomateria ORDER BY nombremateria";
				 $materiasCarrera= $db->Execute($query_materias_carrera);
				 $materias= $materiasCarrera->GetArray();
				
				// print_r($materiasCarrera);
				$smat= " AND dp.codigomateria IN ($query_materias_carrera)";
				$smat2="  AND nh.codigomateria IN ($query_materias_carrera)";
		}
		$total = 0;
		$contador = 0;
		?>
		<br>
		<br>
		 <table border="0" class="CSSTableGenerator">
		 <?php 
		foreach($materias as $materia){
			$codigomateria=$materia["codigomateria"];
			$sql_Te="SELECT count(p.codigoestudiante) as tot_estu
						FROM prematricula as p
						INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
						INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
						INNER JOIN materia as m on (dp.codigomateria=m.codigomateria) 
						INNER JOIN estudiante e on e.codigoestudiante=p.codigoestudiante and e.codigocarrera='".$codigocarrera."' 
						where p.codigoperiodo='".$codigoperiodo."' AND dp.codigomateria='".$codigomateria."'  
						and p.codigoestadoprematricula IN (40,41) and dp.codigoestadodetalleprematricula=30;";
						//echo $sql_Te;
			$data_N= $db->Execute($sql_Te);
			$dataN= $data_N ->GetArray();
			$dataN=$dataN[0];
			$estu_ins=$dataN['tot_estu'];
			
			$cp2=$codigoperiodo-1;
			$sql_EP="SELECT * from notahistorico nh 
				
							inner join estudiante e on e.codigoestudiante=nh.codigoestudiante 
							and e.codigocarrera='".$codigocarrera."' 
							where nh.codigoperiodo<'".$codigoperiodo."'  AND nh.codigomateria='".$codigomateria."' 	
							AND e.codigoestudiante IN 
							(
							SELECT p.codigoestudiante
								FROM prematricula as p
								INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
								INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
								INNER JOIN materia as m on (dp.codigomateria=m.codigomateria) 
								INNER JOIN estudiante e on e.codigoestudiante=p.codigoestudiante and e.codigocarrera='".$codigocarrera."' 
								where p.codigoperiodo='".$codigoperiodo."' AND dp.codigomateria='".$codigomateria."'  
								and p.codigoestadoprematricula IN (40,41) and dp.codigoestadodetalleprematricula=30
							)						
							GROUP BY e.codigoestudiante";
		//echo $sql_EP;
			/*$sql_Te="SELECT count(codigoestudiante) as tot_estu
						FROM prematricula as p
						INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
						INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
						INNER JOIN materia as m on (dp.codigomateria=m.codigomateria)
						where p.codigoperiodo='".$codigoperiodo."' and dp.codigomateria='".$codigomateria."'
						and p.codigoestadoprematricula=40 and dp.codigoestadodetalleprematricula=30;";
			$data_N= $db->Execute($sql_Te);
			$dataN= $data_N ->GetArray();
			$dataN=$dataN[0];
			$estu_ins=$dataN['tot_estu'];
			
			$cp2=$codigoperiodo-1;
			$sql_EP="SELECT nombremateria, codigoestudiante, p.codigoperiodo, dp.codigomateria, count(codigoestudiante) as tot_mat
					FROM prematricula as p
					INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
					INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
					INNER JOIN materia as m on (dp.codigomateria=m.codigomateria)
					where  dp.codigomateria='".$codigomateria."' and  p.codigoperiodo>='".$cp2."'
					and p.codigoestadoprematricula=40 and dp.codigoestadodetalleprematricula=30
					group by p.codigoestudiante HAVING tot_mat > 1";*/
			//echo $sql_EP;
			$data_E= $db->Execute($sql_EP);
			$dataE= $data_E->GetArray();
		  //  print_r($dataE);
			$estu_Re=count($dataE);
		   // echo $estu_Re.'/'.$estu_ins;
		    $repitenciaMateria = ($estu_Re/$estu_ins)*100;
			$total+=$repitenciaMateria;
			$contador++;
			?>
			
                <tr>
                     <td>% de Repitencia de Asignatura <?php echo $materia["nombremateria"]; ?></td>
                     <td><?php echo number_format($repitenciaMateria,2) ?></td>
                </tr>
		<?php }
		/*$sql = "SELECT e.* from prematricula pr
							inner join detalleprematricula dp on dp.idprematricula=pr.idprematricula and codigoperiodo='".$codigoperiodo."' 
							and pr.codigoestadoprematricula IN (40,41) 
							inner join estudiante e on e.codigoestudiante=pr.codigoestudiante 
							and e.codigocarrera='".$codigocarrera."' 
							and codigomateria=".$codigomateria;
					echo "<br/><br/>".$sql;
					$estudiantesMatriculados = $db->GetAll($sql);
					
					
					$sql = "SELECT * from notahistorico nh 
					inner join prematricula pr on pr.codigoestudiante=nh.codigoestudiante 
					inner join detalleprematricula dp on dp.idprematricula=pr.idprematricula and pr.codigoperiodo='".$codigoperiodo."' and dp.codigomateria=nh.codigomateria
						inner join estudiante e on e.codigoestudiante=pr.codigoestudiante 
						and e.codigocarrera='".$codigocarrera."' 
						and nh.codigomateria='".$codigomateria."' and nh.codigoperiodo<'".$codigoperiodo."' GROUP BY e.codigoestudiante";
					$estudiantesRepitentes = $db->GetAll($sql);		
		if(count($estudiantesMatriculados)==0){$total = 0; } else { 
						$total = count($estudiantesRepitentes)/count($estudiantesMatriculados)*100;} */
		$total=($total/$contador);
		if($contador>1){
    ?>
           
                <tr>
                     <td>% de Repitencia de Asignaturas de la Carrera</td>
                     <td><?php echo number_format($total,2) ?></td>
                </tr>
				<?php } ?>
            </table>
    <?php
 }
?>
    <br>
     &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
</div>
<?PHP 
function PorcentajeRepitencia($db,$codigocarrera,$codigomateria,$codigoperiodo){
    
		$smat=""; 
		$smat2=""; 
		$materias = array();
        if ($codigomateria!=''){
            $smat="  AND dp.codigomateria='".$codigomateria."'  ";
            $smat2="  AND nh.codigomateria='".$codigomateria."'  ";
			 $query_materias_carrera = "SELECT m.codigomateria, m.nombremateria   
				FROM materia m WHERE m.codigomateria='".$codigomateria."' ";
				//echo $query_materias_carrera."<br/>";
				$materias[0]= $db->GetRow($query_materias_carrera);				
			
        } else {
			 $query_materias_carrera = "SELECT m.codigomateria, m.nombremateria   
				FROM planestudio p
				inner join detalleplanestudio dp on dp.idplanestudio=p.idplanestudio 
				inner join materia m on m.codigomateria=dp.codigomateria 
				where p.codigocarrera='".$codigocarrera."' GROUP BY m.codigomateria ORDER BY nombremateria";
				 $materiasCarrera= $db->Execute($query_materias_carrera);
				 $materias= $materiasCarrera->GetArray();
				
				// print_r($materiasCarrera);
				$smat= " AND dp.codigomateria IN ($query_materias_carrera)";
				$smat2="  AND nh.codigomateria IN ($query_materias_carrera)";
		}
		$total = 0;
		$contador = 0;
	
		foreach($materias as $materia){
			$codigomateria=$materia["codigomateria"];
			$sql_Te="SELECT count(p.codigoestudiante) as tot_estu
						FROM prematricula as p
						INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
						INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
						INNER JOIN materia as m on (dp.codigomateria=m.codigomateria) 
						INNER JOIN estudiante e on e.codigoestudiante=p.codigoestudiante and e.codigocarrera='".$codigocarrera."' 
						where p.codigoperiodo='".$codigoperiodo."' AND dp.codigomateria='".$codigomateria."'  
						and p.codigoestadoprematricula IN (40,41) and dp.codigoestadodetalleprematricula=30;";
						//echo $sql_Te;
			$data_N= $db->Execute($sql_Te);
			$dataN= $data_N ->GetArray();
			$dataN=$dataN[0];
			$estu_ins=$dataN['tot_estu'];
			
			$cp2=$codigoperiodo-1;
			$sql_EP="SELECT * from notahistorico nh 
				
							inner join estudiante e on e.codigoestudiante=nh.codigoestudiante 
							and e.codigocarrera='".$codigocarrera."' 
							where nh.codigoperiodo<'".$codigoperiodo."'  AND nh.codigomateria='".$codigomateria."' 	
							AND e.codigoestudiante IN 
							(
							SELECT p.codigoestudiante
								FROM prematricula as p
								INNER JOIN detalleprematricula as dp on (p.idprematricula=dp.idprematricula)
								INNER JOIN estadoprematricula as ep on (p.codigoestadoprematricula=ep.codigoestadoprematricula)
								INNER JOIN materia as m on (dp.codigomateria=m.codigomateria) 
								INNER JOIN estudiante e on e.codigoestudiante=p.codigoestudiante and e.codigocarrera='".$codigocarrera."' 
								where p.codigoperiodo='".$codigoperiodo."' AND dp.codigomateria='".$codigomateria."'  
								and p.codigoestadoprematricula IN (40,41) and dp.codigoestadodetalleprematricula=30
							)						
							GROUP BY e.codigoestudiante";
	
			$data_E= $db->Execute($sql_EP);
			$dataE= $data_E->GetArray();
		  //  print_r($dataE);
			$estu_Re=count($dataE);
		   // echo $estu_Re.'/'.$estu_ins;
		    $repitenciaMateria = ($estu_Re/$estu_ins)*100;
			$total+=$repitenciaMateria;
			$contador++;
			$MateriaName = $materia["nombremateria"];          
            $DataRepitencia = number_format($repitenciaMateria,2); 
		}//foreach
        
        $Data_Info['Name'] = $MateriaName;
        $Data_Info['Porcentaje'] = $DataRepitencia; 
	
    return $Data_Info;
}//function PorcentajeRepitencia
?>