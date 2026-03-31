<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include("../templates/templateObservatorio.php");
include("funciones2.php");
$db =writeHeader("Seguimiento <br> Docente",true,"PAE",1);
$fun = new Observatorio();
$documento =$_REQUEST['doc'];
$tipo=$_REQUEST['tipo'];
$periodo =$_REQUEST['periodo'];
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
 .load('generahistorial.php', {codigoestudiante: estudiante, entity:entity, direc:"" }, function(response){					
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
h1 {
  font-size:1em; 
  display: inline;
  font-weight:normal;
}
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

  <div id="container" style="margin-left: 160px;">
    <label style="color:#2448a5; font-size:13px">Si desea citar al estudiante, haga clic en "Citar Estudiante" y esta información se guardará en Citación PAE, Citaciones pendientes.</label>
    <br />
    <br />
    <div id="tabs">

     <table  bgcolor="#ea8511" >
      <tr>
        <td style="font-size:12px ; color:#FFF ; padding-top:6px ; padding-left:28px " >      Datos del                  </td>
      </tr>
      <tr>
        <td style="font-size:12px ; color:#FFF  ;padding-bottom:6px ; padding-left:28px ;padding-top:0" width="180px" >      Remitido            </td>
      </tr>
    </table>
<!--                <ul>
                <li style="width: 165px"><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />Remitente</span></a></li>
                <li style="width: 165px"><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos<br />del Remitido</span></a></li>
                <li style="width: 165px"><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Causas de<br />Ingreso al PAE</span></a></li>
                <li style="width: 164px"><div class="stepNumber">4</div><a href="#tabs-4"><span class="stepDesc">Registro<br />Primera Instancia </span></a></li>
                <li style="width: 164px"><div class="stepNumber">5</div><a href="#tabs-6"><span class="stepDesc">Remisi&oacute;n</span></a></li>
              </ul>-->
                <!--<div id="tabs-1">
                 <?php 
                       //$fun->docente($db, $id_doc,$idrol); 
                  ?>
                </div>-->
                <div id="tabs-2">
                  <?php  $fun->estudiante($db, $id_estu, $periodo); ?>
                </div>
           <!-- <div id="tabs-3">
                    <?php 
                     //  $fun->registro_riesgo($db, $_REQUEST['id_res']); 
                       
                    ?>
             </div>
               <div id="tabs-4">
                      <?php
                       //  $fun->primera_ins($db, $data4['idobs_primera_instancia'] ,$riesgo);
                      ?>
           </div>
            <div id="tabs-6">
                   <?php
                         //$fun->remision($db,$id_estu,$_REQUEST['id_res'],'V');
                      ?>
                    </div>-->
                  </div>
          <!--<div class="derecha">
                       <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="listar_registro_riesgo.php?tipo=S" class="submit" tabindex="4">Regreso al menú</a>
                      </div><!-- End demo -->
      <!--   <h1 class="titulo2" style="width: 1030px"><a href="#" onclick="ver('tutorias')"> Historial Tutorias </a> | <a href="#"  onclick="ver('remision_financiera')"> Historial Financiera </a> | <a href="#" onclick="ver('remision_psicologica')">  Historial Psicologica </a> </h1>
      <div id="historial">-->
        <?php

		//echo $documento;

        require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
        mysql_select_db($database_sala, $sala);
    /////////////////////////////   buscar ficha psicopedagogica ////////////////////
        $query_estudiantes = "SELECT count(FichaPsicopedagogicaId) as ficha FROM FichaPsicopedagogica where EstudianteGeneralId in 
        (SELECT  idestudiantegeneral FROM salaoees.estudiantegeneral  where numerodocumento  = '$documento') ;";
        $res = $db->Execute($query_estudiantes);
        if (!$res) echo "ERROR 1 : " . mysql_error();

        foreach($res as $solicitud){
         $ficha= $solicitud['ficha'];
				 //echo $ficha;
       }
        /////////////////////////////   buscar apoyo //////////////////////////////
       $query_codigoestudiantes = " SELECT codigoestudiante, eg.idestudiantegeneral, 
       CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre
       FROM  estudiante e 
       INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
       where numerodocumento = '$documento' order by codigoestudiante desc;";
       $res2 = $db->Execute($query_codigoestudiantes);
       if (!$res2) echo "ERROR 1 : " . mysql_error();

       foreach($res2 as $solicitud2){
              //  echo $res2['codigoestudiante'];
       $codigoest= $solicitud2['codigoestudiante'];
		   $idestudiante =$solicitud2['idestudiantegeneral'];
       }
          
       /*echo $codigoest;
       echo "<br>";
		echo $idestudiante;*/
        //////////////////////////////////////////////////////////////////////////

       $query_apoyoestudiante = "SELECT MAX(idTipoApoyo),idobs_estudiante_tutor,codigoestudiante, idTipoApoyo, nombre ,fechacreacion
FROM obs_estudiante_tutor, OEESParametro
where obs_estudiante_tutor.idTipoApoyo = OEESParametro.OEESParametroid
and codigoestudiante =   '$codigoest'
GROUP BY idTipoApoyo ";
       $res3 = $db->Execute($query_apoyoestudiante);
       if (!$res3) echo "ERROR 1 : " . mysql_error();

       foreach($res3 as $solicitud3){
              //  echo $res2['codigoestudiante'];
         $tipoApoyo= $solicitud3['idTipoApoyo'];
         /*echo $tipoApoyo;
         echo "<br>";*/
       }
       
 /////////////////////////////   buscar otroapoyo ////////////////////

$otrap2=0;
foreach($res2 as $solicitud3){
   $codigoest= $solicitud3['codigoestudiante'];
   
           $query_otroapoyo = "SELECT count(id_ApoyoAcademico) as otroapoyo
 FROM ApoyosAcademicosEstudiante where codigoestudiante = '$codigoest' ;";
        $res4 = $db->Execute($query_otroapoyo);
        if (!$res4) echo "ERROR 1 : " . mysql_error();
        foreach($res4 as $solicitud4){
         $otrap= $solicitud4['otroapoyo'];
         if ($otrap != 0 || $otrap != '0' ){
        $otrap2 =$otrap;
        $codigoest2 =$codigoest;
        // echo " respuesta apoyo ".$otrap2 =$otrap;
       }
       }
}

       if ( $ficha != 0 || $ficha != '0' || $otrap2 != 0 || $otrap2 != '0'  ||(isset($tipoApoyo)  && $tipoApoyo !=null && $tipoApoyo !="")) {
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*        $query_idestudiante = "SELECT idestudiantegeneral FROM salaoees.estudiantegeneral  where numerodocumento  = '$documento'";
        $res2 = $db->Execute($query_idestudiante);
        if (!$res2) echo "ERROR 1 : " . mysql_error();

        foreach($res2 as $solicitud2){
         $idestudianteg= $solicitud2['idestudiantegeneral'];
         //echo $ficha;
       }*/
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


       ?>

       
       <script type="text/javascript">
//////////////////////////////////////// Popup window code  //////////////////////////////////////
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=300,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>
<table>
  <tr>
    <td><h4>Historial de Apoyos</h4></td>
    <td>
      <div class="container1">

        <a href="#" data-toggle="tooltip" title="A continuacion usted encontrara los diferentes tipos de apoyos que el estudiante ha recibido para el periodo consultado. Si no aparece ningun tipo de apoyo significa que el estudiante no lo ha recibido."><img src="../img/icono-informacion.png" width="20px" height="20px" /></a>
      </div>
    </td>
  </tr>
  <script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
  </script>
</table>
<!--//////////////////////////////////////////////  fin popup - inicio fichapsicopedagogica///////////////////////////////////////////////-->
<?php if ( $ficha != 0 || $ficha != '0'){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir('../InformeIntervencionPsicopedagogica/Consulta_html.php?actionID=ConsultaIndividualLider&nd=<?php echo $idestudiante ?>')"  >Psicopedagogía </a>  |  </h1>      
     <?php  }?>
<!--    //////////////////////////////////////////////        inicio     posibles apoyos        //////////////////////////////////////////////            -->
   <?php    foreach($res3 as $solicitud3){
              //  echo $res2['codigoestudiante'];
         $tipoApoyo= $solicitud3['idTipoApoyo'];
        // echo $tipoApoyo;
        ?>
<?php if ( $tipoApoyo === '26' || $tipoApoyo === 26 ){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir2('Datos.php?id=<?php echo $idestudiante ?>&periodo=<?php echo $periodo ?>&apoyo=26')"   >Tutorías PAE </a>  |  </h1>
<?php }?>
<?php if ( $tipoApoyo === '27' || $tipoApoyo === 27 ){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir('Datos.php?id=<?php echo $idestudiante ?>&periodo=<?php echo $periodo ?>&apoyo=27')" > Tutorías Pares </a>  |  </h1>
<?php }?>
<?php if ( $tipoApoyo === '28' || $tipoApoyo === 28 ){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir('Datos.php?id=<?php echo $idestudiante ?>&periodo=<?php echo $periodo ?>&apoyo=28')"  >Psicología </a>  |  </h1>
<?php }?>



<?php if ( $tipoApoyo === '29' || $tipoApoyo === 29 ){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir('Datos.php?id=<?php echo $idestudiante ?>&periodo=<?php echo $periodo ?>&apoyo=29')"  >Tutorías LPL </a>  |  </h1>
<?php }?>
<?php if ( $tipoApoyo === '30' || $tipoApoyo === 30 ){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir('Datos.php?id=<?php echo $idestudiante ?>&periodo=<?php echo $periodo ?>&apoyo=30')"   >Apoyo financiero </a>  |  </h1>
<?php }}?>
<!-- ///////////////////////////////////////////   fin apoyo////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////   otro apoyo////////////////////////////////////////////////////////////// -->
<?php if ( $otrap2 != 0 || $otrap2 != '0'){?>
<h1 class="titulo2" style="width: 1030px"><a href="javascript:abrir('datosApoyosAcademicos.php?cod=<?php echo $codigoest2 ?>')"  >Otros </a>  |  </h1>
<?php }?>







<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div id="historial">

 <script> 
 function abrir(url) { 
  open(url,'','top=100,left=100,width=900,height=700,status=no,directories=no,menubar=no,toolbar=no,location=no,resizable=si,titlebar=no,scrollbar=no,top=50px, margin:100px') ; 
} 
 function abrir2(url) { 
  open(url,'','top=50,left=100,width=900,height=805,status=no,directories=no,menubar=no,toolbar=no,location=no,resizable=no,titlebar=no,scrollbar=no') ; 
} 
</script>
<?php
				} //if 
				////////////////////////////////////////////////////////////////
				?>
     </div>

   </div>
 </form>
<!--       <div id="tabs-2"> </div>-->
                <?php  
//                $fun->bus_apoyoAcademimco($db,20151,148781); 
//                //echo $id_estu.'-->>';
                ?>
          
            
 
 <?php    writeFooter();
 ?>  
     <script>
/*        function irFuncion2($idobs_estudiante_tutor,$idApoyo){

          var idobs_estudiante_tutor = 81;
          var idApoyo = 26; 

        
        $.ajax({
            url: "MostrarInfApoyo.php", //pagina de destino
            type: "POST", //metodo de envio
            data: {idobs_estudiante_tutor:idobs_estudiante_tutor,idApoyo:idApoyo}, //donde estan los datos
            beforeSend: function() {

                $("#divres").html("");

                
            },
            success: function(res) {
                 //mensaje desde ingresar.php
                 $("#divres").html(res);

            }
        });



        }*/
</script>

