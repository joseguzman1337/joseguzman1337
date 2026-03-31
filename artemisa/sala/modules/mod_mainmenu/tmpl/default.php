<?php 
// No direct access
defined('_JEXEC') or die; ?>

<nav id="mainnav-container">
	<div id="mainnav">
		<!--Shortcut buttons-->
		<!--  -->
		<div id="mainnav-shortcut">
			<ul class="list-unstyled">
				<li class="col-xs-4" data-content="Preguntas Frecuentes" data-original-title="" title="">
					<a id="demo-toggle-aside" rel="iframe" class="menuItem shortcut-grid" href="<?php echo str_replace('sala', 'serviciosacademicos', $uriBase); ?>consulta/facultades/centralPreguntasFrecuentes.htm">
						<i class="fa fa-question-circle"></i>
					</a>
				</li>
				<li class="col-xs-4" data-content="Correo Institucional" data-original-title="" title="">
					<a id="demo-alert" rel="" class="shortcut-grid" href="https://mail.google.com/a/unbosque.edu.co" target="_blank">
						<i class="fa fa-envelope"></i>
					</a>
				</li>
				<li class="col-xs-4" data-content="Page Alerts" data-original-title="" title="">
					<a id="demo-page-alert" rel="" class="menuItem shortcut-grid" href="#">
						<i class="fa fa-bell"></i>
					</a>
				</li>
			</ul>
		</div>
		<!--End shortcut buttons-->


		<!--Menu-->
		<!--================================-->
		<div id="mainnav-menu-wrap"> 
			<div class="search">
				<div class="nano-content" tabindex="0" style="right: -17px;">
					<ul id="search-menu" class="list-group"> 
						<!--Category name-->
						<li class="list-header">
							<div class="input-group  bg-white">
								<span class="input-group-addon"><i class="fa fa-search fa-lg"></i></span>
								<input class="form-control" id="txt_buscador" placeholder="Búsqueda" type="text" >
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="nano has-scrollbar">
				<div class="nano-content" tabindex="0" style="right: -17px;">
					<ul id="mainnav-menu" class="list-group"> 
			
						<!--Menu list item--> 
						<li class="active-link">
							<a href="<?php echo $uriBase; ?>" rel="" class="menuItem">
								<i class="fa fa-home"></i>
								<span class="menu-title">
									<strong>INICIO</strong> 
								</span>
							</a>
						</li> 
						<?php
						foreach($menu as $m){
							$li = modMainMenuHelper::printMenuItem( $m );
							echo $li;
							//d($m);
						}//exit;
						?>
			
						<li class="list-divider"></li>
						<li>
							<a class="menuItem" rel="" href="<?php echo $uriBase; ?>?option=com_planDeDesarrollo">
								<i class="fa fa-dashboard"></i>
								<span class="menu-title">
									<strong>Plan de Desarrollo TEST</strong>
								</span>
							</a>
						</li>
						<li>
							<a class="menuItem" rel="iframe" href="http://localhost/desarrollo/proyecto/serviciosacademicos/PlanDesarrollo/interfaz/home.php">
								<i class="fa fa-dashboard"></i>
								<span class="menu-title">
									<strong>Plan de Desarrollo Iframe</strong>
								</span>
							</a>
						</li>
						<li class="list-divider"></li>
			
					</ul>


					<!--Widget-->
					<!--================================-->
					<div class="mainnav-widget">

						<!-- Show the button on collapsed navigation -->
						<div class="show-small">
							<a href="#" data-toggle="menu-widget" data-target="#demo-wg-server">
								<i class="fa fa-desktop"></i>
							</a>
						</div>

						<!-- Hide the content on collapsed navigation -->
						<div id="demo-wg-server" class="hide-small mainnav-widget-content">
							<ul class="list-group">
								<li class="list-header pad-no pad-ver">Server Status</li>
								<li class="mar-btm">
									<span class="label label-primary pull-right">15%</span>
									<p>CPU Usage</p>
									<div class="progress progress-sm">
										<div class="progress-bar progress-bar-primary" style="width: 15%;">
											<span class="sr-only">15%</span>
										</div>
									</div>
								</li>
								<li class="mar-btm">
									<span class="label label-purple pull-right">75%</span>
									<p>Bandwidth</p>
									<div class="progress progress-sm">
										<div class="progress-bar progress-bar-purple" style="width: 75%;">
											<span class="sr-only">75%</span>
										</div>
									</div>
								</li>
								<li class="pad-ver"><a href="#" class="btn btn-success btn-bock">View Details</a></li>
							</ul>
						</div>
					</div>
					<!--================================-->
					<!--End widget-->

				</div>
			<div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 20px;"></div></div></div>
		</div>
		<!--================================-->
		<!--End menu-->

	</div>
</nav>
