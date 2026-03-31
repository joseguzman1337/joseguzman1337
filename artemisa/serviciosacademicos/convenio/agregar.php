<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if($_REQUEST['iddetalle_convenio']){
    $sql = "select nombremateria,codigogrupo,idsiq_grupoconvenio from siq_grupoconvenio gp inner join materia m on gp.codigomateria = m.codigomateria where idsiq_detalle_convenio = ".$_REQUEST['iddetalle_convenio'].";";
    $rs = $sala->Execute($sql);    
    $reg = $rs->NumRows();
    if ($reg > 0){
        $html = "Grupo:<select name=idsiq_detalle_convenio id=idsiq_detalle_convenio onchange=javscript:update_module_grupo(this);>";
        $html .= "<option>Seleccione..</option>";
        while ($rows = $rs->FetchRow()) {
            $html .= "<option value='".$rows['idsiq_detalle_convenio']."'>$rows[nombremateria] - $rows[codigogrupo]</option>";
        }
        $html .= "</select>";
    }else{
        $html = "No Existe Grupos Asociados - Debe crear un grupo";
    }
    echo $html;
}

if($_REQUEST['idsiq_grupoconvenio']){
    $query = "select distinct eg.idestudiantegeneral,apellidosestudiantegeneral, nombresestudiantegeneral
    from prematricula p 
    inner join detalleprematricula dp on p.idprematricula = dp.idprematricula
    inner join estudiante e on e.codigoestudiante = p.codigoestudiante
    inner join estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral
    where p.codigoperiodo = 20122 and codigoestadoprematricula in (40,41,30,11)
    and codigomateria = 4;";
    $html = "";
    $rs = $sala->Execute($query);    
    $reg = $rs->NumRows();
        while ($rows = $rs->FetchRow()) {
            $html .= "<option value='".$rows['idestudiantegeneral']."'>$rows[apellidosestudiantegeneral] - $rows[nombresestudiantegeneral]</option>";
        }
        echo $html;
}



if($_REQUEST['idconvenio']){    
    $sql = "select nombreprograma,idsiq_detalle_convenio  from siq_detalle_convenio where idsiq_convenio = ".$_REQUEST['idconvenio'].";";
    $rs = $sala->Execute($sql);    
    $reg = $rs->NumRows();
    if ($reg > 0){    
        $html = "Programa:<select name=idsiq_detalle_convenio id=idsiq_detalle_convenio onchange=javscript:update_module_materia(this);>";
        $html .= "<option>Seleccione</option>";
        while ($rows = $rs->FetchRow()) {
            $html .= "<option value='".$rows['idsiq_detalle_convenio']."'>$rows[nombreprograma]</option>";
        }
        $html .= "</select>";
        
    }else{
        $html = "No Existe Detalles asociados al convenio";
    }
    echo $html;
}


if($_REQUEST['nom_usu']){
    $sql = "insert into siqitemsperfiles values (null, '".$_REQUEST['nom_usu']."',null)";
    $query=$sala->query($sql);
    listatabla($sala);
}
if($_REQUEST['ide_usu']){
    $sql = "delete from siqitemsperfiles where idsiqitemsperfiles = ".$_REQUEST['ide_usu']."";
    $query=$sala->query($sql);
    listatabla($sala);
}

function listatabla($sala){
    $sql = "select * from  siqitemsperfiles";
    $query=$sala->query($sql);
    $reg = $query->NumRows();
    echo "<table id='grilla' class='lista'>
              <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre del Perfil</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
    while ($rows = $query->FetchRow()) {
        echo "<tr>
                    <td>$rows[idsiqitemsperfiles]</td>
                    <td>$rows[perfilsiqitemsperfiles]</td>
                    <td><a class='elimina' href='#'><img src='../images/delete.png' onclick='fn_dar_eliminar(this);' /></a></td>
                </tr>";
    }
    echo '</tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidad">'.$reg.'</span> Roles.</td>
                    </tr>
                </tfoot>
            </table>';
}


    function  object_to_array($mixed) {
        if(is_object($mixed)) $mixed = (array) $mixed;
            if(is_array($mixed)) {
            $new = array();
            foreach($mixed as $key => $val) {
                $key = preg_replace("/^\\0(.*)\\0/","",$key);
                $new[$key] = $val;
            }
        }
        else $new = $mixed;
        return $new;
    }


if($_REQUEST['idperfil']){    
    $idperfil = $_REQUEST['idperfil'];
   $sql = "select a.idusuario,trim(usuario) as usuario from usuario a
left join siqitemsusuario c on a.idusuario = c.idusuario and idsiqitemsperfiles = $idperfil
where codigotipousuario not in (600,900,670)
and c.idusuario is null order by 2;
    ";
    $query=$sala->query($sql);    
    while ($rows = $query->FetchRow()) {
        $html .= '<option value="'.$rows['idusuario'].'">'.$rows['usuario'].'</option>';
    }
    echo $html;
}

if($_REQUEST['idperfil2']){
   $idsperfil = $_REQUEST['idperfil2'];
  $sql = "select distinct
idsiqitemsperfiles,a.idusuario,trim(usuario) as usuario from usuario a inner join siqitemsusuario b on a.idusuario = b.idusuario and idsiqitemsperfiles = $idsperfil
order by 2;";
    $query=$sala->query($sql);    
    while ($rows = $query->FetchRow()) {
        $html .= '<option value="'.$rows['idusuario'].'">'.$rows['usuario'].'</option>';
    }
    echo $html;
}

if($_REQUEST['guardar']){
    if(is_array($_REQUEST['idsperfilv_p'])){        
        $idperfildel = $_REQUEST['idsperfildel'];
        $sql = "delete from siqitemsusuario where   idsiqitemsperfiles = $idperfildel ;";
        $query=$sala->query($sql);
        foreach ($_REQUEST['idsperfilv_p'] as $id){
            $sql = "INSERT INTO siqitemsusuario VALUES ( null, $idperfildel, $id);";
            $query=$sala->query($sql);
        }
    }
}

if($_REQUEST['anexoitemid']){
    $anexoitemid = $_REQUEST['anexoitemid'];
    $ids  = $_REQUEST['idsiqitem'];
    $sql = "update siqitemsanexos set codigoestado = 200 where idsiqitemsanexos = $anexoitemid";
    $query=$sala->query($sql);
     $sql = 'select * from siqitemsanexos where idsiqitems =' . $ids . ' and codigoestado = 100';
     $query=$sala->query($sql);
       if($query->_numOfRows>0) {
            $result = $query->GetArray();
       }
       if(is_array($result)){

                 echo "<table width='100%' >";
                echo "<tr>";
                echo "<th>Archivo</th>";
                echo "<th>Nombre del link</th>";
                echo "<th>Fecha de Vigencia</th>";
                echo "<th>Eliminar</th>";
                echo "</tr>";

           foreach($result as $row2){
                echo "<tr>";
                echo "<td>";
                echo "<a href='".$_SESSION['URL_PATH']."archivos/".$row2['urlanexosiqitemsanexos']."' target='_blank'>".$row2['nombreanexosiqitemsanexos']."</a>";
                echo "</td>";
                echo "<td>";
                echo "<input type='text' name='nombreanexosiqitemsanexos[".$row2['idsiqitemsanexos']."]' value='".$row2['nombreanexosiqitemsanexos']."' size='30'/>";
                echo "</td>";
                echo "<td>";
                echo "<input type='text' name='fechacaducidadsiqitemsanexos[".$row2['idsiqitemsanexos']."]' value='".$row2['fechacaducidadsiqitemsanexos']."' size='10'/>";
                echo "<input type='hidden' name='idsiqitemsanexos[".$row2['idsiqitemsanexos']."]' value='".$row2['idsiqitemsanexos']."'/>";
                echo "</td>";
                echo "<td>";
                echo "<a id='' href=# onclick='javascript:deletefile(".$row2['idsiqitemsanexos'].");'><img src='./images/delete.png'> </a>";
                echo "</td>";
                echo "</tr>";
           }
            echo "</table>";
       }
}
?>
