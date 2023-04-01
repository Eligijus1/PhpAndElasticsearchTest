<?php

namespace CliCommands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
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
            //->setSSLVerification(false)
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

        $this->addIndexMyIndex();

        $this->searchIndexInMyIndex();

        $this->deleteDocumentInMyIndex();

        $this->deleteMyIndex();

        $this->logWriter->debugMessage("'execute' method finished.");
    }

    /**
     * @return void
     */
    private function printInfo(): void
    {
        try {
            $response = $this->elasticClient->info();
            $this->logWriter->infoMessage("Status code: {$response->getStatusCode()}");
            $this->logWriter->infoMessage("Version number: " . $response['version']['number']);
        } catch (ClientResponseException $e) {
            $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
            exit(1);
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
            exit(1);
        }
    }

    /**
     * @return void
     */
    private function addIndexMyIndex(): void
    {
        $params = [
            'index' => 'my_index',
            'id' => 'my_id',
            'body' => ['testField' => 'abc']
        ];

        try {
            $response = $this->elasticClient->index($params);
            $this->logWriter->infoMessage("Index 'my_index' added.");
        } catch (ClientResponseException $e) {
            $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
            exit(1);
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
            exit(1);
        } catch (Exception $e) {
            $this->logWriter->errorMessage("Exception: {$e->getMessage()}");
            exit(1);
        }
    }

    /**
     * @return void
     */
    private function searchIndexInMyIndex(): void
    {
        $params = [
            'index' => 'my_index',
            'body' => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];

        try {
            $response = $this->elasticClient->search($params);
            $this->logWriter->infoMessage("Total docs: " . $response['hits']['total']['value']);
            $this->logWriter->infoMessage("Max score: " . $response['hits']['max_score']);
            $this->logWriter->infoMessage("Took: " . $response['hits']['max_score'] . " ms");
            //$this->logWriter->infoMessage("Hits: " . print_r($response['hits']['hits'], true));
        } catch (ClientResponseException $e) {
            $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
            exit(1);
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
            exit(1);
        } catch (Exception $e) {
            $this->logWriter->errorMessage("Exception: {$e->getMessage()}");
            exit(1);
        }
    }

    /**
     * @return void
     */
    private function deleteDocumentInMyIndex(): void
    {
        try {
            $response = $this->elasticClient->delete([
                'index' => 'my_index',
                'id' => 'my_id'
            ]);
            $this->logWriter->infoMessage("Document id 'my_id' removed from index 'my_index'.");
            //print_r($response);
//            if ($response['acknowledge'] === 1) {
//                $this->logWriter->infoMessage("The document with id 'my_id' has been deleted.");
//            }
        } catch (ClientResponseException $e) {
            if ($e->getCode() === 404) {
                $this->logWriter->errorMessage("The document with id 'my_id' does not exist.");
            } else {
                $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
                exit(1);
            }
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
            exit(1);
        } catch (Exception $e) {
            $this->logWriter->errorMessage("Exception: {$e->getMessage()}");
            exit(1);
        }
    }


    /**
     * @return void
     */
    private function deleteMyIndex(): void
    {
        try {
            $deleteParams = [
                'index' => 'my_index'
            ];
            $response = $this->elasticClient->indices()->delete($deleteParams);

            if ((int)$response['acknowledged'] === 1) {
                $this->logWriter->infoMessage("Index 'my_index' deleted.");
            }
        } catch (ClientResponseException $e) {
            if ($e->getCode() === 404) {
                $this->logWriter->errorMessage("The document with id 'my_id' does not exist.");
            } else {
                $this->logWriter->errorMessage("ClientResponseException: {$e->getMessage()}");
                exit(1);
            }
        } catch (ServerResponseException $e) {
            $this->logWriter->errorMessage("ServerResponseException: {$e->getMessage()}");
            exit(1);
        } catch (Exception $e) {
            $this->logWriter->errorMessage("Exception: {$e->getMessage()}");
            exit(1);
        }
    }
}
