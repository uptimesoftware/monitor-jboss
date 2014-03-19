@ECHO OFF
set PHPDIR=..\..\apache\php\
"%PHPDIR%\php.exe" ..\..\plugins\scripts\monitor-jboss\monitor-jboss.php %1%
