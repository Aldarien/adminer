<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Aldarien\App\Service\UrlGetter;

class UrlGetterTest extends TestCase {
  public function testCreate() {
    $response = $this->getMockBuilder(ResponseInterface::class)
      ->setMethods(['getStatusCode', 'getBody'])
      ->getMock();
    $response->method('getStatusCode')
      ->will($this->returnValue(200));
    $response->method('getBody')
      ->will($this->returnValue('<?php "adminer"; ?>'));
    $client = $this->getMockBuilder(Client::class)
      ->setMethods(['request'])
      ->getMock();
    $client->method('request')
      ->will($this->returnValue($response));
    $getter = new UrlGetter($client);
    $this->assertTrue(true);
    return $getter;
  }
  /**
   * @depends testCreate
   */
  public function testGet(UrlGetter $getter) {
    $expected = '<?php "adminer"; ?>';
    $result = $getter->get('http://adminer');
    $this->assertEquals($expected, $result);
  }
}
