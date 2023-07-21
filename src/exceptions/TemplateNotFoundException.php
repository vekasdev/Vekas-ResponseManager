<?php
namespace Vekas\ResponseManager\Exceptions;
class TemplateNotFoundException extends \Exception {
    protected $message = "the template required is not found";
}