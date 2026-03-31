<?php

//var_dump (is_file('templates/template.php'));die;

include_once("templates/template.php");

require_once('../Connections/sala2.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

//echo '<pre>';print_r($db);die;

  /*$SQL="SELECT x.num, x.numerodocumento

        FROM
        
        (SELECT COUNT(u.usuario) as num, u.numerodocumento 
        
        FROM usuario u INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
        			   INNER JOIN estudiante e ON eg.idestudiantegeneral=e.idestudiantegeneral
        			   INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante	AND p.codigoperiodo='20141'
        
        
        WHERE u.codigoestadousuario=100 AND u.codigorol=1 AND u.codigotipousuario=600 AND u.fechainiciousuario>'2012-01-01 00:00:01' AND e.codigosituacioncarreraestudiante IN(300,301) 
        
        GROUP BY u.numerodocumento ORDER BY 1 DESC) x
        
        WHERE 
        
        x.num > 1
        
        GROUP BY x.numerodocumento ORDER BY x.num DESC";*/
        
  $SQL="SELECT COUNT(u.usuario) as num, u.numerodocumento 
        
        FROM usuario u INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
        			   INNER JOIN estudiante e ON eg.idestudiantegeneral=e.idestudiantegeneral
        			   INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante	
        
        
        WHERE u.codigoestadousuario=100 AND u.codigorol=1 AND u.codigotipousuario=600 AND u.fechainiciousuario>'2010-01-01 00:00:01' AND e.codigosituacioncarreraestudiante IN(300,200,301) 
        
        GROUP BY u.numerodocumento ORDER BY 1 DESC";     
        
        if($Consulta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Consulta...<br><br>'.$SQL;
            die;
        }//if
        
        $j=1;
        
        while(!$Consulta->EOF){
            /*********************************************/
            $NumeroDocumento = $Consulta->fields['numerodocumento'];
            
              $query_usuario = "SELECT u.usuario
              
                                FROM usuario u, estudiantedocumento ed
                                
                                WHERE ed.numerodocumento = '".$NumeroDocumento."'
                                
                                AND ed.numerodocumento = u.numerodocumento
                                AND u.codigotipousuario='600'
                                limit 1";
                                
                 if($usuario=&$db->Execute($query_usuario)===false){
                    echo 'Error en el SQL del Usuario...<br><br>'.$query_usuario;
                    die;
                 }//if   
                 
                 if(!$usuario->EOF){
                    /*********************************************/
                    $UserName = $usuario->fields['usuario'];
                    
                    echo '<br><br>'.$Modifica='UPDATE usuario 
                               SET codigoestadousuario=200 
                               WHERE  
                               numerodocumento="'.$NumeroDocumento.'" 
                               AND 
                               codigorol=1 
                               AND 
                               codigotipousuario=600 
                               AND 
                               usuario<>"'.$UserName.'"';
                               
                         if($UpdateUsuario=&$db->Execute($Modifica)===false){
                            echo 'Error en el SQL de Modificar User.....<br><br>'.$Modifica;
                            die;
                         }else{
                            echo '<br>'.$j.'  Usuario Modificado <strong>'.$UserName.'</strong> Numero de Documento '.$NumeroDocumento.'<br>'; 
                         }//if  
                         
                            
                    /*********************************************/
                 }//if            
            /*********************************************/
            $j++;
            $Consulta->MoveNext();
        }//while
echo '<br>Termino...';
?>