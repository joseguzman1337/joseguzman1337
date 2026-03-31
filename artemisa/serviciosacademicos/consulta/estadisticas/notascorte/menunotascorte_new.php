<?php 
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>

<script>
	function VentanaOpen(periodo,codigomateria,columna,codigocarrera,titulo){
		/*	getemail=dhtmlmodal.open('newsletterbox', 'ajax', 'listadodetallenotascortes.php?link_origen=listadonotascorte.php&codigomateria='+codigomateria+'&&codigoperiodo='+periodo+'&columna='+columna+'&codigocarrera='+codigocarrera+'&Div=0', titulo, 'width=1500px, height=600px, left=50,right=0, resize=0,top=50%,overflow:scroll,overflow-x:scroll'); return false;*/
			
		/********************************************************/
		 var url  = 'listadodetallenotascortes.php?link_origen=listadonotascorte.php&codigomateria='+codigomateria+'&&codigoperiodo='+periodo+'&columna='+columna+'&codigocarrera='+codigocarrera+'&Div=0';
			 var centerWidth = (window.screen.width - 850) / 2;
			 var centerHeight = (window.screen.height - 700) / 2;
	   
			 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1500px, height=600px, top="+centerHeight+", left="+centerWidth;
			 var mypopup = window.open(url,"",opciones);
			 //para poner la ventana en frente
			 window.focus();
			 mypopup.focus();
		/********************************************************/
		}
	
	function VentanaOpenDif(periodo,codigomateria,columna,codigocarrera,titulo){
			/*getemail=dhtmlmodal.open('newsletterbox', 'ajax', 'listadodetallegruposmaterias.php?link_origen=listadonotascorte.php&codigomateria='+codigomateria+'&&codigoperiodo='+periodo+'&columna='+columna+'&codigocarrera='+codigocarrera+'&Div=0', titulo, 'width=1500px, height=600px, left=50,right=0, resize=0,top=50%,overflow:scroll,overflow-x:scroll'); return false;*/
		/********************************************************/
		 var url  = 'listadodetallegruposmaterias.php?link_origen=listadonotascorte.php&codigomateria='+codigomateria+'&&codigoperiodo='+periodo+'&columna='+columna+'&codigocarrera='+codigocarrera+'&Div=0';
			 var centerWidth = (window.screen.width - 850) / 2;
			 var centerHeight = (window.screen.height - 700) / 2;
	   
			 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1500px, height=600px, top="+centerHeight+", left="+centerWidth;
			 var mypopup = window.open(url,"",opciones);
			 //para poner la ventana en frente
			 window.focus();
			 mypopup.focus();
		/********************************************************/
		}
</script>



<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo '../matriculas/menu.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo '../matriculas/menu.php';?>";
}
function enviarmenu()
{
form1.action="";
form1.submit();
}
</script>
  
<script>
	
	/****************************************************************/
	
	/**************************************************************/
    function ResetModalidad(){
				$('#Modalidad').val('');   
				$('#id_modalidad').val('');
			}
		function ResetCarrera(){
				$('#carrera').val('');
				$('#codigocarrera').val('');
			}
		function autoCompleModalidad(){
			/********************************************************/	
				$('#Modalidad').autocomplete({
						
						source: "../../../men/Reportes/EstudiantesRiesgo/Reporte_EstudianteRiesgo.html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_modalidad').val(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
			}
		function autoCompleteCarrera(){
			/********************************************************/	
			
			var id_modalidad = $('#id_modalidad').val();
			
			if(!$.trim(id_modalidad)){
					alert('Primero debe Buscar y Selecionar una Modalidad');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
			
				$('#carrera').autocomplete({
						
						source: "../../../men/Reportes/EstudiantesRiesgo/Reporte_EstudianteRiesgo.html.php?actionID=autoCompleteCarrera&id_Movilidad="+id_modalidad,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#codigocarrera').val(ui.item.id_carrera);
							
							}
						
					});//
			/********************************************************/
			}
		function Activar(){
				
				if($('#TodasCarreras').is(':checked')){
						$('#carrera').val('');
						$('#codigocarrera').val('');
						$('#carrera').attr('disabled',true);
					}else{
							$('#carrera').attr('disabled',false);
						}
				
			}
			
	function ValidarDatos(){
			
			var id_modalidad = $('#id_modalidad').val();
			
			if(!$.trim(id_modalidad)){
					alert('Primero debe Buscar y Selecionar una Modalidad');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
		
			var id_carrera		= $('#codigocarrera').val();
				
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')){
								var id_carrera = 0;
							}
					}
					
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')==false){
								alert('Indique que carrera ');
								$('#TodasCarreras').css('border-color','#F00');
					    		$('#TodasCarreras').effect("pulsate", {times:3}, 500);
								$('#carrera').css('border-color','#F00');
					    		$('#carrera').effect("pulsate", {times:3}, 500);
								return false;
							}
					}	
					
				var Periodo			= $('#Periodo').val();	
				
				if(Periodo==-1 || Periodo=='-1'){
						alert('Selecione un Periodo');
						$('#Periodo').css('border-color','#F00');
					    $('#Periodo').effect("pulsate", {times:3}, 500);
						return false;
					}
					
			var id_Materia  = $('#id_Materia').val();
			
			if(!$.trim(id_carrera)){
				if($('#TodasCarreras').is(':checked')==false){
						alert('Primero debe Buscar y Selecionar un Programa o Carrera');
						$('#carrera').effect("pulsate", {times:3}, 500);
						return false;
				   }
				}
			
			
			
		//	alert('id_Materia->'+id_Materia)
			/*************************************************************/
				
				//$('#ReporteRiesgo').submit();
				
				//alert('Periodo'+Periodo+'\n semestre'+Semestre+'\n riesgo'+Riesgo+'\n codigocarrera'+id_carrera);
				
				$('#DivReporte').html('<blink>Cargando...</blink>');
				
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'listadonotacorte_new.php',
					  async: false,
					  //dataType: 'json',
					  data:({codigoperiodo:Periodo,
						     codigomodalidadacademica:id_modalidad,
						     codigocarrera:id_carrera,
							 codigomateria:id_Materia}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#DivReporte').html(data);
				   },
				}); //AJAX
				
			/***********************************************************/
				
			
			
		}	
	function autoCompleteMateria(){
			/****************************************************/
			
			var id_carrera = $('#codigocarrera').val();
			
			if(!$.trim(id_carrera)){
				if($('#TodasCarreras').is(':checked')==false){
						alert('Primero debe Buscar y Selecionar un Programa o Carrera');
						$('#carrera').effect("pulsate", {times:3}, 500);
						return false;
				   }
				}
			//
				$('#Materia').autocomplete({
						
						source: "../../../men/Reportes/EstudiantesRiesgo/Reporte_EstudianteRiesgo.html.php?actionID=autoCompleteMateria&id_carrera="+id_carrera,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Materia').val(ui.item.id_Materia);
							
							}
						
					});//
			
			//**************************************************/
			}
		function ResetMateria(){
				$('#Materia').val('');
				$('#id_Materia').val('');
			}	
		function ActivarMateria(){
				
				if($('#TodasMaterias').is(':checked')){
						$('#Materia').val('');
						$('#id_Materia').val(0);
						$('#Materia').attr('disabled',true);
					}else{
							$('#Materia').attr('disabled',false);
							$('#id_Materia').val('');
						}
				
			}			
</script>			    
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

include('../../../men/templates/MenuReportes.php');

global $userid,$db;

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');

?>
<fieldset style="width:98%;">
	<form name="form1" action="riesgossemestredetalle.php" method="post" id="ReporteRiesgo">
    	<input type="hidden" name="AnularOK" value="">
        	<legend>ESTADISTICAS CORTES DE NOTAS</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad()" /><input type="hidden" id="id_modalidad" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td><strong>Carrera</strong></td>
                        <td><input type="text"  id="carrera" name="carrera" autocomplete="off" placeholder="Digite la Carrera" style="text-align:center;width:90%;" size="70" onClick="ResetCarrera();" onkeypress="autoCompleteCarrera()" /><input type="hidden" id="codigocarrera" name="codigocarrera"  />&nbsp;&nbsp;<!--<strong>Todas</strong><input type="checkbox" id="TodasCarreras" onclick="Activar()" title="Todas las Carreras" />--></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong>Materia</strong></td>
                        <td><input type="text"  id="Materia" name="Materia" autocomplete="off" placeholder="Digite el Nombre o Codigo de la Materia" style="text-align:center;width:90%;" size="70" onClick="ResetMateria();" onkeypress="autoCompleteMateria()" /><input type="hidden" id="id_Materia"  />&nbsp;&nbsp;<strong>Todas</strong><input type="checkbox" id="TodasMaterias" onclick="ActivarMateria()" title="Todas las Materias" /></td>
                        <td>&nbsp;</td>
                    </tr>
                 	<tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td><strong>Periodo</strong></td>
                        <td><?PHP Periodo();?></td>
                       <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="4" align="center"><input type="button" id="Buscar" onclick="ValidarDatos()" value="Buscar" style="cursor:pointer" /></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="DivReporte" align="center" style="width:100%; height:500;" ></div>
                        </td>
                    </tr>
                </table>
    </form>
</fieldset>
<br /><br />

<?PHP

/*********************************************************************/

function Periodo(){
		
		include('../../../men/templates/MenuReportes.php');

		global $userid,$db;
		
	
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			
			?>
            <select id="Periodo" name="Periodo" style="text-align:center">
            	<option value="-1">Selecionar</option>
                <?PHP 
					while(!$Periodo->EOF){
						?>
                        <option value="<?PHP echo $Periodo->fields['codigoperiodo']?>"><?PHP echo $Periodo->fields['codigoperiodo']?></option>
                        <?PHP	
						$Periodo->MoveNext();
					}
				?>    
            </select>
            <?PHP	
		}


/*********************************************************************/



/*echo "<form name=\"form1\" action=\"listadonotascorte.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

 	$formulario->dibujar_fila_titulo('ESTADISTICAS  CORTES DE NOTAS','labelresaltado',"2","align='center'");
	
	
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica f","codigomodalidadacademica","nombremodalidadacademica","");
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','');

	//$codigofacultad="05";
	$condicion="c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
				order by c.nombrecarrera";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion,'',0);
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','');


	$condicion="m.codigocarrera='".$_POST['codigocarrera']."'
				and m.codigoestadomateria like '01'
				order by m.nombremateria";	
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("materia m","m.codigomateria","m.nombremateria",$condicion,'',0);
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigomateria','".$_POST['codigomateria']."',''";
	$formulario->dibujar_campo($campo,$parametros,"Materia","tdtitulogris",'codigomateria','');

	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_POST['codigoperiodo']))
	$codigoperiodo=$_POST['codigoperiodo'];
	if(isset($_GET['codigoperiodo']))
	$codigoperiodo=$_GET['codigoperiodo'];	
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');


	
	
	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
*/?>