<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   
   $val=$_REQUEST['id'];
   $nombre=$_REQUEST['nombre'];
   $apell=$_REQUEST['apellido'];
   $identi=$_REQUEST['identificacion'];
   
   $wv=''; $wn=''; $wa=''; $wi='';
   
   
   
   if(!empty($val)){
       $wv=" and  eg.idestudiantegeneral='".$val."'";
   }
   
   if(!empty($nombre)){
       $wn=" and  eg.nombresestudiantegeneral like '%".$nombre."%'";
   }
   
   if(!empty($apell)){
       $wa=" and  eg.apellidosestudiantegeneral like '%".$apell."%'";
   }
   
   if(!empty($identi)){
       $wi=" and  eg.numerodocumento='".$identi."'";
   }
   
   $query_estudiante = "SELECT idestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, numerodocumento
                    FROM `estudiantegeneral` as eg
                    where 1
                    ".$wv."
                    ".$wn."
                    ".$wa."
                    ".$wi." ";
   //echo $query_estudiante;
   $data_in= $db->Execute($query_estudiante);
   $F_data1 = $data_in->GetArray();
   $val1=$F_data1 [0]['idestudiantegeneral'];
   $F_total1=count($F_data1);
   $F_EsT='';
   
   if ( $F_total1==1){
    $sql_rr="SELECT * FROM obs_estudiante_tutor WHERE codigoestudiante='".$val1."' ";
    $data_r= $db->Execute($sql_rr);
    $F_Es = $data_r->GetArray();
    $F_EsT=count($F_Es);
   }
      if ($F_total1>1){
          
       echo "Hay ".$F_total1." estudiante(s) Encontrado(s), por favor seleccione uno:";
       ?>
       <p>
                   <table border="0" class="CSSTableGenerator">
                          <tbody> 
                              <tr>
                                <td width="487"><label class="titulo_label">
                                  <div align="center"><b>Nombre</b></div>
                                </label></td>
                                <td width="149"><div align="center"><label class="titulo_label"><b>No. Identificaci&oacute;n</b></div></td>
                                <td width="283"><div align="center"><label class="titulo_label"><b>Facultad</b></div></td>
                                <td width="304"><div align="center"><label class="titulo_label"><b>Carrera</b></div></td>
                                <td width="77"><div align="center"><label class="titulo_label"><b>Semestre</b></div></td>
                                <td width="221"><div align="center"></div></td>
                             </tr>
<?php
       foreach($F_data1 as $dt){
            $query_carrera1 = "SELECT  eg.idestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, numerodocumento, nombrefacultad, nombrecarrera, semestre
                    FROM `estudiantegeneral` as eg
                    inner join estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    inner join carrera as c on (e.codigocarrera=c.codigocarrera)
                    inner join facultad as f on (c.codigofacultad=f.codigofacultad)
                    where eg.idestudiantegeneral='".$dt['idestudiantegeneral']."' ";
            $data_in1= $db->Execute($query_carrera1);
            $E_data = $data_in1->GetArray();
           ?>
 
                            <tr>
                                <td width="487"><?php echo $dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral']; ?></td>
                                <td width="149"><?php echo $dt['numerodocumento']; ?></td>
                                <td width="283"><?php echo $E_data[0]['nombrefacultad']; ?></td>
                                <td width="304"><?php echo $E_data[0]['nombrecarrera']; ?></td>
                                <td width="77"><?php echo $E_data[0]['semestre']; ?></td>
                                <td width="221"><button type="button" id="buscar_estu" onclick="buscarestu('<?php echo $dt['idestudiantegeneral'] ?>')">
                                <img src="../img/check.png" height="15" width="15"  /></button> </td>
                               
                            </tr>

            <?php
       }
       ?>
                                    </tbody>
                       </table>                
       <?php
   }else{

   }

   if ($F_total1==1 && $F_EsT==0 ){

   $query_carrera = "SELECT * 
                    FROM `estudiantegeneral` as eg
                    inner join estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    inner join carrera as c on (e.codigocarrera=c.codigocarrera)
                    inner join facultad as f on (c.codigofacultad=f.codigofacultad)
                    where eg.idestudiantegeneral='".$val1."' ";
  // echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
  // $F_data1 = $data_in->GetArray();
  // $F_total1=count($F_data1);

   $i=0;
  
   ?>
   <legend>Datos del Estudiante</legend>
   <?php
	foreach($data_in as $dt){
   ?>
                <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo $codigo=$dt['idestudiantegeneral'] ?>" />
                    <table border="0" width="100%" class="CSSTableGenerator">
                          <tbody>  
                          <?php
			    if ($i==0){
						  ?>
                          
                            <tr>
                                <td width="145"><label class="titulo_label"><b>Nombre:</b></label></td>
                                <td width="494"><?php echo $nombre=$dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral']; ?></td>
                                <td width="179"><label class="titulo_label"><b>N&uacute;mero de Identificaci&oacute;n:</b></td>
                                <td width="668"><?php echo $iden=$dt['numerodocumento']; ?></td>
                               
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Edad:</b></td>
                              <td><?php
                                //fecha actual
                                        $dia=date('j');
                                        $mes=date('n');
                                        $ano=date('Y');
                                        
                                        //fecha de nacimiento
                                        $fec_naci1=explode(' ', $dt['fechanacimientoestudiantegeneral']); 
                                        $fec_naci=explode('-',$fec_naci1[0]);
                                        $dianaz=$fec_naci[2];
                                        $mesnaz=$fec_naci[1];
                                        $anonaz=$fec_naci[0];

                                        //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
                                         if (($mesnaz == $mes) && ($dianaz > $dia)) {
                                        $ano=($ano-1); }

                                        //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
                                        if ($mesnaz > $mes) {
                                        $ano=($ano-1);}

                                        //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
                                        $edad=($ano-$anonaz);
                                        
                                        echo $edad;
                                    ?>
                              </td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>                              
                              
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Celular:</b></td>
                              <td><?php echo $celular=$dt['celularestudiantegeneral']; ?></td>
                              <td><label class="titulo_label"><b>Fijo:</b></td>
                              <td><?php echo $fijo=$dt['telefonoresidenciaestudiantegeneral']; ?></td>
                              
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>E-mail Institucional:</b></td>
                              <td><?php echo $email1=$dt['emailestudiantegeneral']; ?></td>
                              <td><label class="titulo_label"><b>E-mail Personal:</b></td>
                              <td><?php echo $email2=$dt['email2estudiantegeneral']; ?></td>
                              
                            </tr>
                        </tbody>
                       </table>
                
                       		
                            <?PHP  } 
							$i++;
	                 }
					 ?>
				<br><b>DATOS DE LA(S) CARRERA(S)</b><br>
                <p>
                    <table border="0" width="100%" class="CSSTableGenerator">
                     <tbody>  
                     <?php
					 $cat=$i;
					// echo $cat.'-->';
					 $i=0;
		 foreach($data_in as $dt){?>
                            <tr>
                                <td width="5%"><label class="titulo_label"><b>Facultad:</b></label></td>
                                <td width="37%"><?php echo $facultad=$dt['nombrefacultad']; ?></td>
                                <td width="5%"><label class="titulo_label"><b>Carrera:</b></td>
                                <td width="51%"><?php echo $carrera=$dt['nombrecarrera']; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><label class="titulo_label"><b>Semestre:</b></td>
                                <td><?php echo $semestre=$dt['semestre']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                	<?php if ($cat>1) {?>   <hr style="color: #88ab0c"> <?php } ?>
                                </td>
                            </tr>
                          <?php
						 $i++;
						}
						?>
                        </tbody>
                    </table>
   <?php
   }else{
       if ($F_EsT>0){
           echo "<script>alert('Este estudiante ya es estudiante tutor')</script>";
           echo "Este estudiante ya es estudiante tutor...";
       }
        //echo "<script>alert('Este estudiante ya empezo el proceso en el PAE, no se puede registrar...')</script>";
   }
   ?>
                    