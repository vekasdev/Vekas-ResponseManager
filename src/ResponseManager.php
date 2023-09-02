<?php
namespace Vekas\ResponseManager;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Tuupola\Http\Factory\ResponseFactory;
use Vekas\ResponseManager\exceptions\TemplateNotFoundException as TemplateNotFoundException;
use Vekas\ResponseManager\IResponseManager;

class ResponseManager implements IResponseManager,ILoadableResponseManager{
    protected array $data = [];
    protected array $templates=[];
    function __construct(
        private ContainerInterface $container,
        private FileLoader | null $fileLoader = null
        )
    {}
    function setData(array $data){
        $this->data = $data;
    }

    function getData() : array{
        return $this->data;
    }
    
    function setTemplate($id,callable | ResponseInterface $template){
        array_push($this->templates,[$id,$template]);
    }

    /**
     * @inheritDoc
     */
    function getResponse($templateId) : ResponseInterface{
        $template = $this->getTemplate($templateId);
        if ( $template !== false ) {
            $handler = $template[1];
            if($handler instanceof IResponseEntry ) {
                return $handler($this->getData());
            }
        }
        return $handler($this->container,$this->getData());
    }

    private function getTemplate($templateId) : array{
        /**
         * @var array $template
         */
        foreach($this->templates as $template) {
            if(array_search($templateId,$template)!== false) {
                $_template = $template;
            }
        }
        if( ( !isset($_template)) ) {
                if ($this->fileLoader) {
                // load from files
                $fqcn = $this->fileLoader->getClass($templateId);
                if(!$fqcn) {
                    throw new  TemplateNotFoundException(`template : $templateId not found`);
                }
                $responseHandler = new ($fqcn)($this->container);
                $this->setTemplate($templateId,$responseHandler);
                $_template = $this->getTemplate($templateId);
            } else throw new  TemplateNotFoundException(`template : $templateId not found`);
        } 
        return $_template;
    }
}