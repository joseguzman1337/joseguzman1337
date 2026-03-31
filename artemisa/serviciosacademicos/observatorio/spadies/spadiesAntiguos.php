
<?php
 
	$ruta = "../";
	while (!is_file($ruta . 'Connections/sala2.php')) {
		$ruta = $ruta . "../";
	}
	require_once($ruta . 'Connections/sala2.php');
	$rutaado = $ruta . "funciones/adodb/";
	require_once($ruta . 'Connections/salaado.php');
    include_once("../templates/mainjson.php");
    include_once("../../utilidades/funcionesTexto.php");
			$sqlPeriodo = "SELECT codigoperiodo FROM periodo WHERE codigoperiodo < '20071' ORDER BY codigoperiodo DESC;";
				
				if ($DataP = &$db->Execute($sqlPeriodo) === false) {
				echo 'Error en el SQL Data Solicitudes....<br><br>' . $sqlPeriodo;
				die;
			}
			$Periodo = $DataP->GetArray();
			
			if(!(empty($_POST['periodo']))){
			   $periodo=$_POST['periodo'];
			   $numTable=1;
			  }else{
				  $periodo="1";
				  } ;
				 
?>
		<script src="js/jquery.min.js"></script>
	  <script type="text/javascript" src="js/table2CSV.js" > </script> 
	  <script>
	  
	  $( document ).ready(function() {
		  var periodo = <?php echo $periodo?>;
		  if(periodo === 1){
			  $('#respuesta').hide();
		  }
		
	  });
	  </script>
	<div align="center" width="50%" id="tablaPeriodo<?php echo $numTable?>">
	<table border="3" >
	
	<tr>
	
		 <td><label for="periodo" ><b>Seleccione Periodo: </b><span class="mandatory">(*)</span></label>
                            <select id="Periodo_id" name="Periodo_id">
                                <?PHP 
                                for ($i = 0; $i <= count($Periodo); $i++) {
                                    
                                    if($Periodo){
                                        $Selecte  = 'selected="selected"';
                                    }else{
                                        $Selecte  = '';
                                    }
                                    ?>
                                    <option value="<?PHP echo $Periodo[$i]['codigoperiodo']?>" <?PHP echo $Selecte?>><?PHP echo $Periodo[$i]['codigoperiodo']?></option>
                                    <?PHP
                                    
                                }
                                ?>
                            </select>
                        </td>
	</tr>
	</table>
	</div>
<?php 

		$sql = "SELECT DISTINCT

				eg.apellidosestudiantegeneral,
				eg.nombresestudiantegeneral,
				eg.tipodocumento,
				eg.numerodocumento,
				c.nombrecortocarrera,
				eg.idestudiantegeneral,
				eg.codigogenero,
				eg.fechanacimientoestudiantegeneral,
				cr.numeroregistrocarreraregistro
				
			FROM
				estudiante est,
				estudiantegeneral eg,
				estudiantedocumento ed,
				carrera c,
				periodo p,
				situacioncarreraestudiante s,
				modalidadacademica m,				
				carreraregistro cr
			WHERE	
			 eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND c.codigomodalidadacademica = 200
			AND est.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
			AND ed.fechavencimientoestudiantedocumento >= NOW()
			AND est.codigoperiodo = '".$_POST['periodo']."'
			AND est.codigosituacioncarreraestudiante != 109
			AND est.codigoperiodo = p.codigoperiodo
			AND cr.codigocarrera=c.codigocarrera

			ORDER BY
				3,
				est.codigoperiodo,eg.apellidosestudiantegeneral";
				
				if ($Data = &$db->Execute($sql) === false) {
				echo 'Error en el SQL Data Solicitudes....<br><br>' . $sql;
				die;
			}
			$Resultado = $Data->GetArray();
	
    ?>
<div id="respuesta">
    <table border="1" align="center" id="dataTable">
	<input type="hidden" id="periodoActual" name="periodoActual" value="<?php echo $_POST['periodo']?>"/>
        <thead>
            <tr>
                <th>apellido</th>
                <th>nombres</th>
                <th>tipoDocumento</th>
                <th>documento</th>
                <th>nombrePrograma</th>
                <th>codigoEstudiante</th>
                <th>sexo</th>
                <th>fechaNacimiento</th>
                <th>codigoSNIESprograma</th>
            </tr>
        </thead>
        <tbody>
            <?PHP 
          
            
            for($j=0;$j<count($Resultado);$j++){
                
                
                    if($Resultado[$j]['tipodocumento']==01 || $Resultado[$j]['tipodocumento']=='01'){
                        $Tipo_Doc = 'C';
                    }else if($Resultado[$j]['tipodocumento']==02 || $Resultado[$j]['tipodocumento']=='02'){
                        $Tipo_Doc = 'T';
                    }else if($Resultado[$j]['tipodocumento']==03 || $Resultado[$j]['tipodocumento']=='03'){
                        $Tipo_Doc = 'E';
                    }else if($Resultado[$j]['tipodocumento']==04 || $Resultado[$j]['tipodocumento']=='04'){
                        $Tipo_Doc = 'R';
                    }else{
                        $Tipo_Doc = 'O';
                    }
                    if($Resultado[$j]['codigogenero']==100 || $Resultado[$j]['codigogenero']=='100'){
                        $Genero  = 'F';
                    }else if($Resultado[$j]['codigogenero']==200 || $Resultado[$j]['codigogenero']=='200'){
                        $Genero  = 'M';
                    }
                    $Fecha1     = $Resultado[$j]['fechanacimientoestudiantegeneral'];
                    $Fecha = date("Y/m/d",strtotime($Fecha1));
                    $CodigoSNIES  = $Resultado[$j]['numeroregistrocarreraregistro'];
                    
                   $N++; 
				   $apellidosestudiantegeneral = strtoupper(sanear_string($Resultado[$j]['apellidosestudiantegeneral']));
				   $nombreestudiantegeneral = strtoupper(sanear_string($Resultado[$j]['nombresestudiantegeneral']));
                  ?>
                    <tr>
                        <td><?PHP echo $apellidosestudiantegeneral?></td>
                        <td><?PHP echo $nombreestudiantegeneral?></td>
                        <td><?PHP echo $Tipo_Doc?></td>
                        <td><?PHP echo $Resultado[$j]['numerodocumento']?></td>
                        <td><?PHP echo $Resultado[$j]['nombrecortocarrera']?></td>
                        <td><?PHP echo $Resultado[$j]['idestudiantegeneral']?></td>
                        <td><?PHP echo $Genero?></td>
                        <td><?PHP echo $Fecha?></td>
                        <td><?PHP echo $CodigoSNIES?></td>     
                    </tr>
                    <?PHP  
                
                
                /***********************************************/
            }//for
        
            ?>
        </tbody>
    </table> 
<div align="center">
				<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion" > 
                    <table border="1" align="left" width=10% align="center">
                        <tr>
                            <td align="center" width="5">
                                <p><img src="js/images/Office-Excel-icon.png" width="50" style="cursor: pointer;" class="botonExcel" /></p>
                                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                            </td>
                            <td align="center" width="5">
                                <p><img src="js/images/Office-Csv.png" width="50" style="cursor: pointer;" class="botonCsv" /></p>
                                <input type="hidden" id="datos_a_enviar2" name="datos_a_enviar2" />
                            </td>
                        </tr>
                    </table>
                </form>
</div>	
</div>	

<script>
	 $(".botonExcel").click(function (event) {
            $("#datos_a_enviar").val($("<div>").append($("#dataTable").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
		});
	$('#dataTable').each(function() {
				var $table = $(this);
				$(".botonCsv").click(function (event) {
					var csv = $table.table2CSV({delivery:'value'});
				  window.location.href = 'data:text/csv;charset=UTF-8,'
										+ encodeURIComponent(csv);
				});
			
			
		});
	$("#Periodo_id").change(function() {
		var periodo = $("#Periodo_id").val();
		var periodoActual=$("#periodoActual").val();
		if(periodo != periodoActual){
		$.ajax({
						type: 'POST',
						url: 'spadiesAntiguos.php',
						async: false,
						data: {periodo:periodo},                
						success:function(data){	
						
											$("#loading").css("display","none");				
							$('#respuesta').html(data);					
							$('#respuesta').show();
							$('#tablaPeriodo1').remove();
						},
						error: function(data,error,errorThrown){alert(error + errorThrown);}
				}); 
		}
				
  
});; 
</script>   

