<?php
class ean128
{
	function ean128($cadena)
	{
		$this->cadena="Ê".$cadena;

	}
	function codificar()
	{
		$checksum=0;
		if(strlen($this->cadena)>0)
		{
			//valida los caracteres
			for($this->i=0;$this->i <= strlen($this->cadena);$this->i++)
			{
				$ascii=ord(substr($this->cadena,$this->i,1));
				//echo $ascii,"<br>";
				if($ascii >=32 and $ascii <=126)
				{}
				elseif($ascii=198 or $ascii=202)
				{}
				else
				{
					$this->i=0;
					break;
				}
			}
			//calcula el codigo de la cadena con uso optimizado para tablas b y c
			$ean128="";
			$this->tablaB=true;
			if($this->i > 0)
			{
				$this->i=1; //se convierte en el indice de la cadena
				do
				{
					if($this->tablaB)
					{
						//mira si se debe cambiar a tabla C
						//si para 4 digitos al comienzo o al final, no si son 6 digitos
						if($this->i==1 or $this->i+3==strlen($this->cadena))
						{
							$this->mini=4;
						}
						else
						{
							$this->mini=6;
						}
						$this->testnumorfnc1();
						if($this->mini < 0)//si si, selecciona tabla c
						{
							if($this->i==1)//comenzando con tabla c
							{
								$ean128=chr(205);
							}
							else//cambia a tabla c
							{
								$ean128=$ean128.chr(199);
							}
							$this->tablaB=false;
						}
						else
						{
							if($this->i==1)
							{
								$ean128=chr(204);//comenzando con tabla b
							}
						}
					}
					if(!$this->tablaB)
					{
						//estamos en tabla c, se intenta procesar 2 digitos o Ê
						$prueba=substr($this->cadena,$this->i-1,2);
						if(ord(substr($this->cadena,$this->i-1,2))==202)
						{
							//Se procesa el Fnc1(Ê)
							$ean128=$ean128.substr($this->cadena,$this->i-1,1);
							$this->i=$this->i+1;
						}
						else
						{
							$this->mini=2;
							$this->testnum();
							if($this->mini < 0)//OK para 2 digitos, procesar
							{
								//$prueba2=substr($this->cadena,$this->i-1,2);
								$dummy = ereg_replace("[^0-9]",null,substr($this->cadena,$this->i-1,2));
								if($dummy < 95)
								{
									$dummy=$dummy+32;
								}
								else
								{
									$dummy=$dummy+100;
								}
								$ean128=$ean128.chr($dummy);
								$this->i=$this->i+2;
							}
							else//no se tienen 2 digitos, cambiar a tabla b
							{
								$ean128=$ean128.chr(200);
								$this->tablaB=true;
								
							}

						}
					}
					if($this->tablaB==true)
					{
						//procesar digito 1 con tabla b
						$ean128=$ean128.substr($this->cadena,$this->i,1);
						$this->i=$this->i+1;
					}
				}
				while ($this->i <= strlen($this->cadena));
				//calcular checksum de verificacion
				for($this->i=0;$this->i <= strlen($this->cadena); $this->i++)
				{
					$dummy=ord(substr($ean128,$this->i,1));
					if($dummy < 127)
					{
						$dummy=$dummy-32;
					}
					else
					{
						$dummy=$dummy-100;
					}
					if($this->i==0)
					{
						$checksum=$dummy;
					}
					//checksum& = (checksum& + (i% - 1) * dummy%) Mod 103
					$checksum=($checksum+($this->i) * $dummy) % 103;
					if($checksum<0)
					{
						$checksum=$checksum*-1;
					}
				}
				//calcular el checksum codigo ascii
				if($checksum<95)
				{
					$checksum=$checksum+32;
					
				}
				else
				{
					$checksum=$checksum+100;
	
				}

				//agregar checksum y el stop
				$checksum=$checksum-1;
				$ean128=$ean128.chr($checksum).chr(206);
				//echo $checksum,"<br>";
				 
			}

		}
		return $ean128;
	}
	function testnumorfnc1()
	{
		//si los caracteres $mini de $i son numericos, entonces $mini=0
		$this->mini=$this->mini-1;
		if($this->i+$this->mini <= strlen($this->cadena))
		{

			do
			{
				if(ord(substr($this->cadena,$this->i-1+$this->mini,1)) < 48 or ord(substr($this->cadena,$this->i-1+$this->mini,1)) > 57 and ord(substr($this->cadena,$this->i-1+$this->mini,1)) <> 202)
				{

					break;
				}
				else
				{
					$this->mini=$this->mini-1;
				}
			}
			while ($this->mini >= 0);
		}
	}
	function testnum()
	{
		//si los caracteres de $mini son numericos, entonces $mini=0
		/*
		TestNum:
  'if the mini% characters from i% are numeric, then mini%=0
  mini% = mini% - 1
  If i% + mini% <= Len(chaine$) Then
    Do While mini% >= 0
      If Asc(Mid$(chaine$, i% + mini%, 1)) < 48 Or Asc(Mid$(chaine$, i% + mini%, 1)) > 57 Then Exit Do
      mini% = mini% - 1
    Loop
  End If
Return
*/
		$this->mini=$this->mini-1;
		if($this->i-1 + $this->mini <= strlen($this->cadena))
		{
			do
			{
				//If Asc(Mid$(chaine$, i% + mini%, 1)) < 48 Or Asc(Mid$(chaine$, i% + mini%, 1)) > 57 Then Exit Do
				if(ord(substr($this->cadena,$this->i-1+$this->mini,1)) < 48 or ord(substr($this->cadena,$this->i-1+$this->mini,1)) > 57)
				{
					break;
				}
				$this->mini=$this->mini-1;
			}
			while ($this->mini >= 0);
		}
		return;
	}
}
?>
