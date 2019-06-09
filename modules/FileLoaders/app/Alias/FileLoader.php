<?php
namespace Aldarien\App\Alias;

use Aldarien\App\Definition\FileLoader as FileLoaderInterface;

abstract class FileLoader implements FileLoaderInterface {
  protected $file;
  public function __construct(\SplFileInfo $file) {
    $this->file = $file;
  }
  public function getName(): string {
    return $this->file->getBasename('.' . $this->file->getExtension());
  }
  protected function arrayToObject($arr) {
    $new_arr = [];
    foreach ($arr as $key => $val) {
      if (is_array($val) or is_object($val)) {
        $new_arr[$key] = $this->arrayToObject($val);
        continue;
      }
      $new_arr[$key] = $val;
    }
    return (object) $new_arr;
  }
}
