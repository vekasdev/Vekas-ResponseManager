<?php
use DI\Container;
use PHPUnit\Framework\TestCase;
use Responses\Error404Response;
use Vekas\ResponseManager\FileLoader;
use Vekas\ResponseManager\IResponseEntry;

class FileLoaderTest extends TestCase {

    function testScanClasses(){
        $fl = new FileLoader("Response",realpath(__DIR__."/../responses/"),"Responses");
        $classes = $fl->scanClasses();
        $this->assertIsArray($classes);
    }
    function testGetError404Response(){
        $container = new Container;
        $fl = new FileLoader("Response",realpath(__DIR__."/../responses/"),"Responses");
        $class = new ($fl->getClass("Error404Response"))($container);
        $this->assertInstanceOf(IResponseEntry::class,$class);
    }

    function testInstantiateFileLoader(){
        $fl = new FileLoader("Response",realpath(__DIR__."/../responses/"),"Responses");
        $this->assertInstanceOf(FileLoader::class,$fl);
    }
}