<?php
	 /**
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package templates
 */
//d($metaSecundaria);


?> 



<style type="text/css">
	.form-control{
		width: 100% !important;
		margin: 0px !important;
	}
</style>

<script src="../js/MainActualizar.js"></script>
     <script>
        $(document).ready(function (){
          $('.soloNumeros').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });

        
        
    </script>

<form id="formActualizar">
	<fieldset>
		<legend>Meta Anual</legend> 
		<div class="actualizarMeta">
			<div class="form-group">
				<div class="col-xs-12 col-md-3">
					<label for="txtActualizaMeta">Meta:</label>
				</div>
				<div class="col-xs-12 col-md-8">
					<input type="text" class="form-control" id="txtActualizaMeta" name="txtActualizaMeta" value="<?php echo $metaSecundaria->getNombreMetaSecundaria(); ?>" />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
				<div class="col-xs-3 col-md-3">
					<label for="txtFechaActualizaInicioMeta">Fecha Inicio:</label>
				</div>
				<div class="col-xs-9 col-md-3">
					<!--id="txtFechaActualizaInicioMeta"-->
					<input type="text"  class="form-control" id="txtFechaActualizaInicioMeta"  name="txtFechaActualizaInicioMeta" value="<?php echo date("Y-m-d", strtotime($metaSecundaria->getFechaInicioMetaSecundaria())); ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="txtFechaActualizaInicioMeta">Fecha Final:</label>
				</div>
				<div class="col-xs-9 col-md-3">
					<!--id="txtFechaActualizaFinalMeta"-->
					<input type="text" class="form-control"  id="txtFechaActualizaFinalMeta"  name="txtFechaActualizaFinalMeta" value="<?php echo date("Y-m-d", strtotime($metaSecundaria->getFechaFinMetaSecundaria())); ?>" />
				</div>
				<div class="clearfix"></div>
			</div> 
			<div class="form-group">
				<div class="col-xs-12 col-md-3">
					<label for="txtActualizaValorMeta">Avance Esperado:</label>
				</div>
				<div class="col-xs-12 col-md-6">
					<input type="text"  id="txtActualizaValorMeta" name="txtActualizaValorMeta" class="soloNumeros"  value="<?php echo $metaSecundaria->getValorMetaSecundaria(); ?>" />
                                </div>
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-md-3">
					<label for="txtActualizaValorMeta">Acciones:</label>
				</div>
				<div class="col-xs-12 col-md-9">
					<textarea class="form-control" id="txtActualizaAccionMeta" name="txtActualizaAccionMeta" rows="3"><?php echo $metaSecundaria->getActividadMetaSecundaria( ); ?></textarea>
				</div>
				<div class="clearfix"></div>
			</div>
			
			<div class="ui-widget">		
				
				<div class="form-group">
					<div class="col-xs-12 col-md-3">
						<label for="txtActualizaValorMeta">Responsable:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input type="text" class="form-control" id="txtActualizaResponsableMeta" name="txtActualizaResponsableMeta" value="<?php echo $metaSecundaria->getResponsableMetaSecundaria(); ?>" />
					</div>
					<div class="clearfix"></div>
				 </div>
				 
				 <div class="form-group">
					<div class="col-xs-12 col-md-3">
						<label for="txtemail">Email:</label>
					</div>
				
					<div class="col-xs-12 col-md-9">
						<input type="text" class="form-control" id="txtEmail" name="txtEmail" value="<?php echo $metaSecundaria->getEmailResponsableMetaSecundaria(); ?>" />
                                                <strong>"Para múltiples responsables,separar los correos con coma"</strong>
					</div>
                                     
					<div class="clearfix"></div>
				 </div>
				
			
		</div>
			
		</div>
	</fieldset>
	<p>
		<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="actualizar" />
		<input type="hidden" id="txtIdMetaSecundaria" name="txtIdMetaSecundaria" value="<?php echo $txtIdMetaSecundaria; ?>" />
		<input type="hidden" id="txtIdMetaPrincipal" name="txtIdMetaPrincipal" value="<?php echo $txtIdMetaPrincipal; ?>" />
		<input type="hidden" id="txtIdPrograma" name="txtIdPrograma" value="<?php echo $txtIdPrograma; ?>" />
		<input type="hidden" id="txtIdProyecto" name="txtIdProyecto" value="<?php echo $txtIdProyecto; ?>" />
                <input type="hidden" id="txtValorAvances" name="txtValorAvances" value="<?php echo $valorAvances-$metaSecundaria->getValorMetaSecundaria(); ?>" />
                <input type="hidden" id="txtValorAvancesAct" name="txtValorAvancesAct" value="<?php echo $valorAvances-$metaSecundaria->getValorMetaSecundaria(); ?>" />
                <input type="hidden" id="txtAlcanceMeta" name="txtAlcanceMeta" value="<?php echo $alcanceMeta; ?>" />
        </p> 
</form>
<br /> 
<div>
    <?php
        /*
         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
         * Se agrega validacion de insertar a nivel de componente, esta medida es temporal mientras se define como se va a trabajar 
         * con los modulos y donde se van a registar
         * @since  marzo 21, 2017
        */
        if($permisoEditar){
        	
    ?>
	<button id="btnActualizarMetaSec" class="btn btn-warning"  >Guardar</button>
    <?php        
        }
        /* FIN MODIFICACION */
    ?>
	<button id="btnCancelarActualizarMetaSec" class="btn btn-warning"  >Cancelar</button>
</div>
<div id="mensageActualizar" class="mensageRegistrar"><div>¿Desea Actualizar el Plan de Desarrollo?</div></div>