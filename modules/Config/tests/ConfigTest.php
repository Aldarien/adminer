<?php
use PHPUnit\Framework\TestCase;
use Aldarien\App\Service\Config;

class ConfigTest extends TestCase {
  public function testCreate() {
    $config_folder = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'tests', 'data']);
    $config = new Config($config_folder);
    $this->assertTrue(true);
    $config->load();
    $this->assertTrue(true);
    return $config;
  }
  /**
   * @depends testCreate
   */
  public function testGet(Config $config) {
    $expected = 'Config';
    $result = $config->get('app.name');
    $this->assertEquals($expected, $result);
    $expected = 'test';
    $result = $config->get('not.exists', 'test');
    $this->assertEquals($expected, $result);
  }
}
