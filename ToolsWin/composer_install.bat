@echo off

call variables.bat

cd %projectRoot%
cd ../

php %composerLocation% --version

php %composerLocation% install

pause