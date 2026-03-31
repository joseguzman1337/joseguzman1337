<?php
class ipidentificar 
{
    function tomarip()
	{
		if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else
		{
			if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"]))
			{
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			}
			else
			{
				if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"]))
				{
					$ip = $_SERVER["REMOTE_HOST"];
				}
				else
				{
					$ip = $_SERVER["REMOTE_ADDR"];
				}
			}
		}
		return $ip;
	}
}
?>