<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<?php
$res=$db->exec("select apellidodocente
			,nombredocente
			,tipodocumento
			,numerodocumento
			,emaildocente
			,usuarioskypedocente
			,perfilfacebookdocente
			,codigogenero
			,fechanacimientodocente
			,idestadocivil
			,direcciondocente
			,idciudadresidencia
			,telefonoresidenciadocente
			,numerocelulardocente
			,profesion
			,numerotarjetaprofesionaldocente
			,fechaexpediciontarjetaprofesionaldocente
			,nombreempresapropiadocente
			,fechaprimercontratodocente
			,modalidadocente
			,idciudadnacimiento
			,de.iddepartamento
			,de.idpais
		from docente do 
		join ciudad c on do.idciudadnacimiento=c.idciudad
		join departamento de using(iddepartamento)
		where iddocente='".$_SESSION["sissic_iddocente"]."'");
$row=mysql_fetch_array($res);
$apellidodocente=$row["apellidodocente"];
$nombredocente=$row["nombredocente"];
$tipodocumento=$row["tipodocumento"];
$numerodocumento=$row["numerodocumento"];
$emaildocente=$row["emaildocente"];
$usuarioskypedocente=$row["usuarioskypedocente"];
$perfilfacebookdocente=$row["perfilfacebookdocente"];
$codigogenero=$row["codigogenero"];
$fechanacimientodocente=$row["fechanacimientodocente"];
$idestadocivil=$row["idestadocivil"];
$direcciondocente=$row["direcciondocente"];
$idciudadresidencia=$row["idciudadresidencia"];
$telefonoresidenciadocente=$row["telefonoresidenciadocente"];
$numerocelulardocente=$row["numerocelulardocente"];
$profesion=$row["profesion"];
$numerotarjetaprofesionaldocente=$row["numerotarjetaprofesionaldocente"];
$fechaexpediciontarjetaprofesionaldocente=$row["fechaexpediciontarjetaprofesionaldocente"];
$nombreempresapropiadocente=$row["nombreempresapropiadocente"];
$fechaprimercontratodocente=$row["fechaprimercontratodocente"];
$modalidadocente=$row["modalidadocente"];
$idpais=$row["idpais"];
$iddepartamento=$row["iddepartamento"];
$idciudadnacimiento=$row["idciudadnacimiento"];

$res=$db->exec("select idnucleofamiliadocente,codigotiponucleofamiliadocente,cantidadnucleofamiliadocente from nucleofamiliadocente where iddocente='".$_SESSION["sissic_iddocente"]."'");
while($row=mysql_fetch_array($res)) {
	if($row['codigotiponucleofamiliadocente']=="100") {
		$valuePadre=$row['idnucleofamiliadocente'];
		$checkPadre=($row['cantidadnucleofamiliadocente'])?"checked":"";
	}
	if($row['codigotiponucleofamiliadocente']=="101") {
		$valueMadre=$row['idnucleofamiliadocente'];
		$checkMadre=($row['cantidadnucleofamiliadocente'])?"checked":"";
	}
	if($row['codigotiponucleofamiliadocente']=="102") {
		$valueHermanos=$row['idnucleofamiliadocente'];
		$checkHermano=($row['cantidadnucleofamiliadocente'])?"checked":"";
	}
	if($row['codigotiponucleofamiliadocente']=="103") {
		$valueEsposo=$row['idnucleofamiliadocente'];
		$checkEsposo=($row['cantidadnucleofamiliadocente'])?"checked":"";
	}
	if($row['codigotiponucleofamiliadocente']=="200")  {
		$valueHijos=$row['idnucleofamiliadocente'];
		$nrohijos=$row['cantidadnucleofamiliadocente'];
	}
}
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">INFORMACI&Oacute;N PERSONAL</legend>
	<p> <?=$obj->textBox("Apellidos","apellidodocente",$apellidodocente,1,"30","left")?> </p>
	<p> <?=$obj->textBox("Nombres","nombredocente",$nombredocente,1,"30","left")?> </p>
	<p> <?=$obj->select("Tipo documento","tipodocumento",$tipodocumento,1,"select tipodocumento,nombredocumento from documento where codigoestado=100 and tipodocumento<>'0' order by nombredocumento")?> </p>
	<p> <?=$obj->numberBox("N&uacute;mero de documento","numerodocumento",$numerodocumento,1,"10","right","","","readonly")?> </p>
	<p> <?=$obj->emailBox("Correo electr&oacute;nico","emaildocente",$emaildocente,0,"35")?> </p>
	<p> <?=$obj->textBox("Usuario skype","usuarioskypedocente",$usuarioskypedocente,0,"10")?> </p>
	<p> <?=$obj->textBox("Perfil facebook","perfilfacebookdocente",$perfilfacebookdocente,0,"20")?> </p>
	<p> <?=$obj->select("G&eacute;nero","codigogenero",$codigogenero,1,"select codigogenero,nombregenero from genero")?> </p>
	<p> <?=$obj->dateBox("Fecha de nacimiento","fechanacimientodocente",$fechanacimientodocente,1)?> </p>
	<p> <?=$obj->select("Estado civil","idestadocivil",$idestadocivil,1,"select idestadocivil,nombreestadocivil from estadocivil order by nombreestadocivil")?> </p>
	<p> <?=$obj->textBox("Direcci&oacute;n de residencia","direcciondocente",$direcciondocente,1,"40")?> </p>
	<p> <?=$obj->select("Ciudad de residencia","idciudadresidencia",$idciudadresidencia,1,"select idciudad,nombreciudad from ciudad order by nombreciudad")?> </p>
	<p> <?=$obj->textBox("Tel&eacute;fono de residencia","telefonoresidenciadocente",$telefonoresidenciadocente,1,"8","right")?> </p>
	<p> <?=$obj->textBox("Celular","numerocelulardocente",$numerocelulardocente,0,"10","right")?> </p>
	<p> <?=$obj->textBox("Profesi&oacute;n","profesion",$profesion,0,"30")?> </p>
	<p> <?=$obj->textBox("N&uacute;mero de tarjeta profesional","numerotarjetaprofesionaldocente",$numerotarjetaprofesionaldocente,0,"10","right")?> </p>
	<p> <?=$obj->dateBox("Fecha de expedici&oacute;n tarjeta profesional","fechaexpediciontarjetaprofesionaldocente",$fechaexpediciontarjetaprofesionaldocente,0)?> </p>
	<p> <?=$obj->textBox("Nombre empresa propia","nombreempresapropiadocente",$nombreempresapropiadocente,0,"30")?> </p>
	<p> <?=$obj->dateBox("Fecha primer contrato","fechaprimercontratodocente",$fechaprimercontratodocente,0)?> </p>
	<p> <?=$obj->select("Modalidad","modalidadocente",$modalidadocente,0,"select id_modalidadocente,nombre from modalidad_docente where codigoestado=100")?> </p>
	<p> <?=$obj->select("Pais nacimiento","idpais",$idpais,1,"select idpais,nombrepais from pais where codigoestado='100' order by nombrepais","","cargaDepartamentos(this.value)"," function cargaDepartamentos(id) { $.ajax({ url: 'cargaCombos.php' , data: 'id='+id+'&opc=dep' , success: function(resp){ $('#iddepartamento').html(resp) } }); $.ajax({ url: 'cargaCombos.php' , data: 'opc=empty' , success: function(resp){ $('#idciudadnacimiento').html(resp) } }); } ")?> </p>

	<p> <?=$obj->select("Departamento nacimiento","iddepartamento",$iddepartamento,1,"select iddepartamento,nombredepartamento from departamento where idpais=".$idpais." and codigoestado='100' order by nombredepartamento","","cargaCiudades(this.value)","function cargaCiudades(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=ciu', success: function(resp){ $('#idciudadnacimiento').html(resp) } });}")?> </p>
	<p> <?=$obj->select("Ciudad nacimiento","idciudadnacimiento",$idciudadnacimiento,1,"select idciudad,nombreciudad from ciudad where iddepartamento=".$iddepartamento." and codigoestado='100' order by nombreciudad")?> </p>
</fieldset>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget-header ui-corner-all">N&Uacute;CLEO FAMILIAR<br><br>Ubique aqu&iacute; las personas que componen su n&uacute;cleo familiar (Personas que viven con usted)</legend>
	<p>
		<?=$obj->checkBox("Padre","checkpadre",1,0,$checkPadre)?>
		<?=$obj->hiddenBox("padre",$valuePadre)?> 
	</p>
	<p>
		<?=$obj->checkBox("Madre","checkmadre",1,0,$checkMadre)?>
		<?=$obj->hiddenBox("madre",$valueMadre)?> 
	</p>
	<p>
		<?=$obj->checkBox("Hermanos(s)","checkhermanos",1,0,$checkHermano)?>
		<?=$obj->hiddenBox("hermanos",$valueHermanos)?> 
	</p>
	<p>
		<?=$obj->checkBox("Esposo(a)","checkesposo",1,0,$checkEsposo)?>
		<?=$obj->hiddenBox("esposo",$valueEsposo)?> 
	</p>
	<p>
		<?=$obj->numberBox("Hijo(s)","nrohijos",$nrohijos,0,"3","center",1,2)?>
		<?=$obj->hiddenBox("hijos",$valueHijos)?> 
	</p>
	<p>
		<?=$obj->hiddenBox("opc",$_REQUEST["opc"])?> 
		<div id="submit">
			<button type="submit">Enviar</button>
		</div>
	</p>
</fieldset>
<div id="resultado"></div>
