<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-weight: bold;
}
.Estilo2 {
	font-family: tahoma;
	font-size: x-small;
}
-->
</style>


<form name="form1" method="post" action="descargaarchivo.php?archivo=<?php echo $_GET['archivo'];?>">
  <div align="center">
    <p class="Estilo1">DESCARGA ARCHIVO SPADIES </p>
    <p><?php echo $_GET['archivo'];?></p>
    <p class="Estilo2">&nbsp;</p>
    <p class="Estilo2"><input type="submit" name="Submit" value="Descargar">	<input type="button" name="Regresar" value="Regresar" onClick="history.go(-2)"></p> 
  </div>
</form>
