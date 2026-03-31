<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    if(!isset ($_SESSION['MM_Username'])){
            //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
            echo "No ha iniciado sesión en el sistema";
            exit();
        }
		$db = getBD();

	/**** AJAX FUNCTIONS ****/
	
	if(isset($_POST['func'])){
		$func = $_POST['func']; 
		switch ($func) {
			case 'modalidadacademica':
				if($_POST['codigo'] != 0){
					$sQl = 'SELECT codigocarrera, nombrecarrera FROM carrera WHERE codigomodalidadacademica = '.$_POST['codigo'].' AND fechavencimientocarrera >= NOW()';
					if($Consulta=&$db->Execute($sQl)===false){
						echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
						die;
					}   
					$valores = &$db->Execute($sQl);
					$datos =  $valores->getarray();
					$select = '';
					foreach ($datos as $dato){
						$select .= '<option value="'.$dato['codigocarrera'].'">'.$dato['nombrecarrera'].'</option>';
					}
					echo $select;
					die;
				}
			break;
		}
	}
	
	/**** END AJAX FUNCTIONS ****/
?>
<html>
    <head>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <title>Reporte de usuarios padres</title><style type="text/css"></style>
		<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
    </head>
    <body>
       <div align="center">
            <form name="f1" action="listausuariospadre.php" method="post">
                <p class="Estilo3">CONSULTA 
                </p>
                <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr>
                        <td colspan="4" align="center" class="Estilo1" >
                            <label>Seleccione la modalidad academica</label>
                            <?php 
                                $sql= 'SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica where codigoestado = 100';
                                if($Consulta=&$db->Execute($sql)===false){
                                    echo 'Error en el SQL de la Consulta....<br><br>'.$sql;
                                    die;
                                }   
                                $valor_modalidad = &$db->Execute($sql);
                                $datos_modalidad =  $valor_modalidad->getarray();
                                $totaldatos=count($datos_modalidad);
                                if ($totaldatos>0){
                            ?>
                            <select name="codigomodalidadacademica" id="codigomodalidadacademica">
                                <option value=""></option>  
                                <?php
                                    foreach($valor_modalidad as $datos){
                                ?>
                                <option value="<?php echo $datos['codigomodalidadacademica'] ?>"><?php echo $datos['codigomodalidadacademica'].' - '.$datos['nombremodalidadacademica'] ?></option>
                                <?php
                                    }
                                    }
                                ?>
                            </select>
                       <br /><br />
					   
					   <label>Seleccione el programa</label>                            
							<select name="codigocarrera[]" id="codigocarrera" multiple>
								<option value="1">*Todos*</option>
							</select>
                       <br /><br />
                           
                            <label>Seleccione el periodo</label>
                            <?php 
                                $sql1= 'SELECT codigoperiodo FROM periodo ORDER BY codigoperiodo DESC';
                                if($Consulta=&$db->Execute($sql1)===false){
                                    echo 'Error en el SQL de la Consulta....<br><br>'.$sql1;
                                    die;
                                }   
                                $valor_periodo = &$db->Execute($sql1);
                                $datos_periodo =  $valor_periodo->getarray();
                                $totaldatos=count($datos_periodo);
                                if ($totaldatos>0){
                            ?>
                            <select name="codigoperiodo" id="codigoperiodo">
                                <option value=""></option>  
                                <?php
                                    foreach($valor_periodo as $datos){
                                ?>
                                <option value="<?php echo $datos['codigoperiodo'] ?>"><?php echo $datos['codigoperiodo'] ?></option>
                                <?php
                                    }
                                    }
                                ?>
                            </select>
                       <br /><br />
                           
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" class="Estilo1">
                        <input name="buscar" type="submit" value="Buscar">&nbsp;
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
	<script>
		/****
		*** AJAX TO CHANGE MODALIDAD ACADEMICA ***
		*****/
		$(document).ready(function (){
			$('#codigomodalidadacademica').change(function(){
				var codigo = $(this).val();
				$.ajax({
					type: 'POST',
					url: 'buscausuariospadre.php',
					dataType: 'html',
					data: {func: 'modalidadacademica', codigo: codigo},
					success: function(data) {
						$('#codigocarrera').html('');
						$('#codigocarrera').html(data);
					}
				});
			});				
		});
	</script>
</html>