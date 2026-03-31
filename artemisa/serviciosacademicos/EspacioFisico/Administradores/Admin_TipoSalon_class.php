<?php
class Admin_TipoSalon{
    public function Principal(){
        global $db;
        ?>
        <fieldset style="width: auto;">
    	<legend>Creaci&oacute;n Tipo Sal&oacute;n</legend>
    	   <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 50%; margin-left: 10%;">
                <thead>
                    <tr>
                        <th>Nuevo Tipo Sal&oacute;n<samp style="color: red;">&nbsp;*</samp></th>
                        <th>
                            <input type="text" id="T_Salon" name="T_Salon" autocomplete="off" style="text-align: center;" size="40" placeholder="Digite Nombre Tipo Salon" />
                        </th>
                    </tr>
                    <tr>
                        <th>Espacio F&iacute;sico</th>
                        <th>
                            <?PHP $this->SelectEspacioFisico($db,'EspacioFisico')?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" id="View">
                        <?PHP $this->ViewTipoSalon()?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="SaveSalon" name="SaveSalon" value="Guardar" style="margin-left: 6%;" class="Boton" onclick="SaveSalon();" />
                        </td>
                    </tr>
                </tbody>
           </table>
        <?PHP
    }//public function Principal
    public function SelectEspacioFisico($db,$name,$id='',$Funcion='',$valor=''){
        
          $SQL='SELECT
                	EspaciosFisicosId AS id,
                	Nombre
                FROM
                	EspaciosFisicos
                WHERE
                	codigoestado = 100
                AND PermitirAsignacion = 1 OR EspaciosFisicosId=6 ORDER BY Nombre ASC';
                
           if($EspacioFisico=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Espacios Fisicos...<br><br>'.$SQL;
                die;
           }  
           
           ?>
           <select id="<?PHP echo $name?>" name="<?PHP echo $name?>" onchange="<?PHP echo $Funcion?>('<?PHP echo $valor?>')">
            <option value="-1"></option>
            <?PHP 
            $selected = '';
             while(!$EspacioFisico->EOF){
                
                if($id){
                    if($id==$EspacioFisico->fields['id']){
                        $selected = 'selected="selected"';
                    }else{
                        $selected = '';
                    }
                }
                ?>
                <option <?PHP echo $selected?> value="<?PHP echo $EspacioFisico->fields['id']?>"><?PHP echo $EspacioFisico->fields['Nombre']?></option>
                <?PHP
                $EspacioFisico->MoveNext();
               }   
           ?>
           </select>
           <?PHP
          
    }//public function SelectEspacioFisico
    public function ViewTipoSalon(){ 
        global $db,$userid;
        
        include_once('Admin_Categorias_class.php'); $C_Admin_Categorias = new Admin_Categorias(); 
        
          $SQL='SELECT
                	t.codigotiposalon AS id,
                	t.nombretiposalon AS T_Salon,
                	t.codigoestado,
                    e.EspaciosFisicosId
                FROM
                	tiposalon t INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=t.EspaciosFisicosId
                    
                    ORDER BY t.nombretiposalon ASC';
                
          if($TipoSalon=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Tipo Salon....<br><br>'.$SQL;
            die;
          }      
        
        ?>
        <fieldset style="width: auto; margin-left: 6%;">
        <legend>Tipo de Salones Existents</legend>
            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 80%; margin-left: 10%;">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo Espacio F&iacute;sico</th>
                    <th>Opciones</th>
                </tr>
            <?PHP 
            if(!$TipoSalon->EOF){
                $c = 0;
                while(!$TipoSalon->EOF){
                    $r = $C_Admin_Categorias::ispar($c);
                    if($r==1){
                        $color = 'style="background:#F2EAFB"';
                    }else{
                        $color = 'style="background:#F7FFFF"';
                    }
                    if($TipoSalon->fields['codigoestado']==100){
                           $opacity_OK     = 'opacity:0.4;';
                           $opacity_delete = '';
                           $onclick_OK        = '';
                           $onclick_delete    = "CambiarEstado('".$TipoSalon->fields['id']."','200');";
                        }else{
                           $opacity_OK        = '';
                           $opacity_delete    = 'opacity:0.4;';
                           $onclick_OK        = "CambiarEstado('".$TipoSalon->fields['id']."','100');";
                           $onclick_delete    = '';
                        }
                    ?>
                    <tr <?PHP echo $color?> >
                        <td id="<?PHP echo $TipoSalon->fields['id']?>" style="cursor: pointer;" contenteditable="true" title="Para Editar dar Click"><?PHP echo $TipoSalon->fields['T_Salon']?></td>
                        <td>
                            <?PHP $this->SelectEspacioFisico($db,'EsapcioFisico_'.$TipoSalon->fields['id'],$TipoSalon->fields['EspaciosFisicosId'],'EjecutarCambio',$TipoSalon->fields['id'])?>
                        </td>
                        <td style="text-align: right;" width="22">
                            <img  src="../../mgi/images/Check.png" style="  cursor: pointer;<?PHP echo $opacity_OK?> " width="20" title="Activar" onclick="<?PHP echo $onclick_OK?>" />
                        </td>
                        <td style="text-align: right;" width="22">
                            <img  src="../../mgi/images/delete.png" style=" cursor: pointer;<?PHP echo $opacity_delete?>" width="20" title="Inactivar" onclick="<?PHP echo $onclick_delete?>" />  
                        </td>
                    </tr>
                    <?PHP
                    $c++;
                    $TipoSalon->MoveNext();
                }
                ?>
                <input type="hidden" id="Index" name="Index" value="<?PHP echo $c?>" />
                <?PHP
            }else{
                ?>
                <tr>
                    <td style="text-align: center;color: gray;">No hay Informaci&oacute;n</td>
                </tr>
                
                <?PHP 
            }
            ?>
            </table>
        </fieldset>
        <?PHP
    }//public function ViewTipoSalon
}//class

?>