<?
 function armarScriptInstituciones($tablaInt , $tablaValoresInt , $tablaLongInt){
		
		$Instruccion="SELECT Codigo_Pais,Nombre,Codigo FROM Instituciones ORDER BY Codigo_Pais,Nombre";
		$result = mysql_query($Instruccion);   
		$cod_pais_anterior = "";
		$Indice= "";
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
			   
			    If ($cod_pais_anterior != $row[0])
           		{	//Inicializo el vector de dependencia de la institucion nueva
                      $Indice[$row[0]]=0;
					  echo $tablaInt."[".$row[0]."]=new Array;\n";
            	      echo $tablaValoresInt."[".$row[0]."]=new Array;\n";
					  $cod_pais_anterior = $row[0];
				}
				$pos = $Indice[$row[0]];

				
			   echo $tablaInt."[".$row[0]."][".$pos."]='".$row[1]."';\n";
               echo $tablaValoresInt."[".$row[0]."][".$pos."]=".$row[2].";\n";
          
                $Indice[$row[0]]+=1;
			
		   }
		    echo "//Reflejo las longitudes de los vectores\n";
            echo "\n";

            while (list($key1,$valor1)=each($Indice))
            {
          		   echo $tablaLongInt."[".$key1."]=".$valor1.";\n";
            }
		
			  
		 }
		
		mysql_free_result($result);
	}
	function armarScriptDependencia($tablaDependencias , $tablaValoresDep , $tablaLongDep){
		
		$Instruccion="SELECT Codigo_Institucion,Nombre,Id FROM Dependencias ORDER BY Codigo_Institucion,Nombre";
		$result = mysql_query($Instruccion);   
		$cod_institucion_anterior = "";
		$Indice= "";
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
			   
			    If ($cod_institucion_anterior != $row[0])
           		{	//Inicializo el vector de dependencia de la institucion nueva
                      $Indice[$row[0]]=0;
					  echo $tablaDependencias."[".$row[0]."]=new Array;\n";
            	      echo $tablaValoresDep."[".$row[0]."]=new Array;\n";
					  $cod_institucion_anterior = $row[0];
				}
				$pos = $Indice[$row[0]];

				
			   echo $tablaDependencias."[".$row[0]."][".$pos."]='".$row[1]."';\n";
               echo $tablaValoresDep."[".$row[0]."][".$pos."]=".$row[2].";\n";
          
                $Indice[$row[0]]+=1;
			
		   }
		    echo "//Reflejo las longitudes de los vectores\n";
            echo "\n";

            while (list($key1,$valor1)=each($Indice))
            {
          		   echo $tablaLongDep."[".$key1."]=".$valor1.";\n";
            }
		
			 
		 }
		 mysql_free_result($result);

	}



	function armarScriptUnidades($tabla_Unidades , $tabla_val_Uni , $tabla_Long_Uni)
	{
		$Instruccion="SELECT Codigo_Dependencia,Nombre,Id FROM Unidades ORDER BY Codigo_Dependencia,Nombre";
		$result = mysql_query($Instruccion);   
		$cod_dependencia_anterior = "";
		$Indice= "";
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
			   
			    If ($cod_dependencia_anterior != $row[0])
           		{	
                      $Indice[$row[0]]=0;
					  echo $tabla_Unidades."[".$row[0]."]=new Array;\n";
            	      echo $tabla_val_Uni."[".$row[0]."]=new Array;\n";
					  $cod_dependencia_anterior = $row[0];
				}
			   $pos = $Indice[$row[0]];				
			   echo $tabla_Unidades."[".$row[0]."][".$pos."]='".$row[1]."';\n";
               echo $tabla_val_Uni."[".$row[0]."][".$pos."]=".$row[2].";\n";          
               $Indice[$row[0]]+=1;
			
		   }

		    if ($tabla_Long_Uni != ""){ 
			    echo "//Reflejo las longitudes de los vectores\n";
		        echo "\n";
			    while (list($key1,$valor1)=each($Indice)){
          			echo $tabla_Long_Uni."[".$key1."]=".$valor1.";\n";
				   }
			}
		
			 
		 }
		  mysql_free_result($result);
  }


  	function armarScriptLocalidades($tabla_Localidad , $tabla_val_Loc , $tabla_Long_Loc)
	{
		$Instruccion="SELECT Codigo_Pais,Nombre,Id as Codigo FROM Localidades ORDER BY Codigo_Pais,Nombre";
		$result = mysql_query($Instruccion);   
		$cod_pais_anterior = "";
		$Indice= "";
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
			   
			    If ($cod_pais_anterior != $row[0])
           		{	
                      $Indice[$row[0]]=0;
					  echo $tabla_Localidad."[".$row[0]."]=new Array;\n";
            	      echo $tabla_val_Loc."[".$row[0]."]=new Array;\n";
					  $cod_pais_anterior = $row[0];
				}
			   $pos = $Indice[$row[0]];				
			   echo $tabla_Localidad."[".$row[0]."][".$pos."]='".$row[1]."';\n";
               echo $tabla_val_Loc."[".$row[0]."][".$pos."]=".$row[2].";\n";          
               $Indice[$row[0]]+=1;
			
		   }
		    echo "//Reflejo las longitudes de los vectores\n";
            echo "\n";

            while (list($key1,$valor1)=each($Indice))
            {
          		   echo $tabla_Long_Loc."[".$key1."]=".$valor1.";\n";
            }
		
			 
		 }
		  mysql_free_result($result);
  }

	function armarScriptPaises($tabla_Pais , $tabla_val_Pais )
	{
		$Instruccion = "SELECT Id,Nombre FROM Paises ORDER BY Nombre";
		$result = mysql_query($Instruccion);   		
		$contpaises=0;
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
			   
			   	
			   
			   echo $tabla_Pais."[".$contpaises."]='".$row[1]."';\n";
               echo $tabla_val_Pais."[".$contpaises."]=".$row[0].";\n";          
               $contpaises ++;
			
		   }


		   
           echo "contpaises=".$contpaises.";";		
			 
		 }
		  echo "contpaises=".$contpaises.";";	
		  mysql_free_result($result);
  }
 
?>