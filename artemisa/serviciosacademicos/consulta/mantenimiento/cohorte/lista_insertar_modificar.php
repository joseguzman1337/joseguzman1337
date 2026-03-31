<?php
	/*
	* Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
	* Modificado 18 de julio 2017
	*/
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

	$fechahoy=date("Y-m-d H:i:s");
	require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
	$rutaado = "../../../funciones/adodb/";
	require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
	//$codigocarrera = $_SESSION['codigofacultad'];
	$fechahoy=date("Y-m-d H:i:s");
	$varguardar = 0;

	$query_cantidad ="SELECT nombreplanestudio, codigocarrera, max(cantidadsemestresplanestudio*1) as cantidadsemestresplanestudio FROM planestudio where codigocarrera = '".$_REQUEST['codigocarrera']."' and codigoestadoplanestudio in ('100', '101')";	
	$cantidad= $db->Execute($query_cantidad);
	$totalRows_cantidad = $cantidad->RecordCount();
	$row_cantidad = $cantidad->FetchRow();
	$semestres = $row_cantidad['cantidadsemestresplanestudio'];
	$inicio = 1;

	if (isset($_POST['grabar'])) {
		if ($varguardar == 0) {
			$cohortesInsertadas = false;
			$esValido = true;
			foreach($_POST as $key => $value) {
				if(ereg("valordetallecohorte_modificar",$key)) {
					if($value == '' || !is_numeric($value)){
						$esValido = false;
						break;
					}
				}
				if(ereg("valordetallecohorte_insertar",$key)) {
					if($value == '' || !is_numeric($value)){
						$esValido = false;
						break;
					}
				}
			}
			if($esValido) {
				foreach($_POST as $key => $value) {
					if(ereg("valordetallecohorte_modificar",$key)) {
						$semestre = ereg_replace("valordetallecohorte_modificar[0-9]+_","",$key);
						//echo $semestre;
						//exit();
						$iddetallecohortetmp = ereg_replace("valordetallecohorte_modificar","",$key);
						$iddetallecohorte = ereg_replace("_[0-9]+$","",$iddetallecohortetmp);
						$query_actualizar = "UPDATE detallecohorte SET valordetallecohorte='".$value."', semestredetallecohorte='".$semestre."'
						where iddetallecohorte = '{$iddetallecohorte}'";
						$actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
					}
					if(ereg("valordetallecohorte_insertar",$key)) {
						$semestre = ereg_replace("valordetallecohorte_insertar","",$key);
						$query_guardar = "INSERT INTO detallecohorte (iddetallecohorte, idcohorte, semestredetallecohorte, codigoconcepto, valordetallecohorte) values (0, '{$_REQUEST['idcohorte']}','$semestre','151','{$value}')";
						$guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
						$_REQUEST['iddetallecohorte'] = $db->Insert_ID();
						$cohortesInsertadas = true;
					}
				}
				if (!$cohortesInsertadas){
					echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
				}
				else {
					echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
				}
			}
			else
				echo "<script language='javascript'> alert('Debe diligenciar todos los campos');  </script>";
		}
	}

	$query ="select dc.iddetallecohorte,dc.semestredetallecohorte,c.nombreconcepto,dc.valordetallecohorte from detallecohorte dc, concepto c where dc.codigoconcepto=c.codigoconcepto and dc.idcohorte='".$_REQUEST['idcohorte']." order by dc.semestredetallecohorte'";	
	$rta= $db->Execute($query);
	$totalRows_rta = $rta->RecordCount();
	$row_rta = $rta->FetchRow();
?>
<html>
    <head>
        <title></title>
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css"> 
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css"> 
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css"> 
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css"> 
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css"> 
		<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css"> 
		<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script> 
		<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
	</head>
	<script type="text/javascript">
		function insertarValores(chequeo) {
			var elementos = document.getElementsByTagName("input");
			var tmp;
			var entro = false;
			var texto;
			if(chequeo.checked) {
				if(confirm('¿Está seguro de dejar el mismo valor para todos los semestres?')) {
					//alert("Hay " + elementos.length + elementos[0].type + " elementos con el nombre 'input'");
					texto = "";
					for (x=0;x<elementos.length;x++) {
						texto = elementos[x];
						if(texto.type == 'text'){
							if(!entro) {
								tmp = elementos[x].value;
								entro = true;
							}
							texto.value = tmp;
						//alert("Se han encontrado los siguientes valores en elementos 'opcion1'\n" + texto);
						}
					}
				}
				else {
					chequeo.checked = false;
				}
			}
		 }
	</script>
    <body>
		<div class="container">
			<center><h2>Detalle de Cohortes</h2></center>
			<form name="form1" id="form1"  method="POST">
				<INPUT type="hidden" name="idcohorte" value="<?php echo $_REQUEST['idcohorte'];?>"/>
				<INPUT type="hidden" name="codigoperiodo" value="<?php echo $_REQUEST['codigoperiodo'];?>"/>
				<div class="table-responsive">
					<table class="table table-line-ColorBrand-headers" width="400">
						<thead>
							<tr>
							<th>Semestre Cohorte</th>
							<th>
								Valor Cohorte
								<input type="checkbox" onclick="insertarValores(this)"/>
							</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if ($totalRows_rta !=0)
						{
							do 
							{
							?>
								<tr>
									<td> <?php echo $row_rta['semestredetallecohorte']; ?></td>
									<td>
										<INPUT type="text" name="valordetallecohorte_modificar<?php echo $row_rta['iddetallecohorte']."_".$inicio; ?>" id="valordetallecohorte" value="<?php
										if (isset ($_POST['valordetallecohorte_modificar'.$row_rta['iddetallecohorte']."_".$inicio]))
											echo $_POST['valordetallecohorte_modificar'.$row_rta['iddetallecohorte']."_".$inicio];
										else
											echo  $row_rta['valordetallecohorte']; ?>"/>
									</td>
								</tr>
								<?php 
								$inicio++;
							}while($row_rta = $rta->FetchRow());         			
						}
						else 
						{
							while($inicio <= $semestres) 
							{
								?>
								<tr>
									<td><?php echo $inicio; ?></td>
									<td>
										<INPUT type="text" name="valordetallecohorte_insertar<?php echo $inicio; ?>" id="valordetalle" value="<?php 
										if 	($_POST['valordetallecohorte_insertar'.$inicio]!="")
										{
										echo $_POST['valordetallecohorte_insertar'.$inicio];
										} ?>"/>
									</td>
								</tr>
							<?php
							$inicio++;
							}//while
						}//else
						?>
						<tr>
							<td colspan="2">
								<INPUT  class="btn btn-fill-green-XL" type="submit" value="Guardar" name="grabar"/>
								<?php
								if (isset($_REQUEST['idcohorte']))
								{
								?>
									<input type="hidden" name="idcohorte" value="<?php echo $_REQUEST['idcohorte']; ?>"/>
								<?php
								}
								?>
								<INPUT  class="btn btn-fill-green-XL" type="button" value="Regresar" onClick="window.location.href='lista.php?codigoperiodo=<?php echo $_REQUEST['codigoperiodo']; ?>'"/>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</body>
</html>