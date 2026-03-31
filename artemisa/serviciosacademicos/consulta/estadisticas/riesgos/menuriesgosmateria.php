<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

unset($_SESSION['codigomateriariesgo']);
unset($_SESSION['codigomodalidadacademicariesgo']);
unset($_SESSION['codigocarrerariesgo']);
unset($_SESSION['codigoperiodoriesgo']);
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
        	<legend>Listado De Estudiantes En Riesgo Por Materia</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad()" /><input type="hidden" id="id_modalidad" /></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Carrera</strong></td>
                        <td><input type="text"  id="carrera" name="carrera" autocomplete="off" placeholder="Digite la Carrera" style="text-align:center;width:90%;" size="70" onClick="ResetCarrera();" onkeypress="autoCompleteCarrera()" /><input type="hidden" id="codigocarrera" name="codigocarrera"  />&nbsp;&nbsp;<!--<strong>Todas</strong><input type="checkbox" id="TodasCarreras" onclick="Activar()" title="Todas las Carreras" />--></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Materia</strong></td>
                        <td><input type="text"  id="materia" name="materia" autocomplete="off" placeholder="Digite la Materia" style="text-align:center;width:90%;" size="70" onClick="ResetMateria();" onkeypress="autoCompleteMateria()" /><input type="hidden" id="codigomateria" name="codigomateria"  />&nbsp;&nbsp;<!--<strong>Todas</strong><input type="checkbox" id="TodasMaterias" onclick="Activar()" title="Todas las Materias" />--></td>
                        <td>Todas las Materias</td>
                        <td><input type="checkbox" name="tmaterias" id="tmaterias" value="1" ></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Periodo</strong></td>
                        <td><?PHP Periodo()?></td>
                        <th>Semestre</th>
                        <td><?PHP Semestre()?></td>
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
            <select id="Periodo" name="Periodo" style="width:10%; text-align:center">
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
        <select id="semestre" name="semestre" style="text-align:center">
        	<option value="-1">Seleccionar</option>
            <?PHP
		for($i=1;$i<=13;$i++){
			$Valor	= $i;
			/**********************************/
			if($i==13){$Valor='Todos';}
			?>
            <option value="<?PHP echo $i?>"><?PHP echo $Valor?></option>
            <?PHP
			/**********************************/
			}
			?>
        </select>
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

?>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/extras/TableTools/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/extras/TableTools/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
     <style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                
    </style>
    
    <script>
	/****************************************************************/
	$(document).ready( function () {
	//TableTools.DEFAULTS.aButtons = [ "copy", "csv", "xls" ];
	
	$('#example').dataTable( {
		//"sDom": 'T<"clear">lfrtip'
	} );
} );
	/**************************************************************/
    function ResetModalidad(){
				$('#Modalidad').val('');   
				$('#id_modalidad').val('');
			}
		function ResetCarrera(){
				$('#carrera').val('');
				$('#codigocarrera').val('');
			}
                function ResetMateria(){
				$('#materia').val('');
				$('#codigomateria').val('');
			}
		function autoCompleModalidad(){
			/********************************************************/	
				$('#Modalidad').autocomplete({
						source: "carga_datos.php?actionID=autoCompleModalidad",
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
						
						source: "carga_datos.php?actionID=autoCompleteCarrera&id_Movilidad="+id_modalidad,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#codigocarrera').val(ui.item.id_carrera);
							
							}
						
					});//
			/********************************************************/
			}
               /**************************/
               		function autoCompleteMateria(){
			/********************************************************/	
			
			var codigocarrera = $('#codigocarrera').val();
			
			if(!$.trim(codigocarrera)){
					alert('Primero debe Buscar y Selecionar una Carrera');
					$('#carrera').effect("pulsate", {times:3}, 500);
					return false;
				}
			
				$('#materia').autocomplete({
						
						source: "carga_datos.php?actionID=autoCompleteMateria&carrera="+codigocarrera,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#codigomateria').val(ui.item.codigomateria);
							
							}
						
					});//
			/********************************************************/
			}



	/*	function Activar(){
				
				if($('#TodasCarreras').is(':checked')){
						$('#carrera').val('');
						$('#codigocarrera').val('');
						$('#carrera').attr('disabled',true);
					}else{
							$('#carrera').attr('disabled',false);
						}
				
			}
*/
			
	function ValidarDatos(){
			
                        ///**************Valida la modalidad
                        var id_modalidad= $('#id_modalidad').val();

			if(!$.trim(id_modalidad)){
                            alert('Indique la modalidad academico ');
                            $('#Modalidad').css('border-color','#F00');
                            $('#Modalidad').effect("pulsate", {times:3}, 500);
                             return false;
                        }	
			
                        ///**************Valida la carrera
                        
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
                                        
                               
                              ///**************Valida la materia
                              
                              
                              
                              
                              var codigomateria= $('#codigomateria').val();
                              var tmat=$("#tmaterias").attr("checked");
                              //alert ('materias-->'+tmat)
                                if(tmat=='checked') {
                                   // alert('aca')
                                    var tmaterias=1;
                                } else {
                                    var tmaterias=0;
                                }
                               if(!$.trim(codigomateria) && tmaterias==0){
                                    alert('Indique la materia ');
                                    $('#materia').css('border-color','#F00');
                                    $('#materia').effect("pulsate", {times:3}, 500);
                                     return false;
                                }
					
				///*******************valida el periodo
                                
                                var Periodo			= $('#Periodo').val();	
				
				if(Periodo==-1 || Periodo=='-1'){
						alert('Selecione un Periodo');
						$('#Periodo').css('border-color','#F00');
					    $('#Periodo').effect("pulsate", {times:3}, 500);
						return false;
					}
					
					
				var Semestre = $('#semestre').val();	
				
				if(Semestre==-1 || Semestre=='-1'){
						alert('Seleccione el Semestre');
						$('#semestre').css('border-color','#F00');
					    $('#semestre').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				var Riesgo	= $('#riesgo').val();	
				
				if(Riesgo==-1 || Riesgo=='-1'){
						alert('Seleccione el Riesgo');
						$('#riesgo').css('border-color','#F00');
					    $('#riesgo').effect("pulsate", {times:3}, 500);
						return false;
					}
			/*************************************************************/
				
				//$('#ReporteRiesgo').submit();
				
				//alert('Periodo'+Periodo+'\n semestre'+Semestre+'\n riesgo'+Riesgo+'\n codigocarrera'+id_carrera);
				
				$('#DivReporte').html('<blink>Cargando...</blink>');
				
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'riesgosmateriadetalle.php',
					  async: false,
					  //dataType: 'json',
					  data:({Periodo:Periodo,
						     modalidad:id_modalidad,
						     codigomateria:codigomateria,
                             tmaterias:tmaterias,
						     codigocarrera:id_carrera,
							 Semestre:Semestre}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#DivReporte').html(data);
				   }
				}); //AJAX
				
			/***********************************************************/
				
			
			
		}		
</script>			