# phpLibrary
a library to execute the common task instead of writing the code from scratch every time we need them such as database connection, connection status, insert,
delete, update, isCredentialValid, etc, get connectionError Message,generate secure hash and many more

This script has three classes:
#
Config.php -> use to config the database:
# 
library.php-> has  the instance of the libraryClass.php and the config. This class doesnt requires any changes.
#
libraryClass.php-> has the definition of all common functions
#
I  have included a database that was used to test and yield the results for test.php
#
In order to set up a testing, change the username and password and host in the config.php and upload the database included here to your
server. 
#
Feel free to provide feedback or report any bug.
