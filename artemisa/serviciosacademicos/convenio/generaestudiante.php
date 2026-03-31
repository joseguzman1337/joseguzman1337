<?php

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
require_once '../class/ManagerEntity.php';

$sql = "select distinct dp.idgrupo,e.codigoestudiante,apellidosestudiantegeneral, nombresestudiantegeneral
    from prematricula p 
    inner join detalleprematricula dp on p.idprematricula = dp.idprematricula
    inner join estudiante e on e.codigoestudiante = p.codigoestudiante
    inner join estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral
    left join siq_estudiantegrupo seg on seg.idgrupo = dp.idgrupo and seg.idgrupo and e.codigoestudiante = seg.codigoestudiante
    where p.codigoperiodo = ".$_REQUEST['codigoperiodo']." and codigoestadoprematricula in (10,40,41,30,11)
    and seg.idgrupo is null
    and dp.idgrupo = ".$_REQUEST['id']."
    order by 3;";
//echo $sql;
$rs= $db->Execute($sql);        
while (!$rs->EOF) {
    echo '<option value="'.$rs->fields[1].'">'.$rs->fields[2]."-".$rs->fields[3].'</option>';
    $rs->MoveNext();
}
?>

