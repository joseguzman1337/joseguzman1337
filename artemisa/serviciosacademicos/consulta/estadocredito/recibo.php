<?php require_once('../../Connections/sala.php');

    //session_start();
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

?>



<style type="text/css">

<!--

.style3 {font-family: Tahoma; font-size: x-small; }

.Estilo2 {

	font-family: Tahoma;

	font-weight: bold;

}

.Estilo4 {color: #006666}

.Estilo5 {color: #000000}

.Estilo7 {font-family: Tahoma}

.Estilo10 {font-size: x-small}

.Estilo13 {font-family: Tahoma; font-size: x-small; font-weight: bold; }

.Estilo14 {font-weight: bold}

.Estilo15 {color: #000000; font-family: Tahoma; font-weight: bold; font-size: x-small; }

.Estilo19 {color: #000000; font-family: Tahoma; font-size: x-small; }

.Estilo20 {font-size: small}

-->

</style>

<form name="form1" method="post" action="JavaScript:window.print()">

  <p align="center">

    <?php

       $base= "select * from estudiante,carrera where ((codigoestudiante = '".$_SESSION['codigo']."')and(estudiante.codigocarrera=carrera.codigocarrera))";

       $sol=mysql_db_query($database_sala,$base);

	   $totalRows = mysql_num_rows($sol);

       $row=mysql_fetch_array($sol); 

 ?>

    <?php

       $base1= "select * from cuotacredito where idcuotacredito = '".$_GET['imprimir']."'";

       $sol1=mysql_db_query($database_sala,$base1);

	   $totalRows1= mysql_num_rows($sol1);

       $row1=mysql_fetch_array($sol1);?> 

  </p>

  <div align="center"></div>

  <table width="665" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333" bgcolor="#FFFFFF">

    <tr>

      <td><div align="center" class="Estilo2">

          <p><img src="../../../imagenes/escudobosque.jpg" width="56" height="67"></p>

      </div>        </td>

      <td colspan="4"><div align="center" class="Estilo7 Estilo20"><strong>UNIVERSIDAD EL BOSQUE <br>

  NIT: 860.066.789-6</strong></div></td>

    </tr>

    <tr>

      <td colspan="5"><div align="center" class="Estilo7 Estilo10 Estilo5"><strong>COMPROBANTE PARA PAGO DE CREDITOS DE ESTUDIANTE </strong></div></td>

    </tr>

    <tr bgcolor="#C5D5D6">

      <td width="92"><div align="center" class="style3"><strong>Fecha</strong></div></td>

      <td colspan="2"><div align="center" class="style3"><strong>Nombres y Apellidos </strong></div>        <div align="center" class="Estilo13"></div></td>

      <td colspan="2" bgcolor="#C5D5D6"><div align="center" class="style3"><strong>Documento Identidad </strong></div>        

      <div align="center" class="Estilo13"></div></td>

    </tr>

    <tr>

      <td><div align="center" class="style3"><?php echo date("Y-m-d",time());?></div></td>

      <td colspan="2"><div align="center" class="style3"><?php echo $row['nombresestudiante'];?>&nbsp;<?php echo $row['apellidosestudiante'];?></div>        <div align="center" class="style3"></div></td>

      <td colspan="2"><div align="center" class="style3"><?php echo $row['numerodocumento'];?></div>        <div align="center" class="style3"></div></td>

    </tr>

    <tr bgcolor="#C5D5D6">

      <td><div align="center" class="style3"><strong>No. Cr&eacute;dito </strong></div></td>

      <td width="292"><div align="center" class="style3 Estilo14">

        <div align="center">Nombre Carrera </div>

      </div></td>

      <td width="66"><div align="center" class="Estilo13">Semestre</div></td>

      <td colspan="2"><div align="center" class="Estilo13"></div>        <div align="center" class="Estilo13">C&oacute;digo Estudiante </div></td>

    </tr>

    <tr>

      <td><div align="center" class="style3"><?php echo $row1['numerocredito'];?></div></td>

      <td><div align="center" class="style3">

        <div align="center" class="style3"><?php echo $row['nombrecarrera'];?></div>

      </div></td>

      <td><div align="center" class="style3"><?php echo $row['semestreestudiante'];?></div></td>

      <td colspan="2"><div align="center" class="style3"><?php echo $row['codigoestudiante'];?></div>        </td>

    </tr>

  </table>

  <table width="665" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914" bgcolor="#FFFFFF">

    <tr>

      <td width="242" rowspan="2"><div align="center" class="style3"></div>

          <div align="center" class="style3"><strong>PAGO CUOTA</strong>&nbsp;&nbsp;

              <?php

		if (date("Y-m-d",time()) > date("Y-m-d",strtotime($row1['fechavencimiento']))){

		

		echo "<h5>VENCIDA</h5>";

		} ?>

        </div></td>

      <td width="77" bgcolor="#FFD8B0"><div align="center" class="Estilo15">No. Cuota </div></td>

      <td width="117" bgcolor="#FFD8B0"><div align="center"><span class="Estilo15">Vence</span></div></td>

      <td width="98" bgcolor="#FFD8B0"><div align="center" class="Estilo15">Interes Cuota </div></td>

      <td width="93" bgcolor="#FFD8B0"><div align="center" class="Estilo15">Valor Cuota </div></td>

    </tr>

    <tr>

	<?php

	     $cuota=$row1['valorcuota'];

	     $interes=$row1['interesescuota'];

	     $valorcuota=$cuota-$interes;

	  ?>

      <td><div align="center" class="style3">.</div></td>

      <td><div align="center"><span class="style3"><?php echo $row1['fechavencimiento'];?></span></div></td>

      <td><div align="center" class="style3">

        <div align="left">$&nbsp;&nbsp;&nbsp;<?php echo $row1['interesescuota'];?></div>

        </div></td>

      <td><div align="left" class="style3">$&nbsp;&nbsp;&nbsp;<?php echo $valorcuota;?></div></td>

    </tr>

  </table>

  <table width="666" border="2" align="center" cellpadding="3" bordercolor="#E97914">

    <tr>

      <td width="192" bgcolor="#FFD8B0"><div align="center" class="Estilo15">PAGUE HASTA </div></td>

      <td width="158"><div align="center" class="Estilo19"><?php echo $row1['fechavencimiento'];?></div></td>

      <td colspan="2" bgcolor="#FFD8B0"><div align="right" class="Estilo15">Total Cuota </div></td>

      <td width="89"><span class="Estilo19">$&nbsp;&nbsp;&nbsp;<?php echo $row1['valorcuota'];?></span></td>

    </tr>

  </table>

  <table width="666" border="1" align="center" cellpadding="1" bordercolor="#E97914">

    <tr>

      <td width="127" bgcolor="#FFD8B0"><div align="center" class="Estilo13">Intereses de Mora </div></td>

      <td width="98" bgcolor="#FFD8B0"><div align="center" class="Estilo13">Abono</div></td>

      <td width="130" bgcolor="#FFD8B0"><div align="center" class="Estilo13">Saldo Pendiente </div></td>

      <td width="104" bgcolor="#FFD8B0"><div align="center" class="Estilo13">Total a Pagar </div></td>

      <td width="173" bgcolor="#FFD8B0"><div align="center" class="Estilo13">Autorizo</div></td>

    </tr>

    <tr>

      <td><div align="left">.</div></td>

      <td><div align="left">.</div></td>

      <td><div align="left">.</div></td>

      <td><div align="left">.</div></td>

      <td><div align="left">.</div></td>

    </tr>

  </table>

  <table width="666" border="2" align="center" cellpadding="3" bordercolor="#E97914">

    <tr>

      <td colspan="2"><span class="Estilo15">Digite el Siguiente n&uacute;mero para recaudo por: </span></td>

      <td colspan="3" bgcolor="#FFD8B0"><div align="center" class="Estilo15">FORMA DE PAGO </div></td>

    </tr>

    <tr>

      <td width="179"><div align="center" class="Estilo15">Ventanilla</div></td>

      <td width="171"><div align="center" class="Estilo15">Tesorer&iacute;a</div></td>

      <td width="37" bgcolor="#FFD8B0"><div align="center" class="Estilo15"></div>        

        <div align="center" class="Estilo15">BCO</div></td>

      <td width="134" bgcolor="#FFD8B0"><div align="center" class="Estilo15">CHEQUE </div></td>

      <td width="89" bgcolor="#FFD8B0"><div align="center" class="Estilo15">VALOR</div></td>

    </tr>

    <tr>

      <td><div align="center" class="Estilo15"> Pago Electr&oacute;nico </div></td>

      <td><div align="center" class="Estilo15">Tesorer&iacute;a</div></td>

      <td><span class="Estilo19">.</span></td>

      <td><span class="Estilo19">.</span></td>

      <td><div align="left" class="Estilo19">$</div></td>

    </tr>

    <tr>

      <td colspan="2" rowspan="2"><div align="center" class="Estilo15">Pague &uacute;nicamente en TESORER&Iacute;A </div></td>

      <td colspan="2" bgcolor="#FFD8B0"><div align="right" class="Estilo15">EFECTIVO</div></td>

      <td><span class="Estilo19">$</span></td>

    </tr>

    <tr>

      <td colspan="2" bgcolor="#FFD8B0"><div align="right" class="Estilo15">TOTAL</div></td>

      <td><span class="Estilo19">$</span></td>

    </tr>

    <tr bgcolor="#FFD8B0">

      <td colspan="5"><p align="center" class="Estilo15">NOTA:  S&iacute; NO realiza su pago antes de <?php echo $row1['fechavencimiento'];?> debe acercarse al <br>

  Departamento de Cr&eacute;dito y Cartera. <br>

  </p>      </td>

    </tr>

  </table>

  <p align="center"><span class="style3">

    <input name="imprimir" type="hidden" class="style3" value="<?php echo $_GET['imprimir'];?>">

    <br>

  </span>

    <input type="submit" name="Submit" value="Imprimir">

    <br>

    <?php

	 /*  $base= "select * from fechaactualizacion ";

       $sol=mysql_db_query($database_sala,$base);

	   $totalRows = mysql_num_rows($sol);

       $row=mysql_fetch_array($sol);  */      

      // $base1= "select * from fechaactualizacion  where idfechaactualizacion =  $totalRows";

       $base1= "select * from fechaactualizacion order by fechaactualizacion.idfechaactualizacion DESC ";

	   $sol1=mysql_db_query($database_sala,$base1);

	   $row1=mysql_fetch_array($sol1); 

 ?>

  </p>

  <div align="center">

    <p class="Estilo13">Fecha ultima actualizaci&oacute;n&nbsp;&nbsp;&nbsp; <?php echo $row1['fechaactualizacion'];?></p>

  </div>

</form>

