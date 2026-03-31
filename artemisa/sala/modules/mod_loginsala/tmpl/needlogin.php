<?php 
// No direct access
defined('_JEXEC') or die; ?>
<!--User dropdown-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li id="dropdown-user" class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
								<span class="pull-right">
									<img class="img-circle img-user media-object" src="<?php echo $uriBase.'assets/'; ?>img/av1.png" alt="Profile Picture">
								</span>
								<div class="username hidden-xs">Necesita logguearse</div>
							</a>


							<div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">

								<!-- Dropdown heading  -->
								<div class="pad-all bord-btm">
									<p class="text-lg text-muted text-thin mar-btm">750Gb of 1,000Gb Used</p>
									<div class="progress progress-sm">
										<div class="progress-bar" style="width: 70%;">
											<span class="sr-only">70%</span>
										</div>
									</div>
								</div>


								<!-- User dropdown menu -->
								<ul class="head-list">
									<li>
										<a href="#">
											<i class="fa fa-user fa-fw fa-lg"></i> Profile
										</a>
									</li>
									<li>
										<a href="#">
											<span class="badge badge-danger pull-right">9</span>
											<i class="fa fa-envelope fa-fw fa-lg"></i> Messages
										</a>
									</li>
									<li>
										<a href="#">
											<span class="label label-success pull-right">New</span>
											<i class="fa fa-gear fa-fw fa-lg"></i> Settings
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-question-circle fa-fw fa-lg"></i> Help
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-lock fa-fw fa-lg"></i> Lock screen
										</a>
									</li>
								</ul>

								<!-- Dropdown footer -->
								<div class="pad-all text-right">
									<a href="pages-login.html" class="btn btn-primary">
										<i class="fa fa-sign-out fa-fw"></i> Logout
									</a>
								</div>
							</div>
						</li>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End user dropdown-->