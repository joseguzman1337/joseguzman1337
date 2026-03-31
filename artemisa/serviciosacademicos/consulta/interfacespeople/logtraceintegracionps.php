<?php
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Log integracion People Soft</title>
		<style type="text/css" title="currentStyle">
			@import "./media/css/demo_page.css";
			@import "./media/css/demo_table_jui.css";
			@import "./examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css";
                                        div.panel,p.flip
                                        {
                                        margin:0px;
                                        padding:5px;
                                        text-align:center;
                                        background:#e5eecc;
                                        border:solid 1px #c3c3c3;
                                        position:absolute;
                                        }
                                        div.panel
                                        {
                                        display:none;
                                        }

                        .tip{
                        background-color: #ffcc99;
                        padding: 10px;
                        display: none;
                        position: absolute;
                        }
                        
		</style>
		<script type="text/javascript" language="javascript" src="./media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="./media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				oTable = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
                                                        
			} );

                        function mostrar(id){
                            //elemento = document.getElementsByClassName('tip');
                            $('.tip').css("display", "none");
                            $("#panel"+id).css("left", $(id).pageX + 5);
                            $("#panel"+id).css("top", $(id).pageY + 5);
                            $("#panel"+id).css("display", "block");
                            $("#panel"+id).css("z-index", "3");
                        }
                        function ocultar(id){                                
                                $("#panel"+id).css("display", "none");
                        }
		</script>
	</head>
	<body id="dt_example">
		<div id="container">
                    <div class="full_width big">
				TRACE DE ORDENES DE PAGO INTEGRACION PS 
			</div>			
			<h1></h1>
<form name='forma' method='post' action='logtraceintegracionps.php'>
    <p>
    Filtrar por n&uacute;mero de orden o Documento <input type='text' name='nroorden' value='<?php echo $_REQUEST['nroorden']?>' size='10' style='text-align:center'>
    <input type='submit' value='Filtrar'>               
    </p>
</form>                        
<h1>Resultados:</h1>
<div class="demo_jui">                           
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
    <tr>
        <th>Transaccion</th>
        <th>Envio</th>
        <th>Respuesta</th>
        <th>Orden o Documento</th>
        <th>Fecha de Registro</th>
    </tr>
    </thead>
    <tbody>
    <?php                        
        if ($_REQUEST['nroorden']){
            $where=($_REQUEST['nroorden'])?" where documentologtraceintegracionps=".$_REQUEST['nroorden']:"";
        }else{
            $where="";
        }
            
           $query="SELECT * from logtraceintegracionps $where order by fecharegistrologtraceintegracionps desc limit 0 , 100";
            $orden = mysql_query($query, $sala) or die("$query" . mysql_error());       

            while($row=mysql_fetch_array($orden)){
                /*
                * psibles clases para pintar el grid (Color)
                * <tr class="gradeC">
                * <tr class="gradeA">
                * <tr class="gradeX">
                *<tr class="gradeU">
                * 
                */
                                // Palabra que queremos buscar

		$txt=htmlentities($row['respuestalogtraceintegracionps']);
		$palabra="Correcto";
		if(ereg("id:0",$txt) || ereg("ERRNUM=0",$txt)) {
			if(ereg("Correcto",$txt) || ereg("Ok",$txt))
				$calss = "class='gradeA'";
			else
				$calss = "class='gradeC'";
		} else
			$calss = 'class="gradeX"';
                
                //if(eregi("[ tnr]+".$palabra."[ tnr]+",htmlentities($row['respuestalogtraceintegracionps']))) {
                //$calss = 'class="gradeX"';
               // } else {
                //echo 'No existe'; 
                //}
                    echo "<tr $calss>";
                    echo "<td>".$row['transaccionlogtraceintegracionps']."</td>";                    
                    echo "<td><a href='#' id=".$row['idlogtraceintegracionps']." onclick='javascript:mostrar(this.id);' >Ver Estructura XML</a>
                <div class='tip' id='panel".$row['idlogtraceintegracionps']."' style='display:none;'>
                    <p calss='closed' id=".$row['idlogtraceintegracionps']." onclick='javascript:ocultar(this.id);'>Cerrar</p>
<pre>". trim(htmlentities($row['enviologtraceintegracionps'])) ."</pre></div>
                            </td>";
                    echo "<td>". substr(trim(htmlentities($row['respuestalogtraceintegracionps'])),0,25) ."<a href='#' id=".$row['idlogtraceintegracionps']." onclick=javascript:mostrar('Error'+this.id);>...ver mas(+)</a>
                        <div class='tip' id='panelError".$row['idlogtraceintegracionps']."' style='display:none;text-align: justify;'>
                    <p calss='closed' id=".$row['idlogtraceintegracionps']." onclick=javascript:ocultar('Error'+this.id);>Cerrar</p>
<pre>". trim(htmlentities($row['respuestalogtraceintegracionps'])) ."</pre></div>

</td>";
                    echo "<td class='center'>".$row['documentologtraceintegracionps']."</td>";
                    echo "<td class='center'>".$row['fecharegistrologtraceintegracionps']."</td>";
                    echo "</tr>";
            }        
        
    ?>

    </tbody>
</table>
    </div>
<div class="spacer" style=""></div>
    </div>
</body>
</html>
