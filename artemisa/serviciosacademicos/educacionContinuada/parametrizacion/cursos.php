<?php

    session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Valores de Defecto de Programas",TRUE);

    include("./menu.php");
    writeMenu(1);
    $utils = Utils::getInstance();
    $cat = "CURSOS";
    $valores = $utils->getValoresParametrizacion($db,"CURSOS");
	//var_dump($valores);
    $numValores = count($valores);
?>

    <div id="contenido">
        <h4>Valores por Defecto para el Registro de Programas</h4>
        <div id="form"> 
         <form action="save.php" method="post" id="form_test">
             <input type="hidden" name="action" value="updateValues" />
             <input type="hidden" name="categoria" value="<?php echo $cat; ?>" />
            <?php for($i = 0; $i < $numValores; ++$i) { ?>
                <div class="campo">
                    <label for="nombre" class="grid-2-12"><?php echo $valores[$i]["etiquetaCampo"]; ?>: <span class="mandatory">(*)</span></label>
                    <?php $utils->pintarCampo($db,$valores[$i]); ?>     
                </div>
				<div class="vacio"></div>
            <?php } ?> 
                         
             <input type="submit" value="Guardar valores" class="first" />
         </form>
        </div>
    </div>  


<script type="text/javascript">
                $(':submit').click(function(event) {
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
                                alert(data.message);
                                 window.location.href="cursos.php";
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
<?php  writeFooter(); ?>