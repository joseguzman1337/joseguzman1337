<?php 

class piepagina
{
	public function Mostrar($ruta)
	{
		$html = '
		<footer id="footer" role="contentinfo">
			<div class="footer-container">
				<div class="footer_first region-content">
					<h2 class="block-title"> Universidad El Bosque </h2>
					<div class="block block-block-content block-block-content07517576-86cd-4637-9513-4ad94c11a55b">
						<div class="block-inner">
							<h2>Instalaciones Bogotá</h2>
							<div class="title-suffix"></div>
							<div class="block-content block-content--type-basic block-content--view-mode-full ds-1col clearfix">
								<div class="field field--name-body field--type-text-with-summary field--label-hidden field__items">
									<div class="field__item">
										<div class="text-first-footer">
											<p>Edificio Fundadores Av. Cra 9 No. 131 A - 02<br>
											Línea Gratuita 018000 113033<br>PBX (571) 6489000<br>
											</p>
										</div>
									</div>
								</div>
								<div class="image-first-footer field field--name-field-imagen field--type-image field--label-hidden field__item">
									<img src="'.$ruta.'assets/icons/icon%20fundadores.png" alt="Sede" typeof="foaf:Image" width="31" height="31">
								</div>
							</div>
						</div>
					</div>
					<div class="block block-block-content block-block-content1d5ef9b8-cac9-47da-ba86-b63a589cbf95">
						<div class="block-inner">
							<h2>Instalaciones Chía</h2>
							<div class="title-suffix"></div>
							<div class="block-content block-content--type-basic block-content--view-mode-full ds-1col clearfix">
								<div class="field field--name-body field--type-text-with-summary field--label-hidden field__items">
									<div class="field__item">
										<div class="text-first-footer">
											<p>Autopista Norte Km. 20 costado occidental Vía Chía - Bogotá<br>
											Teléfono: 6763110<br>
											Línea Gratuita 018000 113033<br>
											PBX (571) 6489000
											</p>
										</div>
									</div>
								</div>
								<div class="image-first-footer field field--name-field-imagen field--type-image field--label-hidden field__item">
									<img src="'.$ruta.'assets/icons/IconUniversity.png" alt="Sede Chía" typeof="foaf:Image" width="51" height="34">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer_second region-content">
					<div class="block block-block-content block-block-content3f4bc1ea-9591-49bb-93ec-f65d1c6b589e">
						<div class="block-inner">
						<h2>Admisiones</h2>
						<div class="title-suffix"></div>
							<div class="block-content block-content--type-basic block-content--view-mode-full ds-1col clearfix">
								<div class="field field--name-body field--type-text-with-summary field--label-hidden field__items">
									<div class="field__item">
										<p>6489000 Ext. 1170<br>
										Línea Gratuita 018000 113033<br>
										Edificio Fundadores Av. Cra 9 N0. 131 A - 02<br>
										Skype /uelbosque<br>
										<a href="mailto:atencionalusuario@unbosque.edu.co">atencionalusuario@unbosque.edu.co</a>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer_third region-content">
					<nav class="block block-menu navigation menu--informacion-legal" role="navigation" aria-labelledby="-menu">
						<h2 id="-menu">Información Legal</h2>
						<ul class="menu">
							<li class="menu-item">
								<a href="http://www.uelbosque.edu.co/admisiones/valores_pecuniarios" target="_blank">Valores Pecuniarios</a>
							</li>
							<li class="menu-item">
								<a href="http://www.uelbosque.edu.co/institucional/documentos/estatutos-reglamentos/estatuto-general" target="_blank">Estatuto General</a>
							</li>
							<li class="menu-item">
								<a href="http://www.uelbosque.edu.co/institucional/documentos/estatutos-reglamentos/reglamento-estudiantil" target="_blank">Reglamento Estudiantil</a>
							</li>
							<li class="menu-item">
								<a href="http://www.uelbosque.edu.co/institucional/documentos/estatutos-reglamentos/estatuto-docente" target="_blank">Estatuto Docente</a>
							</li>
							<li class="menu-item">
								<a href="http://www.uelbosque.edu.co/institucional/documentos/politicas/bienestar" target="_blank">Política de Bienestar Universitario</a>
							</li>
							<li class="menu-item">
								<a href="http://www.uelbosque.edu.co/sites/default/files/nueva-web/terminos-y-condiciones-de-uso-del-sitio.pdf" target="_blank">Términos y Condiciones de Uso del Sitio</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="footer_copyright region-content">
				<div class="block block-block-content block-block-content40319c06-179b-4ec0-97ba-80fe638390ae">
					<div class="block-inner">
						<div class="title-suffix"></div>
						<div class="block-content block-content--type-basic block-content--view-mode-full ds-1col clearfix">
							<div class="field field--name-body field--type-text-with-summary field--label-hidden field__items">
								<div class="field__item">
									<p>Vigilada Mineducación. Personería Jurídica otorgada mediante resolución 11153 del 4 de agosto de 1978.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>';
		
		return $html;
	}//function Mostrar
}
?>