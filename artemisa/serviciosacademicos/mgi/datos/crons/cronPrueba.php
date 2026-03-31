<?php 
// a la 1 am de prueba /serviciosacademicos/mgi/datos/crons/cronPrueba.php
// this starts the session 
 /*session_start(); 
$_SESSION['MM_Username'] = 'admintecnologia';

    include("../templates/template.php");
    
    if(function_exists('curl_init')) // Comprobamos si hay soporte para cURL
{
	/*$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,
		"http://www.google.es/search?hl=es&q=curl");
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);*/
       /* $url = "http://blip.fm/login/authenticate"; 
        $url= "http://talentohumano.unbosque.edu.co/psp/hcprd/?cmd=login&languageCd=ESP";
        //$postData = array("username" => "blpgirl", "password" => "nose75");  
        $postData = "username=blpgirl&password=nose75"; 
        $postData = "userid=martinezsergio&pwd=Ubosque2012"; 
        /*Convierte el array en el formato adecuado para cURL*/  
        //$elements = array();  
        //foreach ($postData as $name=>$value) {  
        //$elements[] = "{$name}=".urlencode($value);  
        //}  
        /*$ch = curl_init();  
        
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE,1);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POST,true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $resultado = curl_exec ($ch);
        
        $url = "http://talentohumano.unbosque.edu.co/psp/hcprd/EMPLOYEE/HRMS/h/?tab=DEFAULT";
        $url = "http://talentohumano.unbosque.edu.co/psp/hcprd/EMPLOYEE/HRMS/c/QUERY_MANAGER.QUERY_MANAGER.GBL?FolderPath=PORTAL_ROOT_OBJECT.PT_REPORTING_TOOLS.PT_QUERY.PT_QUERY_MANAGER_GBL&IsFolder=false&IgnoreParamTempl=FolderPath%2cIsFolder";
        //$url = "http://talentohumano.unbosque.edu.co/psc/hcprd_4/EMPLOYEE/HRMS/q/?ICAction=ICQryNameURL=PUBLIC.UB_SNIESADMON";
	curl_setopt($ch, CURLOPT_URL, $url);
        $resultado = curl_exec ($ch);
 
	print_r($resultado);*/
/*}
else
	echo "No hay soporte para cURL";
    
    //var_dump(opendir('file://///172.16.3.230/PS_repositorio'));
    //var_dump(fopen('\\\\172.16.3.230', 'r'));
    echo "<pre>";print_r(system('net use Z: "\\\\BUSRVFILE\\PS_repositorio" PASSWORD /user:unbosque/martinezsergio /persistent:no'));
    echo "<pre>";print_r(system('net domain'));
    
    var_dump(opendir('Z:\\'));
    echo "<br/><br/><pre>";print_r(system("smb://172.16.3.230"));
    echo "<br/><br/><pre>";print_r(system("net conf"));
    
    echo "<br/><br/><pre>";print_r(system("smbclient -L windows_box"));
    system('mount -t cifs -o username=unbosque/martinezsergio \\\\BUSRVFILE\\PS_repositorio /mnt/myshare2', $retval);
    echo "<br/><br/>";print_r($retval);
    // similarly ...
    var_dump(getcwd());
    //var_dump(fopen('C:\\Program Files', 'r'));
    //var_dump(opendir(getcwd()));
    //var_dump(popen("\\BUSRVFILE\PS_repositorio\Nomina.xls", "r"));
    //var_dump(opendir('Y:\''));
    //$handle = popen("\\BUSRVFILE\PS_repositorio\Nomina.xls", "r");
    //$leer = fread($handle, 10240);
    //echo strlen($leer);
    //pclose($handle);
    $var = "/mnt/myshare2";
    echo "<br/><br/>".$var."<br/><br/>";
    
    var_dump(fopen($var, 'r'));
    var_dump(scandir($var,0));
    $files = glob($var."*",GLOB_ONLYDIR);
    var_dump($files);
    /*$dh = opendir("\\\\BUSRVFILE\\PS_repositorio");
    while (false !== ($file = readdir($dh)))
    {
        echo "$file<br />";
    }*/
    //var_dump($handle);
    /*if ($handle) {
    echo "Directory handle: $handle\n";
    echo "Entries:\n";

    /* This is the correct way to loop over the directory. */
    /*while (false !== ($entry = readdir($handle))) {
        echo "$entry\n";
    }

    closedir($handle);
}*/
    
  /*  $databases = getBDMoodle();
    
    $dbSala = $databases[0];
    $dbMoodle = $databases[1];
    $dbMoodle2 = $databases[2];
    
    $query = "SELECT COUNT(a.id) FROM mdl_course a 
        inner join mdl_course_categories p ON p.id = a.category ORDER BY a.startdate DESC";
    $cursosAulasVirtuales = $dbMoodle->GetRow($query); 
    
    $cursosAulasVirtuales2 = $dbMoodle2->GetRow($query); 
    
    $querySala = "SELECT COUNT(idsiq_moodle_aulaVirtual) from siq_moodle_aulaVirtual WHERE codigoestado=100";
    $cursosSala = $dbSala->GetRow($querySala); 
    
    $querySala = "SELECT idsiq_moodle_aulaVirtual, idmoodle, asignatura, codigoestado FROM siq_moodle_aulaVirtual";
    $cursosSalaDetalle = $dbSala->GetAll($querySala); 
    
    $mensaje = "Todo bien, el cron funciona ".date('l jS \of F Y h:i:s A')." en moodle: ".$cursosAulasVirtuales[0]." - ".$cursosAulasVirtuales2[0];
    $mensaje = $mensaje." y en sala: ".$cursosSala[0]." <br/><br/> \r\n ".var_export($cursosSalaDetalle, true);
    /*for ($i = 0; $i < count($cursosSalaDetalle); $i++) {
        $mensaje = $mensaje.$cursosSalaDetalle[$i]["idsiq_moodle_aulaVirtual"]." - ".
                $cursosSalaDetalle[$i]["idmoodle"]." - ".
                $cursosSalaDetalle[$i]["asignatura"]." - ".
                $cursosSalaDetalle[$i]["codigoestado"]." - "." <br/><br/> \r\n ";
    }*/
    
   /* $asunto = "cron de prueba ".date('l jS \of F Y h:i:s A');
    $destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
    //$headers = "From: no-responder@unbosque.edu.co \r\n";
        
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        

        // Cabeceras adicionales
        //$cabeceras .= 'To: ' .$to. "\r\n";
        $cabeceras .= 'From: Equipo MGI <equipomgi@unbosque.edu.co>' . "\r\n";
        //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        
          // Enviamos el mensaje
          if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
                $aviso = "Su mensaje fue enviado.";
                $succed = true;
          } else {
                $aviso = "Error de envío.";
                $succed = false;
          }*/
?>
