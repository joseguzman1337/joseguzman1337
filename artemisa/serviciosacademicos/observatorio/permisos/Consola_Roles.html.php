<?php
include("../templates/templateObservatorio.php");
include("../interfaz/funcionesPermisos.php");
$db = writeHeader('Consola de Permisos', true, "Permisos", 1);
$funciones = new ObservatorioPermisos();
?>
<style>
    fieldset{
        border:1px solid #C0C0C0;
    }
    .CargarButon{
        background:-moz-linear-gradient(#fc0 0%,#F60 100%);
        background:-ms-linear-gradient(#fc0 0%,#F60 100%);
        background:-o-linear-gradient(#fc0 0%,#F60 100%);
        background:-webkit-linear-gradient(#fc0 0%,#F60 100%);
        background:linear-gradient(#fc0 0%,#F60 100%);
        border:solid 1px #DEDEDE;
        border-radius:5px;
        text-align:center;
        padding:5px;
        color:#fff;
        width:150px;
    }
    .CargarButon:hover{
        background:-moz-linear-gradient(#fff 0%,#DEDEDE 100%);
        color:#999;
    }

</style>
<script src="../js/functionsRolPermiso.js"></script>      
<link type="text/css" href="../css/styless.css" rel="stylesheet" />
<div id="container">
<div id="delete-ok" style="display:none;">&nbsp;</div>
    <fieldset>
        <legend>Consola De Permisos Observatorio</legend>
        <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
            <thead>
                <tr>
                    <th>
                        <strong>Digite nombre del Rol</strong>
                    </th>
                </tr>
				<tr>
                    <th>
						<input type="text" id="RolData" name="RolData" size="75" autocomplete="off" style="text-align: center;" placeholder="Digite Nombre de Rol"/>
						<input type="hidden" id="id_Usuario" name="id_Usuario" />
					</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>
						<input type="hidden" id="PermisosCargados" name="PermisosCargados" />
						<fieldset style="width:90%;margin: 1em auto;">
							<strong>Seleccione modulo </strong>
							<select id="dataModulos" name="dataModulos" >
								<option value=""></option>
								<?php
								$funObs = $funciones->dataModulos($db);
								foreach ($funObs as $dataModulos){
									?>
									<option value="<?php echo $dataModulos['id_categoriamodulo']; ?>"><?php echo $dataModulos['categoria']; ?></option>
								<?php } ?>
							</select>
							<legend>Permisos Modulo</legend>
							<div id="DIV_DataPermisos">
								<br />
								<span style="color: silver;text-align: center;">No hay Informaci&oacute;n...</span>
								<br />
							</div>
							
							<legend>Permisos Actuales</legend>
							<br>
							<div id="DIV_DataActuales">
								<br />
								<span style="color: silver;text-align: center;">No hay Informaci&oacute;n...</span>
								<br />
							</div>
						</fieldset>
					</th>
				</tr>
            <tr>
                <td style="text-align: right;" colspan="3">
                    <input type="button" value="Adicionar Rol" id="adicionar" name="adicionar" class="CargarButon"  title="Adicionar Rol" />
                </td>
            </tr>
            
            </tbody>
        </table>
    </fieldset>
</div>  