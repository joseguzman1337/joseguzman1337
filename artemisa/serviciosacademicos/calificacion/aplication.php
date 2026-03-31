<!doctype html>
<head>
<meta charset="utf-8">
<title>Calificaci&oacuten de Servicio Cl&iacutenica el Bosque</title>	
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- keyboard widget css & script (required) -->
	<link href="css/keyboard.css" rel="stylesheet">
        <link href="css/demo.css" rel="stylesheet">
	<script src="js/jquery.keyboard.js"></script>
	<!-- keyboard extensions (optional) -->
	<script src="js/jquery.mousewheel.js"></script>	
	<script>
		$(function(){
			$('#identificacion').keyboard({
                            layout: 'custom',
                            customLayout: {
                            'default' : [
                            'C D E F',
                            '8 9 A B',
                            '4 5 6 7',
                            '0 1 2 3',
                            '{bksp} {a} {c}'
                            ]
                            },
                            maxLength : 9,
                            visible : function (){coments = 0;},
                            lockInput : true,
                            restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
                            useCombos : false // don't want A+E to become a ligature
                            }
                        );                        
                        $('#comentario').keyboard({
                            lockInput : true,
                            visible : function (){setComment();},
                            hidden : function (){window.coments = 1; window.timesLoader = 5000;}
                        });  
		});
                
	</script>
        

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<br>    
<br>
<div id="aplication">
<section id="container2" class="container2">
<img id="logo" alt="Clínica El Bosque" src="images/logotipo.png">
<div id="banner">
<br>    
<br>
<br>
<section>
<p><b>Ayudemos a mejorar nuestro servicio</b></p>

</section>
<section>
    <p>&nbsp;</p>
</section>
</div>
<section>       
</section>
<hr>
<section>    
    <div>
    <div id="ok" style="display: none;">
        <center>    
    
        <p>Gracias Por su colaboraci&oacute;n, si desea realizar comentarios acerca de nuestro servicio por favor presione el bot&oacuten</p>
        <img src="images/ok.png" width="250" height="200"/>
        </center>        
    <!--small>Nombre:<input type="text" name="nombre" id="nombre" value="" />
    Tel&eacute;fono:<input type="text" name="telefono" id="telefono" value="" size="12"/>
    Email <input type="text" name="mail" id="mail" value="" /></small!-->        
    </div>   
    <div id="coments" style="display: none;">
    <p>Ingrese sus Comentarios <img id="inter-type" class="tooltip" title="Ingrese sus comentarios" src="images/keyboard.png"></p>    
    <div class="block"><textarea name="comentario" id="comentario" cols="72"></textarea></div>
    <div><input type="button" name="guadarcomentario" id="guadarcomentario" value="Enviar Comentario"></div>
    </div>  
    <div class="centrado">
        <p>Dig&iacute;te su N&uacute;mero de C&eacute;dula o Historia Cl&iacute;nica &nbsp;&nbsp;&nbsp;&nbsp;&nbsp <input type="text" name="indentificacion" id="identificacion" value="" /></p>    
        <p>Califique Nuestro Servicio</p>    
    <table border="0">        
        <tr style="text-align: center;">
        <?php 
        include 'db/db.inc';
        $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
        $query = "select * from  cl_opcion_evaluacion";
        $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
        while($row = mysql_fetch_array($result)) {            
            printf("<td><div id='image".$row["idcl_opcion_evaluacion"]."' class='contadorClicks'><img src='".$row["image"]."'/><br>".$row["opcion"]."</div></td>");
        }
        mysql_free_result($result);
        ?>
        </tr>
    </table>
    </div>
    <?php if(!$_REQUEST['id'])$_REQUEST['id']=1;?>
    <input type="hidden" name="idcl_servicio" id="idcl_servicio" value="<?php echo $_REQUEST['id']?>">
    <input type="hidden" name="idevaluacion" id="idevaluacion" value="">    
    </div>
</section>
</section>
</div>
</body>
<script src="js/script.js" type="text/javascript"></script>
</html>