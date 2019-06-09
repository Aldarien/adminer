<?php
namespace Aldarien\FileLoaders;

use \Spyc;
use Aldarien\App\Alias\FileLoader;

class YAML extends FileLoader {
  public function load(): object {
    return $this->arrayToObject(Spyc::YAMLLoad($this->file->getRealPath()));
  }
}
