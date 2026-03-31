<?php
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   $ban=0;
   $val=$_REQUEST['id'];
   $sin_ind=$_REQUEST['opt'];
   $codigoperiodo=$_REQUEST['Periodo'];
   $ban=$_REQUEST['status'];
   $idfacultad=$_REQUEST['idfacultad'];
   $n='';
        $query_carrera = "SELECT m.nombremateria, m.nombrecortomateria, m.codigomateria  
				FROM planestudio p
				inner join detalleplanestudio dp on dp.idplanestudio=p.idplanestudio 
				inner join materia m on m.codigomateria=dp.codigomateria 
				where p.codigocarrera='".$val."' GROUP BY m.codigomateria ORDER BY nombremateria";

    //echo $query_carrera;
    $data_in= $db->Execute($query_carrera);
        ?>
        <select id="codigomateria" name="codigomateria" style="width:250px;" >
            <option value="">-Selccione-</option>
            <?php
                foreach($data_in as $dt){
                    $nombre=$dt['nombremateria'];
                    $cnombre=$dt['codigomateria'];
                    $idcarrera=$dt['codigomateria'];
                ?>
                <option value="<?php echo $idcarrera ?>"><?php echo $cnombre.'-'.$nombre ?></option>
                <?php
                }
            ?>
        </select> 
 