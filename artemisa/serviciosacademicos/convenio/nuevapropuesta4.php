<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    require_once(realpath(dirname(__FILE__))."/../modelos/convenios/SolicitudConvenios.php");

    if(!$db){
    	$db = getBD();
    }
    $sqlS = "select idusuario from usuario where usuario = '" . $_SESSION['MM_Username'] . "'";
    $datosusuario = $db->GetRow($sqlS);
    $usuario = $datosusuario['idusuario'];
    
    if(!$_REQUEST['id'])
    {
        ?>
    	<script type="text/javascript">
    		window.location = './Propuestaconvenio.php';
    	</script>
    	<?php
    }

    
    $codigoFacultad = $_SESSION['codigofacultad'];
    $edit=false;
    $action = "SaveData";
    if(isset($_REQUEST["id"])){
    		$solicitud = new solicitudConvenio();
    		$solicitud->load("SolicitudConvenioId=?", array($_REQUEST["id"]));
    		$edit = true;
    		$action = "UpdateData";
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <link rel="stylesheet" href="cssEmail/style.css" type="text/css" />
        <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Solicitud</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesPropuestas.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>

        <script>
            function Regresar()
            {
                location.href = "./nuevapropuesta3.php?id=<?php echo $_GET["id"]; ?>";
            }
        </script>
		<script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
		<style>
			table{
				width:80%;
				align:"center";
			}
			
			#container{
				margin-top:10px;
			}
			.titulo{
				font-size:16px;
				font-weight:bold;
				background-color:#CCC;
			}
			.tablagris tr td:first-child{
				background-color:#DDD;
                width: 420px;
			}
			input{
				width:90%;
			}
			textarea{
				width:95%;
			}
			.boton{
				width:100px;
			}
		</style>
    </head>
    <body>
  		<div align="center" id="container">
			<form id="propuesta" name="propuesta" method="post" action="procesarSolicitudConvenio.php">
	    		<input type="hidden" id="Action_id" name="Action_id" value="<?php echo $action; ?>" />
	    		<input type="hidden" id="paso" name="paso" value="4" />
				<?php if($edit){ ?>
	    		<input type="hidden" id="SolicitudConvenioId" name="SolicitudConvenioId" value="<?php echo $_REQUEST['id']; ?>" />				
				<?php }  ?>		
			<table>
			<tr>
					<td colspan="2" class="titulo" align="center">OBJETIVOS</td>
				</tr>
				<tr>
					<td style="background-color:#DDD;" align="center">General</td>
					<td style="background-color:#DDD;" align="center">Específicos</td>
				</tr>
				<tr>
					<td><textarea maxlength="1000" rows="8" cols="50" id="txtObjetivoG" class="required" name="txtObjetivoG"  onkeypress="return val_texto(event)"
					placeholder="Por favor ingrese el objetivo general"><?php if($edit){ echo $solicitud->objetivogeneral;} ?></textarea></td>
					<td><textarea maxlength="1000" rows="8" cols="50" id="txtObjetivosE" class="required" name="txtObjetivosE"  onkeypress="return val_texto(event)"
					placeholder="Por favor ingrese los objetivos específicos"><?php if($edit){ echo $solicitud->objetivoespecifico;} ?></textarea></td>
				</tr>
				<tr>
					<td style="background-color:#DDD;" align="center" colspan="2">Compromisos</td>
				</tr>
				<tr>
					<td colspan="2"><textarea maxlength="1000" rows="8" cols="70" class="required" id="txtCompromiso" name="txtCompromiso" onkeypress="return val_texto(event)"
					placeholder="Por favor ingrese los compromisos"><?php if($edit){ echo $solicitud->compromiso;} ?></textarea></td>
				</tr>
				<tr>
					<td style="background-color:#DDD;">Duración estimada del convenio<span style="color: red;">*</span></td>
					<td>
					    <select name="duracionConvenio" id="duracionConvenio" class="required custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ui-autocomplete-input">
					        <option value=""></option>
					        <?php
					        $sqlDuracionConvenio = "select idsiq_duracionconvenio, nombreduracion FROM siq_duracionconvenio WHERE idsiq_duracionconvenio <> '11'";
					        $duracionConvenios = $db->GetAll($sqlDuracionConvenio);
					        foreach ($duracionConvenios as $duracionConvenio) {
								$check = "";
								if($edit && $solicitud->duracionconvenioid==$duracionConvenio['idsiq_duracionconvenio']){ 
										$check = "selected";
								}							
								echo "<option value='" . $duracionConvenio['idsiq_duracionconvenio'] . "' ".$check.">" . $duracionConvenio['nombreduracion'] . "</option>";
							}
					        ?>
					    </select>
					</td>
				</tr>
				<tr>
					<td style="background-color:#DDD;">Responsable académico<span style="color: red;">*</span></td>
					<td><input type="text" id="txtNombreDocente" class="required" name="txtNombreDocente" size="50%"  onkeypress="return val_texto(event)"
					value="<?php if($edit){ echo $solicitud->responsableacademico;} ?>" /></td>
				</tr>
				<tr>
					<td style="border-color: #ccc; border-style: solid; border-width: 1px;"><center>Actividades<span style="color: red;">*</span></center></td>
					<td><textarea maxlength="1000" rows="8" cols="50" class="required" id="txtActividades" name="txtActividades" onkeypress="return val_texto(event)"
					placeholder="Por favor ingrese las Actividades"><?php if($edit){ echo $solicitud->actividades;} ?></textarea></td>
				</tr>
				<tr>
					<td style="border-color: #ccc; border-style: solid; border-width: 1px;"><center>Resultados Esperados<span style="color: red;">*</span></center></td>
					<td><textarea maxlength="1000" rows="8" cols="50" class="required" id="txtResultados" name="txtResultados" onkeypress="return val_texto(event)"
					placeholder="Por favor ingrese los resultados esperados"><?php if($edit){ echo $solicitud->resultadoesperado;} ?></textarea></td>
				</tr>
		    		</table>
					<div style="width:80%;margin-bottom:20px;clear:both;height:40px">
								<input type="submit" class="boton" id="Guardar" name="Guardar" value="Siguiente" style="display:block;float:right;"/>
								<input type="button" class="boton" value="Anterior" onclick="Regresar()" style="display:block;float:left;"/>
					</div>
			</form>
		</div>
<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#propuesta");
                    if(valido){
                       $( "#propuesta" ).submit();
                    }
                });	
</script>
    </body>
</html>