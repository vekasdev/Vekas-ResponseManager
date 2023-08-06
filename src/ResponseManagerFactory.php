<?php
namespace Vekas\ResponseManager;

use Tuupola\Http\Factory\ResponseFactory;

class ResponseManagerFactory {
    function getResponseManager(){
        return new ResponseManager(new ResponseFactory);
    }
}