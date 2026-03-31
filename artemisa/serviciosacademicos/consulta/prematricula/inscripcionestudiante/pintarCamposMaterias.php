<?php 
     if (isset($row_datosgrabados['nombreasignaturaestado']) && !empty($row_datosgrabados['nombreasignaturaestado']) ){
             $nombreasignaturaestado = $row_datosgrabados['nombreasignaturaestado'];

             if (isset($row_datosgrabados['idasignaturaestado']) && !empty($row_datosgrabados['idasignaturaestado'])) {
                 $idasignaturaestado = $row_datosgrabados['idasignaturaestado'];
             } else {
                 $idasignaturaestado = "";
             }
             if (isset($row_datosgrabados['iddetalleresultadopruebaestado']) && !empty($row_datosgrabados['iddetalleresultadopruebaestado'])) {
                 $iddetalleresultadopruebaestado = $row_datosgrabados['iddetalleresultadopruebaestado'];
             } else {
                 $iddetalleresultadopruebaestado = "";
             }

             if (isset($row_datosgrabados['notadetalleresultadopruebaestado']) && !empty($row_datosgrabados['notadetalleresultadopruebaestado'])) {
                 $notadetalleresultadopruebaestado = $row_datosgrabados['notadetalleresultadopruebaestado'];
             } else {
                 $notadetalleresultadopruebaestado = "00";
             }

             if (isset($row_datosgrabados['TipoPrueba']) && !empty($row_datosgrabados['TipoPrueba'])) {
                 $TipoPrueba = $row_datosgrabados['TipoPrueba'];
             } else {
                 $TipoPrueba = "";
             }

             if (isset($row_datosgrabados['nivel']) && !empty($row_datosgrabados['nivel'])) {
                 $nivel = $row_datosgrabados['nivel'];
             } else {
                 $nivel = "";
             }

             if (isset($row_datosgrabados['decil']) && !empty($row_datosgrabados['decil'])) {
                 $decil = $row_datosgrabados['decil'];
             } else {
                 $decil = "";
             }

             ?>
             <tr>
             <td colspan="2"><?php echo $nombreasignaturaestado; ?>
                 <input type="hidden" name="asignatura<?php echo $cuentaidioma; ?>"
                        value="<?php echo $idasignaturaestado; ?>">
             </td>
             <td colspan="2">
                 <input type="text" name="puntaje<?php echo $cuentaidioma; ?>" size="3" maxlength="5"
                        value="<?php echo $notadetalleresultadopruebaestado; ?>">
                 <input type="hidden" name="id<?php echo $cuentaidioma; ?>" size="3"
                        value="<?php echo $iddetalleresultadopruebaestado; ?>">
             </td>
             <td colspan="2">
                 <?php
                 if ($idasignaturaestado == "14" || $idasignaturaestado == "21") {
                     ?>
                     <select name="nivel<?php echo $cuentaidioma; ?>" id="nivel<?php echo $cuentaidioma; ?>">
                         <option value="-1">Seleccione:</option>
                         <option value="A-" <?php if ($nivel == 'A-') {
                             echo "selected";
                         } ?>>A-
                         </option>
                         <option value="A1" <?php if ($nivel == 'A1') {
                             echo "selected";
                         } ?>>A1
                         </option>
                         <option value="A2" <?php if ($nivel == 'A2') {
                             echo "selected";
                         } ?>>A2
                         </option>
                         <option value="B1" <?php if ($nivel == 'B1') {
                             echo "selected";
                         } ?>>B1
                         </option>
                         <option value="B+" <?php if ($nivel == 'B+') {
                             echo "selected";
                         } ?>>B+
                         </option>
                     </select>
                     <?php
                 }
                 ?>&nbsp;
             </td>
             <?php
             if ($TipoPrueba == 2 || $TipoPrueba == 3) {
                 ?>
                 <td colspan="2">
                     <input type="text" name="decil<?php echo $cuentaidioma; ?>" size="3" maxlength="5"
                            value="<?php echo $decil; ?>">
                 </td>
                 <?php
             } else {
                 ?>
                 <td colspan="2">&nbsp;</td>
                 <?php
             }
             $cuentaidioma++;
    }//if
?>