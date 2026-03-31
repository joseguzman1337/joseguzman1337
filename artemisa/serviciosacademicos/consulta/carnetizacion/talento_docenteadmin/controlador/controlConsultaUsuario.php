<?php
class controlConsultaUsuario
{
    public function ctrConsultausuario(){
        $datos = array();
        $complementoConsulta = '';
        $n=1;
        $tipoUsuario = $_POST["tipoUsuario"];
        $numeroDocumento = $_POST["numeroDocumento"];
        if ($numeroDocumento!=""){
            $complementoConsulta ='and numerodocumento='.$numeroDocumento;
        }
        $cnsUsuario = generalModelo::mdlConsultaUsuarios($complementoConsulta,$tipoUsuario);
        if (!empty($cnsUsuario)){
            foreach ($cnsUsuario as $clave => $valor) {
                $datos[$n]['contador']=$n;
                $datos[$n]['nombreUsuarioAdministrativo'] = strtoupper($valor["nombre"]);
                $datos[$n]['numeroDocumento'] = $valor["numerodocumento"];
                $datos[$n]['terminacionContrato'] = $valor["fechavencimiento"];
                $datos[$n]['idAdministrativosDocentes']= $valor["idadministrativosdocentes"];
                $n++;
            }
        }
        return $datos;
    }
}