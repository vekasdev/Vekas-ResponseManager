<?php
namespace Responses;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tuupola\Http\Factory\ResponseFactory;
use Vekas\ResponseManager\AbstractResponseEntry;

class Error404Response extends AbstractResponseEntry{
    function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    function __invoke() : ResponseInterface{
        /**
         * @var ResponseFactory
         */
        $rf = $this->container->get(ResponseFactory::class);
        $res = $rf->createResponse(200);
        $res->getBody()->write("error404");
        return $res;
    }
}