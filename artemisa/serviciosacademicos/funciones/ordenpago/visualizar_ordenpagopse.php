<?php
$fechavencimiento = $this->ordenvigente();
//$this->codigoestudiante  $this->sala  $this->numeroordenpago

	/*
	 * @modified David Perez <perezdavid@unbosque.edu.co>
	 * @since  Abril 20, 2017
	 * Evalua si existe aporte o no para mostrar la opcion
	*/
	
	$aporte = 0;
	$query = "SELECT
			v.valorpecuniario
		FROM
			AportesBecas ab
		INNER JOIN valorpecuniario v ON v.idvalorpecuniario = ab.idvalorpecuniario
		WHERE
			ab.numeroordenpago = ".$this->numeroordenpago."
		AND ab.codigoestado = 400";
	$rta_query=mysql_query($query, $this->sala);
	if(mysql_num_rows($rta_query) > 0){
		$row_aporte=mysql_fetch_array($rta_query);
		$aporte = $row_aporte['valorpecuniario'];
	}
	/* Fin Modificación */
	
function cumplerequisitosmensaje($codigoestudiante,$sala,$numeroordenpago)
{
 	$query_ins="select c.codigoconcepto,c.nombreconcepto,dop.valorconcepto 
                from detalleordenpago dop join concepto c on dop.codigoconcepto=c.codigoconcepto 
                where numeroordenpago ='$numeroordenpago' and cuentaoperacionprincipal='153' and cuentaoperacionparcial='0001'";
        $rta_query_ins=mysql_query($query_ins, $sala);
        $totalRows_rta = mysql_num_rows($rta_query_ins);
        if($totalRows_rta > 0){
	
	$query_modal="select c.codigomodalidadacademica 
	from estudiante e, carrera c
	where e.codigoestudiante='$codigoestudiante'
	and e.codigocarrera=c.codigocarrera";
	$modal=mysql_query($query_modal, $sala);
	$row_modal=mysql_fetch_array($modal);

	if($row_modal['codigomodalidadacademica']=='200'){

        $esordeninscripcion=true;
	}
        }

	$query_datosdetalles= "select d.codigoconcepto, c.nombreconcepto, d.valorconcepto, d.cantidaddetalleordenpago
                from detalleordenpago d, concepto c
                where d.numeroordenpago = '$numeroordenpago'
                and d.codigoconcepto = c.codigoconcepto";
        $operacion=mysql_query($query_datosdetalles, $sala);
        $row_detalles=mysql_fetch_array($operacion);
        do {
            if($row_detalles['codigoconcepto'] == '151') {
                $esMatricula = true;
            }

        }
        while($row_detalles=mysql_fetch_array($operacion));

	if($esMatricula){

       $query_datosestudiante= "select e.idestudiantegeneral, d.tipodocumento, eg.numerodocumento, o.numeroordenpago, d.nombrecortodocumento,
                concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoestudiante, p.semestreprematricula, 
                o.codigoperiodo, c.codigosucursal, c.centrocosto, c.nombrecarrera, e.codigotipoestudiante, c.codigocarrera, c.codigomodalidadacademica,
                o.codigoimprimeordenpago, i.nombreimprimeordenpago, co.nombrecopiaordenpago,o.fechaentregaordenpago
                from estudiante e, ordenpago o, prematricula p, carrera c, documento d, imprimeordenpago i, copiaordenpago co, estudiantegeneral eg
                where e.codigoestudiante = o.codigoestudiante
                and o.numeroordenpago = '$numeroordenpago'
                and e.codigoestudiante='$codigoestudiante'
                and p.idprematricula = o.idprematricula
                and e.codigocarrera = c.codigocarrera
                and d.tipodocumento = eg.tipodocumento
                and o.codigoimprimeordenpago = i.codigoimprimeordenpago
                and o.codigocopiaordenpago = co.codigocopiaordenpago
                and e.idestudiantegeneral = eg.idestudiantegeneral";
        $datachino=mysql_query($query_datosestudiante, $sala);
        $row_datachino = mysql_fetch_array($datachino);

	  if($row_datachino['semestreprematricula']==1 && $row_datachino['codigomodalidadacademica']=='200'){	
  	  $esMensaje = true;
	  }	

        }

	if($esordeninscripcion){
	return true;
	}
	elseif($esMensaje){
	return true;
	}
	else{
	return false;
	}

}//function cumplerequisitosmensaje


 function pago_con_tarjeta($codigoestudiante,$sala,$numeroordenpago)
 {
    $query_data= "select codigosituacioncarreraestudiante,codigomodalidadacademica,codigoconcepto,e.codigocarrera
	from estudiante e,detalleordenpago d,carrera c,ordenpago o
	where e.codigoestudiante = '$codigoestudiante'
	and d.numeroordenpago = '$numeroordenpago'
	and c.codigocarrera = e.codigocarrera
	and o.codigoestudiante = e.codigoestudiante
	and o.numeroordenpago = d.numeroordenpago";
	//echo $query_data;
	$data=mysql_query($query_data, $sala) or die("$query_data".mysql_error());
	$totalRows_data = mysql_num_rows($data);

	while($row_data = mysql_fetch_array($data))
	{
	    $carrera = $row_data['codigocarrera'];
		$codigomodalidadacademica = $row_data['codigomodalidadacademica'];
		$codigoconcepto = $row_data['codigoconcepto'];
		$codigosituacioncarreraestudiante = $row_data['codigosituacioncarreraestudiante'];


		$query_autorizacion = "select *
		from carreracobrotarjeta
		where ( codigocarrera = '$carrera' or codigocarrera = '1' )
		and codigomodalidadacademica = '$codigomodalidadacademica'
		and now() between fechainiciocarreracobrotarjeta and fechafinalcarreracobrotarjeta
		and codigoestado like '1%'";
		//echo $query_autorizacion;
		$autorizacion=mysql_query($query_autorizacion, $sala) or die("$query_autorizacion".mysql_error());
		$totalRows_autorizacion = mysql_num_rows($autorizacion);
        $row_autorizacion = mysql_fetch_array($autorizacion);

		if (!$row_autorizacion)
		 {
		   return false;
		 }
		else
		 {
		  $query_concepto = "select *
		  from detallecarreracobrotarjeta
		  where idcarreracobrotarjeta = '".$row_autorizacion['idcarreracobrotarjeta']."'
		  and ( codigoconcepto = '$codigoconcepto')
		  and now() between fechainiciodetallecarreracobrotarjeta and fechafinaldetallecarreracobrotarjeta
		  and codigoestado like '1%'";
		  //echo "<br>$query_concepto";
		  $concepto=mysql_query($query_concepto, $sala) or die("$query_concepto".mysql_error());
		  $totalRows_concepto = mysql_num_rows($concepto);
          $row_concepto = mysql_fetch_array($concepto);

		  if($row_concepto <> "")
		   {
		    $query_tipo = "select *
			from cobrotarjetaestudiante
			where iddetallecarreracobrotarjeta = '".$row_concepto['iddetallecarreracobrotarjeta']."'
			and codigosituacioncarreraestudiante = '$codigosituacioncarreraestudiante'
		    and now() between fechainiciocobrotarjetaestudiante and fechafinalcobrotarjetaestudiante
		    and codigoestado like '1%'";
		    //echo $query_tipo;
			$tipo=mysql_query($query_tipo, $sala) or die("$query_tipo".mysql_error());
		    $totalRows_tipo = mysql_num_rows($tipo);
            $row_tipo = mysql_fetch_array($tipo);
		    if($row_tipo <> "")
			 {
			  return true;
			 }
		   }
		 }
	}
    return false;
 }//function pago_con_tarjeta

?>
<SCRIPT LANGUAGE="JavaScript">
    function disableForm(theform) 
    {
        if (document.all || document.getElementById) { for (i = 0; i < theform.length; i++) { var tempobj = theform.elements[i]; if (tempobj.type.toLowerCase() == "submit" || tempobj.type.toLowerCase() == "reset") tempobj.disabled = true; } setTimeout('alert("La información ha sido enviada. Por favor espere un momento.")', 2000); return true; } else { alert("La información ha sido enviada. Por favor espere un momento."); return false;
        }
    }//function
//  End -->
</script>

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
    <tr>
        <td colspan="1"><label id="labelresaltado"><strong>SELECCIONE SU FORMA DE PAGO</strong></label></td>
    </tr>
    <tr>
        <td colspan="1" valign="top" style="border-top-color:#000000">
            <table width="100%">
                <tr>
                    <td valign="top">
                        <!--  Si requiere información sobre PSE de Click <a href="http://www.achcolombia.com.co/pse.html" target="_blank" id="aparencialinknaranja">aqui</a> -->
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" >
                            <tr>
                                <td valign="top" width="30%">
                                    <div align="center"><!--<a href="http://www.achcolombia.com.co/pse.html" target="_blank">-->
                                        <img src="../../../imagenes/LogoPSE.jpg" ><!--</a>-->
                                    </div><br>
                                    <center> 
                                        <input type="radio" name="PaymentSystem" value="0" checked onClick="if(document.getElementById('tarjeta').disabled == false){ document.getElementById('tarjeta').disabled = true; document.getElementById('bancos').disabled = false }">
                                        <strong>PSE</strong>
                                    </center>
                                </td>
                                <td valign="top" width="30%">
                                    <strong>Seleccione el Tipo de Cliente</strong>
                                    <br>
                                    <input type="radio" name="tipocliente" value="0" checked> Natural
                                    <input type="radio" name="tipocliente" value="1"> Jurídico	
                                    <br><br>
                                    <?php 
                                    if(cumplerequisitosmensaje($this->codigoestudiante,$this->sala,$this->numeroordenpago))
                                    {
                                        ?>
                                        <strong>Nuestro estudiante atenderá periódicamente, algunas actividades propias de su programa académico en el campus ubicado en el kilómetro 20 de la Autopista Norte.</strong>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <!-- 
                                Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
                                modificado 18 de abril del 2017
                                Se adiciona una celda mas con la informacion del aporte al pago
                                -->
								<?php 
									if($aporte > 0){
								?>
                                <td valign="top" width="60%">
                                    <strong>Desea apoyar el Proyecto Semillas de becas con un aporte de:</strong>
                                    <br>
                                    <strong>$<?php echo $aporte; ?></strong><br>
                                    <input type="checkbox" name="conaporte" id="sumaAporte" onclick="aporte();" value="0"> Si                                     
                                    <br><br>
                                    <p>
                                        Gracias a tu aporte al Programa Semillas, la Universidad seguirá otorgando becas a más de 300 estudiantes año a año.
                                    </p>
                                </td>
								<?php
									}
								?>
                                <!--end -->
                                <!--<td valign="top" width="200px">-->
                                <?php
                                        //getBankList(); //echo  $fechavencimiento['valorfechaordenpago'];
                                        /*$query_selbancospse= "select codigobancopse, nombrebancopse
                                        from bancopse
                                        where codigoestado like '1%'";
                                        $selbancospse=mysql_query($query_selbancospse, $this->sala) or die("$query_selbancospse".mysql_error());
                                        $totalRows_selbancospse = mysql_num_rows($selbancospse);*/
                                        //echo $query_selbancospse;
                                ?>
                                   <!--<select name="cmbBanco" id="bancos">-->
                                <?php
                                        /*while($row_selbancospse = mysql_fetch_array($selbancospse))
                                        {
                                                echo "<option value='".$row_selbancospse['codigobancopse']."'>".$row_selbancospse['nombrebancopse']."</option>";
                                        }*/
                                $numerodocumento_ordenpago=$this->numerodocumento_ordenpago();
                                 ?>
                                  <!--</select>-->
								<input name="aporteBeca" type="hidden" id="aporteBeca" value="<?php echo $aporte; ?>">
                                <input id="txtValor" name="txtValor" type="hidden" value="<?php echo $fechavencimiento['valorfechaordenpago']; ?>">
                                <input name="txtReference1" type="hidden" value="<?php echo $this->numeroordenpago; ?>">
                                <input name="txtReference2" type="hidden" value="<?php echo $this->numerodocumento; ?>">
                                <input name="txtReference3" type="hidden" value="<?php echo $this->tipodocumento; ?>">

                                    <!-- <input type="submit" name="enviar" value="Pagar" disabled onClick="alert('Todavía no esta en funcionamiento esta opción')"> -->

                                <!--</td>-->
                                <td align="center">
                                    <input type="submit" name="enviar" value="Pagar">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
	</td>
    </tr>
    <?php
    ///******/ validacion para  pago con tarjeta de credito
     if (pago_con_tarjeta($this->codigoestudiante,$this->sala,$this->numeroordenpago)|| $this->numeroordenpago==1853056 || $this->numeroordenpago==1876469 || $this->numeroordenpago==1876470 || $this->numeroordenpago==1876472 || $this->numeroordenpago==1850413 || $this->numeroordenpago==1853057)
      {
    ?>
    <tr>
        <td width="319" style="border-top-color:#000000">
            <table width="100%">
                <tr>
                    <td valign="top"><!--  Si requiere información sobre PSE de Click <a href="http://www.achcolombia.com.co/pse.html" target="_blank" id="aparencialinknaranja">aqui</a> -->
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" >
                            <tr>
                                <td align="center" width="30%">
                                    <table  align="center">
                                        <tr>
                                            <td align="center"><img src="../../../imagenes/mcard.gif" width="50" height="50">
                                            </td>
                                            <td align="center"><img src="../../../imagenes/visa.gif" width="50" height="50">
                                            </td>
                                        </tr>
                                    </table>
                                    <br><input type="radio" name="PaymentSystem" value="1" onClick="if(document.getElementById('bancos').disabled == false){ document.getElementById('bancos').disabled = true; document.getElementById('tarjeta').disabled = false }"><b>Tarjetas de Crédito</b>
                                </td>
                                <td width="50%">&nbsp;</td>
                                <td valign="top" align="center"><br><br>
                                    <?php
                                    //<strong>Seleccione la tarjeta</strong>
                                            //getBankListTarjeta(); //echo  $fechavencimiento['valorfechaordenpago'];
                                            /*$fechavencimiento['valorfechaordenpago'] = '2008-08-08';
                                            $numeroordenpago = '1135225';
                                            $numerodocumento = '78101105503';*/
                                    ?>
                                     <input type="submit" name="enviar" value="Pagar" >
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php
      }
    ?>
</table>
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
<script LANGUAGE="JavaScript">
	function aporte(){
		var valor = parseInt($('#txtValor').val());
		var aporte = parseInt($('#aporteBeca').val());
		if($('#sumaAporte').prop('checked')){			
			$('#txtValor').val(valor+aporte);
		}else{
			$('#txtValor').val(valor-aporte);
		}
	}
</script>