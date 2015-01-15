# comTaskLib
comTaskLib is a lightweight php library that is designed to eliminate the pain of writing codes from scratch
to peform basic tasks such as insert, delete, update, check whether a user credential is validate, basic String Validation Operation , etc. 
This library is designed using Object Oriented Programming(OOP) principle, flexible and has included methods that are readily available to You.  
##Application
ComTaskLib aims on speeding up programming and enable to get developers get more things done in a shorter time.
####Divisions
This script has three files:
1. Config.php -> use to config the database:
2. library.php-> has  the instance of the libraryClass.php and the config. This class doesnt requires any changes.
3. libraryClass.php-> has the definition of all common functions
> I  have included a database that was used to test and yield the results for test.php
> In order to set up a testing, change the username and password and host in the config.php and upload the database > included here to your
> server. 
>More functions are to be added. This is just the beginning

#Usage
1. Just Do It Like This 
```php
<?php

include('library.php');//required

/*-------------------------------------------------------
  this is an example of how to use the connection method
  The parameter $connection is a PDO connection 
  -----------------------------------------------------*/
  
if($library->connectionStatus($connection))
{
echo 'Connection Status :passed!';
}
else
{
echo 'Connection Status :failed';
}
```
for any usage it is important to call the library like $library->someMethod()

#Contributing
Feel free to provide feedback or report any bug.
