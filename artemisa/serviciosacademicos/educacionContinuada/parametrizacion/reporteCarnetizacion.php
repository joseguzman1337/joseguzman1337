<?php

    session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Administrar Casos Especiales Carnetización",TRUE);

    include("./menu.php");
    writeMenu(4);
    $utils = Utils::getInstance();
	$user = $utils->getUser();
if($admin=$utils->esAdministrador($db,$user["usuario"])) {
	
	$usuariosAdmin = $utils->getUsuariosAdministradores($db);
	//$usuariosFuncionarios = $utils->getUsuariosFuncionarios($db);
	
?> 
<head> 
<link type="text/css" href="css/styless.css" rel="stylesheet" />
<script src="../js/functionsAdmin.js"></script>      
</head>
<body>
<div id="delete-ok" style="display:none;">&nbsp;</div>
    <div id="contenido">
        <div id="form"> 
			<div id="msg-error"><?php echo $_REQUEST["mensaje"]; ?></div>
    
				<form action="" method="post" id="form_test" style="margin-top:100px;"  >
				<input type="hidden" id="admin" value="<?php echo $admin; ?>" />
						<fieldset>   
							<legend>Administrar Casos Especiales Carnetización</legend>  
							<p><input type="submit" id="crearEstudiante" name="crearEstudiante" value="crearEstudiante" /></p>
							<div id="idData"></div>
						</fieldset>
				</form>
				<div id="popup" style="display: none;">
								<div class="content-popup">
									<div class="close"><a href="#" id="close"><img src="images/close.png"/></a></div>
									<div>
									   <h2>Crear Estudiante</h2>
									   Documento : <input type="text" id="documento" name="documento" autocomplete="off"/> <input type="submit" id="consultarEstudiante" name="consultarEstudiante" value="Consultar" />
									   <div id="idDataEstudiante"></div>
									   <input type='submit' id='insertEstudiante' name='insertEstudiante' value='Guardar'/>
									   <div id="vacio" name="vacion"><p><b>No existe información relacionada</b></p></div>
									   <div id="correcto" name="correcto"><p><b>La información Se Guardo Correctamente</b></p></div>
									</div>
								</div>
							</div>
		</div>
	</div>

</body>	
<?php } else {
	echo "No tiene permisos para acceder a esta página.";
} writeFooter(); ?>
