<?php
namespace Aldarien\App\Definition;

interface ConfigService {
  public function __construct(string $config_folder);
  public function load(): void;
  public function get(string $name, $default = null, $current = null, string $full = '');
}
