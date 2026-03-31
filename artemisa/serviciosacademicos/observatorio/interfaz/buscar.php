<?php
include('../templates/templateObservatorio.php');
//include_once ('funciones_datos.php');
 //  $db=writeHeaderBD();
   $db=writeHeader('Observatorio',true,'');
    include("funciones.php");
 $fun = new Observatorio();
 $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Variables de Riesgo'); 

   ?>
<script>
     $(document).ready( function () {
				var oTable = $('#customers').dataTable( {
                                        "sDom": '<"H"Cfrltip>',
                                        "bJQueryUI": false,
                                        "bProcessing": true,
					"bScrollCollapse": true,
                                        "bPaginate": true,
                                        "sPaginationType": "full_numbers",
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
<?php
$entity=$_REQUEST['entity'];

if ($entity=='grupos'){
    $idcarr=$_REQUEST['Carrera_1'];
    $idmod=$_REQUEST['codigomodalidadacademica'];
    $doc=$_REQUEST['docente'];

    $carr='';
    foreach ($idcarr as $valor) {
        $carr.="'".$valor."',";
    }
    $carr = substr($carr, 0, -1);
    
    $mod='';
    foreach ($idmod as $valor) {
        $mod.="'".$valor."',";
    }
    $mod = substr($mod, 0, -1);
    
    
    if (!empty($carr)){ $wc=' and c.codigocarrera in ('.$carr.')'; }
    if (!empty($mod)){ $wm=' and c.codigomodalidadacademica in ('.$mod.')';  }
    if (!empty($_REQUEST['docente'])){ $wd=' and d.numerodocumento='.$_REQUEST['docente'].''; }
    if (!empty($_REQUEST['documento'])){ $we=' and es.numerodocumento='.$_REQUEST['documento'].''; }
    if (!empty($_REQUEST['codigoperiodo'])){ $wp=' and g.codigoperiodo='.$_REQUEST['codigoperiodo'].''; }
   // echo $idcai.'<br>';
    $sql="SELECT g.idobs_grupos, nombregrupos, descripciongrupos, nombrecarrera, 
            CONCAT(d.nombredocente,' ', d.apellidodocente) as docente
            FROM obs_grupos as g 
            LEFT JOIN modalidadacademica as m on (m.codigomodalidadacademica=g.codigomodalidadacademica) 
            LEFT JOIN carrera as c on (c.codigocarrera=g.codigocarrera)            
            LEFT JOIN docente as d on (d.iddocente=g.iddocente) 
                         where g.codigoestado=100 ".$wc." ".$wm." ".$wd." ".$we." ".$wp." ";
          //  echo $sql;
}
if ($entity=='causas'){
    $idcau=$_REQUEST['idobs_tipocausas'];
    
    $idcai='';
    foreach ($idcau as $valor) {
        $idcai.="'".$valor."',";
    }
    $idcai = substr($idcai, 0, -1);
    if (!empty($idcai)){
        $wh=' and e.idobs_tipocausas in ('.$idcai.')';
    }
   // echo $idcai.'<br>';
    $sql="SELECT idobs_causas, nombrecausas, nombretipocausas
        FROM obs_causas as e 
        INNER JOIN obs_tipocausas as t on (e.idobs_tipocausas=t.idobs_tipocausas and t.codigoestado=100) 
        WHERE e.codigoestado=100 ".$wh." order by idobs_causas ";
   // echo $sql;
}

   $data_in= $db->Execute($sql);
   $F_data2 = $data_in->GetArray();
   $F_data1 = $data_in->FetchObject($toupper=false);
?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <?php
          $i=0;
          foreach($F_data1 as $ind=>$val){
              $nom=str_replace("nombre","",$ind);
              if ($i==0) $nom='Acciones';
           ?>
           <td><?php echo $nom ?></td>
        <?php 
          $i++;
          } ?>
    </thead>
    <tbody>
    <?php
        foreach($data_in as $dt){ 
            $i=0;
            ?> <tr> <?php
            foreach($F_data1 as $ind=>$val){
            ?>  
             <td>
            <?php if ($i==0){ ?>
                      
                  <?php if ($roles['editar']==1){?>        <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_<?php echo $entity ?>.php?id=row_<?php echo $dt['idobs_'.$entity.''] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /><?php } ?></button>
                  <?php if ($roles['eliminar']==1){?>        <button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('<?php echo $entity ?>','<?php echo $dt['idobs_'.$entity.''] ?>','listar_<?php echo $entity ?>.php')"><img src="../img/eliminar.png" width="20px" height="20px"  /><?php } ?></button>
                     
             <?php }else{
                 echo $dt[$ind];
             }  ?>
             </td>
              <?php
            $i++;
            }
            ?> </tr> <?php
        }
    ?>
    </tbody>
</table>
</div>