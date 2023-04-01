<?php

require_once '../vendor/autoload.php';
require_once 'Log/Writer.php';
require_once 'CliCommands/CliCommandInterface.php';
require_once 'CliCommands/TestDataTransferToElasticsearch.php';

use CliCommands\CliCommandInterface;
use CliCommands\TestDataTransferToElasticsearch;
use Log\Writer;

// Services:
$logWriter = new Writer();

// CLI Commands:
$rpcCommands[TestDataTransferToElasticsearch::class] = new TestDataTransferToElasticsearch($logWriter);

// Detect if script executed from command line:
if (strtolower(php_sapi_name()) === 'cli') {
    if (empty($argv[1])) {
        $logWriter->errorMessage("Argument 1 (CLI command class) not specified.");
        exit(1);
    }

    if (empty($rpcCommands[$argv[1]])) {
        $logWriter->errorMessage("CLI command '" . $argv[1] . "' not found.");
        exit(1);
    }

    if (!($rpcCommands[$argv[1]] instanceof CliCommandInterface)) {
        $logWriter->errorMessage("'" . $argv[1] . "' not instance of CliCommandInterface.");
        exit(1);
    }

    $logWriter->debugMessage("Argument 1 found: " . $argv[1]);

    // Handle CLI request:
    $rpcCommands[$argv[1]]->execute($argv);
} else {
    // Handling WEB request:
    echo "php_sapi_name(): " . php_sapi_name() . PHP_EOL;
}

