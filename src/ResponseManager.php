<?php
namespace Vekas\ResponseManager;
use Psr\Http\Message\ResponseInterface;
use Tuupola\Http\Factory\ResponseFactory;
use Vekas\ResponseManager\Exceptions\TemplateNotFoundException as TemplateNotFoundException;
use Vekas\ResponseManager\IResponseManager;

class ResponseManager implements IResponseManager{
    private array $data;
    private array $templates=[];
    function __construct(
        private ResponseFactory $responseFactory)
    {}
    function setData(array $data){
        $this->data = $data;
    }

    function getData() : array{
        return $this->data;
    }
    
    /**
     * @inheritDoc
     */
    function setTemplate($id,callable $template){
        array_push($this->templates,[$id,$template]);
    }

    /**
     * @inheritDoc
     */
    function getResponse($templateId) : ResponseInterface{
        /**
         * @var array $template
         */
        foreach($this->templates as $template) {
            if(array_search($templateId,$template)!== false) {
                $_template = $template;
            }
        }
        if(!isset($_template)) throw new  TemplateNotFoundException(`the template $templateId not found`);
        $handler = $_template[1];
        return $handler($this->responseFactory,$this->getData());
    }
}