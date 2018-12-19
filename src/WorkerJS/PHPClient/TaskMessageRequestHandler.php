<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:58 AM
 */

namespace WorkerJS\PHPClient;

class TaskMessageRequestHandler{
    private $client;

    public function __construct(Client $client){
        $this->client = $client;
    }

    public function handleRequest(string $body){
        $body = json_decode($body);
        //TODO: Check protocol

        $taskID = $body->taskID;

        $taskStore = $this->client->getTaskStore();

        $task = $taskStore->getTask($taskID);
        $task["taskID"] = $taskID;

        $task = $this->client->newTask($task);

        $handlerName = $body->name;

        try {
            $this->client->getTaskMessageRouter()->call($handlerName, $task, $body);
        } catch(Exception $e){
            //TODO: Log unimplemented handler
        }
    }
}
