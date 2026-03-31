<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<script language="javascript">
function enviar(){
	document.aplicaarp.submit()
}
</script>
<?php
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica ORDER BY nombremodalidadacademica ASC";
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

$query_sel_codigoperiodo="SELECT * FROM periodo p order by p.codigoperiodo desc";
$sel_codigoperiodo=mysql_query($query_sel_codigoperiodo,$sala) or die(mysql_error());
$row_sel_codigoperiodo=mysql_fetch_assoc($sel_codigoperiodo);
$totalRows_sel_codigoperiodo=mysql_num_rows($sel_codigoperiodo);
?>
<form name="aplicaarp" method="get" action="">
  <p align="center" class="Estilo3">VALORES PECUNIARIOS - MENU PRINCIPAL </p>
  <table width="58%"  border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="51%" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2">
				<div align="center">Modalidad Acad&eacute;mica</div>
			</td>
      <td width="49%" bordercolor="#FFFFFF" bgcolor='#FEF7ED'><p align="left" class="style2">
          <select name="modalidadacademica" id="modalidadacademica" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php
                do {
									?>
            <option value="<?php echo $row_sel_modalidadacademica['codigomodalidadacademica']?>"<?php if(isset($_GET['modalidadacademica'])){if($_GET['modalidadacademica'] == $row_sel_modalidadacademica['codigomodalidadacademica']){echo "selected";}}?>><?php echo $row_sel_modalidadacademica['nombremodalidadacademica']?></option>
            <?php
                } while ($row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica));
                $rows = mysql_num_rows($sel_modalidadacademica);
                if($rows > 0) {
                	mysql_data_seek($sel_modalidadacademica, 0);
                	$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
                }
?>
          </select>
      </p></td>
    </tr>
    <tr>
      <td bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2">
				<div align="center">Periodo</div>
			</td>
      <td bordercolor="#FFFFFF" bgcolor='#FEF7ED'>
				<div align="left">
					<span class="style2">
          	<select name="codigoperiodo" id="codigoperiodo" onChange="enviar()">
            	<option value="">Seleccionar</option>
            	<?php do { ?>
            		<option value="<?php echo $row_sel_codigoperiodo['codigoperiodo']?>"<?php if(isset($_GET['codigoperiodo'])){if($_GET['codigoperiodo'] == $row_sel_codigoperiodo['codigoperiodo']){echo "selected";}}?>><?php echo $row_sel_codigoperiodo['codigoperiodo']?></option>
            		<?php
              } while ($row_sel_codigoperiodo = mysql_fetch_assoc($sel_codigoperiodo));
              $rows = mysql_num_rows($sel_codigoperiodo);
              if($rows > 0) {
            		mysql_data_seek($sel_codigoperiodo, 0);
              	$row_sel_codigoperiodo = mysql_fetch_assoc($sel_codigoperiodo);
              }
							?>
          </select>
      </span></div></td>
    </tr>
    <tr>
      <td bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2">
				<div align="center">Acci&oacute;n</div>
			</td>
      <td bordercolor="#FFFFFF" bgcolor='#FEF7ED'>
      	<div align="left">
        	<select name="tipo" id="tipo">
          	<option>Seleccionar</option>
            <option value="1" <?php if($_GET['tipo']=='1'){echo "selected";}?>>Insertar factura/detalle factura valor pecuniario</option>
            <option value="2" <?php if($_GET['tipo']=='2'){echo "selected";}?>>Modificar factura/detalle factura valor pecuniario</option>
            <option value="3" <?php if($_GET['tipo']=='3'){echo "selected";}?>>Consultar factura/detalle factura valor pecuniario</option>
        		<option value="4" <?php if($_GET['tipo']=='4'){echo "selected";}?>>Crear Nuevos Valores Pecuniarios</option>
		        <option value="5" <?php if($_GET['tipo']=='5'){echo "selected";}?>>Edición Valores Pecuniarios</option>
						<option value="6" <?php if($_GET['tipo']=='6'){echo "selected";}?>>Copia Valores Pecuniarios</option>
          </select>
        </div>
			</td>
		</tr>
		<tr >
			<td width="51%" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2">
				<div align="center">Periodo destino</div>
			</td>
			<td bordercolor="#FFFFFF" bgcolor='#FEF7ED'>
				<div align="left">
					<span class="style2">
						<select name="codigoperiododestino" id="codigoperiododestino" onChange="enviar()">
							<option value="">Seleccionar</option>
							<?php do { ?>
								<option value="<?php echo $row_sel_codigoperiodo['codigoperiodo']?>"<?php if(isset($_GET['codigoperiododestino'])){if($_GET['codigoperiododestino'] == $row_sel_codigoperiodo['codigoperiodo']){echo "selected";}}?>><?php echo $row_sel_codigoperiodo['codigoperiodo']?></option>
								<?php
							} while ($row_sel_codigoperiodo = mysql_fetch_assoc($sel_codigoperiodo));
							$rows = mysql_num_rows($sel_codigoperiodo);
							if($rows > 0) {
								mysql_data_seek($sel_codigoperiodo, 0);
								$row_sel_codigoperiodo = mysql_fetch_assoc($sel_codigoperiodo);
							}
							?>
					</select>
			</span></div></td>
		</tr>
    <tr>
      <td colspan="2" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2">
				<div align="center">
        	<input name="Enviar" type="submit" id="Enviar" value="Enviar">
      	</div>
			</td>
    </tr>
  </table>
</form>
<script language="javascript">
	function cambia_tipo(){
	    //tomo el valor del select del tipo elegido
	    var tipo
	    tipo = document.aplicaarp.tipo[document.aplicaarp.tipo.selectedIndex].value
	    //miro a ver si el tipo está definido
	    if (tipo == 1){
				window.location.href="vpecuniarioinsertar.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica'];?>&tipo=<?php echo $_GET['tipo']?>";
			}
	    if (tipo == 2){
				window.location.href="vpecuniariomodificar.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica'];?>&tipo=<?php echo $_GET['tipo']?>";
			}
	    if (tipo == 3){
				window.location.href="vpecuniarioconsultar.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica'];?>&tipo=<?php echo $_GET['tipo']?>";
			}
			if (tipo == 4){
				window.location.href="vpecuniarionuevo.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica'];?>&tipo=<?php echo $_GET['tipo']?>";
			}
			if (tipo == 5){
				window.location.href="vpecuniario_lista.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica'];?>&tipo=<?php echo $_GET['tipo']?>";
			}
			if (tipo == 6){
				window.location.href="vpecuniario_automatico.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&codigoperiododestino=<?php echo $_GET['codigoperiododestino']?>&modalidadacademica=<?php echo $_GET['modalidadacademica'];?>&tipo=<?php echo $_GET['tipo']?>";
			}
	}
</script>
<?php
if(isset($_GET['Enviar'])){
	if(isset($_GET['modalidadacademica'])){
		$validaciongeneral=true;
	}else{}
	if(isset($_GET['codigoperiodo'])){
		$validaciongeneral=true;
	}else{}
	if($validaciongeneral==true){
		?>
		<script language="javascript">
		cambia_tipo()
		</script>
	<?php
	}
}
