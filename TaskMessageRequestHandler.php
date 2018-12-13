<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:58 AM
 */

namespace App;


class TaskRequestHandler
{
    public static function handleRequest(string $body){
        $body = json_decode($body, true);

        //TODO: Check protocol

        $taskID = $body->taskID;

        $taskStoreClass = TaskConfig::getOption("taskStoreClass");
        $taskStore = new $taskStoreClass();

        $task = $taskStore->getTask($taskID);

        $taskClass = TaskConfig::getOption("taskClass");
        $task = new $taskClass($task);

        $handlerName = $task->getHandlerName();

        try {
            TaskMessageRouter::call($handlerName, $task, $params);
        } catch(Exception $e){
            //TODO: Log unimplemented handler
        }
    }
}
