<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

 namespace WorkerJS\PHPClient;

 class MySQLTaskStore extends TaskStore {
    private $connection;

    public function __construct($client){
        parent::__construct($client);

        $connection = parse_url($this->client->getSetting("store")["uri"]);

        $this->connection = mysqli_connect($connection["host"], $connection["user"], $connection["pass"], trim($connection["path"], "/"));
    }

    public function getTask($taskID){
        $result = mysqli_query($this->connection, "SELECT `task` FROM `tasks` WHERE `taskID` = ".intval($taskID));

        if(mysqli_num_rows($result) === 0){
            throw new \Exception("Task $taskID not found.");
        } else {
            return mysqli_fetch_assoc($result);
        }
    }

    public function setTask($taskID, Task $task){
        mysqli_query($this->connection, "INSERT INTO `tasks` (`taskID`, `task`) VALUES (".intval($taskID).", '".mysqli_real_escape_string($this->connection, json_encode($task->getTask()))."')");
    }
 }
