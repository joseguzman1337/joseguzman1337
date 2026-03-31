<?php 
defined('_JEXEC') or die;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gestión académica en línea - SALA</title>

	<?php
		$uriBase=JURI::base();
		$base=dirname(__FILE__);
		jimport('includes.header', $base); 
		printHeaders($uriBase);
	?>
</head>
<body> 
	<div class="pace  pace-inactive">
		<div class="pace-progress" style="width: 100%;" data-progress-text="100%" data-progress="99">
			<div class="pace-progress-inner"></div>
		</div>
		<div class="pace-activity"></div>
	</div>
	<div id="container" class="effect mainnav-lg">
		
		<!--NAVBAR-->
		<!--===================================================-->
		<header id="navbar" class="">
			<div id="navbar-container" class="boxed">

				<!--Brand logo & name-->
				<!--================================-->
				<div class="navbar-header">
					<a href="<?php echo $uriBase; ?>" class="navbar-brand">
						<img src="<?php echo $uriBase; ?>templates/sala/images/logo.png" alt="Logo" class="brand-icon">
						<div class="brand-title">
							<span class="brand-text"><img src="<?php echo $uriBase; ?>templates/sala/images/logoPequeno.png" alt="btheme Logo" class="brand-icon"></span>
						</div>
					</a>
				</div>
				<!--================================-->
				<!--End brand logo & name-->


				<!--Navbar Dropdown-->
				<!--================================-->
				<div class="navbar-content clearfix">
					<ul class="nav navbar-top-links pull-left">

						<!--Navigation toogle button-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li class="tgl-menu-btn">
							<a class="mainnav-toggle" href="#">
								<i class="fa fa-navicon fa-lg"></i>
							</a>
						</li>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End Navigation toogle button-->

					</ul>
					<div class="brand-title brand-title100 col-xs-8 col-sm-8 col-md-8 col-lg-8">
						<span class="brand-text col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="hidden-xs hidden-sm visible-md-inline visible-lg-inline">Sistema de gestión académica en línea </div>SALA
						</span>
					</div>
					<ul class="nav navbar-top-links pull-right">
						<jdoc:include type="modules" name="loginsala" style="none" />

					</ul>
				</div>
				<!--================================-->
				<!--End Navbar Dropdown-->

			</div>
		</header>
		<!--===================================================-->
		<!--END NAVBAR-->

		<div class="boxed">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<!--Page Title-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--<div id="page-title">
					<h1 class="page-header text-overflow">Dashboard</h1>

					< !--Searchbox-- >
					<div class="searchbox">
						<div class="input-group custom-search-form">
							<input class="form-control" placeholder="Search.." type="text">
							<span class="input-group-btn">
								<button class="text-muted" type="button"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</div>
				</div>-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End page title-->


				<!--Breadcrumb-->
				<!-- 
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Library</a></li>
					<li class="active">Data</li>
				</ol> -->
				<!--End breadcrumb-->


		

				<!--Page content-->
				<!--===================================================-->
				<div id="page-content">
					<jdoc:include type="component" />
					<?php //echo $content; ?>
				</div>
				<!--===================================================-->
				<!--End page content-->


			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->


			
			<!--MAIN NAVIGATION-->
			<!--===================================================-->
			<jdoc:include type="modules" name="main-menu" style="none" />
			<?php 
				// $module = JModuleHelper::getModule( 'mainmenu', 'Main Menu' );
				// $menu = JModuleHelper::renderModule( $module ); 
				//echo $menu;
			/*/ ?>
			<nav id="mainnav-container">
				<div id="mainnav">

					<!--Shortcut buttons-->
					<!--================================-->
					<div id="mainnav-shortcut">
						<ul class="list-unstyled">
							<li class="col-xs-4" data-content="Additional Sidebar" data-original-title="" title="">
								<a id="demo-toggle-aside" class="shortcut-grid" href="#">
									<i class="fa fa-magic"></i>
								</a>
							</li>
							<li class="col-xs-4" data-content="Notification" data-original-title="" title="">
								<a id="demo-alert" class="shortcut-grid" href="#">
									<i class="fa fa-bullhorn"></i>
								</a>
							</li>
							<li class="col-xs-4" data-content="Page Alerts" data-original-title="" title="">
								<a id="demo-page-alert" class="shortcut-grid" href="#">
									<i class="fa fa-bell"></i>
								</a>
							</li>
						</ul>
					</div>
					<!--================================-->
					<!--End shortcut buttons-->


					<!--Menu-->
					<!--================================-->
					<div id="mainnav-menu-wrap">
						<div class="nano has-scrollbar">
							<div class="nano-content" tabindex="0" style="right: -17px;">
								<ul id="mainnav-menu" class="list-group">
						
									<!--Category name-->
									<li class="list-header">Navigation</li>
									<!--Menu list item-->
									<li class="active">
										<a href="#">
											<i class="fa fa-th"></i>
											<span class="menu-title">
												<strong>Servicios Academicos</strong>
											</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse in" aria-expanded="true" style="">
											<li><a href="<?php echo $uriBase; ?>?option=com_planDeDesarrollo">Plan De Desarrollo</a></li>  
										</ul>
									</li>
									
									<!--Menu list item-->
									<li>
										<a href="index.html">
											<i class="fa fa-dashboard"></i>
											<span class="menu-title">
												<strong>Dashboard</strong>
												<span class="label label-success pull-right">Top</span>
											</span>
										</a>
									</li>
						
									<!--Menu list item-->
									<li >
										<a href="#">
											<i class="fa fa-th"></i>
											<span class="menu-title">
												<strong>Layouts</strong>
											</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse in" aria-expanded="true" style="">
											<li><a href="layouts-collapsed-navigation.html">Collapsed Navigation</a></li>
											<li><a href="layouts-offcanvas-navigation.html">Off-Canvas Navigation</a></li>
											<li><a href="layouts-offcanvas-slide-in-navigation.html">Slide-in Navigation</a></li>
											<li><a href="layouts-offcanvas-revealing-navigation.html">Revealing Navigation</a></li>
											<li class="list-divider"></li>
											<li><a href="layouts-aside-right-side.html">Aside on the right side</a></li>
											<li><a href="layouts-aside-left-side.html">Aside on the left side</a></li>
											<li><a href="layouts-aside-bright-theme.html">Bright aside theme</a></li>
											<li class="list-divider"></li>
											<li><a href="layouts-fixed-navbar.html">Fixed Navbar</a></li>
											<li><a href="layouts-fixed-footer.html">Fixed Footer</a></li>
											
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="widgets.html">
											<i class="fa fa-flask"></i>
											<span class="menu-title">
												<strong>Widgets</strong>
												<span class="pull-right badge badge-warning">9</span>
											</span>
										</a>
									</li>
						
									<li class="list-divider"></li>
						
									<!--Category name-->
									<li class="list-header">Components</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-briefcase"></i>
											<span class="menu-title">UI Elements</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse">
											<li><a href="ui-buttons.html">Buttons</a></li>
											<li><a href="ui-checkboxes-radio.html">Checkboxes &amp; Radio</a></li>
											<li><a href="ui-panels.html">Panels</a></li>
											<li><a href="ui-modals.html">Modals</a></li>
											<li><a href="ui-progress-bars.html">Progress bars</a></li>
											<li><a href="ui-components.html">Components</a></li>
											<li><a href="ui-typography.html">Typography</a></li>
											<li><a href="ui-list-group.html">List Group</a></li>
											<li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a></li>
											<li><a href="ui-alerts-tooltips.html">Alerts &amp; Tooltips</a></li>
											<li><a href="ui-helper-classes.html">Helper Classes</a></li>
											
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-edit"></i>
											<span class="menu-title">Forms</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse">
											<li><a href="forms-general.html">General</a></li>
											<li><a href="forms-components.html">Components</a></li>
											<li><a href="forms-validation.html">Validation</a></li>
											<li><a href="forms-wizard.html">Wizard</a></li>
											
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">Tables</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse">
											<li><a href="tables-static.html">Static Tables</a></li>
											<li><a href="tables-bootstrap.html">Bootstrap Tables</a></li>
											<li><a href="tables-datatable.html">Data Tables<span class="label label-info pull-right">New</span></a></li>
											<li><a href="tables-footable.html">Foo Tables<span class="label label-info pull-right">New</span></a></li>
											
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="charts.html">
											<i class="fa fa-line-chart"></i>
											<span class="menu-title">Charts</span>
										</a>
									</li>
						
									<li class="list-divider"></li>
						
									<!--Category name-->
									<li class="list-header">Extra</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-plug"></i>
											<span class="menu-title">
												Miscellaneous
												<span class="label label-mint pull-right">New</span>
											</span>
										</a>
						
										<!--Submenu-->
										<ul class="collapse">
											<li><a href="misc-calendar.html">Calendar</a></li>
											<li><a href="misc-maps.html">Google Maps</a></li>
											
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-envelope"></i>
											<span class="menu-title">Email</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse">
											<li><a href="mailbox.html">Inbox</a></li>
											<li><a href="mailbox-message.html">View Message</a></li>
											<li><a href="mailbox-compose.html">Compose Message</a></li>
											
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-file"></i>
											<span class="menu-title">Pages</span>
											<i class="arrow"></i>
										</a>
						
										<!--Submenu-->
										<ul class="collapse">
											<li><a href="pages-blank.html">Blank Page</a></li>
											<li><a href="pages-profile.html">Profile</a></li>
											<li><a href="pages-search-results.html">Search Results</a></li>
											<li><a href="pages-timeline.html">Timeline<span class="label label-info pull-right">New</span></a></li>
											<li><a href="pages-faq.html">FAQ</a></li>
											<li class="list-divider"></li>
											<li><a href="pages-404.html">404 Error</a></li>
											<li><a href="pages-500.html">500 Error</a></li>
											<li class="list-divider"></li>
											<li><a href="pages-login.html">Login</a></li>
											<li><a href="pages-register.html">Register</a></li>
											<li><a href="pages-password-reminder.html">Password Reminder</a></li>
											<li><a href="pages-lock-screen.html">Lock Screen</a></li>
											
										</ul>
									</li>

									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-plus-square"></i>
											<span class="menu-title">Menu Level</span>
											<i class="arrow"></i>
										</a>

										<!--Submenu-->
										<ul class="collapse">
											<li><a href="#">Second Level Item</a></li>
											<li><a href="#">Second Level Item</a></li>
											<li><a href="#">Second Level Item</a></li>
											<li class="list-divider"></li>
											<li>
												<a href="#">Third Level<i class="arrow"></i></a>

												<!--Submenu-->
												<ul class="collapse">
													<li><a href="#">Third Level Item</a></li>
													<li><a href="#">Third Level Item</a></li>
													<li><a href="#">Third Level Item</a></li>
													<li><a href="#">Third Level Item</a></li>
												</ul>
											</li>
											<li>
												<a href="#">Third Level<i class="arrow"></i></a>

												<!--Submenu-->
												<ul class="collapse">
													<li><a href="#">Third Level Item</a></li>
													<li><a href="#">Third Level Item</a></li>
													<li><a href="#">Third Level Item</a></li>
													<li class="list-divider"></li>
													<li><a href="#">Third Level Item</a></li>
													<li><a href="#">Third Level Item</a></li>
												</ul>
											</li>
										</ul>
									</li>

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
			<?php /**/ ?>
			<!--===================================================-->
			<!--END MAIN NAVIGATION-->
			
			<!--ASIDE-->
			<!--===================================================-->
			<aside id="aside-container">
				<div id="aside">
					<div class="nano has-scrollbar">
						<div class="nano-content" tabindex="0" style="right: -17px;">
							
							<!--Nav tabs-->
							<!--================================-->
							<ul class="nav nav-tabs nav-justified">
								<li class="active">
									<a href="#demo-asd-tab-1" data-toggle="tab">
										<i class="fa fa-comments"></i>
										<span class="badge badge-purple">7</span>
									</a>
								</li>
								<li>
									<a href="#demo-asd-tab-2" data-toggle="tab">
										<i class="fa fa-info-circle"></i>
									</a>
								</li>
								<li>
									<a href="#demo-asd-tab-3" data-toggle="tab">
										<i class="fa fa-wrench"></i>
									</a>
								</li>
							</ul>
							<!--================================-->
							<!--End nav tabs-->



							<!-- Tabs Content -->
							<!--================================-->
							<div class="tab-content">

								<!--First tab (Contact list)-->
								<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
								<div class="tab-pane fade in active" id="demo-asd-tab-1">
									<h4 class="pad-hor text-thin">
										<span class="pull-right badge badge-warning">3</span> Family
									</h4>

									<!--Family-->
									<div class="list-group bg-trans">
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av2.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Stephen Tran</div>
												<span class="text-muted">Availabe</span>
											</div>
										</a>
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av4.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Brittany Meyer</div>
												<span class="text-muted">I think so</span>
											</div>
										</a>
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av3.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Donald Brown</div>
												<span class="text-muted">Lorem ipsum dolor sit amet.</span>
											</div>
										</a>
									</div>


									<hr>
									<h4 class="pad-hor text-thin">
										<span class="pull-right badge badge-info">4</span> Friends
									</h4>

									<!--Friends-->
									<div class="list-group bg-trans">
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av5.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Betty Murphy</div>
												<span class="text-muted">Bye</span>
											</div>
										</a>
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av6.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Olivia Spencer</div>
												<span class="text-muted">Thank you!</span>
											</div>
										</a>
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av4.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Sarah Ruiz</div>
												<span class="text-muted">2 hours ago</span>
											</div>
										</a>
										<a href="#" class="list-group-item">
											<div class="media-left">
												<img class="img-circle img-xs" src="<?php echo $base.'/assets/'; ?>img/av3.png" alt="Profile Picture">
											</div>
											<div class="media-body">
												<div class="text-lg">Paul Aguilar</div>
												<span class="text-muted">2 hours ago</span>
											</div>
										</a>
									</div>


									<hr>
									<h4 class="pad-hor text-thin">
										<span class="pull-right badge badge-success">Offline</span> Works
									</h4>

									<!--Works-->
									<div class="list-group bg-trans">
										<a href="#" class="list-group-item">
											<span class="badge badge-purple badge-icon badge-fw pull-left"></span> Joey K. Greyson
										</a>
										<a href="#" class="list-group-item">
											<span class="badge badge-info badge-icon badge-fw pull-left"></span> Andrea Branden
										</a>
										<a href="#" class="list-group-item">
											<span class="badge badge-pink badge-icon badge-fw pull-left"></span> Lucy Moon
										</a>
										<a href="#" class="list-group-item">
											<span class="badge badge-success badge-icon badge-fw pull-left"></span> Johny Juan
										</a>
										<a href="#" class="list-group-item">
											<span class="badge badge-danger badge-icon badge-fw pull-left"></span> Susan Sun
										</a>
									</div>

								</div>
								<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
								<!--End first tab (Contact list)-->


								<!--Second tab (Custom layout)-->
								<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
								<div class="tab-pane fade" id="demo-asd-tab-2">

									<!--Monthly billing-->
									<div class="pad-all">
										<h4 class="text-lg mar-no">Monthly Billing</h4>
										<p class="text-sm">January 2015</p>
										<button class="btn btn-block btn-success mar-top">Pay Now</button>
									</div>


									<hr>

									<!--Information-->
									<div class="text-center clearfix pad-top">
										<div class="col-xs-6">
											<span class="h4">4,327</span>
											<p class="text-muted text-uppercase"><small>Sales</small></p>
										</div>
										<div class="col-xs-6">
											<span class="h4">$ 1,252</span>
											<p class="text-muted text-uppercase"><small>Earning</small></p>
										</div>
									</div>


									<hr>

									<!--Simple Menu-->
									<div class="list-group bg-trans">
										<a href="#" class="list-group-item"><span class="label label-danger pull-right">Featured</span>Edit Password</a>
										<a href="#" class="list-group-item">Email</a>
										<a href="#" class="list-group-item"><span class="label label-success pull-right">New</span>Chat</a>
										<a href="#" class="list-group-item">Reports</a>
										<a href="#" class="list-group-item">Transfer Funds</a>
									</div>


									<hr>

									<div class="text-center">Questions?
										<p class="text-lg text-semibold"> (415) 234-53454 </p>
										<small><em>We are here 24/7</em></small>
									</div>
								</div>
								<!--End second tab (Custom layout)-->
								<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


								<!--Third tab (Settings)-->
								<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
								<div class="tab-pane fade" id="demo-asd-tab-3">
									<ul class="list-group bg-trans">
										<li class="list-header">
											<h4 class="text-thin">Account Settings</h4>
										</li>
										<li class="list-group-item">
											<div class="pull-right">
												<input class="demo-switch" checked="" style="display: none;" data-switchery="true" type="checkbox"><span class="switchery switchery-default" style="background-color: rgb(100, 189, 99); border-color: rgb(100, 189, 99); box-shadow: 0px 0px 0px 0px rgb(100, 189, 99) inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 17px; background-color: rgb(255, 255, 255); transition: left 0.2s ease 0s;"></small></span>
											</div>
											<p>Show my personal status</p>
											<small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
										</li>
										<li class="list-group-item">
											<div class="pull-right">
												<input class="demo-switch" checked="" style="display: none;" data-switchery="true" type="checkbox"><span class="switchery switchery-default" style="background-color: rgb(100, 189, 99); border-color: rgb(100, 189, 99); box-shadow: 0px 0px 0px 0px rgb(100, 189, 99) inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 17px; background-color: rgb(255, 255, 255); transition: left 0.2s ease 0s;"></small></span>
											</div>
											<p>Show offline contact</p>
											<small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
										</li>
										<li class="list-group-item">
											<div class="pull-right">
												<input class="demo-switch" style="display: none;" data-switchery="true" type="checkbox"><span class="switchery switchery-default" style="box-shadow: 0px 0px 0px 0px rgb(223, 223, 223) inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;"><small style="left: 0px; background-color: rgb(255, 255, 255); transition: left 0.2s ease 0s;"></small></span>
											</div>
											<p>Invisible mode </p>
											<small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
										</li>
									</ul>


									<hr>

									<ul class="list-group bg-trans">
										<li class="list-header"><h4 class="text-thin">Public Settings</h4></li>
										<li class="list-group-item">
											<div class="pull-right">
												<input class="demo-switch" checked="" style="display: none;" data-switchery="true" type="checkbox"><span class="switchery switchery-default" style="background-color: rgb(100, 189, 99); border-color: rgb(100, 189, 99); box-shadow: 0px 0px 0px 0px rgb(100, 189, 99) inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 17px; background-color: rgb(255, 255, 255); transition: left 0.2s ease 0s;"></small></span>
											</div>
											Online status
										</li>
										<li class="list-group-item">
											<div class="pull-right">
												<input class="demo-switch" checked="" style="display: none;" data-switchery="true" type="checkbox"><span class="switchery switchery-default" style="background-color: rgb(100, 189, 99); border-color: rgb(100, 189, 99); box-shadow: 0px 0px 0px 0px rgb(100, 189, 99) inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 17px; background-color: rgb(255, 255, 255); transition: left 0.2s ease 0s;"></small></span>
											</div>
											Show offline contact
										</li>
										<li class="list-group-item">
											<div class="pull-right">
												<input class="demo-switch" style="display: none;" data-switchery="true" type="checkbox"><span class="switchery switchery-default" style="box-shadow: 0px 0px 0px 0px rgb(223, 223, 223) inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;"><small style="left: 0px; background-color: rgb(255, 255, 255); transition: left 0.2s ease 0s;"></small></span>
											</div>
											Show my device icon
										</li>
									</ul>



									<hr>

									<h4 class="pad-hor text-thin">Task Progress</h4>
									<div class="pad-all">
										<p>Upgrade Progress</p>
										<div class="progress progress-sm">
											<div class="progress-bar progress-bar-success" style="width: 15%;"><span class="sr-only">15%</span></div>
										</div>
										<small class="text-muted">15% Completed</small>
									</div>
									<div class="pad-hor">
										<p>Database</p>
										<div class="progress progress-sm">
											<div class="progress-bar progress-bar-danger" style="width: 75%;"><span class="sr-only">75%</span></div>
										</div>
										<small class="text-muted">17/23 Database</small>
									</div>

								</div>
								<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
								<!--Third tab (Settings)-->

							</div>
						</div>
					<div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 20px; transform: translate(0px, 0px);"></div></div></div>
				</div>
			</aside>
			<!--===================================================-->
			<!--END ASIDE-->

		</div>

		

        <!-- FOOTER -->
        <footer id="footer">
            <div class="hide-fixed pull-right pad-rgt"><i class="fa fa-university" aria-hidden="true"></i> SALA V1.0</div>
            <p class="pad-lft">&copy; <?php echo date('Y');?> Universidad El Bosque</p>
        </footer>
        <!-- END FOOTER -->


        <!-- SCROLL TOP BUTTON -->
        <!--===================================================-->
        <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
        <!--===================================================-->



	<div id="floating-top-right" class="floating-container"></div></div>
	<!--===================================================-->
	<!-- END OF CONTAINER --> 
	
	<?php
		printScriptFooter($uriBase);
	?>
     
		



<i title="Raphaël Colour Picker" style="display: none; color: transparent;"></i>

</body>
</html>

