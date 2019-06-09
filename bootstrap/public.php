<?php
require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

use Slim\App;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;
use GuzzleHttp\Client;
use Aldarien\App\Factory\Path as PathFactory;
use Aldarien\App\Service\Config as ConfigService;
use Aldarien\App\Service\UrlGetter;
use Adminer\App\Service\VersionChecker;
use Adminer\App\Middleware\Adminer;

$root = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
$path_factory = new PathFactory($root);
$config = [
  'settings' => [
    'debug' => true,
    'displayErrorDetails' => true
  ],
  'locations' => function($container) use ($root) {
    return new PathFactory($root);
  },
  'config' => function($container) use ($path_factory) {
    $folder = $path_factory->add('config')->build();
    $config = new ConfigService($folder);
    $config->load();
    return $config;
  },
  'client' => function($container) {
    return new Client();
  }
];

$app = new App($config);

$container = $app->getContainer();

$container['versionChecker'] = function($container) {
  return new VersionChecker($container->locations, $container->config, $container->client);
};
$container['urlGetter'] = function($container) {
  return new UrlGetter($container->client);
};

$app->add(new WhoopsMiddleware($app));
$app->add(new Adminer($container));
