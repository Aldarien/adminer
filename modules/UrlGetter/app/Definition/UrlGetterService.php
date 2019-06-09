<?php
namespace Aldarien\App\Definition;

use GuzzleHttp\ClientInterface;

interface UrlGetterService {
  public function __construct(ClientInterface $client);
  public function get(string $url): string;
}
