<?php
namespace Vekas\ResponseManager;

use Psr\Container\ContainerInterface;
use Tuupola\Http\Factory\ResponseFactory;

class ResponseManagerFactory {
    private IClassesLoader $loader;
    function setFileLoader(IClassesLoader $loader){
        $this->loader = $loader;
    }
    function getResponseManager(ContainerInterface $container){
        return new ResponseManager($container,$this->loader??null);
    }
}