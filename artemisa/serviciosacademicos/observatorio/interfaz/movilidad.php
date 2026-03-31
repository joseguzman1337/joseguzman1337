<?php
include('../templates/templateObservatorio.php');
include("funciones.php");

 $db =writeHeader("Movilidad <br> Estudiantil",true,"Admisiones",1);
    include("../class/toolsFormClass.php");
    $fun = new Observatorio();
    $tipo=$_REQUEST['tipo'];
   ?>

<div id="demo" style=" width: 1000px;">
   <iframe src="../../mgi/datos/internacionalizacion/menu_internacionalizacion.php" height="600" width="1000"></iframe> 
    <br><br>
    &nbsp;&nbsp;
    <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
</div>