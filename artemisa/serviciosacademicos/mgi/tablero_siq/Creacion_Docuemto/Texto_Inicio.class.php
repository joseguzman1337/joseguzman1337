 <?PHP 
 class Texto_InicialDocumento{
	 
	 public function Principal(){#public function Principal()
		 
		 ?>
         <br />
         <fieldset style="width:98%;">
         	<legend>Descripcion Inical</legend>
         	<table border="0" align="center" cellpadding="0" cellspacing="0" width="95%">
            	<tr>
                	<td class="Borde"><strong>Seleccione Documento</strong></td>
                    <td class="Borde">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="2" class="Borde"><?PHP $this->Autocomplete('Documento','Digite el Documento a Buscar','FormatDocumento','AutocompletDocumento','id_Documento');?></td>
                </tr>
                <tr id="Datos_Tr" style="visibility:collapse">
                	<td class="Borde">
                    	<table border="0" align="center" cellpadding="0" cellspacing="0" width="95%">
                        	<tr>
                            	<td><strong>Nombre Documento:</strong></td>
                                <td id="Nombre"></td>
                            </tr>
                            <tr>
                            	<td><strong>Entidad a Presentar:</strong></td>
                                <td id="Entidad"></td>
                            </tr>
                            <tr>
                            	<td><strong>Tipo de Documento:</strong></td>
                                <td id="Tipo"></td>
                            </tr>
                            <tr>
                            	<td><strong>Fecha Inicio de Vigencia:</strong></td>
                                <td id="Inicial"></td>
                            </tr>
                            <tr>
                            	<td><strong>Fecha Final de Vigencia:</strong></td>
                                <td id="Final"></td>
                            </tr>
                        </table>	
                    </td>
                </tr>
            </table>
            <br>
            <hr style="width:90%; text-align:center">
            <br>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="95%">
            	<tr>
                	<td align="center" class="Borde"><strong>Titulo</strong><span style="color:#F00">*</span></td>
                </tr>
                <tr>
                	<td align="center" class="Borde">
                    	<input type="text" id="Titulo" name="Titulo" style="text-align:center" onClick="FormatTitulo();" size="50" autocomplete="off" placeholder="Titulo">
                    </td>
                </tr>
                <tr>
                	<td class="Borde">&nbsp;</td>
                </tr>
                <tr>
                	<td class="Borde">
                    	<fieldset style="width:98%;">
         					<legend><strong>Cuerpo</strong><span style="color:#F00">*</span></legend>
                                <table border="0" align="center" cellpadding="0" cellspacing="0" width="95%">
                                    <tr>
                                        <td align="center" class="Borde">
                                        	<div id="menuEditor" style="width: 792px;"></div>
                                        	<textarea id="Cuerpo" name="Cuerpo" rows="30" cols="90" placeholder=" Descripcion Del Cuerpo del Documento." class="grid-8-12" style="width: 800px; height: 360px;"></textarea>
                                        </td>
                                    </tr>
                                </table>
                        </fieldset>        
                    </td>
                </tr>
                <tr>
                	<td class="Borde">&nbsp;</td>
                </tr>
                <tr>
                	<td class="Borde" align="right">
                    	<table border="0" align="center" cellpadding="0" cellspacing="0" width="95%">
                        	<tr>
                            	<td width="67%" height="41" align="right" class="Borde"><strong>Autor</strong></td>
                                <td width="33%" align="right" class="Borde">
                                	<input type="text" id="Autor" name="Autor" style=" text-align:center" size="30" onClick="FormatAutor();" autocomplete="off" placeholder="Nombre del Autor">
                                </td>
                            </tr>
                            <tr>
                            	<td align="right" class="Borde"><strong>Dependencia</strong></td>
                                <td align="right" class="Borde">
                                	<input type="text" id="Dependencia" name="Dependencia" style=" text-align:center" size="30" onClick="FormatDependencia();" autocomplete="off" placeholder="Dependencia">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <input type="button" id="Save" name="Save" value="Guardar" onclick="SaveInfo();" class="first" />
         </fieldset>   
         <?PHP
		 }#public function Principal()
	public function Documento(){
		?>
        <select id="Documento" name="Documento">
        	<option value="-1">Seleccione</option>
        </select>
        <?PHP
		}
	public function Autocomplete($Nombre,$TituloFondo='',$OnClick,$AutoComplet,$Nom_Hidden){
		?>
        <input type="text"  id="<?PHP echo $Nombre?>" name="<?PHP echo $Nombre?>" autocomplete="off" placeholder="<?PHP echo $TituloFondo?>"  style="text-align:center;width:90%;" size="70" onClick="<?PHP echo $OnClick?>();" onKeyPress="<?PHP echo $AutoComplet?>();" /><input type="hidden" id="<?PHP echo $Nom_Hidden?>" />
        <?PHP
		}		 
}#Fin Class
 ?>