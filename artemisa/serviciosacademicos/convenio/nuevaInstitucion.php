<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    if(!isset ($_SESSION['MM_Username']))
    {
        //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
        echo "No ha iniciado sesión en el sistema";
        exit();
    }

    $db = getBD();
    if(!empty($_POST['id'])){
        if($_POST['id'] == '5656'){
            $keyword = '%'.$_POST['keyword'].'%';
            $sql = "SELECT EmailSolicitanteBosque FROM InstitucionConvenios "
                   ."WHERE EmailSolicitanteBosque LIKE '$keyword' ORDER BY EmailSolicitanteBosque ASC LIMIT 0, 10";
            $query = $db->Execute($sql);
            $list = $query->getarray();
                foreach ($list as $rs){
                     // put in bold the written text
                     $EmailSolicitanteBosque = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['EmailSolicitanteBosque']);
                     // add new option
                     echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['EmailSolicitanteBosque']).'\',5656)">'.$EmailSolicitanteBosque.'</li>';
    
             }
        }if($_POST['id'] == '5657'){
            $keyword = '%'.$_POST['keyword'].'%';
            $sql = "SELECT emailsupervisorbosque FROM InstitucionConvenios "
                   ."WHERE emailsupervisorbosque LIKE '$keyword' ORDER BY emailsupervisorbosque ASC LIMIT 0, 10";
            $query = $db->Execute($sql);
            $list = $query->getarray();
                foreach ($list as $rs){
                     // put in bold the written text
                     $emailsupervisorbosque = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['emailsupervisorbosque']);
                     // add new option
                     echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['emailsupervisorbosque']).'\',5657)">'.$emailsupervisorbosque.'</li>';
    
             }
        }
        die();
    }
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }

    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    if($_POST['Action_id']=='SaveData')
    {
        $nombreInstitucion             = $_POST['NombreInstitucion'];
        $nit                           = $_POST['Nit'];    
        $direccion                     = $_POST['Direccion'];
        $telefono                      = $_POST['Telefono'];
        $telefonodos                   = $_POST['TelefonoDos'];
        $email                         = $_POST['Email'];
        $representantelegal            = $_POST['RepresentanteLegal'];
        $identificacionrepresentante   = $_POST['IdentificaciónRepresentante'];
        $ciudad                        = $_POST['Ciudad'];
        if(empty($ciudad)){$ciudad = '359';}
        $tipoinstitucion               = $_POST['tipoinstitucion'];
        $codigoestado                  = $_POST['CodigoEstado'];
        if(empty($codigoestado)){$codigoestado = '200';}
        $fechacreacion                 = date("Y-m-d H:i:s");
        $cargorepresentantelegal       = $_POST['CargoRepresentanteLegal'];
        $nombresupervisor              = $_POST['NombreSupervisor'];
        $identificacionsupervisor      = $_POST['IdentificaciónSupervisor'];
        $telefonosupervisor            = $_POST['TelefonoSupervisor'];
        $cargosupervisor               = $_POST['CargoSupervisor'];
        $emailsupervisor               = $_POST['EmailSupervisor'];
        $nombresolicitantebosque       = $_POST['nombresolicitantebosque'];
        $telefonosolicitantebosque     = $_POST['telefonosolicitantebosque'];
        $cargosolicitantebosque        = $_POST['cargosolicitantebosque'];
        $emailsolicitantebosque        = $_POST['emailsolicitantebosque'];
        $nombresupervisorbosque        = $_POST['nombresupervisorbosque'];
        $telefonosupervisorbosque      = $_POST['telefonosupervisorbosque'];
        $cargosupervisorbosque         = $_POST['cargosupervisorbosque'];
        $emailsupervisorbosque         = $_POST['emailsupervisorbosque'];
        $fechainicio                   = $_POST['fechainicio'];
        $fechafinal                    = $_POST['fechafin'];
        $vigencia                      = $_POST['vigencia'];
        $codigoinstitucion             = $_POST['codigoinstitucion'];
        
        $nombreInstitucion = limpiarCadena(filter_var($nombreInstitucion,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $nit = limpiarCadena(filter_var($nit,FILTER_SANITIZE_NUMBER_INT));
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
        $representantelegal = limpiarCadena(filter_var($representantelegal,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $identificacionrepresentante = limpiarCadena(filter_var($identificacionrepresentante,FILTER_SANITIZE_NUMBER_INT));
        $tipoinstitucion = limpiarCadena(filter_var($tipoinstitucion,FILTER_SANITIZE_NUMBER_INT));
        $ciudad = limpiarCadena(filter_var($ciudad,FILTER_SANITIZE_NUMBER_INT));
        $codigoestado = limpiarCadena(filter_var($codigoestado,FILTER_SANITIZE_NUMBER_INT));
        $cargorepresentantelegal = limpiarCadena(filter_var($cargorepresentantelegal,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $nombresupervisor = limpiarCadena(filter_var($nombresupervisor,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $identificacionsupervisor = limpiarCadena(filter_var($identificacionsupervisor,FILTER_SANITIZE_NUMBER_INT));
        $telefonosupervisor = limpiarCadena(filter_var($telefonosupervisor,FILTER_SANITIZE_NUMBER_INT));
        $cargosupervisor = limpiarCadena(filter_var($cargosupervisor,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $emailsupervisor = filter_var($emailsupervisor,FILTER_SANITIZE_EMAIL);
        $nombresolicitantebosque = limpiarCadena(filter_var($nombresolicitantebosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $telefonosolicitantebosque = limpiarCadena(filter_var($telefonosolicitantebosque,FILTER_SANITIZE_NUMBER_INT));
        $cargosolicitantebosque = limpiarCadena(filter_var($cargosolicitantebosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $emailsolicitantebosque = filter_var($emailsolicitantebosque,FILTER_SANITIZE_EMAIL);
        $nombresupervisorbosque = limpiarCadena(filter_var($nombresupervisorbosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $telefonosupervisorbosque = limpiarCadena(filter_var($telefonosupervisorbosque,FILTER_SANITIZE_NUMBER_INT));
        $cargosupervisorbosque = limpiarCadena(filter_var($cargosupervisorbosque,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $emailsupervisorbosque = filter_var($emailsupervisorbosque,FILTER_SANITIZE_EMAIL);
        $vigencia = limpiarCadena(filter_var($vigencia,FILTER_SANITIZE_NUMBER_INT));
        $codigoinstitucion = limpiarCadena(filter_var($codigoinstitucion,FILTER_SANITIZE_NUMBER_INT));
          
        $sql1="SELECT count(NombreInstitucion) as numero FROM InstitucionConvenios  where  NombreInstitucion like '".$nombreInstitucion."'";
        if($Consulta=&$db->Execute($sql1)===true)
        {
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Consultar..';
            echo json_encode($a_vectt);
            exit;
        }
        $valores = $db->GetRow($sql1);
        if ($valores['numero']>0)
        {
            $descrip = 'La institución que esta intentando ingresar ya se encuentra registrada.';
        }else
        {
            $sql2="INSERT INTO InstitucionConvenios (NombreInstitucion, Nit, Direccion, Telefono, TelefonoDos, Email, RepresentanteLegal, 
    		IdentificacionRepresentante, CiudadId, idsiq_tipoinstitucion, UsuarioCreacion, 
    		FechaCreacion, CargoRepresentanteLegal, NombreSupervisor, TelefonoSupervisor, EmailSupervisor, 
    		NombreSolicitanteBosque,  TelefonoSolicitanteBosque, CargoSolicitanteBosque, EmailSolicitanteBosque, 
    		IdentificacionSupervisor, CargoSupervisor, NombreSupervisorBosque, TelefonoSupervisorBosque, CargoSupervisorBosque, 
    		EmailSupervisorBosque, FechaInicio, FechaFin, Vigencia, CodigoInstitucion,idsiq_estadoconvenio) VALUES ('".$nombreInstitucion."','".$nit."', 
    		'".$direccion."', '".$telefono."','".$telefonodos."', '".$emailinstitucion."','".$representantelegal."','".$identificacionrepresentante."', 
    		'".$ciudad."','".$tipoinstitucion."','".$user."','".$fechacreacion."','".$cargorepresentantelegal."','".$nombresupervisor."',
    		'".$telefonosupervisor."','".$emailsupervisor."','".$nombresolicitantebosque."','".$telefonosolicitantebosque."','".$cargosolicitantebosque."',
    		'".$emailsolicitantebosque."', '".$identificacionsupervisor."', '".$cargosupervisor."', '".$nombresupervisorbosque."','".$telefonosupervisorbosque."',
    		'".$cargosupervisorbosque."','".$emailsupervisorbosque."', '".$fechainicio."', '".$fechafinal."', '".$vigencia."', '".$codigoinstitucion."',1)";
            //echo $sql2; 
    		$agregar = $db->Execute($sql2);   
            $descrip = 'La institución fue agregada';
            //$descrip =  $sql2;
        }
    $a_vectt['val']			=true;
    $a_vectt['descrip']		=$descrip;
    echo json_encode($a_vectt);
    exit;
    }//if($_POST['Action_id']=='SaveData')        

?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" />
        <link rel="stylesheet" href="cssEmail/style.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Instituciones</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesInstituciones.js"></script>
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        
        
        	$(document).ready( function () {

        			
        		$("#fechainicio").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $("#fechafin").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
               $('#ui-datepicker-div').css('display','none');
           	
                         
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        	} );
        	/**************************************************************/
        </script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
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
    </head>
    <body> 
    <div id="container">
        <center><h1>NUEVA INSTITUCIÓN</h1></center>
        <form  id="institucion" action="../convenio/nuevaInstitucion.php" method="post" enctype="multipart/form-data" >
            <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre Institución:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="NombreInstitucion" value="<?php echo $nombreInstitucion ?>" size="50"  id="NombreInstitucion" class="required" onkeypress="return val_texto(event)" />
                    </td>
                    <td>Dirección Institución:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="Direccion" id="Direccion" value="<?php echo $direccion?>" size="50" class="required" onkeypress="return val_dirrecion(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>NIT</td>
                    <td>
                        <input type="text" name="Nit" id="Nit" value="<?php echo $nit?>" onkeypress="return val_numero(event)" />
                    </td>
                    <td>Email:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="Email" id="Email" value="<?php echo $emailinstitucion?>" size="50" class="required" onkeypress="return val_email(event)"/> 
                    </td>
                </tr>  
                <tr>
                    <td>Teléfono:</td>
                    <td>
                        <input type="number" name="Telefono" id="Telefono" onkeypress="return val_numero(event)" />
                    </td>
                    <td>Tipo Institución:<span style="color: red;">*</span></td>
                    <td>
                        <select id="tipoinstitucion" name="tipoinstitucion">
						<?php
                        $sqlciudades = "select idsiq_tipoinstitucion, nombretipoinstitucion from siq_tipoinstitucion";
                        $ciudades = $db->Execute($sqlciudades);
                        foreach($ciudades as $nombresciudades)
                        {
                        ?>
                          <option value="<?php echo $nombresciudades['idsiq_tipoinstitucion']?>"><?php echo $nombresciudades['nombretipoinstitucion']?></option>
                        <?php
                        }                        
                        ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                   <td>Ciudad:<span style="color: red;">*</span></td>
                        <td>
                        <select name="Ciudad" id="Ciudad" class="required">
                        <option value="0">Seleccione</option>
                        <?php
                        $sqlciudades = "select idciudad, nombreciudad from ciudad where codigoestado= '100' order by idciudad asc";
                        $ciudades = $db->Execute($sqlciudades);
                        foreach($ciudades as $nombresciudades)
                        {
                        ?>
                          <option value="<?php echo $nombresciudades['idciudad']?>"><?php echo $nombresciudades['nombreciudad']?></option>
                        <?php
                        }                        
                        ?>
                        </select>
                        </td>
                    <td>Estado:</td>
                    <td>
                        <select id="CodigoEstado" name="CodigoEstado" class="required" >
                            <option value="100" selected="selected">Activo</option>
                            <option value="200">Inactivo</option>         
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Fecha inicio:</td>
                    <td>
                        <input type="text" name="fechainicio" id="fechainicio" />
                    </td>
                    <td>Fecha final</td>
                    <td>
                        <input type="text" name="fechafin" id="fechafin" value=""/>
                    </td>
                </tr>
                <tr>
                    <td>Vigencia:</td>
                    <td>
                        <select id="vigencia" name="vigencia">
                        <?php
                            $sqlvigencia = "select nombreduracion, idsiq_duracionconvenio from siq_duracionconvenio";
                             $vigencia = $db->Execute($sqlvigencia);
                            foreach($vigencia as $numerosvigencia)
                            {
                            ?>
                              <option value="<?php echo $numerosvigencia['idsiq_duracionconvenio']?>"><?php echo $numerosvigencia['nombreduracion']?></option>
                            <?php
                            }                        
                        ?>
                        </select>
                    </td>
                    <td>Codigo Institucion:</td>
                    <td>
                        <input type="text" name="codigoinstitucion" id="codigoinstitucion" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan='4'><center><h2>INSTITUCIÓN</h2></center></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <th colspan='4'>Representante</th>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>
                        <input type="text" name="RepresentanteLegal" id="RepresentanteLegal" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Identificación</td>
                    <td>
                        <input type="text" name="IdentificaciónRepresentante" id="IdentificaciónRepresentante" onkeypress="return val_numero(event)"/>
                    </td>
                    
                </tr>
                <tr>
                    <td>Cargo</td> 
                    <td>
                        <input type="text" name="CargoRepresentanteLegal" id="CargoRepresentanteLegal" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Teléfono</td>
                    <td>
                        <input type="number" name="TelefonoDos" id="TelefonoDos" min="1000000" max="10000000000" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                <tr>
                    <th colspan='4'>Supervisor</th>
                </tr>
                <tr>    
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>
                        <input type="text" name="NombreSupervisor" id="NombreSupervisor" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Identificación</td> 
                    <td>
                        <input type="text" name="IdentificaciónSupervisor" id="IdentificaciónSupervisor" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>Cargo</td> 
                    <td>
                        <input type="text" name="CargoSupervisor" id="CargoSupervisor" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Email</td> 
                    <td>
                        <input type="text" name="EmailSupervisor" id="EmailSupervisor" size="50" onkeypress="return val_email(event)"/>
                    </td>
                </tr>
                <tr>                  
                    <td>Teléfono</td> 
                    <td>
                        <input type="number" name="TelefonoSupervisor" id="TelefonoSupervisor" min="1000000" max="10000000000" onkeypress="return val_numero(event)" />
                    </td>
                </tr>
               <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan='4'><center><h2>UNIVERSIDAD EL BOSQUE</h2></center></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                 <tr>
                       <th colspan="4">Solicitante</th>
                </tr>
                 <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>
                        <input type="text" name="nombresolicitantebosque" id="nombresolicitantebosque" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Teléfono</td>
                    <td>
                        <input type="number" name="telefonosolicitantebosque" id="telefonosolicitantebosque" min="1000000" max="10000000000" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>
                <tr>
                    <td>Cargo</td>
                    <td>
                        <input type="text" name="cargosolicitantebosque" id="cargosolicitantebosque"  size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Email</td>
                    <td>
                        <div class="input_container">
                        <input type="text" name="emailsolicitantebosque" id="emailsolicitantebosque" size="50" onkeyup="autocomplet(5656)"  onkeypress="return val_email(event)"/>
                        <ul id="listemailsolicitantebosque" style="cursor: pointer;"></ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                 <tr>
                       <th colspan="4">Supervisor</th>
                </tr>
                 <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>
                        <input type="text" name="nombresupervisorbosque" id="nombresupervisorbosque" size="50" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Teléfono</td>
                    <td>
                        <input type="number" name="telefonosupervisorbosque" id="telefonosupervisorbosque" min="1000000" max="10000000000" onkeypress="return val_numero(event)"/>
                    </td>
                    
                </tr>
                <tr>
                    <td>Cargo</td>
                    <td>
                        <input type="text" name="cargosupervisorbosque" id="cargosupervisorbosque"  size="50" onkeypress="return val_texto(event)" />
                    </td>
                    <td>Email</td>
                    <td>
                        <div class="input_container">
                        <input type="text" name="emailsupervisorbosque" id="emailsupervisorbosque" size="50" onkeyup="autocomplet(5657)" onkeypress="return val_email(event)"/>
                           <ul id="listemailsupervisorbosque" style="cursor: pointer;"></ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
            </table>
            <center>
                <table width="600" id="botones">
                <tr><td><input type="button" value="Guardar" onclick="validarDatos('#institucion');" /></td>
                <td align='right'><input type="button" value="Regresar" onclick="RegresarConvenio()" /></td></tr>
             </table>
            </center>  
        </form>
    </div>
  </body>
</html>
<script>

function autocomplet(id) {
    if(id === 5656){
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#emailsolicitantebosque').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'nuevaInstitucion.php',
			type: 'POST',
			data: {keyword:keyword,id:id},
			success:function(data){
				$('#listemailsolicitantebosque').show();
				$('#listemailsolicitantebosque').html(data);
			}
		});
	} else {
		$('#listemailsolicitantebosque').hide();
	}
    }
    if(id === 5657){
        var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#emailsupervisorbosque').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'nuevaInstitucion.php',
			type: 'POST',
			data: {keyword:keyword,id:id},
			success:function(data){
				$('#listemailsupervisorbosque').show();
				$('#listemailsupervisorbosque').html(data);
			}
		});
	} else {
		$('#listemailsupervisorbosque').hide();
	}
    }
}
 
// set_item : this function will be executed when we select an item
function set_item(item,id) {
    
    if(id===5656){
        // change input value
	$('#emailsolicitantebosque').val(item);
	// hide proposition list
	$('#listemailsolicitantebosque').hide();
    }
    if(id===5657){
        $('#emailsupervisorbosque').val(item);
	// hide proposition list
	$('#listemailsupervisorbosque').hide();
    }
}
</script>
    
      