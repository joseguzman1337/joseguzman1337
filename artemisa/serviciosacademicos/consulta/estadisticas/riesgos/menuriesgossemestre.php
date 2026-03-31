<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

switch($_REQUEST['actionID']){
	case 'ListadoCarreras';{
		include('../../../men/templates/MenuReportes.php');

		global $userid,$db;
		
		ListadoCarreras($_POST['id_modalidad']);
		}exit;
	}
unset($_SESSION['codigomateriariesgo']);
unset($_SESSION['codigomodalidadacademicariesgo']);
unset($_SESSION['codigocarrerariesgo']);
unset($_SESSION['codigoperiodoriesgo']);

$tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : '';
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo '../matriculas/menu.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo '../matriculas/menu.php'; ?>";
    }
    function enviarmenu()
    {
        form1.action="";
        form1.submit();
    }
</script>
<?php
$rutaado = ("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
include('../../../men/templates/MenuReportes.php');

global $userid,$db;

$objetobase = new BaseDeDatosGeneral($sala);

$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');
?>
<fieldset style="width:98%;">
	<form name="form1" action="riesgossemestredetalle.php" method="post" id="ReporteRiesgo">
    	<input type="hidden" name="AnularOK" value="">
        <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
        	<legend>Listado De Estudiantes En Riesgo Por Semestre</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad()" /><input type="hidden" id="id_modalidad" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo</strong></td>
                        <td><?PHP Periodo()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Programa Académico</strong></td>
                        <td>
                        <input type="button" id="VerCarreras" name="VerCarreras" value="Ver Carreras" onclick="BuscarCarreras()" disabled="disabled" /><input type="hidden" id="CadenaCarrera" />
                        <fieldset style="width:90%;display:none" id="Borde">
                        <div id="ListaCarreras"></div>
                        </fieldset>
                        <td>&nbsp;</td>
                        <td><strong>Semestre</strong></td>
                        <td><input type="hidden" id="semestre" name="semestre" /><?PHP Semestre()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td><strong>Riesgo</strong></td>
                        <td><?PHP Riesgo()?></td>
                    </tr>
                 	<tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="5" align="center"><input type="button" id="Buscar" onclick="ValidarDatos()" value="Buscar" style="cursor:pointer" /></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div id="DivReporte" align="center" style="width:100%; height:500;" ></div>
                        </td>
                    </tr>
                </table>
    </form>
</fieldset>
<br /><br />
<!--<form name="form1" action="riesgossemestredetalle.php" method="post">
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">-->
        <?php
        /*$formulario->dibujar_fila_titulo('ESTADISTICAS RIESGOS', 'labelresaltado', "2", "align='center'");


        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("modalidadacademica f", "codigomodalidadacademica", "nombremodalidadacademica", "");
        //$formulario->filatmp["todos"]="*Todos*";
        $formulario->filatmp[""] = "Seleccionar";
        $campo = 'menu_fila';
        $parametros = "'codigomodalidadacademica','" . $_POST['codigomodalidadacademica'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Modalidad Academica", "tdtitulogris", 'codigomodalidadacademica', '');

        //$codigofacultad="05";
        $condicion = "c.codigomodalidadacademica='" . $_POST['codigomodalidadacademica'] . "'
				order by c.nombrecarrera";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion, '', 0);
        $formulario->filatmp["todos"] = "*Todos*";
        $formulario->filatmp[""] = "Seleccionar";
        $campo = 'menu_fila';
        $parametros = "'codigocarrera','" . $_POST['codigocarrera'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Carrera", "tdtitulogris", 'codigocarrera', '');

        $formulario->filatmp["Alto"] = "Alto";
        $formulario->filatmp["Medio"] = "Medio";
        $formulario->filatmp["Bajo"] = "Bajo";
        $formulario->filatmp["Sin Riesgo"] = "Sin Riesgo";
        $campo = 'menu_fila';
        $parametros = "'riesgo','" . $_POST['riesgo'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Riesgo", "tdtitulogris", 'riesgo', '');
        
        unset($formulario->filatmp);
        for ($i = 1; $i < 13; $i++) {
            $formulario->filatmp[$i] = $i;
        }
        $campo = 'menu_fila';
        $parametros = "'semestre','" . $_POST['semestre'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Semestre", "tdtitulogris", 'semestre', '');

        $conboton = 0;
        $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',''";
        $boton[$conboton] = 'boton_tipo';
        $conboton++;
        $parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
        $boton[$conboton] = 'boton_tipo';
        $conboton++;
        $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');*/
        ?>
<?PHP 

function Periodo(){
		
		include('../../../men/templates/MenuReportes.php');

		global $userid,$db;
			
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodo" name="Periodo" style="width:100%; text-align:center">
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

 function Semestre(){
		
		include('../../../men/templates/MenuReportes.php');

		global $userid,$db;
		
		?>
        <div id="Div_Semestre" style="overflow:scroll;width:100%;height:50;overflow-x:hidden;">
        <table align="center" border="0">
            <?PHP
		for($i=1;$i<13;$i++){
			/**********************************/
			?>
            <tr id="TrS_<?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'TrS_')" onmouseout="SinSombra(<?PHP echo $i?>,'TrS_')" style="cursor:pointer">
            	<th><?PHP echo $i?></th>
                <td><input type="checkbox" id="Semestre_<?PHP echo $i?>" name="Semestre_<?PHP echo $i?>" onclick="addItem(<?PHP echo $i?>,'CodigoSemestre_','semestre','Semestre_')" class="CheckSemestre" /><input type="hidden" id="CodigoSemestre_<?PHP echo $i?>" value="<?PHP echo $i?>" /></td>
            </tr>
            <?PHP
			/**********************************/
			}   
			?>
            <tr id="TrS_<?PHP echo $i=0?>" onmouseover="Sombra(<?PHP echo $i=0?>,'TrS_')" onmouseout="SinSombra(<?PHP echo $i=0?>,'TrS_')" style="cursor:pointer">
            	<th>Todos</th>
                <td><input type="checkbox" id="TodosSemestre" onclick="Inactivar('TodosSemestre','CheckSemestre','semestre')" title="Todas los Semestres" /></td>
            </tr>
            </table>
            </div>
            <?PHP
		}
	function Riesgo(){
		
		include('../../../men/templates/MenuReportes.php');

		global $userid,$db;
		
		?>
        <select id="riesgo" name="riesgo" style="text-align:center">
        	<option value="-1">Seleccionar</option>
            <option value="1">Alto</option>
            <option value="2">Medio</option>
            <option value="3">Bajo</option>
            <option value="0">Sin Riesgo</option>
        </select>
		<?PHP
		}		
	function ListadoCarreras($id_Modalidad){
			global $db,$userid;
			
			  $SQL='SELECT 

					codigocarrera,
					nombrecarrera
					
					FROM 
					
					carrera
					
					WHERE
					
					codigomodalidadacademica="'.$id_Modalidad.'"
					AND
					codigocarrera NOT IN (1,2)
					
					ORDER BY nombrecarrera ASC';
					
			if($ListaCarreras=&$db->Execute($SQL)===false){
					echo 'Error en el SQL <br><br>'.$SQL;
					die;
				}	
			
			
			?>
            <table align="center" width="100%" cellpadding="0" cellspacing="0">
                <?PHP 
                if(!$ListaCarreras->EOF){
                    $i=1;
                    while(!$ListaCarreras->EOF){
                        ?>
                        <tr id="Tr_<?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'Tr_')" onmouseout="SinSombra(<?PHP echo $i?>,'Tr_')" style="cursor:pointer">
                            <td><?PHP echo $ListaCarreras->fields['nombrecarrera']?></td>
                            <td><input type="checkbox" id="CheckCarrera_<?PHP echo $i?>" class="ChkCarrera" onclick="addItem(<?PHP echo $i?>,'CodigoCarrera_','CadenaCarrera','CheckCarrera_')" /><input type="hidden" id="CodigoCarrera_<?PHP echo $i?>" value="<?PHP echo $ListaCarreras->fields['codigocarrera']?>"  /></td>
                        </tr>
                        <?PHP
                        $i++;
                        $ListaCarreras->MoveNext();
                        }
						?>
                        <tr>
                        	<td><strong>Todas</strong></td>
                            <td><input type="checkbox" id="TodasCarreras" onclick="Inactivar('TodasCarreras','ChkCarrera','CadenaCarrera')" title="Todas las Carreras" /></td>
                        </tr>
                        <?PHP	
                    }else{
                        ?>
                        <tr>
                            <td colspan="2"><span style="color:#999">No Hay Informaci&oacute;n...</span></td>
                        </tr>
                        <?PHP
                        }
                ?>
            </table>
            <?PHP
		}
?>
   <script>
	
	
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
							$('#VerCarreras').attr('disabled',false);
							
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
						$('#carreraOtra').val('');
						$('#codigocarreraOtra').val('');
						$('#carreraOtra').attr('disabled',true);
					}else{
							$('#carrera').attr('disabled',false);
							$('#carreraOtra').attr('disabled',false);
						}
				
			}
			
	function ValidarDatos(){
			var CadenaCarrera		= $('#CadenaCarrera').val();
				
				if(!$.trim(CadenaCarrera)){
						if($('#TodasCarreras').is(':checked')){
								var CadenaCarrera = 0;
							}
					}
					
				if(!$.trim(CadenaCarrera)){
						if($('#TodasCarreras').is(':checked')==false){
								alert('Indique que Programa Academico ');
								$('#TodasCarreras').css('border-color','#F00');
					    		$('#TodasCarreras').effect("pulsate", {times:3}, 500);
								$('.ChkCarrera').css('border-color','#F00');
					    		$('.ChkCarrera').effect("pulsate", {times:3}, 500);
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
					
					
				var Semestre = $('#semestre').val();	
				
				if(!$.trim(Semestre)){
						if($('#TodosSemestre').is(':checked')){
								var Semestre = 0;
							}
					}
				
				if(!$.trim(Semestre)){
						alert('Seleccione el Semestre');
						$('.CheckSemestre').css('border-color','#F00');
					    $('.CheckSemestre').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				var Riesgo	= $('#riesgo').val();	
				
				if(Riesgo==-1 || Riesgo=='-1'){
						alert('Seleccione el Riesgo');
						$('#riesgo').css('border-color','#F00');
					    $('#riesgo').effect("pulsate", {times:3}, 500);
						return false;
					}
				
				//var codigocarreraOtra = $('#codigocarreraOtra').val();	
			/*************************************************************/
				
				//$('#ReporteRiesgo').submit();
				
				//alert('Periodo'+Periodo+'\n semestre'+Semestre+'\n riesgo'+Riesgo+'\n codigocarrera'+id_carrera);
				var tipo=$("#tipo").val();
                               //  alert(tipo)
				$('#DivReporte').html('<blink>Cargando...</blink>');
				
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'riesgossemestredetalle.php',
					  async: false,
					  //dataType: 'json',
					  data:({Periodo:Periodo,
						     semestre:Semestre,
						     riesgo:Riesgo,
                                                     tipo:tipo,
						     codigocarrera:CadenaCarrera}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#DivReporte').html(data);
				   },
				}); //AJAX
				
			/***********************************************************/
				
		}		
	function ResetCarreraOtra(){
			$('#carreraOtra').val('');
			$('#codigocarreraOtra').val('');
		}	
	function autoCompleteCarreraOtra(){
			/********************************************************/	
			
			var id_modalidad = $('#id_modalidad').val();
			
			if(!$.trim(id_modalidad)){
					alert('Primero debe Buscar y Selecionar una Modalidad');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			var Carrera  = $('#codigocarrera').val();	
			
			if(!$.trim(Carrera)){
					alert('Primero debe Buscar El Primer Periodo Academico');
					$('#carrera').effect("pulsate", {times:3}, 500);
					return false;
				}
			
				$('#carreraOtra').autocomplete({
						
						source: "../../../men/Reportes/EstudiantesRiesgo/Reporte_EstudianteRiesgo.html.php?actionID=autoCompleteCarreraOtra&id_Movilidad="+id_modalidad+'&CarreraOtra='+Carrera,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#codigocarreraOtra').val(ui.item.id_carreraOtra);
							
							}
						
					});//
			/********************************************************/
			}	
	function BuscarCarreras(){
		var id_modalidad	= $('#id_modalidad').val();
		/********************************************/
			$.ajax({//Ajax
				  type: 'POST',
				  url: 'menuriesgossemestre.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'ListadoCarreras',
				 		id_modalidad:id_modalidad}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
					 /*style="overflow:scroll;width:100%;height:100;overflow-x:hidden;" */
					    $('#VerCarreras').attr('disabled',true);
					 	$('#Borde').css('display','inline');
					 	$('#ListaCarreras').css('overflow','scroll');
						$('#ListaCarreras').css('width','100%');
						$('#ListaCarreras').css('height','100');
						$('#ListaCarreras').css('overflow-x','hidden');
						$('#ListaCarreras').html(data);
						
			   },
			}); //AJAX
		/**************************************/	
		}	
	function Sombra(i,id){
		/*************************/
		$('#'+id+i).css('background-color','#CCC');
		/*************************/
		}	
	function SinSombra(i,id){
		/*************************/
		$('#'+id+i).css('background-color','#FFF');
		/*************************/
		}	
	function Inactivar(Todas,Class,Cadena){
		/****************************************/	
		if($('#'+Todas).is(':checked')){
				$('.'+Class).attr('checked',false);
				$('.'+Class).attr('disabled',true);
				$('#'+Cadena).val('');
			}else{
					$('.'+Class).attr('disabled',false);
				}
		/****************************************/
		}
	function addItem(i,codigo,cadena,Chekc){
		/***************************************************************/
		var Carrera = $('#'+codigo+i).val();
		if($('#'+Chekc+i).is(':checked')){
			/*******************************************/
			$('#'+cadena).val($('#'+cadena).val()+'::'+Carrera);
			/*******************************************/
			}else{
				/**************************************************/
				var Dato = '::'+Carrera;
				
				var Cadena_Actual	= $('#'+cadena).val();
				var CadenaNew		= Cadena_Actual.replace(Dato,'');
				 
				 $('#'+cadena).val(CadenaNew); 
				/**************************************************/
				}
		/***************************************************************/
		}			
</script>			