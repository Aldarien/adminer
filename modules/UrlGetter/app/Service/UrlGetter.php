<?php
namespace Aldarien\App\Service;

use GuzzleHttp\ClientInterface;
use Aldarien\App\Definition\UrlGetterService as UrlGetterInterface;

class UrlGetter implements UrlGetterInterface {
  protected $client;
  public function __construct(ClientInterface $client) {
    $this->client = $client;
  }
  public function get(string $url): string {
    $res = $this->client->request('GET', $url);
    if ($res->getStatusCode() == 200) {
      $data = $res->getBody();
      return $data;
    }
    return '';
  }
}
