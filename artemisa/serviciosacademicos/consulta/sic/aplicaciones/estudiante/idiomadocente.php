<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function idiomadocente($formulario,$objetobase)
{
	echo "<form name=\"formidioma\" id=\"formidioma\" action=\"\" method=\"post\"  >
	<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"780\">";
	
	
		$usuario=$formulario->datos_usuario();
	
	$condicion=" and codigoestado like '1%'";
		$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",8,$condicion,"",0);
		
	$formulario->dibujar_fila_titulo(strtoupper($datosformulario["nombreformulario"]),'labelresaltado',"2","align='center'");	
	
	$formulario->dibujar_fila_titulo($datosformulario["descripcionformulario"],'tdtituloencuestadescripcion',"2","align='left'","td");
	
	if(isset($_GET["ididiomadocente"])&&trim($_GET["ididiomadocente"])!=''){
	$datosidiomadocente=$objetobase->recuperar_datos_tabla("idiomadocente d","d.ididiomadocente",$_GET['ididiomadocente'],$condicion,"",0);
		$ididioma=$datosidiomadocente["ididioma"];
	
	$resultado=$objetobase->recuperar_resultado_tabla("detalleidiomadocente d","d.ididiomadocente",$datosidiomadocente['ididiomadocente'],$condicion,"",0);
	
	while($rowrecuperaidioma=$resultado->fetchRow()){	
		$nivelidioma[$rowrecuperaidioma["idtipomanejoidioma"]]=$rowrecuperaidioma["idindicadornivelidioma"];
	}
	
	}
	else{
	
	$ididioma=$_POST["ididioma"];
	$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100","","",0);
	while($rowrecuperaidioma=$resultadotipomanejo->fetchRow()){
	
		$nivelidioma[$rowrecuperaidioma["idtipomanejoidioma"]]=$_POST["nivelidioma".$rowmanejo["idtipomanejoidioma"]];
	}
	
	}
	
	
		echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
	
	
	
			$fila["Codigo"]="";
			$fila["Idioma"]="";
			$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100"," order by idtipomanejoidioma","",0);
			while($rowmanejo=$resultadotipomanejo->fetchRow()){
				$fila[$rowmanejo["nombrecortotipomanejoidioma"]]="";
			}
	
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
	
		$condicion=" and d.codigoestado like '1%'
			and i.ididioma=d.ididioma";	
		$resultado=$objetobase->recuperar_resultado_tabla("idiomadocente d,idioma i","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
			
		while($row=$resultado->fetchRow()){
			unset($fila);
			$enlacedetalle="<a href='nivelacademicodocente.php?codigotipoformacion=400&ididiomadocente=".$row["ididiomadocente"]."&idformulario=".$_GET["idformulario"]."'>".$row["ididiomadocente"]."</a>";
			$fila[]=$enlacedetalle;
			$fila[]=$row["nombreidioma"];
				$condicion=" left join detalleidiomadocente dt on tm.idtipomanejoidioma=dt.idtipomanejoidioma
				and dt.codigoestado like '1%'
				and dt.ididiomadocente=	".$row['ididiomadocente']."
				left join  indicadornivelidioma i				
				on i.idindicadornivelidioma=dt.idindicadornivelidioma
				";	
				$resultadodeatalle=$objetobase->recuperar_resultado_tabla("tipomanejoidioma tm    ".$condicion,"1","1"," order by tm.idtipomanejoidioma","",0);
				while($rowdetalle=$resultadodeatalle->fetchRow()){			
					$fila[]=$rowdetalle["nombreindicadornivelidioma"];
				}
	
				
	
			$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
			
		}	
		$colspantotal=4 * count($fila);
	//	echo "<tr><td align='center' colspan='".$colspantotal."'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";
	echo "<tr><td align='center' colspan='".$colspantotal."'><input type='button' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro' onclick='enviarnivelacademico(400)'/> </td></tr>";	
		echo "</table></td><tr>";	
	
	
	$muestraformulario=0;
	if($_REQUEST["Enviar"]){
	$muestraformulario=1;
	}
	
	
	if($_REQUEST["Nuevo_Registro"]){
	$muestraformulario=1;
	//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$_GET["ididiomadocente"]."</h1>";
	
		if(isset($_GET["ididiomadocente"])&&trim($_GET["ididiomadocente"])!=''){
			unset($_POST);
			unset($_GET["ididiomadocente"]);
			unset($_REQUEST["Anulado"]);
			unset($ididioma);
			unset($nivelidioma);
		}
	
	$_REQUEST["Nuevo_Registro"]=1;
	}
	
	if(isset($_GET["ididiomadocente"])&&trim($_GET["ididiomadocente"])!=''){
	$muestraformulario=1;
	//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
	}
	if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("idiomadocente","ididiomadocente",$_GET["ididiomadocente"],"","",0)){
	if($datosdedicacionexterna["codigoestado"]=="200"){
		$muestraformulario=0;
			//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
		}
	
	}
	if($_REQUEST["Anulado"]){
	$muestraformulario=0;
	//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}
	
	
	if($muestraformulario){
	
		$condicion=" 1=1 order by nombreidioma";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("idioma d","ididioma","nombreidioma",$condicion,'',0);
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'ididioma','".$ididioma."',''";
		$formulario->dibujar_campo($campo,$parametros,"Idioma ","tdtitulogris",'ididioma','requerido');
	
		$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100","","",0);
	
	
	
		while($rowmanejo=$resultadotipomanejo->fetchRow()){
			
		$condicion=" codigoestado='100' order by nombreindicadornivelidioma";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("indicadornivelidioma d","idindicadornivelidioma","nombreindicadornivelidioma",$condicion,'',0);
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'nivelidioma".$rowmanejo["idtipomanejoidioma"]."','".$nivelidioma[$rowmanejo["idtipomanejoidioma"]]."',''";
		$formulario->dibujar_campo($campo,$parametros,$rowmanejo["nombretipomanejoidioma"],"tdtitulogris","nivelidioma".$rowmanejo["idtipomanejoidioma"],'requerido');
	
		}	
	}
	if(isset($_GET["ididiomadocente"])&&trim($_GET["ididiomadocente"])!=''){
	
	$conboton=0;
	$parametrobotonenviarv[$conboton]="'submit','Modificar_Idioma','Modificar'";
								$botonv[$conboton]='boton_tipo';
								$conboton++;
	$parametrobotonenviarv[$conboton]="'submit','Anular_Idioma','Anular'";
								$botonv[$conboton]='boton_tipo';
								$conboton++;
	
	}
	else{
	
	$conboton=0;
	$parametrobotonenviarv[$conboton]="'submit','Enviar_Idioma','Enviar'";
								$botonv[$conboton]='boton_tipo';
								$conboton++;
	
	
	
	}
	$formulario->dibujar_campos($botonv,$parametrobotonenviarv,"Enviar","tdtitulogris",'Enviar');
	
		if($_POST["Modificar_Idioma"]){
	
	
				unset($fila);
				$tabla="idiomadocente";
				$fila["ididioma"]=$_POST["ididioma"];
				$fila["iddocente"]=$_SESSION['sissic_iddocente'];
				$fila["codigoestado"]="100";
				$condicionactualiza=" ididiomadocente=".$_GET["ididiomadocente"];
	
					
				//echo "<h1>Entro4</h1>";
				//echo "<pre>";
				//print_r($fila);
				$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
				//echo "<pre>";
				//echo "<h1>Entro3</h1>";
				$condicion=" and ididioma=".$fila["ididioma"];
				$datosultimoidioma=$objetobase->recuperar_datos_tabla("idiomadocente d","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				
				
	
				$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100"," order by idtipomanejoidioma","",0);
				while($rowmanejo=$resultadotipomanejo->fetchRow()){
					unset($filadetalle);
					$tabladetalle="detalleidiomadocente";
					$filadetalle["idtipomanejoidioma"]=$rowmanejo["idtipomanejoidioma"];
					$filadetalle["idindicadornivelidioma"]=$_POST["nivelidioma".$rowmanejo["idtipomanejoidioma"]];
					$filadetalle["ididiomadocente"]=$datosultimoidioma["ididiomadocente"];
					$filadetalle["codigoestado"]="100";
				
					$condicionactualizadetalle=" ididiomadocente ='".$filadetalle["ididiomadocente"]."'
						and idtipomanejoidioma='".$filadetalle["idtipomanejoidioma"]."'";
					//echo "<pre>";
					$objetobase->insertar_fila_bd($tabladetalle,$filadetalle,0,$condicionactualizadetalle);
					//echo "<pre>";				
				}		
	
	
	
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
		echo "<script type='text/javascript'>	
			window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
		</script>";
	
		}
	
		if($_POST["Enviar_Idioma"]){
			if($formulario->valida_formulario()){
				unset($fila);
				$tabla="idiomadocente";
				$fila["ididioma"]=$_POST["ididioma"];
				$fila["iddocente"]=$_SESSION['sissic_iddocente'];
				$fila["codigoestado"]="100";
				$condicionactualiza=" iddocente ='".$fila["iddocente"]."'
					and ididioma='".$fila["ididioma"]."'";
	
					
				//echo "<h1>Entro4</h1>";
				//echo "<pre>";
				//print_r($fila);
				$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
				//echo "<pre>";
				//echo "<h1>Entro3</h1>";
				$condicion=" and ididioma=".$fila["ididioma"];
				$datosultimoidioma=$objetobase->recuperar_datos_tabla("idiomadocente d","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				
				
	
				$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100"," order by idtipomanejoidioma","",0);
				while($rowmanejo=$resultadotipomanejo->fetchRow()){
					unset($filadetalle);
					$tabladetalle="detalleidiomadocente";
					$filadetalle["idtipomanejoidioma"]=$rowmanejo["idtipomanejoidioma"];
					$filadetalle["idindicadornivelidioma"]=$_POST["nivelidioma".$rowmanejo["idtipomanejoidioma"]];
					$filadetalle["ididiomadocente"]=$datosultimoidioma["ididiomadocente"];
					$filadetalle["codigoestado"]="100";
				
					$condicionactualizadetalle=" ididiomadocente ='".$filadetalle["ididiomadocente"]."'
						and idtipomanejoidioma='".$filadetalle["idtipomanejoidioma"]."'";
					//echo "<pre>";
					$objetobase->insertar_fila_bd($tabladetalle,$filadetalle,0,$condicionactualizadetalle);
					//echo "<pre>";				
				}		
		
				
	
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
			echo "<script type='text/javascript'>	
				window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
			</script>";
			}
	
		}
		if($_POST["Anular_Idioma"]){
	
				unset($fila);
				$tabla="idiomadocente";
				$fila["ididioma"]=$_POST["ididioma"];
				$fila["codigoestado"]="200";
				$condicionactualiza=" ididiomadocente=".$_GET["ididiomadocente"];
	
					
				//echo "<h1>Entro4</h1>";
				//echo "<pre>";
				//print_r($fila);
				$objetobase->insertar_fila_bd($tabla,$fila,1,$condicionactualiza);
				//echo "<pre>";
				//echo "<h1>Entro3</h1>";
				$condicion=" and ididioma=".$fila["ididioma"];
				$datosultimoidioma=$objetobase->recuperar_datos_tabla("idiomadocente d","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				
				
	
				$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100"," order by idtipomanejoidioma","",0);
				while($rowmanejo=$resultadotipomanejo->fetchRow()){
				
					unset($filadetalle);
					$tabladetalle="detalleidiomadocente";
					$filadetalle["codigoestado"]="200";		
					$condicionactualizadetalle="";
					//echo "<pre>";
					$objetobase->actualizar_fila_bd($tabladetalle,$filadetalle,"ididiomadocente",$datosultimoidioma["ididiomadocente"],$condicionactualizadetalle,0);
					//echo "<pre>";				
				}
		
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."&Anulado=1'>";
		}
	
	echo "</table>"; 
	echo "</form>"; 
}
?>
