<?php
/**
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 01 de octubre de 2018.
 */
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);
//d($_REQUEST);
if ($_REQUEST['Accion'] == 'GuardarFormula') {
    //consulta del id del usuario 
    $sqlS = "select idusuario from usuario where usuario = '" . $_SESSION['MM_Username'] . "'";
    $datosusuario = $db->GetRow($sqlS);
    $user = $_SESSION['idusuario'];

    $codigocarrera = $_REQUEST['codigocarrera'];
    $ConvenioId = $_REQUEST['ConvenioId'];
    $fechaInicioVigencia = $_REQUEST['fechaInicioVigencia'];
    $fechaFinVigencia = $_REQUEST['fechaFinVigencia'];
    $FechaCreacion = date("Y-m-d H:i:s");
    $UsuarioCreacion = $user;
    $IdContraprestacion = $_REQUEST['IdContraprestacion'];
    $contador = $_REQUEST['contador'];
    $formula = "";
    
    for ($i = 1; $i <= $contador; $i++) {
        if (!empty($_REQUEST['campo_' . $i])) {
            if ($_REQUEST['campo_' . $i] == '3' || $_REQUEST['campo_' . $i] == '6' || $_REQUEST['campo_' . $i] == '9' || $_REQUEST['campo_' . $i] == '12' || $_REQUEST['campo_' . $i] == '11' || $_REQUEST['campo_' . $i] == '15' || $_REQUEST['campo_' . $i] == '16' || $_REQUEST['campo_' . $i] == '17') {
                $formula .= $_REQUEST['campo_' . $i] . "-" . $_REQUEST['N' . $i] . ",";
            } else {
                $formula .= $_REQUEST['campo_' . $i] . ",";
            }
        }
    }
    $formula = substr($formula, '0', '-1');
    
    $sqlconsultarFormula = "Select codigoestado from FormulaLiquidaciones where codigocarrera='" . $codigocarrera . "' and ConvenioId ='" . $ConvenioId . "'";
    //d($sqlconsultarFormula);
    $consulta = $db->GetRow($sqlconsultarFormula);
    
    /**
     * Se modifica la forma de guardado y update de modo que ahora se valida
     * el campo formulaLiquidacionId, se entiende que si este campo
     * viene vacio es porque se esta insertando un nuevo registro, cuando se hace
     * actualizacion de una formula, a esta se le cambia el estado a inactivo y se 
     * inserta un nuevo registro
     * @modified Andres Ariza <andresariza@unbosque.edu.do>.
     * @copyright Dirección de Tecnología Universidad el Bosque
     * @since 01 de octubre de 2018.
     */
    $sqlsFormula = "";
    $where = "";

    if (empty($_REQUEST['formulaLiquidacionId'])) {
        $respuesta = "registrada";
    } else {
        $respuesta = "actualizada";
        $sqlsFormula = "UPDATE FormulaLiquidaciones "
                . " SET codigoestado = '200', "
                . " FechaModificacion = NOW(), "
                . " UsuarioModificacion = '".$user."' "
                . " WHERE FormulaLiquidacionId = '" . $_REQUEST['formulaLiquidacionId'] . "' ";
        //ddd($sqlsFormula);
        $db->execute($sqlsFormula);
    }
    
    $sqlsFormula = " INSERT INTO FormulaLiquidaciones SET codigocarrera = '" . $codigocarrera 
            . "', ConvenioId = '" . $ConvenioId 
            . "', Formula = '" . $formula 
            . "', codigoestado = '100', "
            . " FechaCreacion = '" . $FechaCreacion. "', "
            . " FechaInicioVigencia = '" . $fechaInicioVigencia. "', "
            . " FechaFinVigencia = '" . $fechaFinVigencia. "', "
            . " UsuarioCreacion = '" . $user . "' " ;
    //ddd($sqlsFormula);
    $db->execute($sqlsFormula);
    
    $a_vectt['success'] = true;
    $a_vectt['message'] = 'La Formula fue '.$respuesta;
    echo json_encode($a_vectt);
    exit;
} else {
    $a_vectt['success'] = false;
    $a_vectt['message'] = 'La Formula no se puedo registrar, intentelo de nuevo';
    echo json_encode($a_vectt);
    exit;
}
?>