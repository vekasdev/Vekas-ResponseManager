<?php

use DI\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Responses\Error404Response;
use SebastianBergmann\Template\Template;
use Tuupola\Http\Factory\ResponseFactory;
use Vekas\ResponseManager\exceptions\TemplateNotFoundException;
use Vekas\ResponseManager\FileLoader;
use Vekas\ResponseManager\ResponseManager;
use Vekas\ResponseManager\ResponseManagerFactory;

class ResponseManagerTest extends TestCase {
    function getResponseManager() {
        $container = new Container();
        $container->set(ResponseFactory::class,new ResponseFactory);
        $fileLoader = new FileLoader(
            "Response",
            realpath(__DIR__."/../responses"),
            "Responses"
        );
        $rmf = new ResponseManagerFactory();
        $rmf->setFileLoader($fileLoader);
        return $rmf->getResponseManager($container);
    }
    function getResponseManagerWithoutLoader(){
        $container = new Container();
        $container->set(ResponseFactory::class,new ResponseFactory);
        $fileLoader = new FileLoader(
            "Response",
            realpath(__DIR__."/../responses"),
            "Responses"
        );
        $rmf = new ResponseManagerFactory();
        return $rmf->getResponseManager($container);
    }
    function testCreateResponseManager(){
        $responseManager = $this->getResponseManager();
        $data = ["name" => "ahmed hassan sadiq"];
        $responseManager->setTemplate("api-presentation-v1",function(ContainerInterface $container){
            $responseFactory = $container->get(ResponseFactory::class);
            return $responseFactory->createResponse(200);
        });
        $response = $responseManager->getResponse("api-presentation-v1");
        $this->assertInstanceOf(ResponseInterface::class,$response);
    }

    function testExpectingNotExistTemplateException(){
        $responseManager = $this->getResponseManager();
        $data = ["name" => "ahmed hassan sadiq"];
        $responseManager->setTemplate("api-presentation-v1",function(ResponseFactory $responseFactory){
            return $responseFactory->createResponse(200);
        });
        $this->expectException(TemplateNotFoundException::class);
        $responseManager->getResponse("not-registered-template",data : $data);
    }

    function testGetResponseOfError404(){
        $rm = $this->getResponseManager();
        $response = $rm->getResponse(Error404Response::class);
        $resBody = $response->getBody()->__toString();
        $this->assertInstanceOf(ResponseInterface::class,$response);
        $this->assertSame("error404",$resBody);
    }

    function testGetTemplateNotFoundException(){
        $rm = $this->getResponseManager();
        $this->expectException(TemplateNotFoundException::class);
        $rm->getResponse("not-registered-template-id");
    }

}