<?php
use PHPUnit\Framework\TestCase;
use Aldarien\FileLoaders\PHP;

class PHPTest extends TestCase {
  public function testCreate() {
    $filename = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'tests', 'data', 'test.php']);
    $file = new \SplFileInfo($filename);
    $loader = new PHP($file);
    $this->assertTrue(true);
    return $loader;
  }
  /**
   * @depends testCreate
   */
  public function testGetName(PHP $loader) {
    $expected = 'test';
    $result = $loader->getName();
    $this->assertEquals($expected, $result);
  }
  /**
   * @depends testCreate
   */
  public function testLoad(PHP $loader) {
    $expected = (object) ['hello' => 'world'];
    $result = $loader->load();
    $this->assertEquals($expected, $result);
  }
}
