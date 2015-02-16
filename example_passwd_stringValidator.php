<?php

/*-------------------------------------------------PASSWORD VALIDATOR ( EXAMPLE)--------------------------------------------------*/
/* ------------------------------------------------This is EXAMPLE APPLICATION OF string_ValidatorClass.php-----------------------*/

/*This PHP File Implemets a Rassword Validator Function Which Checks if 
Password Contain Atleast 6 Letters
If Contain Special Char ,alphabet and Digit
@author argunner
github.com/argunner
*/

include('string_ValidatorClass.php');
$passwd="1234567@a";
$instance = new string_Validator();



if(!$instance->check_length($passwd,6)){

	if(!$instance->if_alpha($passwd)){

		if(!$instance->if_digit($passwd)){

			if(!$instance->if_contain_special_chars($passwd)){

				echo "Seems Like Good Password";
			}
			else{

				echo "Password Must Contain A Special Character";
			}
		}
		else{

			echo "Password Must Contain A Numeric Digit";
		}

	}

	else{

		echo "Password Must Contain An Alphabet";


	}	
}
else{

	echo "Password Must Contain Atleast 6 Letters";

}

