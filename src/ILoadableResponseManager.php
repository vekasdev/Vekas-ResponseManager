<?php
namespace  Vekas\ResponseManager;
use Psr\Http\Message\ResponseInterface;

interface ILoadableResponseManager{
    function setTemplate($id,callable | ResponseInterface $template);
}