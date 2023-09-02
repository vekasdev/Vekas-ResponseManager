<?php


namespace Vekas\ResponseManager ;
interface IClassesLoader {
    /**
     * @param string $className it can be fqcn or only className
     * @return string | null the fqcn if it is exists or null if not
     */
    function getClass($className) : string | null;
}