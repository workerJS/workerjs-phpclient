<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

 namespace WorkerJS\PHPClient;

 class PostgresTaskStore extends TaskStore {
    private $connection;

    public function __construct($client){
        parent::__construct($client);

        $this->connection = pg_connect($this->client->getSetting("store")["uri"]);
    }

    public function getTask($taskID){
        $result = pg_query($this->connection, "SELECT task FROM tasks WHERE taskID = ".intval($taskID));

        if(pg_num_rows($result) === 0){
            throw new Exception("Task $taskID not found.");
        } else {
            return pg_fetch_assoc($result);
        }
    }

    public function setTask($taskID, Task $task){
        pg_query($this->connection, "INSERT INTO tasks (taskID, task) VALUES (".intval($taskID).", '".pg_escape_string($this->connection, json_encode($task->getTask()))."')");
    }
 }
