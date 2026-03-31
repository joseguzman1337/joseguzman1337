<?php require_once('../../Connections/sala2.php');

//session_start();
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

?>

<style type="text/css">

<!--

.Estilo8 {

	font-size: x-small;

	color: #FFFFFF;

	font-family: Tahoma;

}

.Estilo10 {font-family: thaoma}

.Estilo13 {color: #FFFFFF}

.Estilo17 {color: #000000; font-size: small;}

.Estilo18 {

	font-family: Tahoma;

	font-size: x-small;

}

.Estilo25 {

	font-family: Tahoma;

	color: #000000;

	font-weight: bold;

	font-size: xx-small;

}

.Estilo28 {font-family: Tahoma; font-size: x-small; font-weight: bold; }

.Estilo29 {font-weight: bold; color: #000000; }

.Estilo30 {color: #000000}

.Estilo31 {

	font-weight: bold;

	font-size: xx-small;

}

.Estilo33 {font-size: xx-small}

.Estilo34 {color: #000000; font-size: xx-small; }

.Estilo35 {font-weight: bold; color: #000000; font-size: xx-small; }

.Estilo36 {font-family: Tahoma; font-size: xx-small; }

.Estilo37 {font-size: x-small}

-->

</style>

<title></title>

<form action="" method="post" name="form1" class="Estilo10">

<div align="center">

<?php	 

mysql_select_db($database_sala, $sala);

$query_dataestudiante = "SELECT *

                         FROM estudiantegeneral e

                         where e.numerodocumento = '$codigoestudiante'

						 ";

$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());

$row_dataestudiante = mysql_fetch_assoc($dataestudiante);

$totalRows_dataestudiante = mysql_num_rows($dataestudiante);



if (! $row_dataestudiante)

 {

   mysql_select_db($database_sala, $sala);

  $query_dataestudiante = "SELECT * 

							 FROM estudiante e,estudiantegeneral eg 

							 WHERE e.idestudiantegeneral = eg.idestudiantegeneral

							 and e.codigoestudiante = '".$_SESSION['codigo']."'

							 ";

  $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());

  $row_dataestudiante = mysql_fetch_assoc($dataestudiante);

  $totalRows_dataestudiante = mysql_num_rows($dataestudiante);

  if ($row_dataestudiante <> "")

   {

    $codigoestudiante = $row_dataestudiante['numerodocumento'];

   }

 }





 ?> 

<span class="Estilo28">

ESTADO DE CR&Eacute;DITO Y CARTERA<br>

<br>

</span>

<table width="614" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" id="tahoma">

    <tr>

      <td width="175" bgcolor="#C5D5D6" class="Estilo18"><div align="center" class="Estilo29 Estilo33">

        <div align="center"><strong>Nombres y Apellidos: </strong></div>

      </div></td>

      <td colspan="3" class="Estilo18">

      <div align="center" class="Estilo4 Estilo33"><?php echo $row_dataestudiante['apellidosestudiantegeneral'];?>&nbsp;<?php echo $row_dataestudiante['nombresestudiantegeneral'];?> </div>      

      </td>

      </tr>

    <tr>

      <td bgcolor="#C5D5D6" class="Estilo18"><div align="center" class="Estilo25">

        <p align="center">Nro Documento:</p>

      </div></td>

      <td width="195" class="Estilo18"><div align="center" class="Estilo4 Estilo33"><?php echo $row_dataestudiante['numerodocumento'];?></div></td>

      <td width="107" colspan="-1" bgcolor="#C5D5D6" class="Estilo18"><div align="center" class="Estilo34">

        <div align="center"><strong>Fecha:</strong></div>

      </div></td>

      <td width="99" class="Estilo18"><div align="center" class="Estilo4 Estilo33"><?php echo date("Y-m-d");?></div></td>

    </tr>

  </table>

  <span class="Estilo18"><br>

  <strong>CR&Eacute;DITOS PACTADOS</strong><span class="Estilo13">

    <?php

         

       $base = "select * 

	           from credito 

			   where codigoestudiante = '".$codigoestudiante."'";

       //echo $base;

	   $sol=mysql_db_query($database_sala,$base);

	   $totalRows = mysql_num_rows($sol);

       $row=mysql_fetch_array($sol);  

  if (! $row)

	  {

	    echo"";

	  }

	  else

	  {   

      do{ 

	  $saldocuota=0;

	   ?> 

    <br>

    <br>

    </span></span>

    <table width="618" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">

          <tr bgcolor="#C5D5D6" class="Estilo17">

            <td width="115" class="Estilo18"><div align="center" class="Estilo30 Estilo31">

              <p>No. Cr&eacute;dito </p>

            </div></td>

            <td width="233" bgcolor="#C5D5D6" class="Estilo18"><div align="center" class="Estilo35">

              <p>No. Aprobaci&oacute;n </p>

            </div></td>

            <td width="101" class="Estilo18"><div align="center" class="Estilo35">Fecha Cr&eacute;dito</div></td>

            <td width="131" bgcolor="#C5D5D6" class="Estilo18"><div align="center" class="Estilo35">Tipo Financiamiento</div></td>

          </tr>

          <tr>

            <td class="Estilo18"><div align="center" class="Estilo33"><?php echo $row['numerocredito'];?></div></td>

            <td class="Estilo18"><div align="center" class="Estilo33"><?php echo $row['aprobacioncredito'];?>&nbsp;</div></td>

            <td class="Estilo18"><div align="center" class="Estilo33"><?php echo $row['fechacredito'];?></div></td>

            <td class="Estilo18"><div align="center" class="Estilo33"><?php echo $row['codigofinanciamiento'];?>&nbsp;</div></td>

          </tr>

          <tr bgcolor="#C5D5D6" class="Estilo17">

            <td class="Estilo18"><div align="center" class="Estilo35">Periodo</div></td>

            <td class="Estilo18"><div align="center" class="Estilo35">No. Orden de Matr&iacute;cula </div></td>

            <td class="Estilo18"><div align="center" class="Estilo35">No. Pagar&eacute;</div></td>

            <td class="Estilo18"><div align="center" class="Estilo35">Valor Cr&eacute;dito</div></td>

          </tr>

          <tr>

            <td class="Estilo18">              <div align="center" class="Estilo33"><?php echo $row['codigoperiodo'];?></div></td>

            <td class="Estilo18"><div align="center" class="Estilo33"><?php echo $row['numeroordenmatricula'];?></div></td>

            <td class="Estilo18"><div align="center" class="Estilo33"><?php echo $row['numeropagare'];?>&nbsp;</div></td>

            <td class="Estilo18"><div align="center" class="Estilo33">$&nbsp;&nbsp;<?php echo $row['valorcredito'];?></div></td>

          </tr>

  </table>

    <span class="Estilo18">    </span>

    <table width="618" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">

            <tr bgcolor="#C5D5D6" class="Estilo17">

              <td width="116" class="Estilo25"><div align="center"></div> 

              <div align="center"> Cuota              </div>                </td>

              <td width="102" class="Estilo18"><div align="center" class="Estilo35">Documento </div></td>

              <td width="126" class="Estilo18"><div align="center" class="Estilo35">Clase Doc.</div></td>

              <td width="102" class="Estilo18"><div align="center" class="Estilo35">Fecha Vence </div></td>

              <td width="134" class="Estilo25"><div align="center">Valor Cuota</div>                

              <div align="center"></div></td>

            </tr>

  

   

    <?php  $base1= "select * 

	                from cuotacredito,credito 

					where cuotacredito.numerocredito=credito.numerocredito

					and cuotacredito.numerocredito ='".$row['numerocredito']."'";

         $sol1=mysql_db_query($database_sala,$base1);

	     $totalRows1 = mysql_num_rows($sol1);

         $row1=mysql_fetch_array($sol1);

	   

  if (! $row1)

	  {

	    echo"";

	  }

	  else

	  {   

 ?>     

	

       <tr>  

<?php	

	  do{  

		  //$numerocuota=$numerocuota+1;

		  ?>

    

 

              <td width="116" class="Estilo18"><div align="center" class="Estilo33">

                <?php

		if (date("Y-m-d",time()) > date("Y-m-d",strtotime($row1['fechavencimiento'])))

		{

		 echo "VENCIDA";

		}

	  else

	   {

	    echo "PROX.CUOTA";

	   }

		 ?>

&nbsp;              <?php /*echo "<a href='recibo.php?imprimir=".$row1['idcuotacredito']."'>",Imprimir,"</a>" */?> 

&nbsp;              </div></td>

              <td width="102" class="Estilo18"><div align="center" class="Estilo33"><?php echo $row1['chequepostfechado'];?></div></td>

              <td width="126" class="Estilo18"><div align="center" class="Estilo33"><?php echo $row1['formapago'];?></div></td>

              <td width="102" class="Estilo18"><div align="center" class="Estilo33"><?php echo $row1['fechavencimiento'];?></div></td>

              <td width="134" class="Estilo36"><div align="center">$&nbsp;&nbsp;&nbsp;<?php echo $row1['valorcuota'];?></div></td>

              <?php $saldocuota=$row1['valorcuota'] + $saldocuota;?>

	  </tr>

    

    <span class="Estilo8">

    <?php }while ($row1=mysql_fetch_array($sol1)); }?>

    </span>   

      <tr>

        <td bgcolor="#C5D5D6" class="Estilo18" colspan="4"><div align="right" class="Estilo35">SALDO CR&Eacute;DITO </div></td>

       <td width="134" class="Estilo36"><div align="center">$&nbsp;&nbsp;&nbsp;<?php echo $saldocuota;?></div></td>

      </tr>

    </table>   

    <?php }while ($row=mysql_fetch_array($sol)); } ?><br> 

    <span class="Estilo37 Estilo30">Si encuentra alguna inconsistencia en los datos favor dir&iacute;jase personalmente<br>

    al Departamento de Cr&eacute;dito y Cartera<br> 

    <br>



    <?php  

       $base1= "select * from fechaactualizacion order by fechaactualizacion.idfechaactualizacion DESC ";

       $sol1=mysql_db_query($database_sala,$base1);

	   $row1=mysql_fetch_array($sol1); 



 ?>

    <strong>Fecha &uacute;ltima actualizaci&oacute;n</strong> &nbsp; <?php echo $row1['fechaactualizacion'];?></span></div>

</form>

