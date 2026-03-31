<div id='cssmenu'>
	<ul>
		<li class='has-sub <?php (isset($_REQUEST["opc"]) && $_REQUEST["opc"]=="v")?"active":""?>'><a href='#'><span>Configuración</span></a>
			<ul>
				<li class='<?php ($_REQUEST["opc"]=="v")?"active2":""?>'><a href='index.php?opc=v&acc=list'><span>Votaciones</span></a></li>
				<!--<li class='<?php ($_REQUEST["opc"]=="p")?"active2":""?>'><a href='index.php?opc=p&acc=list'><span>Plantillas</span></a></li>
				<li class='<?php ($_REQUEST["opc"]=="c")?"active2":""?>'><a href='index.php?opc=c&acc=list'><span>Candidatos</span></a></li>-->
			</ul>
		</li>
	</ul>
</div>
