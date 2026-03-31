<?
// funciones relacionadas con los eventos de los pedidos 
// el control de los mismos, la correlación entre ellos
// tanto como el estado de los pedidos que generan

/* if (__fgenped_inc == 1)
		return;
	define ('__fgenped_inc', 1); */
include_once "var.inc.php";
include_once "parametros.inc.php";
include_once "fgentrad.php";
global $IdiomaSitio;
$Mens= Comienzo ("descrip",$IdiomaSitio);

function Saca_Ult_Char($texto)
{
  return substr($texto,0,strlen($texto)-1);
}


function Determinar_Estado($Evento)
{
  // Determina el estado en que quedará el pedido
  // de acuerdo al evento que le llega
  
  switch ($Evento)
  {
    case 2: // Evento de toma de pedido
      return 2;
      break;
    case 3: // Evento de solicitud realizada
      return 3;
      break;
    case 4: // Evento de pedido en espera de confirmacion por parte del usuario
      return 4;
      break;
    case 5:  // Evento de pedido confirmado por parte del usuario
      return 5;
      break;    
    case 6: // Evento de pedido recibido
      return 6; 
      break;
    case 7: // Evento de pedido entregado
      return 7;
      break;
    case 8: // Evento de pedido cancelado por el operador
      return 8;  
      break;
    case 9: // Evento de pedido cancelado por el usuario
      return 8;  
	  break;
    case 10: // Evento de observado, si bien pasa a estado 10, no lo registra
      return 10;
        break;
    case 11: // Evento de confirmar pedido por encontrarse en SeCyT - Modificacion realizada por Gonzalo	
      return 9; //en confirmacion por recurso web
      break;
    case 12: //Evento de autorizado para bajarse el pdf
      return 11; //pasa a estado PDF enviado
      break;
	  //10; //pasa a estado de Confirmado y solicitar PDF
      
   }   
}

function Devolver_Opciones ($Estado,$Idioma)
{
  // Devuelve un arreglo con todas las opciones correctas a partir de un 
  // estado
  
  switch ($Estado)
  {
    case 1: // Esta pendiente
      return array($Idioma["Evento1"]=>2,$Idioma["Evento9"]=>10);
    case 2: // Ya esta en busqueda, puede ser solicitado o confirmado
      return array($Idioma["Evento2"]=>3,$Idioma["Evento3"]=>4,$Idioma["Evento7"]=>8,$Idioma["Evento9"]=>10); //,$Idioma["Evento12"]=>12//,$Idioma["Evento11"]=>11
    case 3: // Ya fue solicitado, puede ser recibido, entregado, redirigido o vuelto a poner en búsqueda o confirmar
      return array($Idioma["Evento5"]=>6,$Idioma["Evento10"]=>3,$Idioma["Evento7"]=>8,$Idioma["Evento9"]=>10,$Idioma["Evento1"]=>2,$Idioma["Evento3"]=>4);//,$Idioma["Evento12"]=>12);//,$Idioma["Evento11"]=>11
    case 4: // Esta pendiente de confirmacion por parte del usuario, puede ser confirmado o cancelado
      return array($Idioma["Evento4"]=>5,$Idioma["Evento8"]=>9,$Idioma["Evento7"]=>8,$Idioma["Evento9"]=>10);//,$Idioma["Evento11"]=>9
    case 5: // Ya fue confirmado
      return array($Idioma["Evento2"]=>3,$Idioma["Evento7"]=>8,$Idioma["Evento9"]=>10,$Idioma["Evento3"]=>4,$Idioma["Evento1"]=>2);//,$Idioma["Evento11"]=>11
    case 6: // Fue recibido, puede solo ser entregado , cancelado por mala recepcion o obs.especiales o vuelto a poner en búsqueda. Se agregó, puede pasar a Confirmado y Solicitar PDF
      return array($Idioma["Evento6"]=>7,$Idioma["Evento7"]=>8,$Idioma["Evento9"]=>10,$Idioma["Evento1"]=>2);//,$Idioma["Evento12"]=>12);
    case 9: //Está en "Confirmación por recurso web". Puede ser Entregado (se le imprime y entrega directamente)  o  Confirmado y Solicitar PDF 
      return array ($Idioma["Evento6"]=>7);//,$Idioma["Evento12"]=>12);
	case 11: //está en "SolicitarPDF", puede ser cancelado, Obs. especiales
       return array($Idioma["Evento7"]=>8,$Idioma["Evento9"]=>10);
   }
}

function Devolver_Todos_Eventos ($Idioma)
{
  // Devuelve un arreglo con todas las opciones correctas a partir de un 
  // estado
  
      return array($Idioma["Evento1"]=>2,$Idioma["Evento2"]=>3,$Idioma["Evento3"]=>4,$Idioma["Evento4"]=>5,$Idioma["Evento5"]=>6,$Idioma["Evento6"]=>7,$Idioma["Evento7"]=>8,$Idioma["Evento8"]=>9,$Idioma["Evento9"]=>10,$Idioma["Evento10"]=>11,$Idioma["Evento11"]=>10);
}

function Devolver_Todos_Eventos_Mails ($Idioma)
{
  // Estos son las leyendas de eventos que se producen fuera de pedidos y que
  // necesitan enviar mail. Separon numericamente bien los códigos para garantizar
  // que no se mezclen
  
      return array($Idioma["Eventos_Mail_1"]=>100,$Idioma["Eventos_Mail_2"]=>101,$Idioma["Eventos_Mail_3"]=>102);
}

function Devolver_Estado ($Vc,$Estado,$Numero)
{ 
  if ($Numero==0)
  {
   $Columna = "Estado_".$Estado."_Pedidos_S";
  }
  else
  {
  	$Columna = "Estado_".$Estado."_Pedidos_P";
  }

 return $Vc[$Columna]; 

}

function Devolver_Tipo_Solicitud ($Vc,$Tipo,$Abreviado)
{
	
   
	if ($Tipo==1)
	{
		$Solicitud = $Vc["Operacion_1"];
	}
	else
	{
  		$Solicitud = $Vc["Operacion_2"];
	}
	
	if (!$Abreviado)
	{
	  return $Solicitud;
	}
	else
	{
	  return substr($Solicitud,0,4);	
	}  
}

function Devolver_Evento ($Evento,$VIdioma)
{
  $i=$Evento-1;	
  $Campo = "Evento".$i; 
  return $VIdioma[$Campo];
  
}   
   
function Devuelve_Inst()
{
   // Devuelve un string con las opciones que usan
   // Institucion y dependencia en el evento
   
   
     return "3,6";
}

function Devuelve_Evento_Tomado()
{
  return 2;
}

function Devuelve_Evento_Solicitado()
{
  return 3;
}

function Devuelve_Evento_paraConfirmar()
{
  return 4;
}

function Devuelve_Evento_confirma()
{
  // Devuelve el codigo de evento de la confirmacion
  // por parte del usuario
  return 5;
}


function Devuelve_Evento_cancela()
{
  // Devuelve el codigo de evento de la cancelacion
  // por parte del usuario
  return 9;
}

function Devuelve_Evento_entrega()
{
  // Devuelve el codigo de evento de la entrega del pedido
  // al usuario
  return 7;
}

function Devuelve_Evento_recepcion()
{
  // Devuelve el codigo de evento de la entrega del pedido
  // al usuario
  return 6;
}

function Devuelve_Evento_Observado()
{
  // Devuelve el codigo de evento de la entrega del pedido
  // al usuario
  return 10;
}


function Devuelve_Evento_paraConfirmarPorRecursoWeb()
{  //Devuelve eñ codigo del evento de enviar confirmacion por encontrarse en SeCyT
  return 11;
}
function Devuelve_Evento_PDFEnviado()
{
  // Devuelve el codigo de evento de habilitar al usuario para bajarse el pdf
  
  return 12;
}

function Devuelve_Evento_Download()
{
   return 13;
}

function Devolver_Estado_Inicial()
{
	return 1;
}

function Devolver_Estado_Tomado()
{
	return 2;
}

function Devolver_Estado_Pedido()
{
	return 3;
}


function Devolver_Estado_Recibido()
{
	return 6;
}

function Devolver_Estado_Entregado()
{
	return 7;
}

function Devolver_Estado_Cancelado()
{
	return 8;
}

function Devolver_Estado_SolicitarPDF()
{
	return 11;
}

function Devolver_Estado_Download()
{
   return 12;
}
function Devolver_Color ($argumento)
{
   if ($argumento==1) 
     { return "#CCCCCC";}
   else if ($argumento==2) 
     { return "#FFFFFF";}
   else if ($argumento==3) 
     { return "#A6CEDD";}
   else if ($argumento==4) 
     { return "#C8C7BB";}
   else if ($argumento==5) 
     { return "#F5EED3";}
 
}

function Devolver_Mes ($Mes,$Vector)
{

 return $Vector[$Mes."_Mes"];
  
}
function Devolver_Mes_abr ($Mes,$Vector)
{

 return substr($Vector[$Mes."_Mes"],0,3);
  
}
function Devolver_DiaSem ($Dia,$Vector)
{
 return $Vector[$Dia."_Dia"];
}

function Devolver_Tipo_Material ($Vect,$valor)
{
  if (isset($Vect["Tipo_Pedido_".$valor] ))
	  return $Vect["Tipo_Pedido_".$valor];
  else
	return "";
}

function armar_expresion_busqueda()
{
    
   $expresion = "SELECT Pedidos.Tipo_Pedido,Pedidos.Id,Clientes.Apellido,Clientes.Nombres,";   //0-1-2-3
   $expresion = $expresion."Pedidos.Tipo_Material,Pedidos.Titulo_Libro,Pedidos.Autor_Libro,";  //4-5-6
   $expresion = $expresion."Pedidos.Editor_Libro,Pedidos.Desea_Indice,Pedidos.Anio_Libro,";    //7-8-9   
   $expresion = $expresion."Pedidos.Numero_Patente,Paises.Nombre,Pedidos.Pais_Patente,";       //10-11-12 
   $expresion = $expresion."Pedidos.Anio_Patente,Titulos_Colecciones.Nombre,Pedidos.Titulo_Revista,"; //13-14-15
   $expresion = $expresion."Pedidos.Titulo_Articulo,Pedidos.Volumen_Revista,Pedidos.Numero_Revista,"; //16-17-18
   $expresion = $expresion."Pedidos.Anio_Revista,Pedidos.Pagina_Desde,Pedidos.Pagina_Hasta,";         //19-20-21
   $expresion = $expresion."Pedidos.Autor_Detalle1,Pedidos.Autor_Detalle2,Pedidos.Autor_Detalle3,";   //22-23-24
   $expresion = $expresion."Pedidos.TituloTesis,Pedidos.AutorTesis,Pedidos.DirectorTesis,";    //25-26-27  
   $expresion = $expresion."PaisTesis.Nombre,InstitucionTesis.Nombre,Pedidos.Anio_Tesis,";     //28-29-30
   $expresion = $expresion."Pedidos.TituloCongreso,Pedidos.Organizador,PaisCongreso.Nombre,";  //31-32-33
   $expresion = $expresion."Pedidos.Anio_Congreso,Pedidos.Fecha_Alta_Pedido,Pedidos.Estado,";  //34-35-36
   $expresion = $expresion."Operador.Apellido,Operador.Nombres,Clientes.Id,";					  //37-38-39 
   $expresion = $expresion."Pedidos.Fecha_Solicitado,PaisSol.Nombre,InstSol.Nombre,";          //40-41-42    
   $expresion = $expresion."DepSol.Nombre,Pedidos.Observado,Titulos_Colecciones.Id,";			  //43-44-45
   $expresion = $expresion."Clientes.EMail,Pedidos.Fecha_Inicio_Busqueda,Pedidos.Tipo_Usuario_Crea,Pedidos.Usuario_Creador,Clientes.Id,Pedidos.Operador_Corriente ";             // 46-47-48-49-50-51
   $expresion .= ",Pedidos.Capitulo_Libro "; // 52 agregador por Gonzalo
   $expresion = $expresion."FROM Pedidos LEFT JOIN Usuarios AS Clientes ON Codigo_Usuario = Clientes.Id ";
   $expresion = $expresion."LEFT JOIN Paises ON Pedidos.Codigo_Pais_Patente = Paises.Id LEFT JOIN Usuarios AS Operador ON Operador_Corriente=Operador.Id ";
   $expresion = $expresion."LEFT JOIN Titulos_Colecciones ON Pedidos.Codigo_Titulo_Revista=Titulos_Colecciones.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisCongreso ON Pedidos.Codigo_Pais_Congreso=PaisCongreso.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisTesis ON Pedidos.Codigo_Pais_Tesis=PaisTesis.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisSol ON Pedidos.Ultimo_Pais_Solicitado=PaisSol.Id ";
   $expresion = $expresion."LEFT JOIN Instituciones AS InstSol ON Pedidos.Ultima_Institucion_Solicitado=InstSol.Codigo ";
   $expresion = $expresion."LEFT JOIN Dependencias AS DepSol ON Pedidos.Ultima_Dependencia_Solicitado=DepSol.Id ";
   $expresion = $expresion."LEFT JOIN Instituciones AS InstitucionTesis ON Pedidos.Codigo_Institucion_Tesis=InstitucionTesis.Codigo ";
   return $expresion;
}

function armar_expresion_busqueda_anula()
{    
   $expresion = "SELECT PedAnula.Tipo_Pedido,PedAnula.Id,Clientes.Apellido,Clientes.Nombres,";   //0-1-2-3
   $expresion = $expresion."PedAnula.Tipo_Material,PedAnula.Titulo_Libro,PedAnula.Autor_Libro,";  //4-5-6
   $expresion = $expresion."PedAnula.Editor_Libro,PedAnula.Desea_Indice,PedAnula.Anio_Libro,";    //7-8-9   
   $expresion = $expresion."PedAnula.Numero_Patente,Paises.Nombre,PedAnula.Pais_Patente,";       //10-11-12 
   $expresion = $expresion."PedAnula.Anio_Patente,Titulos_Colecciones.Nombre,PedAnula.Titulo_Revista,"; //13-14-15
   $expresion = $expresion."PedAnula.Titulo_Articulo,PedAnula.Volumen_Revista,PedAnula.Numero_Revista,"; //16-17-18
   $expresion = $expresion."PedAnula.Anio_Revista,PedAnula.Pagina_Desde,PedAnula.Pagina_Hasta,";         //19-20-21
   $expresion = $expresion."PedAnula.Autor_Detalle1,PedAnula.Autor_Detalle2,PedAnula.Autor_Detalle3,";   //22-23-24
   $expresion = $expresion."PedAnula.TituloTesis,PedAnula.AutorTesis,PedAnula.DirectorTesis,";    //25-26-27  
   $expresion = $expresion."PaisTesis.Nombre,InstitucionTesis.Nombre,PedAnula.Anio_Tesis,";     //28-29-30
   $expresion = $expresion."PedAnula.TituloCongreso,PedAnula.Organizador,PaisCongreso.Nombre,";  //31-32-33
   $expresion = $expresion."PedAnula.Anio_Congreso,PedAnula.Fecha_Alta_Pedido,PedAnula.Estado,";  //34-35-36
   $expresion = $expresion."Operador.Apellido,Operador.Nombres,Clientes.Id,";					  //37-38-39 
   $expresion = $expresion."PedAnula.Fecha_Solicitado,PaisSol.Nombre,InstSol.Nombre,";          //40-41-42    
   $expresion = $expresion."DepSol.Nombre,PedAnula.Observado,Titulos_Colecciones.Id,";			  //43-44-45
   $expresion = $expresion."Clientes.EMail,PedAnula.Fecha_Inicio_Busqueda ";						  //46-47
   $expresion = $expresion."FROM PedAnula LEFT JOIN Usuarios AS Clientes ON Codigo_Usuario = Clientes.Id ";
   $expresion = $expresion."LEFT JOIN Paises ON PedAnula.Codigo_Pais_Patente = Paises.Id LEFT JOIN Usuarios AS Operador ON Operador_Corriente=Operador.Id ";
   $expresion = $expresion."LEFT JOIN Titulos_Colecciones ON PedAnula.Codigo_Titulo_Revista=Titulos_Colecciones.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisCongreso ON PedAnula.Codigo_Pais_Congreso=PaisCongreso.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisTesis ON PedAnula.Codigo_Pais_Tesis=PaisTesis.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisSol ON PedAnula.Ultimo_Pais_Solicitado=PaisSol.Id ";
   $expresion = $expresion."LEFT JOIN Instituciones AS InstSol ON PedAnula.Ultima_Institucion_Solicitado=InstSol.Codigo ";
   $expresion = $expresion."LEFT JOIN Dependencias AS DepSol ON PedAnula.Ultima_Dependencia_Solicitado=DepSol.Id ";
   $expresion = $expresion."LEFT JOIN Instituciones AS InstitucionTesis ON PedAnula.Codigo_Institucion_Tesis=InstitucionTesis.Codigo ";
   return $expresion;
}

function armar_expresion_busqueda_hist()
{
  $expresion = "SELECT PedHist.Tipo_Pedido,PedHist.Id,Clientes.Apellido,Clientes.Nombres,PedHist.Tipo_Material,"; // 0- 4
   $expresion = $expresion."PedHist.Titulo_Libro,PedHist.Autor_Libro,PedHist.Editor_Libro,PedHist.Desea_Indice,PedHist.Anio_Libro,"; // 5-9
   $expresion = $expresion."PedHist.Numero_Patente,Paises.Nombre,PedHist.Pais_Patente,PedHist.Anio_Patente,"; // 10-13
   $expresion = $expresion."Titulos_Colecciones.Nombre,PedHist.Titulo_Revista,PedHist.Titulo_Articulo,Volumen_Revista,PedHist.Numero_Revista,"; // 14-18
   $expresion = $expresion."PedHist.Anio_Revista,PedHist.Pagina_Desde,PedHist.Pagina_Hasta,PedHist.Autor_Detalle1,PedHist.Autor_Detalle2,PedHist.Autor_Detalle3,";// 19-24
   $expresion = $expresion."PedHist.TituloTesis,PedHist.AutorTesis,PedHist.DirectorTesis,PaisTesis.Nombre,InstitucionTesis.Nombre,PedHist.Anio_Tesis,";//25-30
   $expresion = $expresion."PedHist.TituloCongreso,PedHist.Organizador,PaisCongreso.Nombre,PedHist.Anio_Congreso,";// 31-34
   $expresion = $expresion."PedHist.Fecha_Alta_Pedido,PedHist.Estado,PedHist.Fecha_Recepcion,Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,";// 35-39
   $expresion = $expresion."PaisObt.Nombre,InstObt.Nombre,DepObt.Nombre,PedHist.Fecha_Entrega,PedHist.Observado,Titulos_Colecciones.Id ,PedHist.Capitulo_Libro"; // 40-46

   $expresion = $expresion." FROM PedHist  LEFT JOIN Usuarios AS Clientes ON PedHist.Codigo_Usuario=Clientes.Id ";
   $expresion = $expresion."LEFT JOIN Titulos_Colecciones ON PedHist.Codigo_Titulo_Revista=Titulos_Colecciones.Id ";
   $expresion = $expresion."LEFT JOIN Paises ON PedHist.Codigo_Pais_Patente = Paises.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisCongreso ON PedHist.Codigo_Pais_Congreso=PaisCongreso.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisTesis ON PedHist.Codigo_Pais_Tesis=PaisTesis.Id ";
   $expresion = $expresion."LEFT JOIN Paises AS PaisObt ON PedHist.Ultimo_Pais_Solicitado=PaisObt.Id ";

   $expresion = $expresion."LEFT JOIN Instituciones AS InstitucionTesis ON PedHist.Codigo_Institucion_Tesis=InstitucionTesis.Codigo ";
   $expresion = $expresion."LEFT JOIN Instituciones AS InstObt ON  PedHist.Ultima_Institucion_Solicitado=InstObt.Codigo ";
   $expresion = $expresion."LEFT JOIN Dependencias AS DepObt ON  PedHist.Ultima_Dependencia_Solicitado=DepObt.Id ";
   return $expresion;
}
function Devolver_Descriptivo_Material_Por_FilaGenerica($row1,$Mensaje)
{
	
	$renglon="";
	if ($row1[4]==1)
		      {
			   
			   $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tr-1'].":&nbsp;</b></font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[15]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[16]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[19]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[17]."</font></td></tr></table>";
         		      }
             else
		         if ($row1[4]==2)
		             {
				      $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#99CCFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tl-1'].":&nbsp;</b></font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[5]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[7]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[7]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[46]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-5'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[9]."</font></td></tr> </table>";
         		
				     }
					else 
			            if ($row1[4]==4)
		                   {
						    $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tt-1']."</b>:&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[25]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[26]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[27]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[30]."</font></td></tr></table>";
         		
						   }
                          else 
			                  if ($row1[4]==5)
		                        {
				                  $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFCCFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tc-1']."</b>:&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[31]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[32]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[34]."</font></td></tr></table>";
         							}
							else 
			                  if ($row1[4]==3)
		                           {
								$renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tp-1'].":&nbsp;</b></font></b></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[10]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensaje['tp-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'><b>".$row1[12]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><b><font face='MS Sans Serif' size='1'>".$Mensaje['tp-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'><b>".$row1[13]."</font></td></tr></table>";
         						    };
                 
         return $renglon;
}

function Devolver_Descriptivo_Material_Por_Fila($TipoMaterial,$row1,$forma,$Mensaje)
{

	
	$renglon="";    
	switch ($TipoMaterial)
	{
	  case 1:// Libros
	                   	          
	          {	
	          		if ($forma==1) 
	          		  {		 	   
						  $renglon ="<div align='center'><table width='70%' bgcolor='#99CCFF' cellspacing='0' cellpadding='0' height='42'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-1'].":&nbsp;</font></td>	 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[6]."</font></td></tr><tr><td height='17' width='35%' valign='top'  align='right'><font face='MS Sans Serif'  size='1'>".$Mensaje['tl-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[5]."</font></td></tr>      <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tl-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[7]."</font></td></tr></table>";                            
					  
	          		  }
					 else if ($forma==2)
	                         {
	          		          $renglon ="<div align='center'><table width='70%' bgcolor='#99CCFF' cellspacing='0' cellpadding='0' height='42'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-1'].":&nbsp;</font></td>	 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[6]."</font></td></tr><tr><td height='17' width='35%' valign='top'  align='right'><font face='MS Sans Serif'  size='1'>".$Mensaje['tl-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[5]."</b></font></td></tr>      <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[7]."</font></td></tr></table>";                           
	          		
							 }
							 else if ($forma==3)
				                     {
								      $renglon ="<div align='center'><table width='70%' bgcolor='#99CCFF' cellspacing='0' cellpadding='0' height='42'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-1'].":&nbsp;</font></td>	 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[6]."</font></td></tr><tr><td height='17' width='35%' valign='top'  align='right'><font face='MS Sans Serif'  size='1'>".$Mensaje['tl-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[5]."</font></td></tr>      <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[7]."</font></td></tr></table>";                           
	          		                  }
									  else if ($forma==4)
				                                {
										         $renglon ="<div align='center'><table width='70%' bgcolor='#99CCFF' cellspacing='0' cellpadding='0' height='42'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-1'].":&nbsp;</font></td>	 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[6]."</font></td></tr><tr><td height='17' width='35%' valign='top'  align='right'><font face='MS Sans Serif'   size='1'>".$Mensaje['tl-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[5]."</font></td></tr>      <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tl-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[7]."</font></td></tr>                  <td height='17' width='35%' valign='top'  align='right'><font face='MS Sans Serif'  size='1'>".$Mensaje['tl-4'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[46]."</font></td></tr>"; 
									            };
			        }
	 			break;
				
	  case 2: // Revista
	           {	
	          		if ($forma==1) 
	          		  {

	          		   $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-2'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[16]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[15]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-4'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[19].",".$row1[17]."</font></td></tr></table>";
					   
					   
					   
					   
	          		  }
					 else if ($forma==2)
	                         {
	          		          $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-2'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[16]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[15]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-4'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[19].",".$row1[17]."</font></td></tr></table>";
							 }
							 else if ($forma==3)
				                     {
								      $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-2'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[16]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[15]."</font></td></tr><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tr-4'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[19].",".$row1[17]."</font></td></tr></table>";
	          		                  }
			 
			     }
			   break;
	     case 3:// Tesis
	
			{	
	          		if ($forma==1) 
	          		  {
  	          		   $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-1'].":&nbsp;</font></td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[26]."</font></td></tr>					   <tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[27]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'><b>".$row1[25]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[30]."</font></td></tr></table>";
					   
					   
				
					
	          		  }
					 else if ($forma==2)
	                         {
	          		          $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><b><font face='MS Sans Serif' size='1'>".$Mensaje['tt-1'].":&nbsp;</font></td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[26]."</font></td></tr>					   <tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[27]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><b><font face='MS Sans Serif' size='1'>".$Mensaje['tt-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[25]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[30]."</font></td></tr></table>";
					
							 }
							 else if ($forma==3)
				                   {
								   $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-1'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[26]."</font></td></tr>					   <tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[27]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[25]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[30]."</font></td></tr></table>";
					 }
									  else if ($forma==4)
				                                {
										      $renglon ="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#CCFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-1'].":&nbsp;</font></td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[26]."</font></td></tr>	<tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[27]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-3'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[25]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tt-4'].":</td><td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[30]."</font></td></tr></table>";
	          		                  
									            };
			        }
	 			break;
		case 4:// Actas o Proceeding Congresos
	         {	
	          		if ($forma==1) 
	          		  {
					   $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadmding='0' height='42' bgcolor='#FFCCFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-1'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[31]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[32]."</font></td></tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[33]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><b><font face='MS Sans Serif' size='1'>".$Mensaje['tc-4'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[34]."</font></td></tr></table>";
					   
					   
					   
	          		  }
					 else if ($forma==2)
	                         {
	          		         $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFCCFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-1'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[31]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[32]."</font></td></tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-3'].":&nbsp;</font></b></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[33]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-4'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[34]."</font></td></tr></table>";
					   
							 }
							 else if ($forma==3)
				                   {
						
	          		         $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFCCFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-1'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[31]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[32]."</font></td></tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[33]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><b><font face='MS Sans Serif' size='1'>".$Mensaje['tc-4'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[34]."</font></td></tr></table>";
					                }
									  else if ($forma==4)
				                                {
									$renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFCCFF'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-1'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[31]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-2'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[32]."</font></td></tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-3'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[33]."</font></td></tr>					   <tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tc-4'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[34]."</font></td></tr></table>";
					                  
									            };  
			        }
	 			break;
		case 5:// Patentes
	       {
           if ($forma==1)
			   { 
			   $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-3'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[10]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-1'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[12]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-2'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[13]."</font></td></tr></table>";
			   
			   
			   
					 }
			  else if ($forma==2)
				      {
			           $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-3'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[10]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-1'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[12]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'><b>".$Mensaje['tp-2'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[13]."</font></td></tr></table>";
			   
			   
	          		   }
					   else if ($forma==3)
				        {
			           $renglon="<div align='center'> <TABLE border='0' width='70%' cellspacing='0' cellpadding='0' height='42' bgcolor='#FFFFCC'><tr> <td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-3'].":&nbsp;</font></td>			 <td  width='65%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#FF0033'>".$row1[10]."</font></td><tr><td height='17' width='35%' valign='top' align='right'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-1'].":&nbsp;</font></td><td height='17' valign='top'  width='65%' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[12]."</font></td></tr><tr><td height='17' valign='top' align='right' width='35%'><font face='MS Sans Serif' size='1'>".$Mensaje['tp-2'].":&nbsp;</font></td><td height='17' valign='top' align='left' width='65%' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>".$row1[13]."</font></td></tr></table>";
			   
			   
	          		   };
		   }
				break;
              
     
	};
    
   return $renglon;       
}
function Devolver_Descriptivo_Material_pequeña ($TipoMaterial,$row,$dedonde,$sinhiper,$esAdmin)
{
	global $Mens;
	// Los límites de $row son polimorficos y dependen
	// del tipo de pedido
	
	for ($i=0;$i<sizeof($row);$i++)
	{
		$row[$i]=StripSlashes($row[$i]);
	}
	
	$renglon="";

	switch ($TipoMaterial)
	{
	  case 1:// Revistas
	          	   	  
				  $renglon='	<table width="100%" border="0" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                          <tr>
                            <td width="12" height="20" bgcolor="#06B4D2" class="style5"><div align="center"><img src="../images/arrow.gif" width="10" height="13"></div></td>
                            <td width="577" bgcolor="#06B4D2" class="style5">'. $row[1].'</td>
                          </tr>
                          <tr>
                            <td colspan="2" class="style8"> <p><span class="style17">Titulo Revista: </span>'.$row[15].'<br>
                                <span class="style17">Fecha Pedido: </span>'.$row[35].'<br>
                              </p>                            </td>
                          </tr>
                          <tr bgcolor="#ECECEC">
                            <td colspan="2"><div align="center">
                              <table border="0" cellpadding="0" cellspacing="3">
                                <tr>
                                  <td><span class="style8">Descargar</span></td>
                                  <td>';
		
 
//Fin buscar archivo(s) para el pedido

						  //<img src="../images/pdf.gif" width="16" height="16">
					/*	   $renglon.= '</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                        </table>';
				  */
				  //$renglon =$Mens['tf-1']." ".$row[14]."";	
	         		
	         
	 			break;
			
	  case 2: // Libros
             $renglon='	<table width="100%" border="0" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                          <tr>
                            <td width="12" height="20" bgcolor="#06B4D2" class="style5"><div align="center"><img src="../images/arrow.gif" width="10" height="13"></div></td>
                            <td width="577" bgcolor="#06B4D2" class="style5">'. $row[1].'</td>
                          </tr>
                          <tr>
                            <td colspan="2" class="style8"> <p><span class="style17">'.$Mens['tf-5'].': </span>'.$row[5].'<br>
                                <span class="style17">Fecha Pedido: </span>'.$row[35].'<br>
                              </p>                            </td>
                          </tr>
                          <tr bgcolor="#ECECEC">
                            <td colspan="2"><div align="center">
                              <table border="0" cellpadding="0" cellspacing="3">
                                <tr>
                                  <td><span class="style8">Descargar</span></td>
                                  <td>';

			  		  
			  break;
             
	  case 3:// Patentes
$renglon='	<table width="100%" border="0" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                          <tr>
                            <td width="12" height="20" bgcolor="#06B4D2" class="style5"><div align="center"><img src="../images/arrow.gif" width="10" height="13"></div></td>
                            <td width="577" bgcolor="#06B4D2" class="style5">'. $row[1].'</td>
                          </tr>
                          <tr>
                            <td colspan="2" class="style8"> <p><span class="style17">'.$Mens['tf-10'].': </span>'.$row[10].'<br>
                                <span class="style17">Fecha Pedido: </span>'.$row[35].'<br>
                              </p>                            </td>
                          </tr>
                          <tr bgcolor="#ECECEC">
                            <td colspan="2"><div align="center">
                              <table border="0" cellpadding="0" cellspacing="3">
                                <tr>
                                  <td><span class="style8">Descargar</span></td>
                                  <td>';

			 
			 
			 /*$renglon = $Mens['tf-10']." ".$row[10]." /  ".$Mens['tf-11'].":";
             if ($row[11]==null && strlen($row[12])>0)
             {
               $renglon = $renglon.$row[12];
             }  
             elseif ($row[11]!=null)
             {
           	  $renglon = $renglon.$row[11];
             }
             $renglon = $renglon. " / ".$Mens['tf-12'].":".$row[13]."<br><br>";
             */
			 break;
             
	  case 4:// Tesis
$renglon='	<table width="100%" border="0" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                          <tr>
                            <td width="12" height="20" bgcolor="#06B4D2" class="style5"><div align="center"><img src="../images/arrow.gif" width="10" height="13"></div></td>
                            <td width="577" bgcolor="#06B4D2" class="style5">'. $row[1].'</td>
                          </tr>
                          <tr>
                            <td colspan="2" class="style8"> <p><span class="style17">'.$Mens['tf-13'].': </span>'.$row[25].'<br>
                                <span class="style17">Fecha Pedido: </span>'.$row[35].'<br>
                              </p>                            </td>
                          </tr>
                          <tr bgcolor="#ECECEC">
                            <td colspan="2"><div align="center">
                              <table border="0" cellpadding="0" cellspacing="3">
                                <tr>
                                  <td><span class="style8">Descargar</span></td>
                                  <td>';

			 
			 /*$renglon = " ".$Mens['tf-13'].":".$row[25]." /  ".$Mens['tf-14'].":".$row[26]." / ".$Mens['tf-15'].":".$row[27];
	         $renglon = $renglon." /  ".$Mens['tf-16'].":".$row[28]." /  ".$Mens['tf-17'].":".$row[29]." /  ".$Mens['tf-18'].":".$row[30]."<br><br>";
	         */
			 break;
	         
	  case 5:// Actas o Proceeding Congresos
$renglon='	<table width="100%" border="0" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                          <tr>
                            <td width="12" height="20" bgcolor="#06B4D2" class="style5"><div align="center"><img src="../images/arrow.gif" width="10" height="13"></div></td>
                            <td width="577" bgcolor="#06B4D2" class="style5">'. $row[1].'</td>
                          </tr>
                          <tr>
                            <td colspan="2" class="style8"> <p><span class="style17">'.$Mens['tf-13'].': </span>'.$row[31].'<br>
                                <span class="style17">Fecha Pedido: </span>'.$row[35].'<br>
                              </p>                            </td>
                          </tr>
                          <tr bgcolor="#ECECEC">
                            <td colspan="2"><div align="center">
                              <table border="0" cellpadding="0" cellspacing="3">
                                <tr>
                                  <td><span class="style8">Descargar</span></td>
                                  <td>';

			 
			 /*$renglon = $Mens['tf-13'].":".$row[31]." / ".$Mens['tf-19'].":".$row[32]." /  ".$Mens['tf-16'].": ".$row[33]." /  ".$Mens['tf-18'].":".$row[34]."<br><br>";
	  */
	}  
       
	   $unArchivo = array();
$list = array();
global $Id_usuario;
global $Rol;

$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
    
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];
     if ($esAdmin==1) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
       /*echo $esAdmin;
	   echo $Rol;*/
	   if ($Rol==2) //es bibliotecario. No puede bajarse los archivos, solo puede verlos
          $renglon.= " <img alt='No tiene permisos para bajarse el archivo' border=0 src='../images/pdf.gif' width='20'> ";
       else
          $renglon.= " <a href='../pedidos/farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
              <img alt='Archivo disponible para bajar' border=0 src='../images/pdf.gif' width='20'> </a> ";
     else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        {
      if (($Rol==2)&&($esAdmin==2))
	  {
	     $autorizado = puedeBajarseElArchivo($unArchivo,$row[1]);
        switch ($autorizado)
			{
				case 1:  //puede bajarse sin problemas
				  $renglon.= " <a href='../pedidos/farchivos/download.php?Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
                       <img src='../images/pdf.gif' alt='Archivo disponible para bajar' border=0 width='20' height='20'> </a> ";
				  break;
				case 0: //el archivo no está disponible
				   $renglon.= " <img alt='Archivo ya bajado' border=0 src='../images/pdf-cacelled.gif' width='20'> ";
				  break;
				
			}  //switch
      }// del if
	  else
		{
		   $renglon.= " <img alt='No tiene permisos para bajarse el archivo' border=0 src='../images/pdf.gif' width='20'> ";
	    }
      }  //else
   }   //for
 
 }  //if
	   	   $renglon.= '</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                        </table>';
   return $renglon;       

}

function Devolver_Descriptivo_Material ($TipoMaterial,$row,$dedonde,$sinhiper)
{

global $Mens;
	// Los límites de $row son polimorficos y dependen
	// del tipo de pedido
	
	for ($i=0;$i<sizeof($row);$i++)
	{
		$row[$i]=StripSlashes($row[$i]);
	}
	
	$renglon="";

	switch ($TipoMaterial)
	{
	  case 1:// Revistas
	          if ($row[14]!=null)	          	          
	          {	   		if ($dedonde!=1) 
	          		{
	          			if ($sinhiper==1)
	          			{
	          			  $renglon =$Mens['tf-1']." <b>".$row[14]."</b>";	
	          			}
	          			else
	          			{ 
	          		      $renglon =$Mens['tf-1'] ." <b><a href=\"conshallados.php?Id_Col=$row[45]&Vol=$row[17]&Numero=$row[18]&Anio=$row[19]&Id=$row[1]\"><font color='#000000'>".$row[14]."</font></a></b>";
						}	
	          		
					}
                 else {$renglon =$Mens['tf-1']." ".$row[14];}  
           	}
	 			else
				{
					if ($dedonde!=1) {$renglon =$Mens['tf-1']." <font color='#800000'>".$row[15]."</font>";}
					else {$renglon =$Mens['tf-1']." ".$row[15];}       			
 				}
				$renglon=$renglon." <br> ".$Mens['tf-2']." ".$row[19]." &nbsp;&nbsp;&nbsp; Vol:".$row[17]." &nbsp;&nbsp;&nbsp; ".$Mens['tf-3']." ".$row[18];
				if ($dedonde!=1){ $renglon=$renglon." &nbsp;&nbsp;&nbsp;  ".$Mens['tf-4'].": <font color='#800000'>".$row[20]."-".$row[21]."</font>";
				if ($row[16])
					$renglon .= "<br>Art: ".$row[16];
				}
				else {$renglon=$renglon." &nbsp;&nbsp;&nbsp; ".$Mens['tf-4'].": ".$row[20]."-".$row[21];}
				$renglon .= '<br><br>';
				break;
				
	  case 2: // Libros
	          $renglon = " ".$Mens['tf-5'].": <b> ".$row[5]." </b>   <!-- titulo libro--> <br>".$Mens['tf-6'].": ".$row[6]." <!-- autor libro -->
			  <span align='left'>".$Mens['tf-8'].": ".$row[9]."</span></span></td></tr>"; //año 
			    $renglon = $renglon."<tr valign='top' class='style33'>";
				
				 echo "<td width='200' colspan=1 align='left'>";
			    if ($row[52])
		         $renglon .= "Cap: ".$row[52]." </td>";
				
			  $renglon .= "&nbsp;<td colspan='3' align='right' width=489 >";
             if (($row[21]) || ($row[20])) //pag. desde o pag. hasta
			     $renglon .= "pag. ".$row[20]."-".$row[21]."";

             if ($row[8]==1)
             { //solicita índice
               $renglon = $renglon."<span class='style41'>".$Mens['tf-9']."</span>"; 
             }
			 
			 $renglon .= "</td> </tr>";
             break;
             
	  case 3:// Patentes
             $renglon = $Mens['tf-10']." ".$row[10]." /  ".$Mens['tf-11'].":";
             if ($row[11]==null && strlen($row[12])>0)
             {
               $renglon = $renglon.$row[12];
             }  
             elseif ($row[11]!=null)
             {
           	  $renglon = $renglon.$row[11];
             }
             $renglon = $renglon. " / ".$Mens['tf-12'].":".$row[13]."<br><br>";
             break;
             
	  case 4:// Tesis
	         $renglon = " ".$Mens['tf-13'].":".$row[25]." /  ".$Mens['tf-14'].":".$row[26]." / ".$Mens['tf-15'].":".$row[27];
	         $renglon = $renglon." /  ".$Mens['tf-16'].":".$row[28]." /  ".$Mens['tf-17'].":".$row[29]." /  ".$Mens['tf-18'].":".$row[30]."<br><br>";
	         break;
	         
	  case 5:// Actas o Proceeding Congresos
	         $renglon = $Mens['tf-13'].":".$row[31]." / ".$Mens['tf-19'].":".$row[32]." /  ".$Mens['tf-16'].": ".$row[33]." /  ".$Mens['tf-18'].":".$row[34]."<br><br>";
	  
	}  
       
   return $renglon;       

}

function Devolver_Descriptivo_Material_Corto ($TipoMaterial,$row,$dedonde,$sinhiper)
{
//este se usa para la lista corta
global $Mens;
	// Los límites de $row son polimorficos y dependen
	// del tipo de pedido
	
	for ($i=0;$i<sizeof($row);$i++)
	{
		$row[$i]=StripSlashes($row[$i]);
	}
	
	$renglon="";

	switch ($TipoMaterial)
	{
	  case 1:// Revistas
	          if ($row[14]!=null)	          	          
	          {	   		if ($dedonde!=1) 
	          		{
	          			if ($sinhiper==1)
	          			{
	          			  $renglon =$Mens['tf-1']." ".$row[14]."";	
	          			}
	          			else
	          			{ 
	          		      $renglon =$Mens['tf-1'] ." <a href=\"conshallados.php?Id_Col=$row[45]&Vol=$row[17]&Numero=$row[18]&Anio=$row[19]&Id=$row[1]\"><font color='#000000'>".$row[14]."</font></a>";
						}	
	          		
					}
                 else {$renglon =$Mens['tf-1'].$row[14];}  
           	}
	 			else
				{
					if ($dedonde!=1) {$renglon =$Mens['tf-1']." <font color='#800000'>".$row[15]."</font>";}
					else {$renglon =$Mens['tf-1'].$row[15];}       			
 				}
				$renglon=$renglon." ".$Mens['tf-2']." ".$row[19]." / Vol:".$row[17]." / ".$Mens['tf-3']." ".$row[18];
				if ($dedonde!=1){ $renglon=$renglon." /  ".$Mens['tf-4'].": <font color='#800000'>".$row[20]."-".$row[21]."</font>"; }
				else {$renglon=$renglon." / ".$Mens['tf-4'].": ".$row[20]."-".$row[21];}
				break;
				
	  case 2: // Libros   row[6] = autor libro. row[9] = año
	          $renglon = " ".$Mens['tf-5'].": ".$row[5]." / ".$Mens['tf-6'].": ".$row[6]." 
			  / ".$Mens['tf-8'].": ".$row[9]." "; //año 
			  $renglon = $renglon."\n "; 
			  
             if ($row[8]==1)
             { //solicita índice
               $renglon = $renglon.$Mens['tf-9']; //solicita indice
             }
			 $renglon .= "";
             break;
             
	  case 3:// Patentes
             $renglon = $Mens['tf-10']." ".$row[10]." /  ".$Mens['tf-11'].":";
             if ($row[11]==null && strlen($row[12])>0)
             {
               $renglon = $renglon.$row[12];
             }  
             elseif ($row[11]!=null)
             {
           	  $renglon = $renglon.$row[11];
             }
             $renglon = $renglon. " / ".$Mens['tf-12'].":".$row[13];
             break;
             
	  case 4:// Tesis
	         $renglon = " ".$Mens['tf-13'].":".$row[25]." /  ".$Mens['tf-14'].":".$row[26]." / ".$Mens['tf-15'].":".$row[27];
	         $renglon = $renglon." /  ".$Mens['tf-16'].":".$row[28]." /  ".$Mens['tf-17'].":".$row[29]." /  ".$Mens['tf-18'].":".$row[30];
	         break;
	         
	  case 5:// Actas o Proceeding Congresos
	         $renglon = $Mens['tf-13'].":".$row[31]." / ".$Mens['tf-19'].":".$row[32]." /  ".$Mens['tf-16'].": ".$row[33]." /  ".$Mens['tf-18'].":".$row[34];
	  
	}  
       
   return $renglon;       

}



function Devolver_Descriptivo_Material_Email ($TipoMaterial,$row,$dedonde,$sinhiper)
{
//se usa para los textos de los emails
global $Mens;
	// Los límites de $row son polimorficos y dependen
	// del tipo de pedido
	
	for ($i=0;$i<sizeof($row);$i++)
	{
		$row[$i]=StripSlashes($row[$i]);
	}
	
	$renglon="";

	switch ($TipoMaterial)
	{
	  case 1:// Revistas
	          if ($row[14]!=null)	          	          
	          {	   		if ($dedonde!=1) 
	          		{
	          			if ($sinhiper==1)
	          			{
	          			  $renglon =$Mens['tf-1']." ".$row[14]."";	
	          			}
	          			else
	          			{ 
	          		      $renglon =$Mens['tf-1'] ." <a href=\"conshallados.php?Id_Col=$row[45]&Vol=$row[17]&Numero=$row[18]&Anio=$row[19]&Id=$row[1]\"><font color='#000000'>".$row[14]."</font></a>";
						}	
	          		
					}
                 else {$renglon =$Mens['tf-1']." ".$row[14];}  
           	}
	 			else
				{
					if ($dedonde!=1) {$renglon =$Mens['tf-1']." <font color='#800000'>".$row[15]."</font>";}
					else {$renglon =$Mens['tf-1']." ".$row[15];}       			
 				}
				if ($row[16])
				   $renglon .= " \n Art: ".$row[16];
				$renglon=$renglon." \n ".$Mens['tf-2']." ".$row[19]." / Vol:".$row[17]." / ".$Mens['tf-3']." ".$row[18]."";
				if ($dedonde!=1){ $renglon=$renglon." /  ".$Mens['tf-4'].": <font color='#800000'>".$row[20]."-".$row[21]."</font>"; }
				else {$renglon=$renglon." / ".$Mens['tf-4'].": ".$row[20]."-".$row[21];}
				break;
				
	  case 2: // Libros   row[6] = autor libro. row[9] = año
	          $renglon = " ".$Mens['tf-5'].": ".$row[5]." / ".$Mens['tf-6'].": ".$row[6]." 
			  / ".$Mens['tf-8'].": ".$row[9]." "; //año 
			  $renglon = $renglon."\n "; 
			  if ($row[52]) //capitulo
			    $renglon .= "Cap: ".$row[52]." \n";
             if ($row[8]==1)
             { //solicita índice
               $renglon = $renglon.$Mens['tf-9']; //solicita indice
             }
			 $renglon .= "";
             break;
             
	  case 3:// Patentes
             $renglon = $Mens['tf-10']." ".$row[10]." /  ".$Mens['tf-11'].":";
             if ($row[11]==null && strlen($row[12])>0)
             {
               $renglon = $renglon.$row[12];
             }  
             elseif ($row[11]!=null)
             {
           	  $renglon = $renglon.$row[11];
             }
             $renglon = $renglon. " / ".$Mens['tf-12'].":".$row[13];
             break;
             
	  case 4:// Tesis
	         $renglon = " ".$Mens['tf-13'].":".$row[25]." /  ".$Mens['tf-14'].":".$row[26]." / ".$Mens['tf-15'].":".$row[27];
	         $renglon = $renglon." /  ".$Mens['tf-16'].":".$row[28]." /  ".$Mens['tf-17'].":".$row[29]." /  ".$Mens['tf-18'].":".$row[30];
	         break;
	         
	  case 5:// Actas o Proceeding Congresos
	         $renglon = $Mens['tf-13'].":".$row[31]." / ".$Mens['tf-19'].":".$row[32]." /  ".$Mens['tf-16'].": ".$row[33]." /  ".$Mens['tf-18'].":".$row[34];
	  
	}  
       
   return $renglon;       

}



function Contar_Colecciones($Id)
{

  $Instruccion = "SELECT Codigo_Titulo_Revista FROM Pedidos WHERE Id='".$Id."'";
  $result = mysql_query ($Instruccion);
  $row = mysql_fetch_row($result);
  if ($row[0]!=0)
  {
      $Instruccion = "SELECT Numero_Pedidos FROM Titulos_Colecciones WHERE Id=".$row[0];
      $result = mysql_query($Instruccion);
      $rowg = mysql_fetch_row($result);
      $Instruccion = "UPDATE Titulos_Colecciones SET Numero_Pedidos=".($rowg[0]+1)." WHERE Id=".$row[0];
      $result = mysql_query($Instruccion);
  }
 
}

function LoginyPassword($Nombre,$Apellido)
{
	// Elimino blancos en el nombre
   $i=0;
   $NombreBien="";
   while ($i<=strlen($Nombre)-1)
   {
   		if (substr($Nombre,$i,1)!=" ")
   		{
   			$NombreBien = $NombreBien.substr($Nombre,$i,1);
   		}
   		$i++;
   }
   
   // Elimino blancos en el Apellido
   $i=0;
   $ApellidoBien="";
   while ($i<=strlen($Apellido)-1)
   {
   		if (substr($Apellido,$i,1)!=" ")
   		{
   			$ApellidoBien = $ApellidoBien.substr($Apellido,$i,1);
   		}
   		$i++;
   }

   // Concateno
   
   if(strlen($ApellidoBien)>5)
   {
     $LongNom = 3;
   }
   else
   {
   	  $LongNom	= 8 - strlen($ApellidoBien);
   }  
   
   $Login = substr($ApellidoBien,0,5).substr($NombreBien,0,$LongNom);
   $Login = substr($Login,0,8);
   $Login = strtoupper(substr($Login,0,1)).strtolower(substr($Login,1,7));
   
   // Verifico que no exista un login asi
   $senial=1;
   while ($senial>=1)
   {
   	 $Instruccion = "SELECT COUNT(*) FROM Usuarios WHERE Login='".$Login."'";
   	 $resultw=mysql_query($Instruccion);
   	 $roww=mysql_fetch_row($resultw);
   	 if ($roww[0]==0)
   	 {
   	 	$senial=0;
   	 }
   	 else   	 
   	 {
   	   $Login = substr($Login,0,strlen($Login)-1).++$senial;
   	 }
   	} 
   	
   	// Asigno password
   srand((double)microtime()*1000000);  
   $Numero = rand (2000,6230);
   $Clave = substr($Login,0,3).$Numero;
   
   mysql_free_result ($resultw); 

   return array($Login,$Clave);
}

function Devolver_Elementos()
{
	return array ("Texto"=>1,"Texto Condicional"=>2,"Hipervínculo"=>3,"Hipervínculo Condicional"=>4,"Encabezado de Tabla"=>5,"Imágen"=>6,"Título Ventana"=>7,"Mensaje de Error"=>8,"Botón"=>9);	
}

function Devolver_Desc_Elem($opcion)
{
	$vector = array ("Texto","Texto Condicional","Hipervínculo","Hipervínculo Condicional","Encabezado de Tabla","Imágen","Título Ventana","Mensaje de Error","Botón");	
	return $vector[$opcion-1];
}

function Opciones_select($Modo,$VectorIdioma)
{
       $st="";  
		for ($i=1; $i<=5; $i++)
		{   
           if ($Modo==$i)
             { 
              $st=$st."<option selected value='$i'>".Devolver_Estado($VectorIdioma,$i,1)."</option>";
             }
            else 
            {
              $st=$st."<option value='$i'>".Devolver_Estado($VectorIdioma,$i,1)."</option>";
			  }
        }      
       return $st;   
            
}

function reemplazar_variables($origen,$Id_Pedido,$Nombre_usuario,$paginas,$cita,$numero_pedidos,$minima_fecha,$login,$password)
{
  // Agrego un par de variables mas. Las mismas se usan en el contexto
  // del envío de mails dirigidos a listas de usuarios que poseen pedidos
  // para entregar, en las plantillas contruidas a tal fin va a figurar
  // como variable los valores de número total de pedidos por entregar
  // y mínimo de fecha en la que se recibió un pedido.
   
  
  if (strpos($origen,"/*pedido*/")>0)  {$origen = substr_replace($origen,$Id_Pedido,strpos($origen,"/*pedido*/")).substr(strstr($origen,"/*pedido*/"),10,strlen($origen)); }
  if (strpos($origen,"/*usuario*/")>0) {$origen = substr_replace($origen,$Nombre_usuario,strpos($origen,"/*usuario*/")).substr(strstr($origen,"/*usuario*/"),11,strlen($origen));}
  if (strpos($origen,"/*paginas*/")>0) {$origen = substr_replace($origen,$paginas,strpos($origen,"/*paginas*/")).substr(strstr($origen,"/*paginas*/"),11,strlen($origen));}
  if (strpos($origen,"/*cita*/")>0)    {$origen = substr_replace($origen,$cita,strpos($origen,"/*cita*/")).substr(strstr($origen,"/*cita*/"),8,strlen($origen));}
  if (strpos($origen,"/*numero_pedidos*/")>0)    {$origen = substr_replace($origen,$numero_pedidos,strpos($origen,"/*numero_pedidos*/")).substr(strstr($origen,"/*numero_pedidos*/"),18,strlen($origen));}
  if (strpos($origen,"/*minima_fecha*/")>0)    {$origen = substr_replace($origen,$minima_fecha,strpos($origen,"/*minima_fecha*/")).substr(strstr($origen,"/*minima_fecha*/"),16,strlen($origen));}
  if (strpos($origen,"/*login*/")>0)    {$origen = substr_replace($origen,$login,strpos($origen,"/*login*/")).substr(strstr($origen,"/*login*/"),9,strlen($origen));}
  if (strpos($origen,"/*password*/")>0)    {$origen = substr_replace($origen,$password,strpos($origen,"/*password*/")).substr(strstr($origen,"/*password*/"),12,strlen($origen));}
 
  
  
  return $origen;
}

function Armar_select_eventos($dedonde,$Id,$Tabla) 
{
   switch ($Tabla)
   {
     case 1:
	 
       $Instruccion = "SELECT Codigo_Evento,Fecha,Paises.Nombre,Instituciones.Nombre";
       $Instruccion = $Instruccion.",Dependencias.Nombre,Usuarios.Apellido,Usuarios.Nombres,Eventos.Id,Eventos.Id_Correo";
       $Instruccion = $Instruccion." FROM Eventos LEFT JOIN Paises ON Eventos.Codigo_Pais=Paises.Id";
       $Instruccion = $Instruccion." LEFT JOIN Instituciones ON Eventos.Codigo_Institucion=Instituciones.Codigo";
       $Instruccion = $Instruccion." LEFT JOIN Dependencias ON Eventos.Codigo_Dependencia=Dependencias.Id";
       $Instruccion = $Instruccion." LEFT JOIN Usuarios ON Eventos.Operador=Usuarios.Id";
       // Cuando proviene de la visión del usuario debe eliminar los privados
       if ($dedonde==1)
       {
          $Instruccion = $Instruccion." WHERE Eventos.Id_Pedido='".$Id."' AND Es_Privado=0 ORDER BY Eventos.Fecha,Eventos.Codigo_Evento";
       }
       else
       {
         $Instruccion = $Instruccion." WHERE Eventos.Id_Pedido='".$Id."' ORDER BY Eventos.Fecha,Eventos.Codigo_Evento";
       }
	   break;
	 
	 case 2:  

       $Instruccion = "SELECT Codigo_Evento,Fecha,Paises.Nombre,Instituciones.Nombre";
       $Instruccion = $Instruccion.",Dependencias.Nombre,Usuarios.Apellido,Usuarios.Nombres,EvHist.Id,EvHist.Id_Correo";
       $Instruccion = $Instruccion." FROM EvHist LEFT JOIN Paises ON EvHist.Codigo_Pais=Paises.Id";
       $Instruccion = $Instruccion." LEFT JOIN Instituciones ON EvHist.Codigo_Institucion=Instituciones.Codigo";
       $Instruccion = $Instruccion." LEFT JOIN Dependencias ON EvHist.Codigo_Dependencia=Dependencias.Id";
       $Instruccion = $Instruccion." LEFT JOIN Usuarios ON EvHist.Operador=Usuarios.Id";
       // Cuando proviene de la visión del usuario debe eliminar los privados
       if ($dedonde==1)
       {
          $Instruccion = $Instruccion." WHERE EvHist.Id_Pedido='".$Id."' AND Es_Privado=0 ORDER BY EvHist.Fecha,EvHist.Codigo_Evento";
       }
       else
       {
          $Instruccion = $Instruccion." WHERE EvHist.Id_Pedido='".$Id."' ORDER BY EvHist.Fecha,EvHist.Codigo_Evento";
       }
	   break;
	   
	 case 3:  

       $Instruccion = "SELECT Codigo_Evento,Fecha,Paises.Nombre,Instituciones.Nombre";
       $Instruccion = $Instruccion.",Dependencias.Nombre,Usuarios.Apellido,Usuarios.Nombres,EvAnula.Id,EvAnula.Id_Correo";
       $Instruccion = $Instruccion." FROM EvAnula LEFT JOIN Paises ON EvAnula.Codigo_Pais=Paises.Id";
       $Instruccion = $Instruccion." LEFT JOIN Instituciones ON EvAnula.Codigo_Institucion=Instituciones.Codigo";
       $Instruccion = $Instruccion." LEFT JOIN Dependencias ON EvAnula.Codigo_Dependencia=Dependencias.Id";
       $Instruccion = $Instruccion." LEFT JOIN Usuarios ON EvAnula.Operador=Usuarios.Id";
       // Cuando proviene de la visión del usuario debe eliminar los privados
       if ($dedonde==1)
       {
          $Instruccion = $Instruccion." WHERE EvAnula.Id_Pedido='".$Id."' AND Es_Privado=0 ORDER BY EvAnula.Fecha,EvAnula.Codigo_Evento";
       }
       else
       {
          $Instruccion = $Instruccion." WHERE EvAnula.Id_Pedido='".$Id."' ORDER BY EvAnula.Fecha,EvAnula.Codigo_Evento";
       }
   
	}
	return $Instruccion;     
}

function Determinar_Color_Encabezado($Tabla)
{
	switch ($Tabla)
	{
		case 1:
			return "#006699";
			break;
		case 2:
		    return "#878898";
			greak;
		case 3:
			return "#993366";	
	} 
}

function Calcular_Dias ($st1,$st2)
{
 // Se supone recibe dos strings fecha y debe calcular la diferencia en
 // dias entre ambos considerando los fines de semana
 // Modificacion: Calendario dias festivos para cada pais
 // el formato asumido de fecha es AAAA-MM-DD (ISO)
 // supone st1 Inicio st2 Final
 
 //Genero los timestamp de cada una de las fechas
 $Inicio = mktime (0,0,0,substr($st1,5,2),substr($st1,8,2),substr($st1,0,4));
 $Fin = mktime (0,0,0,substr($st2,5,2),substr($st2,8,2),substr($st2,0,4));
 
 $contador = 0;
 
 
 //Recorro todos los dias entre una y otra
 
 while ($Inicio <= $Fin)
 {
   $valores = getdate ($Inicio);
   if ($valores ["wday"]>=1 && $valores["wday"]<=5)
   {
     $contador+=1;
   }
   // Avanzo un día
 	$Inicio+=86400;
 }
 
 if ($contador-1<0)
 {
   return 0; 
 }
 else
 {
   return $contador-1;
 }
}
function Opciones_Color()
{
	return "#003399,#993366,#009966,#ff6699,#ffffff,#ff9966,#6699ff,#666699,#ffccff,#00ccff,#ffff00,#66ff33,#ff0000,#6600ff,#00cc00,#ffccff,#ffcc99,#00ff00,#cccc33,#ffffcc,#00ff99";
}
function Primer_Palabra($cadena)
{
  $posicion = strpos($cadena," ");
  
  if ($posicion===false)  
  {
    return $cadena;
  }
  else
  {	
	return substr($cadena,0,$posicion);
  }	
}

function checkMimeType()
{  
  global $HTTP_POST_FILES;
  
  		$tipos= array("application/x-gzip-compressed" => 1,
					"application/x-zip-compressed" => 1,
					"application/x-tar" => 1,
					"text/plain" => 2,
					"text/html" => 3,
					"image/bmp" => 4,
					"image/gif" => 4,
					"image/jpeg" => 4,
					"image/pjpeg" => 4,
					"application/pdf" => 7,
					"application/msword" => 8,
					"application/csv" => 9,
					"application/x-msexcel" => 9,
					"application/x-mspowerpoint" => 10);
		
		$devuelve=0;			
		while (list($tipo,$valor)=each($tipos))
		{
			if ($tipo==$HTTP_POST_FILES['Archivo']['type'])
			{
				$devuelve = $valor;
			}
		}		
		return $devuelve;	
					
}

function upload($userfile,$necesita_id=true)
{
  global $HTTP_POST_FILES;

   $tipo = 	checkMimeType();	
   if ($userfile!="none" && (($necesita_id && $tipo!=0) || (!$necesita_id)))
   {

    $userfile = $HTTP_POST_FILES['Archivo']['name']; 
	$size = $HTTP_POST_FILES['Archivo']['size']; 
	$location = $HTTP_POST_FILES['Archivo']['tmp_name']; 
	
     if (is_uploaded_file($location)) 
	 { 
	    $destino = Destino().$userfile;
		move_uploaded_file($location, $destino);
		return array($userfile,$tipo,$size);
	 }
	 else
	 {
	 	return array("",0,0);
	 }
   	}
}
function Devolver_Institucion_Predeterminada()
{
$query = "SELECT Instituciones.Nombre, Instituciones.Abreviatura FROM Instituciones WHERE Predeterminada=1";
$resu = mysql_query($query);
$row=mysql_fetch_array($resu);
return $row[0];

}

function Devolver_Abreviatura_Institucion_Predeterminada()
{
$query = "SELECT Instituciones.Nombre, Instituciones.Abreviatura FROM Instituciones WHERE Predeterminada=1";
$resu = mysql_query($query);
$row=mysql_fetch_array($resu);
return $row[1];


}


function Devolver_Abreviatura_Pais_Predeterminada()
{
$query = "SELECT Instituciones.Nombre, Paises.Abreviatura FROM Instituciones,Paises WHERE Paises.Id=Instituciones.Codigo_Pais and  Predeterminada=1";
$resu = mysql_query($query);
$row=mysql_fetch_array($resu);
return $row[1];


}
function tipo_pedido($idUsuario)
/* Si el usuario es de UNLP retorna 1, o sea, búsqueda.
   Sino, retorna 0, o sea provisión.
*/
{
$query = "SELECT Instituciones.Nombre, Instituciones.Abreviatura,Instituciones.tipo_pedido_nuevo FROM Usuarios,Instituciones WHERE Usuarios.Id = ".$idUsuario." and Usuarios.Codigo_Institucion = Instituciones.Codigo";
$resu = mysql_query($query);
//echo $query;
echo mysql_error();
$retorno = 0;
if ($row = mysql_fetch_row($resu))
	{
	  $retorno =$row[2] ;
    }
return $retorno;
}
function devolver_imagen ($tipo)
{
	switch ($tipo)
	{
		case 1:
			$imagen = "../images/zip.gif";
			break;
		case 2:
			$imagen = "../images/texto.gif";
			break;
		case 3:
			$imagen = "../images/explorer.gif";
			break;
		case 4:
			$imagen = "../images/imagen.gif";
			break;
		case 7:
			$imagen = "../images/acrobat.gif";
			break;
		case 8:
			$imagen = "../images/doc.gif";
			break;
		case 9:
			$imagen = "../images/excel.gif";
			break;
		case 10:
			$imagen = "../images/pps.gif";
			break;
	}
	return $imagen;
}
function estado_busqueda ($estado)
{
	// Devuelve si a un pedido le debe ser presentado el botón de 
	// busquedas o no de acuerdo a su estado. El unico 
	// caso que no deberia es si esta pendiente
	if ($estado==1)
	{
		return false;		
	}
	else
	{
		return true;
	}
}

function dibujar_menu_usuarios($username,$dedonde=1)
{     global $IdiomaSitio;

	switch ($IdiomaSitio)
	{
		case 1: //castellano
			$Mensajes = array("msg-1"=>"Volver al sitio de Usuarios","msg-2"=>"Editar datos personales","msg-3"=>" Cambiar contrase&ntilde;a ","msg-4"=>"Salir de cuenta usuario",);
			break;
    	case 2:  //portugues
			$Mensajes = array("msg-1"=>"Volver al sitio de Usuarios","msg-2"=>"Editar datos personales","msg-3"=>" Cambiar contrase&ntilde;a ","msg-4"=>"Salir de cuenta usuario",);
			break;
		case 3: //english
			$Mensajes = array("msg-1"=>"Back to user's site","msg-2"=>"Modify personal data","msg-3"=>"Change password ","msg-4"=>"Logout",);
			break;
		default :  // == castellano
			$Mensajes = array("msg-1"=>"Volver al sitio de Usuarios","msg-2"=>"Editar datos personales","msg-3"=>" Cambiar contrase&ntilde;a ","msg-4"=>"Salir de cuenta usuario",);
	}

echo '<table width="150"  border="0" bgcolor="#ececec">
                <tr>
                  <td height="20" bgcolor="#F5F5F5"><div align="center"><span class="style4">'.$username.'</span></div></td>
                </tr>
                <tr>
                  <td height="20"><img src="../images/user.jpg" width="150" height="177"></td>
                </tr>';
                
                 if ($dedonde == 1) //muestro la opcion de volver al menu principal
                     echo '<tr><td class="style2"><div align="center" class="style31 style32"><div align="left"><span class="style5"><img src="../images/square-w.gif" width="8" height="8"></span><a href="../usuarios/sitiousuariologed.php" class="style8">'.$Mensajes["msg-1"].'</a>  </td> </tr>';
				 
							 
				 echo '<tr><td class="style2"><div align="center" class="style31 style32">
                      <div align="left"><span class="style5"><img src="../images/b1owhite.gif" width="8" height="8"></span>  <a href="../usuarios/actualizar-datos-personales.php" class="style8">'.$Mensajes["msg-2"].'</a></div>
                  </div></td>
                </tr>
            	  
					  <tr>
                  <td class="style2"><div align="center" class="style34 style36">
                      <div align="left"><span class="style5"><img src="../images/b1owhite.gif" width="8" height="8"></span> <a href="../usuarios/cambiarcontrasenia.php" class="style8">'.$Mensajes["msg-3"].'</a></div>
                  </div></td>
                </tr>
            		  <tr>
                  <td class="style2"><div align="center" class="style32">
                      <div align="left"><span class="style5"><img src="../images/b1owhite.gif" width="8" height="8"></span> <a href="../usuarios/sitiousuario.php" class="style8">'.$Mensajes["msg-4"].'</a></div>
                  </div></td>
                </tr>
              </table>';
    
}

function Busqueda_Titulo_No_Normalizado($expresion , $dedonde , $Id_usuario ,$VectorIdioma , $Mensajes , $Bibliotecario = 0, $esAdmin=0 , $inicial=0 , $pagina_actual=1 , $cantidad=0)
	{
    $expresion = addslashes($expresion);
// Busqueda por Titulo Normalizado

   //Armo la consulta de los pedidos en curso
		$query = armar_expresion_busqueda();
		if ($Bibliotecario>=1){
				$query.=" LEFT JOIN Usuarios AS Biblio ON Pedidos.Codigo_Usuario=Biblio.Id "; 
			}

		$query .= " WHERE (Titulo_Revista LIKE '%".$expresion."%'  or Titulo_Libro LIKE '%".$expresion."%' or Titulo_Articulo LIKE '%".$expresion."%' or  TituloTesis  LIKE '%".$expresion."%'  or TituloCongreso LIKE '%".$expresion."%' or PonenciaActa like '%".$expresion."%')";

		if ($dedonde==1 && $Bibliotecario>=1){	
		
			   switch ($Bibliotecario){	
						case 1:
							$query.=" AND Biblio.Codigo_Institucion=".$Instit_usuario;
							break;
						case 2:
							$query.=" AND Biblio.Codigo_Dependencia=".$Dependencia;
							break;
						case 3:
							$query.=" AND Biblio.Codigo_Unidad=".$Unidad;
							break;
				}	//end swicth 
			
		   }  //end if ($dedonde==1 && $Bibliotecario>=1)
		  elseif ($dedonde==1){
				$query .= " AND Codigo_Usuario=".$Id_usuario;
			} 

//		echo $query;
	
		$query = $query." ORDER BY Titulo_Revista , Titulo_Libro ,  Titulo_Articulo ,  TituloTesis , TituloCongreso  ";

		$result = mysql_query($query);
		echo mysql_error();

   //Armo la consulta de los pedidos historicos


		$query1 = armar_expresion_busqueda_hist();   
		$query1 .= "WHERE (Titulo_Revista LIKE '%".$expresion."%'  or Titulo_Libro LIKE '%".$expresion."%' or Titulo_Articulo LIKE '%".$expresion."%' or  TituloTesis  LIKE '%".$expresion."%'  or TituloCongreso LIKE '%".$expresion."%' or PonenciaActa like '%".$expresion."%')";
		if ($dedonde==1 && $Bibliotecario>=1){	
		
			   switch ($Bibliotecario){	
						case 1:
							$query1.=" AND Biblio.Codigo_Institucion=".$Instit_usuario;
							break;
						case 2:
							$query1.=" AND Biblio.Codigo_Dependencia=".$Dependencia;
							break;
						case 3:
							$query1.=" AND Biblio.Codigo_Unidad=".$Unidad;
							break;
				}	//end swicth 
			
		   }  //end if ($dedonde==1 && $Bibliotecario>=1)
		  elseif ($dedonde==1){
				$query1 .= " AND Codigo_Usuario=".$Id_usuario;
			} 
		$query1 = $query1." ORDER BY Titulo_Revista , Titulo_Libro ,  Titulo_Articulo ,  TituloTesis  , TituloCongreso   ";
								  
		$result1 = mysql_query($query1);
		echo mysql_error();

//Armo la consulta de los pedidos anulados


		$query2 = armar_expresion_busqueda_anula();
		$query2 .= "WHERE (Titulo_Revista LIKE '%".$expresion."%'  or Titulo_Libro LIKE '%".$expresion."%' or Titulo_Articulo LIKE '%".$expresion."%' or  TituloTesis  LIKE '%".$expresion."%' or TituloCongreso LIKE '%".$expresion."%' or PonenciaActa like '%".$expresion."%') ";	
		if ($dedonde==1 && $Bibliotecario>=1){	
		
			   switch ($Bibliotecario){	
						case 1:
							$query2.=" AND Biblio.Codigo_Institucion=".$Instit_usuario;
							break;
						case 2:
							$query2.=" AND Biblio.Codigo_Dependencia=".$Dependencia;
							break;
						case 3:
							$query2.=" AND Biblio.Codigo_Unidad=".$Unidad;
							break;
				}	//end swicth 
			
		   }  //end if ($dedonde==1 && $Bibliotecario>=1)
		  elseif ($dedonde==1){
				$query2 .= " AND Codigo_Usuario= ".$Id_usuario;
			} 


		$query2 = $query2." ORDER BY Titulo_Revista , Titulo_Libro ,  Titulo_Articulo ,  TituloTesis , TituloCongreso  ";
	/*	echo' <div align="left"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC"><tr><td height="20" class="style22">';
		echo $query2;
		echo"</td></tr></table></div>";*/
		$result2= mysql_query($query2);
		echo mysql_error();


  include_once "../inc/tabla_ped_unnoba.inc" ;


  $cantidad_pedidos = mysql_num_rows($result)+mysql_num_rows($result1)+mysql_num_rows($result2);
  
  
   

  ?>
	<div align="left"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC"><tr><td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"><?echo $Mensajes["et-9"];?>:<span class="style35"><? echo $cantidad_pedidos;?> </span></td></tr></table></div>
    <br><?

	
   $url = "busqueda.php?expresion=".$expresion."&campo=2&dedonde=".$dedonde;
   
   MostrarPaginado($url , $cantidad_pedidos , $pagina_actual, $inicial , $cantidad );


   
   $decena_actual= intval( $pg / 10);

   if ($decena_actual ==0)
		     $decena_actual = 0.1; // Para el caso de que este el la decena 0

   $desde = $decena_actual * 10; // Calculo de la pagina inicial
   $fin_decena= $desde + 9;

   $pages = ceil($cantidad_pedidos / $cantidad);
   
   if ($pages > $fin_decena)
		$hasta= $fin_decena;
	else
		$hasta = $pages;



$i=0;

$resultados="";
	while($row = mysql_fetch_row($result))
		 {  	
		    
			$pedido[0] = 1;
			$pedido[1] = $row;
			$resultados[$i] = $pedido;
			$i++;

				
		}
	while($row = mysql_fetch_row($result1))
		 {  	
		    
			$pedido[0] = 2;
			$pedido[1] = $row;
			$resultados[$i] = $pedido;
			$i++;
				
		}
	while($row = mysql_fetch_row($result2))
		 {  	
		    
			$pedido[0] = 3;
			$pedido[1] = $row;
			$resultados[$i] = $pedido;
			$i++;
				
		}		



for ($j = $inicial ; $j < ($inicial + $cantidad ) ; $j++ )
		{	

			$pedido = $resultados[$j];		
			$row= $pedido[1];
			switch($pedido[0])
				{
				case 1: 
					    //Visualizacion de los pedidos en curso
						Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes , $esAdmin);?></td></tr>
						<tr> <td align='center'><p align="center">
							<form name="form3" method="POST">	
								<input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>' , 1)">
									<? if ($dedonde!=1) { ?>	<!-- if 11 -->
											<input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
									<? }  ?><!-- end if 11 -->
								<input type="hidden" name="Modo">
								<input type="hidden" name="Lista">
							</form></p>
						</tr></td></table><br><? 
						break;

				case 2: 
						//Visualizacion de los pedidos historicos
						echo " <table align='center' width='90%' border=1 bordercolor='green'> <tr><td align='center' width='90%'  >";
						 Dibujar_Tabla_Comp_Hist_Ped ($VectorIdioma,$row,$Mensajes,1,$esAdmin); ?>
					    <center><div>
						<table border='0' width='100%' align='center' cellpadding='0' cellspacing='1'  bgcolor="<? echo Devolver_Color($row[4]);?>" ><tr><td align='center' ><input type="button" class="style22" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'nada','<? echo $row[2].",".$row[3]; ?>',0)"></td></tr></table></div></center></td></tr></table><br><?
						break;

				case 3: 
					     //Visualizacion de los pedidos anulados
					     Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$Mensajes , $esAdmin,1);?>
						 </td></tr><tr><td align='center' > 		 
						 <form name="form3" method="POST"> 
						  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
						  <input type="button" value="<? echo $Mensajes["bot-5"]; ?>" name="B3"  class="style22" OnClick="vent_anula('<? echo $row[1]; ?>')">
						  </p>
						 <input type="hidden" name="Modo">
						 </form></td></tr></table><br><?						
						 break;
								
				} //end switch
				
		}//end for

	 
	   MostrarPaginado($url , $cantidad_pedidos , $pagina_actual, $inicial , $cantidad );
	 

} // end Busqueda_Titulo_No_Normalizado


function Busqueda_Autor($expresion , $dedonde , $Id_usuario ,$VectorIdioma , $Mensajes , $Bibliotecario = 0, $esAdmin=0 , $inicial=0 , $pagina_actual=1 , $cantidad=0){

    $expresion = addslashes($expresion);
//Busqueda de todos los autores
// Se arma el query de los pedidos en curso
	$query = armar_expresion_busqueda();
	if ($Bibliotecario>=1)	   {
										$query.="LEFT JOIN Usuarios AS Biblio ON Pedidos.Codigo_Usuario=Biblio.Id "; 
									   }
	
	$query .= " WHERE (DirectorTesis like '%$expresion%' || AutorTesis  like '%$expresion%' || Editor_Libro like '%$expresion%' ||  Autor_Libro like '%$expresion%' || Autor_Detalle1 like '%$expresion%' || Autor_Detalle2 like '%$expresion%' || Autor_Detalle3 like '%$expresion%' )";
	

	if ($dedonde==1){
			 $query .= " AND Codigo_Usuario= ".$Id_usuario;
		}
	$query = $query." ORDER BY Titulo_Articulo";

	$result = mysql_query($query);
	echo mysql_error();

// Se arma el query de los pedidos en historicos
	$query1 = armar_expresion_busqueda_hist(); 
	if ($Bibliotecario>=1)	   {
										$query1.="LEFT JOIN Usuarios AS Biblio ON Pedidos.Codigo_Usuario=Biblio.Id "; 
									   }
	
	$query1 .= " WHERE (DirectorTesis like '%$expresion%' || AutorTesis  like '%$expresion%' || Editor_Libro like '%$expresion%' ||  Autor_Libro like '%$expresion%' || Autor_Detalle1 like '%$expresion%' || Autor_Detalle2 like '%$expresion%' || Autor_Detalle3 like '%$expresion%' )";
	

	if ($dedonde==1){
			 $query1 .= " AND Codigo_Usuario= ".$Id_usuario;
		}
	$query1 = $query1." ORDER BY Titulo_Articulo";

	$result1 = mysql_query($query1);
	echo mysql_error();

// Se arma el query de los pedidos anulados
	$query2 = armar_expresion_busqueda_anula();
	if ($Bibliotecario>=1)	   {
										$query2.="LEFT JOIN Usuarios AS Biblio ON Pedidos.Codigo_Usuario=Biblio.Id "; 
									   }
	
	$query2 .= " WHERE (DirectorTesis like '%$expresion%' || AutorTesis  like '%$expresion%' || Editor_Libro like '%$expresion%' ||  Autor_Libro like '%$expresion%' || Autor_Detalle1 like '%$expresion%' || Autor_Detalle2 like '%$expresion%' || Autor_Detalle3 like '%$expresion%' )";
	

	if ($dedonde==1){
			 $query2 .= " AND Codigo_Usuario= ".$Id_usuario;
		}
	$query2 = $query2." ORDER BY Titulo_Articulo";

	$result2 = mysql_query($query2);
	echo mysql_error();
  
   include_once "../inc/tabla_ped_unnoba.inc" ;


   $cantidad_pedidos = mysql_num_rows($result)+mysql_num_rows($result1)+mysql_num_rows($result2);
   
   
   $url= "busqueda.php?expresion=".$expresion."&campo=3&dedonde=".$dedonde;
   
   
   

   ?>

	
	<div align="left"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC"><tr><td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"><?echo $Mensajes["et-9"];?>:<span class="style35"><? echo $cantidad_pedidos;?> </span></td></tr></table></div>
    <br><?
MostrarPaginado($url , $cantidad_pedidos , $pagina_actual, $inicial  , $cantidad);
$i=0;

$resultados="";
	while($row = mysql_fetch_row($result))
		 {  	
		    
			$pedido[0] = 1;
			$pedido[1] = $row;
			$resultados[$i] = $pedido;
			$i++;

				
		}
	while($row = mysql_fetch_row($result1))
		 {  	
		    
			$pedido[0] = 2;
			$pedido[1] = $row;
			$resultados[$i] = $pedido;
			$i++;
				
		}
	while($row = mysql_fetch_row($result2))
		 {  	
		    
			$pedido[0] = 3;
			$pedido[1] = $row;
			$resultados[$i] = $pedido;
			$i++;
				
		}		



for ($j = $inicial ; $j < ($inicial + $cantidad ) ; $j++ )
		{	

			$pedido = $resultados[$j];		
			$row= $pedido[1];
			switch($pedido[0])
				{
				case 1: 
					    //Visualizacion de los pedidos en curso
						Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes , $esAdmin);?></td></tr>
						<tr> <td align='center'><p align="center">
							<form name="form3" method="POST">	
								<input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>' , 1)">
									<? if ($dedonde!=1) { ?>	<!-- if 11 -->
											<input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
									<? }  ?><!-- end if 11 -->
								<input type="hidden" name="Modo">
								<input type="hidden" name="Lista">
							</form></p>
						</tr></td></table><br><? 
						break;

				case 2: 
						//Visualizacion de los pedidos historicos
						echo " <table align='center' width='90%' border=1 bordercolor='green'> <tr><td align='center' width='90%'  >";
						 Dibujar_Tabla_Comp_Hist_Ped ($VectorIdioma,$row,$Mensajes,1,$esAdmin); ?>
					    <center><div>
						<table border='0' width='100%' align='center' cellpadding='0' cellspacing='1'  bgcolor="<? echo Devolver_Color($row[4]);?>" ><tr><td align='center' ><input type="button" class="style22" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'nada','<? echo $row[2].",".$row[3]; ?>',0)"></td></tr></table></div></center></td></tr></table><br><?
						break;

				case 3: 
					     //Visualizacion de los pedidos anulados
					     Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$Mensajes , $esAdmin,1);?>
						 </td></tr><tr><td align='center' > 		 
						 <form name="form3" method="POST"> 
						  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
						  <input type="button" value="<? echo $Mensajes["bot-5"]; ?>" name="B3"  class="style22" OnClick="vent_anula('<? echo $row[1]; ?>')">
						  </p>
						 <input type="hidden" name="Modo">
						 </form></td></tr></table><br><?						
						 break;
								
				} //end switch
				
		}//end for

   
   
   MostrarPaginado($url , $cantidad_pedidos , $pagina_actual, $inicial  , $cantidad);
   


}// end  Busqueda_Autor



function Busqueda_Pedido_Por_Codigo($Codigo , $dedonde , $Id_usuario ,$VectorIdioma , $Mensajes, $Bibliotecario = 0, $esAdmin=0){
	
	//Posicion de numeros.
	
	$PrimerLugar=strpos($Codigo,'-',0);
	$SegundoLugar=strpos($Codigo,'-',$PrimerLugar+1);
	$Numero = substr($Codigo,$SegundoLugar+1,(strlen($Codigo)-$SegundoLugar-1));
	$Counter= 7 - (strlen($Codigo)-$SegundoLugar);
	for ($i=0;$i<=$Counter;$i++)
		{
		$Numero="0".$Numero;
		}
	$Codigo = substr($Codigo,0,$SegundoLugar+1).$Numero;
	//$caja=1;
	$query = armar_expresion_busqueda();
	$query .=" WHERE Pedidos.Id='".$Codigo."'";
	if ($dedonde==1){
			 $query2 .= " AND Codigo_Usuario= ".$Id_usuario;
		}
	$result = mysql_query($query);   
	$caja=1;
	//echo $query;
	if (mysql_num_rows($result)==0)
		{
			// Implica que no lo encontró dentro de los pedidos
			// corrientes, con lo que lo busco en anulados y sino en históricos
			$caja = 3;
			$query1 = armar_expresion_busqueda_anula();
			$query1 .= "WHERE PedAnula.Id='".$Codigo."'";
			$result = mysql_query($query1);
					 
			if (mysql_num_rows($result)==0)
				{
					$caja = 2;
					$query2= armar_expresion_busqueda_hist();
					$query2 .= "WHERE PedHist.Id='".$Codigo."'";
					$result = mysql_query($query2);
					if (mysql_num_rows($result)==0)
						{
						$caja=1;
						}
				}
		}

	echo mysql_error();
	$color = Determinar_Color_Encabezado($caja);?>

    <div align="left"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC"><tr><td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"><?echo $Mensajes["et-9"];?>:<span class="style35"><? echo mysql_num_rows($result);?> </span></td></tr></table></div>
    <br><?
  	while($row = mysql_fetch_row($result))
		 {
			switch ($caja) {
					case 1:
							Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$Mensajes,$esAdmin);
							echo "</td></tr><tr><td align='center'>";
							break;
					case 2:
							Dibujar_Tabla_Comp_Hist_Ped ($VectorIdioma,$row,$Mensajes,$esAdmin);
							echo "<table border='0' width='95%' align='center' cellpadding='0' cellspacing='1' bgcolor='#ECECEC'><tr><td align='center'>";
							break;
					case 3:	 
							Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$Mensajes,$esAdmin);
							echo "</td></tr><tr><td align='center'>";
							break;
			}?>
		   <p align="center">
				<form name="form3" method="POST">
				<input type="button" class="style43" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>',<? echo $caja; ?>)">
									   
			<?
			if ($caja==1)
					{?>
					<input type="button" class="style43" value="<? echo $Mensajes["bot-3"]; ?>" name="B1"  OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> 
					<input type="button" class="style43" value="<? echo $Mensajes["bot-7"]; ?>" name="B1"  OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> <?
					}
			if ($caja==3)
					{?>	
					<input type="button" class="style43" value="<? echo $Mensajes["bot-5"]; ?>" name="B1" OnClick="vent_anula('<? echo $row[1]; ?>')"><?
					}
			if ($caja==2)
					{ ?>
					<input type="button" class="style43" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'nada','<? echo $row[2].",".$row[3]; ?>',0)"><?
 				    }?>
		  <input type="hidden" name="Modo">									 
	      <input type="hidden" name="caja" value="<? echo $caja;?>">
		 </form></p>
									
		<?								
		echo "</td></tr></table>";
	}
									 




}// end  Busqueda_Pedido_Por_Codigo


function  MostrarPaginado($url , $total , $pg, $inicial , $cantidad){


$decena_actual= intval( $pg / 10);

if ($decena_actual ==0)
		     $decena_actual = 0.1; // Para el caso de que este el la decena 0

$desde = $decena_actual * 10; // Calculo de la pagina inicial
$fin_decena= $desde + 9;
$pages = ceil($total / $cantidad);
echo "<div align='center'> ";
if ($pages > $fin_decena)
		$hasta= $fin_decena;
	else
		$hasta = $pages;
if ($pg > 1)
					{
						$urll = $pg - 1;
						echo "<a class='paginado'  href='".$url."&pg=".$urll."'> &lt;&lt;&nbsp;</a>";
					}

if ($decena_actual > 0.1)
					{
						echo "<a id='paginado' href='".$url."&pg=1'>1</a>&nbsp;| <font color='black'>..</font> |&nbsp;";
					}
for ($i = $desde; $i<=$hasta ; $i++) {
		if ($i == $pg)  
			{   
				if ($total > $cantidad)
					echo "<strong>$i</strong>";					
			}
		else 
			{
				echo "<a id='paginado' href='".$url."&pg=".$i."'>".$i."</a>&nbsp;";
			}
		if (($i+1) <= $hasta ){
				echo "&nbsp;|&nbsp;";
			}
	}

if ($pg < $pages) 
	{

		if ($pages > 10)
			if ($decena_actual <  intval( $pages / 10) )
						{
							echo "&nbsp;| <font color='black'>..</font> | <a id='paginado'   href='".$url."&pg=".$pages."'>&nbsp;".$pages."</a>";
						}
		$urll = $pg + 1;
		echo "<a id='paginado'   href='".$url."&pg=".$urll."'>&gt;&gt;</a>";

	}

/*if ($decena_actual < 10)
					{
						echo "<a id='paginado' href='".$url."&pg=".$1."'>1 .. </a>&nbsp;";

					}*/
echo '</div><br>';
}
?>