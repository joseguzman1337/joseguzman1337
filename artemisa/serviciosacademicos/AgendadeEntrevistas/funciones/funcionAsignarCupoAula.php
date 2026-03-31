<?php 
/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Ajuste de formulario y creacion de horarios de Entrevistas para los programas de Postgrados y Educacion Virtual.
 * @since Abril 17, 2018.
*/ 
require_once('../../../serviciosacademicos/Connections/sala2.php');
require('../../../serviciosacademicos/funciones/funcionpassword.php');
$rutaado = '../../../serviciosacademicos/funciones/adodb/';
require_once('../../../serviciosacademicos/Connections/salaado.php');

session_start();

include_once('../../../serviciosacademicos/utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
    
$user = $_SESSION['usuario'];
$rol = $_SESSION['rol'];

//Buscar el id del usuario con el que esta logueado.
$SQL_usuario = "SELECT idusuario FROM usuario WHERE usuario = '$user'";
$identificadorUsuario = $db->GetRow($SQL_usuario);
       
$idUsuario = $identificadorUsuario['idusuario'];
$hoy = date("Y-m-d");
switch($_POST['action']){

     case 'Modalidad':
        {
            // Obtener modalidades de pregrado y postgrado.
            $sql_moda = "SELECT codigomodalidadacademica, nombremodalidadacademica
            FROM modalidadacademica
            WHERE codigoestado = 100
            AND codigomodalidadacademica IN (200,300,800)
            ORDER BY nombremodalidadacademica";
            $datosmodalidad = $db->GetAll($sql_moda); 
            
            $selectmodalidadhtml="<option value='1'>Seleccione...</option>";
            
            foreach ($datosmodalidad as $modalidad) {
            $selectmodalidadhtml.="<option value='".$modalidad['codigomodalidadacademica']."'>".$modalidad['nombremodalidadacademica']."</option>";
            }
            
            echo $selectmodalidadhtml;
            }
    break;   
        
    case 'Carrera':
        {
       $Modalidad = $_POST['moda'];
       
        //Lista las carreras activas de pregrado y posgrado de acuerdo a las carreras de cada usuario.
        $SQL_carerra = "SELECT c.codigocarrera, c.nombrecarrera,c.fechavencimientocarrera FROM carrera c";
        $SQL_carerrab = " WHERE c.codigomodalidadacademica = '$Modalidad' AND c.fechavencimientocarrera > NOW() AND c.codigocarrera <> '1' ";
        $SQL_carerrab.= " ORDER BY c.nombrecarrera";
        /*
         * Caso 101092
         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
         * Los roles usuarios con roles (13,49,84) tienen acceso a programar entrevistas de todas las modalidades y carreras.
         * @since Junio 8, 2018.
         */     
    
        switch ($rol) {
            case 13:
            case 49:
            case 84:
            $SQL_carerra.=$SQL_carerrab;    
            break;
                default: 
                    $usuario = " INNER JOIN usuariofacultad uf ON c.codigocarrera = uf.codigofacultad AND uf.usuario= '$user' ";
                    $SQL_carerra.= $usuario.$SQL_carerrab;
                break;
        }
        //End Caso 101092.
          $selectcarrerahtml="";
          $carreras = $db->GetAll($SQL_carerra); 
          $selectcarrerahtml.= "<option value=''>Seleccione...</option>";
		  foreach($carreras as $ListaCarrera){
          $selectcarrerahtml.= '<option value="'.$ListaCarrera['codigocarrera'].'">'.$ListaCarrera['nombrecarrera'].'</option>';
          }
          echo $selectcarrerahtml;
        }
    break; 
    
    case 'Aula':
        {
          //Lista los salones activos creados para las Entrevistas.
          $SQL_aula = "SELECT se.SalonEntrevistasId, se.NombreSalonEntrevistas FROM SalonEntrevistas se WHERE se.Estado='100' ORDER BY se.NombreSalonEntrevistas";
       
          $aulas = $db->GetAll($SQL_aula);
          
          $selectaulahtml.= "<option value=''>Seleccione...</option>";    
          
          foreach($aulas as $ListaAula){
          $selectaulahtml.= '<option value="'.$ListaAula['SalonEntrevistasId'].'">'.$ListaAula['NombreSalonEntrevistas'].'</option>';
          } 
          echo $selectaulahtml;    
        }
    break;    
    case 'Responsable':
        {
            $SQL_responsable = "SELECT rec.ResponsableEntrevistaCarrreraId , CONCAT(rec.NombresResponsable,' ',rec.ApellidosResponsable) AS 'NombreResponsable'
            FROM ResponsableEntrevistaCarrera rec
            WHERE 
            rec.EstadoResponsable = '100'
            ORDER BY rec.NombresResponsable";
            $responsable = $db->GetAll($SQL_responsable);
    
            
            $selectresponsablehtml.= "<option value=''>Seleccione...</option>";   
            
            foreach($responsable as $ListaResponsable){
                $selectresponsablehtml.= '<option value="'.$ListaResponsable['ResponsableEntrevistaCarrreraId'].'">'.$ListaResponsable['NombreResponsable'].'</option>';
            }
            echo $selectresponsablehtml;
        }
    break;   
        
    case 'Consultar':
        {
        $Carrera = $_POST['carrera'];
        $Modal = $_POST['modal'];
        $Salon = $_POST['aula'];   
        
        
        if($Carrera <>'' AND $Salon <>'' AND $Modal <>''){
          $ModalidadC = "AND c.codigomodalidadacademica = '".$Modal."' ";
          $CarreraC = "AND cs.CodigoCarrera = '".$Carrera."'"; 
          $SalonC = "AND cs.SalonEntrevistasId = '".$Salon."'";
            
        }else
        if($Carrera <>''){
            $CarreraC = "AND cs.CodigoCarrera = '".$Carrera."'"; 
        }else 
            if($Carrera =='' AND $Salon <>''){
               $SalonC = "AND cs.SalonEntrevistasId = '".$Salon."'";  
            }else
                if($Modal <>'' AND $Carrera ==''){
                 $ModalidadC = "AND c.codigomodalidadacademica = '".$Modal."' "; 
                }
         //Lista las carreras activas de pregrado y posgrado de acuerdo a las carreras de cada usuario.
          $SQL_cupoAulas = " SELECT
	           cs.CarreraSalonId,
	           c.nombrecarrera,
	           se.NombreSalonEntrevistas,
	           CONCAT(rec.NombresResponsable,' ',rec.ApellidosResponsable) AS 'NombreResponsable',
	           cs.CupoEstudiante
            FROM
	           CarreraSalones cs
               INNER JOIN SalonEntrevistas se ON se.SalonEntrevistasId = cs.SalonEntrevistasId
               INNER JOIN carrera c ON c.codigocarrera = cs.CodigoCarrera ";
          $SQL_cupoAulasb = " INNER JOIN ResponsableEntrevistaCarrera rec ON cs.ResponsableEntrevistaCarrreraId = rec.ResponsableEntrevistaCarrreraId  $Cons       
            WHERE
	           cs.EstadoCarreraSalon = '100' $CarreraC $SalonC $ModalidadC  
            ORDER BY
	           c.nombrecarrera ";
        /*
         * Caso 101092
         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
         * Los roles usuarios con roles (13,49,84) tienen acceso a programar entrevistas de todas las modalidades y carreras.
         * @since Junio 8, 2018.
        */     
        switch ($rol) {
            case 13:
            case 49:
            case 84:
            $SQL_cupoAulas.=$SQL_cupoAulasb;
            break;
                default: 
                    $usuario = " INNER JOIN usuariofacultad uf ON c.codigocarrera = uf.codigofacultad AND uf.usuario= '$user' ";
                    $SQL_cupoAulas.= $usuario.$SQL_cupoAulasb;
                break;
        }
       //End Caso 101092.
            $cupos = $db->GetAll($SQL_cupoAulas);
            
            if(count($cupos)>0){
    
            $html = "";
            $i=1;    

            foreach ($cupos as $listaAulas) {

              $html.= "<tr>";
              $html.= "<td>".$i."</td>";
              $html.= "<td id="."a_".$listaAulas['CarreraSalonId'].">".$listaAulas['nombrecarrera']."</td>";
              $html.= "<td id="."b_".$listaAulas['CarreraSalonId'].">".$listaAulas['NombreSalonEntrevistas']."</td>";
              $html.= "<td id="."b1_".$listaAulas['CarreraSalonId'].">".$listaAulas['NombreResponsable']."</td>";        
              $html.= "<td id="."c_".$listaAulas['CarreraSalonId'].">".$listaAulas['CupoEstudiante']."</td>";
              $html.= "<td><p><a  href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='emergenteActualizar(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-success actualizar'>
              <span class='glyphicon glyphicon-pencil text-success'>Editar</span></a></p></td>";
                
              $carreraSalonId = $listaAulas['CarreraSalonId'];
              
              $SQL_existeEntrevista = "SELECT EntrevistaId
              FROM Entrevistas 
              WHERE CarreraSalonId = '$carreraSalonId'
              AND EstadoEntrevista = 100
              AND FechaEntrevista >= '$hoy'";
                      
              $existeEntrevista = $db->GetRow($SQL_existeEntrevista);
              if($existeEntrevista){
                    $html.= "<td><p><a href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='noEliminar(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-danger'>
                    <span class='glyphicon glyphicon-trash text-danger'>Eliminar</span></a></p></td>";    
                  
                    $html.= "<td><p><a href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='SoloConsultarEntrevistas(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-success'>
                    <span class='glyphicon glyphicon-eye-open text-success'>Ver Horario Grafica</span></a></p></td>";
                  
                    $html.= "<td><p><a href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='creaEntrevista(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-success'>
                    <span class='glyphicon glyphicon-ok text-success'>Horarios</span></a></p></td>"; 
              }else{
                $html.= "<td><p><a href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='eliminar(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-danger'>
                <span class='glyphicon glyphicon-trash text-danger'>Eliminar</span></a></p></td>";    
                
                $html.= "<td><p><a href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='SoloConsultarEntrevistas(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-success'>
                <span class='glyphicon glyphicon-eye-open text-success'>Ver Horario Grafica</span></a></p></td>";  
                  
                $html.= "<td><p><a href= '#' id=".$listaAulas["CarreraSalonId"]."  onclick='creaEntrevista(".$listaAulas["CarreraSalonId"].")' class='btn btn-default bg-success'>
                <span class='glyphicon glyphicon-ok text-success'>Horarios</span></a></p></td>"; 
              }    
            $i++;
            }//Foreach
         
            echo $html;    
        }else{
            echo "No hay Resultados.";
        }
        }
    break;
    
   case 'ConsultarEditar':
        {
            $html = "";
            $CarreraSalon = $_POST['idCarreraSalon'];
            
            $SQL_cosultaAulas = "SELECT
                cs.CarreraSalonId,
                c.codigocarrera,
                c.nombrecarrera,
                se.SalonEntrevistasId,
                se.NombreSalonEntrevistas,
                rec.ResponsableEntrevistaCarrreraId,
                CONCAT(rec.NombresResponsable,' ',rec.ApellidosResponsable) AS 'NombreResponsable',
                cs.CupoEstudiante
            FROM
	           CarreraSalones cs
               INNER JOIN SalonEntrevistas se ON se.SalonEntrevistasId = cs.SalonEntrevistasId
               INNER JOIN carrera c ON c.codigocarrera = cs.CodigoCarrera
               INNER JOIN ResponsableEntrevistaCarrera rec ON cs.ResponsableEntrevistaCarrreraId = rec.ResponsableEntrevistaCarrreraId
            WHERE cs.EstadoCarreraSalon = 100
            AND cs.CarreraSalonId= '$CarreraSalon'";
            
            $resultadoAulas = $db->GetRow($SQL_cosultaAulas);
           
            $codigoCarrera = $resultadoAulas['codigocarrera'];
            $codigoSalonEntrevistas = $resultadoAulas['SalonEntrevistasId'];
            $codigoResponsableEntrevistas = $resultadoAulas['ResponsableEntrevistaCarrreraId'];
            $cupoEstudiante = $resultadoAulas['CupoEstudiante'];
            
            $SQL_Modalidad = "SELECT c.codigomodalidadacademica FROM carrera c WHERE c.codigocarrera = '$codigoCarrera' ";
            $ResMod = $db->GetRow($SQL_Modalidad);
            $Modal = $ResMod['codigomodalidadacademica'];
            
             //Lista las carreras activas de pregrado y posgrado de acuerdo a las carreras de cada usuario.
          $SQL_carerra = "SELECT c.codigocarrera, c.nombrecarrera,c.fechavencimientocarrera FROM carrera c";
          $SQL_carerrab = " WHERE c.codigomodalidadacademica = '$Modal' AND c.fechavencimientocarrera > NOW() AND c.codigocarrera <> '1'";
          $SQL_carerrab.= " ORDER BY c.nombrecarrera";      
            
           /*
            * Caso 101092
            * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
            * Los roles usuarios con roles (13,49,84) tienen acceso a programar entrevistas de todas las modalidades y carreras.
            * @since Junio 8, 2018.
           */     
            switch ($rol) {
                case 13:
                case 49:
                case 84:
                $SQL_carerra.=$SQL_carerrab;
                break;
                    default: 
                        $carreras = " INNER JOIN usuariofacultad uf ON c.codigocarrera = uf.codigofacultad AND uf.usuario= '$user' ";
                        $SQL_carerra.= $carreras.$SQL_carerrab;
                    break;
            }
            //End Caso 101092.    
            $carreras = $db->GetAll($SQL_carerra); 
            
            $html.='<form id="formActualizar" name="formActualizar">
                        <div class="form-group">
                          <label for="programa_academicoM">Programa Académico</label>
                          <select id="programa_academicoM" name="programa_academicoM"class="form-control">';
                        foreach($carreras as $ListaCarrera){
                            if( $codigoCarrera == $ListaCarrera['codigocarrera']){
                                $html.= '<option value="'.$ListaCarrera['codigocarrera'].'" selected>'.$ListaCarrera['nombrecarrera'].'</option>';
                            }else{
                                $html.= '<option value="'.$ListaCarrera['codigocarrera'].'">'.$ListaCarrera['nombrecarrera'].'</option>';
                            }
                        }
            $html.='</select><div>';
            
            $SQL_aula = "SELECT se.SalonEntrevistasId, se.NombreSalonEntrevistas FROM SalonEntrevistas se WHERE se.Estado='100' ORDER BY se.NombreSalonEntrevistas";
            $aulas = $db->GetAll($SQL_aula);
            
            $html.='<div class="form-group">
                          <label for="aulaM">Aula</label>
                          <select id="aulaM" name="aulaM" class="form-control">';
                        foreach($aulas as $ListaAulas){
                            if( $codigoSalonEntrevistas == $ListaAulas['SalonEntrevistasId']){
                                    $html.= '<option value="'.$ListaAulas['SalonEntrevistasId'].'" selected>'.$ListaAulas['NombreSalonEntrevistas'].'</option>';
                            }else{
                                    $html.= '<option value="'.$ListaAulas['SalonEntrevistasId'].'">'.$ListaAulas['NombreSalonEntrevistas'].'</option>';
                            }
                        }
            $html.='</select><div>';
            
            $SQL_responsableEditar = "SELECT rec.ResponsableEntrevistaCarrreraId , CONCAT(rec.NombresResponsable,' ',rec.ApellidosResponsable) AS 'NombreResponsable'
            FROM ResponsableEntrevistaCarrera rec
            WHERE rec.EstadoResponsable = '100' ORDER BY rec.NombresResponsable";
            $responsableEditar = $db->GetAll($SQL_responsableEditar);
            
            $html.='<div class="form-group">
                    <label for="responsableM">Responsable</label>
                    <select id="responsableM" name="responsableM" class="form-control">';
                        foreach($responsableEditar as $ListaResponsable){
                            if( $codigoResponsableEntrevistas == $ListaResponsable['ResponsableEntrevistaCarrreraId']){
                                    $html.= '<option value="'.$ListaResponsable['ResponsableEntrevistaCarrreraId'].'" selected>'.$ListaResponsable['NombreResponsable'].'</option>';
                            }else{
                                    $html.= '<option value="'.$ListaResponsable['ResponsableEntrevistaCarrreraId'].'">'.$ListaResponsable['NombreResponsable'].'</option>';
                            }
                        }
            $html.='</select><div>';
                        
            $html.='<div class="form-group">
                          <label for="cupoM">Cupo</label>
                          <input type="text" class="form-control input-sm" id="cupoM" name="cupoM" value= "'.$cupoEstudiante.'" required>
                    </div>';                        
    
            $html.='</form';
         echo $html;    
        }
    break;
    
    case 'ConsultarEntrevistas':
        {
            $html = "";
            $idEntrevista= $_POST['identrevista'];
            
            $SQL_cosultaEntrevista = "SELECT EntrevistaId, FechaEntrevista, HoraInicio, HoraFin FROM Entrevistas 
            WHERE EntrevistaId = '$idEntrevista' AND EstadoEntrevista = 100";
            
            $resultadoEntrevista = $db->GetRow($SQL_cosultaEntrevista);
           
            $fechaEntrevista = $resultadoEntrevista['FechaEntrevista'];
            $HoraInicioEntrevista = $resultadoEntrevista['HoraInicio'];
            $HoraFinEntrevista = $resultadoEntrevista['HoraFin'];
                
       
          $html.='<form id="formActualizarEntrevista" name="formActualizarEntrevista">';
          $html.='<div class="form-group">
                          <label for="fecha_entrevistaM">Fecha Entrevista</label>
                          <input type="date" class="form-control input-sm" id="fecha_entrevistaM" name="fecha_entrevistaM" value= "'.$fechaEntrevista.'" required>
                  </div>';      
            
         $html.='<div class="form-group">
                       <label for="hora_inicialM">Hora Inicio</label>
                       <input type="time" class="form-control input-sm" id="hora_inicialM" name="hora_inicialM" value= "'.$HoraInicioEntrevista.'" required>
                 </div>';                        
         $html.='<div class="form-group">
                       <label for="hora_finalM">Hora Fin</label>
                       <input type="time" class="form-control input-sm" id="hora_finalM" name="hora_finalM" value= "'.$HoraFinEntrevista.'" required>
              </div>';   
    
         $html.='</form';
         echo $html;    
        }
    break;
            
    case 'CrearEntrevistas':
        {
        $carrreSalonId = $_POST['codCarreraSalon'];   
      
        $SQL_carreraSalon = "SELECT CarreraSalonId from CarreraSalones WHERE CarreraSalonId = '$carrreSalonId' AND EstadoCarreraSalon = 100;";
        $resultadoCarrrera = $db->GetRow($SQL_carreraSalon);
    
        $CarrreraSalon = $resultadoCarrrera['CarreraSalonId'];
        
        }
    break;
        
    case 'guardarEntrevista':
        {
         $CarrreraSalonInsert = $_POST['codcarrreraSalon']; 
         $fechaparaEntrevista = $_POST['fechaEntrevista'];    
         $horaInicialEntrevitas = $_POST['horaInicio'];    
         $horaFinalEntrevitas = $_POST['horaFin'];   
         $hoy = date("Y-m-d H:i:s");    
         $usuario= $idUsuario;
    
        $SQL_ExisteEntre= "SELECT EntrevistaId, FechaEntrevista, HoraInicio, HoraFin
        FROM Entrevistas
        WHERE
            EstadoEntrevista = '100'
        AND CarreraSalonId = '$CarrreraSalonInsert'
        AND FechaEntrevista = '$fechaparaEntrevista'
        AND HoraInicio = '$horaInicialEntrevitas'";
        $resultadoExiste = $db->GetRow($SQL_ExisteEntre);
        
        if($resultadoExiste){
        echo '0';
        }else
        if($horaInicialEntrevitas > $horaFinalEntrevitas){
        echo '2';    
        }else{
           $SQL_insertE ="INSERT INTO Entrevistas(
                CarreraSalonId,
                FechaEntrevista,
                HoraInicio,
                HoraFin,
                UsuarioCreacion,
                UsuarioUltimaModificacion,
                FechaCreacion,
                FechaUltimaModificacion,
                EstadoEntrevista
            )
            VALUES
                (
                '$CarrreraSalonInsert',
                '$fechaparaEntrevista',
                '$horaInicialEntrevitas',
                '$horaFinalEntrevitas',
                '$usuario',
                NULL,
                '$hoy',
                NULL,
                '100'
            )";
            
            if($db->Execute($SQL_insertE)==false){
                echo '<br />Error al insertar....<br><br>'.$SQL.' El error es: '.mysql_error();
            }else{
                echo '1';  
            }  
        }  
        }
    break;    
    case 'Guardar':
        {
        $Carrera = $_POST['carrera'];    
        $Aula = $_POST['aula'];     
        $Responsable = $_POST['responsable'];     
        $Cupo = $_POST['cupo']; 
        $hoy = date("Y-m-d H:i:s");
        
        //Lista los salones creados para una carrera para validar que no se asigne un mismo salon a una misma carrera.
        $SQL_Existe= "SELECT CodigoCarrera, SalonEntrevistasId
        FROM CarreraSalones
        WHERE CodigoCarrera = '$Carrera'
        AND SalonEntrevistasId ='$Aula'
        AND EstadoCarreraSalon = '100'";
        $resultadoExiste = $db->GetRow($SQL_Existe);
        
        if($resultadoExiste){
        echo '0';
        }else{
            $SQL_insert ="INSERT INTO CarreraSalones(
            SalonEntrevistasId,
            ResponsableEntrevistaCarrreraId,
            CodigoCarrera,
            CupoEstudiante,
            EstadoCarreraSalon,
            UsuarioCreacion,
            UsuarioUltimaModificacion,
            FechaCreacion,
            FechaUltimaModificacion
            )
            VALUES
               (
                '$Aula',
                '$Responsable',
                '$Carrera',
                '$Cupo',
                '100',
                '$idUsuario',
                '',
                '$hoy',
                ''
                )";
            if($db->Execute($SQL_insert)==false){
                echo '<br />Error al insertar....<br><br>'.$SQL.' El error es: '.mysql_error();
            }else{
                echo '1';  
            }  
        }  
 
    }
    break;
        
                
    case 'Modificar':
        {
        $IdCarreraSalon = $_POST['idCarreraSalon'];    
        $Carrera = $_POST['carreraM'];    
        $Aula = $_POST['aulaM'];
        $Responsable = $_POST['responsable'];
        $CupoMod = $_POST['cupoM']; 
        $hoy = date("Y-m-d H:i:s");
        
        $SQL_Existe= "SELECT CodigoCarrera, SalonEntrevistasId
        FROM CarreraSalones
        WHERE CodigoCarrera = '$Carrera'
        AND SalonEntrevistasId ='$Aula'
        AND CupoEstudiante = '$CupoMod'
        AND ResponsableEntrevistaCarrreraId = '$Responsable'
        AND EstadoCarreraSalon = '100'";
        $resultadoExiste = $db->GetRow($SQL_Existe);
        
        if($resultadoExiste){
        echo '0';
        }else{
        $SQL_update ="UPDATE CarreraSalones
        SET SalonEntrevistasId= '$Aula',
        ResponsableEntrevistaCarrreraId = '$Responsable',
        CodigoCarrera= '$Carrera',
        CupoEstudiante= '$CupoMod',
        UsuarioUltimaModificacion= '$idUsuario',
        FechaUltimaModificacion = '$hoy'
        WHERE
	       (CarreraSalonId= '$IdCarreraSalon')
        LIMIT 1"; 
       
        if($db->Execute($SQL_update)==false){
            echo '<br />Error en el Modificar....<br><br>'.$SQL.' El error es: '.mysql_error();
            
         }else{
            echo '1';  
            }   
        }
        
        }
    break;
    
    case 'ModificarEntrevistas':
    {
        $codEntrevista = $_POST['identrevista'];
        $codCarrreraSalon = $_POST['idcarrreraSalon'];
        $fechadeEntrevista = $_POST['fecha_entrevista'];    
        $HoraIniEntrevista = $_POST['hora_inicio'];    
        $HoraFiEntrevista = $_POST['hora_final'];
        $usuario= $idUsuario;
        $hoy = date("Y-m-d H:i:s");
        
        
    
       $SQL_ExisteEntrevista= "SELECT
            EntrevistaId,
            FechaEntrevista,
            HoraInicio,
            HoraFin
        FROM
           Entrevistas
        WHERE
	       FechaEntrevista = '$fechadeEntrevista'	
        AND HoraInicio = '$HoraIniEntrevista'
        AND HoraFin = '$HoraFiEntrevista'
        AND CarreraSalonId = '$codCarrreraSalon'
        AND EstadoEntrevista = 100";
            
        $resultadoExisteEntrevista = $db->GetRow($SQL_ExisteEntrevista);
        
        if($resultadoExisteEntrevista){
        echo '0';
        }else
        if($HoraIniEntrevista > $HoraFiEntrevista){
         echo '2';   
        }else{
        $SQL_updateEntrevista ="UPDATE Entrevistas
        SET FechaEntrevista = '$fechadeEntrevista',
            HoraInicio = '$HoraIniEntrevista',
            HoraFin = '$HoraFiEntrevista',
            UsuarioUltimaModificacion = '$usuario',
            FechaUltimaModificacion = '$hoy'
        WHERE
	       (EntrevistaId = '$codEntrevista')
        LIMIT 1"; 
     
      if($db->Execute($SQL_updateEntrevista)==false){
            echo '<br />Error en el Modificar....<br><br>'.$SQL.' El error es: '.mysql_error();
            
         }else{
            echo '1';  
            }   
        }
        
    }
    break;    
    case 'Eliminar':
        { 

       $IdCarreraSalon = $_POST['idCarreraSalon'];    
       $hoy = date("Y-m-d H:i:s");
        
       $SQL_Eliminar ="UPDATE CarreraSalones
        SET EstadoCarreraSalon= '300',
        UsuarioUltimaModificacion= '$idUsuario',
        FechaUltimaModificacion = '$hoy'
        WHERE
	       (CarreraSalonId= '$IdCarreraSalon')
        LIMIT 1"; 
       
         if($db->Execute($SQL_Eliminar)==false){
            echo '<br />Error en el Eliminar....<br><br>'.$SQL.' El error es: '.mysql_error();
            
         }else{
             echo "<script type=\"text/javascript\">alert(\"Los datos se Eliminaron Correctamente...\");</script>";  
             }
    }
    break;
    
    case 'ConsultarSalon':
        {
           //Lista los salones activos para las Entrevistas.
           $SQL_salones = "SELECT SalonEntrevistasId, NombreSalonEntrevistas 
            FROM SalonEntrevistas
            WHERE Estado = '100'";
            
            $salon = $db->GetAll($SQL_salones);
            $html = "";
            $i=1;    

            foreach ($salon as $listaSalones) {

              $html.= "<tr>";
              $html.= "<td>".$i."</td>";
              $html.= "<td id="."a_".$listaSalones['SalonEntrevistasId'].">".$listaSalones['NombreSalonEntrevistas']."</td>";
              
              $html.= "<td><p><a  href= '#' id=".$listaSalones["SalonEntrevistasId"]."  onclick='actualizarSalon(".$listaSalones["SalonEntrevistasId"].")' class='btn btn-default bg-success actualizar'>
              <span class='glyphicon glyphicon-pencil text-success'>Editar</span></a></p></td>";
                
              $html.= "<td><p><a href= '#' id=".$listaSalones["SalonEntrevistasId"]."  onclick='eliminarSalon(".$listaSalones["SalonEntrevistasId"].")' class='btn btn-default bg-danger'>
                <span class='glyphicon glyphicon-remove text-danger'>Eliminar</span></a></p></td></tr>";    
                  
              $i++;
            }//Foreach
         
            echo $html;       
        }
    break;   
    
    case 'ConsultarResponsables':
        {
        $nombresResponsable = $_POST['nombres'];
        $apellidosResponsable = $_POST['apellidos'];
        $correoResponsable = $_POST['correo'];
    
        if($nombresResponsable<>'' AND $apellidosResponsable<>'' AND $correoResponsable <>''){
              $Nombres = "AND re.NombresResponsable like ('%".$nombresResponsable."%')";   
              $Apellidos = "AND re.ApellidosResponsable like ('%".$apellidosResponsable."%')";                   
              $Correo = "AND re.CorreoResponsable = '".$correoResponsable."'";    
            }else
                if($nombresResponsable<>'' AND $apellidosResponsable<>'' AND $correoResponsable =='' ) {
                  $Nombres = "AND re.NombresResponsable like ('%".$nombresResponsable."%')";   
                  $Apellidos = "AND re.ApellidosResponsable like ('%".$apellidosResponsable."%')";                    
                } else
                    if($nombresResponsable<>'' AND $correoResponsable <>'' AND $apellidosResponsable==''){
                        $Nombres = "AND re.NombresResponsable like ('%".$nombresResponsable."%')"; 
                        $Correo = "AND re.CorreoResponsable = '".$correoResponsable."'";    
                    }else
                        if($apellidosResponsable<>'' AND $correoResponsable <>'' AND $nombresResponsable==''){
                           $Apellidos = "AND re.ApellidosResponsable like ('%".$apellidosResponsable."%')";    
                           $Correo = "AND re.CorreoResponsable = '".$correoResponsable."'";    
                        }else
                    if($nombresResponsable<>'' AND $correoResponsable =='' AND $apellidosResponsable==''){
                        $Nombres = "AND re.NombresResponsable like ('%".$nombresResponsable."%')"; 
                        }else
                        if($apellidosResponsable<>'' AND $correoResponsable =='' AND $nombresResponsable==''){
                           $Apellidos = "AND re.ApellidosResponsable like ('%".$apellidosResponsable."%')";    
                        }else
                         if($apellidosResponsable=='' AND $correoResponsable <>'' AND $nombresResponsable==''){
                           $Correo = "AND re.CorreoResponsable = '".$correoResponsable."'";    
                        }
                
                
            
           //Lista los Responsables activos para las Entrevistas.
           $SQL_Responsables = "SELECT re.ResponsableEntrevistaCarrreraId,	re.NombresResponsable AS 'Nombres', re.ApellidosResponsable AS 'Apellidos', re.CorreoResponsable AS 'CorreoElectronico', re.CorreoAlterno1,	re.CorreoAlterno2 
           FROM
	           ResponsableEntrevistaCarrera re
           WHERE
	           re.EstadoResponsable = '100' $Nombres $Apellidos $Correo";
    
           $responsables = $db->GetAll($SQL_Responsables);
        if(count($responsables)>0){
            $html = "";
            $i=1;    

            foreach ($responsables as $listaResponsables) {

              $html.= "<tr>";
              $html.= "<td>".$i."</td>";
              $html.= "<td id="."a_".$listaResponsables['ResponsableEntrevistaCarrreraId'].">".$listaResponsables['Nombres']."</td>";
              $html.= "<td id="."b_".$listaResponsables['ResponsableEntrevistaCarrreraId'].">".$listaResponsables['Apellidos']."</td>";
              $html.= "<td id="."b_".$listaResponsables['ResponsableEntrevistaCarrreraId'].">".$listaResponsables['CorreoElectronico']."</td>";
              $html.= "<td id="."b_".$listaResponsables['ResponsableEntrevistaCarrreraId'].">".$listaResponsables['CorreoAlterno1']."</td>";
              $html.= "<td id="."b_".$listaResponsables['ResponsableEntrevistaCarrreraId'].">".$listaResponsables['CorreoAlterno2']."</td>";
              
              $html.= "<td><p><a  href= '#' id=".$listaResponsables["ResponsableEntrevistaCarrreraId"]."  onclick='editarResponsable(".$listaResponsables["ResponsableEntrevistaCarrreraId"].")' class='btn btn-default bg-success actualizar'>
              <span class='glyphicon glyphicon-pencil text-success'>Editar</span></a></p></td>";
                
              $html.= "<td><p><a href= '#' id=".$listaResponsables["ResponsableEntrevistaCarrreraId"]."  onclick='eliminarResponsable(".$listaResponsables["ResponsableEntrevistaCarrreraId"].")' class='btn btn-default bg-danger'>
                <span class='glyphicon glyphicon-remove text-danger'>Eliminar</span></a></p></td></tr>";    
                  
              $i++;
            }//Foreach
         
            echo $html; 
        }else{
            echo "No hay resultados.";
        }
        }
    break;       
    case 'GuardarSalon':
        {
         $SalonIn = $_POST['salon']; 
        
              
       $SQL_insertSalon = "INSERT INTO SalonEntrevistas(
	   NombreSalonEntrevistas,
	   Estado
       )
       VALUES
       (
		'$SalonIn',
		'100'
	   )";
           
      if($db->Execute($SQL_insertSalon)==false){
                echo '<br />Error al insertar....<br><br>'.$SQL.' El error es: '.mysql_error();
            }else{
                echo '1';  
            } 
    
       }
    break;
    
    case 'GuardarResponsable':
    {
         $nombresResponsable = $_POST['Nombres']; 
         $apellidoResponsable = $_POST['Apellidos']; 
         $correoResponsable = $_POST['Correo']; 
         $correoAlterno1 = $_POST['Correo1']; 
         $correoAlterno2 = $_POST['Correo2']; 
        
              
       $SQL_insertResponsable = "INSERT INTO ResponsableEntrevistaCarrera(
	   NombresResponsable,
       ApellidosResponsable,
       CorreoResponsable,
       CorreoAlterno1,
       CorreoAlterno2,
	   EstadoResponsable
       )
       VALUES
       (
		'$nombresResponsable',
        '$apellidoResponsable',
        '$correoResponsable',
        '$correoAlterno1',
        '$correoAlterno2',
		'100'
	   )";
           
      if($db->Execute($SQL_insertResponsable)==false){
                echo '<br />Error al insertar....<br><br>'.$SQL.' El error es: '.mysql_error();
            }else{
                echo '1';  
            } 
    
    }
    break;    
    case 'EliminarSalon':
    {
       $SalonId = $_POST['idSalon']; 
       
       $SQL_buscaSalon = "SELECT SalonEntrevistasId FROM CarreraSalones
       WHERE SalonEntrevistasId = '$SalonId'";
       
       $SalonExiste = $db->GetRow($SQL_buscaSalon);
        
       if($SalonExiste){
        echo '0';           
       }else{
       
           $SQL_updateSalon = "UPDATE SalonEntrevistas
           SET Estado = '300'
           WHERE
           (SalonEntrevistasId= '$SalonId')
           LIMIT 1";

          if($db->Execute($SQL_updateSalon)==false){
                    echo '<br />Error al Eliminar....<br><br>'.$SQL.' El error es: '.mysql_error();
                }else{
                    echo '1';  
                } 
       }
    }
    break;
        
    case 'EliminaResponsable':
        {
       $ResponsableId = $_POST['IdResponsable']; 
        
       $SQL_buscaResponsable = "SELECT ResponsableEntrevistaCarrreraId FROM CarreraSalones
       WHERE ResponsableEntrevistaCarrreraId = '$ResponsableId'";
       
       $ExisteRes = $db->GetRow($SQL_buscaResponsable);
        
       if($ExisteRes){
        echo '0';           
       }else{
       
       $SQL_updateResponsable = "UPDATE ResponsableEntrevistaCarrera
	   SET EstadoResponsable = '300'
       WHERE
       (ResponsableEntrevistaCarrreraId= '$ResponsableId')
       LIMIT 1";
           
      if($db->Execute($SQL_updateResponsable)==false){
                echo '<br />Error al Eliminar....<br><br>'.$SQL.' El error es: '.mysql_error();
            }else{
                echo '1';  
            } 
       }
     }
     break;    
     
     case 'EliminarEntrevista':
        {
       $IddeEntrevista = $_POST['idEntrevista']; 
        
       $SQL_eliminarEntrevista = "UPDATE Entrevistas
	   SET EstadoEntrevista = '300'
       WHERE
       (EntrevistaId= '$IddeEntrevista')
       LIMIT 1";
      if($db->Execute($SQL_eliminarEntrevista)==false){
                echo '<br />Error al Eliminar....<br><br>'.$SQL.' El error es: '.mysql_error();
            }else{
                echo '1';  
            } 
    
     }
     break;    
        
     case 'EditarSalon':
        {
            $html = "";
            $IdSalon = $_POST['SalonMod'];
             
                
            $SQL_cosultaAulas = "SELECT SalonEntrevistasId, NombreSalonEntrevistas 
            FROM SalonEntrevistas
            WHERE Estado = '100'
            AND SalonEntrevistasId= '$IdSalon'";
            
            $resultadoAulas = $db->GetRow($SQL_cosultaAulas);
            $NombreAula = $resultadoAulas['NombreSalonEntrevistas'];
            
            
          $html.='<form id="formActualizarSalon" name="formActualizarSalon">';
              $html.='<div class="form-group">
                          <label for="SalonM">Nombre Salón</label>
                          <input type="text" class="form-control input-sm" id="SalonMod" name="SalonMod" value= "'.$NombreAula.'" required>
                    </div>';                        
    
            $html.='</form';
         echo $html;    
        }
    break; 
    case 'EditarResponsable':
        {
            $html = "";
            $IdResponsable = $_POST['idResponsable'];
                         
                
            $SQL_cosultaResponsable = "SELECT ResponsableEntrevistaCarrreraId, NombresResponsable AS 'Nombres', ApellidosResponsable AS 'Apellidos',	CorreoResponsable AS 'CorreoElectronico', CorreoAlterno1, CorreoAlterno2
            FROM
	       ResponsableEntrevistaCarrera
           WHERE
	           EstadoResponsable = '100'
           AND ResponsableEntrevistaCarrreraId = '$IdResponsable'";
            
            $resultadoResponsable = $db->GetRow($SQL_cosultaResponsable);
                
          $html.='<form id="formEditarResponsable" name="formEditarResponsable">';
              $html.='<div class="form-group">
                          <label for="nombreResponsableE">Nombres</label>
                          <input type="text" class="form-control input-sm" id="nombreResponsableE" name="nombreResponsableE" value= "'.$resultadoResponsable['Nombres'].'" required>
                          
                          <label for="apellidoResponsableE">Apellidos</label>
                          <input type="text" class="form-control input-sm" id="apellidoResponsableE" name="apellidoResponsableE" value= "'.$resultadoResponsable['Apellidos'].'" required>
                         
                          <label for="correoResponsableE">Correo Principal</label>
                          <input type="text" class="form-control input-sm" id="correoResponsableE" name="correoResponsableE" value= "'.$resultadoResponsable['CorreoElectronico'].'" required>
                          
                          <label for="correoAlterno1">Correo Alterno 1</label>
                          <input type="text" class="form-control input-sm" id="correoAlterno1" name="correoAlterno1" value= "'.$resultadoResponsable['CorreoAlterno1'].'">
                          
                          <label for="correoAlterno2">Correo Alterno 2</label>
                          <input type="text" class="form-control input-sm" id="correoAlterno2" name="correoAlterno2" value= "'.$resultadoResponsable['CorreoAlterno2'].'">
                          
                    </div>';                        
    
            $html.='</form';
         echo $html;    
        }
    break;
        
    case 'ModificarSalon':
        {
        
        $SalonId = $_POST['salonId']; 
        $Salon = $_POST['salonModi'];
        
       
        
        $SQL_Existe= "SELECT SalonEntrevistasId, NombreSalonEntrevistas 
            FROM SalonEntrevistas
            WHERE Estado = '100'
            AND NombreSalonEntrevistas ='$Salon'";
        
        $resultadoExiste = $db->GetRow($SQL_Existe);
        
        if($resultadoExiste){
        echo '0';
        }else{
        $SQL_update ="UPDATE SalonEntrevistas
        SET NombreSalonEntrevistas = '$Salon'
        WHERE
	    (SalonEntrevistasId= '$SalonId')
        LIMIT 1"; 
        
        if($db->Execute($SQL_update)==false){
            echo '<br />Error en el Modificar....<br><br>'.$SQL.' El error es: '.mysql_error();
            
         }else{
            echo '1';  
            }   
        }
        
        }
    break;  
        
    case 'ModificarResponsable':
        {
        
        $ResponsableId = $_POST['idResponsable']; 
        $nombreResponsable = $_POST['nombreResMod']; 
        $apelliResponsable = $_POST['apellidoMod']; 
        $correoResponsable = $_POST['correoMod']; 
        $alterno1Responsable = $_POST['alterno1Mod']; 
        $alterno2Responsable = $_POST['alterno2Mod']; 
        
        
       $SQL_update ="UPDATE ResponsableEntrevistaCarrera
        SET NombresResponsable = '$nombreResponsable',
        ApellidosResponsable = '$apelliResponsable',
        CorreoResponsable = '$correoResponsable',
        CorreoAlterno1 = '$alterno1Responsable',
        CorreoAlterno2 = '$alterno2Responsable'
        WHERE
	   (
	   ResponsableEntrevistaCarrreraId = '$ResponsableId'
	   )
       LIMIT 1"; 
        
        if($db->Execute($SQL_update)==false){
            echo '<br />Error en el Modificar....<br><br>'.$SQL.' El error es: '.mysql_error();
            
         }else{
            echo '1';  
            }   
    }
    break;      
        
    case 'ConsultaEntrevistas':
        {
        $IdCarreraSalon = $_POST['idCarrreraSalonE'];  
        $hoy = date("Y-m-d");
        
        //Lista las carreras activas de pregrado y posgrado de acuerdo a las carreras de cada usuario.
        $SQL_entrevitas = "SELECT
	           cs.CarreraSalonId,
	           c.nombrecarrera,
               se.NombreSalonEntrevistas,
               e.EntrevistaId,
               e.FechaEntrevista,
               e.HoraInicio,
               e.HoraFin
            FROM
                CarreraSalones cs
                INNER JOIN SalonEntrevistas se ON se.SalonEntrevistasId = cs.SalonEntrevistasId
                INNER JOIN carrera c ON c.codigocarrera = cs.CodigoCarrera
                INNER JOIN ResponsableEntrevistaCarrera rec ON cs.ResponsableEntrevistaCarrreraId = rec.ResponsableEntrevistaCarrreraId
                INNER JOIN Entrevistas e ON cs.CarreraSalonId = e.CarreraSalonId ";
    
        $SQL_entrevitasb = "  WHERE
	           cs.EstadoCarreraSalon = 100
               AND e.EstadoEntrevista = 100
               AND e.CarreraSalonId = '$IdCarreraSalon'
               AND e.FechaEntrevista >= '$hoy'
            ORDER BY
	           e.FechaEntrevista DESC, e.HoraInicio";
        //Los roles usuarios con roles (13,49,84) tienen acceso a programar entrevistas de todas las modalidades y carreras.
        switch ($rol) {
            case 13:
            case 49:
            case 84:
            $SQL_entrevitas.=$SQL_entrevitasb;    
            break;
                default: 
                    $Completar = " INNER JOIN usuariofacultad uf ON c.codigocarrera = uf.codigofacultad AND uf.usuario= '$user' ";
                    $SQL_entrevitas.= $Completar.$SQL_entrevitasb;
                break;
        }
    
            $entrevistas = $db->GetAll($SQL_entrevitas);
         
            $html = "";
            $i=1;    

            foreach ($entrevistas as $listaEntrevistas) {
              
              $html.= "<tr>";
              $html.= "<td>".$i."</td>";
              $html.= "<td id="."a_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['nombrecarrera']."</td>";
              $html.= "<td id="."b_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['NombreSalonEntrevistas']."</td>";
              $html.= "<td id="."b1_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['FechaEntrevista']."</td>";        
              $html.= "<td id="."c_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['HoraInicio']."</td>";
              $html.= "<td id="."c_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['HoraFin']."</td>";        
              $html.= "<td><p><a  href= '#' id=".$listaEntrevistas["EntrevistaId"]."  onclick='actualizarEntrevista(".$listaEntrevistas["EntrevistaId"].",".$listaEntrevistas["CarreraSalonId"].")' class='btn btn-default bg-success actualizar'>
              <span class='glyphicon glyphicon-pencil text-success'>Editar</span></a></p></td>";
                
              $html.= "<td><p><a href= '#' id=".$listaEntrevistas["EntrevistaId"]."  onclick='eliminarEntrevista(".$listaEntrevistas["EntrevistaId"].",".$listaEntrevistas["CarreraSalonId"].")' class='btn btn-default bg-danger'>
                <span class='glyphicon glyphicon-trash text-danger'>Eliminar</span></a></p></td>";    
                
              $i++;
            }//Foreach
         
            echo $html;    
        }
    break; 
case 'SoloConsultaEntrevistas':
        {
        $IdCarreraSalon = $_POST['codCarrreraSalon'];  
        $hoy = date("Y-m-d");
        //Lista las entrevistas por programa a partir de la fecha actual.
            $SQL_entrevitas = "SELECT
	           cs.CarreraSalonId,
	           c.nombrecarrera,
               se.NombreSalonEntrevistas,
               e.EntrevistaId,
               e.FechaEntrevista,
               e.HoraInicio,
               e.HoraFin
            FROM
                CarreraSalones cs
                INNER JOIN SalonEntrevistas se ON se.SalonEntrevistasId = cs.SalonEntrevistasId
                INNER JOIN carrera c ON c.codigocarrera = cs.CodigoCarrera
                INNER JOIN usuariofacultad uf ON c.codigocarrera = uf.codigofacultad
                INNER JOIN ResponsableEntrevistaCarrera rec ON cs.ResponsableEntrevistaCarrreraId = rec.ResponsableEntrevistaCarrreraId
                INNER JOIN Entrevistas e ON cs.CarreraSalonId = e.CarreraSalonId
                AND uf.usuario = '$user'
            WHERE
	           cs.EstadoCarreraSalon = 100
               AND e.EstadoEntrevista = 100
               AND e.CarreraSalonId = '$IdCarreraSalon'
               AND e.FechaEntrevista >= '$hoy'
            ORDER BY
	           e.FechaEntrevista, e.HoraInicio";
    
           $entrevistas = $db->GetAll($SQL_entrevitas);
            
            $html = "";
            $i=1;    

            foreach ($entrevistas as $listaEntrevistas) {

              $html.= "<tr>";
              $html.= "<td>".$i."</td>";
              $html.= "<td id="."a_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['nombrecarrera']."</td>";
              $html.= "<td id="."b_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['NombreSalonEntrevistas']."</td>";
              $html.= "<td id="."b1_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['FechaEntrevista']."</td>";        
              $html.= "<td id="."c_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['HoraInicio']."</td>";
              $html.= "<td id="."c_".$listaEntrevistas['CarreraSalonId'].">".$listaEntrevistas['HoraFin']."</td>";        
              
            $i++;
            }//Foreach
         
            echo $html;    
        }
    break;            
}