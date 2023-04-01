@echo off

call variables.bat

cd %projectRoot%
cd ../

php %composerLocation% update

pause