
<?php 
//d($variables);
require_once(dirname(dirname(__FILE__)).'/control/ControlComponentes.php');
$controlRender = new ControlRender( ROOT );
//d($relacionUsuarios);
//d($variables );
?>
<h1>Administrar Permisos de <?php echo $componenteList[0]->__get("nombremenuopcion"); ?></h1>
<div class="clearfix"></div>
<div class="panel panel-default">
	<div class="panel-heading buscador">
		<div class="row no-margin">Filtrar por</div>
		<div class="row no-margin">
                    <input type="hidden" name="page" id="page" value="<?php echo $variables->page; ?>" />
                    <input type="hidden" name="ipp" id="ipp" value="<?php echo $variables->ipp; ?>" />
                    <input type="hidden" name="idComponente" id="idComponente" value="<?php echo $variables->idComponente; ?>" />
			<div class="col-md-4">
				<label for="RelacionUsuario" class="inline-block-middle col-md-4">Relacion Usuario:</label>
				<div class="inline-block-middle col-md-7" id="selectRelacionUsuario">
					<select name="RelacionUsuario" id="RelacionUsuario" class="chosen-select " >
						<option value="">Seleccionar</option>
						<?php 
						foreach($relacionUsuarios as $ru){
                                                    $selected = "";
                                                    if($variables->RelacionUsuario == $ru->__get("id") ){
                                                        $selected = " selected ";
                                                    }
							?>
							<option value="<?php echo $ru->__get("id"); ?>" <?php echo $selected;?> ><?php echo $ru->__get("nombre"); ?></option>
							<?php
						}
						?>
					</select> 
				</div>
			</div>
			<div class="col-md-4">
				<label for="Usuario" class="inline-block-middle col-md-4">Usuario: </label>
				<div class="inline-block-middle col-md-7" id="selectUsuario">
					<select name="Usuario" id="Usuario" class="chosen-select" >
						<option value="-1">Seleccionar</option>
					</select> 
				</div>
			</div> 
		
		</div> 
	</div>
	<div class="panel-body" id="contenedorTabla">
        <?php
                $array= array(
                        "usuariosTabla"=>$usuariosTabla,
                        "pagination" => $pagination, 
                        "variables" => $variables,
                        "ControlComponentes" => $ControlComponentes
                        );
                $controlRender->render('tablaComponentes',$array);
	?>
	</div>
</div>