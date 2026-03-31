<?php
class DatosOrdenPagoReporte{
    function ValorPagado($orden,$numerodocumento,$codigoestudiante,$ruta='../'){
       include_once($ruta."templates/template.php");
       $db = getBD();
        $Existe = $this->pagoEnlinea($db,$orden,$numerodocumento);
        
        if($Existe['val']==false){
            $Existe = $this->ValorporFecha($db,$orden,$codigoestudiante);
        }
        
        if($Existe['val']==true){
            return $Existe;
        }
    }//function ValorPagado
    function pagoEnlinea($db,$orden,$numerodocumento){
          $SQL='SELECT
                	o.numeroordenpago,
                	o.fechapagosapordenpago,
                	DATE(l.BankProcessDate) AS Fecha_Banco,
                	DATE(l.SoliciteDate) AS Fecha_Cliente,
                	l.TransValue
                FROM
                	LogPagos l
                INNER JOIN ordenpago o ON o.numeroordenpago = l.Reference1
                WHERE
                	l.Reference1 = "'.$orden.'"
                AND l.Reference2 = "'.$numerodocumento.'"
                AND l.StaCode = "OK"';
                
          if($Datos=&$db->Execute($SQL)===false){
            echo 'Error en el sistema...';die;
          }      
          
          if(!$Datos->EOF){
            $Other = $this->porcentaje($db,$orden,$Datos->fields['Fecha_Cliente']);
            $Data['val'] = true;
            $Data['fechapagorealizado']   = $Datos->fields['Fecha_Cliente'];
            $Data['PagoRealizado']        = $Datos->fields['TransValue'];  
            $Data['fechapagoOportuno']    = $Other[0]['fechaordenpago'];
            $Data['porcentaje']           = $Other[0]['porcentajefechaordenpago'];   
            $Data['valorfechaordenpago']  = $Other[0]['valorfechaordenpago'];
            $Data['TipoPagoRealizado']        = 'Pago En Linea';                 
          }else{
            $Data['val'] = false;
          } 
          
          return $Data;
    }//function pagoEnlinea
    function ValorporFecha($db,$orden,$codigoestudiante){
        $SQL='SELECT
                    fechapagosapordenpago
                FROM
                    ordenpago
                WHERE
                    numeroordenpago="'.$orden.'"';
                    
          if($Datos=&$db->Execute($SQL)===false){
            echo 'Error en el sistema...';die;
          } 
          
           if(!$Datos->EOF){
            $Other = $this->porcentaje($db,$orden,$Datos->fields['fechapagosapordenpago']);
            $Data['val'] = true;
            $Data['fechapagorealizado']   = $Datos->fields['fechapagosapordenpago'];
            $Data['fechapagoOportuno']    = $Other[0]['fechaordenpago'];
            $Data['porcentaje']           = $Other[0]['porcentajefechaordenpago'];
            $Data['PagoRealizado']        = $Other[0]['valorfechaordenpago'];   
            $Data['valorfechaordenpago']  = $Other[0]['valorfechaordenpago'];      
            $Data['TipoPagoRealizado']        = 'Ventanilla o Bancos';        
          }else{
            $Data['val'] = false;
          } 
          
          return $Data;           
    }//function ValorporFecha
    function ValorMatriculaCohorte($carrera,$codigoperiodo,$semestre,$ruta='../'){
       include_once($ruta."templates/template.php");
       $db = getBD();
          $SQL='SELECT
                	dc.valordetallecohorte
                FROM
                	cohorte c
                INNER JOIN detallecohorte dc ON dc.idcohorte = c.idcohorte
                WHERE
                	c.codigocarrera = "'.$carrera.'"
                AND c.codigoperiodo = "'.$codigoperiodo.'"
                AND dc.semestredetallecohorte = "'.$semestre.'"';
                
          if($Datos=&$db->Execute($SQL)===false){
            echo 'Error en el sistema...';die;
          } 
          
          return $Datos->fields['valordetallecohorte'];
    }//function ValorMatriculaCohorte
    function CreditosMatriculados($orden,$ruta='../'){ 
       
       include_once($ruta."templates/template.php");
       $db = getBD();
       
         $SQL='SELECT
                	SUM(m.numerocreditos) AS num
                FROM
                	detalleprematricula d
                INNER JOIN materia m ON m.codigomateria = d.codigomateria
                WHERE
                	d.numeroordenpago = "'.$orden.'"
                AND d.codigoestadodetalleprematricula = 30';
                
          if($Datos=&$db->Execute($SQL)===false){
            echo 'Error en el sistema...';die;
          } 
          
          return $Datos->fields['num'];      
    }//function CreditosMatriculados    
    function porcentaje($db,$orden,$fecha,$ruta='../'){
       include_once($ruta."templates/template.php");
       $db = getBD();
          $SQL='SELECT
                	fechaordenpago,
                	porcentajefechaordenpago,
                	valorfechaordenpago
                FROM
                	fechaordenpago
                WHERE
                	numeroordenpago = "'.$orden.'"
                AND fechaordenpago >= "'.$fecha.'"
                ORDER BY
                	fechaordenpago ASC
                LIMIT 1';
                
          if($Datos=&$db->Execute($SQL)===false){
            echo 'Error en el sistema...';die;
          }  
          
          if(!$Datos->EOF){
            $DataNew = $Datos->GetArray();
          }else{
            $SQL='SELECT
                	fechaordenpago,
                	porcentajefechaordenpago,
                	valorfechaordenpago
                FROM
                	fechaordenpago
                WHERE
                	numeroordenpago = "'.$orden.'"
                
                LIMIT 1';
                
              if($DataNew=&$db->GetAll($SQL)===false){
                echo 'Error en el sistema...';die;
              }  
          }  
          
        return $DataNew;        
    }//function porcentaje    
    function MaxCreditosEstudiante($codigoestudiante,$semestre,$ruta='../'){
       include_once($ruta."templates/template.php");
       $db = getBD();
      $SQL='SELECT
            	SUM(
            		dp.numerocreditosdetalleplanestudio
            	) AS numMax
            FROM
            	planestudioestudiante p
            INNER JOIN detalleplanestudio dp ON dp.idplanestudio = p.idplanestudio
            WHERE
            	p.codigoestudiante = "'.$codigoestudiante.'"
            AND dp.semestredetalleplanestudio = "'.$semestre.'"';
            
            if($Data=&$db->Execute($SQL)===false){
                echo 'Error en el sistema...';die;
            }  
            
            return $Data->fields['numMax'];
    }//function MaxCreditosEstudiante
}//class DatosOrdenPagoReporte

?>