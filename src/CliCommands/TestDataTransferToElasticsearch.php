<?php

namespace CliCommands;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Log\Writer;

class TestDataTransferToElasticsearch implements CliCommandInterface
{
    private Writer $logWriter;

    private array $env;

    /**
     * @param Writer $logWriter
     * @param array $env
     */
    public function __construct(Writer $logWriter, array $env)
    {
        $this->logWriter = $logWriter;
        $this->env = $env;
    }

    /**
     * @param array $arguments
     * @return void
     * @throws AuthenticationException
     */
    public function execute(array $arguments): void
    {
        $this->logWriter->debugMessage("execute method started.");

//        $this->logWriter->debugMessage($this->env['ELASTIC_CLOUD_WEB_UI_CLOUD_ID']);
//        $this->logWriter->debugMessage($this->env['ELASTIC_CLOUD_WEB_UI_API_KEY']);

        $elasticClient = ClientBuilder::create()->setElasticCloudId($this->env['ELASTIC_CLOUD_WEB_UI_CLOUD_ID'])
            ->setApiKey($this->env['ELASTIC_CLOUD_WEB_UI_API_KEY'])
            ->build();

        try {
            $response = $elasticClient->info();
            $this->logWriter->debugMessage("Status code: {$response->getStatusCode()}");
        } catch (ClientResponseException $e) {
            $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
        }

        $this->logWriter->debugMessage("execute method finished.");
    }
}
/*
PHP Fatal error:  Uncaught GuzzleHttp\Exception\RequestException: cURL error 60: SSL certificate problem: self-signed certificate in certificate chain
 */