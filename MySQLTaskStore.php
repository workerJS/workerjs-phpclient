<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

 class MySQLTaskStore {
    private $connection;

    public function __construct($client){
        super($client);

        $connection = parse_url($this->client->getSetting("store")["uri"]);

        $this->connection = mysqli_connect($connection["host"], $connection["user"], $connection["password"], trim($connection["path"], "/"));
    }

    public function getTask($taskID){
        $result = mysqli_query($link, "SELECT `task` FROM `tasks` WHERE `taskID` = ".intval($taskID));

        if(mysqli_num_rows($result) === 0){
            throw new Exception("Task $taskID not found.");
        } else {
            return mysqli_fetch_assoc($result);
        }
    }

    public function setTask($taskID, $task){
        $result = mysqli_query($link, "INSERT INTO `tasks` (`taskID`, `task`) VALUES (".intval($taskID).", '".mysqli_real_escape_string($this->link, json_encode($task->getTask()))."')");
    }
 }
