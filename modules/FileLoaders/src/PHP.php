<?php
namespace Aldarien\FileLoaders;

use Aldarien\App\Alias\FileLoader;

class PHP extends FileLoader {
  public function load(): object {
    return $this->arrayToObject(include($this->file->getRealPath()));
  }
}
