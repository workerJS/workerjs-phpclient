<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:27 AM
 */

namespace App;


abstract class TaskStore
{
    public function __construct(){
        //TODO: Setup connection
    }

    public function setTask($taskID, Task $task){
        $task->getTask();

        //TODO: Write to DB
    }

    public function getTask($taskID){
        $task = null;
        //TODO: Read from DB
        //TODO: Return task
        return $task;
    }
}
