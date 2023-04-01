@echo off

call variables.bat

cd %projectRoot%
cd ../

REM php %composerLocation% require elasticsearch/elasticsearch
REM php %composerLocation% require php-http/async-client-implementation
REM php %composerLocation% require php-http/guzzle7-adapter

pause