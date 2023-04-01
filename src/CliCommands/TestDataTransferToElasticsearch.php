<?php

namespace CliCommands;

use Log\Writer;

class TestDataTransferToElasticsearch implements CliCommandInterface
{
    private Writer $logWriter;

    /**
     * @param Writer $logWriter
     */
    public function __construct(Writer $logWriter)
    {
        $this->logWriter = $logWriter;
    }

    /**
     * @param array $arguments
     * @return void
     */
    public function execute(array $arguments): void
    {
        $this->logWriter->debugMessage("execute method started.");

        print_r($arguments);

        $this->logWriter->debugMessage("execute method finished.");
    }
}