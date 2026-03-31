<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

<fieldset style="width:98%;">
<legend>Buscar Estudiantes</legend>
<form action="CargarDocentes.php" method="post" enctype="multipart/form-data" name="Principal">
<table>
	<thead>
    	<tr>
        	<th>Cargar Archivo.cvs</th>
            <th>
            	<input type="file" id="file" name="file" height="80px"  size="50"/>
            </th>
        </tr>
    </thead> 
    <tbody> 
    	<tr>
        	<td colspan="2">&nbsp;</td>
        </tr> 
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>  
        <tr>
        	<td colspan="2" align="center">
            	<input type="submit" id="Save" name="Save" value="Cargar"/>
            </td>
        </tr>
    </tbody>   
</table>
</form>
</fieldset>