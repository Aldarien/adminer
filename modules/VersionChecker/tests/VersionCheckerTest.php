<?php
use GuzzleHttp\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Aldarien\App\Service\Config as ConfigService;
use Aldarien\App\Factory\Path as PathFactory;
use Adminer\App\Service\VersionChecker;

class VersionCheckerTest extends TestCase {
  public function setUp(): void {
    mkdir('resources');
    mkdir('resources/adminer');
  }
  public function tearDown(): void {
    rmdir('resources/adminer');
    rmdir('resources');
  }
  public function testCreate() {
    $config_folder = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'tests', 'data']);
    $config = new ConfigService($config_folder);
    $config->load();
    $base_path = dirname(__DIR__);
    $path_factory = new PathFactory($base_path);
    $response = $this->getMockBuilder(ResponseInterface::class)
      ->setMethods(['getStatusCode', 'getBody'])
      ->getMock();
    $response->method('getStatusCode')
      ->will($this->returnValue(200));
    $response->method('getBody')
      ->will($this->returnValue('{"tag_name": "v1.0.0"}'));
    $client = $this->getMockBuilder(Client::class)
      ->setMethods(['request'])
      ->getMock();
    $client->method('request')
      ->will($this->returnValue($response));
    $checker = new VersionChecker($path_factory, $config, $client);
    $this->assertTrue(true);
    return $checker;
  }
  /**
   * @depends testCreate
   */
  public function testGetLatest(VersionChecker $checker) {
    $expected = "v1.0.0";
    $result = $checker->getLatest();
    $this->assertEquals($expected, $result);
    return $checker;
  }
  /**
   * @depends testGetLatest
   */
  public function testGetCurrent(VersionChecker $checker) {
    $expected = 0;
    $result = $checker->getCurrent();
    $this->assertEquals($expected, $result);
    return $checker;
  }
  /**
   * @depends testGetCurrent
   */
  public function testCheck(VersionChecker $checker) {
    $expected = false;
    $result = $checker->check();
    $this->assertEquals($expected, $result);
  }
}
