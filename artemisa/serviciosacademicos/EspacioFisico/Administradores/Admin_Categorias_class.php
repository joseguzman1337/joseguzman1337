<?php
class Admin_Categorias{
    public function Principal(){
        ?>
        <fieldset style="width: auto;">
    	<legend>Creaci&oacute;n Categor&iacute;as Espacio F&iacute;sico.</legend>
    	   <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 50%; margin-left: 10%;">
                <thead>
                    <tr>
                        <th>Nueva Categor&iacute;a<samp style="color: red;">&nbsp;*</samp></th>
                        <th>Permitir Asignaci&oacute;n</th>
                    </tr>
                    <tr>    
                        <th>
                            <input type="text" id="Categoria" name="Categoria" autocomplete="off" style="text-align: center;" size="40" placeholder="Digite Nombre Categor&iacute;a" />
                        </th>
                        <th>
                            <input type="checkbox" id="ActivarPermitir" name="ActivarPermitir" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" id="View">
                        <?PHP $this->ViewCategorias()?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="SaveCategoria" name="SaveCategoria" value="Guardar" style="margin-left: 6%;" class="Boton" onclick="SaveCategoria()" />
                        </td>
                    </tr>
                </tbody>
           </table>
        <?PHP
    }//public function Principal
    public function ViewCategorias(){
        global $db,$userid;
        
          $SQL='SELECT

                EspaciosFisicosId AS id,
                Nombre,
                codigoestado,
                PermitirAsignacion
                
                FROM EspaciosFisicos
                
                
                ORDER BY Nombre ASC';
        
            if($View=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de View<br><br>'.$SQL;
                die;
            }
        ?>
        <fieldset style="width: auto; margin-left: 6%;">
        <legend>Categor&iacute;as Existentes</legend>
            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 80%; margin-left: 10%;">
                <tr>
                    <td>Nombre</td>
                    <td>Permitir Aignaci&oacute;n</td>
                    <td>Opciones</td>
                </tr>
                <?PHP 
                if(!$View->EOF){
                    $c = 0;
                    while(!$View->EOF){
                        $x = $this->ispar($c);
                        if($x==1){
                            $color = 'style="background:#F2EAFB"';
                        }else{
                            $color = 'style="background:#F7FFFF"';
                        }
                        if($View->fields['codigoestado']==100){
                           $opacity_OK     = 'opacity:0.4;';
                           $opacity_delete = '';
                           $onclick_OK        = '';
                           $onclick_delete    = "CambiarEstado('".$View->fields['id']."','200');";
                        }else{
                           $opacity_OK        = '';
                           $opacity_delete    = 'opacity:0.4;';
                           $onclick_OK        = "CambiarEstado('".$View->fields['id']."','100');";
                           $onclick_delete    = '';
                        }
                        if($View->fields['PermitirAsignacion']==1){
                            $Check  = 'checked="checked"';
                        }else{
                            $Check  = '';
                        }
                        
                        ?>
                        <tr <?PHP echo $color?>>
                            <td id="<?PHP echo $View->fields['id']?>" style="cursor: pointer;" contenteditable="true" title="Para Editar dar Click"><?PHP echo $View->fields['Nombre']?>
                                <!--<span id="label_<?PHP echo $View->fields['id']?>"></span>
                                <input type="text" id="TextoEdit_<?PHP echo $View->fields['id']?>" name="TextoEdit_<?PHP echo $View->fields['id']?>" value="<?PHP echo $View->fields['Nombre']?>" style="text-align: center; display: none;" />-->
                            </td>
                            <td>
                                <input type="checkbox" <?PHP echo $Check?> id="ActivarPermitir_<?PHP echo $View->fields['id']?>" name="ActivarPermitir_<?PHP echo $View->fields['id']?>" onclick="CambiarActivar(<?PHP echo $View->fields['id']?>)" />
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
                        $View->MoveNext();
                    }
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
    }//public function ViewCategorias
    public function ispar($numero){
        if ($numero%2==0){
            //echo "el $numero es par";
            $r = 0;
        }else{
             //echo "el $numero es impar";
             $r = 1;
        }
        return $r;
    }//public function ispar
}//class

?>