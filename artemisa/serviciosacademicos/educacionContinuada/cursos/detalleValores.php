<div id="contentPage">
<?php
	
	session_start;
/*	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = getBD();
    $valores = array();
    $tiposEstudiante = array();
    $utils = Utils::getInstance();
    $periodo = $utils->getPeriodoActual($db);
    if(isset($_REQUEST["id"])){  
	   $id = $_REQUEST["id"];
            $data = $utils->getDataEntity("carrera", $id, "codigocarrera");  
            $sql="select * from valorpecuniario v 
                INNER JOIN concepto c ON c.codigoconcepto=v.codigoconcepto AND c.codigoestado=100 
                where v.codigoperiodo = '".$periodo["codigoperiodo"]."' AND v.codigoestado=100";
            $valores = $db->GetAll($sql);    
			
			$valoresActivos = array();
			
            $sql="select * from tipoestudiante";
            $tiposEstudiante = $db->GetAll($sql);   
    }
?>
	<form action="save.php" method="post" id="form_test">
            <input type="hidden" name="action" value="saveValoresPecunarios" />
			<input type="hidden" name="codigocarrera" value="<?php echo $_REQUEST["id"]; ?>" />
		<div id="tabs-4">
			<h4>Valores Pecunarios Programa de Educación Continuada</h4>
			<table class="detalle" style="width:100%">
			<tr>
						<th class="center" rowspan="2">Concepto</th>
						<th class="center" rowspan="2">Valor</th>
						<th class="center" colspan="<?php echo count($tiposEstudiante); ?>">Tipo de estudiante</th>
					</tr>
					<tr>
						<?php foreach($tiposEstudiante as $tipo){ 
							$sql="select v.idvalorpecuniario, IF(ISNULL(dv.iddetallefacturavalorpecuniario), false, true) AS elegido from valorpecuniario v 
                INNER JOIN concepto c ON c.codigoconcepto=v.codigoconcepto AND c.codigoestado=100 
				LEFT JOIN facturavalorpecuniario vp ON vp.codigoperiodo=v.codigoperiodo AND vp.codigocarrera='".$id."' 
                LEFT JOIN detallefacturavalorpecuniario dv ON dv.idfacturavalorpecuniario=vp.idfacturavalorpecuniario 
				AND dv.codigoestado=100 AND dv.idvalorpecuniario=v.idvalorpecuniario AND codigotipoestudiante='".$tipo["codigotipoestudiante"]."' 
                WHERE v.codigoperiodo = '".$periodo["codigoperiodo"]."' AND v.codigoestado=100";
							$valoresActivos[$tipo["codigotipoestudiante"]] = $db->GetAll($sql);
						?>
							<th class="center" ><?php echo $tipo["nombretipoestudiante"]; ?></th>
						<?php } ?>
					</tr>
					<?php $cont = 0; foreach($valores as $v){ ?>
					<tr>
						<td><?php echo $v["nombreconcepto"]; ?></td>
						<td class="center">$ <?php echo number_format($v["valorpecuniario"],0); ?></td>
						<?php foreach($tiposEstudiante as $tipo){ ?>
							<td class="center" >
							<input type="checkbox" name="aplica[]" value="<?php echo $v["idvalorpecuniario"]; ?>;<?php echo $tipo["codigotipoestudiante"]; ?>" <?php if($valoresActivos[$tipo["codigotipoestudiante"]][$cont]["elegido"]) { echo "checked='checked'"; } ?>/>
							</td>
						<?php } ?>
					</tr>
					<?php $cont++; } ?>
				</table>
						
		</div>
		<input type="submit" value="Guardar cambios" />
	</form>
</div>
<script type="text/javascript">
        $(':submit').click(function(event) {
                    event.preventDefault();
					sendForm();
		});
		
		function sendForm(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
							alert(data.message);
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
</script>