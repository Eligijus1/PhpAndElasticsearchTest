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
     * @throws AuthenticationException
     */
    public function execute(array $arguments): void
    {
        $this->logWriter->debugMessage("execute method started.");

        try {
            $response = $this->elasticClient->info();
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
2023-04-01 12:20:24 ERROR ClientResponseException:
401 Unauthorized: {"error":{"root_cause":[{"type":"security_exception","reason":"unable to authenticate with provided credentials and anonymous access
is not allowed for this request","additional_unsuccessful_credentials":"API key: unable to find apikey with id ZW6nPIcBf-4jny-WMBds",
"header":{"WWW-Authenticate":["Basic realm=\"security\" charset=\"UTF-8\"","Bearer realm=\"security\"","ApiKey"]}}],
"type":"security_exception","reason":"unable to authenticate with provided credentials and anonymous access is not
 allowed for this request","additional_unsuccessful_credentials":"API key:
unable to find apikey with id ZW6nPIcBf-4jny-WMBds","header":{"WWW-Authenticate":["Basic realm=\"security\" charset=\"UTF-8\"","Bearer realm=\"security\"","ApiKey"]}},"status":401}
*/