<?php
class MostrarEncuesta {
    var $tipousuario;
    var $objetobase;
    var $formulario;
    var $consultaencuesta;
    var $arrayencuesta;
    var $arraydatosrespuesta;
    var $arraytitulospestanas;
    var $idusuario;
    var $datosencuesta;
    var $conpreguntatabla;


             
  
   
    function MostrarEncuesta($idusuarioencuesta,$objetobase,$formulario,$consultaencuesta) {

        $this->idusuario=$idusuarioencuesta;
        $this->codigotipousuario=$tipousuario;
        $this->objetobase=$objetobase;
        $this->formulario=$formulario;
        $this->objconsultaencuesta=$consultaencuesta;
        //$this->validaencuesta=new ValidaEncuesta();

    }
    function setIdEncuesta($idencuesta) {
        $this->idencuesta=$idencuesta;
        $this->datosencuesta=$this->objetobase->recuperar_datos_tabla("encuesta","idencuesta",$this->idencuesta,"","",0);
        $this->objconsultaencuesta->setIdEncuesta($idencuesta);
    }
    function setTitulosEncuesta($arraytitulos) {
        $this->arraytitulos=$arraytitulos;

    }
    function mostrarTitulosEncuesta() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo("<b><BR>".$this->datosencuesta["titulo1encuesta"]."<BR><BR></b>",'tdtituloencuesta',"2","align='center'","td");
        $this->formulario->dibujar_fila_titulo("<b><br>".$this->datosencuesta["titulo2encuesta"]."<br><br></b>","tdtituloencuestadescripcion","2","align='left'","td");
        echo "</table>";
        if(is_array($this->arraytitulos))
            foreach($this->arraytitulos as $i=>$valortitulo) {
                echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
                if(isset($valortitulo["estilo"])&&trim($valortitulo["estilo"])!='') {
                    $estilo=$valortitulo["estilo"];
                }
                else {
                    $estilo='tdtituloencuestadescripcion';
                }

                $this->formulario->dibujar_fila_titulo($valortitulo["descripcion"],$estilo,"2","align='left'","td");
                echo "</table>";
            }
    }
    function iniciarEncuestaUsuario() {
        $this->objconsultaencuesta->consultaprimernivelpreguntas();
        $this->arrayencuesta=$this->objconsultaencuesta->recuperarencuesta();
        $this->arraydatosrespuesta=$this->objconsultaencuesta->recuperarrespuestapreguntausuario($this->idusuario);
        $this->arraytitulospestanas=$this->objconsultaencuesta->recuperarpadrepreguntas();

    }
     function iniciarEncuestaTipoUsuario() {
        $this->arrayencuesta=$this->objconsultaencuesta->recuperarencuesta();
        $this->arraydatosrespuesta=$this->objconsultaencuesta->recuperarrespuestapreguntausuario($idusuario);
        $this->arraytitulospestanas=$this->objconsultaencuesta->recuperarpadrepreguntas();

    }
    
    function ingresarTotalPreguntas($tablaparametro="respuestadetalleencuestapreguntadocente",$filaadicional=array()) {
		
		

        if(!is_array($this->arraydatosrespuesta)) {
            foreach($this->objconsultaencuesta->preguntasencuesta as $llave=>$idpregunta ) {
                unset($fila);
                $tabla=$tablaparametro;
                if(count($filaadicional)>1) {
                    $fila=$filaadicional;
                }
                //$fila["idpregunta"]=$idpregunta;
                $fila["numerodocumento"]=$this->idusuario;
                $fila["valor".$tabla]="";
                $fila["codigoestado"]="100";
                $idencuestapregunta=$this->objconsultaencuesta->recuperaidencuestapregunta($idpregunta,$this->idencuesta);
                $fila["idencuestapregunta"]=$idencuestapregunta;


                $condicionactualiza=" idencuestapregunta='".$idencuestapregunta."'".
                        " and numerodocumento='".$this->idusuario."'";

                $this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);

            }
        }
    }
     function imprimirEncuesta($tituloinicial="") {
		
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo($tituloinicial,'tdtituloencuestadescripcion',"2","align='left'","td");
        echo "</table>";


        echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla=0;
        foreach($this->objconsultaencuesta->arbolpreguntas as $idpregunta=>$ramapregunta) {
            echo "	<div class='dhtmlgoodies_aTab'>
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

            $this->objconsultaencuesta->muestraformulariopreguntas($ramapregunta,$idpregunta,$this->idencuesta);
            $this->botonesFormulario();
            echo "</table>";
            echo "</div>";
        }

        echo "</div>";


    }
   function imprimirResultadosEncuesta($tituloinicial="",$cadenaparametros,$tablasadicionales) {
        //echo "<h1>ENTRO</h1>";
       
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo($tituloinicial,'tdtituloencuestadescripcion',"2","align='left'","td");
        echo "</table>";
 
        echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla=0;
       
        foreach($this->objconsultaencuesta->arbolpreguntas as $idpregunta=>$ramapregunta) {
            echo "	<div class='dhtmlgoodies_aTab'>
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
		
     unset($this->objconsultaencuesta->arrayNotas);


           $this->objconsultaencuesta->muestraresultadospreguntas($ramapregunta,$idpregunta,$this->idencuesta,$cadenaparametros,$tablasadicionales);
          
           
           
           
           
      //     exit();
           
           
            $numeronotas=count($this->objconsultaencuesta->arrayNotas);
            //~ $numeronotastotal+=$numeronotas;
            $sumanotas=0;
            
		 
            foreach($this->objconsultaencuesta->arrayNotas as $inota=>$notaparcial){
				
				/*echo"<pre>";
print_r($this->objconsultaencuesta);
echo"</pre>";*/
                $sumanotas+=$notaparcial;
                $sumanotastotal+=$notaparcial;
            }
            $notaporpestana=round($sumanotas/$numeronotas,2);
            $this->formulario->dibujar_fila_titulo("<b>Nota parcial</n> ".$notaporpestana,'tdtituloencuestadescripcion',"2","align='right'","td");
            $this->botonesResultado();
            echo "</table>";

            echo "</div>";
        }


        echo "</div>";
        echo "<div style =' 	position:absolute;
	left:8px;
	top:350px;
	z-index:1;'>";
         echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
         
        
         //  $notaporpestana=round($sumanotastotal/$numeronotastotal,2);
            $this->formulario->dibujar_fila_titulo("<b>Nota Total</n> ".$notaporpestana,'tdtituloencuestadescripcion',"4","align='left'","td");
        echo "</table>";
echo "</div>";
    }
    function botonesFormulario() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $conboton=0;

        /*$parametrobotonenviar[$conboton]="'submit','Guardar','Guardar',''";
		$boton[$conboton]='boton_tipo';
		$conboton++;*/
        $parametrobotonenviar[$conboton]="'button','Seguir','Seguir','onclick=\'return cambiapestana(".($this->conpreguntatabla+1)."); \''";
        $boton[$conboton]='boton_tipo';

        if($this->conpreguntatabla>=(count($this->objconsultaencuesta->arbolpreguntas)-1))
            $parametrobotonenviar[$conboton]="'submit','Finalizar','Finalizar',''";
        $boton[$conboton]='boton_tipo';

        /*$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';*/
        $this->formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');

        $this->formulario->dibujar_fila_titulo('<b>Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion</b>','',"2","align='center'","td");
        $this->conpreguntatabla++;
        echo  "</table>";
    }
function botonesResultado() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $conboton=0;

        /*$parametrobotonenviar[$conboton]="'submit','Guardar','Guardar',''";
		$boton[$conboton]='boton_tipo';
		$conboton++;*/
        $parametrobotonenviar[$conboton]="'button','Seguir','Seguir','onclick=\'return cambiapestana(".($this->conpreguntatabla+1)."); \''";
        $boton[$conboton]='boton_tipo';

        //if($this->conpreguntatabla>=(count($this->objconsultaencuesta->arbolpreguntas)-1))
            //$parametrobotonenviar[$conboton]="'submit','Finalizar','Finalizar',''";
       // $boton[$conboton]='boton_tipo';

        /*$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';*/
        $this->formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');

        $this->formulario->dibujar_fila_titulo('<b>Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion</b>','',"2","align='center'","td");
        $this->conpreguntatabla++;
        echo  "</table>";
    }
    function guardarEncuesta($mensajeexito,$mensajefalta,$direccionexito,$direccionfalta,$tablaparametro="respuestadetalleencuestapreguntadocente",$filaadicional=array()) {

        if(isset($_POST["Finalizar"])) {


            foreach($_POST["preguntas"] as $llave=>$idpregunta) {
                //echo "<br>".$llave."=>".$idpregunta." =>".$_POST[$idpregunta];
                unset($fila);

                //$tabla="respuestadetalleencuestapreguntadocente";
                $tabla=$tablaparametro;
                if(count($filaadicional)>1) {
                    $fila=$filaadicional;
                }
                //$fila["idpregunta"]=$idpregunta;
                $fila["numerodocumento"]=$this->idusuario;
                $fila["valor".$tabla]="".$_POST[$idpregunta];
                $fila["codigoestado"]="100";
                $idencuestapregunta=$this->objconsultaencuesta->recuperaidencuestapregunta($idpregunta,$_POST["idencuesta"]);
                $fila["idencuestapregunta"]=$idencuestapregunta;


                $condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
                        " and numerodocumento='".$this->idusuario."'";
                //echo "<pre>";
                $this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
                //echo "</pre>";
            }
            $this->formulario=$this->objconsultaencuesta->recuperaobjetoformulario();
            /*echo "<h1>FORMULARIO</h1><pre>";
	print_r($formulario);
	echo "</pre>";*/
            $validacion=$this->formulario->valida_formulario();
            if($validacion==false) {
                //"No puede continuar hasta que diligencie toda la encuesta "
                alerta_javascript($mensajefalta);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccionfalta."'>";

            }
            else {
                //"Gracias por su colaboración, sus respuestas son utiles para el mejoramiento de nuestra Institución .\\n Puede continuar"
                alerta_javascript($mensajeexito);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccionexito."'>";
            }

        }

    }
}

?>
