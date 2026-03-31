<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.Estilo1 {
			font-family: tahoma;
			font-size: 14px;
			font-weight: bold;
			background-color:#C5D5D6;
		}
		.Estilo2 {
			font-family: tahoma;
			font-size: 12px;
			font-weight: bold;
		}
		.Estilo3 {
			font-family: tahoma;
			font-size: 15px;
			font-weight: bold;
		}
	</style>
	<style type="text/css">label.error { float: none; color: red; padding-left: .5em; vertical-align: middle; font-size: 10px; }</style>
	<script type="text/javascript" src="../../../mgi/js/jquery.js"></script>
	<script type="text/javascript" src="../../../mgi/js/jquery.validate.min.js"></script>
	<script>
		$().ready(function() {
			$("#form_test").validate({
				messages: {
					modalidad: "Seleccione una modalidad.",
					codigocarrera: "Seleccione un programa.",
					anio: "Digite un año válido.",
					periodo: "Seleccione un periodo.",
					busqueda_semestre: "Seleccione una opción.",
					promedio: "Seleccione un método de ordenación."
				}
			});
		});
		function hideDiv(val) {
			if(val==1)
				document.getElementById("div_semestre").style.display="";
			else
				document.getElementById("div_semestre").style.display="none";
		}

	</script>
</head>
<body>
<?php
	session_start();
?>
	<form name="form_test" id="form_test" action="listadopromediosformulario.php" method="post">
		<div align="center">
			<p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
			<table border="1" bordercolor="#003333" width="30%">
<?php 
				if($_SESSION["usuario"]=="admintecnologia" || $_SESSION["codigofacultad"]==156) {
?>
					<tr>
						<td class="Estilo1">Modalidad: </td>
						<td class="Estilo2" colspan="2">
					                <select name="modalidad" id="modalidad" class="required">
			        		                <option value="" selected>Seleccione...</option>
                        					<option value='200' >Programas de Pregrado</option>
			                        		<option value='300' >Programas de Postgrado</option>
					                </select>
						</td>
					</tr>
					<tr>
						<td class="Estilo1">Programa: </td>
						<td class="Estilo2" colspan="2">
							<select name="codigocarrera" id="codigocarrera" class="required">
				        	                <option value="" selected>Seleccione modalidad...</option>
							</select>
						</td>
					</tr>
<?php
				}
?>
				<tr>
					<td class="Estilo1">A&ntilde;o: </td>
					<td class="Estilo2" colspan="2">
						<input type="text" name="anio" id="anio" value="<?=date("Y")?>" style="text-align:center" maxlength="4" size="4" class="required">
					</td>
				</tr>
				<tr>
					<td class="Estilo1">Periodo: </td>
					<td class="Estilo2" colspan="2">
				                <select name="periodo" id="periodo" class="required">
			        	                <option value="" selected>Seleccione...</option>
                        				<option value=1>Primer periodo</option>
			                        	<option value=2>Segundo periodo</option>
				                </select>
					</td>
				</tr>
				<tr>
					<td class="Estilo1">Buscar x semestre: </td>
					<td class="Estilo2">
						<input name="busqueda_semestre" id="busqueda_semestre" type="radio" value="1" onclick="hideDiv(this.value)" class="required"> Si
						<br>
						<input name="busqueda_semestre" id="busqueda_semestre" type="radio" value="2" onclick="hideDiv(this.value)" class="required"> No
					</td>
					<td class="Estilo2" align="center">
						<div style="display:none" id="div_semestre">
							Semestre:
							<br>
							<input type="text" name="semestre" style="text-align:center" maxlength="2" size="2" class="required">
						</div>
					</td>
				</tr>
				<tr>
					<td class="Estilo1">Ordenado por: </td>
					<td class="Estilo2" colspan="2">
						<input name="promedio" id="promedio" type="radio" value="1" class="required"> Promedio Semestral
						<br>
						<input name="promedio" id="promedio" type="radio" value="2" class="required"> Promedio Acumulado
					</td>
				</tr>
				<tr>

					<td colspan="3" align="center"><input name="accion" type="submit" value="Consultar"></td>
				</tr>
			</table>
		</div>
	</form>
	<script type="text/javascript">
		$('#form_test #modalidad').change(function(event) {
			getCarreras("#form_test");
		});
		function getCarreras(formName){
			$(formName + " #codigocarrera").html("");
			$(formName + " #codigocarrera").css("width","auto");   
			if($(formName + ' #modalidad').val()!=""){
				var mod = $(formName + ' #modalidad').val();
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: '../../../mgi/datos/searchs/lookForCareersByModalidad.php',
					data: { modalidad: mod },     
					success:function(data){
						var html = '<option value="" selected></option>';
						var i = 0;
						while(data.length>i){
							html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
							i = i + 1;
						}                                    
						$(formName + " #codigocarrera").html(html);
						$(formName + " #codigocarrera").css("width","500px");                                        
					},
					error: function(data,error,errorThrown){alert(error + errorThrown);}
				});  
			}
		}
	</script>                
</body>
</html>
