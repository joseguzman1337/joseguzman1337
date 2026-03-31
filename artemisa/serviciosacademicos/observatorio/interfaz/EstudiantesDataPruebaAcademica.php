<?php 

session_start();
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
  include("../templates/templateObservatorio.php");

  $db =writeHeader("Prueba Académica",False,'Prueba Académica');


$modalidadacademica = $_REQUEST['codigomodalidadacademica'];
$programa = $_REQUEST['codigocarrera'];

$_SESSION['programa']=$programa;



?> 
<script>
      $(document).ready(function(){
                                            var oTable = $('#customers').dataTable( {
                                                    "sDom": '<"H"Cfrltip>',
                                                    "bJQueryUI": false,
                                                    "bProcessing": true,
                                                    "bScrollCollapse": true,
                                                    "bPaginate": true,
                                                    "sPaginationType": "full_numbers", 
                                                    "oColReorder": {
                                                            "iFixedColumns": 1
                                                    },
                                                    "oColVis": {
                                                            "buttonText": "Ver/Ocultar Columns",
                                                             "aiExclude": [ 0 ]
                                                      }

                                            } );
                                             var oTableTools = new TableTools( oTable, {
                    "buttons": [
                        "copy",
                        "csv",
                        "xls",
                        "pdf",
                        { "type": "print", "buttonText": "Print me!" }
                    ]
                 });
                  $('#demo').before( oTableTools.dom.container );
});
                         
                         
</script>
<form method="POST" action="ExportarPruebaAcademica.php" id="frm1" name="frm1">
  <br>
    <div align="right">
              
      <button type="submit" class="submit" id="pdf" name="pdf">Pdf</button>
      <button type="submit" class="submit" id="excel" name="excel">Excel</button>
    </div>
    <br>
    <br>



  <?php

  if($programa!=""){


            $query_solicitud = "SELECT DISTINCT eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, eg.numerodocumento, est.codigoestudiante, ca.nombrecarrera
              FROM estudiante est, estudiantegeneral eg,carrera ca
              WHERE ca.codigocarrera = '".$programa."'
              and eg.idestudiantegeneral = est.idestudiantegeneral
              and ca.codigocarrera = est.codigocarrera
              and est.codigosituacioncarreraestudiante in (200)
              order by eg.nombresestudiantegeneral";
              //and est.codigosituacioncarreraestudiante not like '1%'
              //and est.codigosituacioncarreraestudiante not like '5%'
          
          $res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());

          $_SESSION['res_solicitud'] = $res_solicitud;

          ?> 
                  <table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px; overflow-x:auto;  " width="100%">
                  <thead style=" background: #eff0f0; text-align: center">
                    <tr>
                      <th>Citar Estudiante</th>
                      <th>Número de identificación</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Semestre</th>
                      <th>Carrera</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php

              while($EstudiantesPruebaAcademica = mysql_fetch_assoc($res_solicitud)){

                $SQL_semestre_Actual = "SELECT MAX(pr.semestreprematricula) AS 'SemestreActual'
                    FROM estudiantegeneral eg
                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                    WHERE eg.numerodocumento = '".$EstudiantesPruebaAcademica['numerodocumento']."'";
                        //and est.codigosituacioncarreraestudiante not like '1%'
                        //and est.codigosituacioncarreraestudiante not like '5%'
                    
                $Sem_Actual = mysql_query($SQL_semestre_Actual, $sala) or die("$query_solicitud".mysql_error());
                $semestre_Actual = mysql_fetch_assoc($Sem_Actual);

                ?>


                    <tr>
                      <td>
                            
                                <span class="formInfo"><a href="javascript:abrir('listar_citaciones.php?nestudiante=<?php echo $EstudiantesPruebaAcademica['numerodocumento']?>&modalidad=<?php echo $_SESSION['codigomodalidadacademica']?>&semestre=<?php echo $semestre_Actual['SemestreActual']?>&carrera=<?php echo $programa?>&habilitar=1')"  id="span"   ><img src="../img/editar.png" width="20px" height="20px"  /></a></span>
                                 <script> 
                                    function abrir(url) { 
                                    open(url,'','top=10,left=10,width=1100,height=700,status=no,directories=no,menubar=no,toolbar=no,location=no,resizable=no,titlebar=no,scrollbars=yes') ; 
                                    } 
                                </script>
                      </td>
                      <td><?php echo $EstudiantesPruebaAcademica['numerodocumento'] ?></td>
                      <td><?php echo $EstudiantesPruebaAcademica['nombresestudiantegeneral'] ?></td>
                      <td><?php echo $EstudiantesPruebaAcademica['apellidosestudiantegeneral'] ?></td>
                      <td><?php echo $semestre_Actual['SemestreActual'] ?></td>
                      <td><?php echo $EstudiantesPruebaAcademica['nombrecarrera'] ?></td>
                    </tr>


                <?php

       

              }

  ?>
                  </tbody>
                </table>

  <?php


  }else{

          ?> 

                  <table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px; overflow-x:auto;  " width="100%">
                  <thead style=" background: #eff0f0; text-align: center">
                    <tr>
                      <th>Acciones</th>
                      <th>Número de identificación</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Semestre</th>
                      <th>Carrera</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php

          $departamento="departamento";

                  $cad= 'SELECT 
                      codigocarrera, 
                      nombrecarrera 
                      from carrera   
                      WHERE codigomodalidadacademica = '.$_SESSION['codigomodalidadacademica'].' 
                      and nombrecarrera NOT LIKE "%'.$departamento.'%"
                      and codigocarrera not in (30, 39, 74, 138) 
                      ORDER BY nombrecarrera';


          $Programa = mysql_query($cad, $sala) or die("$query".mysql_error());
          
          while($ListProgramas = mysql_fetch_assoc($Programa)){

            $query_solicitud = "SELECT DISTINCT eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, eg.numerodocumento, est.codigoestudiante, ca.nombrecarrera
                FROM estudiante est, estudiantegeneral eg,carrera ca
                WHERE ca.codigocarrera = '".$ListProgramas['codigocarrera']."'
                and eg.idestudiantegeneral = est.idestudiantegeneral
                and ca.codigocarrera = est.codigocarrera
                and est.codigosituacioncarreraestudiante in (200)
                order by eg.nombresestudiantegeneral";
                //and est.codigosituacioncarreraestudiante not like '1%'
                //and est.codigosituacioncarreraestudiante not like '5%'
            
            $res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());

            $_SESSION['res_solicitud'] = $res_solicitud;

              while($EstudiantesPruebaAcademica = mysql_fetch_assoc($res_solicitud)){

                $SQL_semestre_Actual = "SELECT MAX(pr.semestreprematricula) AS 'SemestreActual'
                    FROM estudiantegeneral eg
                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                    WHERE eg.numerodocumento = '".$EstudiantesPruebaAcademica['numerodocumento']."'";
                        //and est.codigosituacioncarreraestudiante not like '1%'
                        //and est.codigosituacioncarreraestudiante not like '5%'
                    
                $Sem_Actual = mysql_query($SQL_semestre_Actual, $sala) or die("$query_solicitud".mysql_error());
                $semestre_Actual = mysql_fetch_assoc($Sem_Actual);

                ?>


                    <tr>
                      <td><a href="listar_citaciones.php?nestudiante=<?php echo $EstudiantesPruebaAcademica['numerodocumento']?>&modalidad=<?php echo $_SESSION['codigomodalidadacademica']?>&semestre=<?php echo $semestre_Actual['SemestreActual']?>&carrera=<?php echo $ListProgramas['codigocarrera']?>&habilitar=1" >Citar Estudiante</a>&nbsp;</td>
                      <td><?php echo $EstudiantesPruebaAcademica['numerodocumento'] ?></td>
                      <td><?php echo $EstudiantesPruebaAcademica['nombresestudiantegeneral'] ?></td>
                      <td><?php echo $EstudiantesPruebaAcademica['apellidosestudiantegeneral'] ?></td>
                      <td><?php echo $semestre_Actual['SemestreActual'] ?></td>
                      <td><?php echo $EstudiantesPruebaAcademica['nombrecarrera'] ?></td>
                    </tr>


                <?php

       

              }


          }

  ?>
                  </tbody>
                </table>


  <?php





  }


?>
</form>


