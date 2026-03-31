		<div class="table-responsive">
			<table class="table table-bordered table-striped table-line-ColorBrand-headers">
				<theader>
					<tr>
						<th class="col-lg-1 col-md-3 col-sm-3 col-xs-3">
							Relación Usuario
						</th>
						<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							Usuario
						</th>
						<th class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
							Componente
						</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							Habilitar Permisos
						</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							Ver
						</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							Editar
						</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							Insertar
						</th>
						<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							Eliminar
						</th>
					</tr>
				</theader>
				<tbody>
					<?php
					foreach($usuariosTabla as $ut){
                                            //ddd($ut);
						?>
					<tr>
                                                <td><?php echo $ut->user->getNombreRelacionUsuario();?></td>
						<td><?php echo $ut->user->getUser();?></td>
						<td><?php echo $ut->nombreMenuOpcion;?></td>
						<td>
                                                    <?php
                                                    echo $ControlComponentes->habilitarPermisos($ut->user->getRelacionUsuario(), $ut->user->getIduser(),$ut->idComponent, $_GET['option']);
                                                    ?>
						</td>
						<td>
                                                    <?php
                                                    echo $ControlComponentes->checkPermisos($ut->user->getRelacionUsuario(), $ut->user->getIduser(),$ut->idComponent, $_GET['option'], "ver");
                                                    ?>
						</td>
						<td>
                                                    <?php
                                                    echo $ControlComponentes->checkPermisos($ut->user->getRelacionUsuario(), $ut->user->getIduser(),$ut->idComponent, $_GET['option'], "editar");
                                                    ?>
						</td>
						<td>
                                                    <?php
                                                    echo $ControlComponentes->checkPermisos($ut->user->getRelacionUsuario(), $ut->user->getIduser(),$ut->idComponent, $_GET['option'], "insertar");
                                                    ?>
						</td>
						<td>
                                                    <?php
                                                    echo $ControlComponentes->checkPermisos($ut->user->getRelacionUsuario(), $ut->user->getIduser(),$ut->idComponent, $_GET['option'], "eliminar");
                                                    ?>
						</td>
					</tr>
						<?php
					} 
					?> 
				</tbody>
			</table>
		</div>
		<?php 
		echo  $pagination->paginate();echo $pagination->display_pages();
		?>