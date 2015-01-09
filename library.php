<?php
	/*-------------------------------------------------------------------
	  Create an instance of the library class
	  which will be use and can be access 
	  anywhere in oop style by saying
	  
	  $library->somefunction
	  
	  AUTHOR:KEMOY CAMPBELL
	  
	  THIS CLASS DOESNT NEED ANY CONFIGRATION....
	----------------------------------------------------------------------*/
	include('config.php');
	include('libraryClass.php');
	
	//Instance the libraryClas
	$library = new Library($config);
	$connection = $library->connect();
	
?>