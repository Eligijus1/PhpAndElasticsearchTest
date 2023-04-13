<?php
/*
* @copyright C UAB NFQ Technologies
*
* This Software is the property of NFQ Technologies
* and is protected by copyright law – it is NOT Freeware.
*
* Any unauthorized use of this software without a valid license key
* is a violation of the license agreement and will be prosecuted by
* civil and criminal law.
*
* Contact UAB NFQ Technologies:
* E-mail: info@nfq.lt
* http://www.nfq.lt
*
*/

namespace CliCommands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Log\Writer;

class AecErpOrdersIndexCreate implements CliCommandInterface
{
    private const INDEX_NAME = 'aec_erp_orders';
    private Writer $logWriter;
    private array $env;
    private Client $elasticClient;

    /**
     * @param Writer $logWriter
     * @param array  $env
     *
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
     *
     * @return void
     */
    public function execute(array $arguments): void
    {
        $this->logWriter->debugMessage("'execute' method started.");

        $this->addIndexMyIndex('a1', true, 'orderDealerId-1');
        $this->addIndexMyIndex('a2', false, 'orderDealerId-2');

        $this->logWriter->debugMessage("'execute' method finished.");
    }

    /**
     * @param string $id
     * @param bool   $forceUniqueGeneratedId
     * @param string $orderDealerId
     *
     * @return void
     */
    private function addIndexMyIndex(
        string $id,
        bool $forceUniqueGeneratedId,
        string $orderDealerId
    ): void {
        $params = [
            'index' => AecErpOrdersIndexCreate::INDEX_NAME,
            'id' => $id,
            'body' => [
                'forceUniqueGeneratedId' => $forceUniqueGeneratedId,
                'orderDealerId' => $orderDealerId,
            ]
        ];

        try {
            $response = $this->elasticClient->index($params);
            $this->logWriter->infoMessage("{$response->getStatusCode()} ID# $id to index '" . AecErpOrdersIndexCreate::INDEX_NAME . "' added.");
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
}