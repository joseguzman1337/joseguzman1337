<?php
    // this starts the session 
    session_start();
    //ini_set ("memory_limit","60M");
    require_once "../../dompdf/dompdf_config.inc.php";
    
    $_SESSION['MM_Username'] = "admintecnologia";
    
    $ind=$_REQUEST['indicador_id'];
    $dis=$_REQUEST['Descriminacion'];
     
   // echo $ind.'<br>';
   // echo $dis.'-->>ok';
   //echo   'http://172.16.3.227/serviciosacademicos/mgi/autoevaluacion/interfaz/prueba_resul.php?indicador_id='.$ind.'&Descriminacion='.$dis.' ';

    $content = "";
    $path = "";

    doPDF($ind,$dis);
    function doPDF($ind,$dis,$path='',$content='',$body=false,$mode=false,$paper_1='letter',$paper_2='portrait'){    
    if( $body!=true and $body!=false ) $body=false;
    if( $mode!=true and $mode!=false ) $mode=false;
    // echo $ind.'--->ok<br>';
    // echo $dis.'-->>ok';
    
    //$content = file_get_contents('http://172.16.3.227/serviciosacademicos/mgi/autoevaluacion/interfaz/prueba_resul.php?indicador_id='.$ind.'&Descriminacion='.$dis.' ');
    // $content = file_get_contents('http://172.16.3.227/serviciosacademicos/mgi/autoevaluacion/interfaz/prueba_resul.php?indicador_id='.$ind.'&Descriminacion=1');
    $content = file_get_contents('https://artemisa.unbosque.edu.co/serviciosacademicos/mgi/autoevaluacion/interfaz/prueba_resul.php?indicador_id='.$ind.'&Descriminacion='.$dis.'');
    //var_dump($content);

    
    if( $content!='' )
    {        
        //Añadimos la extensión del archivo. Si está vacío el nombre lo creamos
        $path!='' ? $path .='.pdf' : $path = crearNombre(10,$ind,$dis);  

        //Las opciones del papel del PDF. Si no existen se asignan las siguientes:[*]
        if( $paper_1=='' ) $paper_1='letter';
        if( $paper_2=='' ) $paper_2='portrait';
            
        $dompdf =  new DOMPDF();
        $dompdf -> set_paper($paper_1,$paper_2);
        $dompdf -> load_html(utf8_decode($content));
        //ini_set("memory_limit","32M"); //opcional 
        $dompdf -> render();
        
        //Creamos el pdf
        if($mode==false)
            $dompdf->stream($path);
            
        //Lo guardamos en un directorio y lo mostramos
        if($mode==true)
        {               
            var_dump('./reportesPDF/'.$path);
            $result = file_put_contents('./reportesPDF/'.$path, $dompdf->output());
            var_dump($result);
        //header('Location: ./reportesPDF/'.$path);
        }
    }
}

function crearNombre($length,$ind,$dis)
{
    if( ! isset($length) or ! is_numeric($length) ) $length=6;
    
    $str  = "0123456789abcdefghijklmnopqrstuvwxyz";
    $path = '';
    
    for($i=1 ; $i<$length ; $i++)
      $path .= $str{rand(0,strlen($str)-1)};

  //  return "reporte".$path.'_'.date("d-m-Y_H-i-s").'.pdf';    
      return "reporte".$ind.'_'.date("d-m-Y_H-i-s").'.pdf';    
} 
    
?>
