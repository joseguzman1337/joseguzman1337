<?php 

    if(!defined("HTTP_ROOT")){
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode("/serviciosacademicos", $actual_link);
        define("HTTP_ROOT", $actual_link[0]);
    } 
    if(!defined("PATH_ROOT")){
       $actual_link = getcwd();
       $actual_link = explode("/serviciosacademicos", $actual_link);
       define("PATH_ROOT", $actual_link[0]);
    }



session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

</form>
<form>
<?php
require_once("../../../../../funciones/sala_genericas/FuncionesFecha.php");
$res=$db->exec("select * ,c1.nombreciudad nombreciudadresidencia from documento t,genero g,estadocivil e,ciudad c1,docente d left join usuario u on u.numerodocumento=d.numerodocumento and codigotipousuario like '5%' where d.iddocente= '".$_SESSION["sissic_iddocente"]."'and d.codigoestado like '1%' and t.tipodocumento=d.tipodocumento and g.codigogenero=d.codigogenero and e.idestadocivil=d.idestadocivil and c1.idciudad=d.idciudadresidencia");
$row=mysql_fetch_array($res);
/*
 * Caso 89387-89386	
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Se valida si la foto existe en el servidor para que la muestre de los contrario muestra una Imagen por Default que es una imagen en blanco.
 * @since Mayo 8 de 2017
*/
    $fotoHt = HTTP_ROOT."/imagenes/estudiantes/".$row["numerodocumento"].".jpg";
    $fotoPath = PATH_ROOT."/imagenes/estudiantes/".$row["numerodocumento"].".jpg";
    $noFoto = HTTP_ROOT."/serviciosacademicos/consulta/sic/aplicaciones/docente/formularios/images/no_foto.jpg"; 

    if(file_exists($fotoPath)){
       $fotoHttp = $fotoHt;
    }else {
       $fotoHttp = $noFoto;
    }
    //End Caso 89387-89386	
    ?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">INFORMACI&Oacute;N GENERAL DOCENTE</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Apellidos</th>
				<th>Nombres</th>
				<th>Tipo documento</th>
				<th>Documento</th>
				<th rowspan="10" style="background-color:#ffffff"><img width="140" height="200" src="<?=$fotoHttp?>"></th>
			</tr>
			<tr>
				<td><?=$row["apellidodocente"]?></td>
				<td><?=$row["nombredocente"]?></td>
				<td><?=$row["nombredocumento"]?></td>
				<td><?=$row["numerodocumento"]?></td>
			</tr>
			<tr>
				<th>G&eacute;nero</th>
				<th>Estado civil</th>
				<th>Fecha De nacimiento</th>
				<th>Edad</th>
			</tr>
			<tr>
				<td><?=$row["nombregenero"]?></td>
				<td><?=$row["nombreestadocivil"]?></td>
				<td><?=$row["fechanacimientodocente"]?></td>
				<td><?=(int)(diferencia_fechas(formato_fecha_defecto($row["fechanacimientodocente"]),date("d/m/Y"),"meses",0)/12)?></td>
			</tr>
			<tr>
				<th>Direcci&oacute;n residencia</th>
				<th>Ciudad residencia</th>
				<th>Tel&eacute;fono residencia</th>
				<th>Celular</th>
			</tr>
			<tr>
				<td><?=$row["direcciondocente"]?></td>
				<td><?=$row["nombreciudadresidencia"]?></td>
				<td><?=$row["telefonoresidenciadocente"]?></td>
				<td><?=$row["numerocelulardocente"]?></td>
			</tr>
			<tr>
				<th>N&uacute;mero de tarjeta profesional</th>
				<th>Fecha de expedici&oacute;n tarjeta profesional</th>
				<th>Nombre empresa propia</th>
				<th>Fecha primer contrato</th>
			</tr>
			<tr>
				<td><?=$row["numerotarjetaprofesionaldocente"]?></td>
				<td><?=$row["fechaexpediciontarjetaprofesionaldocente"]?></td>
				<td><?=$row["nombreempresapropiadocente"]?></td>
				<td><?=$row["fechaprimercontratodocente"]?></td>
			</tr>
			<tr>
				<th>Correo personal</th>
				<th>Correo institucional</th>
				<th>Usuario skype</th>
				<th>Perfil facebook</th>
			</tr>
			<tr>
				<td><?=$row["emaildocente"]?></td>
				<td><?=$row["usuario"]."@unbosque.edu.co"?></td>
				<td><?=$row["usuarioskypedocente"]?></td>
				<td><?=$row["perfilfacebookdocente"]?></td>
			</tr>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">NUCLEO FAMILIAR</legend>
	<div class="CSSTableGenerator">
<?php
		$rutaimagenchulo="../../../imagenes/ssuccess.png";
		$rutaimagenx="../../../imagenes/serror.png";
		$res=$db->exec("select idnucleofamiliadocente,codigotiponucleofamiliadocente,cantidadnucleofamiliadocente from nucleofamiliadocente where iddocente='".$_SESSION["sissic_iddocente"]."'");
		while($row=mysql_fetch_array($res)) {
			if($row['codigotiponucleofamiliadocente']=="100")
				$imgPadre=($row['cantidadnucleofamiliadocente'])?$rutaimagenchulo:$rutaimagenx;
			if($row['codigotiponucleofamiliadocente']=="101")
				$imgMadre=($row['cantidadnucleofamiliadocente'])?$rutaimagenchulo:$rutaimagenx;
			if($row['codigotiponucleofamiliadocente']=="102")
				$imgHermanos=($row['cantidadnucleofamiliadocente'])?$rutaimagenchulo:$rutaimagenx;
			if($row['codigotiponucleofamiliadocente']=="103")
				$imgEsposo=($row['cantidadnucleofamiliadocente'])?$rutaimagenchulo:$rutaimagenx;
			if($row['codigotiponucleofamiliadocente']=="200")
				$nroHijos=($row['cantidadnucleofamiliadocente'])?$row['cantidadnucleofamiliadocente']:0;
		}
?>
		<table width="100%">
			<tr>
				<th>Padre</th>
				<th>Madre</th>
				<th>Hermano(s)</th>
				<th>Esposo(a)</th>
				<th>Hijo(s)</th>
			</tr>
			<tr>
				<td><img width="10" height="10" src="<?=$imgPadre?>"></td>
				<td><img width="10" height="10" src="<?=$imgMadre?>"></td>
				<td><img width="10" height="10" src="<?=$imgHermanos?>"></td>
				<td><img width="10" height="10" src="<?=$imgEsposo?>"></td>
				<td><?=$nroHijos?></td>
			</tr>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">HISTORIA LABORAL UNBOSQUE</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>N&uacute;mero</th>
				<th>Horas Por semana</th>
				<th>Tipo contrato</th>
				<th>Centro beneficio</th>
				<th>Carrera</th>
				<th>Fecha inicio</th>
				<th>Fecha final</th>
				<th>Escalaf&oacute;n</th>
			</tr>
<?php
		$res=$db->exec("select * from contratodocente cd,tipocontrato tc,detallecontratodocente dc,carrera c,centrobeneficio cb,escalafon e where cd.iddocente='".$_SESSION["sissic_iddocente"]."' and cd.idcontratodocente=dc.idcontratodocente and dc.codigocarrera=c.codigocarrera and tc.codigotipocontrato=cd.codigotipocontrato and cb.codigocentrobeneficio=dc.codigocentrobeneficio and tc.codigoestado like '1%' and cd.codigoestado like '1%' and e.codigoescalafon=cd.codigoescalafon");
		$i=1;
		while($row=mysql_fetch_array($res)) {
?>
			<tr>
				<td><?=$i?></td>
				<td><?=$row["horasxsemanadetallecontratodocente"]?></td>
				<td><?=$row["nombretipocontrato"]?></td>
				<td><?=$row["nombrecentrobeneficio"]?></td>
				<td><?=$row["nombrecarrera"]?></td>
				<td><?=$row["fechainiciocontratodocente"]?></td>
				<td><?=$row["fechafinalcontratodocente"]?></td>
				<td><?=$row["nombreescalafon"]?></td>
			</tr>
<?php
			$i++;
		}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">PARTICIPACI&Oacute;N UNIVERSITARIA</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Periodo</th>
				<th>Tipo participaci&oacute;n</th>
				<th>Nombre participaci&oacute;n</th>
			</tr>
<?php
			$res=$db->exec("select * from participacionuniversitariadocente d,tipoparticipacionuniversitaria tp where d.iddocente= '".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and tp.codigotipoparticipacionuniversitaria=d.codigotipoparticipacionuniversitaria and tp.codigotipoparticipacionuniversitaria <> '400' and d.nombreparticipacionuniversitariadocente<>''");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["codigoperiodo"]?></td>
					<td><?=$row["nombretipoparticipacionuniversitaria"]?></td>
					<td><?=$row["nombreparticipacionuniversitariadocente"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">GOBIERNO UNIVERSITARIO</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Periodo</th>
				<th>Tipo participaci&oacute;n</th>
			</tr>
<?php
			$res=$db->exec("select * from participacionuniversitariadocente d,tipoconsejouniversidad tp where d.iddocente= '".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and tp.codigotipoconsejouniversidad=d.codigotipoconsejouniversidad and tp.codigotipoconsejouniversidad <> '400'");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["codigoperiodo"]?></td>
					<td><?=$row["nombretipoconsejouniversidad"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">ACTIVIDAD LABORAL EN LA UNIVERSIDAD</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Periodo</th>
				<th>Tipo actividad</th>
				<th>Horas dedicadas</th>
				<th>Registrado por</th>
			</tr>
<?php
			$res=$db->exec("select * ,d.codigoperiodo codigoperiodoactividad from actividadlaboraldocente d,tipoactividadlaboral ta,carrera c where d.iddocente='".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and ta.codigotipoactividadlaboral=d.codigotipoactividadlaboral and c.codigocarrera=d.codigocarrera group by d.codigotipoactividadlaboral,d.codigoperiodo order by c.codigocarrera,d.codigoperiodo");
			while($row=mysql_fetch_array($res)) {
				$registrado=($row["codigocarrera"]=="1")?"Docente":"Facultad";
?>
				<tr>
					<td><?=$row["codigoperiodo"]?></td>
					<td><?=$row["nombretipoactividadlaboral"]?></td>
					<td><?=$row["numerohorasactividadlaboraldocente"]?></td>
					<td><?=$registrado?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">ACTIVIDAD LABORAL DOCENCIA</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Periodo</th>
				<th>Codigo mater&iacute;a</th>
				<th>Mater&iacute;a</th>
				<td>Grupo</td>
				<th>N&uacute;mero horas</th>
			</tr>
<?php
			$res=$db->exec("select	 g.codigoperiodo
						,codigomateria
						,nombremateria
						,nombregrupo
						,numerohorassemanales
					from grupo g 
					join materia m using(codigomateria)
					join docente d using(numerodocumento)
					where d.iddocente='".$_SESSION["sissic_iddocente"]."'
						and g.codigoestadogrupo=10
					order by g.codigoperiodo");
			while ($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td align="center"><?=$row["codigoperiodo"]?></td>
					<td align="center"><?=$row["codigomateria"]?></td>
					<td><?=$row["nombremateria"]?></td>
					<td><?=$row["nombregrupo"]?></td>
					<td align="center"><?=$row["numerohorassemanales"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">LINEAS DE INVESTIGACI&Oacute;N</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Periodo</th>
				<th>Linea de investigaci&oacute;n</th>
				<th>Grupo de investigaci&oacute;n</th>
				<th>Facultad</th>
				<th>Fecha de ingreso</th>
				<th>Fecha de termino</th>
			</tr>
<?php
			$res=$db->exec("select * from lineainvestigaciondocente d, lineainvestigacion l,grupoinvestigacion g,facultad f where d.iddocente= '".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and g.codigoestado like '1%' and l.codigoestado like '1%' and l.idlineainvestigacion=d.idlineainvestigacion and l.idgrupoinvestigacion=g.idgrupoinvestigacion and g.codigofacultad=f.codigofacultad");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["codigoperiodo"]?></td>
					<td><?=$row["nombrelineainvestigacion"]?></td>
					<td><?=$row["nombregrupoinvestigacion"]?></td>
					<td><?=$row["nombrefacultad"]?></td>
					<td><?=$row["fechaingresolineainvestigacion"]?></td>
					<td><?=$row["fechaterminacionlineainvestigacion"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">FORMACI&Oacute;N ACAD&Eacute;MICA</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>C&oacute;digo</th>
				<th>Tipo formaci&oacute;n</th>
				<th>Nombre del programa</th>
				<th>Nombre de la instituci&oacute;n</th>
				<th>Tipo de educaci&oacute;n</th>
				<th>Fecha final</th>
			</tr>
<?php
			$res=$db->exec("select * from nivelacademicodocente d,tiponivelacademico t,nucleobasicoareaconocimiento na, pais p, tipoformacion tf where d.iddocente= '".$_SESSION["sissic_iddocente"]."'
             and d.codigoestado like '1%' and d.idnucleobasicoareaconocimiento=na.idnucleobasicoareaconocimiento and d.codigotiponivelacademico=t.codigotiponivelacademico and
              d.idpais=p.idpais and d.codigotiponivelacademico not in ('09','10','11','12','13') and d.codigotipoformacion=tf.codigotipoformacion and d.codigotipoformacion <> '400'");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["idnivelacademicodocente"]?></td>
					<td><?=$row["nombretipoformacion"]?></td>
					<td><?=$row["titulonivelacademicodocente"]?></td>
					<td><?=$row["institucionnivelacademicodocente"]?></td>
					<td><?=$row["nombretiponivelacademico"]?></td>
					<td><?=$row["fechafinalnivelacademicodocente"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">MANEJO DE TECNOLOG&Iacute;AS DE LA INFORMACI&Oacute;N Y COMUNICACIONES</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr></tr>
<?php
			$rutaimagenchulo="../../../imagenes/ssuccess.png";
			$rutaimagenx="../../../imagenes/serror.png";
			$res=$db->exec("select nombretipotecnologiainformacion,td.codigotipotecnologiainformacion from tipotecnologiainformacion tt left join tecnologiainformaciondocente td on tt.codigotipotecnologiainformacion=td.codigotipotecnologiainformacion and td.codigoestado like '1%' and td.iddocente='".$_SESSION["sissic_iddocente"]."' where tt.codigoestado= '100'");
			while($row=mysql_fetch_array($res)) {
				$img=($row["codigotipotecnologiainformacion"])?$rutaimagenchulo:$rutaimagenx;
?>
				<tr>
					<td><?=$row["nombretipotecnologiainformacion"]?></td>
					<td><img width="10" height="10" src="<?=$img?>"></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">IDIOMAS</legend>
	<div class="CSSTableGenerator">
		<table>
			<tr>
				<th>Idioma</th>
<?php
				$arrTipoManejoIdioma=array();
				$res=$db->exec("select idtipomanejoidioma,nombrecortotipomanejoidioma from tipomanejoidioma where codigoestado like '1%' order by idtipomanejoidioma");
				while ($row=mysql_fetch_array($res)) {
					$arrTipoManejoIdioma[]=$row["idtipomanejoidioma"];
?>
					<th><?=$row["nombrecortotipomanejoidioma"]?></th>
<?php
				}
?>
			</tr>
<?php
			$res=$db->exec("select * from idiomadocente join idioma using(ididioma) where iddocente='".$_SESSION["sissic_iddocente"]."'");
			while ($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["nombreidioma"]?></td>

<?php
					$arrTipoManejoIdiomaDocentesId=array();
					$arrTipoManejoIdiomaDocentesIndicador=array();
					$res2=$db->exec("select idtipomanejoidioma,nombreindicadornivelidioma from detalleidiomadocente join indicadornivelidioma using(idindicadornivelidioma) where ididiomadocente=".$row["ididiomadocente"]." order by idtipomanejoidioma");
					while ($row2=mysql_fetch_array($res2))  {
						$arrTipoManejoIdiomaDocentesId[$row2["idtipomanejoidioma"]]=$row2["idtipomanejoidioma"];
						$arrTipoManejoIdiomaDocentesIndicador[$row2["idtipomanejoidioma"]]=$row2["nombreindicadornivelidioma"];
					}
					foreach ($arrTipoManejoIdioma as &$valor) {
						if(in_array($valor,$arrTipoManejoIdiomaDocentesId))
							echo "<td>".$arrTipoManejoIdiomaDocentesIndicador[$valor]."</td>";
						else
							echo "<td>&nbsp;</td>";
					}
?>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">EXPERIENCIA LABORAL</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>C&oacute;digo</th>
				<th>Tipo formaci&oacute;n</th>
				<th>Nombre de la instituci&oacute;n</th>
				<th>Tipo contrato</th>
				<th>Fecha final</th>
				<th>Horas dedicaci&oacute;n</th>
				<th>Profesi&oacute;n</th>
			</tr>
<?php
			$res=$db->exec("select * from experiencialaboraldocente d,tipoexperiencialaboraldocente te,profesion p where d.iddocente= '".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and d.codigotipoexperiencialaboraldocente=te.codigotipoexperiencialaboraldocente and p.idprofesion=d.idprofesion");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["idexperiencialaboraldocente"]?></td>
					<td><?=$row["nombretipoexperiencialaboraldocente"]?></td>
					<td><?=$row["nombreinstitucionexperiencialaboraldocente"]?></td>
					<td><?=$row["tipocontratoexperiencialaboraldocente"]?></td>
					<td><?=$row["fechafinalexperiencialaboraldocente"]?></td>
					<td><?=$row["horadedicacionexperiencialaboraldocente"]?></td>
					<td><?=$row["nombreprofesion"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">PRODUCCI&Oacute;N ACAD&Eacute;MICA</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Nombre principal</th>
				<th>T&iacute;tulo espec&iacute;fico</th>
				<th>Fecha de publicaci&oacute;n</th>
				<th>Producto indexado</th>
				<th>N&uacute;mero de identificaci&oacute;n</th>
				<th>Tipo del producto</th>
			</tr>
<?php
			$res=$db->exec("select * from produccionintelectualdocente d, tipoproduccionintelectual tp where d.iddocente='".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and tp.codigotipoproduccionintelectual=d.codigotipoproduccionintelectual");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["nombreproduccionintelectualdocente"]?></td>
					<td><?=$row["tituloproduccionintelectualdocente"]?></td>
					<td><?=$row["fechapublicacionproduccionintelectualdocente"]?></td>
					<td><?=($row["esindexadaproduccionintelectualdocente"])?"Si":"No"?></td>
					<td><?=$row["numeroproduccionintelectualdocente"]?></td>
					<td><?=$row["nombretipoproduccionintelectual"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">EST&Iacute;MULOS</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>T&iacute;tulo est&iacute;mulo</th>
				<th>Instituci&oacute;n</th>
				<th>Tipo de est&iacute;mulo</th>
				<th>Tipo de participaci&oacute;n</th>
				<th>Fecha finalizaci&oacute;n</th>
				<th>Ciudad</th>
			</tr>
<?php
			$res=$db->exec("select * from estimulodocente d,tipoestimulodocente tp,tipoparticipacionestimulodocente te,ciudad c where d.iddocente='".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and tp.codigotipoestimulodocente=d.codigotipoestimulodocente and d.codigotipoparticipacionestimulodocente=te.codigotipoparticipacionestimulodocente and c.idciudad=d.idciudadestimulodocente");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["tituloestimulodocente"]?></td>
					<td><?=$row["entidadestimulodocente"]?></td>
					<td><?=$row["nombretipoestimulodocente"]?></td>
					<td><?=$row["nombretipoparticipacionestimulodocente"]?></td>
					<td><?=$row["fechaestimulodocente"]?></td>
					<td><?=$row["nombreciudad"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">RECONOCIMIENTOS</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Tipo de reconocimiento</th>
				<th>Reconocimiento otorgado</th>
				<th>Fecha de reconocimiento</th>
				<th>Ciudad</th>
			</tr>
<?php
			$res=$db->exec("select * from reconocimientodocente d, ciudad c where d.iddocente= '".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and c.idciudad=d.idciudadreconocimientodocente");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["tiporeconocimientodocente"]?></td>
					<td><?=$row["otorgareconocimientodocente"]?></td>
					<td><?=$row["fechareconocimientodocente"]?></td>
					<td><?=$row["nombreciudad"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
<br>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">GRUPOS ACAD&Eacute;MICOS</legend>
	<div class="CSSTableGenerator">
		<table width="100%">
			<tr>
				<th>Nombre asociaci&oacute;n</th>
				<th>Tipo de asociaci&oacute;n</th>
				<th>Fecha de ingreso</th>
				<th>Fecha de terminaci&oacute;n</th>
			</tr>
<?php
			$res=$db->exec("select * from asociaciondocente d, tipoasociaciondocente ts where d.iddocente= '".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and ts.codigotipoasociaciondocente=d.codigotipoasociaciondocente");
			while($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$row["nombreasociaciondocente"]?></td>
					<td><?=$row["nombretipoasociaciondocente"]?></td>
					<td><?=$row["fechaingresoasociaciondocente"]?></td>
					<td><?=$row["fechaterminacionasociaciondocente"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
