<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Asignar Función a Indicador",TRUE,$proyectoNumericos,"../../","body",$Utils_numericos);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $utils = new Utils_numericos;
    
   $id = $_REQUEST["id"];
   $action = $_REQUEST["action"];
       
    if(strcmp($action,"inactivate")==0){
       $fields = array();
       $fields["idsiq_funcionIndicadores"] = $id;
       $data = $utils->processData($_REQUEST["action"],"funcionIndicadores", $fields); 
       $url = "detalle.php?id=".$id;
       echo "<script>window.location.href=".$url."</script>";
       header('Location: '.$url);
       exit();
    } else if(strcmp($action,"save")==0){  
       $data = $utils->getDataEntity("indicador", $id); 
       $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]); 
       $tiposFuncion = $utils->getActivesFuncion($db,"nombre,idsiq_funcion","funcion");
       $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]);   
       $entity = array();
        if($discriminacion["idsiq_discriminacionIndicador"]==1){
            $entity["nombre"] = $discriminacion["nombre"];
        } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
            $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$data["idFacultad"]."'");
            $entity["nombre"] = $facultad["nombrefacultad"];           
        } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
            $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
            $entity["nombre"] = $carrera["nombrecarrera"];  
        } 
   
      $SQL_info='SELECT idsiq_funcion,nombre FROM siq_funcion WHERE codigoestado=100';

           if($info=&$db->Execute($SQL_info)===false){
                echo 'Error en Información Indicador.. <br>'.$SQL_info;
		     die;
	}
       // var_dump($info);
    
?>
        
        <div id="contenido">
            <h2>Asignar Función a Indicador Numérico</h2>
            <div id="form"> 
                <div id="msg-error"></div>

                <form action="save.php" method="post" id="form_test" >
                        <input type="hidden" name="entity" value="funcionIndicadores" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Información del Indicador</legend>
                            <label class="grid-2-12">Indicador: </label>
                            <p><?php echo $indicadorGenerico["nombre"]." ( ".$entity["nombre"]." )"; ?></p>        
                            <input type="hidden" name="idIndicador" value="<?php echo $data["idsiq_indicador"]; ?>" />                   
                        </fieldset>
                      
                         <fieldset>   
                              <legend>Información de la Función</legend>
                               <label class="grid-2-12">Tipo de Función: </label>
                              <select id="users" name="idsiq_funcion" onchange="showUser(this.value)">
                               <option value="-1">Seleccionar...</option> 
                                     <?PHP 
					while(!$info->EOF){
					?>
                                         <option  value="<?PHP echo $info->fields['idsiq_funcion']?>"><?PHP echo $info->fields['nombre']?></option>
					<?PHP
					$info->MoveNext();
					}
					?>
                                </select>
                              
                              
                            <br>
                            <div id="txtHint"><b>seleccionar para ver informacion de la función.</b></div>
                         </fieldset>      
                        
                       <input type="submit" value="Asignar Función" class="first" />
                    </form>
            </div>            
        </div>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    //var buttonName = $(this).attr('name');

                    //if (buttonName.indexOf('edit') >= 0) {
                        //confirm("some text") logic...
                    //}
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendForm();
                    }
                });

                function sendForm(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                <?php $url = "detalle.php?id=".$id; ?>
                                window.location.href="<?php echo $url; ?>";
                            }
                            else{   
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
                $(document).ready(function() {
                    $('#usuarioResponsable').autocomplete({
                        source: "../lookForUsers.php",
                        minLength: 2,
                        selectFirst: false,
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idUsuarioResponsable').val(ui.item.id);
                        }                
                    });
                });
  </script>
    <script>
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getuser.php?q="+str,true);
xmlhttp.send();
}
</script>
<?php } writeFooter(); ?>