<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<?php
 session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//error_reporting(2048);

ini_set("include_path", ".:/usr/share/pear_");

require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/combo.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/combo_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);

foreach($config as $class=>$values) {

	$options = &PEAR::getStaticProperty($class,'options');

	$options = $values;

}



$pais_paramodificar = DB_DataObject::factory('pais');

$pais_paramodificar->query("SELECT * FROM pais WHERE codigoestado = 100 ORDER BY nombrepais asc");

$pais_modifica = DB_DataObject::factory('pais');



$departamento_paramodificar=DB_DataObject::factory('departamento');

$departamento_paramodificar->query("SELECT * FROM departamento WHERE codigoestado = 100 ORDER BY nombredepartamento asc");

$departamento_modifica=DB_DataObject::factory('departamento');



$ciudad_paramodificar= DB_DataObject::factory('ciudad');

$ciudad_paramodificar->query("SELECT * FROM ciudad WHERE codigoestado = 100 ORDER BY nombreciudad asc");

$ciudad_modifica= DB_DataObject::factory('ciudad');





$combo_departamento=DB_DataObject::factory('departamento');

$combo_departamento->get('','*');



$combo_pais=DB_DataObject::factory('pais');

$combo_pais->get('','*');



$combo_pais_ciudad=DB_DataObject::factory('pais');

$combo_pais_ciudad->get('','*');









?>

<?php

if(isset($_POST['idciudad']))

{

	$ciudad_modifica->get('idciudad',$_POST['idciudad']);



	$query_pais="SELECT p.nombrepais,p.idpais FROM ciudad c, departamento d, pais p

	WHERE c.iddepartamento=d.iddepartamento AND

	d.idpais=p.idpais AND idciudad='".$ciudad_modifica->idciudad."'";

	//echo $query_pais;

	$pais_ciudad=$sala->query($query_pais);

	$row_pais_ciudad=$pais_ciudad->fetchRow();

	//print_r($row_pais_ciudad);

	//print_r($combo_pais_depto);

	



}

if(isset($_POST['iddepartamento']))

{

	$departamento_modifica->get('iddepartamento',$_POST['iddepartamento']);

}

if(isset($_POST['idpais']))

{

	$pais_modifica->get('idpais',$_POST['idpais']);

}



?>



<form name="form1" method="post" action="">



  <p align="center" class="Estilo3">CREAR REGIONAL - MODIFICAR REGISTROS </p>

  <table width="150" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">

  <tr>

    <td><table width="150" border="0" align="center" cellpadding="3">

          <tr>

            <td colspan="7" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">MODIFICAR CIUDAD</div></td>

          </tr>

          <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione ciudad </div></td>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Ciudad<span class="Estilo4">*</span></div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo2">Departamento</span></span></span><span class="Estilo4">*</span> </div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center" class="Estilo2">Pais<span class="Estilo4">*</span></div></td>      

        <td rowspan="2"   colspan="2" nowrap bgcolor="#FEF7ED">Modificar

          <input name="modificaciudad" type="radio" value="si" onClick="enviar()"></td>

          <td rowspan="2" nowrap bgcolor="#FEF7ED">Anular

            <input name="anulaciudad" type="radio" value="si" onClick="enviar()"></td>

          </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <select name="idciudad" id="idciudad" onChange="enviar()">

            <option value="">Seleccionar</option>

            <?php



             while ($ciudad_paramodificar->fetch()){

?>

            <option value="<?php echo $ciudad_paramodificar->idciudad;?>"<?php if($ciudad_paramodificar->idciudad == $_POST['idciudad']){echo "selected";}?>><?php echo $ciudad_paramodificar->nombreciudad;?></option>

            <?php

            } 





?>

          </select>

        </span></span></span></div></td>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <input name="mod_nombreciudad" type="text" id="mod_nombreciudad" value="<?php if(isset($_POST['idciudad'])){echo $ciudad_modifica->nombreciudad;}?>">

        </span></span></span></div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <select name="mod_iddepartamento" id="mod_iddepartamento">

            <option value="">Seleccionar</option>

            <?php



             do{

?>

            <option value="<?php echo $combo_departamento->iddepartamento;?>"<?php if($combo_departamento->iddepartamento == $ciudad_modifica->iddepartamento){echo "selected";}?>><?php echo $combo_departamento->nombredepartamento;?></option>

            <?php

            } while ($combo_departamento->fetch())





?>

          </select>

</span></span></span></div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <select name="mod_idpais_ciudad" id="mod_idpais_ciudad">

            <option value="">Seleccionar</option>

            <?php



             do{

?>

            <option value="<?php echo $combo_pais_ciudad->idpais;?>"<?php if($combo_pais_ciudad->idpais == $row_pais_ciudad['idpais']){echo "selected";}?>><?php echo $combo_pais_ciudad->nombrepais;?></option>

            <?php

            } while ($combo_pais_ciudad->fetch())





?>

          </select>

</span></span></span>

        </div></td>    

      </tr>

      <tr>

        <td colspan="7" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">MODIFICAR DEPARTAMENTO </div></td>

        </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione departamento</div></td>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Departamento<span class="Estilo4">*</span> </div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo2">Pa&iacute;s</span></span></span><span class="Estilo4">*</span></div></td>
       <td rowspan="2" nowrap  colspan="2" bgcolor="#FEF7ED"><div align="center">Modificar
  
           <input name="modificadepartamento" type="radio" value="si" onClick="enviar()">
       </div></td>

        <td rowspan="2" nowrap colspan="2" bgcolor="#FEF7ED"><div align="center">Anular
  
            <input name="anuladepartamento" type="radio" value="si" onClick="enviar()">
        </div></td>

      </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <select name="iddepartamento" id="iddepartamento" onChange="enviar()">

            <option value="">Seleccionar</option>

            <?php



             while ($departamento_paramodificar->fetch()){

?>

            <option value="<?php echo $departamento_paramodificar->iddepartamento;?>"<?php if($departamento_paramodificar->iddepartamento == $_POST['iddepartamento']){echo "selected";}?>><?php echo $departamento_paramodificar->nombredepartamento;?></option>

            <?php

            } 





?>

          </select>

        </span></span></span></div></td>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <input name="mod_nombredepartamento" type="text" id="mod_nombredepartamento" value="<?php if(isset($_POST['iddepartamento'])){echo $departamento_modifica->nombredepartamento;}?>">

        </span></span></span></div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <select name="mod_idpais" id="mod_idpais">

            <option value="">Seleccionar</option>

            <?php



             do{

?>

            <option value="<?php echo $combo_pais->idpais;?>"<?php if($combo_pais->idpais == $departamento_modifica->idpais){echo "selected";}?>><?php echo $combo_pais->nombrepais;?></option>

            <?php

            } while ($combo_pais->fetch())

?>

          </select>

        </span> </span></span></div></td>     

      </tr>

      <tr>

        <td colspan="7" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">MODIFICAR PAIS </div></td>

        </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione pais</div></td>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Pais<span class="Estilo4">*</span></div></td>       

        <td rowspan="2" colspan="2" nowrap bgcolor="#FEF7ED"><div align="center" class="Estilo2"></div>

          <div align="center">Modificar
  
            <input name="modificapais" type="radio" value="si" onClick="enviar()">
          </div></td>

        <td rowspan="2" colspan="3" nowrap bgcolor="#FEF7ED"><div align="center">Anular
  
            <input name="anulapais" type="radio" value="si" onClick="enviar()">
        </div></td>

      </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

          <select name="idpais" id="idpais" onChange="enviar()">

            <option value="">Seleccionar</option>

            <?php



             while ($pais_paramodificar->fetch()){

?>

            <option value="<?php echo $pais_paramodificar->idpais;?>"<?php if($pais_paramodificar->idpais == $_POST['idpais']){echo "selected";}?>><?php echo $pais_paramodificar->nombrepais;?></option>

            <?php

            } 





?>

          </select>

        </span></span></span></div></td>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">

          <span class="phpmaker"><span class="style2"><span class="Estilo1">

          <input name="mod_nombrepais" type="text" id="mod_nombrepais" value="<?php if(isset($_POST['idpais'])){echo $pais_modifica->nombrepais;}?>">

          </span></span></span>        </div></td>       

      </tr>

      <tr>

        <td colspan="7" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">

          <input name="Regresar" type="submit" id="Regresar" value="Regresar">

        </div></td>

        </tr>

    </table></td>

  </tr>

</table>



</form>



<?php

if(isset($_POST['modificaciudad']))

{

	

	$validaciongeneral=true;

	

	$validacion['req_nombreciudad']=validar($_POST['mod_nombreciudad'],"requerido",'<script language="JavaScript">alert("No digitado el nombre del ciudad")</script>', true);

	$validacion['req_iddepartamento']=validar($_POST['mod_iddepartamento'],"requerido",'<script language="JavaScript">alert("No seleccionado el departamento al que pertenece el ciudad")</script>', true);	

	/*$validacion['req_codigosapciudad']=validar($_POST['mod_codigosapciudad'],"requerido",'<script language="JavaScript">alert("No digitado el código SAP del ciudad")</script>', true);*/



	foreach ($validacion as $key => $valor)

	{

		//echo $valor;

		if($valor==0)

		{

			$validaciongeneral=false;

		}

	}

	

	if($validaciongeneral==true){

		$ciudad_modifica->nombreciudad=$_POST['mod_nombreciudad'];

		$ciudad_modifica->nombrecortociudad=$_POST['mod_nombreciudad'];

		$ciudad_modifica->iddepartamento=$_POST['mod_iddepartamento'];

		$ciudad_modifica->codigosapciudad=$_POST['mod_codigosapciudad'];

		$modificar_ciudad=$ciudad_modifica->update();



		if(modificar_ciudad)

		{

			echo "<script language='javascript'>alert('Ciudad modificada correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 

		}		

		

		

	}

}

?>



<?php

if(isset($_POST['modificadepartamento']))

{

	

	$validaciongeneral=true;



	$validacion['req_nombredepartamento']=validar($_POST['mod_nombredepartamento'],"requerido",'<script language="JavaScript">alert("No digitado el nombre del departamento")</script>', true);

	$validacion['req_idpais']=validar($_POST['mod_idpais'],"requerido",'<script language="JavaScript">alert("No seleccionado el pais al que pertenece el departamento")</script>', true);	

	/*$validacion['req_codigosapdepartamento']=validar($_POST['mod_codigosapdepartamento'],"requerido",'<script language="JavaScript">alert("No digitado el código SAP del departamento")</script>', true);*/



	foreach ($validacion as $key => $valor)

	{

		//echo $valor;

		if($valor==0)

		{

			$validaciongeneral=false;

		}

	}

	

	if($validaciongeneral==true){

		$departamento_modifica->nombredepartamento=$_POST['mod_nombredepartamento'];

		$departamento_modifica->nombrecortodepartamento=$_POST['mod_nombredepartamento'];

		$departamento_modifica->codigosapdepartamento=$_POST['mod_codigosapdepartamento'];

		$departamento_modifica->idpais=$_POST['mod_idpais'];

		

		$modificar_departamento=$departamento_modifica->update();



		if(modificar_departamento)

		{

			echo "<script language='javascript'>alert('Departamento modificado correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 

		}		

		

		

	}

}

?>







<?php

if(isset($_POST['modificapais']))

{

	

	$validaciongeneral=true;

	if($_SESSION['MM_Username']=="")

	{

		$validaciongeneral=false;

		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede continuar")</script>';

	}

	$validacion['req_nombrepais']=validar($_POST['mod_nombrepais'],"requerido",'<script language="JavaScript">alert("No digitado el nombre del pais")</script>', true);

	/*$validacion['req_codigosappais']=validar($_POST['mod_codigosappais'],"requerido",'<script language="JavaScript">alert("No digitado el código SAP del pais")</script>', true);*/

	foreach ($validacion as $key => $valor)

	{

		if($valor==0)

		{

			$validaciongeneral=false;

		}

	}



	if($validaciongeneral==true){

		

		$pais_modifica->nombrepais=$_POST['mod_nombrepais'];

		$pais_modifica->nombrecortopais=$_POST['mod_nombrepais'];

		$pais_modifica->codigosappais=$_POST['mod_codigosappais'];

		$pais_modifica->codigoestado='100';



		$modificar_pais_nuevo=$pais_modifica->update();



		if($modificar_pais_nuevo)

		{

			echo "<script language='javascript'>alert('Pais modificado correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 

		}		

		

		

	}

}

?>



<?php if(isset($_POST['Regresar'])){

  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";

  }

?>



<?php

if(isset($_POST['anulapais'])){

$pais_modifica->codigoestado='200';

$anular_pais=$pais_modifica->update();



if($anular_pais)

		{

			echo "<script language='javascript'>alert('Pais anulado correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 

		}		

}



if(isset($_POST['anulaciudad'])){

$ciudad_modifica->codigoestado='200';

$anular_ciudad=$ciudad_modifica->update();



if($anular_ciudad)

		{

			echo "<script language='javascript'>alert('Ciudad anulada correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 

		}
}



if(isset($_POST['anuladepartamento'])){



$departamento_modifica->codigoestado='200';

$anular_departamento=$departamento_modifica->update();



if($anular_departamento)

		{

			echo "<script language='javascript'>alert('Departamento anulado correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 

		}		

}



?>