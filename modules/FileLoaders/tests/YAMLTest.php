<?php
use PHPUnit\Framework\TestCase;
use Aldarien\FileLoaders\YAML;

class YAMLTest extends TestCase {
  public function testCreate() {
    $filename = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'tests', 'data', 'test.yml']);
    $file = new \SplFileInfo($filename);
    $loader = new YAML($file);
    $this->assertTrue(true);
    return $loader;
  }
  /**
   * @depends testCreate
   */
  public function testGetName(YAML $loader) {
    $expected = 'test';
    $result = $loader->getName();
    $this->assertEquals($expected, $result);
  }
  /**
   * @depends testCreate
   */
  public function testLoad(YAML $loader) {
    $expected = (object) [
      'hello' => 'world',
      'test' => (object) [
        'hi' => (object) [
          'one',
          'two'
        ]
      ]
    ];
    $result = $loader->load();
    $this->assertEquals($expected, $result);
  }
}
