<?php
namespace Aldarien\FileLoaders;

use Aldarien\App\Alias\FileLoader;

class JSON extends FileLoader {
  public function load(): object {
    return $this->arrayToObject(
      \json_decode(
        \trim(
          \file_get_contents($this->file->getRealPath())
        )
      )
    );
  }
}
