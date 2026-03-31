<?php 
        session_start();
        include_once('../../../utilidades/ValidarSesion.php'); 
        $ValidarSesion = new ValidarSesion();
        $ValidarSesion->Validar($_SESSION);
    
        require_once("../../../Connections/sala2.php");

       mysql_select_db($database_sala,$sala);
	   $query_notas = "SELECT * FROM notahistorico n,estudiante e
	   WHERE n.codigoestudiante = e.codigoestudiante
	   AND e.codigocarrera = '98'
	   AND notadefinitiva > 5
	   AND codigoestadonotahistorico LIKE '1%'";
	   $notas= mysql_query($query_notas, $sala) or die(mysql_error());
	   $row_notas= mysql_fetch_assoc($notas);
	   $totalRows_notas= mysql_num_rows($notas); 
	   
	   do{
	       $nota = 0; 
		   $nota =  $row_notas['notadefinitiva'] / 2;
	       $nota = number_format($nota,2);
		   $nota=round($nota * 10)/10;	
		   
		    $base8="UPDATE notahistorico
			SET notadefinitiva = '$nota'			
			WHERE idnotahistorico = '".$row_notas['idnotahistorico']."'			
			";
            //la siguiente linea esta mostrando informacion sobre el update, se debe validar este archivo. ATT: IQ
			echo $base8,"<br>"; 		
		   $sol8=mysql_db_query($database_sala,$base8) or die("$base8".mysql_error());	   
	   
	   }while($row_notas= mysql_fetch_assoc($notas));   
      echo $totalRows_notas;
?>