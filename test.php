<?php
	/*-----------------------------------------------
	   A TEST TO SHOW THE WORKING OF ALL FUNCTION
	   AUTHOR: KEMOY CAMPBELL
	 -----------------------------------------------*/
	include('library.php');
		
	/*----------------------------------------
	testing the connection status
	*-----------------------------------------*/
	echo'<br/><p style="color:blue">TEST CONNECTION STATUS FUNCTION</p>';
	if($library->connectionStatus($connection))
	{
		echo 'Connection Status :passed!';
	}
	else
	{
		echo 'Connection Status :failed';
		
	}
	
	//--------------------------------------------
	/*test errorMessage
	-----------------------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST GET CONNECTION ERROR MESSAGE FUNCTION</p>';
	echo'<br/>'. $library->getConnectionErrorMessage();
	
	/*-----------------------------------------------
	  test getNameOfDatabaseConnectedTo
	*-------------------------------------------------*/
	echo'<br/>';
	echo'<br/><p style="color:blue">TEST GET CONNECTIONED DATABASE FUNCTION</p>';
	$library->getNameOfConnectedDatabase($connection);
	
	/*----------------------------------
	  testing the insert
	------------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST INSERT FUNCTION</p>';
	$columns ='idnum,password,fname';
	$values =':idnum,:password,:fname';
	$idnum='1234';
	$password='mypassword';
	$num='2';
	$salt='$2a$13$';
	$password =$library->generateSecurePasswordHash($num,$salt,$idnum,$password);//hashing the password before insert
	$fname='Kemoy';
	$tables='admin';
	$bindings = array(':idnum'=>$idnum,':password'=>$password,':fname'=>$fname);
	$res = $library->insert($connection,$columns,$bindings,$tables,$values);
	if($res==true)
	{
		echo 'Insert successful';
	}
	else
	{
		echo 'Insert Failed';
	}
	
	/*------------------------
	    testing select
	*--------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST SELECT FUNCTION</p>';
	echo '<br/>';
	$columns ='idnum,password,fname';
	$bindings="";
	$where="";
	$tables='admin';
	$result = $library->select($connection,$columns,$bindings,$tables,$where);
	if($result->rowCount()>0)
	{
		$data = $result->fetchAll();
		foreach($data as $row)
		{
			echo $row['idnum'].'<br/>';
		}
	}
	
	/*------------------------------
	  testing delete
	*------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST DELETE FUNCTION</p>';
	$num='1234';
	$where ='idnum = :num';
	$tables = 'admin';
	$bindings = array(':num'=>$num);
	$res = $library->delete($connection,$bindings,$tables,$where);
	if($res==true)
	{
		echo 'Delete successful';
	}
	else
	{
		echo 'Delete failed';
	}
	
	
	/*------------------------------
	   testing update
	---------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST UPDATE FUNCTION</p>';
	$num='1234';
	$updateNum='0';
	$where ='idnum = :num';
	$set ='idnum = :updateNum';
	$table ='admin';
	$bindings = array(':num'=>$num,':updateNum'=>$updateNum);
	$res = $library->update($connection, $bindings, $table, $set,$where);
	if($res==true)
	{
		echo 'Update successful';
	}
	else
	{
		echo 'Update failed';
	}
	
	
	/*--------------------------------------
	   testing generate random string
	*---------------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST RANDOM GENERATE STRING FUNCTION</p>';
	$length = 30;
    $includeSpecialChar="yes";
	$includeNum="yes";
	$includeString="yes";
	echo $library->createRandomGenerate($length,$includeSpecialChar,$includeNum,$includeString);
	
	/*------------------------------
	   test generateSecureHash
	-----------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST Generate Secure PasswordHash FUNCTION</p>';
	$num='1';
	$salt='$2a$13$';
	$username='kemoycampbell@hotmail.com';
	$password='foo';
	echo '<br/>'.$library->generateSecurePasswordHash($num,$salt,$username,$password);
	
	/*-------------------------------
	    testing isCredentialValid
	---------------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST CREDENTIAL FUNCTION</p>';
	$username="0";
	$password ="mypassword";
	$columns ='idnum,password';
	$bindings=array(':idnum'=>$username, ':password'=>$password);
	$where="WHERE idnum = :idnum AND password = :password";
	$tables='admin';
	$isValid = $library->isCredentialValid($username,$password,$tables,$columns,$bindings,$where);
	if($isValid!=false)
	{
		echo 'passed';
		$result = $isValid->fetchAll();
		
	}
	else{
		echo 'Isnt valid';
	}

	/*---------------------------
	  testing the get method name
	*-----------------------------*/
	echo'<br/>';
	echo'<p style="color:blue">TEST GET METHODS FUNCTION</p>';
	$library->getMethods();
	
	echo'<br/>';
	echo'<p style="color:blue">TEST GET DATA OF VARIABLES FUNCTION</p>';
	$foo='hello world'; $name='Kemoy Campbell'; $sourceType='Open Source';
	$library->getDataOfVariables($foo,$name,$sourceType);
	
	
	

?>