<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Seguimiento <br> Estudiante",true,"PAE",1);
   $fun = new Observatorio();
   
   $tipo=$_REQUEST['tipo'];
   
    if (!empty($_REQUEST['id_res'])){
     $entity = new ManagerEntity("registro_riesgo");
    $entity->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $id_doc=$data['usuariocreacion'];
    $id_estu=$data['codigoestudiante'];
    
    $entity1 = new ManagerEntity("usuario");
    $entity1->prefix = "";
    $entity1->sql_where = "idusuario = '".$id_doc."'";
    //$entity1->debug = true;
    $dataD = $entity1->getData();
    $idrol=$dataD[0]['codigorol'];
    
    $entity3 = new ManagerEntity("causas");
    $entity3->sql_where = "codigoestado=100 ";
    $data3 = $entity3->getData();
    $ca=count($data3);
    
    $entity2 = new ManagerEntity("registro_riesgo_causas");
    $entity2->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']." order by idobs_registro_riesgo_causas asc ";
    //$entity2->debug = true;
    $data2 = $entity2->getData();
    $riesgo='';
    foreach($data2 as $dt){
        $riesgo.=$dt['idobs_causas'].',';
    }
    $riesgo = substr($riesgo, 0, -1);
    
    $entity4 = new ManagerEntity("primera_instancia");
    $entity4->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']." ";
   // $entity3->debug = true;
    $data4 = $entity4->getData();
    $data4 =$data4[0];
  }
  

    $entity5 = new ManagerEntity("tutorias");
    $entity5->sql_where = "codigoestudiante = ".$id_estu."";
   // $entity5->debug = true;
    $data5 = $entity5->getData();
    $tTol=count($data5)-1;
   // echo $tTol.'-->'.$data5[$tTol]['n_tutoria'].'-->';
    $tTuro=$data5[$tTol]['n_tutoria']+1;
    

  
  if (!empty($_REQUEST['id'])){
    $entity5 = new ManagerEntity("tutorias");
    $entity5->sql_where = "idobs_tutorias = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity5->debug = true;
    $data5 = $entity5->getData();
    $data5 =$data5[0];
  }
  
  //print_r($_SESSION);
  
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#buttons').akordeon();
        });
        
    
	$(document).ready(function(){
 		$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity").val();
                jQuery("#historial")
                    .html(ajaxLoader)
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:entity, direc:"", tipo:"estu" }, function(response){					
                    if(response) {
                        jQuery("#historial").css('display', '');                        
                    } else {                    
                        jQuery("#historial").css('display', 'none');                    
                    }
                });     
                
        });  
        
       function ver(tabla) {
               var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity").val();
                jQuery("#historial")
                    .html(ajaxLoader)
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:tabla, direc:"" }, function(response){					
                    if(response) {
                        jQuery("#historial").css('display', '');                        
                    } else {                    
                        jQuery("#historial").css('display', 'none');                    
                    }
                });
    }
        
    
    </script>
    <style>
        
.roundedOne {
	width: 28px;
	height: 28px;
	background: #fcfff4;

	background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
	margin: 20px auto;

	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;

	-webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	position: relative;
}

.roundedOne label {
	cursor: pointer;
	position: absolute;
	width: 20px;
	height: 20px;

	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
	left: 4px;
	top: 4px;

	-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
	-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);

	background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
	background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
	background: -o-linear-gradient(top, #222 0%, #45484d 100%);
	background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
	background: linear-gradient(top, #222 0%, #45484d 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
}

.roundedOne label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	filter: alpha(opacity=0);
	opacity: 0;
	content: '';
	position: absolute;
	width: 16px;
	height: 16px;
	background: #00bf00;

	background: -webkit-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: -moz-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: -o-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: -ms-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: linear-gradient(top, #00bf00 0%, #009400 100%);

	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
	top: 2px;
	left: 2px;

	-webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
}

.roundedOne label:hover::after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
	filter: alpha(opacity=30);
	opacity: 0.3;
}

.roundedOne input[type=checkbox]:checked + label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	opacity: 1;
}

input[type=checkbox] {
	visibility: hidden;
}

    </style>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_tutorias" id="idobs_tutorias" value="<?php echo $data5['idobs_tutorias'] ?>">
        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $_REQUEST['id_res'] ?>">
         <input type="hidden" name="entity" id="entity" value="tutorias">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
        <input type="hidden" name="idroltutoria" id="idroltutoria" value="<?php echo $_SESSION['rol'] ?>" />
        
        <div id="container" style="margin-left: 70px;  ">
          <div id="tabs1" style="width:1030px">
                   <?php  $fun->estudiante($db, $id_estu); ?>
         </div>
          <!--<div class="derecha">
                       <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="listar_registro_riesgo.php?tipo=S" class="submit" tabindex="4">Regreso al menú</a>
                    </div><!-- End demo -->
         <h1 class="titulo2" style="width: 1030px"><a href="#" onclick="ver('tutorias')"> Historial Tutorias </a> | <a href="#"  onclick="ver('remision_financiera')"> Historial Financiera </a> | <a href="#" onclick="ver('remision_psicologica')">  Historial Psicologica </a> </h1>
         <div id="historial">
             
         </div>
             
   </div>
  </form>
<?php    writeFooter();
        ?>  

