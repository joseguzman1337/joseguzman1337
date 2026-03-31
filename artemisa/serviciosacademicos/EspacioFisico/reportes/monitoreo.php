<?php
	session_start();
	include_once ('../templates/template.php');
	$db = getBD();
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>'.$SQL_User;
		die;
	}

	$usuario=$Usario_id->fields['id'];
	$SQL = 'SELECT * FROM ClasificacionEspacios WHERE ClasificacionEspacionPadreId IN (4, 5) AND codigoestado = 100';
	if($Bloque=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos'.$SQL ;
		die;    
	}
?>
<html>
    <head>
        <title>Monitoreo de aulas</title>
		<script type="text/javascript" charset="utf-8" src="../js/jquery-1.13.1.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/function.js?3"></script>
		<link rel="stylesheet" href="../css/monitoreo.css" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="logo"></div>
				<?PHP include_once('../relojdigital/reloj.php')?>
				<div class="bloque">
					Bloque: <select id="bloque">
					<option value="0">Seleccione...</option>
					<?php
                        if(!$Bloque->EOF){
							while(!$Bloque->EOF){
								echo '<option value="'.$Bloque->fields['ClasificacionEspaciosId'].'">'.$Bloque->fields['Nombre'].'</option>';
                                $Bloque->MoveNext();
                            }
						}                                                        
                    ?>
					</select>
				</div>
				<div class="aula">Aula: <select id="aula" disabled="disabled"><option>Seleccione un bloque</option></select></div>
			</div>				
			<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
			<div class="content" id="content">
				
			</div>			
		</div>
	</body>
</html>