<?php
$periodoInicial='20111';
$periodoFinal='20131';

/*Query Estudiantes Admitidos Estratos(1y2)*/
$query_periodo = "select codigoperiodo from periodo where codigoperiodo between ".$periodoInicial." and ".$periodoFinal." order by codigoperiodo";
                $periodo= $db->Execute($query_periodo);
                $totalRows_periodo= $periodo->RecordCount();
                
$Reporte = array( "Número de estudiantes admitidos por convenio de poblaciones especiales"
			,"Número de estudiantes admitidos por convenio de estratos bajos");
			
	
			
?>

<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>  
                  
             <tr id="dataColumns">
                 
                   <th class="column"><span>CARRERA</span></th> 
                    
<?PHP 
		$catd=0;
		while($row_periodo = $periodo->FetchRow()) {  
						$catd++;
			?>
             <th class="column" colspan='2'><span>A&Ntilde;O <?PHP echo $row_periodo['codigoperiodo']?></span></th>
             <?PHP   
}       
      ?> 
      
      <tr id="dataColumns"> 
      
      <th class="column" ><span>PREGRADO</span></th>

<?PHP 
			for($i=1;$i<=$catd;$i++) {
				foreach ($Reporte as &$valor) { 
?>
					<th class="column" ><span><?PHP echo $valor?></span></th>
<?PHP 
				}
			}
?>
		 
       </tr>
	 		   
        </thead>
        <tbody>
			<?PHP 
		$query_carrera= "select * from carrera where codigomodalidadacademica =200 and codigocarrera not in(2,600,605)
and fechainiciocarrera <=curdate() 
and fechavencimientocarrera >=curdate() and codigomodalidadacademicasic=200 
order by nombrecarrera";
                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera= $carrera->RecordCount();
                
?>
           
                <tr id="contentColumns" class="row">	                     
 												
					<?PHP 
		
		while($row_carrera = $carrera->FetchRow()) {  
			
			?>
		<tr>
                    <td class="column"><?PHP echo $row_carrera['nombrecarrera']?></td>  
                    
                    <?PHP 
                    
                   $query_estrato = "SELECT count(est.idestrato) as cantidad
                FROM estudianteestadistica ee, carrera c, estudiante e, estudiantegeneral eg,
estratohistorico est, estrato es
                where e.idestudiantegeneral=eg.idestudiantegeneral
and est.idestudiantegeneral=eg.idestudiantegeneral and es.idestrato=est.idestrato
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo =20111
                and e.codigocarrera=".$row_carrera['codigocarrera']."
                and ee.codigoprocesovidaestudiante= 400
                and ee.codigoestado like '1%'
and est.idestrato in(1,2)";
                $estrato= $db->Execute($query_estrato);
                $totalRows_estrato = $estrato->RecordCount();
                $row_estrato= $estrato->FetchRow() ;
                       
			for($i=1;$i<=$catd;$i++) {
				
                
				foreach ($row_estrato as &$valor) { 
					
?>
					 <td style="text-align:center"> <?PHP echo $valor?></td>
<?PHP 
				}
			}
?>
                                             
                    <?PHP    
}       
      ?>
                        
                </tr>
        </tbody>        
       
    </table>
