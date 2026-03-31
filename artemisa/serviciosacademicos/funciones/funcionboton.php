<?php
/**
* @modifed Ivan dario quintero rios <quinteroivan@unbosque.edu.co>
* @since Mayo 8 del 2019
* Limpieza de codigo, modificaicion de funciones depreciadas
*/

// Crea un menu de botones, trae todos los botones que tiene un script
// Esta función recibe el usuario, el nombre del script y la conexión
function crearmenubotones($usuario, $script, $valores, $sala){
    $query_selrol = "SELECT mb.posicionmenuboton, mb.nombremenuboton, mb.linkmenuboton, mb.linkimagenboton, ".
    " mb.codigotipomenuboton, mb.variablesmenuboton, mb.propiedadesimagenmenuboton, mb.propiedadesmenuboton  ".
    " FROM ".
    " permisorolboton pb INNER JOIN menuboton mb ON (mb.idmenuboton = pb.idmenuboton) ".
    " INNER JOIN usuariorol ur ON (ur.idrol = pb.idrol) ".
    " INNER JOIN UsuarioTipo ut ON (ut.UsuarioTipoId = ur.idusuariotipo) ".
    " INNER JOIN usuario u ON  (u.idusuario = ut.UsuarioId) ".
    " WHERE ".
    " mb.codigoestadomenuboton = '01' AND mb.scriptmenuboton = '".$script."' ".
    " AND u.usuario ='".$usuario."' AND ".
        "( SELECT codigocarrera FROM estudiante	WHERE codigoestudiante = '".$_SESSION['codigo']."') ORDER BY 1";
    $selrol = mysql_query($query_selrol, $sala) or die("$query_selrol".mysql_error());
    $totalRows_selrol = mysql_num_rows($selrol);
    while($row_selrol = mysql_fetch_assoc($selrol)){		
        if($row_selrol['codigotipomenuboton'] == 100){
            crearbotonreferenciar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
        }
        if($row_selrol['codigotipomenuboton'] == 200){
            crearbotonsubmit($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
        }
        if($row_selrol['codigotipomenuboton'] == 300){
            crearbotonventanaauxiliar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
        }
        if($row_selrol['codigotipomenuboton'] == 400){            
            /*if(isset($row_selrol['idmenubotoncarrera'])&&(trim($row_selrol['idmenubotoncarrera'])!='')){
                crearbotonreferenciar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
            }*/
        }
    }										
}//function crearmenubotones

// Trae un boton especifico de un script
// Recibe de mas el nombre del boton
function crearunicoboton($usuario, $script, $valores, $idboton, $sala){
    $query_selrol = "select m.posicionmenuboton, m.nombremenuboton, m.linkmenuboton, m.linkimagenboton,".
    " m.codigotipomenuboton, m.variablesmenuboton, m.propiedadesimagenmenuboton, m.propiedadesmenuboton ".
    " from usuariorol ur, menuboton m, permisorolboton p, UsuarioTipo ut, usuario u ".
    " where u.usuario = '".$usuario."' ".
    " AND u.idusuario = ut.UsuarioId ".
    " AND ur.idusuariotipo = ut.UsuarioTipoId ".
    " AND ur.idrol = p.idrol ".
    " and p.idmenuboton = m.idmenuboton ".
    " and m.scriptmenuboton = '".$script."' ".
    " and m.codigoestadomenuboton = '01' ".
    " and m.idmenuboton = '".$idboton."' order by 1";	    
    $selrol = mysql_query($query_selrol, $sala) or die("$query_selrol".mysql_error());
    $totalRows_selrol = mysql_num_rows($selrol);
    while($row_selrol = mysql_fetch_assoc($selrol)){
        if($row_selrol['codigotipomenuboton'] == 100){
            crearbotonreferenciar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
        }
        if($row_selrol['codigotipomenuboton'] == 200){
            crearbotonsubmit($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
        }
        if($row_selrol['codigotipomenuboton'] == 300){
            crearbotonventanaauxiliar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);	
        }
    }										
}//function crearunicoboton

// Esta función crea un boton con referencia, recibe el nombre, referencia, imágen y las variables a pasar al hacer el get.
//  Y los valores que va a tener cada una de las variables 
function crearbotonreferenciar($nombre, $referencia, $imagen, $variables, $valores, $propiedadesimagen, $propiedades = "", $link=true){
    $cadenavariables = "?";
    foreach($variables as $key => $value){
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega el else para que tambien incluya parametros con valores vacios
         * @since Mayo 17, 2019
         */ 
        if(isset($valores[$value]) && !empty($valores[$value])){
            $cadenavariables = $cadenavariables.$value."=".$valores[$value]."&";
        }else{
            $cadenavariables = $cadenavariables.$value."&";
        }
    }
    //$cadenavariables = preg_match("/&$/","",$cadenavariables);
    
    if($imagen != ""){
        ?>
	<a href="<?php echo $referencia.$cadenavariables;?>" title="<?php echo $nombre; ?>">
        <img src="<?php echo $imagen; ?>" <?php echo $propiedadesimagen ?> alt="<?php echo $nombre ?>" style="border-color:#FFFFFF"></a> 
        <?php
    }else if(!$link){
        ?>
        <input type="button" name="<?php echo $nombre ?>" value="<?php echo $nombre ?>" onClick="<?php echo "window.location.reload('".$referencia.$cadenavariables."')";?>">
        <?php	
    }else{
        ?>
	- <a href="<?php echo $referencia.$cadenavariables;?>" name="aparencialinknaranja" id="aparencialinknaranja"><?php echo $nombre ?></a> 
        <?php
    }
}//function crearbotonreferenciar

function crearbotonventanaauxiliar($nombre, $referencia, $imagen, $variables, $valores, $propiedadesimagen, $propiedades = ""){
    $cadenavariables = "?";
    foreach($variables as $key => $value){
        if(isset($valores[$value]) && !empty($valores[$value]) ){
            $cadenavariables = $cadenavariables.$value."=".$valores[$value]."&";
        }
    }
    //$cadenavariables = preg_match("/&$/","",$cadenavariables);
    if($imagen != ""){
        ?>
        <a onClick="<?php echo "window.open('".$referencia.$cadenavariables."'".$propiedades.")";?>" style="cursor:pointer">
	<!-- style="border:2px solid blue;" -->
	<img src="<?php echo $imagen; ?>" <?php echo $propiedadesimagen ?> alt="<?php echo $nombre ?>"></a>
        <?php
    }else{
        ?>
        <input type="button" name="<?php echo $nombre ?>" value="<?php echo $nombre ?>" onClick="<?php echo "window.open('".$referencia.$cadenavariables."'".$propiedades.")";?>">
        <?php	
    }
}//function crearbotonventanaauxiliar

function crearbotonsubmit($nombre, $referencia, $imagen, $variables, $valores, $propiedadesimagen, $propiedades = ""){
    $cadenavariables = "?";
    foreach($variables as $key => $value){
        $cadenavariables = $cadenavariables.$value."=".$valores[$value]."&";
    }
    $cadenavariables = preg_match("/&$/","",$cadenavariables);
    if($imagen != ""){
        ?>
        <a onClick="<?php echo "$propiedades";?>" style="cursor:pointer">
	<input type="hidden" name="<?php echo $nombre;?>" value="<?php echo $nombre;?>">
        <img src="<?php echo $imagen; ?>" <?php echo $propiedadesimagen ?> alt="<?php echo $nombre ?>" style="border:2px solid blue;"></a>
        <?php
    }else{
        ?>
        <input type="submit" name="<?php echo $nombre;?>" value="<?php echo $nombre;?>" onClick="<?php echo $propiedades; ?>">
        <?php	
    }
}//function crearbotonsubmit

function tienepermiso($usuario, $script, $sala){
    $query_selrol = "select m.posicionmenuboton, m.nombremenuboton, m.linkmenuboton, ".
    " m.linkimagenboton, m.codigotipomenuboton, m.variablesmenuboton, m.propiedadesimagenmenuboton, ".
    " m.propiedadesmenuboton from usuariorol ur, menuboton m, permisorolboton p, UsuarioTipo ut, usuario u ".
    " where u.usuario = '".$usuario."' ".
    " AND u.idusuario = ut.UsuarioId ".
    " AND ur.idusuariotipo = ut.UsuarioTipoId ".
    " AND ur.idrol = p.idrol ".
    " and p.idmenuboton = m.idmenuboton ".
    " and m.scriptmenuboton = '".$script."' ".
    " and m.codigoestadomenuboton = '01' order by 1";
    $selrol = mysql_query($query_selrol, $sala) or die("$query_selrol".mysql_error());
    $totalRows_selrol = mysql_num_rows($selrol);
    if($totalRows_selrol != ""){
        return true;
    }
    return false;
}//function tienepermiso
