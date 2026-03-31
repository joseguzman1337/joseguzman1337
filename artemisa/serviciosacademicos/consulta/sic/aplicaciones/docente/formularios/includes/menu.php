<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

<div id='cssmenu'>
	<ul>
		<li class='has-sub <?=(isset($_REQUEST["opc"]) && $_REQUEST["opc"]!="prev")?"active":""?>'><a href='#'><span>Información general del docente</span></a>
			<ul>
				<li class='<?=($_REQUEST["opc"]=="ip")?"active2":""?>'><a href='index.php?opc=ip'><span>Información personal</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="dp")?"active2":""?>'><a href='index.php?opc=dp&acc=list'><span>Desarrollo profesoral</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="hlu")?"active2":""?>'><a href='index.php?opc=hlu'><span>Historial laboral unbosque</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="pu")?"active2":""?>'><a href='index.php?opc=pu&acc=list'><span>Participación universitaria</span></a></li>
				<li class='has-sub <?=($_REQUEST["opc"]=="alud" || $_REQUEST["opc"]=="aluli" || $_REQUEST["opc"]=="alupsoagaa")?"active2":""?>'><a href='#'><span>Actividad laboral en la universidad</span></a>
					<ul>
						<li class='<?=($_REQUEST["opc"]=="alud")?"active2":""?>'><a href='index.php?opc=alud'><span>Docencia</span></a></li>
						<li class='<?=($_REQUEST["opc"]=="aluli")?"active2":""?>'><a href='index.php?opc=aluli&acc=list'><span>Lineas de investigación</span></a></li>
						<li class='<?=($_REQUEST["opc"]=="alupsoagaa")?"active2":""?>'><a href='index.php?opc=alupsoagaa&acc=list'><span>Proyeccion social / Orientación académica / Gestión académica administrativa</span></a></li>
					</ul>
				</li>
				<li class='has sub <?=($_REQUEST["opc"]=="fafddi" || $_REQUEST["opc"]=="fafgi" || $_REQUEST["opc"]=="fafgmt")?"active2":""?>'><a href='#'><span>Formación académica</span></a>
					<ul>
						<li class='<?=($_REQUEST["opc"]=="fafddi" && $_REQUEST["tf"]=="100")?"active2":""?>'><a href='index.php?opc=fafddi&acc=list&tf=100'><span>Formación disciplinar</span></a></li>
						<li class='<?=($_REQUEST["opc"]=="fafddi" && $_REQUEST["tf"]=="200")?"active2":""?>'><a href='index.php?opc=fafddi&acc=list&tf=200'><span>Formación en la docencia</span></a></li>
						<li class='<?=($_REQUEST["opc"]=="fafddi" && $_REQUEST["tf"]=="300")?"active2":""?>'><a href='index.php?opc=fafddi&acc=list&tf=300'><span>Formación para investigación</span></a></li>
						<li class='has-sub <?=($_REQUEST["opc"]=="fafgi" || $_REQUEST["opc"]=="fafgmt")?"active2":""?>'><a href='#'><span>Formación general</span></a>
							<ul>
								<li class='<?=($_REQUEST["opc"]=="fafgi")?"active2":""?>'><a href='index.php?opc=fafgi&acc=list'><span>Idioma</span></a></li>
								<li class='<?=($_REQUEST["opc"]=="fafgmt")?"active2":""?>'><a href='index.php?opc=fafgmt'><span>Manejo de TICS</span></a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class='<?=($_REQUEST["opc"]=="el")?"active2":""?>'><a href='index.php?opc=el&acc=list'><span>Experiencia laboral</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="pa")?"active2":""?>'><a href='index.php?opc=pa&acc=list'><span>Producción académica</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="e")?"active2":""?>'><a href='index.php?opc=e&acc=list'><span>Estimulos</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="r")?"active2":""?>'><a href='index.php?opc=r&acc=list'><span>Reconocimientos</span></a></li>
				<li class='<?=($_REQUEST["opc"]=="ga")?"active2":""?>'><a href='index.php?opc=ga&acc=list'><span>Grupos académicos</span></a></li>
			</ul>
		</li>
		<!--<li><a href='../consultaaprobacion/consultaprobaciondatosdocente.php' target="_blank"><span>Previsualizar</span></a></li>-->
		<li class='<?=($_REQUEST["opc"]=="prev")?"active":""?>'><a href='index.php?opc=prev'><span>Previsualizar</span></a></li>
<?php
		if(isset($_SESSION["sissic_numerodocumentodocente"])) { 
?>
			<li><a href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/sic/aplicaciones/docente/ingresodocente.php'><span>Salir</span></a></li>
<?php
		}
?>
	</ul>
</div>
