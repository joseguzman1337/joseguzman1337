<?php require_once('../../../Connections/sala2.php');

session_start(); 

$usuario =  $_SESSION['MM_Username'];

    mysql_select_db($database_sala, $sala);

	$query_tipousuario = "SELECT *

	                      FROM usuariofacultad

						  where usuario = '".$usuario."'";

	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());

	$row_tipousuario = mysql_fetch_assoc($tipousuario);

	$totalRows_tipousuario = mysql_num_rows($tipousuario);   



if ($row_tipousuario['codigotipousuariofacultad'] == 100)

  {

     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listadodesercion.php'>";   

  }

else

  { // else

       $fecha = date("Y-m-d G:i:s",time());

		mysql_select_db($database_sala, $sala);

		$query_car = "SELECT nombrecarrera,codigocarrera 

						FROM carrera

						WHERE codigomodalidadacademica = '200'						

					    AND fechavencimientocarrera > '".$fecha."'	

					    order by 1";		

		$car = mysql_query($query_car, $sala) or die(mysql_error());

		$row_car = mysql_fetch_assoc($car);

		$totalRows_car = mysql_num_rows($car);

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

.Estilo4 {color: #FF0000}

-->

</style>

</head>

<script language="javascript">

function cambia_tipo()

{ 

    //tomo el valor del select del tipo elegido 

    var tipo 

    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 

    //miro a ver si el tipo está definido 

    if (tipo == 1)

	{

		window.location.reload("listadodesercionseleccion.php?busqueda=facultad"); 

	} 

    if (tipo == 2)

	{

		window.location.reload("listadodesercionseleccion.php?busqueda=todos"); 

	} 

     

} 



function buscar()

{ 

    //tomo el valor del select del tipo elegido 

    var busca 

    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 

    //miro a ver si el tipo está definido 

    if (busca != 0)

	{

		window.location.reload("listadodesercionseleccion.php?buscar="+busca); 

	} 

} 

</script>

<body>

<div align="center">

<form name="f1" action="listadodesercion.php" method="get" onSubmit="return validar(this)">

  <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>

  <table width="707" border="1" bordercolor="#003333">

  <tr>

    <td width="261" bgcolor="#C5D5D6"><div align="center" class="Estilo7"> 

      <div align="center" class="Estilo2"><strong>Búsqueda por : </strong>

              <select name="tipo" onChange="cambia_tipo()">

                <option value="0">Seleccionar</option>

                <option value="1">Por Facultad</option>

                <option value="2">Todas Las Facultades</option>

              </select>

	    </div>

    </div></td>

	<td width="430" class="Estilo2">&nbsp;	    

	  <?php

 if(isset($_GET['busqueda']))

  {			if ($_GET['busqueda']=="facultad")

			{

			   echo "Seleccione Facultad:"; ?>			       

	  <select name="carrera" id="carrera">

		    <option value="0" <?php if (!(strcmp(0,$_GET['carrera']))) {echo "SELECTED";} ?>>Seleccionar</option>

		    <?php

						do {  

						?>

				       <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp(0, $row_car['codigocarrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>

				       <?php

						} while ($row_car = mysql_fetch_assoc($car));

						  $rows = mysql_num_rows($car);

						  if($rows > 0) 

							   {

								  mysql_data_seek($car, 0);

								  $row_car = mysql_fetch_assoc($car);

								}

						  ?>

          </select>	         

	  <?php		

			}		

			if($_GET['busqueda']=="todos")

			{

				echo "Todas Las Facultades <input name='todas' type='hidden' size ='18' value='0'>";

			}

	

?>	

	  </span></td>

  </tr>

  <tr>

  	<td colspan="2" align="center">  	  <input name="buscar" type="submit" value="Consultar">&nbsp;  	</td>

  </tr>

  <?php

  }

  ?>

</table>

<p>



</p>

</form>

</div>

</body>

<script language="javascript">

function recargar()

{

	window.location.reload("listadodesercionseleccion.php");

}

</script>

<?php 

}

?>