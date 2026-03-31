<?php

 

 // Pagina Paso_1.php

 define('PASO1_TITULO','Escolha o idioma');

 define('PASO1_ES','Espanhol');

 define('PASO1_EN','Inglês');

 define('PASO1_PT','Português');

 

 // Pagina Paso_2.php

 define('PASO2_TITULO','Bem-vindo ao instalador de Celsius!!!!');

 define('PASO2_SUBTITULO','Dados iniciais para a instalação');

 define('PASO2_LABEL_TIPOINSTALACION','Tipo de instalação');

 define('PASO2_RADIO_TIPOINSTALACION_INSTALACION','Nova instalação ');

 define('PASO2_RADIO_TIPOINSTALACION_ACTUALIZACION','Atualização');

 define('PASO2_LABEL_HOSTMYSQL','Host de MySQL');

 define('PASO2_LABEL_USUARIOMYSQL','Usuario root do MySQL');

 define('PASO2_LABEL_PASSWORDMYSQL','Password root do MySQL');

 define('PASO2_LABEL_NOMBREBASE','Nome da nova base de dados para o CelsiusNT');

 define('PASO2_JS_HOSTMYSQL','E preciso ingressar o nome ou o ip do host onde se encontra o mysql');

 define('PASO2_JS_USUARIOMYSQL',' E preciso ingressar o usuário do root mysql');

 define('PASO2_JS_PASSWORDMYSQL',' E preciso ingressar o password do root mysql');

 define('PASO2_JS_NOMBREBASE',' E preciso ingressar o nome que a nova base de dados Celsius vai ter');

 

// Pagina Paso_3.php

 

 define('PASO3_SUBTITULO_ACTUALIZACION','Dados da Base de Dados utilizada pelo Celsius 1.6');

 define('PASO3_LABEL_ACTUALIZACION_BDNAME','DBName 16');

 define('PASO3_SUBTITULO_USUARIOCELSIUS','Usuario do Mysql do CelsiusNT');

 define('PASO3_TEXT_INFORMACION', 'E preciso ingressar os dados de usuário que deverá usar CelsiusNT para se conectar com a BDD.

                                   Se o usuário não existir, será criado automáticamente');

 define('PASO3_LABEL_USUARIOCELSIUSMYSQL','Nome de usuário do Celsius para o MySQL');

 define('PASO3_LABEL_PASSWORDCELSIUSMYSQL','Password do Celsius para o MySQL');

 define('PASO3_JS_NOMBREBD','E preciso ingressar o nome da BDD que utiliza atualmente o seu Celsius 1.6');

 define('PASO3_JS_NOMBREUSUARIOMYSQL','E preciso ingressar os dados de usuário do mysql que utilizará CelsiusNT');

 define('PASO3_JS_PASSWORDUSUARIOMYSQL','E preciso ingressar o password do mysql que utilizará CelsiusNT');

 

 

 

 //Pagina Paso_4.php

 define('PASO4_SUBTITULO','Carregando os dados na BDD do CelsiusNT (Esta operação pode demorar uns minutos)');

 define('PASO4_MENSAJE_DATOSINICIALES','Carregando os dados iniciais na BDD do celsiusNT');

 define('PASO4_MENSAJE_ERROR_DATOSINICIALES','Tem acontecido um erro ao tentar carregar os dados iniciais na BDD de CelsiusNT');

 define('PASO4_MENSAJE_MIGRACIONBDD','Mudando os dados da BDD 1.6 para a NT');

 define('PASO4_MENSAJE_ERROR_MIGRACIONBDD','Tem acontecido um erro ao tentar mudar os dados');

 define('PASO4_MENSAJE_PURGANDO','Purgando os dados da versão 1.6');

 define('PASO4_MENSAJE_ERROR_PURGANDO','Tem acontecido um erro ao tentar purgar os dados da BDD do Celsius 1.6.');

 define('PASO4_MENSAJE_ACTUALIZACIONPIDU','Atualizando o PIDU do Celsius 1.6 ja instalado');

 define('PASO4_MENSAJE_ERROR_ACTUALIZACIONPIDU','Tem acontecido um erro ao tentar actualizar o PIDU da BDD de Celsius 1.6.');

 define('PASO4_MENSAJE_ACTUALIZACIONDATOS','Atualizando los datos do Celsius instalado (Parte 2)');

 define('PASO4_MENSAJE_ERROR_ACTUALIZACIONDATOS','Tem acontecido um erro ao tentar actualizar os dados da BDD do Celsius 1.6.');

 define('PASO4_MENSAJE_ACTUALIZACIONPEDIDOS','Atualizando os pedidos e eventos do Celsius 1.6 instalado');

 define('PASO4_MENSAJE_ERROR_ACTUALIZACIONPEDIDOS','Tem acontecido um erro ao tentar actualizar os pedidos e eventos da BDD do Celsius 1.6.');

 define('PASO4_MENSAJE_TRADUCCIONES','Carregando as traduções na BDD do celsiusNT');

 define('PASO4_MENSAJE_ERROR_TRADUCCIONES','Tem acontecido um erro ao tentar carregar as traduções na BDD do CelsiusNT');

 define('PASO4_MENSAJE_CARGANDODATOS2','Carregando os dados iniciais na BDD do CelsiusNT (parte 2)');

 define('PASO4_MENSAJE_TERMINADO','Finalizado');

 

 

 //Pagina Paso_5.php

 define('PASO5_SUBTITULO','Parâmetros da aplicação');

 define('PASO5_LABEL_URLCOMPLETA','Url completa que utilizara Celsius');

 define('PASO5_LABEL_MAILCONTACTO','Email para fazer contacto com a equipe desta instância Celsius');

 define('PASO5_LABEL_TITULOSITIO','Título do site, vai aparecer na parte superior de todas as janelas do site');

 define('PASO5_LABEL_DIRECTORIOUPLOAD','Ruta completa ao diretório de upload');

 define('PASO5_LABEL_DIRECTORIOUPLOADTEMP','Ruta completa ao diretório de arquivos temporais');

 define('PASO5_LABEL_DATOSADMIN','Dados para o usuario admin (administrador de CelsiusNT)');

 define('PASO5_LABEL_DATOSADMINPASSWORD','Ingresse a senha de admin');

 define('PASO5_LABEL_REDATOSADMINPASSWORD','Por Favor, ingresse a senha de admin novamente');

 define('PASO5_SUBTITULO_DIRECTORIO',' Parâmetros do diretório');

 define('PASO5_LABEL_IDCELSIUSLOCAL','id celsius local ATRIBUÍDO PELO DIRETORIO');

 define('PASO5_LABEL_NTENABLED','nt_enabled?');

 define('PASO5_LABEL_PASSWORDDIRECTORIO','Password diretorio ATRIBUÍDO PELO DIRETORIO ');

 define('PASO5_LABEL_URLDIRECTORIO','url diretorio');

 define('PASO5_TEXT_INFORMACION','Não sincronizar CelsiusNT com o  diretório neste momento (Se o celsiusNT funcionar em modalidade distribuída, e condição sine qua non realizar a sincronização com o diretório para o CelsiusNT poder ser usado)');

 define('PASO5_JS_URLCOMPLETA','E preciso ingressar o endereço do site web (url) completo para ter acesso ao CelsiusNT');

 define('PASO5_JS_MAIL','Por favor, ingressar o endereço electrónico que vai ser utilizado para fazer contacto com os usuários de CelsiusNT');

 define('PASO5_JS_TITULOSITIO',' E preciso ingressar o título que aparecerá em todas as janelas de CelsiusNT');

 define('PASO5_JS_DIRECTORIOUPLOAD',' E preciso ingressar o diretório para ser utilizado no upload de archivos');

 define('PASO5_JS_DIRECTORIOTEMP','E preciso ingressar o  diretório temporal para ser utilizado');

 define('PASO5_JS_PASSWORDADMIN','Por favor, ingressar o password do usuário admin do celsiusNT');

 define('PASO5_JS_REPASSOWRD','Por favor ingressar o password do usuário admin do celsiusNT novamente ');

 define('PASO5_JS_ERRORPASSWORD','Atenção: os dados ingressados nos campos de password do usuário admin deven concordar');

 define('PASO5_JS_IDCELSIUSLOCAL','Por favor ingressar o  Id
 Celsius Local (atribuído pelo Diretório CelsiusNT');

 define('PASO5_JS_PASSWORDDIRECTORIO','Por favor, ingressar o password para fazer contacto com o diretório');

 define('PASO5_JS_URLDIRECTORIO','Por favor, ingressar a url para o acesso ao diretorio');

 

 

 //Pagina Paso_6.php

 

 define('PASO6_TITULO','Atualização com o diretório');

 define('PASO6_SUBTITULO','Por favor aguarde, esta operação pode demorar vários minutos...');

 define('PASO6_BUTTON_ACTUALIZAR','Não actualizar por enquanto?');

 define('PASO6_BUTTON_REINTENTAR','Reintentar');

 define('PASO6_MENSAJE_ACTUALIZACIONCORRECTA','A atualização do diretório foi realizada com sucesso');

 define('PASO6_MENSAJE_ERROR_ACTUALIZARDIRECTORIO','Tem acontecido o seguinte erro ao tentar actualizar o diretório.');

 

 

 //Pagina Paso_7.php

 

 define('PASO7_SUBTITULO','Pidu da instância');

 define('PASO7_LABEL_PAIS','Pais');

 define('PASO7_LABEL_INSTITUCION','Instituição');

 define('PASO7_LABEL_DEPENDENCIA','Dependência ');

 define('PASO7_LABEL_UNIDAD','Unidade');

 define('PASO7_JS_PAIS','Por favor, escolher o Pais');

 define('PASO7_JS_INSTITUCION','Por favor, escolher a Instituição');

 

 

 

 //Pagina Paso_8.php

 define('PASO8_TEXT_1','Clique');

 define('PASO8_TEXT_2','AQUI');

 define('PASO8_TEXT_3','Deseja començar a usar o CelsiusNT Agora?');

 

 

 //Pagina base_layout_install.php

 

 define('BASE_LAYOUT_TEXT_1','Produto planejado completamente pelo');

 // Pagina top_layout_install.php

 define('TOP_LAYOUT_TITULO','Instalação Celsius');

 

 //COMMON

 define('COMMON_BUTTON_SIGUIENTE','Seguinte');

 define('COMMON_MENSAJE_ERROR_MYSQL',' Mysql devolveu o seguinte erro');

 define('COMMON_ERROR_BDD','Tem acontecido o seguinte erro na BDD');

 define('COMMON_ERROR_INESPERADO','');

 define('COMMON_ERROR_MYSQL_INCORRECTO','Os dados do mysql são errados ou não é possível fazer contacto com o servidor. Revise o Host, usuário e password ingressados');

 define('COMMON_MENSAJE_ERROR','Mensagem de erro');

 define('COMMON_ERROR_CREAR_BASE','Tem acontecido um erro ao tentar escolher a BD de celsiusNT criada no momento com o seguinte nome');

 define('COMMON_CREO_SATISFACTORIO','Foi criada a estrutura da BDD de CelsiusNT com sucesso');

 define('COMMON_NUMERO_ERROR','Numero do erro');

 define('COMMON_MENSAJE_ERROR_SELECCIONAR_BASE','Tem acontecido um erro ao tentar escolher a BD de celsius ingressada com o seguinte nome');

 define('COMMON_MENSAJE_ERRPR_CARGA_SCRIPT',' Tem acontecido um erro ao tentar executar o script de carga da BDD de celsiusNT');

 define('COMMON_MENSAJE_ERROR_USUARIO',' Tem acontecido um erro ao definir o usuário para celsiusNT. Por favor, checar que o usuário de root ingresado seja exactamente o usuario root de mysql');

 define('COMMON_MENSAJE_ERROR_OLDPASSWORD',' Tem acontecido um erro ao tentar configurar o password de usuário como OLD_PASSWORD');

 define('COMMON_MENSAJE_ERROR_PERMISOS',' Tem acontecido um erro ao fornecer as permissões desde a base de dados do Celsius 1.6 ao usuário de celsiusNT. Por favor checar que o usuário de root ingressado seja exactamente o usuário root de mysql');

 define('COMMON_MENSAJE_ERROR_ARCHIV','Não foi possível criar o arquivo de configuração do CelsiusNT');

 define('COMMON_MENSAJE_ARCHIVO_SATISFACTORIO','O arquivo de configuração do CelsiusNT foi criado com sucesso');

 define('COMMON_MENSAJE_ERROR_PARAMETROS','Tem acontecido um erro ao tentar guardar os parâmetros na tábua de parâmetros da BDD de CelsiusNT');

 define('COMMON_MENSAJE_ERROR_MODIFICARWSDL','Tem acontecido um erro ao tentar modificar os arquivos wsdl');

 define('COMMON_MENSAJE_PARAMETROS_SATISFACTORIO','Foram carregados com sucesso os dados na tábua de parâmetros do mysql');

  define('COMMON_MENSAJE_ERROR_SCRIPTPIDU','Tem acontecido ao tentar executar o script com os dados iniciais do PIDU');

 define('COMMON_MENSAJE_ERROR_CREARUSUARIO','Tem acontecido um erro ao tentar criar o usuário admin de CelsiusNT');

 define('COMMON_MENSAJE_ERROR_GUARDARPIDU',' Tem acontecido um erro ao tentar guardar o PIDU na tábua de parâmetros da BDD de CelsiusNT ');

 define('COMMON_MENSAJE_ERROR_CREAR_ARCHIVOPARAMETROS','Não foi possível criar o arquivo parametros.properties.php é possível que o servidor web não tenha privilégios sobre o diretório common. O arquivo deveria ser gerado manualmente, e guardado no diretório common dentro do diretório CelsiusNT');

 define('COMMON_MENSAJE_ERROR_PROPERTIES','" O erro que aconteceu e o seguinte');

 define('COMMON_MENSAJE_CONTENIDO_ARCHIVO','O conteúdo do arquivo deveria ser');

 define('COMMON_MENSAJE_ERROR_COPIARBASE',' Tem acontecido o seguinte erro ao tentar copiar os dados da BDD');

 define('COMMON_MENSAJE_ERROR_COPIARDATOS',' Tem acontecido o seguinte erro ao copiar os dados comuns de la BDD');

 define('COMMON_MENSAJE_ERROR_EJECUTAR_SCRIPT',' Tem acontecido o seguinte erro ao tentar executar o script do arquivo');

 define('COMMON_MENSAJE_ERROR_ACCEDER_ARCHIVO',' Tem acontecido o seguinte um erro inesperado. Ocorreu um problema ao acessar ao arquivo');

 define('COMMON_MENSAJE_ERROR_NOLEER','Não foi possível ler o  archivo');

 define('COMMON_MENSAJE_ERROR_PERMISOARCHIVOS',' Revise que o arquivo exista e que as permissões sejam corretas');

 //define();

 define('PASO0_ERROR_ESCRITURA','Error: O diretório');
 define('PAS00_ERROR_ESCRITURA1','Não tem permissão de escrita - E Requerido para a Instalacão');
 define('PASO0_WARNING_VARIABLE',' Para o CELSIUS NT  funcionar corretamente, a variável de ambiente de PHP chamada  ');
 define('PASO0_WARNING_VARIABLE1',' (de valor atual ');
 define('PASO0_WARNING_VARIABLE2',') deveria ter o valor  ');
 
 define('PASO0_BUTTON_CONTINUAR','Continuar');

 

?>


