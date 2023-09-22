<?php
namespace Vekas\ResponseManager;
use Psr\Http\Message\ResponseInterface;
use Vekas\ResponseManager\Exceptions\TemplateNotFoundException;
interface IResponseManager {

    /**
     * @throws TemplateNotFoundException
     */
    function getResponse(string $templateId) : ResponseInterface;
}