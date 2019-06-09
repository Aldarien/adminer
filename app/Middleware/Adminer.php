<?php
namespace Adminer\App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Adminer\Adminer as AdminerLoader;

class Adminer {
  protected $container;
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }
  public function __invoke(RequestInterface $request, ResponseInterface $response, $next) {
    (new AdminerLoader(
      $this->container->versionChecker,
      $this->container->urlGetter,
      $this->container->locations,
      $this->container->config
    ))->run();
    return $next($request, $response);
  }
}
