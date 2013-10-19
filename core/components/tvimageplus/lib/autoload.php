<?php
spl_autoload_register(function ($classname) {
        if(substr($classname,0,10)!='ImagePlus\\')
            return;
        $classname = ltrim($classname, "\\");
        preg_match('/^(.+)?([^\\\\]+)$/U', $classname, $match);
        $classname = dirname(__FILE__).'/'.str_replace("\\", "/", $match[1])
            . str_replace(array("\\", "_"), "/", $match[2])
            . ".php";
        include_once $classname;
    });