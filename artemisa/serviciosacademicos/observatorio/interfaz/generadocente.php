<?php
include('../templates/templateObservatorio.php');
  $db=writeHeaderBD();
   $val=$_REQUEST['id'];
   $sin_ind=$_REQUEST['opt'];
   $codigoperiodo=$_REQUEST['Periodo'];
   $codigocarrera=$_REQUEST['carrera'];
   $status=$_REQUEST['status'];
   if (empty($status)){
   $query_carrera = "select g.numerodocumento, nombredocente, apellidodocente, d.iddocente 
                            from facultad as f 
                            INNER JOIN carrera as c on (f.codigofacultad=c.codigofacultad) 
                            INNER JOIN materia as m on (c.codigocarrera=c.codigocarrera) 
                            INNER JOIN grupo as g on (g.codigomateria=m.codigomateria) 
                            INNER JOIN docente as d on (g.numerodocumento=d.numerodocumento) 
                            where c.codigomodalidadacademica='".$val."'
                            and c.codigocarrera='".$codigocarrera."'
                            group by d.numerodocumento 
                            order by nombredocente asc, apellidodocente asc";
   //echo $query_carrera;
    $data_in= $db->Execute($query_carrera);
    
   ?>
<select id="iddocente" name="iddocente" style="width:250px;">
    <option value="">-Selccione-</option>
    <?php
        foreach($data_in as $dt){
            $nombre=$dt['nombredocente'].' '.$dt['apellidodocente'];
            $idcarrera=$dt['iddocente'];
        ?>
        <option value="<?php echo $idcarrera ?>"><?php echo $nombre ?></option>
        <?php
        }
    ?>
</select>              
<?php
   }else{
  $id=$_REQUEST['id']; 
  $identi=$_REQUEST['identificacion'];
  $nombre=$_REQUEST['nombre'];
  $apellido=$_REQUEST['apellido'];
  
  if(!empty($id)){
       $wi=" and  d.iddocente='".$id."'";
   }  
       
  if(!empty($modalidad)){
       $wm=" and  c.codigomodalidadacademica='".$modalidad."'";
   }
   
   if(!empty($codigocarrera)){
       if ($codigocarrera=='undefined'){
           $wcr=""; 
       }else{
        $wcr=" and  c.codigocarrera='".$codigocarrera."'";
       }
   }
   
   if(!empty($nombre)){
       $wn=" and  d.nombredocente like '%".$nombre."%'";
   }
   
   if(!empty($apell)){
       $wa=" and  d.apellidodocente like '%".$apell."%'";
   }
   
   if(!empty($identi)){
       $wi=" and  d.numerodocumento='".$identi."'";
   } 
       
      $query_carrera = "select d.numerodocumento, nombredocente, apellidodocente, d.iddocente,
                                f.nombrefacultad, c.nombrecarrera
                     from docente as d
                     inner join grupo as g on (g.numerodocumento=d.numerodocumento and codigogrupo<>0) 
                     INNER JOIN materia as m on (g.codigomateria=m.codigomateria)
                     INNER JOIN carrera as c on (m.codigocarrera=c.codigocarrera) 
                     INNER JOIN facultad as f  ON (f.codigofacultad=c.codigofacultad)
                     where d.codigoestado=100 and d.numerodocumento<>''
                        ".$wi."
                        ".$wn."
                        ".$wa."
                        ".$wi." 
                        ".$wcr." 
                        ".$wm."    
                     group by d.numerodocumento";
   //echo $query_carrera;
    $data_in= $db->Execute($query_carrera);
    $F_data1 = $data_in->GetArray();
    $F_total1=count($F_data1);
    if ($F_total1>0 and empty($id)){
       echo "Hay ".$F_total1." (s) Encontrado(s), por favor seleccione uno:";
       ?>
       <p>
                   <table border="0" class="CSSTableGenerator">
                          <tbody> 
                              <tr>
                                <td width="487"><label class="titulo_label"><div align="center"><b>Nombre</b></div></label></td>
                                <td width="149"><div align="center"><label class="titulo_label"><b>No. Identificaci&oacute;n</b></div></td>
                                <td width="283"><div align="center"><label class="titulo_label"><b>Facultad</b></div></td>
                                <td width="304"><div align="center"><label class="titulo_label"><b>Carrera</b></div></td>
                                <td width="221"><div align="center"></div></td>
                             </tr>
            <?php foreach($F_data1 as $dt){ ?>
                            <tr>
                                <td width="487"><?php echo $dt['nombredocente'].' '.$dt['apellidodocente']; ?></td>
                                <td width="149"><?php echo $dt['numerodocumento']; ?></td>
                                <td width="283"><?php echo $dt['nombrefacultad']; ?></td>
                                <td width="304"><?php echo $dt['nombrecarrera']; ?></td>
                                <td width="221"><button type="button" id="buscar_estu" onclick="buscardoc('<?php echo $dt['iddocente'] ?>')">
                                <img src="../img/check.png" height="15" width="15"  /></button> </td>
                               
                            </tr>

       <?php } ?>
                       </tbody>
                       </table>                
       <?php
   }

   if ($F_total1==1 and !empty($id)){ 
      $dt=$F_data1[0];
       ?>
   <legend>Datos del Docente</legend>
                <input type="hidden" name="iddocente" id="iddocente" value="<?php echo $codigo=$dt['iddocente'] ?>" />
                    <table border="0" width="100%" class="CSSTableGenerator">
                          <tbody>                       
                            <tr>
                                <td><label class="titulo_label"><b>Nombre:</b></label></td>
                                <td><?php echo $nombre=$dt['nombredocente'].' '.$dt['apellidodocente']; ?></td>
                                <td><label class="titulo_label"><b>N&uacute;mero de Identificaci&oacute;n:</b></td>
                                <td><?php echo $iden=$dt['numerodocumento']; ?></td>
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Facultad:</b></td>
                              <td><?php echo $celular=$dt['nombrefacultad']; ?></td>
                              <td><label class="titulo_label"><b>Carrera:</b></td>
                              <td><?php echo $fijo=$dt['nombrecarrera']; ?></td>
                              
                            </tr>
                        </tbody>
                       </table>

   <?php
   }
 }
?>