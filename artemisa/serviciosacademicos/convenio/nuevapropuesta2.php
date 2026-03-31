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
        <title>Nueva Propuesta</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesPropuestas.js"></script>
        <script>
            function Regresar()
            {
                location.href = "./nuevapropuesta.php?id=<?php echo $_GET["id"]; ?>";
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
         function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9-]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        function val_dirrecion(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9a-zA-ZñÑ-\s]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
         <script>
        function val_email(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[0-9a-zA-Z\-\.\@\s]+$/;
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
	    		<input type="hidden" id="paso" name="paso" value="2" />
				<?php if($edit){ ?>
	    		<input type="hidden" id="SolicitudConvenioId" name="SolicitudConvenioId" value="<?php echo $_REQUEST['id']; ?>" />				
				<?php } ?>
			<table class="tablagris">
                <tr>
					<td colspan="2" align="center" class="titulo">Datos de la entidad contraparte</td>
				</tr>
            	<tr>
		    		<td>Nombre Institución:<span style="color: red;">*</span></td>
                    <td>
                        <select id="InstitucionConvenioId" name="InstitucionConvenioId" onchange="seleccionarInstitucion()">                        
                        <?php                        
                            $select = "SELECT InstitucionConvenioId, NombreInstitucion FROM InstitucionConvenios where InstitucionConvenioId <> '0'"; 
                            $instituciones = $db->GetAll($select);
                            foreach($instituciones as $lista)
                            {
                                if($solicitud->institucionconvenioid == $lista['InstitucionConvenioId'])
                                {
                                    echo "<option value='".$lista['InstitucionConvenioId']."' selected='selected'>".$lista['NombreInstitucion']."</option>";
                                }else
                                {                                      
                                    echo "<option value='".$lista['InstitucionConvenioId']."'>".$lista['NombreInstitucion']."</option>";
                                }
                            }
                        ?>
                        <option value="0" <?php if($solicitud->institucionconvenioid == '0'){ echo "selected='selected'";}?>>Otra</option>
                        </select>
                        <div id="TD_Otra">
                        <?php                        
                        if($solicitud->institucionconvenioid == '0')
                        {
                           echo "<input type='text' name='nombreconvenio' value='".$solicitud->nombreinstitucion."' id='nombreconvenio' size='50%' class='required' onkeypress='return val_texto(event)'/>";                        
                        }
                        ?>
                        </div>
                    </td>
		    	</tr>
				<tr>
					<td>Nombre del Representante legal <span style="color: red;">*</span></td>
					<td><input type="text" id="representante" name="representante" size="50%" class="required" value="<?php if($edit){ echo $solicitud->representanteinstitucion;} ?>" onkeypress="return val_texto(event)"/></td>
				</tr>
				<tr>
					<td>Documento de Identificación <span style="color: red;">*</span></td>
					<td><input type="text"  id="txtNumeroIdentificacion" name="txtNumeroIdentificacion" size="50%" 
					class="required" value="<?php if($edit){ echo $solicitud->identificacionrepresentanteinstitucion;} ?>" onkeypress="return val_numero(event)"/></td>
				</tr>
				<tr>
					<td>Nombre del Contacto en la Institución <span style="color: red;">*</span></td>
					<td><input type="text" id="txtContactoI" name="txtContactoI" size="50%" class="required" value="<?php if($edit){ echo $solicitud->nombrecontactoinstitucion;} ?>" onkeypress="return val_texto(event)"/></td>
				</tr>
				<tr>
					<td>Cargo <span style="color: red;">*</span></td>
					<td><input type="text" id="txtCargoSI" name="txtCargoSI" size="50%" class="required" value="<?php if($edit){ echo $solicitud->cargocontactoinstitucion;} ?>" onkeypress="return val_texto(event)"/></td>
				</tr>
				<tr>
					<td>Correo Electrónico <span style="color: red;">*</span></td>
					<td><input type="text" id="txtCorreoSI" name="txtCorreoSI" size="50%" class="required correo" value="<?php if($edit){ echo $solicitud->correocontactoinstitucion;} ?>" onkeypress="return val_email(event)"/></td>
				</tr>
				<tr>
					<td>Teléfono Celular / Fijo</td>
					<td><input type="text" id="txtCelularSI" name="txtCelularSI" size="50%" value="<?php if($edit){ echo $solicitud->telefonocontactoinstitucion;} ?>" onkeypress="return val_numero(event)"/></td>
				</tr>
				<tr>
					<td>Dirección Institución<span style="color: red;">*</span></td>
					<td><input type="text" id="txtDireccion" name="txtDireccion" size="50%" class="required" value="<?php if($edit){ echo $solicitud->direccioninstitucion;} ?>" onkeypress="return val_dirrecion(event)"/></td>
				</tr>
                <tr>
                    <td>Ámbito</td>
                    <td>
                        <?php if($solicitud->ambito == '2'){$Check2 = "selected";} if($solicitud->ambito == '1'){$Check1 = "selected";}?>
                        <select id="ambito" class="required" name="ambito">
                            <option></option>
                            <option value="1" <?php echo $Check1;?> >Internacional</option>
                            <option value="2" <?php echo $Check2;?> >Nacional</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tipo de convenio</td>
                    <td>
                        <select id="tipoconvenio" name="tipoconvenio">
                        <option></option>
                        <?php
                            $tiposconvenios = "select idsiq_tipoconvenio, nombretipoconvenio from siq_tipoconvenio where codigoestado ='100'";
                            $conveniostipo = $db->GetAll($tiposconvenios);
                            
                            foreach($conveniostipo as $datos)
                            {
                                echo "<option value='".$datos['idsiq_tipoconvenio']."'>".$datos['nombretipoconvenio']."</option>";
                            } 
                        ?>
                        </select>
                    </td>
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