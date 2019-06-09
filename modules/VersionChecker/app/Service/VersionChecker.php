<?php
namespace Adminer\App\Service;

use GuzzleHttp\ClientInterface;
use Aldarien\App\Definition\PathFactory as PathFactoryInterface;
use Aldarien\App\Definition\ConfigService as ConfigServiceInterface;

class VersionChecker {
  protected $container;
  public function __construct(PathFactoryInterface $path_factory, ConfigServiceInterface $config_service, ClientInterface $client) {
    $this->container = (object) [
      'locations' => $path_factory,
      'config' => $config_service,
      'client' => $client
    ];
  }

  public function isUpToDate() {
    $current = $this->getCurrent();
    $latest = $this->getLatest();
    return ($current === $latest and $latest !== 0);
  }
  protected $current;
  public function getCurrent() {
    if ($this->current === null) {
      $folder = $this->container->locations->add('resources')->add('adminer')->build();
      $files = new \DirectoryIterator($folder);
      $current = 0;
      foreach ($files as $file) {
        if ($file->isDir()) {
          continue;
        }
        $version = explode('-', $file->getBasename('.' . $file->getExtension()))[1];
        if ($this->compare($current, $version) < 0) {
          $current = $version;
        }
      }
      $this->current = $current;
    }
    return $this->current;
  }
  protected function compare($a, $b) {
    if ($a === 0 and $b === 0) {
      return 0;
    }
    if ($a === 0) {
      return -1;
    }
    if ($b === 0) {
      return 1;
    }
    list($Ma, $ma, $ra) = explode('.', trim($a, 'v'));
    list($Mb, $mb, $rb) = explode('.', trim($b, 'v'));
    if ($Ma == $Mb) {
      if ($ma == $mb) {
        return $ra - $rb;
      }
      return $ma - $mb;
    }
    return $Ma - $Mb;
  }
  protected $latest;
  public function getLatest() {
    if ($this->latest === null) {
      $url = $this->container->config->get('adminer.latest.tag');
      $res = $this->container->client->request('GET', $url);
      if ($res->getStatusCode() == 200) {
        $data = json_decode($res->getBody());
        $this->latest = $data->tag_name;
        return $this->latest;
      }
      $this->latest = 0;
    }
    return $this->latest;
  }
}
