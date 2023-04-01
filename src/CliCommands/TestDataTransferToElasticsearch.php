<?php

namespace CliCommands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Log\Writer;

class TestDataTransferToElasticsearch implements CliCommandInterface
{
    private Writer $logWriter;
    private array $env;
    private Client $elasticClient;

    /**
     * @param Writer $logWriter
     * @param array $env
     * @throws AuthenticationException
     */
    public function __construct(Writer $logWriter, array $env)
    {
        $this->logWriter = $logWriter;
        $this->env = $env;

        $this->elasticClient = ClientBuilder::create()
            ->setElasticCloudId($this->env['ELASTIC_CLOUD_WEB_UI_CLOUD_ID'])
            ->setApiKey($this->env['ELASTIC_CLOUD_WEB_UI_API_KEY'])
            ->build();
    }

    /**
     * @param array $arguments
     * @return void
     */
    public function execute(array $arguments): void
    {
        $this->logWriter->debugMessage("'execute' method started.");

        $this->printInfo();

        $this->logWriter->debugMessage("'execute' method finished.");
    }

    /**
     * @return void
     */
    private function printInfo(): void
    {
        try {
            $response = $this->elasticClient->info();
            $this->logWriter->debugMessage("Status code: {$response->getStatusCode()}");
        } catch (ClientResponseException $e) {
            $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
            exit(1);
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
            exit(1);
        }
    }
}
