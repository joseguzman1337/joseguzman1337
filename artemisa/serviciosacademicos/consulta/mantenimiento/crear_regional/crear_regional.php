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
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
//require_once('../funciones/pear/PEAR.php');
//require_once('../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/combo.php');
require(realpath(dirname(__FILE__)).'/../../../Connections/sap.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php'); 

DB_DataObject::debugLevel(5);
$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$pais_nuevo = DB_DataObject::factory('pais');
$departamento_nuevo= DB_DataObject::factory('departamento');
$ciudad_nuevo= DB_DataObject::factory('ciudad');


/*****************************   VALIDACION DE CONEXION Y EXISTENCIA DE TABLA DE CONCEPTOS EN SAP **********/
 
/* if (isset($_POST['nombrepais']))
  {*/
    $rfcfunction = "ZFICA_SALA_CONSULT_PAISES";
    $resultstable = "ZTAB_PAISES";	

	$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

	if(!$rfchandle)
	{
	  echo "We have failed to discover the function".saprfc_error($rfc);
	  exit(1);
	} 
 
  	// traigo la tabla interna de SAP
	saprfc_table_init($rfchandle,$resultstable);
	
	
	@$rfcresults = saprfc_call_and_receive($rfchandle);
	
    
    $numrows = saprfc_table_rows($rfchandle,$resultstable);
 
 	 for ($i=1; $i <= $numrows; $i++)
	 {
	  $results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	 }	

 // var_dump($results);
    
	if ($results <> "")
	 {  // if 1 	 
	  foreach ($results as $valor => $total)
	  { // foreach 1
	     foreach ($total as $valor1 => $total1) 
		  { // foreach 2
		    if ($valor1 == "LAND1") 
			 {
			   $codigopais = $total1;
			  // echo $codigopais,"<br>";
			 }
		    if ($valor1 == "LANDX50")
			 {
			   $nombrepais = $total1;
			  // echo $nombrepais,"<br>";
			 }		   
		  } // foreach 2
          
		   $paises[] = array($codigopais,$nombrepais); 	     
	  } // foreach 1
    } // if 1 
 
          /****************************************** DEPARTAMENTOS ************************************************/
 if (isset($_POST['idpais']))
 {
	$resultstable2 = "ZTAB_PAISES";
	$rfcfunction2 = "ZFICA_SALA_CONSULT_DEPTOS";
	
	$rfchandle = saprfc_function_discover($rfc, $rfcfunction2);

	if(!$rfchandle)
	{
	  echo "We have failed to discover the function".saprfc_error($rfc);
	  exit(1);
	} 
	  
    $query_pais="select * from pais where idpais ='".$_POST['idpais']."'";
    $pais=mysql_query($query_pais,$sala) or die(mysql_error());
    $row_pais=mysql_fetch_assoc($pais);
	
	
	if ($row_pais <> "")
	 {
	   $paissap = $row_pais['codigosappais'];
	 }
	
	saprfc_table_init($rfchandle,$resultstable2);
	
	saprfc_import($rfchandle,"LAND1",$paissap);
	@$rfcresults = saprfc_call_and_receive($rfchandle);
	
    
    $numrows = saprfc_table_rows($rfchandle,$resultstable2);
 
 	 for ($i=1; $i <= $numrows; $i++)
	 {
	  $result[$i] = saprfc_table_read($rfchandle,$resultstable2,$i);
	 }	

 /// var_dump($result);
    
	if ($result <> "")
	 {  // if 1 	 
	  foreach ($result as $value => $tool)
	  { // foreach 1
	     foreach ($tool as $value1 => $tool1) 
		  { // foreach 2
		    if ($value1 == "BLAND") 
			 {
			   $codigodepartamento = $tool1;
			   //echo $codigodepartamento,"<br>";
			 }
		    if ($value1 == "BEZEI")
			 {
			   $nombredepartamento = $tool1;
			   //echo $nombredepartamento,"<br>";
			 }		   
		  } // foreach 2
          
		   $departamentos[] = array($codigodepartamento,$nombredepartamento); 	     
	  } // foreach 1
    } // if 1 
}
	 /************************************************************************************************************/
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">CREAR REGIONAL - ADICIONAR REGISTROS </p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
            <tr>
              <td colspan="5" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">ADICIONAR CIUDAD</div></td>
            </tr>
          <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2">Pa&iacute;s</span></span><span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo2">Departamento</span></span></span><span class="Estilo4">*</span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo2">Nombre Ciudad<span class="Estilo4">*</span></span></span></span></div></td>
        <td rowspan="2" colspan="2" nowrap bgcolor="#FEF7ED"><div align="center">Agregar
             <input name="agregaciudad" type="radio" onClick="enviar()">
        </div></td>
          </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php combo("idpais_ciudad","pais","idpais","nombrepais",'onChange="enviar()"','codigoestado<>200');?>

        </span></span></span></div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">
<?php 
       
	   if(isset($_POST['idpais_ciudad'])){combo("iddepartamento","departamento","iddepartamento","nombredepartamento","",'codigoestado <> 200 and idpais = '.$_POST['idpais_ciudad'].'');}
?>

        </span></span></span></div></td>

        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">          <input name="nombreciudad" type="text" id="nombreciudad" value="<?php echo @$_POST['nombreciudad']?>">
        </span></span></span></td>      

        </tr>

      <tr>

        <td colspan="5" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">ADICIONAR DEPARTAMENTO </div></td>

        </tr>

      <tr>

        <td colspan="1" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"></div> <div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo2">Pa&iacute;s</span></span></span><span class="Estilo4">*</span></div></td>

         <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo2">Nombre Departamento<span class="Estilo4">*</span></span></span></span></div></td>

       

        <td rowspan="2" colspan="4" nowrap bgcolor="#FEF7ED"><div align="center">Agregar
  
            <input name="agregadepartamento" type="radio" onClick="enviar()">
        </div></td>

      </tr>

      <tr>

        <td colspan="1" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">

        </span></span></span></div>          <div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">
  
            <?php combo("idpais","pais","idpais","nombrepais",'onChange="enviar()"','codigoestado<>200');?>
      </span> </span></span></div></td>

        <td nowrap bgcolor="#FEF7ED"><div align="center"><span class="phpmaker"><span class="style2"><span class="Estilo1">
           <!--  <input name="nombredepartamento" type="text" id="nombredepartamento" value="<?php echo @$_POST['nombredepartamento']?>"> -->
		  <select name="nombredepartamento" id="nombredepartamento">
           <option value="">Seleccionar</option>
<?php
          //$totalconceptos = array_multisort($totalconceptos);

		   foreach ($departamentos as $valor => $total)
	        { // foreach 1
	          $contador = 1;
			  $codigodep = "";
			 
			 foreach ($total as $valor1 => $total1) 
		      { // foreach 2
			    if ($contador == 1)
				 {				  
                    $codigodep = $codigodep . $total1;
				    $contador++;
				   
                 }
				 else
				if ($contador == 2)
				 {
				   $codigodep = $codigodep. "-" . $total1;
				    $contador++;
				 } 
				 
              } // foreach 2
			
              $insertacodigodep = explode("-", $codigodep); 

?>
                 <option value="<?php echo $insertacodigodep[0]."-".$insertacodigodep[1];?>"<?php $namedep = explode("-", $_POST['nombredepartamento']); if($namedep[0] == $insertacodigodep[0]){echo "selected";}?>><?php echo  $insertacodigodep[1];?></option>
<?php            

			
			} // foreach 1
?>
            </select>         
 
		   
		   
		   
        </span></span></span></div></td>   

      </tr>

      <tr>

        <td colspan="5" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">ADICIONAR PAIS </div></td>

        </tr>

      <tr>

        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Pais<span class="Estilo4">*</span></div></td>

       

        <td rowspan="2"  colspan="4" nowrap bgcolor="#FEF7ED"><div align="center" class="Estilo2"></div><div align="center">Agregar<input name="agregapais" type="radio"  onClick="enviar()">
          </div></td>

      </tr>

      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
 <select name="nombrepais" id="nombrepais">
           <option value="">Seleccionar</option>
<?php
          //$totalconceptos = array_multisort($totalconceptos);

		   foreach ($paises as $valor => $total)
	        { // foreach 1
	          $contador = 1;
			  $codigopais = "";
			 
			 foreach ($total as $valor1 => $total1) 
		      { // foreach 2
			    if ($contador == 1)
				 {				  
                    $codigopais = $codigopais . $total1;
				    $contador++;
				   
                 }
				 else
				if ($contador == 2)
				 {
				   $codigopais = $codigopais. "-" . $total1;
				    $contador++;
				 } 
				 
              } // foreach 2
			
              $insertacodigo = explode("-", $codigopais); 

?>
                 <option value="<?php echo $insertacodigo[0]."-".$insertacodigo[1];?>"<?php $name = explode("-", $_POST['nombrepais']); if($name[0] == $insertacodigo[0]){echo "selected";}?>><?php echo  $insertacodigo[1];?></option>
<?php            

			
			} // foreach 1
?>
            </select>         

        </div></td>
      </tr>
      <tr>

        <td colspan="5" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">

          <input name="Regresar" type="submit" id="Regresar" value="Regresar">

        </div></td>

        </tr>

    </table></td>

  </tr>

</table>



</form>



<?php
if(isset($_POST['agregapais']))
{
	
	$query_pais="select * from pais where codigosappais ='".$name[0]."'";
    $pais=mysql_query($query_pais,$sala) or die(mysql_error());
    $row_pais=mysql_fetch_assoc($pais);
    
	if ($row_pais <> "")
	 {
	   echo '<script language="JavaScript">alert("Pais ya existe"); </script>';
	   exit();
	 }
	 
	$validaciongeneral=true;
	$validacion['req_nombrepais']=validar($_POST['nombrepais'],"requerido",'<script language="JavaScript">alert("Debe seleccionar un pais")</script>', true);
	/*$validacion['req_codigosappais']=validar($_POST['codigosappais'],"requerido",'<script language="JavaScript">alert("No digitado el código SAP del pais")</script>', true);*/
    
	
	foreach ($validacion as $key => $valor)
	{
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}

	if($validaciongeneral==true){
	
		$pais_nuevo->nombrepais=$name[1];

		$pais_nuevo->nombrecortopais=$name[1];

		$pais_nuevo->codigosappais=$name[0];

		$pais_nuevo->codigoestado='100';

		$insertar_pais_nuevo=$pais_nuevo->insert();

		if($insertar_pais_nuevo)
		{
			echo "<script language='javascript'>alert('Pais agregado correctamente');</script>";
			echo "<script language='javascript'>window.location.reload('crear_regional.php');</script>"; 
		}
	}
}

?>



<?php

if(isset($_POST['agregadepartamento']))

{
    $query_depar="select * from departamento where codigosapdepartamento ='".$namedep[0]."'";
    $depar=mysql_query($query_depar,$sala) or die(mysql_error());
    $row_depar=mysql_fetch_assoc($depar);
    
	if ($row_depar <> "")
	 {
	   echo '<script language="JavaScript">alert("Departamento ya existe"); </script>';
	   exit();
	 }
	 
  
  
	$validaciongeneral=true;
	$validacion['req_nombredepartamento']=validar($_POST['nombredepartamento'],"requerido",'<script language="JavaScript">alert("No digitado el nombre del departamento")</script>', true);
	$validacion['req_idpais']=validar($_POST['idpais'],"requerido",'<script language="JavaScript">alert("No seleccionado el pais al que pertenece el departamento")</script>', true);	

	

	foreach ($validacion as $key => $valor)

	{

		if($valor==0)

		{

			$validaciongeneral=false;

		}

	}



	if($validaciongeneral==true){

		$departamento_nuevo->nombredepartamento=$namedep[1];

		$departamento_nuevo->nombrecortodepartamento=$namedep[1];

		$departamento_nuevo->idpais=$_POST['idpais'];

		$departamento_nuevo->codigosapdepartamento=$namedep[0];

		$departamento_nuevo->codigoestado='100';

		$insertar_departamento_nuevo=$departamento_nuevo->insert();

		if(insertar_departamento_nuevo)

		{

			echo "<script language='javascript'>alert('Departamento agregado correctamente');</script>";

			echo "<script language='javascript'>window.location.reload('crear_regional.php');</script>"; 

		}		

		

		}

}

?>



<?php
if(isset($_POST['agregaciudad']))
{
	$query_ciud="select * from ciudad where nombreciudad ='".$_POST['nombreciudad']."'";
    $ciud=mysql_query($query_ciud,$sala) or die(mysql_error());
    $row_ciud=mysql_fetch_assoc($ciud);
    
	if ($row_ciud <> "")
	 {
	   echo '<script language="JavaScript">alert("Ciudad ya existe"); </script>';
	   exit();
	 }

	$validaciongeneral=true;
	$validacion['req_nombreciudad']=validar($_POST['nombreciudad'],"requerido",'<script language="JavaScript">alert("No digitado el nombre del ciudad")</script>', true);
	$validacion['req_iddepartamento']=validar($_POST['iddepartamento'],"requerido",'<script language="JavaScript">alert("No seleccionado el departamento al que pertenece el ciudad")</script>', true);	

	foreach ($validacion as $key => $valor)
	{
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}

	if($validaciongeneral==true){
		$ciudad_nuevo->nombreciudad=$_POST['nombreciudad'];
		$ciudad_nuevo->nombrecortociudad=$_POST['nombreciudad'];
		$ciudad_nuevo->iddepartamento=$_POST['iddepartamento'];
		$ciudad_nuevo->codigosapciudad='1';
		$ciudad_nuevo->codigoestado='100';
		$insertar_ciudad_nuevo=$ciudad_nuevo->insert();
		if(insertar_ciudad_nuevo)
		{
			echo "<script language='javascript'>alert('Ciudad agregada correctamente');</script>";
			echo "<script language='javascript'>window.location.reload('crear_regional.php');</script>"; 

		}	

	}

}

?> <?php if(isset($_POST['Regresar'])){

  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";

  }

?>