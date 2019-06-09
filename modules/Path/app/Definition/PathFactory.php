<?php
namespace Aldarien\App\Definition;

interface PathFactory {
  public function __construct(string $base_path);
  public function getBase(): string;
  public function add(string $relative_path): PathFactory;
  public function build(): string;
}
