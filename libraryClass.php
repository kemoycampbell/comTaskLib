<?php

	/**-----------------------------------------------------
	 * This is a Php library to handle the common php task
	   such as database connection, connection status, insert,
	   delete, update, isCredentialValid, etc, get connectionError Message,
	   get the name of connected database
	 * @author Kemoy Campbell
	 --------------------------------------------------------*/ 
	 class Library
	 {
		private $dbname;
		private $dbusername;
		private $dbpassword;
		private $host;
		private $errorMessage;
		
		
		//create a database instance  constructor
		public function _construct($config)
		{
			$this->dbname       =$config['dbname'];
			$this->dbusername   = $config['dbusername'];
			$this->dbpassword   = $config['dbpassword'];
			$this->host         = $config['host'];
			
			echo $this->dbname ;	
		}
		
		/**------------------------------------------------------------
     		Function to connect to the database.
			This function returns the connection PDO connection if the
			connection was succesful connected else display failed to 
			connect error message.
			
			return : if the connection is successful then the pdo connection
			         is return else it return false
		 -----------------------------------------------------------------*/
		 public function connect()
		 {
			//default state fo the connection
			$this->errorMessage ='Connection OK'; //temp fix as placing this in the constructor wont work
			
			//attempt to connect
			try{
					global $host;
					global $dbname;
					global $dbusername;
					global $dbpassword;
					global $host;
					$databaseConnectString = 'mysql:host='.$host.';dbname='.$dbname;
					$conn = new PDO($databaseConnectString,$dbusername,$dbpassword);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					return $conn;//database successful connected
			   }
			   
			//database failed
			catch(PDOException $e)
			{
				$this->errorMessage = $e->getMessage();
				return false;
			}
		 }
		 
		 /*-------------------------------------------------
		    This function is used to check succesful connection
			has been made. return true if successful else false
			PARAMETER: $PDO $connection->takes the pdo connection
			
			return: it return true if the connection is okay else
			        return false if connection is bad
		  --------------------------------------------------*/
		 public function connectionStatus($connection)
		 {
			if($connection !=false)
			{
				return true;
			}
			else
			{
				return false;
			}
		 }
		 
		 /*-----------------------------------------------
			This function returns the connection error 
			message
			
			return the connection ERROR MESSAGE...
			this is idle to use if the connection has failed
		 -------------------------------------------------*/
		 public function getConnectionErrorMessage()
		 {
			return '<b>CONNECTION ERROR MESSAGE::</b> '.$this->errorMessage;
		 }
		 
		 
		 /*-------------------------------------------------------------
			This function returns the name of the database currently
			connected
			
			PARAMETER: $connection->PDO connection
			
			return: The database name is echo if the connection is connected
			        else an error message is echo with possible solutions
		*-------------------------------------------------------------------*/
		 public function getNameOfConnectedDatabase($connection)
		 {
		 
			//checks that the connection between server has been established prior
			if($this->errorMessage == "Connection OK")
			{
				//fetching the connected database
				$stmt = $connection->query('SELECT DATABASE() FROM DUAL');
				$result = $stmt->fetch();
				
				$dup ="";//temp fix to prevent showing duplication and space being print ...happens with number and symbol but string is fine
				
				//display the result
				foreach($result as $row)
				{
					if($dup!=$row)
					{
						$dup = $row;
						echo '<b>CONNECTED DATABASE:: </b>'. $row;
					}	
				}//end of for each
			}//end of if connection passed
			else
			{
				echo 'Error connecting to database!<br/> 1.Check your config.php to ensure that you entered the correct information.<br/>';
				echo 'Alternative use the method connectionStatus($connection) to see whether you are succesful connected.';
			}
			
		 }
		 
		 /*-----------------------------------------------
		    This function performs insert-like data in a database.
			returns true if the insert-like function was succesful
			else error mesage is output
			PERIMETERS: PDO connection->takes the connection
			           query->takes the prepared sql query
					   bindings, takes the binding statements(array)
					   table-> the table to insert the data in 
					   values-> the values being insert
					   
			return: true is return if the data was successful insert
           			else error message is echo and false is return
		*/
		 public function insert(PDO $connection,$columns,$bindings,$tables,$values)
		 {
			$query ='INSERT INTO '.$tables.'('.$columns.')VALUES('.$values.')';
			$stmt = $connection->prepare($query);
			try
			{
				$stmt->execute($bindings);
				return true;
				
			}
			catch(PDOException $e)
			{
				echo '<br/>ERROR: '.$e->getMessage().'<br/>';
				return false;
			}
		 }
		 
		 /*--------------------------------------------------------------------------------------------------------------
		  This function read/select data from database
		  returns the PDO stmt if the statement executed else
		  echo error message
		  
		  PARAMETER : $connection-> takes the PDO connection
		              $columns-> columns of data that you want to select, can be specific columns such as foo,foo or * 
					  $binding-> takes the bind statement array
					  $tables-> table to select the data from
					  $where-> takes specific where insturction such as 'where id =:id' or can be blank if no specific where clause ie. $where=""
					  
		 return: PDO stmt if the select is successful else a false is return.. if there are errors with the syntax it will be echo
		  -----------------------------------------------------------------------------------------------------------------*/
		 public function select( PDO $connection,$columns,$bindings,$tables,$where)
		 {
			$query = 'SELECT '.$columns.' FROM '.$tables.' '.$where.'';
			//$query='SELECT * FROM admin';
			$stmt = $connection->prepare($query);
			
			try
			{
				//execute depends on where clause statement if null or not
				if($where=='')
				{
					$stmt->execute();
				}
				else
				{
					$stmt->execute($bindings);
				}
				 return $stmt;	
			}
			catch(PDOException $e)
			{
				echo '<br/>ERROR: '.$e->getMessage().'<br/>';
				return false;
			} 
		 }//end of select
		 
		 /*-----------------------------------------
		    This function deletes... returns the stmt if 
			it was succesful delete else echo error message
			if there is error in the syntax or such like
			
			PARAMETER: $binding-> takes the bind statement array
					  $tables-> table to delete the data from
					  $where-> takes specific where insturction such as '$where = id:=id'
					  $connection->takes the pdo connection
			return: true if data is delete else false. if there are error it will be echo 
			
		*/
		 public function delete( PDO $connection,$bindings,$tables,$where)
		 {
			$query = 'DELETE FROM '.$tables.' Where '.$where. ' ';
			//$query ='DELETE FROM TABLE WHERE id = : some ';
			
			$stmt = $connection->prepare($query);
			try
			{
				$stmt->execute($bindings);
				return true;
			}
			
			//failed 
			catch(PDOException $e)
			{
				echo '<br/>ERROR: '.$e->getMessage().'<br/>';
				return false;
			}
		 }//end of delete
		 
		 /*----------------------------------------------------------------------------------------------------------------
		    This function update... returns the stmt if 
			it was succesful delete else echo error message
			if there is error in the syntax or such like
			
			PARAMETER: $binding-> takes the bind statement array
					  $tables-> table to update
					  $where-> takes specific where insturction such as '$where = id:=id'
					  $connection->takes the pdo connection
					  $set-> take the columns to be set such as $set ='idnum = :updateNum';
			
			return: true if the update was succesful else false... if there is error it will be echo automatically
		*-----------------------------------------------------------------------------------------------------------------*/
		 public function update(PDO $connection, $bindings, $table, $set,$where)
		 {
			$query = 'UPDATE '.$table.' SET '.$set.' WHERE '.$where. ' ';
			
			$stmt = $connection->prepare($query);
			
			try
			{
				$stmt->execute($bindings);
				return true;
			}
			
			//failed
			catch(PDOException $e)
			{
				echo '<br/>ERROR: '.$e->getMessage().'<br/>';
				return false;
			}
		 }
		 
		 /*---------------------------------------------------------------------------------------------------------------------------
		    This is a function to generate random strings
			This can be number only or string only or special character or mix of all or two of the three. you decide.
			PARAMETER: $length-> the total length of random strings to generate
			           $includeNum-> takes "yes" or "no" whether you want to include a number in the generated string
					   $includeSpecialChar->take "yes" or "no" whether you want to include special characters in the generate string
					   $includeString->take "yes" or "no" if you want to include string in the generated string. 
					   
			return: random generated string;
		*-------------------------------------------------------------------------------------------------------------------------------*/
		public function createRandomGenerate($length,$includeSpecialChar,$includeNum,$includeString)
		{
			$randomGenerated='';
			$char='';
			
			//different things that can be generated
			$string  ='ABCDEFGHIJKLMNOPQRSTUVWXYZabdefghijklmnopqrstuvwxyz';
			$num = '0123456789';
			$specialCharacter = '@#$&!,.?~-_*';
			
			
			//ensure that $length is numeric
			if(!is_numeric($length))
			{
				echo '<br/> ERROR: The parameter $length must be a int.<br/> ';
			}
			
			//ensure the user do not leave specialCharacter or num blank
			if($includeNum=="" || $includeSpecialChar=="" || $includeString=="")
			{
				echo '<br/>ERROR: The parameter $includeSpecialChar or $includeNum or $includeString cannot be blank.<br/> ';
			}
			
			else
			{
				//the user wish to add strings
				if( strcasecmp ( $includeString , 'yes' )==0 )
				{
					$char.=$string;

				}
				
				//the user wish to add numbers
				if( strcasecmp ( $includeNum , 'yes' )==0 )
				{	
					$char.=$num;
				}
				
				//the user wish to add special characters
				if( strcasecmp ( $includeSpecialChar , 'yes' )==0 )
				{	
					$char.=$specialCharacter;
				}
				
				//begin the randomize code
				srand((double)microtime()*1000000);
				$i=1;
				while($i<=$length)
				{
					$randNum = rand() % strlen($char);//random between the length of the $char
					$temp = substr($char,$randNum,1);
					//temp fix...prevent temp from adding blank
					if($temp!="")
					{
						$randomGenerated.=$temp;
						$i++;
						
					}

				}	
				return $randomGenerated;
			}

		}//end of random generated function
		
		
		/*----------------------------------------------------------------------------------------
			Function to genereate a secured hash password that has been hashed using crypt.
			procedure: a salt key is generated using a md5 and the user name in a n time loop.
					   after the salt key is generated it is use in aid in hashing the password
					   using crypt($password,$salt)
					   
			Parameter: NUM-> NUMBER OF TIME TO loop a md5
			           salt->A UNIQUE SALT KEY
					   $username->takes the username
					   $password->takes the password
					   
			returns a crypt password that has been hashed in md5 then finally crypt
		*--------------------------------------------------------------------------------------------*/
		public function generateSecurePasswordHash($num,$salt,$username,$password)
		{
			//ensure that $num is a int
			if(!is_numeric($num))
			{
				echo '<br/>Error: The parameter $num in generateSecurePasswordHash function must be an int';
			}
			//password is numeric
			else
			{
				//default values
				$i = 0;
				$md5Hash='';
				$securedHash="";
				//creating a md5 hash n times
				while($i < $num)
				{
					$md5Hash.=md5(strtolower($username));
					//echo '<br/> Generating MD5 :'.$md5Hash.'<br/>';
					$i++;
				}//end of while
				
				//adding the generated md5 to make a salt key
				$salt = $salt.$md5Hash;
				
				//echo '<br/> Generating salt :'.$salt.'<br/>';
				
				//genereating a bcrypt hashed password
				$securedHash = crypt($password,$salt);
				$securedHash = substr($securedHash,30);
				return $securedHash;
				
			}
			
		}//end of generating hash function
		
		/**------------------------------------------------------------------------------------------------------------------------------
			This function validate whether a login credential is
			correct....
			PARAMETERS: username->take the user name 
			            password->takes the password
						table->take the table that contain the user credentials
						columns->takes the columns that contains the username and password	
						binding->binding statment array
						where->takes the where statement
						
			return a pdo stmt if the connection is validate else return false. if there are any error it will automatically echo
		*---------------------------------------------------------------------------------------------------------------------------------**/
		public function isCredentialValid($username,$password,$tables,$columns,$bindings,$where)
		{
			//ensure that the connection has been set prior
			$connection = $this->connect();
			
			//ensure that the variables exist.
			if( (isset($username)) || (isset($password)) || (isset($table)) || (isset($columns)) || (isset($bindings)) || (isset($where)) )
			{
				//ensure that the connection has been proper configured
				if($this->connectionStatus($connection) ==true)
				{
					//echo '<br/> connection Successful ! ';
					
					//ensure that the requirement parameters are not blanked
					if($username!="" && $password!="" && $tables!="" && $columns!="" && $bindings!="" && $where!="")
					{
						//echo '<br/>  Passed ';
						$result = $this->select($connection,$columns,$bindings,$tables,$where);
						
						//check if result has no errors and has record
						if($result!=false)
						{
							//has record hence return the results in form of pdo $stmt
							if($result->rowCount() > 0)
							{
								//echo '<br/> data found!';
								//it is a possible the the user will need every columns from this table so let us return all
								$column ='*';
								$result = $this->select($connection,$columns,$bindings,$tables,$where);
								return $result;
							}
							//else return false as no crediential match
							else
							{
								return false;
							}//end for return false if crediential doenst match
						}
					}//end of if all requirement are not blanked
					
					//output this message is there are any blank parameters
					else
					{
						echo '<br/>Error: All parameters in the function isCredentialValid are required.<br/>';
						echo '<br/>Error: The correct format is  "isCredentialValid($username,$password,$tables,$columns,$bindings,$where)" ';
					}
					
				}
				
				//the connection is not proper configured
				else
				{
					echo '<br/> ERROR: Your server is not connected to the database! Check to ensure that you have set your config.php with the correct information.<br/>';
				}
		
			}
			
			//echo this if the user didnt included any parameter at all ie  isCredentialValid()
			else
			{
				echo '<br/>Error: The correct format is  "isCredentialValid($username,$password,$tables,$columns,$bindings,$where)" ';
			}
			
		}//end of isCredentialValid function
		
		/*------------------------------------------------------------------------------------
		
			This is a function to get the name of all Parameter for a function within 
		  this class.. this can be helpful if one is not sure what parameter are
		  necessary for a method
			
		  return a string of all parameter of a functin
		
		*-------------------------------------------------------------------------------------------*/
		public function get_func_argNames($funcName) 
		{
			$parameters="";
			//get the file
			$file = file_get_contents('libraryClass.php');
			//echo "file is ".$file;
		
			//search for the specific function
			$pos = strpos($file,$funcName);
			if($pos!=false)
			{
				$i=0;
				//find the first occurance of the open brace after the function
				$open = strpos($file,'(',$pos);
			
				//loop until we get to the end of the brace
				$i=$open+1;//move over from the open brace and start getting parameter names
				while($file[$i]!=')')
				{
					$parameters.=$file[$i];
					$i++;
				}
				return $parameters;
			}
			else
			{
				echo '<br/>ERROR: '.$funcName.' is not a function <br/>';
			}
		}
		
		/*--------------------------------------------------------------
			This function returns name of all available methods 
		------------------------------------------------------------------*/
		public function getMethods()
		{
			echo '<b><br/>AVAILABLE METHODS :</b><br/>';
			        echo '=====================<br/>';
			$methods = get_class_methods($this);
			foreach($methods as $individual)
			{
				if($individual!='_construct')
				{
					//$individual = trim($individual);
				
					$getparm = 'public function '.$individual;
					echo '<br/>'.$individual.'('.$this->get_func_argNames($getparm).')<br/>';
					//print_r($this->get_func_argNames($individual));

				}
				
			}
		}
		
		/*--------------------------------------------------------------------------------------------------
		   This method is use to echo the data for a variable
		   thus eliminate the need for multi echo when testing to see
		   what each variables has... all one have to do is supply the parameter with
		   some arguments. when invoking you may supply any number of parameters.
		   
		   This eliminate the need to write a echo statement for each variables to see what data they contain
		   This function will echo both the variable name in the form of $somevariable and the data it possess
		   for example if you have a $foo='hello world'; it will echo:
		   
		    "Data for $foo is : hello world"
		   
		*----------------------------------------------------------------------------------------------------*/
		public function getDataOfVariables()
		{
			//function to get the argument names within this method
			function get_func_argNames($funcName) 
			{
				$parameters="";
				//get the file
				$file = file_get_contents(basename($_SERVER['PHP_SELF']));
				//echo "file is ".$file;
			
				//search for the specific function
				$pos = strpos($file,$funcName);
				if($pos!=false)
				{
					$i=0;
					//find the first occurance of the open brace after the function
					$open = strpos($file,'(',$pos);
				
					//loop until we get to the end of the brace
					$i=$open+1;//move over from the open brace and start getting parameter names
					while($file[$i]!=')')
					{
						$parameters.=$file[$i];
						$i++;
					}
					return $parameters;
				}
				else
				{
					echo '<br/>ERROR: '.$funcName.' is not a function <br/>';
				}
			}//end og get_function_argument name
			
			//execute
			$generatedParam = split("," , get_func_argNames('getDataOfVariables'));//get each parameters and split them based on the ','
			$args = func_get_args();	//get the real value of every arguments
			
			//echo 'Number of arguments :'. $numargs;
			//loop and display the data
			echo'<br/>Displaying values for getDataOfVariables('.get_func_argNames('getDataOfVariables').')';
			echo'<br/>====================================================================================';
			for($i=0; $i < count($generatedParam); $i++)
			{
				echo "<br/> Data for $generatedParam[$i] is : $args[$i]";
			}		
		}//end of get data variable
		 
		 
	 }

?>