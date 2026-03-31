<?php
	/*
	* Ivan Dario quintero Rios <quinteroivan@unbosque.edu.co>
	* modificado julio 18 2017
	*/
	session_start();
	$fechahoy=date("Y-m-d");
	require_once('../../Connections/sala2.php');
	$rutaado = "../../funciones/adodb/";
	require_once('../../Connections/salaado.php');
	require_once("../../funciones/sala_genericas/Excel/reader.php");
	require_once("cargaarchivoitemps.php");

	if(!isset ($_SESSION['MM_Username']))
	{
		echo "No tiene permiso para acceder a esta opción";
		exit();
	}

	if(isset($_POST["codigocarrera"]))
	{		
		cargaarchivoitemps($_FILES,$_POST,$db);
	}
?>
<html>
    <head>
        <title>Homologación de Items</title>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link type="text/css" rel="stylesheet" href="../../../assets/css/normalize.css"> 
		<link type="text/css" rel="stylesheet" href="../../../assets/css/font-page.css"> 
		<link type="text/css" rel="stylesheet" href="../../../assets/css/font-awesome.css"> 
		<link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css"> 
		<link type="text/css" rel="stylesheet" href="../../../assets/css/general.css"> 
		<link type="text/css" rel="stylesheet" href="../../../assets/css/chosen.css"> 
		<script type="text/javascript" src="../../../assets/js/jquery-3.6.0.min.js"></script> 
		<script type="text/javascript" src="../../../assets/js/bootstrap.js"></script>
    </head>
    <body>
		<div class="container">
			<form name="form1" id="formHomologacion"  method="POST" action="" enctype="multipart/form-data" >            
				<table class="table" width="70%" border="0" align="center" cellpadding="3">
					<tr id="trgris">
						<td align="center" colspan="2">
							<h2>Carga Nuevos Ítems PS-SALA</h2>
							<p>
								Para la modalidad de Educacion Virtual  debe seleccionar la opcion de pregrado.
							</p>
						</td>
					</tr>
					<tr>
						<td>Modalidad académica</td>
						<td><?php
							$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where  codigomodalidadacademicasic not in('000')";
							$tipomodalidad = $db->Execute($query_tipomodalidad);							
							?>		
							<select name="modalidad" id="modalidad" >
								<option value=""></option>
								<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
								?>
									<option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
									<?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
									</option>
								<?php
								}
								?>
							</select>							
						</td>
					</tr>
					<tr>
						<td>Programa académico</td>
						<td> <select name="codigocarrera" id="unidadAcademica" class="required" >
								<option value="" selected></option>
							</select>	
						</td>
					</tr>
					<tr>
						<td>
							<br><P>Seleccione el archivo que desea cargar.</P>
						</td>
						<td>
							<br><input type="file" name="resultados">
						</td>
					</tr>
					<tr id="trgris">
						<td align="left" colspan="2">
							<br>
							<label id="labelresaltado" >Para ver el archivo de ejemplo haga clic <a id="aparencialink" href="generaarchivo.php?file=logarchivos/ejemplo.xls">Aquí</a></label>
						</td>
					</tr>
					<tr id="trgris">
						<td align="center" colspan="2"><INPUT class="btn btn-fill-green-XL" type="submit" value="CARGAR ARCHIVO" name="enviar" />
						</td>
					</tr>
				</table>
			</form>
			
		</div>
        
			<script type="text/javascript">
				$(':submit').click(function(event) {
					event.preventDefault();
					var valido = true;
					if($("#formHomologacion #unidadAcademica").val()==""){
						alert("Debe seleccionar una carrera");
						valido = false;
					}
					if(valido && $('input[type="file"]').val()==""){
						alert("Debe seleccionar el archivo a cargar");
						valido = false;
					}
					if(valido){
						document.form1.submit();
					}
				});
					
				$('#formHomologacion #modalidad').change(function(event) {
							getCarreras("#formHomologacion");
						});

				function getCarreras(formName){
					$(formName + " #unidadAcademica").html("");
					$(formName + " #unidadAcademica").css("width","auto");   

					if($(formName + ' #modalidad').val()!=""){
						var mod = $(formName + ' #modalidad').val();
							$.ajax({
								dataType: 'json',
								type: 'POST',
								url: '../../mgi/datos/searchs/lookForCareersByModalidadSIC.php',
								data: { modalidad: mod },     
								success:function(data){
									 var html = '<option value="" selected></option>';
									 var i = 0;
										while(data.length>i){
											html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
											i = i + 1;
										}                                    

										$(formName + " #unidadAcademica").html(html);
										$(formName + " #unidadAcademica").css("width","500px");                                        
								},
								error: function(data,error,errorThrown){alert(error + errorThrown);}
							});  
					}
				}
			</script>    
    </body>
</html>
