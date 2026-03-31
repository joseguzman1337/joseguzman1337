<?

  include("../templates/templateObservatorio.php");
  include("funcionesPruebaAcademica.php");  

  $fun = new Observatorio();
  $db =writeHeader("Prueba Académica",true,"PAE",1,'Prueba Académica');




 ?> 

<script src="js/jquery.js"></script>
<script>
    
    $(document).ready(function(){


    	$("#f1").submit(function(event) {
	        event.preventDefault();
	        $.ajax({
	            url: "EstudiantesDataPruebaAcademica.php", //pagina de destino
	            type: "POST", //metodo de envio
	            data: $("#f1").serialize(), //donde estan los datos
	            beforeSend: function() {
	                $("#divres").html("Espere un momento");
	            },
	            success: function(res) {
	                $("#divres").html(res); //mensaje desde ingresar.php
	            }
	        });
	    });


});


function listar(){
    $.ajax({
        url: "ListarModalidad2.php",
        data: $("#f1").serialize(),
        type: "get",
        beforeSend: function(){
            $("#mensaje").html("Espere un momento...");
        },
        success: function(dat){
            $("#mensaje").html("");
            $("#codigocarrera").html(dat);
        }
    });
};

</script>

         <div id="container" style="margin-left: 70px; ">
         	            <ul>    
            <li><p align="justify">Aquí usted podrá encontrar la información correspondiente a los estudiantes con estatus de Prueba Académica (Rendimiento académico con promedio semestral o acumulado menor a 3.3. Art. 55 Reglamento Estudiantil) o de Reintegro (Condición avalada por el Consejo de Facultad bajo compromiso académico y de seguimiento. Art. 57 Reglamento Estudiantil). Estos estudiantes deben recibir un SEGUIMIENTO PRIORITARIO desde el PAE debido al riesgo de incurrir en Pérdida de la Calidad del Estudiante (Art. 3 Reglamento Estudiantil) si no supera su riesgo académico. Todo ello en el marco del Acuerdo 11989 de 2013 que enmarca el compromiso institucional de acompañamiento a estudiantes con bajos promedios a través de la tutoría integral PAE.</p></li>
            </ul>
           <div id="tabs">
            <ul>    
            <li>
              <a href="#tabs-1">
                <table  bgcolor="#ea8511" >
                  <tr>
                    <td style="font-size:12px ; color:#FFF ; padding-top:6px ; padding-left:28px " >      Criterios                 </td>
                  </tr>
                  <tr>
                    <td style="font-size:12px ; color:#FFF  ;padding-bottom:6px ; padding-left:28px ;padding-top:0" width="180px" >      Institucionales            </td>
                  </tr>
                </table>
              </a>
            </li>
            </ul>
            <div id="tabs-1">
              <form id="f1" method="POST" action="EstudiantesDataPruebaAcademica.php">
                <table border="0" class="CSSTableGenerator">
                    <tr>
                        <td><label class="titulo_label"><b>Modalidad Acad&eacute;mica:</b></label></td>
                        <td>
                          <?php
                          $fun->ModalidadAcademica();
                          ?>
                        </td>                        
                    </tr>
                    <tr>
                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                        <td>
                          <select name="codigocarrera" id="codigocarrera">
                            
                          </select>
                        </td>
                    </tr>
                </table>
                <br>
            <button type="submit" id="buscar" name="buscar" class="submit">Buscar</button> 
            &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
              </form>
            </div>
           </div>
            <br>

            <div id="mensaje" name="mensaje"></div>
            <div id="divres" name="divres"></div>
          </div>