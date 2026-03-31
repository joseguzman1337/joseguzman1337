<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();

if (!$_SESSION['MM_Username'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }

require_once('../../funciones/funcionip.php' );
$ip = "SIN DEFINIR";
$ip = tomarip();
$codigomateria = $_GET['materia'];
$estadonotahistorico = 100;
$idlinea = 0;

   if (!$_SESSION['codigofacultad'])
     {
        $usuario = "Manejo Sistema";
       $codigousuario = '145';
     }
    else
     {
       $usuario = $_SESSION['MM_Username'];
       $codigousuario = $_SESSION['codigofacultad'];
     }
     
     //echo '$usuario->'.$usuario;die;

if(isset($_GET['notas'])){
            $query_historico = "SELECT *
            from notahistorico n
            where n.codigoestudiante = '".$codigoestudiante."'
            and n.codigoperiodo = '".$periodo."'
            and n.codigomateria = '".$codigomateria."'
            and n.codigoestadonotahistorico like '1%'";
           $historico = mysql_query($query_historico, $sala) or die(mysql_error());
           $row_historico = mysql_fetch_assoc($historico);
           $totalRows_historico = mysql_num_rows($historico);


        if ($row_historico <> "")
          {
            $notahistorico = $row_historico['notadefinitiva'];
            $grupo = $row_historico['idgrupo'];
            //$electivahistorico = $row_historico['codigomateriaelectiva'];

            if ($row_historico['notadefinitiva'] > $_GET['notas'])
            {
                echo '<script language="JavaScript">alert("La nota actual es '.$row_historico['notadefinitiva'].'")</script>';
                $estadonotahistorico = 200;
            }
           else
            {
             $base="update notahistorico
             set codigoestadonotahistorico ='200'
             where codigoperiodo = '".$periodo."'
             and codigomateria = '".$codigomateria."'
             and codigoestudiante = '".$codigoestudiante."'";
              $sol=mysql_db_query($database_sala,$base) or die($base.mysql_error());
            }
          }

         else

          {

            $notahistorico = "0.0";

            $grupo = 1;

            //$electivahistorico = 1;

          }

        $tipomateria = $_GET['tipomateria'];

        $planestudio = $_GET['planestudiante'];


        $nota = $_GET['notas'];

        $insertSQL5 = "INSERT INTO auditoria (numerodocumento,usuario,fechaauditoria,codigomateria,grupo,codigoestudiante,notaanterior,notamodificada,corte,tipoauditoria,observacion,ip)";
        $insertSQL5.= "VALUES(
        '".$codigousuario."',
        '".$usuario."',
        '".date("Y-m-j G:i:s",time())."',
        '".$codigomateria."',
        '".$grupo."',
        '".$_GET['codigoestudiante']."',
        '".$notahistorico."',
        '".$nota."',
        '1',
        '20',
        '".$_GET['observacion']."',
        '$ip')";
        //echo 'SQL_Auditoria->'.$insertSQL5;die;
        mysql_select_db($database_sala, $sala);
         $Result1 = mysql_query($insertSQL5, $sala) or die(mysql_error());
         $observacion = $_GET['observación'];
        if ($_GET['materiaelectiva'] == 0 or $_GET['materiaelectiva'] == "")

         {

          $electivahistorico = 1;



         }

        else

         {
                    $electivahistorico = $codigomateria;

          $codigomateria = $_GET['materiaelectiva'];



           $query_Recordset ="select idlineaenfasisplanestudio

                         from detallelineaenfasisplanestudio

                         where codigomateriadetallelineaenfasisplanestudio = '$codigomateria'

                         and idplanestudio = '$planestudio'

                         and codigoestadodetallelineaenfasisplanestudio LIKE '1%'";

               //echo $query_Recordset,"</br>";

              $Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());

              $row_Recordset = mysql_fetch_assoc($Recordset);

              $totalRows_Recordset = mysql_num_rows($Recordset);

           if ($row_Recordset <> "")

            {

             $idlinea = $row_Recordset['idlineaenfasisplanestudio'];

            }

           else

            {

             $idlinea = 1;
            }



         }

        if ($idlinea == 0)

          {

            $idlinea = 1;
            //$planestudio = 1;
          }

         if ($tipomateria == 0)

          {

            $tipomateria = 1;

          }

        $query_historico2 = "SELECT *

                     from notahistorico n

                     where n.codigoestudiante = '".$codigoestudiante."'

                     and n.codigoperiodo = '".$periodo."'

                     and n.codigomateria = '".$codigomateria."'

                     and n.codigotiponotahistorico = '".$_GET['tiponota']."'

                     and n.codigoestadonotahistorico like '1%'";

        $historico2 = mysql_query($query_historico2, $sala) or die(mysql_error());

        $row_historico2 = mysql_fetch_assoc($historico2);

        $totalRows_historico2 = mysql_num_rows($historico2);

        if (!$row_historico2)

         {

           $query_detalleprematricula = "SELECT m.notaminimaaprobatoria,d.idprematricula

                                     from prematricula p,detalleprematricula d,materia m

                                     where p.codigoestudiante = '".$codigoestudiante."'

                                     and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'

                                     and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')

                                     and p.idprematricula = d.idprematricula

                                     and d.codigomateria = m.codigomateria

                                     and d.codigomateria = '".$codigomateria."'";



        $detalleprematricula = mysql_query($query_detalleprematricula, $sala) or die(mysql_error());

        $row_detalleprematricula = mysql_fetch_assoc($detalleprematricula);

        $totalRows_detalleprematricula = mysql_num_rows($detalleprematricula);


        if($planestudio == '')
        {
            $query_modalidad = "SELECT c.codigomodalidadacademica
            from carrera c, estudiante e
            where e.codigoestudiante = '".$codigoestudiante."'
            and e.codigocarrera = c.codigocarrera
            and c.codigomodalidadacademica like '400'";
            $modalidad = mysql_query($query_modalidad, $sala) or die(mysql_error());
            $row_modalidad = mysql_fetch_assoc($modalidad);
            $totalRows_modalidad = mysql_num_rows($modalidad);
            if($totalRows_modalidad > 0)
                $planestudio = 1;
        }


         $sql = "insert into notahistorico(idnotahistorico,codigoperiodo,codigomateria,codigomateriaelectiva,codigoestudiante,notadefinitiva,codigotiponotahistorico,origennotahistorico,fechaprocesonotahistorico,idgrupo,idplanestudio,idlineaenfasisplanestudio,observacionnotahistorico,codigoestadonotahistorico,codigotipomateria)";

         $sql.= "VALUES('0','".$_GET['periodo']."','".$codigomateria."','".$electivahistorico."','".$_GET['codigoestudiante']."','".$nota."','".$_GET['tiponota']."','10','".date("Y-m-d",time())."','".$grupo."','".$planestudio."','".$idlinea."','".$_GET['observacion']."','".$estadonotahistorico."','".$tipomateria."')";

         //echo $sql,"</br>";

         //exit();

         $result = mysql_query($sql,$sala) or die("$sql".mysql_error());

        }

  }else{
    
   

$query_historico = "SELECT * ,n.codigoperiodo as periodo

                    FROM notahistorico n,materia m,estadonotahistorico e

                    WHERE n.idnotahistorico = '".$_GET['idhistorico']."'

                    AND e.codigoestadonotahistorico = n.codigoestadonotahistorico

                    AND m.codigomateria = n.codigomateria

";

//echo $query_historico;die;

//exit();

$historico = mysql_query($query_historico, $sala) or die(mysql_error());

$row_historico = mysql_fetch_assoc($historico);

$totalRows_historico = mysql_num_rows($historico);

$f= 1;

//do {

  $nota = $_GET['nota'];

   $insertSQL5 = "INSERT INTO auditoria (numerodocumento,usuario,fechaauditoria,codigomateria,grupo,codigoestudiante,notaanterior,notamodificada,corte,tipoauditoria,observacion,ip)";
        $insertSQL5.= "VALUES(
        '".$codigousuario."',
        '".$usuario."',
        '".date("Y-m-j G:i:s",time())."',
        '".$row_historico['codigomateria']."',
        '".$row_historico['idgrupo']."',
        '".$row_historico['codigoestudiante']."',
        '".$row_historico['notadefinitiva']."',
        '".$nota."',
        '1',
        '20',
        '".$_GET['nombretiponotahistorico']." - ".$_GET['observacion']."',
        '$ip')";
        
        mysql_select_db($database_sala, $sala);
        $Result1 = mysql_query($insertSQL5, $sala) or die(mysql_error());
        
        
        $sql='SELECT idcorte FROM corte WHERE codigoperiodo ="'.$row_historico['periodo'].'" AND codigocarrera ="'.$row_historico['codigocarrera'].'"  AND (codigomateria=1 OR codigomateria="'.$row_historico['codigomateria'].'")';
        
        
        $SQL_SELECt = mysql_query($sql, $sala) or die(mysql_error());
        
        
       while($data = mysql_fetch_array($SQL_SELECt)){
        
        
        $SQL_Inactiva='UPDATE detallenota
                       SET  codigoestado =200
                       WHERE idcorte="'.$data['idcorte'].'" AND codigoestudiante="'.$row_historico['codigoestudiante'].'" AND codigomateria="'.$row_historico['codigomateria'].'"';
                       
              $EjecutaSQL = mysql_query($SQL_Inactiva, $sala) or die(mysql_error());         

       } 
        
        
        
          $base="update notahistorico  set

                notadefinitiva ='".$nota."',

                codigotiponotahistorico = '".$_GET['tiponota']."',

                codigoestadonotahistorico =  '".$_GET['estadonota']."',

                observacionnotahistorico = '".$_GET['observacion']."'

                where idnotahistorico = '".$_GET['idhistorico']."'";



        $sol=mysql_db_query($database_sala,$base);



    //$f++;

//}while($row_historico = mysql_fetch_assoc($historico));

}//else



//exit();

/*if(isset($_GET['notas']))

  {

    echo '<script language="JavaScript">window.location.href="modificahistoricoformulario.php?codigoestudiante='.$codigoestudiante.'&periodo='.$periodo.'";</script>';

  }*/

unset($_GET['notas']);
?>
