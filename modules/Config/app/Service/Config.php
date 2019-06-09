<?php
namespace Aldarien\App\Service;

use Aldarien\App\Definition\ConfigService as ConfigServiceInterface;

class Config implements ConfigServiceInterface {
  protected $config_folder;
  protected $data;
  protected $loaded;

  public function __construct(string $config_folder) {
    $this->config_folder = realpath($config_folder);
  }
  public function load(): void {
    $files = new \DirectoryIterator($this->config_folder);
    foreach ($files as $file) {
      if (isset($this->loaded[$file])) {
        continue;
      }
      $loader = implode("\\", ['Aldarien', 'FileLoaders', str_replace('YML', 'YAML', strtoupper($file->getExtension()))]);
      if (class_exists($loader)) {
        $loader = new $loader($file);
        $this->addData($loader->getName(), $loader->load());
        $this->loaded []= $file;
      }
    }
  }
  public function get(string $name, $default = null, $current = null, string $full = '') {
    if (strpos($name, '.') === false and $full == '') {
      return $this->data[$name];
    }
    if ($full == '') {
      $full = $name;
      $current = (object) $this->data;
    }
    if (strpos($name, '.') === false) {
      if (isset($current->$name)) {
        return $current->$name;
      }
      return $default;
    }
    $info = explode('.', $name);
    $p = array_shift($info);
    $name = implode('.', $info);
    if (!isset($current->$p)) {
      return $default;
    }
    return $this->get($name, $default, $current->$p, $full);
  }
  protected function addData(string $name, object $data) {
    if (isset($this->data[$name])) {
      $this->data[$name] = (object) array_merge((array) $this->data, (array) $data);
      return;
    }
    $this->data[$name] = $data;
  }
}
