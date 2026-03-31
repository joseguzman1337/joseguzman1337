<?php 


		$msgbox=imap_open ("{correo.unbosque.edu.co/pop3:110/notls}Inbox", "lopezjavier", "javeetounbosque");
		if($msgbox)
		{
			echo "Entro";
		}
		else{
			echo "No entro";
		}
			
?>