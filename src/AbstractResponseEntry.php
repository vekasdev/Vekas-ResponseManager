<?php

namespace Vekas\ResponseManager;

use Psr\Container\ContainerInterface;

abstract class AbstractResponseEntry implements IResponseEntry {
    protected ContainerInterface $container;
    function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
}