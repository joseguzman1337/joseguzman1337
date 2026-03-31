<?php
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
$documento=$_REQUEST['documento'];

$query_persona = "SELECT  concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento,  r.tituloregistrograduadoantiguo, r.numeroactaregistrograduadoantiguo, r.fechagradoregistrograduadoantiguo, r.numerodiplomaregistrograduadoantiguo 
            FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r 
            where eg.numerodocumento = '$documento'
            and e.codigoestudiante=r.codigoestudiante 
            and eg.idestudiantegeneral=e.idestudiantegeneral
            union
            SELECT  concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, t.nombretitulo, r.numeroactaregistrograduado, r.fechagradoregistrograduado, r.numerodiplomaregistrograduado 
            FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t 
            where eg.numerodocumento =  '$documento'
            and eg.idestudiantegeneral=e.idestudiantegeneral
            and e.codigocarrera=c.codigocarrera
            and e.codigoestudiante=r.codigoestudiante
            and c.codigotitulo=t.codigotitulo";
            $persona = $db->Execute($query_persona);
            $totalRows_persona = $persona->RecordCount();
            $row_persona = $persona->FetchRow();
            
            //print_r ($row_persona);
                if ($totalRows_persona >0){ 
                    echo "true";
                }
                else {
                    echo "false";
                }

?>

