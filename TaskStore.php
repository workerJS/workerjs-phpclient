<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:27 AM
 */

namespace App;


abstract class TaskStore{
    private $client;

    public function __construct($client){
        $this->client = $client;
    }

    abstract public function setTask($taskID, Task $task);
    abstract public function getTask($taskID);
}

