<?php
use PHPUnit\Framework\TestCase;
use Aldarien\App\Factory\Path;

class PathTest extends TestCase {
  public function testCreate() {
    $base = dirname(__DIR__);
    $path = new Path($base);
    $this->assertTrue(true);
    return $path;
  }
  /**
   * @depends testCreate
   */
  public function testGetBase(Path $path) {
    $expected = dirname(__DIR__);
    $result = $path->getBase();
    $this->assertSame($expected, $result);
  }
  /**
   * @depends testCreate
   */
  public function testAddBuild(Path $path) {
    $path = $path->add('tests');
    $expected = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'tests']);
    $result = $path->build();
    $this->assertEquals($expected, $result);
  }
}
