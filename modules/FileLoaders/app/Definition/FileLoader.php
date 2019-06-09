<?php
namespace Aldarien\App\Definition;

interface FileLoader {
  public function __construct(\SplFileInfo $file);
  public function load(): object;
  public function getName(): string;
}
