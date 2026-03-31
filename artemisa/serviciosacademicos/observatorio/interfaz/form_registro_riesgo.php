<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones2.php");
   require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
  mysql_select_db($database_sala, $sala);

  $titleHeader = $_REQUEST['title'];

  if (is_null($titleHeader) || empty($titleHeader))
    $titleHeader = "Registro <br> Riesgo";

   $db =writeHeader($titleHeader,true,"PAE",1,'Registro de riesgo');
   
   $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Registro de riesgo');
   
   
   if(empty($roles)){
   	$roles=$fun->roles($db, $_SESSION['MM_Username'], '../interfaz/solicitar_pr.php');
   }
   
   $id_user=$_SESSION['MM_Username'];
   $idR=str_replace('row_','',$_REQUEST['id']);
   $id_doc=''; $id_estu='';
   
   $tipo=$_REQUEST['tipo'];
    if ($tipo=='Notas'){
        $miarray = $_REQUEST['datos'];
        $array_para_recibir_via_url = stripslashes($miarray);
        $array_para_recibir_via_url = urldecode($array_para_recibir_via_url );
        $matriz_completa = unserialize($array_para_recibir_via_url);
        
        $entity1 = new ManagerEntity("estudiantegeneral");
        $entity1->prefix = "";
        $entity1->sql_where = "numerodocumento = '".$matriz_completa['numerodocumento']."'";
        //$entity1->debug = true;
        $dataD = $entity1->getData();
        $id_estu= $dataD[0]['idestudiantegeneral'];
        $Th=4;
       //print_r($matriz_completa);
    } if ($tipo=='Prueba'){
     $entity1 = new ManagerEntity("estudiante");
        $entity1->prefix = "";
        $entity1->sql_where = "codigoestudiante = '".$_REQUEST['codigoestudiante']."'";
       // $entity1->debug = true;
        $dataD = $entity1->getData();
        $id_estu= $dataD[0]['idestudiantegeneral'];   
         $Th=3;
   }if (empty($tipo)){
       $Th=2;
   }
   
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("registro_riesgo");
    $entity->sql_where = "idobs_registro_riesgo = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $id_doc1=$data['usuariocreacion'];
    $id_estu=$data['codigoestudiante'];
    $Th=2;
    
     $entity1 = new ManagerEntity("usuario");
     $entity1->prefix = "";
     $entity1->sql_where = "idusuario = '".$id_doc1."'";
     //$entity1->debug = true;
     $dataD = $entity1->getData();
     $id_doc=$dataD[0]['idusuario'];
     $idrol=$dataD[0]['codigorol'];
      
    $entity3 = new ManagerEntity("causas");
    $entity3->sql_where = "codigoestado=100 ";
    $data3 = $entity3->getData();
    $ca=count($data3);
    
    $entity2 = new ManagerEntity("registro_riesgo_causas");
    $entity2->sql_where = "idobs_registro_riesgo = ".str_replace('row_','',$_REQUEST['id'])." order by idobs_registro_riesgo_causas asc ";
    //$entity2->debug = true;
    $data2 = $entity2->getData();
    $riesgo=''; $j=0;
    for ($i=0; $i<$ca; $i++){
        if($i==$data2[$j]['idobs_causas']){
            $riesgo[]=$data2[$j]['idobs_causas'];
            $j++;
        }else{
           $riesgo[]=0; 
        }
    }
     //print_r($riesgo);
  }else{
      $idrol=$_SESSION['rol'];
      $entity1 = new ManagerEntity("usuario");
      $entity1->prefix = "";
      $entity1->sql_where = "usuario = '".$_SESSION['MM_Username']."'";
      //$entity1->debug = true;
      $dataD = $entity1->getData();
      $id_doc=$dataD[0]['idusuario'];
  }

$periodo = $_REQUEST['periodo'];


$usuario = $_SESSION['MM_Username'];

            $query_UsuarioLog = "SELECT u.idusuario, u.usuario, u.nombres, u.apellidos, ut.CodigoTipoUsuario, ur.idrol, r.nombrerol, rp.usuarioConPermiso, 

              c.codigocarrera,
              c.codigofacultad, 
              c.nombrecarrera, 
              c.codigomodalidadacademica,
              ru.obs_rol,
              uf.emailusuariofacultad
               FROM 
              usuario u 
              INNER JOIN UsuarioTipo ut on ut.UsuarioId = u.idusuario
              INNER JOIN usuariorol ur on ut.UsuarioTipoId = ur.idusuariotipo
              INNER JOIN rol r on ur.idrol = r.idrol
              INNER JOIN obs_usuariosRolPermiso rp on u.idusuario = rp.usuarioConPermiso
              INNER JOIN obs_rolusuarios ru on rp.idobs_rol = ru.idobs_rolusuario
              inner JOIN usuariofacultad uf on u.usuario = uf.usuario and uf.codigoestado = 100
              INNER JOIN carrera c on uf.codigofacultad = c.codigocarrera 
              WHERE u.usuario like '".$usuario."'
              ORDER BY c.nombrecarrera";
            //and est.codigosituacioncarreraestudiante not like '1%'
            //and est.codigosituacioncarreraestudiante not like '5%'
            //AND est.codigocarrera = '$codigocarrera'
            //echo "$query_solicitud<br>";
            $UsuLog = mysql_query($query_UsuarioLog, $sala) or die(mysql_error());


            $DatUsuarioLog = mysql_fetch_assoc($UsuLog);


            $query_Facultad ="SELECT nombrefacultad

                              FROM facultad
                              WHERE codigofacultad = ".$DatUsuarioLog['codigofacultad']."";

            $Facultad = mysql_query($query_Facultad, $sala) or die(mysql_error());


            $DatFac = mysql_fetch_assoc($Facultad);
            

               $query_DatEstudiante = "SELECT * 
                    FROM `estudiantegeneral` as eg
                    inner join estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    inner join carrera as c on (e.codigocarrera=c.codigocarrera)
                    inner join facultad as f on (c.codigofacultad=f.codigofacultad)
                    where e.codigoestudiante='".$id_estu."' "; 

                    // where eg.idestudiantegeneral='".$id_estu."' "
            $DatosEstudiante = mysql_query($query_DatEstudiante, $sala) or die(mysql_error());


            $DatEstudiante = mysql_fetch_assoc($DatosEstudiante);

            
  


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
   
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" href="css/boostrap/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/boostrap/bootstrap.min.js"></script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src=”https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js”></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    
</head>
<body>


    <script type="text/javascript">
  
      $(document).ready(function(){

        $("#guardar").on('click', function(){
          $("#tipoEnvio").val("");
          enviarForm();
        });

        $("#eliminar").on('click', function(){
          $("#tipoEnvio").val("delete");
          enviarForm();
        });

        $("#actualizar").on('click', function () {
          $("#tipoEnvio").val("update");
          enviarForm();
        });

        function enviarForm() {

    	    $("#FormModal").submit(function(event) {
            event.preventDefault();
            $.ajax({
              url: "GuardarRemision.php", //pagina de destino
              type: "POST", //metodo de envio
              data: $("#FormModal").serialize(), //donde estan los datos
              beforeSend: function() {                
              },
              success: function(res) {
                 //mensaje desde ingresar.php
                location.reload();
              }
            });
          });
        }


      jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});
      
  	 $('#tabs').smartTab({
        selected: 0,
        autoHeight:true,
        autoProgress: false,
        stopOnFocus:true,
        transitionEffect:'vSlide'})
	   });



    
    </script>

  <!--<h2>Modal Example</h2>

  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>


  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
-->



    <div style=" width:1000px; display:none; z-index:9999; padding:20px;" id="modal">
        

        <form action="GuardarRemision.php" method="POST" id="FormModal" name="FormModal">
          <input type="hidden" name="idActualizar" id="idActualizar" value="">
          <input type="hidden" name="tipoEnvio" id="tipoEnvio" value="">
        	<input type="hidden" name="idR" id="idR" value="<?php echo $idR?>">
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $periodo ?>">
            <input type="hidden" name="idRemision" id="idRemision">
            <input type="hidden" name="idestudiantegeneral" id="idestudiantegeneral">
            <input type="hidden" name="numerodocumento" id="numerodocumento">
            <input type="hidden" name="idusuario" id="idusuario">
            <input type="hidden" name="NombreRemision" id="NombreRemision">
            
            <h1 id="Pares" style="display: none">TUTORÍA DE PARES</h1>
            <h1 id="Psico" style="display: none">SERVICIO DE PSICOLOGÍA</h1>
            <h1 id="Psicope" style="display: none">SERVICIO DE PSICOPEDAGOGÍA</h1>
            <h1 id="Lpl" style="display: none">TUTORÍA LPL</h1>
            <h1 id="Fin" style="display: none">APOYO FINANCIERO</h1>
            <p id="FechaRegistro" style="display: none"></p>



                  <table>
                  <tr>
                  <td width="255"><b>Datos Remitente</b></td>
                  </tr>
                  </table>

                <table  border="0" class="CSSTableGenerator" width="100%">
                    <tbody>
                        <tr>
                            <td>Nombre de quien remite:</td>
                            <td><input type="text" name="NomRem" id="NomRem"  size="30" readonly="readonly"></td>
                            <td>Facultad:</td>
                            <td><input type="text" name="FacRem" id="FacRem" readonly="readonly"></td>
                        </tr>
                        <tr>
                            <td>Celular:</td>
                            <td><input type="text" name="CelRem" id="CelRem"></td>
                            <td>Fijo:</td>
                            <td><input type="text" name="FijoRem" id="FijoRem"></td>
                        </tr>
                        <tr>
                            <td>E-mail Institucional:</td>
                            <td><input type="text" name="EmailRem" id="EmailRem"></td>
 
                    	</tr>

                    </tbody>

                </table>

                <div id="DescripcionRem" name="DescripcionRem">
	                  <table>
	                  <tr>
	                  <td width="255"><b>Motivo Remision</b></td>
	                  </tr>
	                  </table>

	                <table  border="0" class="CSSTableGenerator">
	                    <tbody>
	                        <tr>
	                        	<td>Descripción:</td>
	                        	<td><TEXTAREA rows="3" cols="60" name="DescripcionRemision" id="DescripcionRemision" required></TEXTAREA></td>
	                        </tr>
	                    </tbody>

	                </table>
                </div>

                <div id="ComObser" name="ComObser" style="display: none">
	                  <table>
	                  <tr>
	                  <td width="255"><b>Comportamientos observados y reporte del estudiante</b></td>
	                  </tr>
	                  </table>

	                <table  border="0" class="CSSTableGenerator">
	                    <tbody>
	                        <tr>
	                        	<td>Descripción:</td>
	                        	<td><TEXTAREA rows="3" cols="60" name="DescripcionCompObs" id="DescripcionCompObs"></TEXTAREA></td>
	                        </tr>
	                    </tbody>

	                </table>


                </div>

                <div id="primariaPae" name="primariaPae" style="display: none">
                	<table>
	                  <tr>
	                  <td width="255"><b>Intervención primaria PAE</b></td>
	                  </tr>
	                  </table>

	                <table  border="0" class="CSSTableGenerator">
	                    <tbody>
	                        <tr>
	                        	<td>Descripción:</td>
	                        	<td><TEXTAREA rows="3" cols="60" name="DescripcionIntervenPae" id="DescripcionIntervenPae"></TEXTAREA></td>
	                        </tr>
	                    </tbody>

	                </table>

	            </div>

	            <div id="SolAc" name="SolAc" style="display: none">
                	<table>
	                  <tr>
	                  <td width="255"><b>Solicitud Económica del estudiante</b></td>
	                  </tr>
	                  </table>

	                <table  border="0" class="CSSTableGenerator">
	                    <tbody>
	                        <tr>
	                        	<td>Descripción:</td>
	                        	<td><TEXTAREA rows="3" cols="60" name="DescripcionSolAcademica" id="DescripcionSolAcademica"></TEXTAREA></td>
	                        </tr>
	                    </tbody>

	                </table>

	            </div>
	            <br>
            <button class="submit" type="submit" tabindex="3" style="display: none;" id="guardar" name="guardar">Guardar</button>
            <button class="submit" type="submit" tabindex="3" style="display: none" id="actualizar" name="actualizar">Actualizar</button>
            <button class="submit" type="submit" tabindex="3" style="display: none" id="eliminar" name="eliminar">Eliminar</button>
            
        </form>
    </div>

    <div id="divres" name="divres"></div>

    <script>
    	function irFuncion2($RemisionEsudianteId,$TipoRemisionId,$idestudiantegeneral,$periodo){

    	var RemisionEsudianteId = $RemisionEsudianteId;
    	var TipoRemisionId = TipoRemisionId;
    	var idestudiantegeneral = $idestudiantegeneral;
    	var periodo = $periodo; 

    	
        $.ajax({
            url: "MostrarInfRemision.php", //pagina de destino
            type: "POST", //metodo de envio
            data: {RemisionEsudianteId:RemisionEsudianteId, TipoRemisionId:TipoRemisionId, idestudiantegeneral:idestudiantegeneral, periodo:periodo}, //donde estan los datos
            beforeSend: function() {

            	$("#divres").html("");
                
            },
            success: function(res) {
                 //mensaje desde ingresar.php
              $("#divres").html(res);

              $('#actualizar').slideDown(); 
              $('#eliminar').slideDown();

            }
        });



    	}


        function irFuncion($idRemision,$Nombre){



          /*u.usuario, u.nombres, u.apellidos, ut.CodigoTipoUsuario, ur.idrol, r.nombrerol, rp.usuarioConPermiso, 

              c.codigocarrera, 
              c.nombrecarrera, 
              c.codigomodalidadacademica,
              ru.obs_rol*/



            jQuery("#NomRem").removeAttr("disabled").focus().val("");
            jQuery("#FacRem").removeAttr("disabled").focus().val("");
            jQuery("#CelRem").removeAttr("disabled").focus().val("");
            jQuery("#FijoRem").removeAttr("disabled").focus().val("");
            jQuery("#EmailRem").removeAttr("disabled").focus().val("");
            jQuery("#DescripcionRemision").removeAttr("disabled").focus().val("");
            jQuery("#DescripcionCompObs").removeAttr("disabled").focus().val("");
            jQuery("#DescripcionIntervenPae").removeAttr("disabled").focus().val("");
            jQuery("#DescripcionSolAcademica").removeAttr("disabled").focus().val("");
            jQuery("#NomRem").removeAttr("disabled").focus().val("");


 

            document.getElementById('idRemision').value=$idRemision;
            document.getElementById('idusuario').value="<?php echo $DatUsuarioLog['idusuario'] ?>";
            document.getElementById('idestudiantegeneral').value="<?php echo $DatEstudiante['idestudiantegeneral'] ?>";
            document.getElementById('numerodocumento').value="<?php echo $DatEstudiante['numerodocumento'] ?>";
            document.getElementById('NomRem').value="<?php echo $DatUsuarioLog['nombres']?> "+"<?php echo $DatUsuarioLog['apellidos']?> ";
            document.getElementById('FacRem').value="<?php echo $DatFac['nombrefacultad'] ?>";
            document.getElementById('EmailRem').value="<?php echo $DatFac['emailusuariofacultad'] ?>";
            document.getElementById('NombreRemision').value=$Nombre;

            $('#FechaRegistro').text("");
            $('#FechaRegistro').slideUp();

            $('#actualizar').css('display', 'none'); 
            $('#eliminar').css('display', 'none'); 
            $('#guardar').slideDown();            
            $('#modal').modal();

            if ($idRemision==21) {

				jQuery("#DescripcionSolAcademica").removeAttr("required").focus().val("");
				jQuery("#DescripcionCompObs").removeAttr("required").focus().val("");
				jQuery("#DescripcionIntervenPae").removeAttr("required").focus().val("");

            	$('#SolAc').slideUp();
            	$('#primariaPae').slideUp();

            	$('#Pares').slideDown();
            	$('#Psico').slideUp();
            	$('#Psicope').slideUp();
            	$('#Lpl').slideUp();
            	$('#Fin').slideUp();
            }
            if ($idRemision==22) {

            	jQuery("#DescripcionSolAcademica").removeAttr("required").focus().val("");

            	$( "#DescripcionCompObs" ).attr({
                	required: "required"
            	});
            	$( "#DescripcionIntervenPae" ).attr({
                	required: "required"
            	});

            	$('#SolAc').slideUp();
            	$('#ComObser').slideDown();
            	$('#primariaPae').slideDown();

            	$('#Pares').slideUp();
            	$('#Psico').slideDown();
            	$('#Psicope').slideUp();
            	$('#Lpl').slideUp();
            	$('#Fin').slideUp();
            	
            }
            if ($idRemision==23 || $idRemision==24) {

            	jQuery("#DescripcionSolAcademica").removeAttr("required").focus().val("");
            	jQuery("#DescripcionCompObs").removeAttr("required").focus().val("");
            	$( "#DescripcionIntervenPae" ).attr({
                	required: "required"
            	});

            	$('#SolAc').slideUp();
      			$('#ComObser').slideUp();
            	$('#primariaPae').slideDown();

            	$('#Pares').slideUp();
            	$('#Psico').slideUp();
            	$('#Psicope').slideUp();
            	$('#Lpl').slideUp();
            	$('#Fin').slideUp();

            	if ($idRemision==23) {

            		$('#Psicope').slideDown();

            	}else{

            		$('#Lpl').slideDown();

            	}
            	
            }

            if ($idRemision==25) {

            	jQuery("#DescripcionSolAcademica").removeAttr("required").focus().val("");
            	jQuery("#DescripcionIntervenPae").removeAttr("required").focus().val("");
            	$( "#DescripcionSolAcademica" ).attr({
                	required: "required"
            	});
            	
            	$('#SolAc').slideDown();
            	$('#ComObser').slideUp();
            	$('#primariaPae').slideUp();


            	$('#Pares').slideUp();
            	$('#Psico').slideUp();
            	$('#Psicope').slideUp();
            	$('#Lpl').slideUp();
            	$('#Fin').slideDown();

            	
            }







        }



   /*$("#FormModal").on("submit", function(e){

   	var idestudiantegeneral=$("#idestudiantegeneral").val();
   	var idusuario=$("#idusuario").val();
    var NomRem=$("#NomRem").val();
    var FacRem=$("#FacRem").val();
    var CelRem=$("#CelRem").val();
    var FijoRem=$("#FijoRem").val();
    var EmailRem=$("#EmailRem").val();
    var DescripcionRemision=$("#DescripcionRemision").val();
    var DescripcionCompObs=$("#DescripcionCompObs").val();
    var DescripcionIntervenPae=$("#DescripcionIntervenPae").val();
    var DescripcionSolAcademica=$("#DescripcionSolAcademica").val();
    var periodo=$("#periodo").val();
    var idRemision=$("#idRemision").val();


   $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'GuardarRemision.php',
            data        : {idestudiantegeneral:idestudiantegeneral,idusuario:idusuario,NomRem:NomRem,FacRem:FacRem,CelRem:CelRem,FijoRem:FijoRem,EmailRem:EmailRem,DescripcionRemision:DescripcionRemision,DescripcionCompObs:DescripcionCompObs,DescripcionIntervenPae:DescripcionIntervenPae,periodo:periodo,idRemision:idRemision}, //Aquí tienes que enviar la información que necesita formula.html si no tiene nada puedes dejarlo así {}
            success: function(response)
            {
               location.reload();
            },
            error : function(response)
            {
                location.reload();
            }



   //return false;
 	});
 });*/
    </script>
    
    <form action="save.php" method="post" id="form_test">

        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $data['idobs_registro_riesgo'] ?>">
        <input type="hidden" name="entity" id="entity" value="registro_riesgo" />
        <input type="hidden" name="entity2" id="entity2" value="registro_riesgo_causas" />
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" /> 
         <input type="hidden" name="idobs_herramientas_deteccion" id="idobs_herramientas_deteccion" value="<?php echo $Th ?>" /> 
         
        <div id="container" style="margin-left: 70px">
        <div id="tabs">
            <ul>
                
            <li><a href="#tabs-1">
            	  <table  bgcolor="#86B404" >
                  <tr>
                    <td style="font-size:12px ; color:#FFF ; padding-top:6px ; padding-left:28px " >      Datos del                 </td>
                  </tr>
                  <tr>
                    <td style="font-size:12px ; color:#FFF  ;padding-bottom:6px ; padding-left:28px ;padding-top:0" width="180px" >      Remitente            </td>
                  </tr>
                </table>
            	


            </a></li>
            <!--<li><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos del<br />Remitido</span></a></li>
            <?php if ($tipo=='Notas' or $tipo=='Prueba' ){ ?> <li><div class="stepNumber">3</div><a href="#tabs-4"><span class="stepDesc">Causas de<br />Remisi&oacute;n</span></a></li><?php } ?>
            <?php if ($tipo=='Notas' or $tipo=='Prueba' ){ $num=4; }else{ $num=3; }?><li><div class="stepNumber"><?php echo $num; ?></div><a href="#tabs-3"><span class="stepDesc">Registro de<br />Riesgo</span></a></li>-->
            </ul>
            <div id="tabs-1">
                <?php  if ($idrol==2){
                         //   echo $id_doc.'-->>';
                            $fun->docente($db, $id_doc,$idrol); 
                        }else if ($tipo=='Notas'){
                            echo "Remite por Bajo Rendimiento";
                        }else if ($tipo=='Prueba'){
                            echo "Remite por Entrevista de Admisiones";
                        }else{
                            // echo "El estudiante viene por su cuenta <br>";
                          echo "";
                        }
                ?>
              </div>
          <div id="tabs-2">
                <?php  $fun->estudiante($db, $id_estu,$periodo,"",$tipo2 = "R");
                $fun->bus_remisiones($db,$periodo,$id_estu); 
                //echo $id_estu.'-->>';
                ?>
              <br>
              <br>
              <br>
             </div>
                <!--<div id="tabs-3">
                     <?php $fun->riesgos($db, '', $riesgo,'idobs_registro_riesgo_causas',$idR); ?>
                       <table border="0" class="CSSTableGenerator">
                           <tr>
                               <td><label class="titulo_label"><b>Nivel:</b></label></td>
                               <td>
                                <?php
                                  $query_riesgo = "SELECT nombretiporiesgo, idobs_tiporiesgo FROM obs_tiporiesgo where codigoestado='100'";
                                  $reg_riesgo =$db->Execute($query_riesgo);
                                  echo $reg_riesgo->GetMenu2('idobs_tiporiesgo',$data['idobs_tiporiesgo'],true,false,1,' id=idobs_tiporiesgo  style="width:150px;"');
                                  ?>
                               </td>
                           </tr>
                                        <tr>
                                            <td><label class="titulo_label"><b>Descripci&oacute;n:</b></label></td>
                                        <td colspan="5" >&nbsp;
                                         <div id="Descripcion">
                                                  <textarea style="height: 50px;" cols="76" id="observacionesregistro_riesgo" tabindex="3" name="observacionesregistro_riesgo"><?php echo $data['observacionesregistro_riesgo']; ?></textarea>
                                         </div>
                                         </td>
                                      </tr>
                                      <tr>
                                          <td><label class="titulo_label"><b>Intervenci&oacute;n Primera Instancia:</b></label></td>
                                        <td colspan="5" >&nbsp;
                                         <div id="Intervencion">
                                                  <textarea style="height: 50px;" cols="76" id="intervencionregistro_riesgo" tabindex="3" name="intervencionregistro_riesgo"><?php echo $data['intervencionregistro_riesgo']; ?></textarea>
                                         </div>
                                         </td>
                                      </tr>
                              </table>
              
                        </div>
            <?php if ($tipo=='Notas'  or $tipo=='Prueba'){ ?>
                    <div id="tabs-4">
                        <?php 
                        if ($tipo=='Notas' ){
                            $fun->registro_academico($db, $matriz_completa);
                            
                        }
                        if ($tipo=='Prueba' ){
                            $fun->registro_prueba($db, $id_estu);
                            
                        }
                        
                        ?>
                    </div>    
            <?php } ?>
        </div>
                   <div class="derecha" >
                        <?php if (!empty($roles)){?>
                            <button class="submit" type="submit" tabindex="3">Guardar</button>
                            &nbsp;&nbsp;                       -->
                         <?php } ?>
                        <!--<a href="listar_registro_riesgo2.php?tipo=R" class="submit" tabindex="4">Regreso al menú</a>-->
                        
                    </div><!-- End demo -->
        </div>
  </form>

<script type="text/javascript">
      
     
                /*$(':submit').click(function(event) {
                    event.preventDefault();
                     if(validar()){  
                        sendFormdata();
                        //sendForminfo()
                    } 
                });*/
                
                function validar(){
                    j=0
                    var nriesgo=$("#nriesgo").val();
                    var riesgo='';
                    for (i=0; i<nriesgo; i++){
                        if($("#idobs_causas_"+i).is(':checked')) { 
                           j++
                        }
                    }   
                   //alert(j+'<<-->>')
                    if($.trim($("#codigoestudiante").val())=='') {
                                alert("Debe escoger un Estudiante");
                                return false;
                        }else if($.trim($("#idobs_tiporiesgo").val())=='') {
                                alert("No ha escogido el nivel de riesgo");
                                 $('#idobs_tiporiesgo').css('border-color','#F00');
				$('#idobs_tiporiesgo').effect("pulsate", {times:3}, 500);
                                $("#idobs_tiporiesgo").focus();
                                return false;
                        }else if($.trim($("#observacionesregistro_riesgo").val())=='') {
                                alert("Debe Digitar la Descripcion");
                                 $('#observacionesregistro_riesgo').css('border-color','#F00');
				$('#observacionesregistro_riesgo').effect("pulsate", {times:3}, 500);
                                $("#observacionesregistro_riesgo").focus();
                                return false;
                        }else if($.trim($("#intervencionregistro_riesgo").val())=='') {
                                alert("Debe Digitar la Intervencion Primera Instacia");
                                 $('#intervencionregistro_riesgo').css('border-color','#F00');
				$('#intervencionregistro_riesgo').effect("pulsate", {times:3}, 500);
                                $("#intervencionregistro_riesgo").focus();
                                return false;
                        }else if (j==0){
                            alert("Debe escoger minimo un riesgo");
                            return false;
                        }else{
                            return true;
                        }     
                }
                
                     
                function sendFormdata(){
                    var entity=$("#entity").val();
                    var iddocente=$("#iddocente").val();
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val()
                    var codigoestudiante=$("#codigoestudiante").val();
                    var observacionesregistro_riesgo=$("#observacionesregistro_riesgo").val();
                    var intervencionregistro_riesgo=$("#intervencionregistro_riesgo").val();
                    var codigoperiodo=$("#codigoperiodo").val();
                    var idobs_tiporiesgo=$("#idobs_tiporiesgo").val();
                    var codigoestado=$("#codigoestado").val();
                    var idobs_herramientas_deteccion=$("#idobs_herramientas_deteccion").val();
                    var matriz=$("#matriz").val();
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, iddocente:iddocente, codigoestudiante:codigoestudiante,
                                observacionesregistro_riesgo:observacionesregistro_riesgo, intervencionregistro_riesgo:intervencionregistro_riesgo, 
                                idobs_tiporiesgo:idobs_tiporiesgo, codigoestado:codigoestado, idobs_herramientas_deteccion:idobs_herramientas_deteccion,
                                idobs_registro_riesgo:idobs_registro_riesgo, matriz:matriz
                        },            
                        success:function(data){
                            if (data.success == true){
                                //alert(data.message);
                                $("#idobs_registro_riesgo").val(data.id);
                                sendForminfo();
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }
             
             function sendForminfo(){
                    var entity=$("#entity2").val();
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val();
                    var codigoestado=$("#codigoestado").val();
                    var nriesgo=$("#nriesgo").val();
                    var riesgo='';
                    for (i=0; i<nriesgo; i++){
                        if($("#idobs_causas_"+i).is(':checked')) { 
                           riesgo+=$("#idobs_causas_"+i).val()+','; 
                        }else{
                           riesgo+='0,'; 
                        }
                    }
                    riesgo = riesgo.substring(0, riesgo.length-1)
                     var conP=''
                     i=0
                    $('input[name="idobs_registro_riesgo_causas[]"]').each(function() { 
                        if ($(this).val()!=''){
                            conP += $(this).val() + ","; 
                        }else{
                            conP +='0,';
                        }
                        i++
                    });
                     conP = conP.substring(0, conP.length-1) 
                     var herr=$("#idobs_herramientas_deteccion").val();
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_arr.php',
                        data: { action: "getData", entity:entity, codigoestado:codigoestado, idobs_registro_riesgo:idobs_registro_riesgo,
                                riesgo:riesgo, conP:conP
                         },            
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                if(herr==4){
                                    $(location).attr('href','../../consulta/estadisticas/riesgos/menuriesgossemestre.php?tipo=R'); 
                                }else if(herr==3){
                                     $(location).attr('href','listar_estudiantes_riesgo_admin.php?tipo2=R'); 
                                }else{
                                    $(location).attr('href','listar_registro_riesgo.php?tipo=R');
                                }
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }
                
                
</script>

</body>
</html>
    
<?php    writeFooter();


if(isset($_POST['accion'])){
    alert("joder");
    echo "hernan";
}
        ?>  

