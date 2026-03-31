<?php
class estudiantegeneral {
// Variables
    var $idestudiantegeneral;
    var $idtrato;
    var $idestadocivil;
    var $tipodocumento;
    var $numerodocumento;
    var $expedidodocumento;
    var $numerolibretamilitar;
    var $numerodistritolibretamilitar;
    var $expedidalibretamilitar;
    var $nombrecortoestudiantegeneral;
    var $nombresestudiantegeneral;
    var $apellidosestudiantegeneral;
    var $fechanacimientoestudiantegeneral;
    var $idciudadnacimiento;
    var $codigogenero;
    var $direccionresidenciaestudiantegeneral;
    var $direccioncortaresidenciaestudiantegeneral;
    var $ciudadresidenciaestudiantegeneral;
    var $telefonoresidenciaestudiantegeneral;
    var $telefono2estudiantegeneral;
    var $celularestudiantegeneral;
    var $direccioncorrespondenciaestudiantegeneral;
    var $direccioncortacorrespondenciaestudiantegeneral;
    var $ciudadcorrespondenciaestudiantegeneral;
    var $telefonocorrespondenciaestudiantegeneral;
    var $emailestudiantegeneral;
    var $email2estudiantegeneral;
    var $fechacreacionestudiantegeneral;
    var $fechaactualizaciondatosestudiantegeneral;
    var $codigotipocliente;
    var $casoemergenciallamarestudiantegeneral;
    var $telefono1casoemergenciallamarestudiantegeneral;
    var $telefono2casoemergenciallamarestudiantegeneral;
    var $idtipoestudiantefamilia;

    // This is the constructor for this class
    // Initialize all your default variables here
    function estudiantegeneral($idestudiantegeneral) {
        global $db;
        $query_estudiantegeneral = "SELECT idestudiantegeneral, idtrato, idestadocivil, tipodocumento,
				numerodocumento, expedidodocumento, numerolibretamilitar, numerodistritolibretamilitar, 
				expedidalibretamilitar, nombrecortoestudiantegeneral, nombresestudiantegeneral, 
				apellidosestudiantegeneral, fechanacimientoestudiantegeneral, idciudadnacimiento, codigogenero, 
				direccionresidenciaestudiantegeneral, direccioncortaresidenciaestudiantegeneral, 
				ciudadresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, telefono2estudiantegeneral, 
				celularestudiantegeneral, direccioncorrespondenciaestudiantegeneral, 
				direccioncortacorrespondenciaestudiantegeneral, ciudadcorrespondenciaestudiantegeneral, 
				telefonocorrespondenciaestudiantegeneral, emailestudiantegeneral, email2estudiantegeneral, 
				fechacreacionestudiantegeneral, fechaactualizaciondatosestudiantegeneral, codigotipocliente, 
				casoemergenciallamarestudiantegeneral, telefono1casoemergenciallamarestudiantegeneral, 
				telefono2casoemergenciallamarestudiantegeneral, idtipoestudiantefamilia 
			    FROM estudiantegeneral
				where idestudiantegeneral = '$idestudiantegeneral'";
        $estudiantegeneral = $db->Execute($query_estudiantegeneral);
        $totalRows_estudiantegeneral = $estudiantegeneral->RecordCount();
        $row_estudiantegeneral = $estudiantegeneral->FetchRow();

        $this->setIdestudiantegeneral($idestudiantegeneral);
        $this->setIdtrato($row_estudiantegeneral['idtrato']);
        $this->setIdestadocivil($row_estudiantegeneral['idestadocivil']);
        $this->setTipodocumento($row_estudiantegeneral['tipodocumento']);
        $this->setNumerodocumento($row_estudiantegeneral['numerodocumento']);
        $this->setExpedidodocumento($row_estudiantegeneral['expedidodocumento']);
        $this->setNumerolibretamilitar($row_estudiantegeneral['numerolibretamilitar']);
        $this->setNumerodistritolibretamilitar($row_estudiantegeneral['numerodistritolibretamilitar']);
        $this->setExpedidalibretamilitar($row_estudiantegeneral['expedidalibretamilitar']);
        $this->setNombrecortoestudiantegeneral($row_estudiantegeneral['nombrecortoestudiantegeneral']);
        $this->setNombresestudiantegeneral($row_estudiantegeneral['nombresestudiantegeneral']);
        $this->setApellidosestudiantegeneral($row_estudiantegeneral['apellidosestudiantegeneral']);
        $this->setFechanacimientoestudiantegeneral($row_estudiantegeneral['fechanacimientoestudiantegeneral']);
        $this->setIdciudadnacimiento($row_estudiantegeneral['idciudadnacimiento']);
        $this->setCodigogenero($row_estudiantegeneral['codigogenero']);
        $this->setDireccionresidenciaestudiantegeneral($row_estudiantegeneral['direccionresidenciaestudiantegeneral']);
        $this->setDireccioncortaresidenciaestudiantegeneral($row_estudiantegeneral['direccioncortaresidenciaestudiantegeneral']);
        $this->setCiudadresidenciaestudiantegeneral($row_estudiantegeneral['ciudadresidenciaestudiantegeneral']);
        $this->setTelefonoresidenciaestudiantegeneral($row_estudiantegeneral['telefonoresidenciaestudiantegeneral']);
        $this->setTelefono2estudiantegeneral($row_estudiantegeneral['telefono2estudiantegeneral']);
        $this->setCelularestudiantegeneral($row_estudiantegeneral['celularestudiantegeneral']);
        $this->setDireccioncorrespondenciaestudiantegeneral($row_estudiantegeneral['direccioncorrespondenciaestudiantegeneral']);
        $this->setDireccioncortacorrespondenciaestudiantegeneral($row_estudiantegeneral['direccioncortacorrespondenciaestudiantegeneral']);
        $this->setCiudadcorrespondenciaestudiantegeneral($row_estudiantegeneral['ciudadcorrespondenciaestudiantegeneral']);
        $this->setTelefonocorrespondenciaestudiantegeneral($row_estudiantegeneral['telefonocorrespondenciaestudiantegeneral']);
        $this->setEmailestudiantegeneral($row_estudiantegeneral['emailestudiantegeneral']);
        $this->setEmail2estudiantegeneral($row_estudiantegeneral['email2estudiantegeneral']);
        $this->setFechacreacionestudiantegeneral($row_estudiantegeneral['fechacreacionestudiantegeneral']);
        $this->setFechaactualizaciondatosestudiantegeneral($row_estudiantegeneral['fechaactualizaciondatosestudiantegeneral']);
        $this->setCodigotipocliente($row_estudiantegeneral['codigotipocliente']);
        $this->setCasoemergenciallamarestudiantegeneral($row_estudiantegeneral['casoemergenciallamarestudiantegeneral']);
        $this->setTelefono1casoemergenciallamarestudiantegeneral($row_estudiantegeneral['telefono1casoemergenciallamarestudiantegeneral']);
        $this->setTelefono2casoemergenciallamarestudiantegeneral($row_estudiantegeneral['telefono2casoemergenciallamarestudiantegeneral']);
        $this->setIdtipoestudiantefamilia($row_estudiantegeneral['idtipoestudiantefamilia']);
    }

    /**
     * @return returns value of variable $idestudiantegeneral
     * @desc getIdestudiantegeneral : Getting value for variable $idestudiantegeneral
     */
    function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $idestudiantegeneral
     * @desc setIdestudiantegeneral : Setting value for $idestudiantegeneral
     */
    function setIdestudiantegeneral($value) {
        $this->idestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $idtrato
     * @desc getIdtrato : Getting value for variable $idtrato
     */
    function getIdtrato() {
        return $this->idtrato;
    }

    /**
     * @param param : value to be saved in variable $idtrato
     * @desc setIdtrato : Setting value for $idtrato
     */
    function setIdtrato($value) {
        $this->idtrato = $value;
    }

    /**
     * @return returns value of variable $idestadocivil
     * @desc getIdestadocivil : Getting value for variable $idestadocivil
     */
    function getIdestadocivil() {
        return $this->idestadocivil;
    }

    /**
     * @param param : value to be saved in variable $idestadocivil
     * @desc setIdestadocivil : Setting value for $idestadocivil
     */
    function setIdestadocivil($value) {
        $this->idestadocivil = $value;
    }

    /**
     * @return returns value of variable $tipodocumento
     * @desc getTipodocumento : Getting value for variable $tipodocumento
     */
    function getTipodocumento() {
        return $this->tipodocumento;
    }

    /**
     * @param param : value to be saved in variable $tipodocumento
     * @desc setTipodocumento : Setting value for $tipodocumento
     */
    function setTipodocumento($value) {
        $this->tipodocumento = $value;
    }

    /**
     * @return returns value of variable $numerodocumento
     * @desc getNumerodocumento : Getting value for variable $numerodocumento
     */
    function getNumerodocumento() {
        return $this->numerodocumento;
    }

    /**
     * @param param : value to be saved in variable $numerodocumento
     * @desc setNumerodocumento : Setting value for $numerodocumento
     */
    function setNumerodocumento($value) {
        $this->numerodocumento = $value;
    }

    /**
     * @return returns value of variable $expedidodocumento
     * @desc getExpedidodocumento : Getting value for variable $expedidodocumento
     */
    function getExpedidodocumento() {
        return $this->expedidodocumento;
    }

    /**
     * @param param : value to be saved in variable $expedidodocumento
     * @desc setExpedidodocumento : Setting value for $expedidodocumento
     */
    function setExpedidodocumento($value) {
        $this->expedidodocumento = $value;
    }

    /**
     * @return returns value of variable $numerolibretamilitar
     * @desc getNumerolibretamilitar : Getting value for variable $numerolibretamilitar
     */
    function getNumerolibretamilitar() {
        return $this->numerolibretamilitar;
    }

    /**
     * @param param : value to be saved in variable $numerolibretamilitar
     * @desc setNumerolibretamilitar : Setting value for $numerolibretamilitar
     */
    function setNumerolibretamilitar($value) {
        $this->numerolibretamilitar = $value;
    }

    /**
     * @return returns value of variable $numerodistritolibretamilitar
     * @desc getNumerodistritolibretamilitar : Getting value for variable $numerodistritolibretamilitar
     */
    function getNumerodistritolibretamilitar() {
        return $this->numerodistritolibretamilitar;
    }

    /**
     * @param param : value to be saved in variable $numerodistritolibretamilitar
     * @desc setNumerodistritolibretamilitar : Setting value for $numerodistritolibretamilitar
     */
    function setNumerodistritolibretamilitar($value) {
        $this->numerodistritolibretamilitar = $value;
    }

    /**
     * @return returns value of variable $expedidalibretamilitar
     * @desc getExpedidalibretamilitar : Getting value for variable $expedidalibretamilitar
     */
    function getExpedidalibretamilitar() {
        return $this->expedidalibretamilitar;
    }

    /**
     * @param param : value to be saved in variable $expedidalibretamilitar
     * @desc setExpedidalibretamilitar : Setting value for $expedidalibretamilitar
     */
    function setExpedidalibretamilitar($value) {
        $this->expedidalibretamilitar = $value;
    }

    /**
     * @return returns value of variable $nombrecortoestudiantegeneral
     * @desc getNombrecortoestudiantegeneral : Getting value for variable $nombrecortoestudiantegeneral
     */
    function getNombrecortoestudiantegeneral() {
        return $this->nombrecortoestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $nombrecortoestudiantegeneral
     * @desc setNombrecortoestudiantegeneral : Setting value for $nombrecortoestudiantegeneral
     */
    function setNombrecortoestudiantegeneral($value) {
        $this->nombrecortoestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $nombresestudiantegeneral
     * @desc getNombresestudiantegeneral : Getting value for variable $nombresestudiantegeneral
     */
    function getNombresestudiantegeneral() {
        return $this->nombresestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $nombresestudiantegeneral
     * @desc setNombresestudiantegeneral : Setting value for $nombresestudiantegeneral
     */
    function setNombresestudiantegeneral($value) {
        $this->nombresestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $apellidosestudiantegeneral
     * @desc getApellidosestudiantegeneral : Getting value for variable $apellidosestudiantegeneral
     */
    function getApellidosestudiantegeneral() {
        return $this->apellidosestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $apellidosestudiantegeneral
     * @desc setApellidosestudiantegeneral : Setting value for $apellidosestudiantegeneral
     */
    function setApellidosestudiantegeneral($value) {
        $this->apellidosestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $fechanacimientoestudiantegeneral
     * @desc getFechanacimientoestudiantegeneral : Getting value for variable $fechanacimientoestudiantegeneral
     */
    function getFechanacimientoestudiantegeneral() {
        return $this->fechanacimientoestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $fechanacimientoestudiantegeneral
     * @desc setFechanacimientoestudiantegeneral : Setting value for $fechanacimientoestudiantegeneral
     */
    function setFechanacimientoestudiantegeneral($value) {
        $this->fechanacimientoestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $idciudadnacimiento
     * @desc getIdciudadnacimiento : Getting value for variable $idciudadnacimiento
     */
    function getIdciudadnacimiento() {
        return $this->idciudadnacimiento;
    }

    /**
     * @param param : value to be saved in variable $idciudadnacimiento
     * @desc setIdciudadnacimiento : Setting value for $idciudadnacimiento
     */
    function setIdciudadnacimiento($value) {
        $this->idciudadnacimiento = $value;
    }

    /**
     * @return returns value of variable $codigogenero
     * @desc getCodigogenero : Getting value for variable $codigogenero
     */
    function getCodigogenero() {
        return $this->codigogenero;
    }

    /**
     * @param param : value to be saved in variable $codigogenero
     * @desc setCodigogenero : Setting value for $codigogenero
     */
    function setCodigogenero($value) {
        $this->codigogenero = $value;
    }

    /**
     * @return returns value of variable $direccionresidenciaestudiantegeneral
     * @desc getDireccionresidenciaestudiantegeneral : Getting value for variable $direccionresidenciaestudiantegeneral
     */
    function getDireccionresidenciaestudiantegeneral() {
        return $this->direccionresidenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $direccionresidenciaestudiantegeneral
     * @desc setDireccionresidenciaestudiantegeneral : Setting value for $direccionresidenciaestudiantegeneral
     */
    function setDireccionresidenciaestudiantegeneral($value) {
        $this->direccionresidenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $direccioncortaresidenciaestudiantegeneral
     * @desc getDireccioncortaresidenciaestudiantegeneral : Getting value for variable $direccioncortaresidenciaestudiantegeneral
     */
    function getDireccioncortaresidenciaestudiantegeneral() {
        return $this->direccioncortaresidenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $direccioncortaresidenciaestudiantegeneral
     * @desc setDireccioncortaresidenciaestudiantegeneral : Setting value for $direccioncortaresidenciaestudiantegeneral
     */
    function setDireccioncortaresidenciaestudiantegeneral($value) {
        $this->direccioncortaresidenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $ciudadresidenciaestudiantegeneral
     * @desc getCiudadresidenciaestudiantegeneral : Getting value for variable $ciudadresidenciaestudiantegeneral
     */
    function getCiudadresidenciaestudiantegeneral() {
        return $this->ciudadresidenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $ciudadresidenciaestudiantegeneral
     * @desc setCiudadresidenciaestudiantegeneral : Setting value for $ciudadresidenciaestudiantegeneral
     */
    function setCiudadresidenciaestudiantegeneral($value) {
        $this->ciudadresidenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $telefonoresidenciaestudiantegeneral
     * @desc getTelefonoresidenciaestudiantegeneral : Getting value for variable $telefonoresidenciaestudiantegeneral
     */
    function getTelefonoresidenciaestudiantegeneral() {
        return $this->telefonoresidenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $telefonoresidenciaestudiantegeneral
     * @desc setTelefonoresidenciaestudiantegeneral : Setting value for $telefonoresidenciaestudiantegeneral
     */
    function setTelefonoresidenciaestudiantegeneral($value) {
        $this->telefonoresidenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $telefono2estudiantegeneral
     * @desc getTelefono2estudiantegeneral : Getting value for variable $telefono2estudiantegeneral
     */
    function getTelefono2estudiantegeneral() {
        return $this->telefono2estudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $telefono2estudiantegeneral
     * @desc setTelefono2estudiantegeneral : Setting value for $telefono2estudiantegeneral
     */
    function setTelefono2estudiantegeneral($value) {
        $this->telefono2estudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $celularestudiantegeneral
     * @desc getCelularestudiantegeneral : Getting value for variable $celularestudiantegeneral
     */
    function getCelularestudiantegeneral() {
        return $this->celularestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $celularestudiantegeneral
     * @desc setCelularestudiantegeneral : Setting value for $celularestudiantegeneral
     */
    function setCelularestudiantegeneral($value) {
        $this->celularestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $direccioncorrespondenciaestudiantegeneral
     * @desc getDireccioncorrespondenciaestudiantegeneral : Getting value for variable $direccioncorrespondenciaestudiantegeneral
     */
    function getDireccioncorrespondenciaestudiantegeneral() {
        return $this->direccioncorrespondenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $direccioncorrespondenciaestudiantegeneral
     * @desc setDireccioncorrespondenciaestudiantegeneral : Setting value for $direccioncorrespondenciaestudiantegeneral
     */
    function setDireccioncorrespondenciaestudiantegeneral($value) {
        $this->direccioncorrespondenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $direccioncortacorrespondenciaestudiantegeneral
     * @desc getDireccioncortacorrespondenciaestudiantegeneral : Getting value for variable $direccioncortacorrespondenciaestudiantegeneral
     */
    function getDireccioncortacorrespondenciaestudiantegeneral() {
        return $this->direccioncortacorrespondenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $direccioncortacorrespondenciaestudiantegeneral
     * @desc setDireccioncortacorrespondenciaestudiantegeneral : Setting value for $direccioncortacorrespondenciaestudiantegeneral
     */
    function setDireccioncortacorrespondenciaestudiantegeneral($value) {
        $this->direccioncortacorrespondenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $ciudadcorrespondenciaestudiantegeneral
     * @desc getCiudadcorrespondenciaestudiantegeneral : Getting value for variable $ciudadcorrespondenciaestudiantegeneral
     */
    function getCiudadcorrespondenciaestudiantegeneral() {
        return $this->ciudadcorrespondenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $ciudadcorrespondenciaestudiantegeneral
     * @desc setCiudadcorrespondenciaestudiantegeneral : Setting value for $ciudadcorrespondenciaestudiantegeneral
     */
    function setCiudadcorrespondenciaestudiantegeneral($value) {
        $this->ciudadcorrespondenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $telefonocorrespondenciaestudiantegeneral
     * @desc getTelefonocorrespondenciaestudiantegeneral : Getting value for variable $telefonocorrespondenciaestudiantegeneral
     */
    function getTelefonocorrespondenciaestudiantegeneral() {
        return $this->telefonocorrespondenciaestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $telefonocorrespondenciaestudiantegeneral
     * @desc setTelefonocorrespondenciaestudiantegeneral : Setting value for $telefonocorrespondenciaestudiantegeneral
     */
    function setTelefonocorrespondenciaestudiantegeneral($value) {
        $this->telefonocorrespondenciaestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $emailestudiantegeneral
     * @desc getEmailestudiantegeneral : Getting value for variable $emailestudiantegeneral
     */
    function getEmailestudiantegeneral() {
        return $this->emailestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $emailestudiantegeneral
     * @desc setEmailestudiantegeneral : Setting value for $emailestudiantegeneral
     */
    function setEmailestudiantegeneral($value) {
        $this->emailestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $email2estudiantegeneral
     * @desc getEmail2estudiantegeneral : Getting value for variable $email2estudiantegeneral
     */
    function getEmail2estudiantegeneral() {
        return $this->email2estudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $email2estudiantegeneral
     * @desc setEmail2estudiantegeneral : Setting value for $email2estudiantegeneral
     */
    function setEmail2estudiantegeneral($value) {
        $this->email2estudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $fechacreacionestudiantegeneral
     * @desc getFechacreacionestudiantegeneral : Getting value for variable $fechacreacionestudiantegeneral
     */
    function getFechacreacionestudiantegeneral() {
        return $this->fechacreacionestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $fechacreacionestudiantegeneral
     * @desc setFechacreacionestudiantegeneral : Setting value for $fechacreacionestudiantegeneral
     */
    function setFechacreacionestudiantegeneral($value) {
        $this->fechacreacionestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $fechaactualizaciondatosestudiantegeneral
     * @desc getFechaactualizaciondatosestudiantegeneral : Getting value for variable $fechaactualizaciondatosestudiantegeneral
     */
    function getFechaactualizaciondatosestudiantegeneral() {
        return $this->fechaactualizaciondatosestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $fechaactualizaciondatosestudiantegeneral
     * @desc setFechaactualizaciondatosestudiantegeneral : Setting value for $fechaactualizaciondatosestudiantegeneral
     */
    function setFechaactualizaciondatosestudiantegeneral($value) {
        $this->fechaactualizaciondatosestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $codigotipocliente
     * @desc getCodigotipocliente : Getting value for variable $codigotipocliente
     */
    function getCodigotipocliente() {
        return $this->codigotipocliente;
    }

    /**
     * @param param : value to be saved in variable $codigotipocliente
     * @desc setCodigotipocliente : Setting value for $codigotipocliente
     */
    function setCodigotipocliente($value) {
        $this->codigotipocliente = $value;
    }

    /**
     * @return returns value of variable $casoemergenciallamarestudiantegeneral
     * @desc getCasoemergenciallamarestudiantegeneral : Getting value for variable $casoemergenciallamarestudiantegeneral
     */
    function getCasoemergenciallamarestudiantegeneral() {
        return $this->casoemergenciallamarestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $casoemergenciallamarestudiantegeneral
     * @desc setCasoemergenciallamarestudiantegeneral : Setting value for $casoemergenciallamarestudiantegeneral
     */
    function setCasoemergenciallamarestudiantegeneral($value) {
        $this->casoemergenciallamarestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $telefono1casoemergenciallamarestudiantegeneral
     * @desc getTelefono1casoemergenciallamarestudiantegeneral : Getting value for variable $telefono1casoemergenciallamarestudiantegeneral
     */
    function getTelefono1casoemergenciallamarestudiantegeneral() {
        return $this->telefono1casoemergenciallamarestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $telefono1casoemergenciallamarestudiantegeneral
     * @desc setTelefono1casoemergenciallamarestudiantegeneral : Setting value for $telefono1casoemergenciallamarestudiantegeneral
     */
    function setTelefono1casoemergenciallamarestudiantegeneral($value) {
        $this->telefono1casoemergenciallamarestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $telefono2casoemergenciallamarestudiantegeneral
     * @desc getTelefono2casoemergenciallamarestudiantegeneral : Getting value for variable $telefono2casoemergenciallamarestudiantegeneral
     */
    function getTelefono2casoemergenciallamarestudiantegeneral() {
        return $this->telefono2casoemergenciallamarestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $telefono2casoemergenciallamarestudiantegeneral
     * @desc setTelefono2casoemergenciallamarestudiantegeneral : Setting value for $telefono2casoemergenciallamarestudiantegeneral
     */
    function setTelefono2casoemergenciallamarestudiantegeneral($value) {
        $this->telefono2casoemergenciallamarestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $idtipoestudiantefamilia
     * @desc getIdtipoestudiantefamilia : Getting value for variable $idtipoestudiantefamilia
     */
    function getIdtipoestudiantefamilia() {
        return $this->idtipoestudiantefamilia;
    }

    /**
     * @param param : value to be saved in variable $idtipoestudiantefamilia
     * @desc setIdtipoestudiantefamilia : Setting value for $idtipoestudiantefamilia
     */
    function setIdtipoestudiantefamilia($value) {
        $this->idtipoestudiantefamilia = $value;
    }

    function editar() {
        require_once("editarestudiantegeneral.php");
    }

    function guardar() {
        require_once("guardarestudiantegeneral.php");
        $this->estudiantegeneral($this->idestudiantegeneral);
    }

    function imprimir() {
        require_once("imprimirestudiantegeneral.php");
    //$this->estudiantegeneral($this->idestudiantegeneral);
    }

    function imprimirFoto($aprobarHV=false) {
        require_once("imprimirestudiantegeneralfoto.php");
    //$this->estudiantegeneral($this->idestudiantegeneral);
    }

    // This function will clear all the values of variables in this class
    function emptyInfo() {

        $this->setIdestudiantegeneral("");
        $this->setIdtrato("");
        $this->setIdestadocivil("");
        $this->setTipodocumento("");
        $this->setNumerodocumento("");
        $this->setExpedidodocumento("");
        $this->setNumerolibretamilitar("");
        $this->setNumerodistritolibretamilitar("");
        $this->setExpedidalibretamilitar("");
        $this->setNombrecortoestudiantegeneral("");
        $this->setNombresestudiantegeneral("");
        $this->setApellidosestudiantegeneral("");
        $this->setFechanacimientoestudiantegeneral("");
        $this->setIdciudadnacimiento("");
        $this->setCodigogenero("");
        $this->setDireccionresidenciaestudiantegeneral("");
        $this->setDireccioncortaresidenciaestudiantegeneral("");
        $this->setCiudadresidenciaestudiantegeneral("");
        $this->setTelefonoresidenciaestudiantegeneral("");
        $this->setTelefono2estudiantegeneral("");
        $this->setCelularestudiantegeneral("");
        $this->setDireccioncorrespondenciaestudiantegeneral("");
        $this->setDireccioncortacorrespondenciaestudiantegeneral("");
        $this->setCiudadcorrespondenciaestudiantegeneral("");
        $this->setTelefonocorrespondenciaestudiantegeneral("");
        $this->setEmailestudiantegeneral("");
        $this->setEmail2estudiantegeneral("");
        $this->setFechacreacionestudiantegeneral("");
        $this->setFechaactualizaciondatosestudiantegeneral("");
        $this->setCodigotipocliente("");
        $this->setCasoemergenciallamarestudiantegeneral("");
        $this->setTelefono1casoemergenciallamarestudiantegeneral("");
        $this->setTelefono2casoemergenciallamarestudiantegeneral("");
        $this->setIdtipoestudiantefamilia("");
    }

}


class estudiante extends estudiantegeneral {
// Variables
    var $codigoestudiante;
    var $idestudiantegeneral;
    var $codigocarrera;
    var $semestre;

    // Esta variable no es cargada de la tabla directamente
    //var $numerocohorte;

    var $codigotipoestudiante;
    var $codigosituacioncarreraestudiante;

    // Es el periodo de ingreso del estudiante
    var $codigoperiodo;
    var $codigojornada;

    /*******************************/
    // Variables de otras tablas que pertenecen al estudiante indirectamente
    var $numerocohorte;
    var $valordetallecohorte;

    // Esta variable es para saber el idcohorte que posee el estudiante para el cohorte actual
    var $idcohorte;

    var $idprematricula;
    var $semestreprematricula;

    // Es el periodo general de los querys
    var $codigoperiodogeneral;

    // This is the constructor for this class
    // Initialize all your default variables here
    function estudiante($codigoestudiante, $codigoperiodogeneral = '') {
        global $db;
        $query_estudiante = "SELECT codigoestudiante, idestudiantegeneral, codigocarrera,
				semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, 
				codigoperiodo, codigojornada 
				FROM estudiante
				where codigoestudiante = '$codigoestudiante'";
        $estudiante = $db->Execute($query_estudiante);
        $totalRows_estudiante = $estudiante->RecordCount();
        $row_estudiante = $estudiante->FetchRow();

        $this->setCodigoestudiante($row_estudiante['codigoestudiante']);
        $this->setIdestudiantegeneral($row_estudiante['idestudiantegeneral']);
        $this->setCodigocarrera($row_estudiante['codigocarrera']);
        $this->setSemestre($row_estudiante['semestre']);
        $this->setCodigotipoestudiante($row_estudiante['codigotipoestudiante']);
        $this->setCodigosituacioncarreraestudiante($row_estudiante['codigosituacioncarreraestudiante']);
        $this->setCodigoperiodo($row_estudiante['codigoperiodo']);
        $this->setCodigoperiodogeneral($codigoperiodogeneral);
        $this->setCodigojornada($row_estudiante['codigojornada']);

        $this->setIdprematricula();
        $this->setNumerocohorte();


        $this->estudiantegeneral($row_estudiante['idestudiantegeneral']);
    }

    /***Funciones para traer datos específicos***/
    function getNombrecarrera() {
        global $db;
        $query_carrera = "select nombrecarrera
				from carrera
				where codigocarrera = '$this->codigocarrera'";
        $carrera = $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();
        $row_carrera = $carrera->FetchRow();

        return $row_carrera['nombrecarrera'];
    }
    function getEstadocivil() {
        global $db;
        $query_estadocivil = "select nombreestadocivil
				from estadocivil
				where idestadocivil = '$this->idestadocivil'";
        $estadocivil = $db->Execute($query_estadocivil);
        $totalRows_estadocivil = $estadocivil->RecordCount();
        $row_estadocivil = $estadocivil->FetchRow();

        return $row_estadocivil['nombreestadocivil'];
    }
    function getEdad() {
        list($anonaz,$mesnaz,$dianaz)=explode("-",$this->fechanacimientoestudiantegeneral);
        $dia=date(j);
        $mes=date(n);
        $ano=date(Y);

        //si el mes es el mismo pero el dia inferior aun no ha cumplido años, le quitaremos un año al actual
        if (($mesnaz == $mes) && ($dianaz > $dia)) {
            $ano=($ano-1); }

        //si el mes es superior al actual tampoco habra cumplido años, por eso le quitamos un año al actual
        if ($mesnaz > $mes) {
            $ano=($ano-1);}

        //ya no habria mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
        $edad=($ano-$anonaz);

        return $edad;
    }
    function getGenero() {
        global $db;
        $query_genero = "SELECT codigogenero, nombregenero
			    FROM genero
				where codigogenero = '$this->codigogenero'";
        $genero = $db->Execute($query_genero);
        $totalRows_genero = $genero->RecordCount();
        $row_genero = $genero->FetchRow();

        return $row_genero['nombregenero'];
    }
    function getCiudadnacimiento() {
        global $db;
        $query_ciudad = "SELECT idciudad, nombreciudad
			    FROM ciudad
				where idciudad = '$this->idciudadnacimiento'";
        $ciudad = $db->Execute($query_ciudad);
        $totalRows_ciudad = $ciudad->RecordCount();
        $row_ciudad = $ciudad->FetchRow();

        return $row_ciudad['nombreciudad'];
    }
    function getJornada() {
        global $db;
        $query_jornada = "SELECT codigojornada, nombrejornada
			    FROM jornada
				where codigojornada = '$this->codigojornada'";
        $jornada = $db->Execute($query_jornada);
        $totalRows_jornada = $jornada->RecordCount();
        $row_jornada = $jornada->FetchRow();

        return $row_jornada['nombrejornada'];
    }
    function getTipoestudiante() {
        global $db;
        $query_tipoestudiante = "SELECT codigotipoestudiante, nombretipoestudiante
			    FROM tipoestudiante
				where codigotipoestudiante = '$this->codigotipoestudiante'";
        $tipoestudiante = $db->Execute($query_tipoestudiante);
        $totalRows_tipoestudiante = $tipoestudiante->RecordCount();
        $row_tipoestudiante = $tipoestudiante->FetchRow();

        return $row_tipoestudiante['nombretipoestudiante'];
    }
    function getSituacioncarreraestudiante() {
        global $db;
        $query_situacioncarreraestudiante = "SELECT codigosituacioncarreraestudiante, nombresituacioncarreraestudiante
			    FROM situacioncarreraestudiante
				where codigosituacioncarreraestudiante = '$this->codigosituacioncarreraestudiante'";
        $situacioncarreraestudiante = $db->Execute($query_situacioncarreraestudiante);
        $totalRows_situacioncarreraestudiante = $situacioncarreraestudiante->RecordCount();
        $row_situacioncarreraestudiante = $situacioncarreraestudiante->FetchRow();

        return $row_situacioncarreraestudiante['nombresituacioncarreraestudiante'];
    }
    function getEstrato() {
        global $db;
        $query_estrato = "SELECT e.nombreestrato, e.idestrato
				FROM estratohistorico eh, estrato e
				where eh.codigoestado like '1%'
				and e.codigoestado like '1%'
				and eh.idestudiantegeneral = $this->idestudiantegeneral
				and e.idestrato = eh.idestrato";
        $estrato = $db->Execute($query_estrato);
        $totalRows_estrato = $estrato->RecordCount();
        $row_estrato = $estrato->FetchRow();

        return $row_estrato['nombreestrato'];
    }

    /**
     * @return returns value of variable $codigoestudiante
     * @desc getCodigoestudiante : Getting value for variable $codigoestudiante
     */
    function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    /**
     * @param param : value to be saved in variable $codigoestudiante
     * @desc setCodigoestudiante : Setting value for $codigoestudiante
     */
    function setCodigoestudiante($value) {
        $this->codigoestudiante = $value;
    }

    /**
     * @return returns value of variable $idestudiantegeneral
     * @desc getIdestudiantegeneral : Getting value for variable $idestudiantegeneral
     */
    function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    /**
     * @param param : value to be saved in variable $idestudiantegeneral
     * @desc setIdestudiantegeneral : Setting value for $idestudiantegeneral
     */
    function setIdestudiantegeneral($value) {
        $this->idestudiantegeneral = $value;
    }

    /**
     * @return returns value of variable $codigocarrera
     * @desc getCodigocarrera : Getting value for variable $codigocarrera
     */
    function getCodigocarrera() {
        return $this->codigocarrera;
    }

    /**
     * @param param : value to be saved in variable $codigocarrera
     * @desc setCodigocarrera : Setting value for $codigocarrera
     */
    function setCodigocarrera($value) {
        $this->codigocarrera = $value;
    }

    /**
     * @return returns value of variable $semestre
     * @desc getSemestre : Getting value for variable $semestre
     */
    function getSemestre() {
        return $this->semestre;
    }

    /**
     * @param param : value to be saved in variable $semestre
     * @desc setSemestre : Setting value for $semestre
     */
    function setSemestre($value) {
        $this->semestre = $value;
    }

    /**
     * @return returns value of variable $numerocohorte
     * @desc getNumerocohorte : Getting value for variable $numerocohorte
     */
    function getNumerocohorte() {
        return $this->numerocohorte;
    }

    /**
     * @param param : value to be saved in variable $numerocohorte
     * @desc setNumerocohorte : Setting value for $numerocohorte
     */
    function setNumerocohorte() {
    // El cohorte se trae con el periodo activo por lo general, sin embargo se permite traer el cohorte
    // en otro periodo de acuerdo a lo que este en la variable $this->codigoperiodogeneral
        global $db;
        /*select c.numerocohorte, c.codigoperiodoinicial, c.codigoperiodofinal
         from cohorte c, estudiante e
         where c.codigocarrera = e.codigocarrera
         and c.codigoperiodo = '$this->codigoperiodogeneral'
         and e.codigoestudiante = '$this->codigoestudiante'
         and e.codigoperiodo*1 between codigoperiodoinicial*1 and codigoperiodofinal*1*/
        $query_cohorte = "select idcohorte, numerocohorte, codigoperiodoinicial, codigoperiodofinal
				from cohorte c
				where c.codigocarrera = '$this->codigocarrera'
				and c.codigoperiodo = '$this->codigoperiodogeneral'
				and $this->codigoperiodo*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";

        $cohorte = $db->Execute($query_cohorte);
        $totalRows_cohorte = $cohorte->RecordCount();
        if($totalRows_cohorte == 0) {
            $query_cohorte = "select c.idcohorte, c.numerocohorte, c.codigoperiodo, max(dc.valordetallecohorte) as max
					from cohorte c, detallecohorte dc
					where c.codigocarrera = '$this->codigocarrera'
					and c.codigoperiodo = '$this->codigoperiodogeneral'
					and dc.idcohorte = c.idcohorte
					group by c.codigoperiodo";
            $cohorte = $db->Execute($query_cohorte);
            $totalRows_cohorte = $cohorte->RecordCount();
        }
        $row_cohorte = $cohorte->FetchRow();
        $this->numerocohorte = $row_cohorte['numerocohorte'];
        $this->idcohorte = $row_cohorte['idcohorte'];

        $query_valorcohorte = "select dc.valordetallecohorte, dc.codigoconcepto, dc.semestredetallecohorte
				from cohorte c, detallecohorte dc
				where c.idcohorte = dc.idcohorte
				and c.idcohorte = '$this->idcohorte'
				and dc.semestredetallecohorte = '$this->semestreprematricula'";
        $valorcohorte = $db->Execute($query_valorcohorte);
        $totalRows_valorcohorte = $valorcohorte->RecordCount();
        $row_valorcohorte = $valorcohorte->FetchRow();
        $this->valordetallecohorte = $row_valorcohorte['valordetallecohorte'];
        if($this->valordetallecohorte == '') {
        //echo "<h1>$query_cohorte <br> $query_valorcohorte</h1>";
        //exit();
        }
    }

    /**
     * @param param : value to be saved in variable $numerocohorte
     * @desc setIdprematricula : Setting value for $numerocohorte
     */
    function setIdprematricula() {
        global $db;
        $query_prematricula = "select idprematricula, semestreprematricula
				from prematricula
				where codigoestudiante = '$this->codigoestudiante'
				and codigoperiodo = '$this->codigoperiodogeneral'";

        $prematricula = $db->Execute($query_prematricula);
        $totalRows_prematricula = $prematricula->RecordCount();
        $row_prematricula = $prematricula->FetchRow();
        if($totalRows_prematricula == 0) {
            $this->semestreprematricula = 1;
        }
        else if($this->semestreprematricula == 0) {
                $this->semestreprematricula = 1;
            }
            else {
                $this->idprematricula = $row_prematricula['idprematricula'];
                $this->semestreprematricula = $row_prematricula['semestreprematricula'];
            }
    }

    /**
     * @return returns value of variable $codigotipoestudiante
     * @desc getCodigotipoestudiante : Getting value for variable $codigotipoestudiante
     */
    function getCodigotipoestudiante() {
        return $this->codigotipoestudiante;
    }

    /**
     * @param param : value to be saved in variable $codigotipoestudiante
     * @desc setCodigotipoestudiante : Setting value for $codigotipoestudiante
     */
    function setCodigotipoestudiante($value) {
        $this->codigotipoestudiante = $value;
    }

    /**
     * @return returns value of variable $codigosituacioncarreraestudiante
     * @desc getCodigosituacioncarreraestudiante : Getting value for variable $codigosituacioncarreraestudiante
     */
    function getCodigosituacioncarreraestudiante() {
        return $this->codigosituacioncarreraestudiante;
    }

    /**
     * @param param : value to be saved in variable $codigosituacioncarreraestudiante
     * @desc setCodigosituacioncarreraestudiante : Setting value for $codigosituacioncarreraestudiante
     */
    function setCodigosituacioncarreraestudiante($value) {
        $this->codigosituacioncarreraestudiante = $value;
    }

    /**
     * @return returns value of variable $codigoperiodo
     * @desc getCodigoperiodo : Getting value for variable $codigoperiodo
     */
    function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    /**
     * @param param : value to be saved in variable $codigoperiodo
     * @desc setCodigoperiodo : Setting value for $codigoperiodo
     */
    function setCodigoperiodogeneral($value) {
    // Si no se le pasa periodo toma el periodo activo
        if($value != '') {
            $this->codigoperiodogeneral = $value;
        }
        else {
            global $db;
            $query_periodo = "SELECT codigoperiodo, nombreperiodo, codigoestadoperiodo,
					fechainicioperiodo, fechavencimientoperiodo, numeroperiodo 
					FROM periodo
					where codigoestadoperiodo = '1'";					
            $periodo = $db->Execute($query_periodo);
            $totalRows_periodo = $periodo->RecordCount();
            $row_periodo = $periodo->FetchRow();
            $this->codigoperiodogeneral = $row_periodo['codigoperiodo'];
        }
    }

    /**
     * @return returns value of variable $codigoperiodo
     * @desc getCodigoperiodo : Getting value for variable $codigoperiodo
     */
    function getCodigoperiodogeneral() {
        return $this->codigoperiodogeneral;
    }

    /**
     * @param param : value to be saved in variable $codigoperiodo
     * @desc setCodigoperiodo : Setting value for $codigoperiodo
     */
    function setCodigoperiodo($value) {
        $this->codigoperiodo = $value;
    }

    /**
     * @return returns value of variable $codigojornada
     * @desc getCodigojornada : Getting value for variable $codigojornada
     */
    function getCodigojornada() {
        return $this->codigojornada;
    }

    /**
     * @param param : value to be saved in variable $codigojornada
     * @desc setCodigojornada : Setting value for $codigojornada
     */
    function setCodigojornada($value) {
        $this->codigojornada = $value;
    }

    // This is the destructor for this class
    // Do whatever needs to be done when object no longer needs to be used
    function __destruct() {

    }

    // This function will clear all the values of variables in this class
    function emptyInfo() {

        $this->setCodigoestudiante("");
        $this->setIdestudiantegeneral("");
        $this->setCodigocarrera("");
        $this->setSemestre("");
        $this->setNumerocohorte("");
        $this->setCodigotipoestudiante("");
        $this->setCodigosituacioncarreraestudiante("");
        $this->setCodigoperiodo("");
        $this->setCodigojornada("");
    }

    /************************* FUNCIONES PARA PROCESOS VARIOS ****************************/

    // Función que calcula el valor pagado por concepto de matricula para cada estudiante
    function valorpago_matriculas() {
        global $db;
        /*sum(do.valorconcepto * do.cantidaddetalleordenpago)*/
        $query_valormatriculas = "SELECT sum(do.valorconcepto) as valormatricula, e.codigoestudiante
				FROM ordenpago o, detalleordenpago do, estudiante e
				where o.codigoperiodo = '$this->codigoperiodogeneral'
				and o.codigoestadoordenpago like '4%'
				and do.numeroordenpago = o.numeroordenpago
				and do.codigoconcepto in ('151','159')
				and e.codigoestudiante = o.codigoestudiante
				and e.codigocarrera in ('$this->codigocarrera')
				and e.codigoestudiante = '$this->codigoestudiante'
				group by e.codigoestudiante";					
        $valormatriculas = $db->Execute($query_valormatriculas);
        $totalRows_valormatriculas = $valormatriculas->RecordCount();
        $row_valormatriculas = $valormatriculas->FetchRow();
        return $row_valormatriculas['valormatricula'];
    }

}

function imprimirEstudiantes($estudiantes, $columnas = 0, $links = 0) {
    if($columnas == 0) {
        $columnas = get_class_vars('estudiante');
        foreach($columnas as $key => $value) {

        }
        print_r($columnas);
        $columnas = array_keys($columnas);
    }
    //print_r($columnas);
    $cuenta = 1;
    ?>
<table border="1" cellspacing="0" cellpadding="0" width="50%">
    <tr id="trtitulogris">
        <td>#</td>
    <?php foreach($columnas as $nombre => $valor): ?>
        <td><?php echo $valor; ?></td>
    <?php endforeach; ?>
    </tr>
    <?php foreach($estudiantes as $estudiante):
        ?>
    <tr>
        <td><?php echo $cuenta; $cuenta++; ?></td>
        <?php
        foreach($columnas as $nombre => $valor):

            ?>
        <td><?php if($links[$nombre] != "") : ?>
            <a href="<?php echo $links[$nombre].$estudiante->$nombre; ?>">
            <?php endif;
            echo $estudiante->$nombre; ?>
            <?php if($links[$nombre] != "") : ?>
            </a>
            <?php endif; ?>
        </td>
        <?php   endforeach; ?>
    </tr>
    <?php endforeach;  ?>
</table>
<?php    
}
?>