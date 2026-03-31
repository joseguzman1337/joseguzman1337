<?php
class controlAdministrativoDocente
{
    public function ctrCreacionAdministrativoDocente(){

        if ($_POST["accion"]=="crearAdministrativoDocente"){
            $arrayDatafrm = array();
            $arrayDatafrm["apellidos"] = $_POST["apellidos"];
            $arrayDatafrm["nombres"] = $_POST["nombres"];
            $arrayDatafrm["tipodocumento"] = $_POST["tipodocumento"];
            $arrayDatafrm["numerodocumento"] = $_POST["numerodocumento"];
            $arrayDatafrm["expedidodocumento"] = $_POST["expedidodocumento"];
            $arrayDatafrm["tipogruposanguineo"] = $_POST["tipogruposanguineo"];
            $arrayDatafrm["genero"] = $_POST["genero"];
            $arrayDatafrm["tipousuarioadmdocen"] = $_POST["tipousuarioadmdocen"];
            $arrayDatafrm["celular"] = $_POST["celular"];
            $arrayDatafrm["email"] = $_POST["email"];
            $arrayDatafrm["direccion"] = $_POST["direccion"];
            $arrayDatafrm["telefono"] = $_POST["telefono"];
            $arrayDatafrm["cargo"] = $_POST["cargo"];
            $arrayDatafrm["fechavigencia"] = $_POST["fechavigencia"];
            $registrDatos = generalModelo::mdlInsertUsuario($arrayDatafrm);
            if ($registrDatos>=0){
                //42 = docente --- 43= prestacion de servicio --- 46= Docente Ad-Honorem
                if($_POST["tipousuarioadmdocen"]==42 || $_POST["tipousuarioadmdocen"]==43 || $_POST["tipousuarioadmdocen"]==46) {
                    echo "<br>Creando docente en las diferentes plataformas ...<br>";
                    $_REQUEST['accion']="Crear";
                    $_REQUEST['tipo_creacion']=1;
                    $_REQUEST['espracticante']=99;
                    $_REQUEST['administrativodocente']=true;
                    $creaciondesdetalentohumano=true;
                    include ("../../creacionUsuariosDocentesEstudiatesAdmin/creacionDocentesEstudiantesAdmin.php");
                }
            }
            echo "<script language='JavaScript'>
                    alert('usuario ".$_POST["nombres"].$_POST["apellidos"]." creado satisfactoriamente');
                 </script>";
        }

    }
    public function ctrActualizarAdministrativoDocente(){
        if ($_POST["accion"]=="actualizarAdministrativoDocente"){
            $arrayDatafrm = array();
            $arrayDatafrm["apellidos"] = $_POST["apellidos"];
            $arrayDatafrm["nombres"] = $_POST["nombres"];
            $arrayDatafrm["tipodocumento"] = $_POST["tipodocumento"];
            $arrayDatafrm["numerodocumento"] = $_POST["numerodocumento"];
            $arrayDatafrm["expedidodocumento"] = $_POST["expedidodocumento"];
            $arrayDatafrm["tipogruposanguineo"] = $_POST["tipogruposanguineo"];
            $arrayDatafrm["genero"] = $_POST["genero"];
            $arrayDatafrm["tipousuarioadmdocen"] = $_POST["tipousuarioadmdocen"];
            $arrayDatafrm["celular"] = $_POST["celular"];
            $arrayDatafrm["email"] = $_POST["email"];
            $arrayDatafrm["direccion"] = $_POST["direccion"];
            $arrayDatafrm["telefono"] = $_POST["telefono"];
            $arrayDatafrm["cargo"] = $_POST["cargo"];
            $arrayDatafrm["fechavigencia"] = $_POST["fechavigencia"];
            $arrayDatafrm["idadministrativosdocentes"] = $_POST["idadministrativosdocentes"];
            $actualizarDatos = generalModelo::mdlActualizaUsuarioAdmnistrativoDocente($arrayDatafrm);

            if(empty($actualizarDatos)){
                if($_POST["tipousuarioadmdocen"]==42 || $_POST["tipousuarioadmdocen"]==43 || $_POST["tipousuarioadmdocen"]==46) {
                    echo "<br>Creando docente en las diferentes plataformas ...<br>";
                    $_REQUEST['accion']="Crear";
                    $_REQUEST['tipo_creacion']=1;
                    $_REQUEST['espracticante']=99;
                    $_REQUEST['administrativod|ocente']=true;
                    $creaciondesdetalentohumano=true;
                    include ("../../creacionUsuariosDocentesEstudiatesAdmin/creacionDocentesEstudiantesAdmin.php");
                }
            }
            echo "<script language='JavaScript'>
                    alert('usuario ".$_POST["nombres"].$_POST["apellidos"]." actualizado satisfactoriamente');
                 </script>";
        }
    }
}