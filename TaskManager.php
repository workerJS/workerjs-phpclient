<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:37 AM
 */

namespace App;


class TaskManager
{
    private static $taskManager;
    private static $webHookHandler;

    public static function getTaskManager()
    {
        if(!self::$taskManager) {
            self::$taskManager = new TaskManager();

            return self::$taskManager;
        } else {
            return self::$taskManager;
        }
    }

    public static function subscribe($name, TaskMessageHandler $handler)
    {
        $taskManager = TaskManager::getTaskManager();
        $taskManager->handlers[$name] = $handler;
    }

    public static function call($name, $task, $params){
        $taskManager = TaskManager::getTaskManager();

        $handler = $taskManager->getHandlerByName($name);
        $handler->handle($task, $params);
    }

    private static function getHandlerByName($name)
    {
        $taskManager = TaskManager::getTaskManager();

        if(isset($taskManager->handlers[$name])) {
            return $taskManager->handlers[$name];
        } else {
            throw Exception("Handler for $name is not registered. ");
        }
    }

    private $handlers = [];

    private function __construct()
    {
    }
}
