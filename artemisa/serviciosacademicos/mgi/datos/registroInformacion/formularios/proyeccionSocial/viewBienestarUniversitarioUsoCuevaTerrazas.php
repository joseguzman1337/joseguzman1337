<?php 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

$usuario_con=$_SESSION['MM_Username'];
   if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
     $aprobacion=true;
     $colspan  = 6;
   }else{
    $colspan  = 7;
   }
   
    

if($_REQUEST['semestre']) {
	$query="select sbu.id
		from siq_bienestaruniversitario sbu 
		join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
		join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
		join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
		where sbu.semestre=".$_REQUEST['semestre']." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";

	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?php echo $_REQUEST['semestre']?></p></div>

<?php
	} else {
?>
                <table align="center" class="formData last" width="92%">
                    <input type="hidden" id="Periodo" value="<?PHP echo $_REQUEST['semestre']?>" />
<?php
			$sum_tot_lunes=0;
			$sum_tot_martes=0;
			$sum_tot_miercoles=0;
			$sum_tot_jueves=0;
			$sum_tot_viernes=0;
			$sum_tot_sabado=0;
			$query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
			$exec2= $db->Execute($query2);
			while($row2 = $exec2->FetchRow()) {
			     /********************************************/
                  $SQL="select	 
            
                        sbu.id,
                        sbu.validar
                        
					from siq_bienestaruniversitario sbu 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbu.semestre=".$_REQUEST['semestre']." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'
                    
                    GROUP BY sbu.validar";
                    
                    if($ValidaSi=&$db->Execute($SQL)===false){
                        echo 'Error en el SQl <br><br>'.$SQL;
                        die;
                    }
                    
                    if($ValidaSi->fields['validar']==1 || $ValidaSi->fields['validar']=='1'){
                        $Check  = 'checked="checked"';
                    }else{
                        $Check  = '';
                    }
                 /********************************************/
?>
				<tr class="dataColumns category">
					<th colspan="<?PHP echo $colspan?>" class="borderR"><?php echo $_REQUEST['semestre']?> - <?php echo $row2['clasificacionesinfhuerfana']?></th>    
                    <?PHP 
                    if($aprobacion==true){
                        ?>
                        <th class="borderR">Validar Informaci&oacute;n<input type="checkbox" title="Validar Informacion" <?PHP echo $Check?>  onclick="CambiarValidar('<?PHP echo $row2['aliasclasificacionesinfhuerfana']?>')" id="ValidaInfo_<?PHP echo $row2['aliasclasificacionesinfhuerfana']?>" /></th>   
                        <?PHP
                    }
                    ?>            
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Día</th>               
					<th class="borderR">Lunes</th>               
					<th class="borderR">Martes</th>               
					<th class="borderR">Miercoles</th>               
					<th class="borderR">Jueves</th>
					<th class="borderR">Viernes</th>
					<th class="borderR">Sabado</th>
				</tr>
<?php
				$sum_lunes=0;
				$sum_martes=0;
				$sum_miercoles=0;
				$sum_jueves=0;
				$sum_viernes=0;
				$sum_sabado=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbu.lunes
						,sbu.martes
						,sbu.miercoles
						,sbu.jueves
						,sbu.viernes
						,sbu.sabado,
                        sbu.validar
					from siq_bienestaruniversitario sbu 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbu.semestre=".$_REQUEST['semestre']." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?php echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?php echo $row['lunes']?></td>
						<td class="column borderR" align="center"><?php echo $row['martes']?></td>
						<td class="column borderR" align="center"><?php echo $row['miercoles']?></td>
						<td class="column borderR" align="center"><?php echo $row['jueves']?></td>
						<td class="column borderR" align="center"><?php echo $row['viernes']?></td>
						<td class="column borderR" align="center"><?php echo $row['sabado']?></td>
					</tr>
<?php
					$sum_lunes+=$row['lunes'];
					$sum_martes+=$row['martes'];
					$sum_miercoles+=$row['miercoles'];
					$sum_jueves+=$row['jueves'];
					$sum_viernes+=$row['viernes'];
					$sum_sabado+=$row['sabado'];
                    
                    $Validar = $row['validar'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?php echo $sum_lunes?></th>
					<th class="borderR"><?php echo $sum_martes?></th>
					<th class="borderR"><?php echo $sum_miercoles?></th>
					<th class="borderR"><?php echo $sum_jueves?></th>
					<th class="borderR"><?php echo $sum_viernes?></th>
					<th class="borderR"><?php echo $sum_sabado?></th>
				</tr>
                <?PHP 
                   if($Validar==1 || $Validar=='1'){
                        $color  = 'white';
                        $Text   = 'La informaci&oacute;n se encuentra Validada.';
                   }else{
                        $color  = 'red';
                        $Text   = 'La informaci&oacute;n NO se encuentra Validada.';
                   } 
                ?>
                <tr>
                    <th colspan='7' style="color:<?PHP echo $color?>;"><?PHP echo $Text?></th>
                </tr>
<?php
				$sum_tot_lunes+=$sum_lunes;
				$sum_tot_martes+=$sum_martes;
				$sum_tot_miercoles+=$sum_miercoles;
				$sum_tot_jueves+=$sum_jueves;
				$sum_tot_viernes+=$sum_viernes;
				$sum_tot_sabado+=$sum_sabado;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='7'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_lunes?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_martes?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_miercoles?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_jueves?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_viernes?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_sabado?></th>
			</tr>
		</table>
<?php
	}
	exit;
}
?>
<form action="" method="post" id="form<?php echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas uso de la cueva y las terrazas</legend>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); ?>
            <input type="hidden" name="semestre" value="" id="semestre" />             
                
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>-->
		<?php //$utils->getSemestresSelect($db,"semestre"); ?>
		<input type="hidden" name="alias" value="<?php echo $_REQUEST['alias']?>" />
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form<?php echo $_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$('#form<?php echo $_REQUEST['alias']?> :submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?php echo $_REQUEST['alias']?>");
		if(valido){
			sendForm5();
		}
	});
	function sendForm5(){           
            var periodo = $('#form<?php echo $_REQUEST['alias']?> #mes').val()+$('#form<?php echo $_REQUEST['alias']?> #anio').val();
                $('#form<?php echo $_REQUEST['alias']?> #semestre').val(periodo);
		$.ajax({
				type: 'GET',
				url: 'formularios/proyeccionSocial/viewBienestarUniversitarioUsoCuevaTerrazas.php',
				async: false,
				data: $('#form<?php echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?php echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
    
    function CambiarValidar(alias){
        /********************************************/
        if($('#ValidaInfo_'+alias).is(':checked')){
            /******************************/
            var Validar  = 1;
            /******************************/
        }else{
            var Validar  = 0;
        }//if
        
        var Periodo  = $('#Periodo').val();
        
        $.ajax({//Ajax
        	  type: 'POST',
        	  url: './formularios/proyeccionSocial/BienestarFormularios_html.php',
        	  async: false,
        	  dataType: 'json',
        	  data:({actionID: 'Validar',alias:alias,
                                         Validar:Validar,
                                         Periodo:Periodo}),
        	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        	  success: function(data){
        	        $('#Tr_info').css('visibility','visible')
        			$('#Th_Info').html(data);
        		}//data 
          }); //AJAX 
        
        /********************************************/
    }/*function CambiarValidar*/
</script>
