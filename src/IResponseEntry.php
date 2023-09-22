<?php
namespace Vekas\ResponseManager;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
interface IResponseEntry {
    function __construct(ContainerInterface $container);
    function __invoke($data): ResponseInterface;

}