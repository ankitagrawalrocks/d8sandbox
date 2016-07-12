<?php

/**
 * @file
 * Contains \Drupal\stocks_update\StocksUpdaterService.
 */

namespace Drupal\stocks_update;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use GuzzleHttp\Client;

class StocksUpdaterService implements StocksUpdaterServiceInterface {

  /**
   * The entity query factory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $queryFactory;

  /**
   * JSON service which decodes JSON data
   *
   * @var \Drupal\Component\Serialization\Json
   */
  protected $jsonService;

  /**
   * Entity type manager service
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * GuzzleHttp client service
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * API url the service is reading data from
   *
   * @var string
   */
  protected $apiUrl = 'http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=%symbol%';

  public function __construct(QueryFactory $queryFactory, Json $jsonService, EntityTypeManagerInterface $entityTypeManager, Client $httpClient) {
    $this->queryFactory = $queryFactory;
    $this->jsonService = $jsonService;
    $this->entityTypeManager = $entityTypeManager;
    $this->httpClient = $httpClient;
  }

  public function process() {
    /** @var \Drupal\Core\Entity\Query\Sql\Query $query */
    $query = $this->queryFactory->get('block_content')
      ->condition('type', 'stock_exchange_rate_card');

    $nids = $query->execute();

    $entities = $this->entityTypeManager->getStorage('block_content')->loadMultiple($nids);

    /**
     * @var int $nid
     * @var \Drupal\Core\Entity\ContentEntityBase $entity
     */
    foreach ($entities as $nid => $entity) {
      $symbol = $entity->get('field_symbol')->value;
      $entity_url = str_replace('%symbol%', $symbol, $this->apiUrl);

      /* Examples to get first item of multivalue field or all values: */
      //    $multival = $entity->field_some_multi_value->value;
      //    $symbolGetValue = $entity->field_symbol->getValue();
      //    $multivalGetValue = $entity->field_some_multi_value->getValue();

      $request = $this->httpClient->get($entity_url);

      /* Example of getting status code 200 */
      //    $status_code = $request->getStatusCode();

      $body = $request->getBody();
      $data_decoded = $this->jsonService->decode($body->getContents());

      $entity->get('field_last_price')->value = $data_decoded['LastPrice'];
      $entity->get('field_change')->value = $data_decoded['Change'];

      $entity->save();
    }
  }
}