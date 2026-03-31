<?php
$ruta=dirname(__FILE__);
$rutaado=($ruta."/../funciones/adodb/");
require_once($ruta."/../Connections/salaado-pear.php");
require_once($ruta."/../funciones/sala_genericas/FuncionesCadena.php");
require_once($ruta."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once($ruta."/../funciones/funcionpassword.php");
require_once($ruta."/../funciones/clases/phpmailer/class.phpmailer.php");
require_once($ruta."/../funciones/clases/autenticacion/claseldap.php");
require_once($ruta."/../Connections/conexionldap.php");

$salaobjecttmp=$sala;
unset($sala);
ini_set('max_execution_time','6000');

class GeneraClaveUsuario {
    var $datosorden;
    var $objetobase;
    var $numeroorden;
    var $mensaje;
    var $fechaintento;
    var $estudiantegeneral;
    var $idusuario;
    var $clave;
    var $objetoldap;
    
    /*/
    function ConstruirCorreo($array_datos_correspondencia,$destinatario,$nombredestinatario,$trato){
        if(is_array($array_datos_correspondencia)){
            $mail = new PHPMailer();
            $mail->From = $array_datos_correspondencia['correoorigencorrespondencia'];
            $mail->FromName = $array_datos_correspondencia['nombreorigencorrespondencia'];
            $mail->ContentType = "text/html";
            $mail->Subject = $array_datos_correspondencia['asuntocorrespondencia'];
            //aquï¿½en $cuerpo se guardan, el encabezado(carreta) y la firma
            $encabezado=$trato.":<br>".$nombre_destinatario;
            $cuerpo=$encabezado."<br><br>".$array_datos_correspondencia['encabezamientocorrespondencia'];
            //$cuerpo2="en ".$array_datos_correo['direccionsitioadmision'].", telï¿½ono: ".$array_datos_correo['telefonositioadmision']." el dï¿½ ".$array_datos_correo['dia']." de ".$array_datos_correo['mesTexto']." del aï¿½ ".$array_datos_correo['ano'].' a las '.substr($array_datos_correo['hora'],0,5)." en el salï¿½ ".$array_datos_correo['codigosalon'].".<br>";
            //$cuerpo3="<br><br>".$this->$array_datos_correo['firmacorrespondencia'];
            $mail->Body = $cuerpo;
            //echo $cuerpo.$cuerpo2.$cuerpo3;
            $mail->AddAddress($destinatario,$nombre_destinatario);
            //$mail->AddAddress("castroabraham@unbosque.edu.co","Prueba");
            //$mail->AddAddress("dianarojas@sistemasunbosque.edu.co","Prueba");
            
            if(is_array($array_datos_correspondencia['detalle'])){
                foreach ($array_datos_correspondencia['detalle'] as $llave => $url){
                    //$ruta="tmp/".$url;
                    //echo "<br>entro el atqachment AddAttachment($url,$llave);<br>";
                    if(!$mail->AddAttachment($url,$llave)){
                        alerta_javascript("Error no lo mando AddAttachment($url,$llave)");
                    }
                }
            }
            
            if(!$mail->Send()){
                echo "El mensaje no pudo ser enviado";
                echo "Mailer Error: " . $mail->ErrorInfo;
                exit();
            }else{
                if($this->depurar==true){
                    echo "Mensaje Enviado";
                    echo "<br>";
                    echo "<pre>";
                    print_r($mail);
                    echo "</pre>";
                }
            }
            
            return true;
        }else{
            return false;
        }
    }/**/
    
    function GeneraClaveUsuario($numeroorden,$salaobjecttmp){
        $this->numeroorden=$numeroorden;
        $this->objetobase=new BaseDeDatosGeneral($salaobjecttmp);
        $this->objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
        
        $this->objetoldap->ConexionAdmin();
        
        $this->fechaintento=date("Y-m-d H:i:s");
        //$this->encuentra_estudiante_orden($numeroorden);
	if($this->encuentra_estudiante_orden($numeroorden)){
            if(!($usuariodatos = $this->objetobase->recuperar_datos_tabla("usuario u","u.numerodocumento",$this->datosorden["numerodocumento"]," and codigotipousuario = '600' ","",0))){
                //if($this->datosorden["codigoperiodoorden"]==$this->datosorden["codigoperiodoestudiante"]){
                $tablas="ordenpago o,estudiante e,detalleordenpago dp";
                $condicion=" and o.codigoestudiante=e.codigoestudiante
                    and e.codigoestudiante=".$this->datosorden["codigoestudiante"]."
                        and o.numeroordenpago=dp.numeroordenpago 
                        and o.numeroordenpago<".$numeroorden.
                        " and o.codigoestadoordenpago like '4%'";
                
                if(!($datosordenantigua=$this->objetobase->recuperar_datos_tabla($tablas,"dp.codigoconcepto",151,$condicion,"",0))){
                    $this->generarnombreusuario(quitartilde($this->datosorden["nombresestudiantegeneral"]),quitartilde($this->datosorden["apellidosestudiantegeneral"]));
                    $this->agregalogcreacionusuario();
                }
            }
        }
        echo $this->mensaje;
        $this->objetoldap->Cerrar();
    }
    
    function insertarnuevousuario($usuario){
        $tabla="usuario";
	//Fila de Ingreso de novedad 
	$fila["usuario"]=$usuario;
	$fila["numerodocumento"]=$this->datosorden["numerodocumento"];
	$fila["tipodocumento"]=$this->datosorden["tipodocumento"];
	$fila["apellidos"]=$this->datosorden["apellidosestudiantegeneral"];
	$fila["nombres"]=$this->datosorden["nombresestudiantegeneral"];
	$fila["codigousuario"]=$this->datosorden["numerodocumento"];
	$fila["semestre"]=$this->datosorden["semestre"];
        
        $fila["codigorol"]=1;
	$fila["fechainiciousuario"]=date("Y-m-d H:i:s");
	$fila["fechavencimientousuario"]="2099-12-31";
	$fila["fecharegistrousuario"]=date("Y-m-d H:i:s");
	$fila["codigotipousuario"]=600;
	$fila["idusuariopadre"]=0;
	$fila["ipaccesousuario"]="";
	$fila["codigoestadousuario"]=400;
	$condicionactualiza="";
	/*/
        $condicionactualiza="usuario=".$fila['usuario'].
                " and codigocarrera='".$fila['codigocarrera'].
                "' and codigoestado='".$fila['codigoestado'].
        /**/
	$datoscarreraldap=$this->objetobase->recuperar_datos_tabla("carreraldap","codigocarrera",$this->datosorden["codigocarrera"]," and codigoestado=100");
	//$informacionadicional["givenName"]=$fila["nombres"];
	//$informacionadicional["sn"]=$fila["apellidos"];
	//$informacionadicional["cn"]=$fila["codigousuario"];
	if(trim($datoscarreraldap["direccioncarreraldap"])!=''){
            $dnpadre="ou=Estudiantes,".$datoscarreraldap["direccioncarreraldap"];
        }else{
            $dnpadre="ou=usuarios,ou=Estudiantes,".RAIZDIRECTORIO;
        }
	
	//$dnpadre="ou=Estudiantes,".$datoscarreraldap["direccioncarreraldap"];
	$fila2=$fila;
	$fila2["mail"]=$this->datosorden["emailestudiantegeneral"];
	$this->objetoldap->EntradaEstudiante($usuario,$this->clave,$fila2,$dnpadre);
	$this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
    }
    
    function agregalogcreacionusuario(){
        $tabla="logcreacionusuario";
	$fila["idusuario"]=$this->idusuario;
	$fila["tmpclavelogcreacionusuario"]=$this->clave;
	$fila["fechalogcreacionusuario"]=$this->fechaintento;
	$fila["observacionlogcreacionusuario"]=$this->mensaje;
	$fila["numerodocumentocreacionusuario"]=$this->datosorden["numerodocumento"];
	$fila["numerodocumentocreacionusuario"]=$this->datosorden["numerodocumento"];
	$fila["codigoestado"]=100;
	$condicionactualiza="";
	$this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
    }	
    /*/
    function agregarloghistorial(){
	$tabla="loghistorialcreacionusuario";
	//$fila["idusuario"]=$datos_usuario["idusuario"];
	$fila["fechaloghistorialcreacionusuario"]=$this->fechaintento;
	$fila["idestudiantegeneral"]=$this->idestudiantegeneral;
	$condicionactualiza="";
	$this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
    }
    /**/
    /*/
    function encuentraconceptomatricula(){
        $tablas="ordenpago op,detalleordenpago dp";
        $condicion=" and op.numeroordenpago=dp.numeroordenpago 
            and dp.codigoconcepto=151";
        
        if($resultado_concepto= $this->objetobase->recuperar_datos_tabla($tablas,"op.numeroordenpago",$this->numeroorden,$condicion,"",0)){
            return true;
        }else{
            return false;	
        }
    }
    /**/
    
    function encuentraestudiante(){
        $tablas="estudiantegeneral eg";
        $datos_estudiantegeneral= $this->objetobase->recuperar_datos_tabla($tablas,"numerodocumento",$this->datosorden["numerodocumento"],$condicion,"",0);
        $this->idestudiantegeneral=$datos_estudiantegeneral["idestudiantegeneral"];
        $tablas="estudiantedocumento ed";
        $condicion="";
        $resultado_documento= $this->objetobase->recuperar_resultado_tabla($tablas,"ed.idestudiantegeneral",$datos_estudiantegeneral["idestudiantegeneral"],$condicion,"",0);
        while ($row = $resultado_documento->fetchRow()){
            $tablas="usuario u";
            $condicion=" and codigotipousuario ='600' ";
            
            if($datos_documento= $this->objetobase->recuperar_datos_tabla($tablas,"u.numerodocumento",$row["numerodocumento"],$condicion,"",0)){
                return true;
            }
        }
        
        return false;
    }
    
    function crearcorreo($nuevousuario,$clave){
        $tablas="usuario u";
        $condicion="";
        
        @$datos_ldapusuario=$this->objetoldap->BusquedaUsuarios("uid=".$nuevousuario);
        /*/
        echo "<pre>";
        print_r($datos_ldapusuario);
        echo "</pre>";
        /**/
        
        if($datos_documento=$this->objetobase->recuperar_datos_tabla($tablas,"u.usuario",$nuevousuario,$condicion,"",0)||(@$datos_ldapusuario["count"]>0)){
            $this->mensaje .= "NOMBRE DE USUARIO ENCONTRADO".$nuevousuario."<br>";
            $this->idusuario=2;
            $this->clave="";
            return false;
        }else{
            /*/
            $mensaje="<b>BIENVENIDO A LA UNIVERSIDAD EL BOSQUE</b><BR><BR>".
                    "Adjunto al presente usuario y clave para el ingreso al correo institucional y como usuario de servicios acadï¿½icos.\n\n
                        Puede ingresar a usar su cuenta de correo 2 dias despues a la fecha que reciba este correo<br><br>".
                    "<b>usuario:\t".$nuevousuario."</b><br><b>clave:\t".$clave."</b>";
            //mail($this->datosorden["emailestudiantegeneral"],"Nueva cuenta de correo UNBOSQUE",$mensaje);
            $array_datos_correspondencia['correoorigencorrespondencia']="";
            $array_datos_correspondencia['nombreorigencorrespondencia']="UNBOSQUE UNIVERSIDAD EL BOSQUE";
            $array_datos_correspondencia['asuntocorrespondencia']="USUARIO CUENTA CORREO INSTITUCIONAL";
            $array_datos_correspondencia['encabezamientocorrespondencia']=$mensaje;
            
            $this->ConstruirCorreo($array_datos_correspondencia,$this->datosorden["emailestudiantegeneral"],$this->datosorden["apellidosestudiantegeneral"]." ".$this->datosorden["nombresestudiantegeneral"],$this->datosorden["nombretrato"]." ".$this->datosorden["apellidosestudiantegeneral"]." ".$this->datosorden["nombresestudiantegeneral"]);
            /**/
            //mail("javeeto@gmail.com","Nueva cuenta de correo UNBOSQUE",$mensaje);
            
            $this->nuevousuario=trim($nuevousuario);
            $this->clave=$clave;
            $this->insertarnuevousuario(trim($nuevousuario));
            
            $datos_usuario= $this->objetobase->recuperar_datos_tabla("usuario","usuario",$nuevousuario,"","",0);
            $this->idusuario=$datos_usuario["idusuario"];
            //echo $nuevousuario." , ".$clave;
            $this->mensaje .= "CREADO EXITOSAMENTE ".$this->datosorden["emailestudiantegeneral"]." , ".$nuevousuario." \n Clave:".$this->clave."";
        }
        return true;
    }
    
    function nombredefecto($nombre1,$nombre2,$apellido1,$apellido2,$semilla){
        $largonombre=strlen($nombre1.$nombre2.$apellido1.$apellido2);
        $largonombre1=strlen($nombre1);
        $largonombre2=strlen($nombre2);
        $largoapellido2=strlen($apellido2);
        $campo1="";$campo2="";$campo3="";
        
        for($i=0;$i<($semilla);$i++){
            $campo1.=$nombre1[$i];
        }
        
        for($i=0;$i<($semilla-$largonombre1);$i++){
            $campo2.=$nombre2[$i];
        }
        
        for($i=0;$i<($semilla-($largonombre1+$largonombre2));$i++){
            $campo4.=$apellido2[$i];
        }
        
        $largogenerado=strlen($campo1.$campo2.$apellido1.$campo4);
        
        if($largonombre<=$largogenerado){
            return false;
        }else{
            return $campo1.$campo2.$apellido1.$campo4;
        }
    }
    
    function generarnombreusuario($nombreestudiante,$apellidosestudiante){
        if(!$this->encuentraestudiante()){
            $nombreestudiante=quitartilde($nombreestudiante);
            $apellidosestudiante=quitartilde($apellidosestudiante);
            $apellidosestudiante=str_replace(" DEL "," ",$apellidosestudiante);
            $cuentapalabrasapellidos=cuentapalabras(trim($apellidosestudiante));
            
            echo $apellido1=trim(sacarpalabras(trim($apellidosestudiante),0,$cuentapalabrasapellidos-2));
            echo $apellido2=trim(sacarpalabras(trim($apellidosestudiante),$cuentapalabrasapellidos-1,$cuentapalabrasapellidos));
            $cuentapalabrasapellido1=cuentapalabras(trim($apellido1));
            
            if($cuentapalabrasapellido1>1){
                $apellido1=sacarpalabras(trim($apellido1),$cuentapalabrasapellido1-1,$cuentapalabrasapellido1);
            }
            $nombre1=trim(sacarpalabras($nombreestudiante,0,0));
            $nombre2=trim(sacarpalabras($nombreestudiante,1));
            $clave=generar_pass(8);
            $cuentacorreocreada=false;
            $nombre1=str_replace(" ","",$nombre1);
            $nombre2=str_replace(" ","",$nombre2);
            $apellido1=str_replace(" ","",$apellido1);
            $apellido2=str_replace(" ","",$apellido2);
            $i=0;
            
            while($cuentacorreocreada==false){
                //for($i=0;$i<30;$i++){
                $i++;
                switch($i){
                    case 1:
                        $nuevousuario=strtolower($nombre1[0].$apellido1);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 2:
                        $nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 3:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$apellido1);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 4:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$apellido1.$apellido2[0]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 5:
                        $nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0].$apellido2[1]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 6:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 7:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1.$apellido2[0]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 8:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1.$apellido2[0].$apellido2[1]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 9:
                        $nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0].$apellido2[1].$apellido2[2]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 10:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$nombre2[2].$apellido1);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    case 11:
                        $nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$nombre2[2].$apellido1.$apellido2[0]);
                        $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        break;
                    default:
                        if($nuevousuario= strtolower($this->nombredefecto($nombre1,$nombre2,$apellido1,$apellido2,($i-10)))){
                            $cuentacorreocreada=$this->crearcorreo($nuevousuario,$clave);
                        }else{
                            $this->mensaje .= "-Todas Las Combinaciones Encontradas-Nombre de Usuario No Se Genero-";
                            $cuentacorreocreada=true;
                            $this->idusuario=2;
                            $this->clave="";
                        }
                        break;
                }
                //echo "$i)$nuevousuario<br>";
            }
        }else{
            $this->idusuario=2;
            $this->clave="";
            $this->mensaje .= "ESTUDIANTE YA EXISTE CON USUARIO EN SALA ".$this->datosorden['numerodocumento']."\n";
        }
    }
    
    function encuentra_estudiante_orden($numeroorden){
        $tablas="ordenpago o,estudiante e,estudiantegeneral eg,carrera c,detalleordenpago dp";
        $condicion=" and o.codigoestudiante=e.codigoestudiante
            and e.idestudiantegeneral=eg.idestudiantegeneral
            and e.codigocarrera=c.codigocarrera 
            /*and c.codigomodalidadacademica <> 400*/
            and o.numeroordenpago=dp.numeroordenpago 
            and dp.codigoconcepto=151";
        
        if($this->datosorden=$this->objetobase->recuperar_datos_tabla($tablas,"o.numeroordenpago",$numeroorden,$condicion,", o.codigoperiodo codigoperiodoorden,e.codigoperiodo codigoperiodoestudiante",0)){
            return true;
        }else{
            return false;
	}
        //return $datos_orden;
    }
}
//$numeroorden="1338881";
//$salaobjecttmp->debug=true;
//$objetoclaveusuario=new GeneraClaveUsuario($numeroorden,$salaobjecttmp);
//$objetoclaveusuario->objetobase->conexion->debug=true;
//$numeroorden="1141214";
//$objetoclaveusuario=new GeneraClaveUsuario($numeroorden,$salaobjecttmp);
/*
$numeroorden="1113822";
$objetoclaveusuario=new GeneraClaveUsuario($numeroorden,$salaobjecttmp);

$numeroorden="1113824";
$objetoclaveusuario=new GeneraClaveUsuario($numeroorden,$salaobjecttmp);*/

/*$datosestudiante=encuentra_estudiante_orden($numeroorden,$salaobjecttmp);
echo "<pre>";
print_r($datosestudiante);
echo "</pre>";
if($datosestudiante["codigoperiodoorden"]==$datosestudiante["codigoperiodoestudiante"])
generarnombreusuario(quitartilde($datosestudiante["nombresestudiantegeneral"]),quitartilde($datosestudiante["apellidosestudiantegeneral"]),$datosestudiante["emailestudiantegeneral"],$datosestudiante["numerodocumento"],$salaobjecttmp);
print_r($objetoimap); */
?>
