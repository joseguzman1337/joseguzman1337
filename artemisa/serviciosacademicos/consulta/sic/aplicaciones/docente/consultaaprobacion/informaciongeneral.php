<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function muestrainformaciongeneral($objetobase,$formulario){
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=2;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			

			/*CONSULTA INFORMACION GENERAL DOCENTE*/
			$condicion=" and d.codigoestado like '1%'
					and t.tipodocumento=d.tipodocumento
					and g.codigogenero=d.codigogenero
					and e.idestadocivil=d.idestadocivil
					and c1.idciudad=d.idciudadresidencia
					";
			$tablas="documento t,genero g,estadocivil e,ciudad c1,docente d
				left join usuario u on u.numerodocumento=d.numerodocumento and codigotipousuario like '5%'";	
			$resultado=$objetobase->recuperar_resultado_tabla($tablas,"d.iddocente",$_SESSION['sissic_iddocente'],$condicion,",c1.nombreciudad nombreciudadresidencia",0);
			$row=$resultado->fetchRow();
			
			//$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			//print_r($_SESSION["codigofacultad"])
			if(!isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])==''){
				if($datosformulario["codigoestadodiligenciamiento"]=="200"){
					$checked="checked=true";
				}

				$titulo="<input type='checkbox' onclick='selapruebadocente(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			}
			else{			
				$titulo=strtoupper($datosformulario["nombreformulario"]);
			}

			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");	
		
				echo "<tr>";		
				echo "<td valign='top'>";
				/*MUESTRA INFORMACION GENERAL DOCENTE*/
				echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
					/*Fila 1*/
					unset($fila);
					$fila["Apellidos"]="";
					$fila["Nombres"]="";
					$fila["Tipo_Documento"]="";
					$fila["Documento"]="";			
					$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
					
					unset($fila);
					$fila[]=$row["apellidodocente"];
					$fila[]=$row["nombredocente"];
					$fila[]=$row["nombredocumento"];
					$fila[]=$row["numerodocumento"];			
					$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");



					/*Fila 2*/
					unset($fila);
					$fila["Genero"]="";
					$fila["Estado_Civil"]="";		
					$fila["Fecha_De_Nacimiento"]="";
					$fila["Edad"]="";
					$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
					
					unset($fila);
					$fila[]=$row["nombregenero"];
					$fila[]=$row["nombreestadocivil"];
					$fila[]=$row["fechanacimientodocente"];
					$edad=(int)(diferencia_fechas(formato_fecha_defecto($row["fechanacimientodocente"]),date("d/m/Y"),"meses",0)/12);	
					$fila[]=$edad;				
					$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");


					/*Fila 3*/
					unset($fila);
					$fila["Direccion_Residencia"]="";
					$fila["Ciudad_Residencia"]="";		
					$fila["Telefono_Residencia"]="";
					$fila["Celular"]="";
					$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
					
					unset($fila);
					$fila[]=$row["direcciondocente"];
					$fila[]=$row["nombreciudadresidencia"];
					$fila[]=$row["telefonoresidenciadocente"];	
					$fila[]=$row["numerocelulardocente"];				
					$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");

					/*Fila 4*/
					unset($fila);
					$fila["Numero de Tarjeta Profesional"]="";
					$fila["Fecha de Expedicion Tarjeta Profesional"]="";		
					$fila["Nombre Empresa Propia"]="";
					$fila["Fecha Primer Contrato"]="";
					$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
					
					unset($fila);
					$fila[]=$row["numerotarjetaprofesionaldocente"];
					$fila[]=$row["fechaexpediciotarjetaprofesionaldocente"];
					$fila[]=$row["nombreempresapropiadocente"];	
					$fila[]=$row["fechaprimercontratodocente"];				
					$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");

					/*Fila 5*/
					unset($fila);
					$fila["Correo_Personal"]="";
					$fila["Correo_Institucional"]="";		
					$fila["Usuario_Skype"]="";
					$fila["Perfil_Facebook"]="";
					$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
					
					unset($fila);
					$fila[]=$row["emaildocente"];
					$fila[]=$row["usuario"]."@unbosque.edu.co";
					$fila[]=$row["usuarioskypedocente"];	
					$fila[]=$row["perfilfacebookdocente"];				
					$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");

				echo "</table></td>";
				echo "<td valign='top'>";
				/*MUESTRA FOTO DOCENTE EN UNA TABLA A LA DERECHA*/
				echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

					unset($fila);
					$fila["Foto"]="";
			
					$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
					
					
					unset($fila);
					$rutaimagen="https://artemisa.unbosque.edu.co/imagenes/estudiantes/".$row["numerodocumento"].".jpg";
					//$rutaimagen="../../../../../../imagenes/estudiantes/".$row["numerodocumento"];
					$imagen="<img id='imagendocente' name='imagendocente' src=".$rutaimagen." width='90' height='120'/>";
					$fila[$imagen]="";
					$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");
			
				echo "</table></td></tr>";
				
		echo " </table>";
}
?>
