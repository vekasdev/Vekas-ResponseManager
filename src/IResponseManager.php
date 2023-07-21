<?php
namespace Vekas\ResponseManager;
use Psr\Http\Message\ResponseInterface;
use Vekas\ResponseManager\exeptions\TemplateNotFound;
interface IResponseManager {
    function setData(array $data);
    /**
     * @param callable $template closure `must return ResponseInterface`
     */
    function setTemplate($id,callable $template);

    /**
     * @throws TemplateNotFound
     */
    function getResponse($templateId) : ResponseInterface;
}