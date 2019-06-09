<?php
namespace Adminer;

use Adminer\App\Service\VersionChecker;
use Aldarien\App\Definition\UrlGetterService as UrlGetterInterface;
use Aldarien\App\Definition\PathFactory as PathInterface;
use Aldarien\App\Definition\ConfigService as ConfigInterface;

class Adminer {
  protected $checker;
  protected $getter;
  protected $config;
  public function __construct(VersionChecker $checker, UrlGetterInterface $getter, PathInterface $path, ConfigInterface $config) {
    $this->checker = $checker;
    $this->getter = $getter;
    $this->locations = $path;
    $this->config = $config;
  }
  public function run() {
    if (!$this->checker->isUpToDate()) {
      $version = $this->checker->getLatest();
      $url = $this->config->get('adminer.latest.url');
      $data = $this->getter->get($url);
      $adminer = $this->locations->add('resources')->add('adminer')->build();
      $public = $this->locations->add('public')->build();

      $filename = implode(DIRECTORY_SEPARATOR, [$adminer, 'adminer-' . $version . '.php']);
      \file_put_contents($filename, $data);
      $filename = implode(DIRECTORY_SEPARATOR, [$public, 'adminer.php']);
      \file_put_contents($filename, $data);

      $url = implode('/', [
        $this->config->get('adminer.styles.url'),
        $this->config->get('adminer.style.name')
      ]);
      $data = $this->getter->get($url);
      $filename = implode(DIRECTORY_SEPARATOR, [$adminer, 'adminer-' . $version . '.css']);
      \file_put_contents($filename, $data);
      $filename = implode(DIRECTORY_SEPARATOR, [$public, 'adminer.css']);
      \file_put_contents($filename, $data);
    }
  }
}
