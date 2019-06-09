<?php
use GuzzleHttp\Psr7\LazyOpenStream;

include_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'bootstrap', 'public.php']);

$app->map(['GET', 'POST'], '/', function($req, $res, $args) {
  include_once 'adminer.php';
});
$app->run();
