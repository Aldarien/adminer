<?php
namespace Aldarien\App\Factory;

use Aldarien\App\Definition\PathFactory as PathFactoryInterface;

class Path implements PathFactoryInterface {
  protected $base_path;
  protected $paths;

  public function __construct(string $base_path) {
    $this->base_path = realpath($base_path);
  }
  public function getBase(): string {
    return $this->base_path;
  }
  public function add(string $relative_path): PathFactoryInterface {
    $this->paths []= $relative_path;
    return $this;
  }
  public function build(): string {
    $path = realpath(implode(DIRECTORY_SEPARATOR,
      array_merge([$this->base_path], $this->paths)
    ));
    $this->reset();
    return $path;
  }
  protected function reset() {
    $this->paths = [];
  }
}
