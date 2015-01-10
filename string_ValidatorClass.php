<?php

	/**-----------------------------------------------------
	 * This is a Php class to handle the common string validator task
	 	using Regex
	 	like string of limited length,if_email,if_only_alpha,if_only_digit,
	 	if_contain_special_chars

	 * @author argunner
	 	http://github/argunner
	 --------------------------------------------------------*/

	 class string_Validator{


	 	/* if_email() function checks weather Given String is a Valid Email Address Or Not
	 		Returns TRUE if String is valid Email
	 		Returns False if String is not valid Email
	 	*/

	 	public function if_email($email){

	 		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  			{
  				return false;
  			}
			else
  			{
  				return true;
  			}

	 	}


	 	/* if_contain_special_chars() checks weather Given String Contains special chars or not.
	 		Returns true if does not contain special chars
	 		Returns flase if contain special chars 
	 	*/

	 	public function if_contain_special_chars($string){

	 		if (!preg_match('/[^A-Za-z0-9]/', $string)) // '/[^a-z\d]/i' should also work.
			{
  				//does not contain special chars
  				return true;

			}
			else
			{
				return false;
			}
		}


		/* if_only_digit() checks weather Given String Contains Only Digits Or Not.
	 		Returns true if contains only digits
	 		Returns flase if contains anything other than digit. 
	 	*/


		public function if_only_digit($string){

			if(!preg_match('/[^0-9]/',$string))
			{

				return true;
			}
			
			else{

				return false;
			}
		}



		/* if_digit() checks weather Given String Contains A Digits Or Not.
	 		Returns true if contains a digit
	 		Returns flase if contains anything other than digit. 
	 	*/

		public function if_digit($string){

			if(!preg_match('/[0-9]/',$string))
			{

				return true;
			}
			
			else{

				return false;
			}
		}




		/* if_only_alpha() checks weather Given String Contains Only Alphabet Or Not.
	 		Returns true if contains only alpha
	 		Returns flase if contains anything other than alpha. 
	 	*/


		public function if_only_alpha($string){

			if(!preg_match('/[^a-z]/',$string))
			{

				return true;
			}
			
			else{

				return false;
			}
		}


		/* if_alpha() checks weather Given String Contains an Alphabet Or Not.
	 		Returns true if contains only alpha
	 		Returns flase if contains anything other than alpha. 
	 	*/


		public function if_alpha($string){

			if(!preg_match('/[a-z]/',$string))
			{

				return true;
			}
			
			else{

				return false;
			}
		}



		/* check_length() checks weather Given String is Under Limit or Not
	 		Returns true if String is Under Limit
	 		Returns flase if String Exceeds Limit. 
	 	*/

		public function check_length($string,$limit){


			if( strlen($string) <= $limit){

				return true;
			}
			else{

				return false;
			}


		}








	 }




	 
