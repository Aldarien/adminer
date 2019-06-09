<?php
use PHPUnit\Framework\TestCase;
use Aldarien\FileLoaders\JSON;

class JSONTest extends TestCase {
  public function testCreate() {
    $filename = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'tests', 'data', 'test.json']);
    $file = new \SplFileInfo($filename);
    $loader = new JSON($file);
    $this->assertTrue(true);
    return $loader;
  }
  /**
   * @depends testCreate
   */
  public function testGetName(JSON $loader) {
    $expected = 'test';
    $result = $loader->getName();
    $this->assertEquals($expected, $result);
  }
  /**
   * @depends testCreate
   */
  public function testLoad(JSON $loader) {
    $expected = (object) ['hello' => 'world'];
    $result = $loader->load();
    $this->assertEquals($expected, $result);
  }
}
