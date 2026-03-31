<?php
	if(isset($_POST['codigoperiodo']))
	{
		require_once("../mgi/datos/templates/template.php");
		$db = writeHeader("valida_PlanTrabajoDocente",TRUE,"../mgi/","body",false);
		$iddocente=$_POST['iddocente'];

		$query_listadocen = "select concat(d.nombredocente,' ', d.apellidodocente) as nombre, ad.id_docente from 
		AreaPrograma ap, AreaDocente ad, AreaUsuario au, docente d
		where au.idusuario='$iddocente'
		and au.idAreaPrograma=ap.idAreaPrograma
		and ap.idAreaPrograma=ad.idAreaPrograma
		and ad.id_docente=d.iddocente
		and au.codigoestado like '1%'";		
        $listadocen= $db->Execute($query_listadocen);
        $totalRows_listadocen = $listadocen->RecordCount();
        $row_listadocen = $listadocen->FetchRow();
        
        if ($totalRows_listadocen >0)
		{        
        ?>
			<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
				<thead>            
					<tr class="dataColumns">
						<th class="column" colspan="3"><span>LISTADO DE DOCENTES PERTENECIENTES AL AREA</span></th>                    
					</tr>
					<tr class="dataColumns">
						<th align="center">Docente</th>
						<th align="center">Plan Trabajo Docente</th>
						<th align="center">Plan de Trabajo Validado</th>
					</tr>                
				</thead>
				<tbody>
                <?php                  
                do 
				{                
					$query_pland = "select * from plandocente where id_docente='".$row_listadocen['id_docente']."' and codigoperiodo='".$_POST['codigoperiodo']."'";
					$pland= $db->Execute($query_pland);
					$totalRows_pland = $pland->RecordCount();
					$row_pland = $pland->FetchRow();
					?>                
					<tr class="contentColumns" class="row">
						<TD align="left" class="column"><?php echo $row_listadocen['nombre']; ?></TD>
                    	<?php 
						if($totalRows_pland >0)
						{ ?>
							<TD class="column" align="left"><a href="../mgi/tablero/factores/detalle_PlanTrabajoDocente.php?iddocente=<?php echo $row_listadocen['id_docente']; ?>&codigoperiodo=<?php echo $_POST['codigoperiodo']; ?>">Ver Plan</a></TD>
							<?php 
							if($row_pland['verificado']==1)
							{
							?>
								<TD class="column" align="left" style="font-style:italic">SI</TD>
								<?php
							}
							else{
							?>
								<TD class="column" align="left" style="font-style:italic">NO</TD>
							<?php
							}
						}//if
                    	else
						{                    
                    	?>
                    		<TD class="column" align="left" style="font-style:italic">No tiene Plan Docente</TD>
                    		<TD class="column" align="left" style="font-style:italic">NO</TD>
                    	<?php
                    	}
                    	?>
                	</tr>
                <?php 
                } while($row_listadocen = $listadocen->FetchRow());
                ?>
				</tbody>  
			</table>     
        <?php
        }//if
        else { ?>       
            <label class="grid-2-12">NO EXISTEN DATOS PARA LA BUSQUEDA</label>
        <?php  
        }

		exit();
	}//if

 	session_start();

	require_once("../mgi/datos/templates/template.php");

	$db = writeHeader("valida_PlanTrabajoDocente",TRUE,"../mgi/","body",false);
	$usuario_doc=$_SESSION['MM_Username'];
	$query_usuariodoc = "select * from usuario where usuario='$usuario_doc'";
	$usuariodoc = $db->Execute($query_usuariodoc);
	$totalRows_usuariodoc = $usuariodoc->RecordCount();
	$row_usuariodoc = $usuariodoc->FetchRow();
?>
<form action="" method="post" id="form_listado" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Lista Docentes Area Plan Trabajo Docente</legend>
		
		<input type="hidden" name="iddocente" id="iddocente" value="<?php echo $row_usuariodoc['idusuario'];?>">		
		<label for="modalidad" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_codperiodo = "select codigoperiodo, nombreperiodo from periodo where codigoperiodo > 20052 order by 1 desc";
		$codperiodo = $db->Execute($query_codperiodo);
		$totalRows_codperiodo = $codperiodo->RecordCount();
		?>		
		<select name="codigoperiodo" id="codigoperiodo">		
		<?php 
			while($row_codperiodo = $codperiodo->FetchRow()) 
			{
			?>
			<option value="<?php echo $row_codperiodo['codigoperiodo']?>">
			<?php echo $row_codperiodo['nombreperiodo']; ?>
			</option>
			<?php
			}
		?>
		</select>		
	 
		<input type="submit" value="Consultar" class="first small"/>
        <img src="../mgi/images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) 
	{
		event.preventDefault();
		var valido= validateForm("#form_listado");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'POST',
				url: 'listadodocente_PlanTrabajoDocente.php',
				async: false,
				data: $('#form_listado').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	
	
</script>