<?php
class Admin_Actividades{
    public function Principal(){
        ?>
        <fieldset style="width: auto;">
    	<legend>Creaci&oacute;n Tipo Actividad</legend>
    	   <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 50%; margin-left: 10%;">
                <thead>
                    <tr>
                        <th>Nueva Actividad<samp style="color: red;">&nbsp;*</samp></th>
                        <th>
                            <input type="text" id="Actividad" name="Actividad" autocomplete="off" style="text-align: center;" size="40" placeholder="Digite Nombre Actividad" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                        <?PHP $this->ViewActividad()?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="SaveActividad" name="SaveActividad" value="Guardar" style="margin-left: 6%;" class="Boton" />
                        </td>
                    </tr>
                </tbody>
           </table>
        <?PHP
    }//public function Principal
    public function ViewActividad(){
        global $db,$userid;
        
        ?>
        <fieldset style="width: auto; margin-left: 6%;">
        <legend>Actividades Existents</legend>
            <ul>
                <li style="color: gray;">No hay Informaci&oacute;n</li>
            </ul>
        </fieldset>
        <?PHP
    }//public function ViewActividad
}//class

?>
