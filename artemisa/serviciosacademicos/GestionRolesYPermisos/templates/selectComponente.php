
<?php 
//d($variables);
require_once(dirname(dirname(__FILE__)).'/control/ControlComponentes.php');
$controlRender = new ControlRender( ROOT );
//d($relacionUsuarios);
//d($componenteList );
?>
<h1>Administrar Permisos de Componentes</h1>
<div class="clearfix"></div>
<div class="panel panel-default">
	<div class="panel-heading buscador">
		<div class="row no-margin">Filtrar por</div>  
	</div>
	<div class="panel-body" id="contenedorTabla">
            <form id="selectComponent" name="selectComponent" action="index.php" method="get" >
                <input type="hidden" name="option" id="option" value="componentes" />
                <?php if(!empty($variables->idRelacionUsuario)){
                ?>
                <input type="hidden" name="RelacionUsuario" id="option" value="<?php echo $variables->idRelacionUsuario;?>" />
                <?php
                }?>
                <label for="Componente" class="inline-block-middle col-md-4">Componente: </label>
                <div class="inline-block-middle col-md-7" id="selectComponente">
                    <select name="idComponente" id="idComponente" class="chosen-select"  >
                            <option value="">Seleccionar</option>
                            <?php 
                            foreach($componenteList as $cp){
                                $selected = "";
                                if($variables->idComponente == $cp->__get("idmenuopcion")){
                                    $selected = " selected ";
                                }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $cp->__get("idmenuopcion"); ?>"><?php echo $cp->__get("nombremenuopcion"); ?></option>
                                    <?php
                            }
                            ?>
                    </select> 
                </div>
            </form>
	</div>
</div>