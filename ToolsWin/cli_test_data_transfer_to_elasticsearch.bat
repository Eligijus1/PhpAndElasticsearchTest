@echo off

REM Always start maximized CMD window:
if not "%1" == "max" start /MAX cmd /c %0 max & exit/b

call variables.bat

php %projectRoot%\index.php CliCommands\TestDataTransferToElasticsearch

pause
