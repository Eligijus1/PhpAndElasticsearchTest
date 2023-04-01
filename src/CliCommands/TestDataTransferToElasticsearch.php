<?php

namespace CliCommands;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
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
     * @throws AuthenticationException
     */
    public function execute(array $arguments): void
    {
        $this->logWriter->debugMessage("execute method started.");

        $client = ClientBuilder::create()->build();

        $this->logWriter->debugMessage("execute method finished.");
    }
}