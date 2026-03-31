<?php
if (!isset($_SESSION)) {
    session_start();
}

function genera_prodiverso($sala, $numeroordenpago) { // funcion
    $query_data = "SELECT DISTINCT
			eg.idestudiantegeneral
			,numerodocumento
			,case when locate(' ',trim(apellidosestudiantegeneral))=0
				then trim(apellidosestudiantegeneral)
				else substring(trim(apellidosestudiantegeneral),1,locate(' ',trim(apellidosestudiantegeneral)))
			 end as primerapellido
			,case when locate(' ',trim(apellidosestudiantegeneral))=0
				then ''
				else substring(trim(apellidosestudiantegeneral) from locate(' ',trim(apellidosestudiantegeneral)))
			 end as segundoapellido
			,case when locate(' ',trim(nombresestudiantegeneral))=0
				then trim(nombresestudiantegeneral)
				else substring(trim(nombresestudiantegeneral),1,locate(' ',trim(nombresestudiantegeneral)))
			 end as primernombre
			,case when locate(' ',trim(nombresestudiantegeneral))=0
				then ''
				else substring(trim(nombresestudiantegeneral) from locate(' ',trim(nombresestudiantegeneral)))
			 end as segundonombre
			,direccionresidenciaestudiantegeneral
			,e.codigocarrera
			,doc.codigodocumentopeople
			,sp.codigopeoplesexo
			,eg.celularestudiantegeneral
			,ciu.nombreciudad
			,pai.codigosappais
			,dep.codigosapdepartamento
			,ciu.codigosapciudad
			,prema.semestreprematricula
			,telefonoresidenciaestudiantegeneral
			,emailestudiantegeneral
			,c.codigoconcepto
			,dop.valorconcepto
			,s.fechainiciofinancierosubperiodo
			,s.fechafinalfinancierosubperiodo
			,cuentaoperacionprincipal
			,cuentaoperacionparcial
			,fechanacimientoestudiantegeneral
			,valorfechaordenpago
			,o.codigoperiodo
			,e.codigoestudiante
			,ecp.codigoestadocivilpeople
			,o.fechaordenpago as fechacreacion
			,f.fechaordenpago as fechavencimiento
			,f.valorfechaordenpago as totalordenpago
			,dop.codigotipodetalleordenpago
		FROM ordenpago o
INNER JOIN estudiante e on  e.codigoestudiante = o.codigoestudiante
INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
INNER JOIN detalleordenpago dop on o.numeroordenpago = dop.numeroordenpago
INNER JOIN fechaordenpago f on f.numeroordenpago = dop.numeroordenpago
INNER JOIN concepto c on dop.codigoconcepto = c.codigoconcepto
INNER JOIN subperiodo s on o.idsubperiododestino = s.idsubperiodo
INNER JOIN documentopeople doc on doc.tipodocumentosala = eg.tipodocumento
INNER JOIN prematricula prema on prema.idprematricula = o.idprematricula
INNER JOIN estadocivilpeople ecp on eg.idestadocivil = ecp.idestadocivil
INNER JOIN sexopeople sp on eg.codigogenero=sp.codigosexo
LEFT JOIN ciudad ciu on ciu.idciudad = eg.ciudadresidenciaestudiantegeneral
LEFT JOIN departamento dep on  ciu.iddepartamento = dep.iddepartamento
LEFT JOIN pais pai on dep.idpais = pai.idpais
		WHERE o.numeroordenpago =  '$numeroordenpago'";

    $data = mysql_query($query_data, $sala) or die(mysql_error());
    $row_data = mysql_fetch_assoc($data);

    $tipodocumento = $row_data['codigodocumentopeople'];
    $documento = $row_data['numerodocumento'];
    $primernombre = $row_data['primernombre'];
    $periodo = $row_data['codigoperiodo'];
    $segundonombre = $row_data['segundonombre'];
    $primerapellido = $row_data['primerapellido'];
    $segundoapellido = $row_data['segundoapellido'];
    $fechanacimiento = $row_data['fechanacimientoestudiantegeneral'];
    $paisnacionalidad = $row_data['codigosappais'];
    $departamentonacionalidad = $row_data['codigosapdepartamento'];
    $ciudadnacionalidad = $row_data['codigosapciudad'];
    $genero = $row_data['codigopeoplesexo'];
    $estadocivil = $row_data ['codigoestadocivilpeople'];
    $direccion = $row_data['direccionresidenciaestudiantegeneral'];
    $telefono = $row_data['telefonoresidenciaestudiantegeneral'];
    $email = $row_data['emailestudiantegeneral'];
    $fechacreacion = $row_data['fechacreacion'];
    $fechavencimiento = $row_data['fechavencimiento'];
    $totalordenpago = $row_data['totalordenpago'];
    $codigocarrera = $row_data ['codigocarrera'];

    $vars = array("tipodocumento"
        , "documento"
        , "primernombre"
        , "segundonombre"
        , "primerapellido"
        , "segundoapellido"
        , "fechanacimiento"
        , "paisnacionalidad"
        , "departamentonacionalidad"
        , "ciudadnacionalidad"
        , "genero"
        , "estadocivil"
        , "direccion"
        , "telefono"
        , "email"
        , "numeroordenpago"
        , "fechacreacion"
        , "fechavencimiento"
        , "totalordenpago"
        , "codigocarrera"
        , "periodo");

    $datos = compact($vars);

    // EN CASO DE NO EXISTIR LA VARIABLE POR SESSION (ES DECIR PROVIENE DIRECTAMENTE DESDE LA PAGINA), SE LE ASIGNA LA RUTA DEL PATH.
    $_SESSION['path_live'] = ($_SESSION['path_live']) ? $_SESSION['path_live'] : '/usr/local/apache2/htdocs/html/serviciosacademicos/';
    require_once($_SESSION['path_live'] . 'consulta/interfacespeople/ordenesdepago/reportarordenespagosala.php');

    return $result;
}

// fin funcion
