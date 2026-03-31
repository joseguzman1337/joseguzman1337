<?php
// La secuencia básica para trabajar con LDAP es conectar, autentificarse,
// buscar, interpretar el resultado de la búsqueda y cerrar la conexión.
//phpinfo();
echo "<h3>Prueba de consulta LDAP</h3>";
echo "Conectando ...";

if($ds=ldap_connect("172.16.1.6","389"))  // Debe ser un servidor LDAP válido!
	echo "Se conecto la caneca ".$ds."<p>";
else
	echo "no se pudo conectar esta cascara ".$ds."<p>";
			# Go with LDAP version 3 if possible (needed for renaming and Novell schema fetching)
		@ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION,3);

		/* Disabling this makes it possible to browse the tree for Active Directory, and seems
		 * to not affect other LDAP servers (tested with OpenLDAP) as phpLDAPadmin explicitly
		 * specifies deref behavior for each ldap_search operation. */
		@ldap_set_option($ds,LDAP_OPT_REFERRALS,0);

if ($ds) { 
    echo "Autentificandose  ..."; 
	/*if($result1=@ldap_bind($ds,"cn=Manager,dc=adminldap,dc=com","adminldap")){
		*///echo "Entro al primero<br>";
		if($result2=ldap_bind($ds,"cn=Manager,dc=unbosque,dc=edu,dc=co","bosque")){
				//cn=Manager,dc=adminldap,dc=com
				echo " se conecto esta caneca<br>";
		
			}
			else{
			echo "no se conecto correctamente esta caneca<br>";
	}		}     // Autentificación anónima, típicamente con
								   // acceso de lectura
	/*}*/
//if($result2=@ldap_bind($ds,"cn=villajuan,ou=Docente,dc=adminldap,dc=com","docente"))
  //  echo "El resultado de la autentificación es ".$result2."<p>";

//    echo "Buscando (sn=P*) ...";
    // Busqueda de entradas por apellidos
/*    $sr=ldap_search($ds,"dc=adminldap,dc=com", "uid=villajuan");  
    echo "El resultado de la búsqueda es ".$sr."<p>";

    echo "El número de entradas devueltas es ".ldap_count_entries($ds,$sr)."<p>";

    echo "Recuperando entradas ...<p>";
    $info = ldap_get_entries($ds, $sr);
    echo "Devueltos datos de ".$info["count"]." entradas:<p>";
echo "<pre>";
print_r($info);
echo "</pre>";
if($info[0]["userpassword"][0]=="{MD5}".base64_encode(pack("H*",md5("docente"))))
	echo "entro a esta caneca y se logueo el paciente";

echo $info[0]["userpassword"][0]." Entre <br>";
echo "{MD5}".base64_encode(pack("H*",md5("docente")))." Entre <br>";

    for ($i=0; $i<$info["count"]; $i++) {
        echo "dn es: ". $info[$i]["dn"] ."<br>";
        echo "La primera entrada cn es: ". $info[$i]["cn"][0] ."<br>";
        echo "La primera entrada email es: ". $info[$i]["mail"][0] ."<p>";
    }

    echo "Cerrando conexión";
    ldap_close($ds);

} else {
    echo "<h4>Ha sido imposible conectar al servidor LDAP</h4>";
}*/
?>
