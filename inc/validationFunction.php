<?php
	class ReasonMessage
  {
    const InputNull = 0; // Input Boş
    const TypeError = 1; // İstenilen Tip Değil
    const MaxLengthError = 2; // Maksimum Uzunluk Kriterinden Büyük
    const MinLengthError = 3; // Minimum Uzunluk Kriterinden Küçük
  }
    
	class ValidationResult
	{
		public $IsValid; // Input geçerli ise true döndürür, geçersizse false.
		public $Reason; // Input değerinin neden geçersiz olduğunu döndürür. Türü ReasonMessage'dir
		public $ValidatedInput; // Input un doğrulamadan geçmiş halini verir. Eğer IsValid false ise ValidatedInput un değeri Null olur.
	}
	
	/* validationInput() Fonksiyonu Kullanımı
		>Girdi Parametreleri
			>$userInput
			>$type
				Kontrol Tipleri: 
					String (Sadece harf içeren metin)
					Text (Özel karakterler ve noktalama işaretlerini destekliyor)
					Alphanumeric (Sadece harf ve rakamlardan oluşan metinleri kontrol ediyor.)
					İnt, Email
			>*minLength (Değer girilmezse uzunluk kriterini kontrol etmez.)
				Input un minimum karakter uzunluğu kriteri
			>*maxLength	Değer girilmezse uzunluk kriterini kontrol etmez.)	
				Input un maksimum karakter uzunluğu kriteri
		>Fonksiyondan	ValidationResult nesnesiyle sonuç değerlerini döndürür.	
		
	*/
	function validationInput($userInput, $type, $minLength, $maxLength)
	{
		$ReasonMessage = new ReasonMessage;
	
		$validationResult = new ValidationResult();
		$str_length = strlen($userInput);
		$userInput = stripslashes(trim(strip_tags($userInput)));
		$userInput = mysql_real_escape_string($userInput);
		$type = trim(strip_tags($type));
		$type = mysql_real_escape_string($type);
		
		if($userInput != ""  && $type != "" && $minLength != "" && $maxLength != "")
		{
			if ($type == "string")
			{
				if (!preg_match("/^[a-zA-Z_\ç\ı\ğ\ö\ş\ü\Ç\İ\Ğ\Ö\Ş\Ü\s]*$/",$userInput) )
				{
					$validation=0;
				}
				else
				{
					$validation=1;
				}
			}
			else if ($type == "alphanumeric")
			{
				if (!preg_match("/^[-0-9A-Z_@üğişöçÜĞİŞÖÇ\s]+$/i",$userInput) )
				{
					$validation = 0;
				}
				else
				{
					$validation = 1;
				}	
			}			
			else if ($type == "email")
			{
				if ( !filter_var($userInput, FILTER_VALIDATE_EMAIL ) )
				{
					$validation = 0;
				}
				else
				{
					$validation = 1;
				}	
			}			
			else if ($type == "int")
			{
				if( !filter_var($userInput, FILTER_VALIDATE_INT) )
				{
					$validation = 0;
				}
				else
				{
					$validation = 1;
				}
			}			
			else if($type == "text")
			{
				if( !filter_var($userInput, FILTER_SANITIZE_STRING) )
				{
					$validation = 0;
				}
				else
				{
					$validation = 1;
				}
			}
			else
			{
				echo "input tipi belirtiniz.";
			}
			
			// karakter uzunluğu
			
				if($minLength != "")
				{
					if($str_length >= $minLength)
					{
						$min_r = 1;
					}
				}
				
				if ($maxLength != "")
				{
					if($str_length <= $maxLength)
					{
						$max_r = 1;
					}
				}
				
				//Sonuç Yazdırma
				
				if ($validation == 1 && $min_r == 1 && $max_r == 1)
				{
					$validationResult->IsValid = true;
					$validationResult->Reason = null;
					$validationResult->ValidatedInput = $userInput;
					return $validationResult;
				}				
				else if ($validation == 0)
				{
					$validationResult->IsValid = false;
					$validationResult->Reason = ReasonMessage::TypeError;
					$validationResult->ValidatedInput = null;
					return $validationResult;
				}				
				else if ($min_r == 0)
				{
					$validationResult->IsValid = false;
					$validationResult->Reason = ReasonMessage::MinLengthError;
					$validationResult->ValidatedInput = null;
					return $validationResult;
				}				
				else if ($max_r == 0)
				{
					$validationResult->IsValid = false;
					$validationResult->Reason = ReasonMessage::MaxLengthError;
					$validationResult->ValidatedInput = null;
					return $validationResult;
				}			
		}		
		else if($userInput != ""  && $type != "" && ($minLength == "" || $maxLength == ""))
		{
			if ($type == "string")
			{
				if (!preg_match("/^[a-zA-Z_\ç\ı\ğ\ö\ş\ü\Ç\İ\Ğ\Ö\Ş\Ü\s]*$/",$userInput) )
				{
					$value_result=0;
				}
				else
				{
					$value_result=1;
				}
			}
			else if ($type == "alphanumeric")
			{
				if (!preg_match("/^[-0-9A-Z_@üğişöçÜĞİŞÖÇ\s]+$/i",$userInput) )
				{
					$value_result=0;
				}
				else
				{
					$value_result=1;
				}
			}
			else if ($type == "email")
			{
				$userInput = filter_var($userInput, FILTER_VALIDATE_EMAIL);
        
				if ( !filter_var($userInput, FILTER_VALIDATE_EMAIL ) )
				{
					$value_result = 0;
				}
				else
				{
					$value_result = 1;
				}	
			}
			else if ($type == "int")
			{
				$userInput = filter_var($userInput, FILTER_VALIDATE_INT);
        
				if( !filter_var($userInput, FILTER_VALIDATE_INT) )
				{
					$value_result = 0;
				}
				else
				{
					$value_result = 1;
				}
			}			
			else if ($type == "text")
			{
				$userInput = filter_var($userInput, FILTER_SANITIZE_STRING);
        
				if ( !filter_var($userInput, FILTER_SANITIZE_STRING) )
				{
					$value_result = 0;
				}
				else
				{
					$value_result = 1;
				}
			}
			
			if ($value_result == 1)
			{
				$validationResult->IsValid = true;
				$validationResult->Reason = null;
				$validationResult->ValidatedInput = $userInput;
				return $validationResult;
			}
			else
			{
				$validationResult->IsValid = false;
				$validationResult->Reason = ReasonMessage::TypeError;
				$validationResult->ValidatedInput = null;
				return $validationResult;
			}			
		}
		else
		{
			$validationResult->IsValid = false;
			$validationResult->Reason = ReasonMessage::InputNull;
			$validationResult->ValidatedInput = null;
			return $validationResult;
		}
	}
	
	//------------------------------------------------------------

	// $userInput = $_POST['userInput'];
	// $type = $_POST['type'];
	// $minLength = $_POST['minLength'];
	// $maxLength = $_POST['maxLength'];
	
	// $resultReturn = validationInput($userInput, $type, $minLength, $maxLength);
	
	// if($resultReturn->IsValid == true)
	// {
		// echo "<br><span style='color:green'>İşlem: Onay</span>";
	// }
	// else
	// {
		// echo "<br><span style='color:red'>İşlem: Başarısız</span>";
	// }
	
	// if($resultReturn->Reason == null)
	// {
		// echo "<br><span style='color:green'>Onay</span>";
	// }
	// else
	// {
		// $sonuc = $resultReturn->Reason;
		// echo "<br><span style='color:red'>$sonuc</span>";
	// }
	
	// if($resultReturn->ValidatedInput == null)
	// {
		// echo "<br><span style='color:red'>Dönen Değer: Boş</span>";
	// }
	// else
	// {
		// $sonuc = $resultReturn->ValidatedInput;
		// echo " <br><span style='color:green'>Sonuç: $sonuc</span>";
	// }
	
?>



