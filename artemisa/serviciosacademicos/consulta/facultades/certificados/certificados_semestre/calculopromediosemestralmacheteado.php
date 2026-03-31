<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
///////////////////////////////////// PROMEDIO SEMESTRAL PERIODO ANTERIORES A PRECIERRE /////////////////

  if($indicadorulas == 1)
    {
      if($solicitud_historico['codigoindicadorcredito'] == 100)
         {
           $notatotal = $notatotal + ($row_materiaperiodo['nota'] * ($solicitud_historico['numerocreditos'] * 48)) ;
           $creditos = $creditos + ($solicitud_historico['numerocreditos'] * 48);
         }
      else
        {
           if ($row_materiaperiodo['nota'] > 5)
           {
            $row_materiaperiodo['nota'] = $row_materiaperiodo['nota']  / 100;
           }

           $notatotal = $notatotal + ($row_materiaperiodo['nota']  * $solicitud_historico['total']) ;
           $creditos  = $creditos  + $solicitud_historico['total'];
        }
     }
    else
     {
           $notatotal = $notatotal + ($row_materiaperiodo['nota'] * $solicitud_historico['numerocreditos']) ;
           $creditos = $creditos + $solicitud_historico['numerocreditos'];
     }

if($creditos != "")
{
    //$promediosemestralperiodo = $notatotal/$creditos;
    //$promediosemestralperiodo = redondeo ($promediosemestralperiodo);

    @$promediosemestralperiodo = (round($notatotal/$creditos,2));
    //echo "acumuladosperiodo ->&nbsp;".$promediosemestralperiodo."<br>";
    $promediosemestralperiodo=round($promediosemestralperiodo * 10)/10;
}
//echo "acumuladosperiodo ->&nbsp;".$promediosemestralperiodo."<br>";

?>