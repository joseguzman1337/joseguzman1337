<?
   $pageName= "idiomas2";
   require_once "../common/includes.php";
   SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);    
   require "../layouts/top_layout_admin.php";	
   global $IdiomaSitio;
   $Mensajes = Comienzo ($pageName,$IdiomaSitio);  


   if (empty($Id))
   		$Id = 0;
      
   if (!empty($Id)){
		$idioma= $servicesFacade->getIdioma($Id);
		if (is_a($idioma, "DB_Exception")){
			$mensaje_error= $Mensajes["error.accesoBBDD"];
			$excepcion = $idioma;
			require "../common/mostrar_error.php";
		}
   }

?>
<script language="JavaScript" type="text/javascript">
  function validar_form(){
  	if (document.getElementsByName('Nombre').item(0).value==''){
  		alert('<?=$Mensajes["warning.faltaNombreIdioma"];?>');
		return false;
  	}
   	return true;
  }
</script>
<form name="form1" method="get" action="actualizar_idioma.php" onsubmit="return validar_form();">
	<input type="hidden" name="Id" value=<?= $Id; ?> />
	
<table class="table-form" width="80%" align="center" cellpadding="1" cellspacing="1">	
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"/><?= $Mensajes["et-1"]?>
		</td>
	</tr>
    <tr>
        <th><?= $Mensajes["ec-1"];?></th>
        <td><input type="text"  name="Nombre" size="54" value="<? if (!empty($idioma))echo $idioma["Nombre"]; ?>"/></td>
    </tr>
    <tr>               					
	    <th><?= $Mensajes["ec-2"] ;?></th>
	    <td><input type="text"  name="0_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["0_Dia"]; ?>"/></td>
    </tr>		                  	  					
	<tr>
	    <th><?= $Mensajes["ec-3"];?></th>
	    <td><input type="text"  name="1_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["1_Dia"]; ?>"/></td>
	</tr>		                  	  					
	<tr>
	    <th><?= $Mensajes["ec-4"];?></th>
	    <td><input type="text"  name="2_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["2_Dia"]; ?>"/></td>
    </tr>		                  	  					
    <tr>
	    <th><?= $Mensajes["ec-5"];?></th>
	    <td><input type="text"  name="3_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["3_Dia"]; ?>"/></td>
    </tr>		                  	  					
    <tr>
	    <th><?= $Mensajes["ec-6"];?></th>
	    <td><input type="text"  name="4_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["4_Dia"]; ?>"/></td>
    </tr>		                  	  					
    <tr>
	    <th><?= $Mensajes["ec-7"];?></th>
	    <td><input type="text"  name="5_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["5_Dia"]; ?>"/></td>
    </tr>		                  	  					
    <tr>
	    <th><?= $Mensajes["ec-8"];?></th>
	    <td><input type="text"  name="6_Dia" size="45" value="<? if (!empty($idioma))echo $idioma["6_Dia"]; ?>"/></td>
    </tr>
    <tr>
        <th><?= $Mensajes["ec-9"] ;?></th>
        <td><input type="text"  name="1_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["1_Mes"]; ?>"/></td>
    </tr>	
    <tr>
	    <th><?= $Mensajes["ec-10"] ;?></th>
	    <td><input type="text"  name="2_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["2_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-11"] ;?></th>
	    <td><input type="text"  name="3_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["3_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-12"] ;?></th>
	    <td><input type="text"  name="4_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["4_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-13"] ;?></th>
	    <td><input type="text"  name="5_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["5_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-14"] ;?></th>
	    <td><input type="text"  name="6_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["6_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-15"] ;?></th>
	    <td><input type="text"  name="7_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["7_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-16"] ;?></th>
	    <td><input type="text"  name="8_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["8_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-17"] ;?></th>
	    <td><input type="text"  name="9_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["9_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-18"] ;?></th>
	    <td><input type="text"  name="10_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["10_Mes"]; ?>"/></td>
	</tr>	
	<tr>
	    <th><?= $Mensajes["ec-19"] ;?></th>
	    <td><input type="text"  name="11_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["11_Mes"]; ?>"/></td>
	</tr>	
	
	<tr>
	    <th><?= $Mensajes["ec-20"] ;?></th>
	    <td><input type="text"  name="12_Mes" size="45" value="<? if (!empty($idioma))echo $idioma["12_Mes"]; ?>"/></td>
	</tr>



	<tr>
		<th><?= $Mensajes["ec-21"] ;?></th>
		<td><input type="text"  name="Evento1" size="45" value="<? if (isset($idioma))echo $idioma["Evento1"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-22"] ;?></th>
		<td><input type="text"  name="Evento2" size="45" value="<? if (isset($idioma))echo $idioma["Evento2"]; ?>"></td>

	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-23"] ;?></th>
		<td><input type="text"  name="Evento3" size="45" value="<? if (isset($idioma))echo $idioma["Evento3"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-24"] ;?></th>
		<td><input type="text"  name="Evento4" size="45" value="<? if (isset($idioma))echo $idioma["Evento4"]; ?>"></td>

	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-25"] ;?></th>
		<td><input type="text"  name="Evento5" size="45" value="<? if (isset($idioma))echo $idioma["Evento5"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-26"] ;?></th>
		<td><input type="text"  name="Evento6" size="45" value="<? if (isset($idioma))echo $idioma["Evento6"]; ?>"></td>

	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-27"] ;?></th>
		<td><input type="text"  name="Evento7" size="45" value="<? if (isset($idioma))echo $idioma["Evento7"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-28"] ;?></th>
		<td><input type="text"  name="Evento8" size="45" value="<? if (isset($idioma))echo $idioma["Evento8"]; ?>"></td>

	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-29"] ;?></th>
		<td><input type="text"  name="Evento9" size="45" value="<? if (isset($idioma))echo $idioma["Evento9"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-30"] ;?></th>
		<td><input type="text"  name="Evento10" size="45" value="<? if (isset($idioma))echo $idioma["Evento10"]; ?>"></td>

	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-31"] ;?></th>
		<td><input type="text"  name="Evento11" size="45" value="<? if (isset($idioma))echo $idioma["Evento11"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["ec-32"] ;?></th>
		<td><input type="text"  name="Evento12" size="45" value="<? if (isset($idioma))echo $idioma["Evento12"]; ?>"></td>

	</tr>			
	<tr>
		<th><?= $Mensajes["campo.evento13"] ;?></th>
		<td><input type="text"  name="Evento13" size="45" value="<? if (isset($idioma))echo $idioma["Evento13"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["campo.evento14"] ;?></th>
		<td><input type="text"  name="Evento14" size="45" value="<? if (isset($idioma))echo $idioma["Evento14"]; ?>"></td>

	</tr>	          					
	<tr>
		<th><?= $Mensajes["campo.evento15"] ;?></th>
		<td><input type="text"  name="Evento15" size="45" value="<? if (isset($idioma))echo $idioma["Evento15"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["campo.evento16"] ;?></th>
		<td><input type="text"  name="Evento16" size="45" value="<? if (isset($idioma))echo $idioma["Evento16"]; ?>"></td>
	</tr>	          					
	<tr>
		<th><?= $Mensajes["campo.evento17"] ;?></th>
		<td><input type="text"  name="Evento17" size="45" value="<? if (isset($idioma))echo $idioma["Evento17"]; ?>"></td>
	</tr>	
				  	  <tr>
		<th><?= $Mensajes["ec-33"] ;?></th>
		<td><input type="text"  name="Eventos_Mail_1" size="45" value="<? if (isset($idioma))echo $idioma["Eventos_Mail_1"]; ?>"></td>
	</tr>          					
	<tr>
		<th><?= $Mensajes["ec-34"] ;?></th>
		<td><input type="text"  name="Eventos_Mail_2" size="45" value="<? if (isset($idioma))echo $idioma["Eventos_Mail_2"]; ?>"></td>
	</tr>          					
	<tr>

		<th><?= $Mensajes["ec-35"] ;?></th>
		<td><input type="text"  name="Eventos_Mail_3" size="45" value="<? if (isset($idioma))echo $idioma["Eventos_Mail_3"]; ?>"></td>
	</tr>    
	                        					
	<tr>
		<th><?= $Mensajes["ec-36"] ;?></th>
		<td><input type="text"  name="Estado_1" size="45" value="<? if (isset($idioma))echo $idioma["Estado_1"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-38"] ;?></th>
		<td><input type="text"  name="Estado_2" size="45" value="<? if (isset($idioma))echo $idioma["Estado_2"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-40"] ;?></th>
		<td><input type="text"  name="Estado_3" size="45" value="<? if (isset($idioma))echo $idioma["Estado_3"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-42"] ;?></th>
		<td><input type="text"  name="Estado_4" size="45" value="<? if (isset($idioma))echo $idioma["Estado_4"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-44"] ;?></th>
		<td><input type="text"  name="Estado_5" size="45" value="<? if (isset($idioma))echo $idioma["Estado_5"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-46"] ;?></th>
		<td><input type="text"  name="Estado_6" size="45" value="<? if (isset($idioma))echo $idioma["Estado_6"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-48"] ;?></th>
		<td><input type="text"  name="Estado_7" size="45" value="<? if (isset($idioma))echo $idioma["Estado_7"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-50"] ;?></th>
		<td><input type="text"  name="Estado_8" size="45" value="<? if (isset($idioma))echo $idioma["Estado_8"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-52"] ;?></th>
		<td><input type="text"  name="Estado_9" size="45" value="<? if (isset($idioma))echo $idioma["Estado_9"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-54"] ;?></th>
		<td><input type="text"  name="Estado_10" size="45" value="<? if (isset($idioma))echo $idioma["Estado_10"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["campo.estadoS11"] ;?></th>
		<td><input type="text"  name="Estado_11" size="45" value="<? if (isset($idioma))echo $idioma["Estado_11"]; ?>"></td>
	</tr>
	<tr>	
		<th><?= $Mensajes["campo.estadoS12"] ;?></th>
		<td><input type="text"  name="Estado_12" size="45" value="<? if (isset($idioma))echo $idioma["Estado_12"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["campo.estadoS13"] ;?></th>
		<td><input type="text"  name="Estado_13" size="45" value="<? if (isset($idioma))echo $idioma["Estado_13"]; ?>"></td>
	</tr>	
	<tr>
		<th><?= $Mensajes["campo.estadoS14"] ;?></th>
		<td><input type="text"  name="Estado_14" size="45" value="<? if (isset($idioma))echo $idioma["Estado_14"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.estadoS15"] ;?></th>
		<td><input type="text"  name="Estado_15" size="45" value="<? if (isset($idioma))echo $idioma["Estado_15"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.estadoS16"] ;?></th>
		<td><input type="text"  name="Estado_16" size="45" value="<? if (isset($idioma))echo $idioma["Estado_16"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.estadoS17"] ;?></th>
		<td><input type="text"  name="Estado_17" size="45" value="<? if (isset($idioma))echo $idioma["Estado_17"]; ?>"></td>
	</tr>
	                 <tr>
		<th><?= $Mensajes["ec-56"] ;?></th>
		<td><input type="text"  name="Tipo_Material_1" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Material_1"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-57"] ;?></th>
		<td><input type="text"  name="Tipo_Material_2" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Material_2"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-58"] ;?></th>
		<td><input type="text"  name="Tipo_Material_3" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Material_3"]; ?>"></td>

	</tr>
	<tr>
		<th><?= $Mensajes["ec-59"] ;?></th>
		<td><input type="text"  name="Tipo_Material_4" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Material_4"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-60"] ;?></th>
		<td><input type="text"  name="Tipo_Material_5" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Material_5"]; ?>"></td>
	</tr>		
	<tr>
		<th><?= $Mensajes["ec-61"] ;?></th>
		<td><input type="text"  name="Perfil_Biblio_1" size="45" value="<? if (isset($idioma))echo $idioma["Perfil_Biblio_1"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-62"] ;?></th>
		<td><input type="text"  name="Perfil_Biblio_2" size="45" value="<? if (isset($idioma))echo $idioma["Perfil_Biblio_2"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-63"] ;?></th>
		<td><input type="text"  name="Perfil_Biblio_3" size="45" value="<? if (isset($idioma))echo $idioma["Perfil_Biblio_3"]; ?>"></td>
	</tr>	    
	<tr>
		<th><?= $Mensajes["ec-64"] ;?></th>
		<td><input type="text"  name="Tipo_Pedido_1" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Pedido_1"]; ?>"></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-65"] ;?></th>
		<td><input type="text"  name="Tipo_Pedido_2" size="45" value="<? if (isset($idioma))echo $idioma["Tipo_Pedido_2"]; ?>"></td>
	</tr>
                    
	<tr>
		<th><?= $Mensajes["ec-66"];?></th>
		<td><input type="checkbox"  name="Predeterminado" size="45" value="ON" <? if (isset($idioma) && ($idioma["Predeterminado"]==1))  echo "checked"?>/></td>
	</tr>
	<tr>
        <th>&nbsp;</th>
        <td colspan="2">
        	<input type="submit"  value="<? if (empty($Id)) echo $Mensajes["bot-1"]; else echo $Mensajes["bot-2"];?>" name="B1" />
			<input type="reset"  value="<?= $Mensajes["bot-3"];?>" name="B2" />                 
        </td>
    </tr>
</table>
</form>

<? require "../layouts/base_layout_admin.php";?>