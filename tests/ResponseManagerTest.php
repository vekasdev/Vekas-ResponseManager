<?php
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use SebastianBergmann\Template\Template;
use Tuupola\Http\Factory\ResponseFactory;
use Vekas\ResponseManager\exceptions\TemplateNotFoundException;
use Vekas\ResponseManager\ResponseManager;

class ResponseManagerTest extends TestCase {
    function testCreateResponseManager(){
        $responseManager = new ResponseManager(new ResponseFactory());
        $responseManager->setData(["name" => "ahmed hassan sadiq"]);
        $responseManager->setTemplate("api-presentation-v1",function(ResponseFactory $responseFactory){
            return $responseFactory->createResponse(200);
        });
        $response = $responseManager->getResponse("api-presentation-v1");
        $this->assertInstanceOf(ResponseInterface::class,$response);
    }

    function testExpectingNotExistTemplateException(){
        $responseManager = new ResponseManager(new ResponseFactory());
        $responseManager->setData(["name" => "ahmed hassan sadiq"]);
        $responseManager->setTemplate("api-presentation-v1",function(ResponseFactory $responseFactory){
            return $responseFactory->createResponse(200);
        });
        $this->expectException(TemplateNotFoundException::class);
        $responseManager->getResponse("not-registered-template");
    }
}