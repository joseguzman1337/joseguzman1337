<div class="row">
    <?php if(empty($relacionUsuario)){?>
	<div class="col-md-4 col-sm-4 pad-all-5">
		<a href="?RelacionUsuario=1">
			<div class="contenedorColorBrand menuPrincipal" >
				<div class="contenedorColorBrandDark45 iconoMenu pad-all-5">
					<i class="fa fa-users fa-3x" aria-hidden="true"></i>
				</div>
				<div class="textMenu">Administra Permisos a Nivel de Tipo Usuario</div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
	<div class="col-md-4 col-sm-4 pad-all-5">
		<a href="?RelacionUsuario=2">
			<div class="contenedorColorBrand menuPrincipal" >
				<div class="contenedorColorBrandDark45 iconoMenu pad-all-5">
					<i class="fa fa-id-card fa-2x" aria-hidden="true"></i>
				</div>
				<div class="textMenu">Administra Permisos a Nivel de Tipo Rol</div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
	<div class="col-md-4 col-sm-4 pad-all-5">
		<a href="?RelacionUsuario=1">
			<div class="contenedorColorBrand menuPrincipal" >
				<div class="contenedorColorBrandDark45 iconoMenu pad-all-5">
					<i class="fa fa-user fa-3x" aria-hidden="true"></i>
				</div>
				<div class="textMenu">Administra Permisos a Nivel de Usuario </div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
    <?php }else{?>
	<div class="col-md-4 col-sm-4 pad-all-5">
		<a href="?idRelacionUsuario=<?php echo $relacionUsuario;?>&option=sistema">
			<div class="contenedorColorBrand menuPrincipal" >
				<div class="contenedorColorBrandDark45 iconoMenu pad-all-5">
					<i class="fa fa-globe fa-3x" aria-hidden="true"></i>
				</div>
				<div class="textMenu">Permisos de Sistema</div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
	<div class="col-md-4 col-sm-4 pad-all-5">
		<a href="?idRelacionUsuario=<?php echo $relacionUsuario;?>&option=componentes">
			<div class="contenedorColorBrand menuPrincipal" >
				<div class="contenedorColorBrandDark45 iconoMenu pad-all-5">
					<i class="fa fa-thumb-tack fa-3x" aria-hidden="true"></i>
				</div>
				<div class="textMenu">Permisos de Componente</div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div> 
    <?php } ?>
</div>