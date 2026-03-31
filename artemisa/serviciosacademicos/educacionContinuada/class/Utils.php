<?php

if (session_id() == '') {
// this starts the session 
    @session_start();
}

$ruta = "";
while (!is_file($ruta . 'ManagerEntity.php')) {
    $ruta = $ruta . "../";
}
require_once($ruta . 'ManagerEntity.php');

class Utils {

    private static $instance = NULL;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Utils();
        }
        return self::$instance;
    }

    public function processData($action, $table, $indexColumn, $fields = array(), $usePost = true, $debug = false) {


        if (!isset($_SESSION['MM_Username'])) {
            echo "No ha iniciado sesión en el sistema";
            die();
        }

        $entity = new ManagerEntity("usuario");
        $entity->sql_select = "idusuario";
        $entity->prefix = "";
        $entity->sql_where = " usuario='" . $_SESSION['MM_Username'] . "' ";
        //$entity->debug = true;
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];
        $entity = new ManagerEntity($table);
        $currentdate = date("Y-m-d H:i:s");
        $idname = $indexColumn;

        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        $fields["codigoestado"] = 100;

        if ($usePost) {
            foreach ($_POST as $key => $value) {
                if (strcmp($key, "action") == 0) {
                    
                } else {
                    $fields[$key] = $value;
                }
            }
        }
        if (strcmp($action, "save") == 0) {

            $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
            return $this->saveData($entity, $fields, $debug);
        } else if (strcmp($action, "update") == 0) {
            return $this->updateData($entity, $fields, $idname, $debug);
        } else if (strcmp($action, "inactivate") == 0) {
            return $this->inactivateData($entity, $fields, $idname);
        } else if (strcmp($action, "activate") == 0) {
            return $this->activateData($entity, $fields, $idname);
        }
    }

    public function saveData($entity, $fields, $debug = false) {
        $entity->SetEntity($fields);
        if ($debug) {
            $entity->debug = true;
        }
        return $entity->insertRecord();
    }

    public function updateData($entity, $fields, $idname, $debug = false) {
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey'] = $fields[$idname];
        
        if ($debug) {
            $entity->debug = true;
        }
        $entity->updateRecord();
        return $fields[$idname];
    }

    public function inactivateData($entity, $fields, $idname) {

        $entity->sql_where = $idname . " = " . $fields[$idname] . "";
        $data = $entity->getData();
        $data = $data[0];

        foreach ($data as $key => $value) {
            if ((strcmp($key, "fecha_modificacion") == 0) || (strcmp($key, "usuario_modificacion") == 0)) {
                
            } else {
                $fields[$key] = $value;
            }
        }

        $fields["codigoestado"] = 200;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey'] = $fields[$idname];

        $entity->updateRecord();
        return $fields[$idname];
    }

    public function activateData($entity, $fields, $idname) {

        $entity->sql_where = "id" . $entity->tablename . " = " . $fields[$idname] . "";
        $data = $entity->getData();
        $data = $data[0];

        foreach ($data as $key => $value) {
            if ((strcmp($key, "fecha_modificacion") == 0) || (strcmp($key, "usuario_modificacion") == 0)) {
                
            } else {
                $fields[$key] = $value;
            }
        }

        $fields["codigoestado"] = 100;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey'] = $fields[$idname];

        $entity->updateRecord();
        return $fields[$idname];
    }

    public function getAll($db, $fields, $table, $where = "", $order = "", $orderType = "ASC", $group = "") {
        $sql = "select " . $fields . " from " . $table;
        if ($where != "") {
            $sql = $sql . " WHERE " . $where;
        }
        if ($group != "") {
            $sql = $sql . " GROUP BY " . $group;
        }
        if ($order != "") {
            $sql = $sql . " ORDER BY " . $order . " " . $orderType;
        }
        $rows = $db->Execute($sql);
        return $rows;
    }

    public function asociarMisCarreras($db, $codigocarrera) {
        $fields = array();
        $fields["codigofacultad"] = $codigocarrera;
        $fields["codigotipousuariofacultad"] = 100;
        $fields["emailusuariofacultad"] = "";
        $fields["codigoestado"] = 100;
        $users = $this->getUsuariosAdministradores($db);
        foreach ($users as $user) {
            $fields["usuario"] = $user["usuario"];
            //$fields["idusuario"] = $user["idusuario"];
            $sql = "SELECT idusuario FROM usuariofacultad WHERE (`usuario`='" . $user["usuario"] . "' AND `codigofacultad`='" . $codigocarrera . "')";
            $row = $db->GetRow($sql);
            if (count($row) > 0) {
                $sql = "UPDATE `usuariofacultad` SET `codigoestado`='100' WHERE (`usuario`='" . $user["usuario"] . "' AND `codigofacultad`='" . $codigocarrera . "')";
                $db->Execute($sql);
            } else {
                $this->processData("save", "usuariofacultad", "idusuario", $fields, false, false);
            }
        }
        $users = $this->getUsuariosFuncionarios($db);

        foreach ($users as $user) {
            $fields["usuario"] = $user["usuario"];
            //$fields["idusuario"] = $user["idusuario"];
            $sql = "SELECT idusuario FROM usuariofacultad WHERE (`usuario`='" . $user["usuario"] . "' AND `codigofacultad`='" . $codigocarrera . "')";
            $row = $db->GetRow($sql);
            if (count($row) > 0) {
                $sql = "UPDATE `usuariofacultad` SET `codigoestado`='100' WHERE (`usuario`='" . $user["usuario"] . "' AND `codigofacultad`='" . $codigocarrera . "')";
                $db->Execute($sql);
            } else {
                $this->processData("save", "usuariofacultad", "idusuario", $fields, false, false);
            }
        }
    }

    public function quitarMisCarreras($db, $codigocarrera) {
        $users = $this->getUsuariosAdministradores($db);

        foreach ($users as $user) {
            $fields["usuario"] = $user["usuario"];
            $fields["idusuario"] = $user["idusuario"];
            $sql = "UPDATE `usuariofacultad` SET `codigoestado`='200' WHERE (`usuario`='" . $user["usuario"] . "' AND `codigofacultad`='" . $codigocarrera . "')";
            $db->Execute($sql);
        }
        $users = $this->getUsuariosFuncionarios($db);
        foreach ($users as $user) {
            $sql = "UPDATE `usuariofacultad` SET `codigoestado`='200' WHERE (`usuario`='" . $user["usuario"] . "' AND `codigofacultad`='" . $codigocarrera . "')";
            $db->Execute($sql);
        }
    }

    public function getGruposCursoEducacionContinuada($db, $idCurso, $asArray = true) {
        $sql = "SELECT g.idgrupo,g.codigogrupo,g.nombregrupo,g.codigomateria,g.numerodocumento,g.fechainiciogrupo,
					g.fechafinalgrupo,c.codigocarrera FROM grupo g
					inner join materia m ON m.codigomateria=g.codigomateria AND g.fechainiciogrupo!='0000-00-00' 
					inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400
					AND c.codigocarrera='" . $idCurso . "' ORDER BY g.fechainiciogrupo DESC";

        if ($asArray) {
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }

        return $rows;
    }

    public function getIngresosGrupo($db, $id) {
        $sql = "SELECT SUM(do.valorconcepto) as ingresos FROM detalleprematricula dm 
				inner join ordenpago o ON o.numeroordenpago=dm.numeroordenpago AND dm.idgrupo='" . $id . "' 
				AND o.codigoestadoordenpago IN ('40','41','44','51','52') 
				inner join detalleordenpago do ON do.numeroordenpago=o.numeroordenpago ";

        $row = $db->GetRow($sql);
        $ingresos = 0;
        if ($row !== NULL && count($row) > 0) {
            $ingresos = $row["ingresos"];
        }

        $sql = "SELECT SUM(valor) as ingresos FROM pagoPatrocinioGrupoEducacionContinuada  
				WHERE idGrupo='" . $id . "' AND codigoestado='100'";

        $row = $db->GetRow($sql);
        if ($row !== NULL && count($row) > 0) {
            $ingresos += $row["ingresos"];
        }

        return $ingresos;
    }

    public function getUsuariosAdministradores($db, $query = false) {
        $idPadres = $this->getIDMenuEC($db);
        $sql = "select u.usuario, u.idusuario, CONCAT(u.nombres,' ',u.apellidos) as nombre
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.idmenuopcion = '" . $idPadres[0] . "' AND u.idusuario=pum.idusuario AND usuario!='admintecnologia' 
				AND pum.idusuario IN (SELECT ur.idusuario FROM usuarioEducacionContinuadaRol ur where idrol=2 and codigoestado=100)
				order by nombre ASC";
        if ($query) {
            return $sql;
        } else {
            $result = $db->GetAll($sql);
            return $result;
        }
    }

    public function esAdministrador($db, $usuario) {
        $admin = false;
        $idPadres = $this->getIDMenuEC($db);
        $sql = "select u.usuario, u.idusuario, CONCAT(u.nombres,' ',u.apellidos) as nombre
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.idmenuopcion = '" . $idPadres[0] . "' AND u.idusuario=pum.idusuario AND usuario='" . $usuario . "' 
				AND pum.idusuario IN (SELECT ur.idusuario FROM usuarioEducacionContinuadaRol ur where idrol=2 and codigoestado=100)
				order by nombre ASC";
        $result = $db->GetRow($sql);
        if ($result != NULL && count($result) > 0) {
            $admin = true;
        }
        return $admin;
    }

    public function getUsuariosFuncionarios($db, $query = false) {
        $idPadres = $this->getIDMenuEC($db);
        $sql = "select u.usuario, u.idusuario, CONCAT(u.nombres,' ',u.apellidos) as nombre
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.idmenuopcion = '" . $idPadres[0] . "' AND u.idusuario=pum.idusuario AND usuario!='admintecnologia' 
				AND pum.idusuario IN (SELECT ur.idusuario FROM usuarioEducacionContinuadaRol ur where idrol=1 and codigoestado=100)
				order by nombre ASC";
        if ($query) {
            return $sql;
        } else {
            $result = $db->GetAll($sql);
            return $result;
        }
    }

    public function getCategoriasMenu($db) {
        $user = $this->getUser();
        $sql = "SELECT m.* FROM usuarioEducacionContinuadaRol u 
				INNER JOIN permisoRol p on p.idRol=u.idrol 
				INNER JOIN moduloEducacionContinuada m on m.idmoduloEducacionContinuada=p.idModulo 
				and m.tipo=1 
				where idusuario='" . $user["idusuario"] . "'  and u.codigoestado=100 
			";
        $result = $db->GetAll($sql);
        return $result;
    }

    public function getEnlacesMenuCategoria($db, $idModulo) {
        $user = $this->getUser();
        $sql = "SELECT m2.* FROM usuarioEducacionContinuadaRol u 
				INNER JOIN permisoRol p on p.idRol=u.idrol 
				INNER JOIN moduloEducacionContinuada m on m.idmoduloEducacionContinuada=p.idModulo 
				and m.tipo=1 and m.idmoduloEducacionContinuada='" . $idModulo . "' 
				INNER JOIN relacionModuloEducacionContinuada rm on rm.idModuloPadre=m.idmoduloEducacionContinuada 
				INNER JOIN moduloEducacionContinuada m2 on m2.idmoduloEducacionContinuada=rm.idModulo 
				where u.idusuario='" . $user["idusuario"] . "' 
			";
        $result = $db->GetAll($sql);

        return $result;
    }

    public function getIDMenuEC($db) {
        $sql = "SELECT idmenuopcion FROM menuopcion WHERE transaccionmenuopcion='GEC000'";
        $row = $db->GetRow($sql);
        $id = array();
        if ($row !== NULL && count($row) > 0) {
            $id[0] = $row["idmenuopcion"];
        } else {
            $id[0] = -1;
        }

        return $id;
    }

    public function getIDsMenuEC($db, $rol) {
        $sql = "SELECT idmenuopcion FROM menuopcion WHERE transaccionmenuopcion='GEC000'";
        $row = $db->GetRow($sql);
        if ($row !== NULL && count($row) > 0) {
            $id[] = $row["idmenuopcion"];
        } else {
            $id = false;
        }

        return $id;
    }

    public function getTotalGruposCursoEducacionContinuada($db, $idCurso) {
        $sql = "SELECT COUNT(g.idgrupo) as total FROM grupo g
					inner join materia m ON m.codigomateria=g.codigomateria AND g.fechainiciogrupo!='0000-00-00' 
					inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400
					AND c.codigocarrera='" . $idCurso . "' /*AND codigoestadogrupo=10 */";
        return $db->GetRow($sql);
    }

    public function getTotalGruposCursoEducacionContinuadaPaginado($db, $idCurso, $limite = 0, $asArray = true) {
        $sql = "SELECT g.idgrupo,g.codigogrupo,g.nombregrupo,g.codigomateria,g.numerodocumento,g.fechainiciogrupo,
					g.fechafinalgrupo,c.codigocarrera,g.maximogrupo,g.matriculadosgrupo,g.codigoperiodo,
					g.codigoestadogrupo,esg.nombreestadogrupo FROM grupo g
					inner join materia m ON m.codigomateria=g.codigomateria AND g.fechainiciogrupo!='0000-00-00' 
					inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400 
					inner join estadogrupo esg on esg.codigoestadogrupo=g.codigoestadogrupo 
					AND c.codigocarrera='" . $idCurso . "' /*AND codigoestadogrupo=10*/ ORDER BY g.fechainiciogrupo DESC,g.idgrupo DESC LIMIT " . $limite . ",10";

        if ($asArray) {
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }

        return $rows;
    }

    public function getDocentesGrupoCursoEducacionContinuada($db, $id) {
        $sql = "SELECT g.iddocente,d.nombredocente,d.apellidodocente,d.numerodocumento FROM relacionDocenteCursoEducacionContinuada g
					inner join grupo gr ON gr.idgrupo='" . $id . "' AND gr.idgrupo=g.idgrupo 
					inner join docente d ON d.numerodocumento=g.iddocente AND g.codigoestado=100";

        $sql2 = "SELECT g.iddocente,d.nombredocente,d.apellidodocente,d.numerodocumento FROM relacionDocenteCursoEducacionContinuada g
					inner join grupo gr ON gr.idgrupo='" . $id . "' AND gr.idgrupo=g.idgrupo 
					inner join docenteEducacionContinuada d ON d.numerodocumento=g.iddocente AND g.codigoestado=100";

        $sqlF = " SELECT sub.iddocente,sub.nombredocente,sub.apellidodocente,sub.numerodocumento FROM (" . $sql . " UNION " . $sql2 . ") as sub 
            GROUP BY sub.numerodocumento ORDER BY sub.apellidodocente,sub.nombredocente";
        $rows = $db->GetAll($sqlF);

        if ($rows == null || count($rows) == 0) {
            $sql = "SELECT g.iddocente,g.nombredocente,g.apellidodocente,g.numerodocumento FROM docente g
					inner join grupo gr ON gr.idgrupo='" . $id . "' AND gr.numerodocumento=g.numerodocumento AND gr.numerodocumento!=1";
            $rows = $db->GetAll($sql);
        }

        return $rows;
    }

    public function getEmpresasGrupoCursoEducacionContinuada($db, $id) {
        $sql = "SELECT g.idempresa,d.nombreempresa FROM relacionEmpresaCursoEducacionContinuada g
					inner join grupo gr ON gr.idgrupo='" . $id . "' 
					inner join empresa d ON d.idempresa=g.idempresa AND g.idgrupo=gr.idgrupo 
                AND g.codigoestado=100 
                GROUP BY g.idempresa ORDER BY d.nombreempresa";
        
        $rows = $db->GetAll($sql);

        return $rows;
    }

    //Este metodo creo que al final no se esta usando en nada
    public function getCostoCursoEducacionContinuada($db, $id, $carrera) {
        $sql = "SELECT g.idvaloreducacioncontinuada,g.preciovaloreducacioncontinuada FROM valoreducacioncontinuada g
					inner join carreragrupofechainscripcion c ON c.codigocarrera=g.codigocarrera AND c.codigocarrera ='" . $carrera . "' 
					AND c.idgrupo='" . $id . "' AND c.fechadesdecarreragrupofechainscripcion >= g.fechainiciovaloreducacioncontinuada 
					AND g.fechafinalvaloreducacioncontinuada>=c.fechahastacarreragrupofechainscripcion AND g.codigoestado=100 
					ORDER BY g.fechainiciovaloreducacioncontinuada ASC";

        $rows = $db->GetRow($sql);

        return $rows;
    }

    public function getParticipantesGrupoCursoEducacionContinuada($db, $id) {
        $dataDetalle = $this->getDataEntityActive("detalleGrupoCursoEducacionContinuada", $id, "idgrupo");

        $sql = "SELECT d.nombrecortodocumento,eg.idestudiantegeneral ,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
                eg.fechanacimientoestudiantegeneral,c.nombreciudad,eg.telefonoresidenciaestudiantegeneral,eg.celularestudiantegeneral,
                eg.emailestudiantegeneral, eg.email2estudiantegeneral,ps.nombrepais,ps.idpais, 
				o.numeroordenpago, eo.nombreestadoordenpago, o.codigoestadoordenpago   
                FROM detalleprematricula g 
                inner join prematricula p ON p.idprematricula=g.idprematricula and p.codigoestadoprematricula in (30,40,41)
                inner join estudiante e ON e.codigoestudiante = p.codigoestudiante 
				inner join estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join ciudad c ON c.idciudad=eg.ciudadresidenciaestudiantegeneral  
                inner join departamento de ON de.iddepartamento=c.iddepartamento 
                inner join pais ps ON ps.idpais=de.idpais 
				LEFT JOIN ordenpago o ON o.idprematricula = p.idprematricula AND o.numeroordenpago=g.numeroordenpago and o.codigoestadoordenpago not like '2%' 
				LEFT JOIN estadoordenpago eo ON eo.codigoestadoordenpago = o.codigoestadoordenpago 
                WHERE g.idgrupo='" . $id . "' AND g.codigoestadodetalleprematricula in ('10','30') GROUP BY eg.idestudiantegeneral 
                    ORDER BY eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";

        $rows = $db->GetAll($sql);
        return $rows;
    }

    public function getParticipantesInscritosGrupoCursoEducacionContinuada($db, $id) {
        $dataDetalle = $this->getDataEntityActive("detalleGrupoCursoEducacionContinuada", $id, "idgrupo");

        $sql = "SELECT d.nombrecortodocumento,eg.idestudiantegeneral ,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
                eg.fechanacimientoestudiantegeneral,c.nombreciudad,eg.telefonoresidenciaestudiantegeneral,eg.celularestudiantegeneral,
                eg.emailestudiantegeneral, eg.email2estudiantegeneral,ps.nombrepais,ps.idpais, 
				o.numeroordenpago, eo.nombreestadoordenpago   
                FROM detalleprematricula g 
                inner join prematricula p ON p.idprematricula=g.idprematricula 
                inner join estudiante e ON e.codigoestudiante = p.codigoestudiante 
				inner join estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join ciudad c ON c.idciudad=eg.ciudadresidenciaestudiantegeneral  
                inner join departamento de ON de.iddepartamento=c.iddepartamento 
				inner JOIN ordenpago o ON o.idprematricula = p.idprematricula AND o.numeroordenpago=g.numeroordenpago 
				inner JOIN estadoordenpago eo ON eo.codigoestadoordenpago = o.codigoestadoordenpago
                inner join pais ps ON ps.idpais=de.idpais 
                WHERE g.idgrupo='" . $id . "' AND g.codigoestadodetalleprematricula not in ('10','30') GROUP BY eg.idestudiantegeneral 
                    ORDER BY eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";
        $rows = $db->GetAll($sql);
        return $rows;
    }

    public function getTitulosEstudiante($db, $id) {
        $sql = "SELECT t.nombretitulo,g.otrotituloestudianteestudio 
                FROM estudianteestudio g 
                inner join titulo t ON t.codigotitulo=g.codigotitulo  
                WHERE g.idestudiantegeneral='" . $id . "'";

        $rows = $db->GetAll($sql);
        $titulos = "";
        $numRows = count($rows);
        if ($rows != null || $numRows > 0) {
            for ($i = 0; $i < $numRows; ++$i) {
                if ($titulos === "") {
                    $titulos = $rows[$i]["nombretitulo"];
                } else {
                    $titulos = "<br/>" . $rows[$i]["nombretitulo"];
                }

                if ($rows[$i]["otrotituloestudianteestudio"] !== "" && $rows[$i]["otrotituloestudianteestudio"] !== NULL) {
                    $titulos = "<br/>" . $rows[$i]["otrotituloestudianteestudio"];
                }
            }
        }

        return $titulos;
    }

    public function getNombreCursoGrupo($db, $id) {
        $sql = "SELECT c.nombrecarrera FROM grupo g
			 inner join  materia m on m.codigomateria=g.codigomateria and g.idgrupo='" . $id . "' 
				inner join carrera c on c.codigocarrera = m.codigocarrera AND c.codigomodalidadacademica=400 AND c.codigomodalidadacademicasic=400  
			   ORDER BY  c.codigocarrera asc";

        $row = $db->GetRow($sql);

        return $row["nombrecarrera"];
    }

    public function getFechaMatricula($db, $id) {
        $sql = "SELECT * FROM fechaeducacioncontinuada f
			 inner join  detallefechaeducacioncontinuada df on df.idfechaeducacioncontinuada=f.idfechaeducacioncontinuada 
                             WHERE f.idgrupo='" . $id . "' AND f.codigoestado=100";
        $row = $db->GetRow($sql);

        return $row["fechadetallefechaeducacioncontinuada"];
    }

    public function getValoresParametrizacion($db, $categoria) {
        $sql = "SELECT * FROM parametrizacionEducacionContinuada where categoria='" . $categoria . "' AND codigoestado='100'
					ORDER BY etiquetaCampo ASC";

        $rows = $db->GetAll($sql);

        return $rows;
    }

    public function getValorDefectoCampo($db, $nombre) {
        $sql = "SELECT * FROM parametrizacionEducacionContinuada where etiquetaCampo='" . $nombre . "' AND codigoestado='100'";

        $row = $db->GetRow($sql);

        return $row["valor"];
    }

    public function pintarCampo($db, $valorParametrizacion) {

        if (strcmp($valorParametrizacion["tipoCampo"], "LISTA") == 0) {
            $sql = "SELECT " . $valorParametrizacion["nombreCampo"] . "," . $valorParametrizacion["nombreCampo2"] .
                    " FROM " . $valorParametrizacion["nombreTabla"];
            if ($valorParametrizacion["consultaCompleja"] != NULL) {
                $sql .= " WHERE " . $valorParametrizacion["consultaCompleja"];
            }
            if ($valorParametrizacion["groupByCampo"] != NULL) {
                $sql .= " GROUP BY " . $valorParametrizacion["groupByCampo"];
            }
            $sql .= " ORDER BY " . $valorParametrizacion["nombreCampo2"] . " ASC";

            $rows = $db->GetAll($sql);
            $numRows = count($rows);
            echo "<select name='parametro_" . $valorParametrizacion["idparametrizacionEducacionContinuada"] . "'>";
            $campoAnterior = "";
            for ($i = 0; $i < $numRows; ++$i) {
                //el trim solo me limpia los espacios en blanco al inicio y al final
                $str1 = trim($campoAnterior);
                $str2 = trim($rows[$i][$valorParametrizacion["nombreCampo2"]]);
                //el segundo me elimina todos los espacios en blanco
                $str1 = preg_replace('/\s+/', ' ', $str1);
                $str2 = preg_replace('/\s+/', ' ', $str2);
                if (strcmp($str1, $str2) == 0) {
                    //son iguales entonces no se agrega porque esta repetido
                } else {
                    if ($valorParametrizacion["valor"] == NULL || ($valorParametrizacion["valor"] !== $rows[$i][$valorParametrizacion["nombreCampo"]])) {
                        echo "<option value='" . $rows[$i][$valorParametrizacion["nombreCampo"]] . "'>" .
                        $rows[$i][$valorParametrizacion["nombreCampo2"]] . "</option>";
                    } else {
                        echo "<option value='" . $rows[$i][$valorParametrizacion["nombreCampo"]] . "' selected>" .
                        $rows[$i][$valorParametrizacion["nombreCampo2"]] . "</option>";
                    }
                    $campoAnterior = $rows[$i][$valorParametrizacion["nombreCampo2"]];
                }
            }
            echo "</select>";
        } else if (strcmp($valorParametrizacion["tipoCampo"], "PORCENTAJE") == 0) {
            //var_dump("que pajoooooooooo");
            echo "<input type='text' name='parametro_" . $valorParametrizacion["idparametrizacionEducacionContinuada"] . "' 
				class='required number percentage' value='" . $valorParametrizacion["valor"] . "' />";
            echo "<span> (0 - 100)</span>";
        }

        return $rows;
    }

    public function pintarCampoPublico($db, $nombreEtiqueta, $selected = "") {
        $sql = "SELECT * FROM parametrizacionEducacionContinuada WHERE etiquetaCampo = '" . $nombreEtiqueta . "' AND codigoestado='100'";
        $row = $db->GetRow($sql);

        if (strcmp($row["tipoCampo"], "LISTA") == 0) {
            $sql = "SELECT " . $row["nombreCampo"] . "," . $row["nombreCampo2"] .
                    " FROM " . $row["nombreTabla"] . " ORDER BY " . $row["nombreCampo2"] . " ASC";

            $rows = $db->GetAll($sql);
            $numRows = count($rows);
            echo "<select name='" . $row["nombreCampo"] . "'>";
            for ($i = 0; $i < $numRows; ++$i) {
                if (($row["valor"] == NULL || ($row["valor"] !== $rows[$i][$row["nombreCampo"]])) && ($selected == "" || $selected == NULL || $rows[$i][$row["nombreCampo"]] !== $selected)) {
                    echo "<option value='" . $rows[$i][$row["nombreCampo"]] . "'>" .
                    $rows[$i][$row["nombreCampo2"]] . "</option>";
                } else if ($selected != "" && $selected != NULL && $rows[$i][$row["nombreCampo"]] === $selected) {
                    echo "<option value='" . $rows[$i][$row["nombreCampo"]] . "' selected>" .
                    $rows[$i][$row["nombreCampo2"]] . "</option>";
                } else if ($selected === "" || $selected === NULL) {
                    echo "<option value='" . $rows[$i][$row["nombreCampo"]] . "' selected>" .
                    $rows[$i][$row["nombreCampo2"]] . "</option>";
                }
            }
            echo "</select>";
        } else if (strcmp($row["tipoCampo"], "PORCENTAJE") == 0) {

            echo "<input type='text' name='" . $row["nombreCampo"] . "'  
				class='required number percentage' value='" . $row["valor"] . "' />";
            echo "<span> (0 - 100)</span>";
        }

        return $rows;
    }

    public function getActives($db, $fields, $table, $order = "", $orderType = "ASC", $asArray = false) {
        $sql = "";
        if ($order != "") {
            $sql = "select " . $fields . " from " . $table . " where codigoestado = '100' ORDER BY " . $order . " " . $orderType;
        } else {
            $sql = "select " . $fields . " from " . $table . " where codigoestado = '100'";
        }

        if ($asArray) {
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }

        return $rows;
    }

    public function getDataEntity($table, $id, $indexColumn, $prefix = "") {
        $entity = new ManagerEntity($table);
        //$entity->debug = true;
        $entity->sql_where = $indexColumn . " = '" . $id . "'";
        $entity->prefix = $prefix;

        $data = $entity->getData();
        $data = $data[0];

        return $data;
    }

    public function getDataEntityActive($table, $id, $indexColumn, $prefix = "") {
        $entity = new ManagerEntity($table);
        $entity->sql_where = $indexColumn . " = '" . $id . "' AND codigoestado=100";
        $entity->prefix = $prefix;

        $data = $entity->getData();
        $data = $data[0];

        return $data;
    }

    function filesize_format($bytes, $format = '', $force = '') {
        #echo 'Entro..';
        $bytes = (float) $bytes;
        if ($bytes < 1024) {
            $numero = number_format($bytes, 0, '.', ',');
            return array($numero, "B");
        }
        if ($bytes < 1048576) {
            $numero = number_format($bytes / 1024, 2, '.', ',');
            return array($numero, "KBs");
        }
        if ($bytes >= 1048576) {
            $numero = number_format($bytes / 1048576, 2, '.', ',');
            return array($numero, "MB");
        }
    }

    public function getHorasAsistenciaGrupo($db, $idGrupo) {
        $horas = 0;
        $sacarListaSql = "SELECT SUM(horasSesion) as horas from listaAsistenciaGrupo WHERE idGrupo='$idGrupo' AND codigoestado='100'";
        $sacarListaSqlRow = $db->GetRow($sacarListaSql);
        if ($sacarListaSqlRow != null && count($sacarListaSqlRow) > 0) {
            if ($sacarListaSqlRow["horas"] != NULL) {
                $horas = $sacarListaSqlRow["horas"];
            }
        }
        return $horas;
    }

    public function getHorasAsistenciaEstudianteGrupo($db, $idGrupo, $idEstudianteGeneral) {
        $horas = 0;
        $sacarListaSql = "SELECT SUM(la.horasSesion) as horas from listaAsistenciaGrupo la 
                INNER JOIN detalleListaAsistenciaGrupo dla ON dla.idListaAsistencia=la.idListaAsistenciaGrupo AND 
                dla.idEstudianteGeneral='$idEstudianteGeneral' AND dla.codigoestado='100' 
                WHERE la.idGrupo='$idGrupo' AND la.codigoestado='100'";
        //echo $sacarListaSql."<br/><br/>";
        $sacarListaSqlRow = $db->GetRow($sacarListaSql);
        if ($sacarListaSqlRow != null && count($sacarListaSqlRow) > 0) {
            if ($sacarListaSqlRow["horas"] != NULL) {
                $horas = $sacarListaSqlRow["horas"];
            }
        }
        return $horas;
    }

    public function getValorMatriculaCurso($db, $codigocarrera, $query = false) {
        $fechahoy = date("Y-m-d H:i:s");
        $valor = "";
        $query_valeducon = "select * from valoreducacioncontinuada v
            join carrera c on c.codigocarrera=v.codigocarrera
            join concepto co on co.codigoconcepto=v.codigoconcepto AND co.codigoconcepto=151 
            where v.codigocarrera = '" . $codigocarrera . "'
            and v.fechainiciovaloreducacioncontinuada <= '" . $fechahoy . "' and v.fechafinalvaloreducacioncontinuada >= '" . $fechahoy . "'";
        $row = $db->GetRow($query_valeducon);
        if ($row != null && count($row) > 0) {
            $valor = $row["preciovaloreducacioncontinuada"];
        }
        if ($query) {
            return $query_valeducon;
        }
        return $valor;
    }

    public function getPeriodoActual($db) {
        /**
         * Caso 2812 
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
         * Se ajusta la consulta del periodo para que tome el que se encuentra activo en la fecha actual. 
         * @since  Julio 17, 2019.
        */
        $dateHoy = date('Y-m-d H:i:s');

        $periodoSelectSql = "select * from periodo where '$dateHoy' between fechainicioperiodo and fechavencimientoperiodo";

        $peridoSelectRow = $db->GetRow($periodoSelectSql);
        return $peridoSelectRow;
        //End Caso 2812
    }

    public function getFechasInscripcionCurso($db, $codigocarrera, $query = false) {

        $fechas = array();
           /**
         * Caso 2812 
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
         * Se ajusta la consulta para que se muestre el último registro creado para cada carrera. 
         * @since  Julio 17, 2019.
        */
        $queryInsc = "select 
            MAX(ci.idcarreragrupofechainscripcion),
            ci.* 
            from carreraperiodo cp 
            join subperiodo sp on sp.idcarreraperiodo=cp.idcarreraperiodo 
            join carreragrupofechainscripcion ci on ci.idsubperiodo=sp.idsubperiodo AND ci.codigocarrera='" . $codigocarrera . "' 
            where cp.codigocarrera = '" . $codigocarrera . "' ";
        
        //End caso 2812
        $row = $db->GetRow($queryInsc);
        if ($row != null && count($row) > 0) {
            $fechas["inicio"] = $row["fechadesdecarreragrupofechainscripcion"];
            $fechas["final"] = $row["fechahastacarreragrupofechainscripcion"];
        }
        if ($query) {
            return $queryInsc;
        }
        return $fechas;
    }

    public function getUser() {
        if (!isset($_SESSION['MM_Username'])) {
            
            echo "No ha iniciado sesión en el sistema";
            die();
        }
        $entity = new ManagerEntity("usuario");
        $entity->sql_select = "idusuario,usuario,nombres,apellidos";
        $entity->prefix = "";
        $entity->sql_where = " usuario='" . $_SESSION['MM_Username'] . "' ";

        $data = $entity->getData();
        $user = $data[0];

        return $user;
    }

    function __destruct() {
        
    }

    public function reporte1($db, $id) {
        $dataDetalle = $this->getDataEntityActive("detalleGrupoCursoEducacionContinuada", $id, "idgrupo");

        if ($dataDetalle != null && count($dataDetalle) > 0 && $dataDetalle["tipo"] == 2) {
            $sql = "SELECT distinct concat(eg.nombresestudiantegeneral, '  ' , eg.apellidosestudiantegeneral) as 'nombre', 'Patrocinado' as 'nombreestadoordenpago', emp.nombreempresa, , d.nombredocumento, eg.numerodocumento, eg.celularestudiantegeneral, eg.emailestudiantegeneral, ps.nombrepais
                FROM relacionEstudianteGrupoInscripcion g 
        inner join estudiantegeneral eg ON eg.idestudiantegeneral=g.idEstudianteGeneral 
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join ciudad c ON c.idciudad=eg.ciudadresidenciaestudiantegeneral 
                inner join departamento de ON de.iddepartamento=c.iddepartamento 
                inner join pais ps ON ps.idpais=g.idPaisResidenciaEstudiante 
                inner join estudiante es on (eg.idestudiantegeneral=es.idestudiantegeneral) 
                inner join relacionEmpresaCursoEducacionContinuada relE on (g.idGrupo=relE.idgrupo)
                inner join empresa emp on (relE.idempresa=emp.idempresa)
                WHERE g.idGrupo='" . $id . "' order by concat(eg.nombresestudiantegeneral, '  ' , eg.apellidosestudiantegeneral) ASC";

            $rows = $db->GetAll($sql);
        } else {
            //si es un curso abierto toca mirar los estudiantes matriculados por sala y si hay algun estudiante patrocinado
            $sql = "SELECT distinct concat(eg.nombresestudiantegeneral, '  ' , eg.apellidosestudiantegeneral) as 'nombre', 'Patrocinado' as 'nombreestadoordenpago', emp.nombreempresa, d.nombredocumento, eg.numerodocumento, eg.celularestudiantegeneral, eg.emailestudiantegeneral, ps.nombrepais
                FROM relacionEstudianteGrupoInscripcion g 
        inner join estudiantegeneral eg ON eg.idestudiantegeneral=g.idEstudianteGeneral 
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join ciudad c ON c.idciudad=eg.ciudadresidenciaestudiantegeneral 
                inner join departamento de ON de.iddepartamento=c.iddepartamento 
                inner join pais ps ON ps.idpais=g.idPaisResidenciaEstudiante 
                inner join estudiante es on (eg.idestudiantegeneral=es.idestudiantegeneral) 
                inner join relacionEmpresaCursoAbiertoEducacionContinuada relE on (relE.idEstudianteGeneral=eg.idestudiantegeneral)
                inner join empresa emp on (relE.idEmpresa=emp.idempresa)
                WHERE g.idGrupo='" . $id . "' order by concat(eg.nombresestudiantegeneral, '  ' , eg.apellidosestudiantegeneral) ASC";

            $sql2 = "select distinct concat(eg.nombresestudiantegeneral, '  ' , eg.apellidosestudiantegeneral) as 'nombre', eop.nombreestadoordenpago, '' as 'nombreempresa' , d.nombredocumento, eg.numerodocumento, eg.celularestudiantegeneral, eg.emailestudiantegeneral, ps.nombrepais
                FROM detalleprematricula g 
                inner join prematricula p ON p.idprematricula=g.idprematricula 
                inner join estudiante e ON e.codigoestudiante = p.codigoestudiante 
        inner join estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join ciudad c ON c.idciudad=eg.ciudadresidenciaestudiantegeneral  
                inner join departamento de ON de.iddepartamento=c.iddepartamento 
                inner join pais ps ON ps.idpais=de.idpais  
                inner join estudiante es on (eg.idestudiantegeneral=es.idestudiantegeneral) 
                inner join ordenpago op on (es.codigoestudiante=op.codigoestudiante) 
                inner join estadoordenpago eop on (op.codigoestadoordenpago=eop.codigoestadoordenpago) 
                WHERE g.idGrupo='" . $id . "' order by concat(eg.nombresestudiantegeneral, '  ' , eg.apellidosestudiantegeneral) ASC, op.fechaordenpago DESC";
            $rows = $db->GetAll($sql);

            $rows2 = $db->GetAll($sql2);

            $rows = array_merge($rows, $rows2);
        }

        return $rows;
    }

}
