# comTaskLib

#####Caution: This is an older version that is abandoned. See the new version at https://github.com/kemoycampbell/amazo/
_comTaskLib_ is a lightweight PHP library that is designed to eliminate the pain of writing code from scratch
to peform basic tasks. These tasks, among others, include:
* insertion.
* deletion.
* updating.
* validity checking of user credentials.
* basic string validation operations.

This library is designed using the Object Oriented Programming ("OOP") principle. It is flexible includes methods that are readily available to you.

##Application

_comTaskLib_ aims to speed up programming and enable developers to get more things done in a shorter amount of time.

####Divisions, Installation, and Setting Up

This script has three files:

1. [`config.php`](https://github.com/kemoycampbell/comTaskLib/blob/master/config.php) - use to configure the database:
2. [`library.php`](https://github.com/kemoycampbell/comTaskLib/blob/master/library.php) - contains the instance of the `libraryClass.php` and the config. This class does not require any changes.
3. [`libraryClass.php`](https://github.com/kemoycampbell/comTaskLib/blob/master/libraryClass.php) - contains the definition of all common functions

> I  have included a database that was used to test and yield the results for `test.php`. In order to set up testing, change the username and password and host in `config.php` and upload the database included here to your server. More functionality will be added in future releases.

#Usage
You may use the following function to test the connection:
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
Remember that it is important to call out to the library as follows:

    $library->someMethod()

#Contributing
Feel free to provide feedback or report any bugs.
