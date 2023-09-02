<?php

foreach(glob(__DIR__."/src/*.php") as $class) {
    // echo $class;
    $class_ = explode("/",$class);
    $fileName = end($class_) ;
    $className = getClassName($fileName);
    echo $className."\n";
}
function getClassName($file){
    preg_match('/^(?<className>[a-zA-Z]+)\.php$/', $file, $arr);
    return $arr["className"] ?? null;
}