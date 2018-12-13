<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:58 AM
 */

namespace App;


class TaskRequestHandler{
    private $client;

    public function __construct($client){
        $this->client = $client;
    }

    public static function handleRequest(string $body){
        $body = json_decode($body, true);

        //TODO: Check protocol

        $taskID = $body->taskID;

        $taskStoreClass = $this->client->getSetting("taskStoreClass");
        $taskStore = new $taskStoreClass();

        $task = $taskStore->getTask($taskID);

        $task = $this->client->newTask($task);

        $handlerName = $task->getHandlerName();

        try {
            $this->client->getTaskMessageRouter()->call($handlerName, $task, $params);
        } catch(Exception $e){
            //TODO: Log unimplemented handler
        }
    }
}
