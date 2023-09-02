<?php
namespace Vekas\ResponseManager;


/**
 * scan files & compare with requested & return FQCN By `getClass()` method
 */
class FileLoader implements IClassesLoader {

    function __construct(
        private string $suffix,
        private string $classesDirectory,
        private string $namespace
    ){

    }

    function getClass($className) : string | null{
        $className = $this->extractClassname($className);
        $classes = $this->scanClasses();
        if(array_search($className,$classes) !== false){
            return  ($this->namespace."\\".$className);
        }
        return null;
    }
    function scanClasses() : array {
        $files = [];
        foreach(glob($this->classesDirectory."/*$this->suffix.php") as $class) {
            $class_ = explode("/",$class);
            $fileName = end($class_) ;
            $className = $this->getClassName($fileName);
            array_push($files,$className);
        }
        return $files;
    }
    function getClassName($file){
        preg_match('/^(?<className>[a-zA-Z0-9]+)\.php$/', $file, $arr);
        return $arr["className"] ?? null;
    }

    function extractClassname(string $className) : string{
        $className = explode("\\",$className);
        $className = end($className);
        return $className;
    }
}