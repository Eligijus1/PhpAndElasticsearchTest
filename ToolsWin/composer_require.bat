@echo off

call variables.bat

cd %projectRoot%
cd ../

php %composerLocation% require elasticsearch/elasticsearch

pause