<?php
class OtherPermisosEspaciosFiscos{
    public function Display($db,$C_Permiso){
        ?>
        <br />
        <div id="container">
            <fieldset>
                <legend>Consola de Responsabilidad de Espacios Físicos</legend>
                <form id="FromOtherPermiso">
                <input type="hidden" id="actionID" name="actionID" value="" />
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                    <thead>
                        <tr>
                            <th >Usuario</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <?PHP $C_Permiso->AutoBox('BuscarUser','FormatUser','BuscarUser_id','AutoCompleteUser','Digite el Usuario o Nombre del Usuario o Numero Documento');?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Categoria Espacio Físico</strong></td>
                        </tr>
                        <tr>    
                            <td>
                                <div id="Div_EspacioFisico">
                                <?PHP $C_Permiso->EspaciosFisicos($db,'','BuscarTipoAulaDetalle');?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Aula</strong></td>
                        </tr>
                        <tr>    
                            <td>
                                <div id="Div_TipoAula">
                                    <select name="TipoAula" id="TipoAula">
                                        <option value="-1"></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Espacio Físico</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <div id="Div_EspacioFisicoDetalle">
                                    <select name="EspacioFisicoDetalle" id="EspacioFisicoDetalle">
                                        <option value="-1"></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="button" id="SaveEsapcioNew" value="Guardar" onclick="SaveCalsificacion()" />
                            </td>
                        </tr>
                    </tbody>     
                </table>
                </form>
                <table align="center">
                    <tr>
                        <td>
                            <div id="VerClasificacionEspacio"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            
        </div>        
        <?PHP
    }//public function Diaplay    
    public function EspcaioFisicoDetalle($db,$id,$Espacio){
          $SQL='SELECT
                        ClasificacionEspaciosId,
                        Nombre
                FROM
                        ClasificacionEspacios
                WHERE
                        codigotiposalon="'.$id.'"
                        AND
                        EspaciosFisicosId="'.$Espacio.'"
                        AND
                        codigoestado=100';
                
          if($EspaciosDetalle=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de del Detalle Espacio Fisico...<br><br>'.$SQL;
                die;
          }  
          
          ?>
          <select id="ClasificacionEspacio" name="ClasificacionEspacio">
            <option value="-1"></option>
            <?PHP 
            while(!$EspaciosDetalle->EOF){
                ?>
                <option value="<?PHP echo $EspaciosDetalle->fields['ClasificacionEspaciosId']?>"><?PHP echo $EspaciosDetalle->fields['Nombre']?></option>
                <?PHP
                $EspaciosDetalle->MoveNext();
            }
            ?>
          </select>
          <?PHP             
    }//public function EspcaioFisicoDetalle
    public function VerClasificacionEspacio($db,$User){
        
        $Info = $this->ConsultaClasificacionResponsabilidad($db,$User);
        
        ?>
        <fieldset>
            <legend><?PHP echo $Info[0]['NameUser']?></legend>
            <table>
                <?PHP 
                for($i=0;$i<count($Info);$i++){
                    ?>
                    <tr>
                        <td><?PHP echo $i+1?></td>
                        <td><?PHP echo $Info[$i]['Nombre']?></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>
                            <img src="../../mgi/images/delete.png" title="Eliminar" style="cursor: pointer;;margin: 6px 0;" width="20" onclick="EliminarClasificacionResponsabilidad('<?PHP echo $User?>','<?PHP echo $Info[$i]['id']?>')" />
                        </td>
                    </tr>
                    <?PHP
                }//for
                ?>
            </table>
        </fieldset>
        <?PHP
    }//public function VerClasificacionEspacio
    public function ConsultaClasificacionResponsabilidad($db,$User){
          $SQL='SELECT
                	c.ClasificacionEspaciosId AS id,
                	c.Nombre,
                    CONCAT(u.nombres," ",u.apellidos," :: ",u.usuario) AS NameUser
  
                FROM
                	ResponsableClasificacionEspacios r
                    INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = r.ClasificacionEspaciosId
                    INNER JOIN usuario  u ON u.idusuario=r.idusuario
                
                WHERE
                	r.idusuario ="'.$User.'"
                AND c.codigoestado = 100
                AND r.CodigoEstado=100';
                
          if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Clasificacion Responsabilidad...<br><br>'.$SQL;
            die;
          }     
          
          $C_Data = $Data->GetArray();
          
          return $C_Data; 
    }//public function ConsultaClasificacionResponsabilidad
}//class
?>