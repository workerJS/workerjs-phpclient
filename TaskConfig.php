<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:35 AM
 */

namespace App;


class TaskConfig
{
    private static $config = [];

    public static function setOption($name, $value){
        TaskConfig::$config[$name] = $value;
    }

    public static function getOption($name){
        if(isset(TaskConfig::$config[$name])){
            return TaskConfig::$config[$name];
        } else {
            throw new Exception("Option $name is not set. ");
        }
    }
}