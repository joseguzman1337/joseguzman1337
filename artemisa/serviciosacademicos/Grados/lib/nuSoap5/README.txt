This is an example of using NetSuite WebServices with PHP as well as other services (in this case Google Maps).

External Tools:
PHP 5 (http://www.php.net)
NuSoap (http://sourceforge.net/projects/nusoap/)
Phoogle - Google Maps PHP interface (http://www.system7designs.com/codebase)

Important notes:
PHP 5 and NuSoap do not play nicely, PHP 5 has it's own definition of the SoapClient class. As such I renamed SoapClient to SoapClientW. Thus we are redistributing the NuSoap PHP (GPL license).


Important Features in this sample code

1) How to login and pass cookies between http requests
  login.php handles this by capturing the cookies returned from NetSuite and making those cookies in php application
2) How to deal with abstract types
  All known PHP tools do not have the sophistication to process the NetSuite abstract types (such as BaseRef vs RecordRef)
  nslib.php contains a set of classes that know how to serialize themselves.
  

